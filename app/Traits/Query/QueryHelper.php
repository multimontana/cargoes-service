<?php

namespace App\Traits\Query;

trait QueryHelper
{
    /**
     * @var $queryOptions
     */
    private array $queryOptions;

    /**
     * @param $key
     * @param $query
     */
    public function setQuery($key, $query): void
    {
        $this->queryOptions[$key] = $query;
    }

    public function setQueries($options): array
    {
        if (!empty($options)) {
            foreach ($options as $key => $query) {
                $this->queryOptions[$key] = $query;
            }
            return $this->queryOptions;
        }

        return [];
    }

    /**
     * @return array
     */
    public function getQueries(): array
    {
        return $this->queryOptions;
    }
}
