<?php

namespace Compiler\Syntax;

use Compiler\Utils\Tree\Node;

trait IfMatch {
    private function if(Node $node, Node $nodeT) {
        $if = $node->add_new_node_name("if");
        $ifT = $nodeT->add_new_node_name("if");

        if(
            $this->open_tag($if, $ifT) &&
            $this->matchL("if", $if, $ifT) &&
            $this->append_to_object($ifT, "(") &&

            $this->matchT("TAG_PROP", $if) &&
            $this->matchL("=", $if) &&
            $this->matchT("TAG_VALUE", $if, $ifT) &&

            $this->append_to_object($ifT, "):") &&
            $this->close_tag($if, $ifT)
        ) {
            return true;
        }

        return false;
    }

    private function endif(Node $node, Node $nodeT) {
        $endif = $node->add_new_node_name("endif");
        $endifT = $nodeT->add_new_node_name("endif");

        if(
            $this->open_tag($endif, $endifT) &&
            $this->matchL("/", $endif) &&
            $this->matchL("if", $endif, $endifT, "endif;") &&

            $this->close_tag($endif, $endifT)
        ) {
            return true;
        }

        return false;
    }

    private function else(Node $node, Node $nodeT) {
        $else = $node->add_new_node_name("else");
        $elseT = $nodeT->add_new_node_name("else");

        if(
            $this->open_tag($else, $elseT) &&
            $this->matchL("else", $else, $elseT, "else:") &&

            $this->close_tag($else, $elseT)
        ) {
            return true;
        }

        return false;
    }
}