<?php

namespace KmeCnin\GrossLang\Exception;

class InvalidTokenKeyException extends \Exception
{
    public function __construct(string $key, array $lexicon)
    {
        $message = sprintf(
            'You fucked up! Your lexicon contains undefined token key: %s.',
            $key
        );
        parent::__construct($message);
    }
}
