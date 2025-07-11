<?php

namespace App\Core\Parents\TestSystemsIntegrations\Dto\Items;

use App\Core\Parents\Dto\Item;

abstract class Category extends Item
{
    public ?string $name = null;
    public ?string $test_uid = null;
    public ?string $test_system_uid = null;
    public ?int $test_id = null;
    public ?string $slug = null;
    public array $image_links = [];

    public function toArray(): array
    {
        return [
            "name" => $this->name,
            "test_uid" => $this->test_uid,
            "test_system_uid" => $this->test_system_uid,
            "test_id" => $this->test_id,
            "slug" => $this->slug,
            "image_links" => $this->image_links
        ];
    }
}
