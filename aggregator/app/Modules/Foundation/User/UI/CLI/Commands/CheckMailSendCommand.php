<?php

namespace App\Modules\Foundation\User\UI\CLI\Commands;

use App\Core\Parents\Commands\Command;
use App\Modules\Foundation\User\Mails\TestMailSending;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class CheckMailSendCommand extends Command
{

    protected $signature = "check:mail-send {mailTo?}";

    public function handle(): void
    {///
    }
}
