<?php

namespace App\Core\Parents\Resources\Attributes;

use App\Core\Parents\Resources\Attributes\AbstractAttribute;

class JsonApi extends AbstractAttribute
{

    /**
     * @inheritDoc
     */
    public function toArray()
    {
        return [$this->key => $this->value];
    }

    /**
     * @inheritDoc
     */
    public function container(): string
    {
        return "jsonapi";
    }
}
