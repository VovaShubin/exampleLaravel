<?php

namespace App\Modules\Test\Data\Transformers;

class DiscountTransformer
{
    public static function make(array $payload): array
    {

        $result = [
            'discount_id' => $payload['id'],
            'value' => floatval($payload['value']),
            'from' => $payload['age_from'] ?? null,
            'to' => $payload['age_to'] ?? null,
            'reserve_name' => empty($payload['reserve_name']) ? $payload['name'] : $payload['reserve_name'] ?? ''
        ];
        return $result;
    }
}
