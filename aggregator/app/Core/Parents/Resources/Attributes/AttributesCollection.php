<?php

namespace App\Core\Parents\Resources\Attributes;

class AttributesCollection extends Collection
{
    protected function resolve(): void
    {
        foreach ($this->payload as $payloadKey => $value) {
            if (in_array($payloadKey, $this->attributeKeys)) {
                $this->collection[] = Attribute::make($payloadKey, $value ?? null);
            }
        }
    }
}
