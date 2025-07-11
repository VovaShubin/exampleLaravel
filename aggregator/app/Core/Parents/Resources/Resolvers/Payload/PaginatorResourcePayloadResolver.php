<?php

namespace App\Core\Parents\Resources\Resolvers\Payload;

use App\Core\Contracts\Resource\IResourcePayload;
use App\Core\Contracts\Resource\IResourcePayloadResolver;
use App\Core\Parents\Resources\ResourcePayload;
use Illuminate\Pagination\AbstractCursorPaginator;
use Illuminate\Pagination\AbstractPaginator;
use Illuminate\Support\Arr;

class PaginatorResourcePayloadResolver implements IResourcePayloadResolver
{
    /**
     * @inheritDoc
     */
    public function resolve($payload): ?IResourcePayload
    {
        if ($payload instanceof AbstractCursorPaginator || $payload instanceof AbstractPaginator) {

            $paginated = $payload->toArray();

            $links["pagination"] = [
                'first' => $paginated['first_page_url'] ?? null,
                'last' => $paginated['last_page_url'] ?? null,
                'prev' => $paginated['prev_page_url'] ?? null,
                'next' => $paginated['next_page_url'] ?? null,
            ];

            $meta["pagination"] = Arr::except($paginated, [
                'data',
                'first_page_url',
                'last_page_url',
                'prev_page_url',
                'next_page_url',
            ]);

            //put all additional payload data to resource's meta field
            if (($additional = $payload?->additional ?? null) && is_array($additional)) {
                $meta += $additional;
            }

            $result = new ResourcePayload($paginated["data"], $meta, $links);
        }

        return $result ?? null;
    }
}
