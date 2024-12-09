<?php

namespace App\Services\Policies;

/**
 * Base Policy class
 * 
 * Every policy must extends this base class
 * 
 * Example usage:
 * class UserPolicy extends Policy {}
 */
abstract class Policy {
    /**
     * Must be overrided
     */
    public static function can_create() {
        return true;
    }

    /**
     * Must be overrided
    */
    public static function can_delete() {
        return true;
    }
    
    /**
     * Must be overrided
    */
    public static function can_update() {
        return true;
    }

    /**
     * Must be overrided
    */
    public static function can_read() {
        return true;
    }
}