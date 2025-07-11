<?php

namespace App\Modules\ExampleSection\ExampleContainer\Tasks;

use App\Core\Parents\Requests\Request;
use Artisan;

class ExampleTask
{
    public function run(Request $request = null): array
    {
        //Any test logic:

        return ['OK'];
    }
}
