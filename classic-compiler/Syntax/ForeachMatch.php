<?php

namespace Compiler\Syntax;

use Compiler\Utils\Tree\Node;

trait ForeachMatch {
    private function foreach(Node $node, Node $nodeT) {
        $foreach = $node->add_new_node_name("foreach");
        $foreachT = $nodeT->add_new_node_name("foreach");

        if(
            $this->open_tag($foreach, $foreachT) && 
            $this->matchL("foreach", $foreach, $foreachT) && 
            $this->append_to_object($foreachT, "(") &&

            $this->matchT("TAG_PROP", $foreach) &&
            $this->matchL("=", $foreach) &&
            $this->matchT("TAG_VALUE", $foreach, $foreachT) &&
            
            $this->append_to_object($foreachT, "as") && 

            $this->matchT("TAG_PROP", $foreach) &&
            $this->matchL("=", $foreach) &&
            $this->matchT("TAG_VALUE", $foreach, $foreachT) &&

            $this->append_to_object($foreachT, "):") && 
            $this->close_tag($foreach, $foreachT)
        ) {
            return true;
        }

        return false;
    }

    private function endforeach(Node $node, Node $nodeT) {
        $endforeach = $node->add_new_node_name("endforeach");
        $endforeachT = $nodeT->add_new_node_name("endforeach");

        if($this->open_tag($endforeach, $endforeachT) && $this->matchL("/", $endforeach) && $this->matchL("foreach", $endforeach, $endforeachT, "endforeach;") && $this->close_tag($endforeach, $endforeachT)) {
            return true;
        }

        return false;
    }
}