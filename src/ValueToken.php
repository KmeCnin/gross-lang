<?php

namespace KmeCnin\GrossLang;

class ValueToken extends Token
{
    protected $value;

    public function __construct(string $token, string $value)
    {
        parent::__construct($token);

        $this->value = $value;
    }

    public function val()
    {
        return $this->value;
    }
}
