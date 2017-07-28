<?php

namespace KmeCnin\GrossLang\Statement;

class Variable extends Valuable
{
    private $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function label(): string
    {
        return 'variable';
    }

    public function jsonSerialize()
    {
        return [
            'name' => $this->name,
        ];
    }
}
