<?php

namespace Compiler\Lexer;

use Compiler\Lexer\AFD;
use Compiler\Utils\CharIterator;
use Compiler\Utils\Token;

class MathOperator extends AFD {
    public function evaluate(CharIterator $code) {
        if($code->current() === "=") {
            $code->next();
            return new Token("RECEIVES", "=");
        } else {
            return null;
        }
    }
}