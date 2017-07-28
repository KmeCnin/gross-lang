<?php

namespace KmeCnin\GrossLang\Exception;

class UnexpectedSyntaxException extends \Exception
{
    public function __construct(array $tokens = [], int $nbTokens = 0)
    {
        $message = sprintf(
            'You fucked up! Your grammar is bad and you should feel bad near %s (%d).',
            $tokens[$nbTokens]->key() ?? null,
            $nbTokens
        );
        parent::__construct($message);
    }
}
