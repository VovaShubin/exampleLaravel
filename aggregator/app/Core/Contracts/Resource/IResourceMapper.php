<?php

namespace App\Core\Contracts\Resource;

use App\Core\Parents\Resources\Attributes\AbstractAttribute;

interface IResourceMapper
{
    /**
     * @param $payload
     * @param $request
     * @return AbstractAttribute[]
     */
    public function data($payload, $request = null): array;

    /**
     * @param $payload
     * @param $request
     * @return array
     */
    public function errors($payload, $request = null): array;

    /**
     * @param $payload
     * @param $request
     * @return AbstractAttribute[]
     */
    public function meta($payload, $request = null): array;

    /**
     * @param $payload
     * @param $request
     * @return AbstractAttribute[]
     */
    public function links($payload, $request = null): array;

    /**
     * @param $payload
     * @param $request
     * @return array
     */
    public function jsonapi($payload, $request = null): array;
}
