<?php

namespace App\Http;

abstract class Json
{
    /**
     * @param string $message
     *
     * @param int $code
     * @return object
     */
    public function toJson(string $message, int $code): object
    {
        return response()
            ->json([
                'error' => $message,
                'code' => $code
            ], $code)->getData();
    }
}
