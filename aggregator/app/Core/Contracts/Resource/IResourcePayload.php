<?php

namespace App\Core\Contracts\Resource;

interface IResourcePayload
{
    /**
     * @return array
     */
    public function data(): array;

    /**
     * @return array
     */
    public function meta(): array;

    /**
     * @return array
     */
    public function links(): array;
}
