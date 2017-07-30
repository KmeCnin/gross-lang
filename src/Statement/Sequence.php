<?php

namespace KmeCnin\GrossLang\Statement;

use KmeCnin\GrossLang\Exception\UnexpectedSyntaxException;
use KmeCnin\GrossLang\Grammar;
use KmeCnin\GrossLang\SequenceGrammar;
use KmeCnin\GrossLang\Token;

class Sequence implements Statement
{
    /** @var Grammar */
    private $grammar;
    /** @var Statement[] */
    private $statements;

    /** @param Token[] $tokens */
    public function __construct(array $tokens)
    {
        $this->grammar = new SequenceGrammar();
        $this->statements = [];
        $this->walk($tokens);
    }

    /** @param Token[] $tokens */
    private function walk(array $tokens)
    {
        if (empty($tokens)) {
            return;
        }

        list($statement, $nbTokens) = $this->grammar->match($tokens);
        if (!$statement instanceof Statement) {
            throw new UnexpectedSyntaxException($tokens, $nbTokens);
        }

        $this->add($statement);
        $this->walk(array_slice($tokens, $nbTokens));
    }

    public function add(Statement $statement): self
    {
        $this->statements[] = $statement;

        return $this;
    }

    public function debug(): void
    {
        echo json_encode($this, JSON_PRETTY_PRINT)."\n";
    }

    public function label(): string
    {
        return 'sequence';
    }

    public function jsonSerialize(): array
    {
        $array = [];
        foreach ($this->statements as $statement) {
            $array[] = [$statement->label() => $statement];
        }
        return $array;
    }
}
