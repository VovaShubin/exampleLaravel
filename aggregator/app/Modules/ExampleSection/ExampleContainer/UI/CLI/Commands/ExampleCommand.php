<?php

namespace App\Modules\ExampleSection\ExampleContainer\UI\CLI\Commands;

use App\Core\Parents\Commands\Command;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class ExampleCommand extends Command
{
    /**
     * @var string
     */
    protected $signature = "example:test";

    public function handle(): void
    {
        Log::build([
            'driver' => 'single',
            'path' => storage_path('logs/example.log'),
        ])->info('Test OK at ' . Carbon::now()->toDateTimeString());
        $this->info("Test OK");
    }
}
