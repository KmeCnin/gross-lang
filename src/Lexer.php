<?php

namespace KmeCnin\GrossLang;

use KmeCnin\GrossLang\Exception\InvalidTokenKeyException;
use KmeCnin\GrossLang\Exception\UnexpectedTokenException;

class Lexer
{
    private $lexicon;
    private $keywords;
    private $program;
    private $regexp;
    private $regexpMap;

    public function __construct(array $lexicon)
    {
        $this->lexicon = $lexicon;

        $this->keywords = $this->regexpMap = $regexp = [];
        foreach ($lexicon as $key => $rule) {
            if (!in_array($key, Token::keys())) {
                throw new InvalidTokenKeyException($key, $lexicon);
            }
            if (substr($rule, 0, 1) !== '[') {
                $this->keywords[$rule] = $key;
                array_unshift($regexp, $this->toRegExp($rule));
                array_unshift($this->regexpMap, $key);
            } else {
                $regexp[] = $this->toRegExp($rule);
                $this->regexpMap[] = $key;
            }
        }

        $this->regexp = implode('|', $regexp);
    }

    public function analyse(string $program)
    {
        $this->program = $program;
        $tokens = [];
        while (trim($this->program) !== '') {
            $tokens[] = $this->nextToken();
        }

        return $tokens;
    }

    private function nextToken(): Token
    {
        if (preg_match(
            '#^'.$this->regexp.'#',
            $this->program,
            $matches
        )) {
            foreach ($matches as $index => $word) {
                if ('' !== $word && $index > 0) {
                    $key = $this->regexpMap[$index-1];
                    $this->stripProgram($word);
                    if ($this->isKeyword(trim($word))) {
                        return new KeywordToken($key);
                    } else {
                        return new ValueToken($key, trim($word));
                    }
                }
            }
        }

        throw new UnexpectedTokenException($this->program);
    }

    private function toRegExp(string $rule)
    {
        return mb_substr($rule, 0, 1) === '['
            ? '(\s*'.$rule.'\s*)'
            : '(\s*'.preg_quote($rule).'\s*)';
    }

    private function stripProgram(string $word): void
    {
        $this->program = mb_substr($this->program, mb_strlen($word));
    }

    private function isKeyword(string $word): bool
    {
        return isset($this->keywords[$word]);
    }
}
