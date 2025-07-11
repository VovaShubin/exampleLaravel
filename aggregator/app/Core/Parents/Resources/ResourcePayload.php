<?php

namespace App\Core\Parents\Resources;

use App\Core\Contracts\Resource\IResourcePayload;

class ResourcePayload implements IResourcePayload
{
    /**
     * @var array
     */
    protected array $meta = [];

    /**
     * @var array
     */
    protected array $links = [];

    /**
     * @var array
     */
    protected array $data = [];

    /**
     * @param array $data
     * @param array $meta
     * @param array $links
     */
    public function __construct(array $data = [], array $meta = [], array $links = [])
    {
        $this->data = $data;

        $this->links = $links;

        $this->meta = $meta;
    }

    /**
     * @return array
     */
    public function meta(): array
    {
        return $this->meta;
    }

    /**
     * @return array
     */
    public function data(): array
    {
        return $this->data;
    }

    /**
     * @return array
     */
    public function links(): array
    {
        return $this->links;
    }
}
