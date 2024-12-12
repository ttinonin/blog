<?php

namespace Compiler\Syntax;

use Compiler\Utils\Tree\Node;

trait VariableMatch {
    private function variable(Node $node, Node $nodeT) {
        $var = $node->add_new_node_name("variable");
        $varT = $nodeT->add_new_node_name("variable");

        if(
            $this->matchL("<", $var, $varT, "<?=") &&
            $this->append_to_object($varT, "htmlspecialchars(") &&
            $this->matchT("TAG_VAR", $var, $varT) &&
            $this->append_to_object($varT, ")") &&

            $this->close_tag($var, $varT)
        ) {
            return true;
        }

        return false;
    }
}