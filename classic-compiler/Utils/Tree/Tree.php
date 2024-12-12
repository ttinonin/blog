<?php

namespace Compiler\Utils\Tree;

use Compiler\Utils\Tree\Node;

class Tree {
    private Node $root;
    private $code = [];

    public function __construct(Node $var = null) {
        if($var !== null) {
            $this->root = $var;
        }
    }

    public function set_root(Node $var) {
        $this->root = $var;
    }

    public function pre_order(Node $var = null) {
        if($var === null) {
            $this->pre_order($this->root);
            echo "\n";
        } else {
            echo (string) $var;
            $var2 = $var->nodes;

            foreach($var2 as $node) {
                $this->pre_order($node);
            }
        }
    }

    public function print_code($var1 = null, &$output = "") {
        if ($var1 === null) {
            $this->print_code($this->root, $output);
            $output = preg_replace('/\s+/', ' ', trim($output));
            $this->code[] = "";
        } else {
            if (isset($var1->name) && $var1->name === "html") {
                $enter = $this->removeSpacesInHtmlTags($var1->enter);
                $exit = $this->removeSpacesInHtmlTags($var1->exit);
            } else {
                $enter = $var1->enter;
                $exit = $var1->exit;
            }

            $output .= $enter;
            $this->code[] = $enter;
            
            if (count($var1->nodes) === 0) {
                if($var1->name === "/" || $var1->name === "<" || str_contains($var1->name, ".php") || str_contains($var1->name, "/../") || str_contains($var1->name, "./")) {
                    $content = (string)$var1->name;
                } else {
                    $content = (string)$var1->name . " ";
                }
                $output .= $content;
                $this->code[] = $content;
            }
            
            foreach ($var1->nodes as $node) {
                $this->print_code($node, $output);
            }
        
            $output .= $exit;
            $this->code[] = $exit;
        }

    }

    private function removeSpacesInHtmlTags($tag) {
        return preg_replace('/\s+/', ' ', trim($tag));
    }

    public function get_code() {
        $output = "";
        $this->print_code(null, $output);
        return $output;
    }

    public function print_tree() {
        echo $this->root->get_tree();
    }
}