<?php

namespace App\Core\Logger;

use App\Core\Data\Models\Log;
use Stringable;

class DataBaseLogger extends AbstractLogger
{
    /** @var string */
    protected string $target = "";
    public function target(string $target): self
    {
        $this->target = $target;
        return $this;
    }

    public function log($level, Stringable|string $message, array $context = []): void
    {
        Log::query()->create([
            'target' => empty($this->target) ? Log::COMMON_TARGET : $this->target,
            'level' => $level,
            'context' => $context,
            'message' => $message
        ]);
        $this->target = "";
    }
}
