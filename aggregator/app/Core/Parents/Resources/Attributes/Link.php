<?php

namespace App\Core\Parents\Resources\Attributes;

class Link extends AbstractAttribute
{
    /**
     * @return array
     */
    public function toArray(): array
    {
        return [$this->key => $this->value];
    }
    /**
     * @return string
     */
    public function container(): string
    {
        return "links";
    }
}
