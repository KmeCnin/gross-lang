<?php

namespace KmeCnin\GrossLang\Statement;

interface Statement extends \JsonSerializable
{
    public function label(): string;
}
