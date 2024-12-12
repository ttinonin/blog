<?php

namespace Compiler\Lexer;

use Compiler\Lexer\AFD;
use Compiler\Utils\CharIterator;
use Compiler\Utils\Token;

class TagValue extends AFD {
    public function evaluate(CharIterator $code) {
        if($code->current() === "'" || $code->current() === '"') {
            $identifier = $this->read_identifier($code);
            if($this->end_identifier($code)) {
                $code->next();
                return new Token("TAG_VALUE", $identifier);
            }
        }
    }

    private function read_identifier(CharIterator $code) {
        $identifier = "";
        $code->next();

        while($code->current() !== "'" && $code->current() !== '"') {
            if($code->current() === null) {
                return null;
            }

            $identifier .= $code->current();            
            $code->next();
        }

        // $identifier .= $code->current();            
        return $identifier;
    }

    private function end_identifier(CharIterator $code) {
        return $code->current() === "'" || $code->current() === '"';
    }
}