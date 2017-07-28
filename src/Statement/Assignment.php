<?php

namespace KmeCnin\GrossLang\Statement;

class Assignment implements Statement
{
    private $variable;
    private $value;

    public function __construct(Variable $variable, Value $value)
    {
        $this->variable = $variable;
        $this->value = $value;
    }

    public function label(): string
    {
        return 'assignment';
    }

    public function jsonSerialize()
    {
        return [
            $this->variable->label() => $this->variable,
            $this->value->label() => $this->value,
        ];
    }
}
