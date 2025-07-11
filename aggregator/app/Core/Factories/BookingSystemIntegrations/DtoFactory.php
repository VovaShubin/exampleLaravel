<?php

namespace App\Core\Factories\BookingSystemIntegrations;

use App\Core\Parents\Dto\Item;

class DtoFactory
{

    /**
     * @param array $payload
     * @param string $target
     * @return Item
     */
    public static function make(array $payload, string $target): Item
    {
        return new $target($payload);
    }

    /**
     * @param array $payloads
     * @param string $target
     * @return Item[]
     */
    public static function makeMany(array $payloads, string $target): array
    {
        $collection = [];

        foreach ($payloads as $payload){

            $collection[] = self::make($payload, $target);

        }

        return $collection;
    }
}
