<?php

namespace KmeCnin\GrossLang;

class Main
{
    public static function run(string $program, array $lexicon): void
    {
        $lexer = new Lexer($lexicon);
        $tokens = $lexer->analyse($program);

        $parser = new Parser($tokens);
    }
}
