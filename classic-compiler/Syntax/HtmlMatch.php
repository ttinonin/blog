<?php

namespace Compiler\Syntax;

use Compiler\Utils\Tree\Node;

trait HtmlMatch {
    private function html(Node $node, Node $nodeT) {
        $html = $node->add_new_node_name("html");
        $htmlT = $nodeT->add_new_node_name("html");

        if(
            $this->matchL("<", $html, $htmlT) &&
            $this->matchT("TAG_HTML", $html, $htmlT) &&
            $this->matchL(">", $html, $htmlT)
        ) {
            return true;
        }

        return false;
    }

    private function endhtml(Node $node, Node $nodeT) {
        $endhtml = $node->add_new_node_name("endhtml");
        $endhtmlT = $nodeT->add_new_node_name("endhtml");

        if(
            $this->matchL("<", $endhtml, $endhtmlT) &&
            $this->matchL("/", $endhtml, $endhtmlT) &&
            $this->matchT("TAG_HTML", $endhtml, $endhtmlT) &&
            $this->matchL(">", $endhtml, $endhtmlT)
        ) {
            return true;
        }

        return false;
    }

    private function text(Node $node, Node $nodeT) {
        $text = $node->add_new_node_name("text");
        $textT = $nodeT->add_new_node_name("text");

        if(
            $this->matchT("TEXT", $text, $textT)
        ) {
            return true;
        }

        return false;
    }
}