<?php

namespace App\Core\Parents\Dto;

use Illuminate\Contracts\Support\Arrayable;

abstract class Item implements Arrayable
{
    /**
     * @param array $payload
     */
    public function __construct(array $payload)
    {
        $this->bind($payload);
    }

    /**
     * @param array $payload
     * @return void
     */
    abstract protected function bind(array $payload): void;

    public function only(array $fields): ?array
    {
        foreach ($fields as $field) {
            if (isset($this->$field)) {
                $result[$field] = $this->$field;
            }
        }
        return $result ?? null;
    }
}
