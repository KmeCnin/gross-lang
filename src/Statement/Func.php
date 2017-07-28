<?php

namespace KmeCnin\GrossLang\Statement;

class Func implements Statement
{
    private $variable;
    private $params;
    private $sequence;

    public function __construct(Variable $variable, Params $params, Sequence $sequence)
    {
        $this->variable = $variable;
        $this->params = $params;
        $this->sequence = $sequence;
    }

    public function label(): string
    {
        return 'function';
    }

    public function jsonSerialize()
    {
        return [
            $this->variable->label() => $this->variable,
            $this->params->label() => $this->params,
            $this->sequence->label() => $this->sequence,
        ];
    }
}
