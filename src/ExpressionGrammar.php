<?php

namespace KmeCnin\GrossLang;

class ExpressionGrammar extends Grammar
{
    /** @var Token[]|ValueToken[] $tokens */
    private $tokens;
    private $nbTokensExtracted;

    public function match(array $tokens): array // (?Statement, ?int $nbTokens)
    {
        $this->tokens = $tokens;

        $match = $this->assignment()
            ?? $this->call()
            ?? $this->comparison()
            ?? null;

        return [$match, $this->nbTokensExtracted];
    }
}
