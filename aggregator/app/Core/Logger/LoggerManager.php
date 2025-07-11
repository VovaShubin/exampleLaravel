<?php

namespace App\Core\Logger;

use App\Core\Logger\AbstractLogger;

class LoggerManager
{
    public function databaseLogger(): DataBaseLogger
    {
        return app(DataBaseLogger::class);
    }
    public function debugInfoLogger(): DebugInfoLogger
    {
        return app(DebugInfoLogger::class);
    }
}
