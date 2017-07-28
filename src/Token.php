<?php

namespace KmeCnin\GrossLang;

abstract class Token
{
    const VAR = "T_VAR";
    const ASS = "T_ASS";
    const VAR_NAME = "T_VAR_NAME";
    const VALUE = "T_VALUE";
    const IF = "T_IF";
    const ELSE = "T_ELSE";
    const PAREN_OPEN = "T_PAREN_OPEN";
    const PAREN_CLOSE = "T_PAREN_CLOSE";
    const BLOCK_OPEN = "T_BLOCK_OPEN";
    const BLOCK_CLOSE = "T_BLOCK_CLOSE";
    const FUNC = "T_FUNC";
    const SEPARATOR = "T_SEPARATOR";
    const EQ = "T_EQ";
    const MODULO = "T_MODULO";
    const LT = "T_LT";
    const GT = "T_GT";
    const LTE = "T_LTE";
    const GTE = "T_GTE";
    const ADD = "T_ADD";

    protected $key;

    public function __construct(string $key)
    {
        $this->key = $key;
    }

    public static function keys(): array
    {
        return [
            self::VAR,
            self::ASS,
            self::VAR_NAME,
            self::VALUE,
            self::IF,
            self::ELSE,
            self::PAREN_OPEN,
            self::PAREN_CLOSE,
            self::BLOCK_OPEN,
            self::BLOCK_CLOSE,
            self::FUNC,
            self::SEPARATOR,
            self::EQ,
            self::MODULO,
            self::LT,
            self::GT,
            self::LTE,
            self::GTE,
            self::ADD,
        ];
    }

    public function key(): string
    {
        return $this->key;
    }
}
