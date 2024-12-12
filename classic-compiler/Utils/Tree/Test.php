<?php

namespace Compiler\Utils\Tree;

class Test {
    public static function test() {
        $node1 = new Node("A");
        $node2 = new Node("B");
        $node3 = new Node("C");
        $node4 = new Node("D");
        $node5 = new Node("E");

        $node1->add_new_node($node2);
        $node1->add_new_node($node3);
        $node1->add_new_node($node4);
        $node4->add_new_node($node5);
        $node2->add_new_node_name("F");
        $node2->add_new_node_name("G");
        $node3->add_new_node_name("H");

        $tree = new Tree($node1);
        $tree->pre_order();
        $tree->print_code();
        $tree->print_tree();
    }
}