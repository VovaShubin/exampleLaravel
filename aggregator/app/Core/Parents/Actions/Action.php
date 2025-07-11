<?php

namespace App\Core\Parents\Actions;

abstract class Action
{
    public function getPaginationParams(array $payload): array
    {
        foreach ($payload as $key => $item) {
            if (in_array($key, ["perPage", "pageName", "columns", "page"])) {
                $result[$key] = $item;
            }
        }
        return $result ?? [];
    }

    public function getSelectedFilters(array $payload): array
    {
        return $payload['filter'] ?? [];
    }

    public function getSelectedSorts(array $payload): array
    {
        $sortParams = $payload['sort'] ?? null;

        if (is_string($sortParams)) {

            return array_unique(array_filter(explode(',', $sortParams)));
        }

        return [];
    }
}
