<?php

namespace App\Entity;

class Query
{
    public const ASC = 'asc';
    public const DESC = 'desc';

    /**
     * @param $value
     *
     * @return int
     */
    public static function offset($value): int
    {
        return (int) $value;
    }

    /**
     * @param $value
     *
     * @return int
     */
    public static function limit($value): int
    {
        return (int) $value;
    }
}
