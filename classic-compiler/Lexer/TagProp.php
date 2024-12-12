<?php

namespace Compiler\Lexer;

use Compiler\Lexer\AFD;
use Compiler\Utils\CharIterator;
use Compiler\Utils\Token;

class TagProp extends AFD {
    private $reserved_keywords = [
        "array",
        "key",
        "value",
        "condition",
        "render",
        "src",
        "action",
        "policy"
    ];

    private $html_attributes = [
        "id", "class", "style", "src", "href", "alt", "title", "type", "value", "name", 
        "placeholder", "disabled", "readonly", "checked", "selected", "required", "pattern", 
        "min", "max", "maxlength", "size", "step", "rows", "cols", "action", "method", 
        "target", "rel", "download", "media", "defer", "async", "charset", "for", "form", 
        "formaction", "formenctype", "formmethod", "formnovalidate", "formtarget", "enctype", 
        "autocomplete", "autofocus", "autoplay", "loop", "muted", "controls", "poster", 
        "preload", "crossorigin", "usemap", "ismap", "longdesc", "srcset", "sizes", 
        "data-*", "datetime", "pubdate", "open", "border", "frameborder", "allowfullscreen", 
        "scrolling", "sandbox", "seamless", "allow", "manifest", "novalidate", "accesskey", 
        "tabindex", "dir", "lang", "role", "aria-*"
    ];    

    public function evaluate(CharIterator $code) {
        if($code->isCurrentALetter()) {
            $identifier = $this->read_identifier($code);

            if($this->end_identifier($code)) {
                if(in_array($identifier, $this->reserved_keywords)) {
                    return new Token("TAG_PROP", $identifier);
                } elseif(in_array($identifier, $this->html_attributes)) {
                    return new Token("TAG_HTML_PROP", $identifier);
                }
            }
        }
    }

    private function read_identifier(CharIterator $code) {
        $identifier = "";

        while($code->isCurrentALetter()) {
            $identifier .= $code->current();            
            
            $code->next();
        }

        return $identifier;
    }

    private function end_identifier(CharIterator $code) {
        return $code->current() === " " || $code->current() === "=";
    }
}