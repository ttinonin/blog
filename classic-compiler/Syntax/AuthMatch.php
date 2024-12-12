<?php

namespace Compiler\Syntax;

use Compiler\Utils\Tree\Node;

trait AuthMatch {
    private function auth(Node $node, Node $nodeT) {
        $auth = $node->add_new_node_name("auth");
        $authT = $nodeT->add_new_node_name("auth");

        if(
            $this->open_tag($auth, $authT) &&
            $this->matchL("auth", $auth, $authT, "if") &&
            $this->append_to_object($authT, "(App\Services\Auth::isLoggedIn()):") &&

            $this->close_tag($auth, $authT)
        ) {
            return true;
        }

        return false;
    }

    private function endauth(Node $node, Node $nodeT) {
        $endauth = $node->add_new_node_name("endauth");
        $endauthT = $nodeT->add_new_node_name("endauth");

        if(
            $this->open_tag($endauth, $endauthT) &&
            $this->matchL("/", $endauth) &&
            $this->matchL("auth", $endauth, $endauthT, "endif;") &&

            $this->close_tag($endauth, $endauthT)
        ) {
            return true;
        }

        return false;
    }
}