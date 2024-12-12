<?php

namespace Compiler\Utils\Tree;

class Node {
    public $nodes = [];
    public $name = "";
    public $enter = "";
    public $exit = "";

    public function __construct($name) {
        $this->name = $name;
    }

    public function add_new_node($new_node = null) {
        $this->nodes[] = $new_node;
    }

    public function add_new_node_name($name) {
        $new_node = new Node($name);
        $this->nodes[] = $new_node;
        return $new_node;
    }

    public function add_node_enter_exit($name, $enter, $exit) {
        $new_node = new Node($name);
        $new_node->enter = $enter;
        $new_node->exit = $exit;
        $this->nodes[] = $new_node;
        return $new_node;
    }

    public function delete_children() {
        return array_pop($this->nodes);
    }

    public function __toString() {
        return "$this->enter $this->name $this->exit";
    }

    public function get_tree() {
        echo "\nAST\n";
        $buffer = [];
        $this->print($buffer, "", "");
        return implode("", $buffer);
    }

    public function print(&$buffer, $prefix, $children_prefix) {
        $buffer[] = $prefix . $this->name . "\n";

        foreach ($this->nodes as $index => $node) {
            if ($index < count($this->nodes) - 1) {
                $node->print($buffer, $children_prefix . "+-- ", $children_prefix . "|   ");
            } else {
                $node->print($buffer, $children_prefix . " -- ", $children_prefix . "    ");
            }
        }
    }
}
