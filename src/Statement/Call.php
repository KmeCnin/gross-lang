<?php

namespace KmeCnin\GrossLang\Statement;

class Call implements Statement
{
    private $variable;
    private $args;

    public function __construct(Variable $variable, Args $args)
    {
        $this->variable = $variable;
        $this->args = $args;
    }

    public function label(): string
    {
        return 'call';
    }

    public function jsonSerialize()
    {
        return [
            $this->variable->label() => $this->variable,
            $this->args->label() => $this->args,
        ];
    }
}
