<?php

namespace KmeCnin\GrossLang;

class SequenceGrammar extends Grammar
{
    /** @var Token[]|ValueToken[] $tokens */
    private $tokens;
    private $nbTokensExtracted;

    public function match(array $tokens): array // (?Statement, ?int $nbTokens)
    {
        $this->tokens = $tokens;

        $match = $this->assignment()
            ?? $this->func()
            ?? $this->call()
            ?? $this->test()
            ?? null;

        return [$match, $this->nbTokensExtracted];
    }
}
