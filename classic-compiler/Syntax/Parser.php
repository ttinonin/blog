<?php

namespace Compiler\Syntax;

use Compiler\Utils\Tree\Node;
use Compiler\Utils\Tree\Tree;
use Compiler\Utils\Token;
use Utils\Flags;

class Parser {
    use ForeachMatch;
    use ComponentMatch;
    use IfMatch;
    use AuthMatch;
    use VariableMatch;
    use HtmlMatch;

    private $tokens = [];
    private Token $token;
    private Node $root_parser;
    private Node $root_parserT;
    private $file_name = "";
    private $errors = [];

    private Flags $flags;

    public function __construct($tokens, $file_name, $flags) {
        $this->tokens = $tokens;
        $this->token = $this->tokens[0];

        $this->file_name = $file_name;
        $this->root_parser = new Node("root");
        $this->root_parserT = new Node("root");

        $this->flags = $flags;
    }

    private function error($rule) {
        echo "\nRule: " . $rule;
        echo "\nInvalid Token: " . $this->token;

        exit;
    }

    public function next_token() {
        if(count($this->tokens) > 0) {
            return array_shift($this->tokens);
        }

        return null;
    }

    public function peek_token() {
        if(count($this->tokens) >= 1) {
            return $this->tokens[0];
        }

        return null;
    }

    private function show_tree(Node $node) {
        $tree = new Tree($node);
        echo "\nCode:\n";
        $tree->print_code();
        echo "\n";
        $tree->print_tree();
    }

    public function main() {
        global $argv;

        $this->token = $this->next_token();
        
        if($this->code($this->root_parser, $this->root_parserT)) {
            if($this->token->type === "EOF") {
                if($this->flags->get("tree")) {
                    $this->show_tree($this->root_parserT);
                }

                return $this->generate_code($this->root_parserT);
            }
        }
    }

    public function generate_code(Node $node) {
        $tree = new Tree($node);

        $code = $tree->get_code();

        return $code;
    }

    private function code(Node $node, Node $nodeT) {
        $code = $node->add_new_node_name("code");
        $codeT = $nodeT->add_new_node_name("code");

        // foreach
        if($this->matchLSecond("foreach", $code, $codeT, null, false) && $this->foreach($code, $codeT) && $this->code($code, $codeT)) {
            return true;
        }
        // endforeach
        elseif($this->matchLSecond("/", $code, $codeT, null, false) && $this->matchLThird("foreach", $code, $codeT, null, false) && $this->endforeach($code, $codeT) && $this->code($code, $codeT)) {
            return true;
        }
        // component
        elseif($this->matchLSecond("component", $code, $codeT, null, false) && $this->component($code, $codeT) && $this->code($code, $codeT)) {
            return true;
        }
        // if
        elseif($this->matchLSecond("if", $code, $codeT, null, false) && $this->if($code, $codeT) && $this->code($code, $codeT)) {
            return true;
        }
        // else
        elseif($this->matchLSecond("else", $code, $codeT, null, false) && $this->else($code, $codeT) && $this->code($code, $codeT)) {
            return true;
        }
        // endif
        elseif($this->matchLSecond("/", $code, $codeT, null, false) && $this->matchLThird("if", $code, $codeT, null, false) && $this->endif($code, $codeT) && $this->code($code, $codeT)) {
            return true;
        }
        // auth
        elseif($this->matchLSecond("auth", $code, $codeT, null, false) && $this->auth($code, $codeT) && $this->code($code, $codeT)) {
            return true;
        }
        // endauth
        elseif($this->matchLSecond("/", $code, $codeT, null, false) && $this->matchLThird("auth", $code, $codeT, null, false) && $this->endauth($code, $codeT) && $this->code($code, $codeT)) {
            return true;
        }
        // variable
        elseif($this->matchTSecond("TAG_VAR", $code, $codeT, null, false) && $this->variable($code, $codeT) && $this->code($code, $codeT)) {
            return true;
        }
        // html
        elseif($this->matchTSecond("TAG_HTML", $code, $codeT, null, false) && $this->html($code, $codeT) && $this->code($code, $codeT)) {
            return true;
        }
        // endhtml
        elseif($this->matchLSecond("/", $code, $codeT, null, false) && $this->matchTThird("TAG_HTML", $code, $codeT, null, false) && $this->endhtml($code, $codeT) && $this->code($code, $codeT)) {
            return true;
        }
        // text
        elseif($this->matchT("TEXT", $code, $codeT, null, false) && $this->text($code, $codeT) && $this->code($code, $codeT)) {
            return true;
        }
        else {
            $code->add_new_node_name("");
            $codeT->add_new_node_name("");
            return true;
        }
    }

    private function matchTThird(string $type, Node $node = null, Node $nodeT = null, string $new_code = null, $next = true) {
        if($this->peek_peek_token()->type === $type && $next) {
            if($new_code === null) {
                $node->add_new_node_name($this->token->lexeme);
                
                if($nodeT !== null) {
                    $nodeT->add_new_node_name($this->token->lexeme);
                }
            } else {
                $node->add_new_node_name($this->token->lexeme);
                $nodeT->add_new_node_name($new_code);
            }

            $this->token = $this->next_token();
            return true;
        } elseif($this->peek_peek_token()->type === $type) {
            return true;
        } elseif($next === false && $this->peek_peek_token()->type === $type) {
            return true;
        } elseif($next === false && $this->peek_peek_token()->type !== $type) {
            return false;
        }

        return false;
    }

    private function matchTSecond(string $type, Node $node = null, Node $nodeT = null, string $new_code = null, $next = true) {
        if($this->peek_token()->type === $type && $next) {
            if($new_code === null) {
                $node->add_new_node_name($this->token->lexeme);
                
                if($nodeT !== null) {
                    $nodeT->add_new_node_name($this->token->lexeme);
                }
            } else {
                $node->add_new_node_name($this->token->lexeme);
                $nodeT->add_new_node_name($new_code);
            }

            $this->token = $this->next_token();
            return true;
        } elseif($this->peek_token()->type === $type) {
            return true;
        } elseif($next === false && $this->peek_token()->type === $type) {
            return true;
        } elseif($next === false && $this->peek_token()->type !== $type) {
            return false;
        }

        return false;
    }

    private function matchT(string $type, Node $node = null, Node $nodeT = null, string $new_code = null, $next = true) {
        if($this->token->type === $type && $next) {
            if($new_code === null) {
                $node->add_new_node_name($this->token->lexeme);
                
                if($nodeT !== null) {
                    $nodeT->add_new_node_name($this->token->lexeme);
                }
            } else {
                $node->add_new_node_name($this->token->lexeme);
                $nodeT->add_new_node_name($new_code);
            }

            $this->token = $this->next_token();
            return true;
        } elseif($this->token->type === $type) {
            return true;
        } elseif($next === false && $this->token->type === $type) {
            return true;
        } elseif($next === false && $this->token->type !== $type) {
            return false;
        }

        return false;
    }

    private function matchLSecond(string $lexeme, Node $node = null, Node $nodeT = null, string $new_code = null, $next = true) {
        if($this->peek_token()->lexeme === $lexeme && $next) {
            if($new_code === null) {
                $node->add_new_node_name($this->token->lexeme);
                
                if($nodeT !== null) {
                    $nodeT->add_new_node_name($this->token->lexeme);
                }
            } else {
                $node->add_new_node_name($this->token->lexeme);
                $nodeT->add_new_node_name($new_code);
            }

            $this->token = $this->next_token();
            return true;
        } elseif($this->peek_token()->lexeme === $lexeme) {
            return true;
        } elseif($next === false) {
            return false;
        }

        return false;
    }

    public function peek_peek_token() {
        if(count($this->tokens) >= 2) {
            return $this->tokens[1];
        }

        return null;
    }

    private function matchLThird(string $lexeme, Node $node = null, Node $nodeT = null, string $new_code = null, $next = true) {
        if($this->peek_peek_token()->lexeme === $lexeme && $next) {
            if($new_code === null) {
                $node->add_new_node_name($this->token->lexeme);
                
                if($nodeT !== null) {
                    $nodeT->add_new_node_name($this->token->lexeme);
                }
            } else {
                $node->add_new_node_name($this->token->lexeme);
                $nodeT->add_new_node_name($new_code);
            }

            $this->token = $this->next_token();
            return true;
        } elseif($this->peek_peek_token()->lexeme === $lexeme) {
            return true;
        } elseif($next === false) {
            return false;
        }

        return false;
    }

    private function matchL(string $lexeme, Node $node = null, Node $nodeT = null, string $new_code = null, $next = true) {
        if($this->token->lexeme === $lexeme && $next) {
            if($new_code === null) {
                $node->add_new_node_name($this->token->lexeme);
                
                if($nodeT !== null) {
                    $nodeT->add_new_node_name($this->token->lexeme);
                }
            } else {
                $node->add_new_node_name($this->token->lexeme);
                $nodeT->add_new_node_name($new_code);
            }

            $this->token = $this->next_token();
            return true;
        } elseif($this->token->lexeme === $lexeme) {
            return true;
        } elseif($next === false) {
            return false;
        }

        return false;
    }

    private function tag_prop(Node $node, Node $nodeT) {
        $tag_prop = $node->add_new_node_name("tag_prop");
        $tag_propT = $nodeT->add_new_node_name("tag_prop");

        if($this->matchT("TAG_PROP", $tag_prop, $tag_propT)) {
            return true;
        }

        return false;
    }

    private function tag_value(Node $node, Node $nodeT) {
        $tag_value = $node->add_new_node_name("tag_value");
        $tag_valueT = $nodeT->add_new_node_name("tag_value");

        if($this->matchT("TAG_VALUE", $tag_value, $tag_valueT)) {
            return true;
        }

        return false;
    }

    private function tag_attribute(Node $node, Node $nodeT) {
        $atribute = $node->add_new_node_name("attribute");
        $atributeT = $nodeT->add_new_node_name("attribute");

        if($this->tag_prop($atribute, $atributeT) && $this->matchL("=", $atribute, $atributeT) && $this->tag_value($atribute, $atributeT)) {
            return true;
        }

        return false;
    }

    private function open_tag(Node $node, Node $nodeT) {
        $open_tag = $node->add_new_node_name("open_tag");
        $open_tagT = $nodeT->add_new_node_name("open_tag");

        if($this->matchL("<", $open_tag, $open_tagT, "<?php")) {
            return true;
        }

        return false;
    }

    private function close_tag(Node $node, Node $nodeT) {
        $close_tag = $node->add_new_node_name("close_tag");
        $close_tagT = $nodeT->add_new_node_name("close_tag");

        if($this->matchL(">", $close_tag, $close_tagT, "?>")) {
            return true;
        }

        return false;
    }

    private function append_to_object(Node $nodeT, string $text) {
        $nodeT->add_new_node_name($text);
        
        return true;
    }
}