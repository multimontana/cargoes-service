<?php

namespace App\Exceptions\Common;

use Exception;
use Symfony\Component\HttpFoundation\Response;

class PermissionDeniedException extends Exception
{
    private array $options;

    public function __construct(
        string $message = '',
        int $code = Response::HTTP_FORBIDDEN,
        array $options = [],
        Exception $previous = null
    ) {
        parent::__construct($message, $code, $previous);

        $this->options = $options;
    }

    public function setOptions(array $options): void
    {
        $this->options = $options;
    }

    public function getOptions(): array
    {
        return $this->options;
    }
}
