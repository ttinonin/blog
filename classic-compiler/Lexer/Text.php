<?php

namespace Compiler\Lexer;

use Compiler\Lexer\AFD;
use Compiler\Utils\Token;
use Compiler\Utils\CharIterator;

class Text extends AFD {
    public function evaluate(CharIterator $code) {
        $identifier = $this->read_identifier($code);

        if($this->end_identifier($code)) {
            return new Token("TEXT", $identifier);
        }
    }

    private function read_identifier(CharIterator $code) {
        $identifier = "";

        while($code->current() != "<") {
            $identifier .= $code->current();            
            
            $code->next();
        }

        return $identifier;
    }

    private function end_identifier(CharIterator $code) {
        return $code->current() === "<" || $code->current() === null;
    }
}