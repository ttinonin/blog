<?php

namespace Compiler\Lexer;

use Compiler\Lexer\AFD;
use Compiler\Utils\CharIterator;
use Compiler\Utils\Token;

class Tag extends AFD {
    public function evaluate(CharIterator $code) {
        if($code->current() === "<") {
            $code->next();
            return new Token("TAG_OPEN", "<");
        } elseif ($code->current() === ">") {
            $code->next();
            return new Token("TAG_CLOSE", ">");
        } else {
            return null;
        }
    }
}