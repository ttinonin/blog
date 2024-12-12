<?php

namespace Compiler\Lexer;

use Compiler\Lexer\AFD;
use Compiler\Utils\CharIterator;
use Compiler\Utils\Token;

class TagEnd extends AFD {
    public function evaluate(CharIterator $code) {
        if($code->current() === "/") {
            $code->next();
            return new Token("TAG_END", "/");
        } else {
            return null;
        }
    }
}