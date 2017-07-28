<?php

namespace KmeCnin\GrossLang\Statement;

class Args implements Statement
{
    /** @var Valuable[] */
    private $args;

    public function __construct(array $args)
    {
        $this->args = [];
        foreach ($args as $arg) {
            $this->add($arg);
        }
    }

    private function add(Valuable $arg)
    {
        $this->args[] = $arg;
    }

    public function label(): string
    {
        return 'args';
    }

    public function jsonSerialize()
    {
        $array = [];
        foreach ($this->args as $arg) {
            $array[] = [$arg->label() => $arg];
        }
        return $array;
    }
}
