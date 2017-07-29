<?php

namespace KmeCnin\GrossLang\Statement;

class Test implements Statement
{
    private $expression;
    private $sequence;

    public function __construct(Expression $expression, Sequence $sequence)
    {
        $this->expression = $expression;
        $this->sequence = $sequence;
    }

    public function label(): string
    {
        return 'test';
    }

    public function jsonSerialize()
    {
        return [
            $this->expression->label() => $this->expression,
            $this->sequence->label() => $this->sequence,
        ];
    }
}
