<?php

namespace Compiler\Utils;

class Token {
    public string $type;
    public string $lexeme;

    public function __construct(string $type, string $lexeme) {
        $this->type = $type;
        $this->lexeme = $lexeme;
    }

    public function __toString() {
        return "<$this->type, $this->lexeme>";
    }
}