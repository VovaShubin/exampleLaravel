<?php

namespace App\Core\Logger;

use Illuminate\Support\Facades\Log;

class DebugInfoLogger
{
    public function logIf(string $message, ?bool $condition = null): void
    {
        if (is_null($condition)) {
            $condition = !app()->isProduction();
        }

        if ($condition) {
            Log::info($message); //to file
            dump($message); //to cmd
        }
    }
}
