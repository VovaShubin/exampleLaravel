<?php

namespace App\Core\Parents\Resources\Attributes;

abstract class Collection
{
    protected array $attributeKeys;
    protected ?array $payload;
    protected array $collection = [];

    public function __construct(?array $payload = null, array $attributeKeys = [])
    {
        $this->attributeKeys = $attributeKeys;
        $this->payload = $payload;
        $this->resolve();
    }

    public static function make(...$params): self
    {
        return new static(...$params);
    }

    public function toArray(): array
    {
        return $this->collection;
    }

    abstract protected function resolve(): void;
}
