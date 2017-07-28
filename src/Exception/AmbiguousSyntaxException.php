<?php

namespace KmeCnin\GrossLang\Exception;

class AmbiguousSyntaxException extends \Exception
{
    public function __construct(array $tokens)
    {
        $message = sprintf(
            'You fucked up! Your grammar is bad and you should feel bad.'
        );
        parent::__construct($message);
    }
}
