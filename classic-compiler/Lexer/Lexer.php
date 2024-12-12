<?php

namespace Compiler\Lexer;

use Exception;
use Compiler\Lexer\Tag;
use Compiler\Utils\Token;
use Compiler\Lexer\TagVar;
use Compiler\Lexer\HtmlTag;
use Compiler\Lexer\TagName;
use Compiler\Lexer\TagProp;
use Compiler\Lexer\TagValue;
use Compiler\Lexer\MathOperator;
use Compiler\Utils\CharIterator;

class Lexer {
    private $tokens = [];
    private $afds = [];
    private $code = null;

    public function __construct(string $code) {
        $this->code = new CharIterator($code);

        $this->afds[] = new Tag();
        $this->afds[] = new TagName();
        $this->afds[] = new TagProp();
        $this->afds[] = new MathOperator();
        $this->afds[] = new TagValue();
        $this->afds[] = new TagVar();
        $this->afds[] = new TagEnd();
        $this->afds[] = new Text();
    }

    private function skipWhiteSpace() {
        while($this->code->current() === ' ' || $this->code->current() === '\n') {
            $this->code->next();
        }
    }

    public function getTokens() {
        while(!$this->code->current() !== null) {
            $accepted = false;
            $this->skipWhiteSpace();

            if($this->code->current() === null) {
                break;
            }

            foreach($this->afds as $afd) {
                $pos = $this->code->getIndex();
                $token = $afd->evaluate($this->code);
                if($token !== null) {
                    $accepted = true;
                    $this->tokens[] = $token;
                    break;
                } else {
                    $this->code->setIndex($pos);
                }
            }
            
            if($accepted) {
                continue;
            }

            throw new Exception("Undefined token: " . $this->code->current());
        }

        $this->tokens[] = new Token("EOF", "$");
        return $this->tokens;
    }
}