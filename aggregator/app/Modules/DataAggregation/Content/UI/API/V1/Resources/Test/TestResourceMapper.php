<?php

namespace App\Modules\DataAggregation\Content\UI\API\V1\Resources\Faqs;

use App\Core\Parents\Resources\Attributes\Attribute;
use App\Core\Parents\Resources\Mappers\ResourceMapper_V1;

class TestResourceMapper extends ResourceMapper_V1
{

    /**
     * @inheritDoc
     */
    public function data($payload, $request = null): array
    {
        return [
            Attribute::make('title', $payload['title'] ?? null),
            Attribute::make('slug', $payload['slug'] ?? null),
            Attribute::make('content', $payload['content'] ?? null),
            Attribute::make('svg', $payload['svg'] ?? null),

        ];
    }

    /**
     * @inheritDoc
     */
    public function meta($payload, $request = null): array
    {
        return [];
    }

    /**
     * @inheritDoc
     */
    public function links($payload, $request = null): array
    {
        return [];
    }

    /**
     * @inheritDoc
     */
    function type(): string
    {
        return 'faqs';
    }
}
