<?php

namespace KmeCnin\GrossLang\Statement;

class Params implements Statement
{
    /** @var Valuable[] */
    private $params;

    public function __construct(array $params)
    {
        $this->params = [];
        foreach ($params as $param) {
            $this->add($param);
        }
    }

    private function add(Variable $param)
    {
        $this->params[] = $param;
    }

    public function label(): string
    {
        return 'params';
    }

    public function jsonSerialize()
    {
        $array = [];
        foreach ($this->params as $param) {
            $array[] = [$param->label() => $param];
        }
        return $array;
    }
}
