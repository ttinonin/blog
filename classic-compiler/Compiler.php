<?php

namespace Compiler;

require __DIR__ . "/../vendor/autoload.php";

use Compiler\Lexer\Lexer;
use Compiler\Syntax\Parser;
use Compiler\Utils\File;

use Utils\Flags;

class Compiler {
    private $template = "";
    private $tokens = [];
    private $code = "";

    private File $file_loader;
    
    private Flags $flags;

    public function __construct(Flags $flags) {
        $this->flags = $flags;
    }

    private function load_template($file) {
        $this->file_loader = new File(__DIR__ . "/../src/Views/pages/pre_compiled/$file");
        
        $this->template = $this->file_loader->load();
    }

    private function run_lexer() {
        $lexer = new Lexer($this->template);
        $this->tokens = $lexer->getTokens();

        if($this->flags->get("tokens")) {
            foreach($this->tokens as $token) {
                echo "\n" . (string) $token . "\n";
            }
        }
    }

    private function run_parser() {
        $parser = new Parser($this->tokens, $this->file_loader->get_name(), $this->flags);
        $this->code = $parser->main();
    }

    private function write_object() {
        $file_name_array = explode(".", $this->file_loader->get_name());
        $name = $file_name_array[0];

        $this->file_loader->write(__DIR__ . "/../src/Views/pages/" . $name . '.php', $this->code);
    }

    public function init($file) {
        $this->load_template($file);

        $this->run_lexer();
        $this->run_parser();

        $this->write_object();
    }
}