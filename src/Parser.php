<?php

namespace KmeCnin\GrossLang;

use KmeCnin\GrossLang\Statement\Sequence;

class Parser
{
    private $tree;

    public function __construct(array $tokens)
    {
        $this->tree = new Sequence($tokens);
        $this->tree->debug();
    }
}
