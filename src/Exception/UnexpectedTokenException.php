<?php

namespace KmeCnin\GrossLang\Exception;

class UnexpectedTokenException extends \Exception
{
    public function __construct(string $program)
    {
        $message = sprintf(
            'You fucked up! Your shitty program contains stupid instruction near: `%s`',
            mb_substr($program, 0, 10)
        );
        parent::__construct($message);
    }
}