<?php

namespace KmeCnin\GrossLang;

use KmeCnin\GrossLang\Statement\Args;
use KmeCnin\GrossLang\Statement\Assignment;
use KmeCnin\GrossLang\Statement\Call;
use KmeCnin\GrossLang\Statement\Func;
use KmeCnin\GrossLang\Statement\Params;
use KmeCnin\GrossLang\Statement\Sequence;
use KmeCnin\GrossLang\Statement\Test;
use KmeCnin\GrossLang\Statement\Value;
use KmeCnin\GrossLang\Statement\Variable;

class Grammar
{
    /** @var Token[]|ValueToken[] $tokens */
    private $tokens;
    private $nbTokensExtracted;

    /** @param Token[] $tokens */
    public function match(array $tokens): array // (?Statement, ?int $nbTokens)
    {
        $this->tokens = $tokens;

        $match = $this->assignment()
            ?? $this->func()
            ?? $this->call()
            ?? $this->test()
            ?? null;

        return [$match, $this->nbTokensExtracted];
    }

    private function assignment(): ?Assignment
    {
        $this->nbTokensExtracted = 0;

        list($keyword, $var, $assign, $value) = $this->extract(4);

        if ($keyword->key() !== Token::VAR ||
            $var->key() !== Token::VAR_NAME || !$var instanceof ValueToken &&
            $assign->key() !== Token::ASS ||
            $value->key() !== Token::VALUE || !$value instanceof ValueToken
        ) {
            return null;
        }

        return new Assignment(new Variable($var->val()), new Value($value->val()));
    }

    private function func(): ?Func
    {
        $this->nbTokensExtracted = 0;

        list($keyword, $name) = $this->extract(2);
        if ($keyword->key() !== Token::FUNC ||
            $name->key() !== Token::VAR_NAME || !$name instanceof ValueToken
        ) {
            return null;
        }

        $params = [];
        while (($token = $this->extract())->key() === Token::VAR_NAME &&
            $token instanceof ValueToken
        ) {
            $params[] = new Variable($token->val());
        }
        if ($token->key() !== Token::BLOCK_OPEN) {
            return null;
        }

        $sequence = [];
        while (($token = $this->extract()) &&
            $token->key() !== Token::BLOCK_CLOSE
        ) {
            $sequence[] = $token;
        }
        if ($token->key() !== Token::BLOCK_CLOSE) {
            return null;
        }

        return new Func(new Variable($name->val()), new Params($params), new Sequence($sequence));
    }

    private function call(): ?Call
    {
        $this->nbTokensExtracted = 0;

        list($name, $open) = $this->extract(2);
        if ($name->key() !== Token::VAR_NAME || !$name instanceof ValueToken ||
            $open->key() !== Token::PAREN_OPEN
        ) {
            return null;
        }

        $args = [];
        while (($token = $this->extract()) instanceof ValueToken) {
            if ($token->key() === Token::VAR_NAME) {
                $args[] = new Variable($token->val());
            } elseif ($token->key() === Token::VAR) {
                $args[] = new Value($token->val());
            } else {
                return null;
            }
        }
        if ($token->key() !== Token::PAREN_CLOSE) {
            return null;
        }

        return new Call(new Variable($name->val()), new Args($args));
    }

    private function test(): ?Test
    {
        $this->nbTokensExtracted = 0;

        $keyword = $this->extract();
        if ($keyword->key() !== Token::IF) {
            return null;
        }

        $expression = [];
        while (($token = $this->extract()) &&
            $token->key() !== Token::BLOCK_OPEN
        ) {
            $expression[] = $token;
        }
        if ($token->key() !== Token::PAREN_OPEN) {
            return null;
        }

        $sequence = [];
        while (($token = $this->extract()) &&
            $token->key() !== Token::BLOCK_CLOSE
        ) {
            $sequence[] = $token;
        }
        if ($token->key() !== Token::BLOCK_CLOSE) {
            return null;
        }

        return new Test(new Expression($expression), new Sequence($sequence));
    }

    /** @return array|ValueToken|null */
    private function extract(int $nb = 1)
    {
        $extracted = [];
        $start = $this->nbTokensExtracted;
        for ($i = 0; $i < $nb; $i++) {
            if (isset($this->tokens[$start+$i])) {
                $extracted[] = $this->tokens[$start+$i];
                $this->nbTokensExtracted++;
            } else {
                $extracted[] = null;
            }
        }

        return 1 === count($extracted) ? reset($extracted) : $extracted;
    }

    private function isComparator(Token $token): bool
    {
        return $token->key() === Token::EQ
            || $token->key() === Token::LT
            || $token->key() === Token::GT
            || $token->key() === Token::LTE
            || $token->key() === Token::GTE
            || $token->key() === Token::ADD;
    }
}
