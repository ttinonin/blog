<?php

namespace App\Models;

class Model {
    public function getModelName() {
        return strtolower(basename(str_replace('\\', '/',get_class($this))) . 's');
    }

    public function getModelParams() {
        $reflector = new \ReflectionClass($this);
        $propriedades = $reflector->getProperties();

        $resultado = [];
        foreach ($propriedades as $propriedade) {
            $propriedade->setAccessible(true);
            $resultado[$propriedade->getName()] = $propriedade->getValue($this);
        }

        return $resultado;
    }
}