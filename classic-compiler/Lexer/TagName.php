<?php

namespace Compiler\Lexer;

use Compiler\Lexer\AFD;
use Compiler\Utils\CharIterator;
use Compiler\Utils\Token;

class TagName extends AFD {
    private $reserved_keywords = [
        "foreach",
        "if",
        "can",
        "auth",
        "else",
        "component",
    ];

    private $html_keywords = [
        "html", "head", "title", "base", "link", "meta", "style", "script", "noscript",
        "body", "section", "nav", "article", "aside", "h1", "h2", "h3", "h4", "h5", "h6", 
        "header", "footer", "address", "main", "p", "hr", "pre", "blockquote", "ol", "ul", 
        "li", "dl", "dt", "dd", "figure", "figcaption", "div", "a", "em", "strong", "small", 
        "s", "cite", "q", "dfn", "abbr", "ruby", "rt", "rp", "data", "time", "code", "var", 
        "samp", "kbd", "sub", "sup", "i", "b", "u", "mark", "bdi", "bdo", "span", "br", 
        "wbr", "ins", "del", "picture", "source", "img", "iframe", "embed", "object", 
        "param", "video", "audio", "track", "map", "area", "table", "caption", "colgroup", 
        "col", "tbody", "thead", "tfoot", "tr", "td", "th", "form", "label", "input", 
        "button", "select", "datalist", "optgroup", "option", "textarea", "output", 
        "progress", "meter", "fieldset", "legend", "details", "summary", "dialog", "script", 
        "noscript", "template", "canvas", "svg", "math"
    ];    

    public function evaluate(CharIterator $code) {
        if($code->isCurrentALetter() || $code->current() === "/" || $code->current() === "$") {
            $identifier = $this->read_identifier($code);

            if($this->end_identifier($code)) {
                if(in_array($identifier, $this->reserved_keywords)) {
                    return new Token("TAG_NAME", $identifier);
                } elseif(in_array($identifier, $this->html_keywords)) {
                    return new Token("TAG_HTML", $identifier);
                }
            }
        }
    }

    private function read_identifier(CharIterator $code) {
        $identifier = "";

        while($code->isCurrentALetter() || $code->isCurrentADigit() || $code->current() === "-") {
            $identifier .= $code->current();            
            
            $code->next();
        }

        return $identifier;
    }

    private function end_identifier(CharIterator $code) {
        return $code->current() === " " || $code->current() === ">" || $code->current() === null;
    }
}