<?php

namespace App\Core\Data\Dto\Sync;


class OfferSyncCandidate extends AbstractSyncCandidate
{
    public array $test;

    public function toArray()
    {
        return [
            'test' => $this->test,
        ];
    }

    protected function bind(array $payload): void
    {
        $this->test = $payload['test'] ?? [];
    }
}
