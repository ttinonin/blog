<?php

namespace Compiler\Syntax;

use Compiler\Utils\Tree\Node;

trait ComponentMatch {
    private function component(Node $node, Node $nodeT) {
        $component = $node->add_new_node_name("component");
        $componentT = $nodeT->add_new_node_name("component");

        if(
            $this->open_tag($component, $componentT) &&
            $this->matchL("component", $component, $componentT, "require_once") &&
            $this->matchT("TAG_PROP", $component, $componentT, "__DIR__") &&
            $this->matchL("=", $component, $componentT, ".") &&
            $this->append_to_object($componentT, "\"/../components/") &&
            $this->matchT("TAG_VALUE", $component, $componentT) &&
            $this->append_to_object($componentT, "\";") &&
            $this->close_tag($component, $componentT)
        ) {
            return true;
        }

        $this->error("component");
        return false;
    }
}