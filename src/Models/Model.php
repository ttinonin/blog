<?php

namespace App\Models;

/**
 * Model is a base class
 * 
 * Every model must extends the Model class, to use basic functions.
 * 
 * Example usage:
 * class User extends Model {}
 */
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