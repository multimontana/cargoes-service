<?php

namespace App\Exceptions;

use Exception;

class GeneralException extends Exception
{
    /**
     * @var array
     */
    private array $options;

    /**
     * AuthenticateException constructor.
     * @param string $message
     * @param int $code
     * @param array $options
     * @param Exception|null $previous
     */
    public function __construct(string $message = "", int $code = 0, array $options = [], Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);

        $this->options = $options;
    }

    /**
     * @param array $options
     */
    public function setOptions(array $options): void
    {
        $this->options = $options;
    }

    /**
     * @return array
     */
    public function getOptions(): array
    {
        return $this->options;
    }
}
