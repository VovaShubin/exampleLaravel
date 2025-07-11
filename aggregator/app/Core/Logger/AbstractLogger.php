<?php

namespace App\Core\Logger;

use App\Core\Data\Models\Log;
use Psr\Log\LoggerInterface;
use Stringable;

abstract class AbstractLogger implements LoggerInterface
{
    public function emergency(Stringable|string $message, array $context = []): void
    {
        $this->log(Log::EMERGENCY_LEVEL, $message, $context);
    }

    public function alert(Stringable|string $message, array $context = []): void
    {
        $this->log(Log::ALERT_LEVEL, $message, $context);
    }

    public function critical(Stringable|string $message, array $context = []): void
    {
        $this->log(Log::CRITICAL_LEVEL, $message, $context);
    }

    public function error(Stringable|string $message, array $context = []): void
    {
        $this->log(Log::ERROR_LEVEL, $message, $context);
    }

    public function warning(Stringable|string $message, array $context = []): void
    {
        $this->log(Log::WARNING_LEVEL, $message, $context);
    }

    public function notice(Stringable|string $message, array $context = []): void
    {
        $this->log(Log::NOTICE_LEVEL, $message, $context);
    }

    public function info(Stringable|string $message, array $context = []): void
    {
        $this->log(Log::INFO_LEVEL, $message, $context);
    }

    public function debug(Stringable|string $message, array $context = []): void
    {
        $this->log(Log::DEBUG_LEVEL, $message, $context);
    }
}
