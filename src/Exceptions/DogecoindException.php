<?php

namespace Bouhnosaure\Dogecoin\Exceptions;

use RuntimeException;

class DogecoindException extends RuntimeException
{
    /**
     * Construct new dogecoind exception.
     *
     * @param object $error
     *
     * @return void
     */
    public function __construct($error)
    {
        parent::__construct($error['message'], $error['code']);
    }
}
