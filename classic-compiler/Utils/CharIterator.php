<?php

namespace Compiler\Utils;

class CharIterator {
    private $text;
    private $index = 0;
    private $DONE = null;

    public function __construct(string $text) {
        $this->text = $text;
    }

    public function current() {
        return $this->isValidIndex() ? $this->text[$this->index] : $this->DONE;
    }

    public function next() {
        if (!$this->isValidIndex()) {
            return $this->DONE;
        }
        
        $this->index++;
        return $this->current();
    }

    public function prev(): string|null {
        if ($this->index > 0) {
            $this->index--;
        }
        return $this->current();
    }

    public function getIndex(): int {
        return $this->index;
    }

    public function setIndex(int $index): void {
        if ($index >= 0 && $index < strlen($this->text)) {
            $this->index = $index;
        } else {
            throw new \OutOfBoundsException("Index out of bounds: $index");
        }
    }

    private function isValidIndex() {
        return $this->index >= 0 && $this->index < strlen($this->text);
    }

    public function isCurrentADigit() {
        $current = $this->current();
        return $current !== null && is_numeric($current);
    }

    public function isCurrentALetter() {
        $current = $this->current();
        return $current !== null && ctype_alpha($current);
    }
}