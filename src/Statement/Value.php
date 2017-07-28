<?php

namespace KmeCnin\GrossLang\Statement;

class Value extends Valuable
{
    private $number;

    public function __construct(int $number)
    {
        $this->number = $number;
    }

    public function label(): string
    {
        return 'value';
    }

    public function jsonSerialize()
    {
        return [
            'number' => $this->number,
        ];
    }
}
