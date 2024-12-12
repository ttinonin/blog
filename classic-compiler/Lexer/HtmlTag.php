<?php

namespace Compiler\Lexer;

use Compiler\Lexer\AFD;
use Compiler\Utils\CharIterator;
use Compiler\Utils\Token;

class HtmlTag extends AFD {
    private $reserved_keywords = [
        "<foreach>",
        "<endforeach>",
        "<if>",
        "<endif>",
        "<can>",
        "<endcan>",
        "<auth>",
        "<endauth>"
    ];

    public function evaluate(CharIterator $code) {
        if($code->current() === "<") {
            $code->next();
            $identifier = $this->read_identifier($code);

            if($this->end_identifier($code)) {
                if(in_array($identifier, $this->reserved_keywords)) {
                    return new Token("RESERVED", $identifier);
                } else {
                    return new Token("TAG", $identifier);
                }
            }
        }
    }

    private function read_identifier(CharIterator $code) {
        $identifier = "<";

        while($code->isCurrentALetter() || $code->current() === ">") {
            $identifier .= $code->current();            
            
            $code->next();
        }

        return $identifier;
    }

    private function end_identifier(CharIterator $code) {
        return $code->current() === "<" || $code->current() === null;
    }
}