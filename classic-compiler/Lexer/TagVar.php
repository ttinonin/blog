<?php

namespace Compiler\Lexer;

use Compiler\Lexer\AFD;
use Compiler\Utils\CharIterator;
use Compiler\Utils\Token;

class TagVar extends AFD {
    private $variables_att = [
        "$",
        "[",
        "]",
        "'",
        "\"",
        "-",
        "_",
    ];

    public function evaluate(CharIterator $code) {
        if($code->current() === "$") {
            $identifier = $this->read_identifier($code);

            if($this->end_identifier($code)) {
                return new Token("TAG_VAR", $identifier);
            }
        }
    }

    private function read_identifier(CharIterator $code) {
        $identifier = "";

        while($code->isCurrentALetter() || $code->isCurrentADigit() || in_array($code->current(), $this->variables_att)) {
            $identifier .= $code->current();            
            
            $code->next();
        }

        return $identifier;
    }

    private function end_identifier(CharIterator $code) {
        return $code->current() === " " || $code->current() === ">" || $code->current() === null;
    }
}