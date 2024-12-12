<?php

namespace Compiler\Lexer;

use Compiler\Utils\CharIterator;

abstract class AFD {
    abstract public function evaluate(CharIterator $code);
}