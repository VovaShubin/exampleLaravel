<?php

namespace App\Core\Parents\Tests;

use Illuminate\Contracts\Console\Kernel;
use Illuminate\Foundation\Application;
use PHPUnit\Framework\TestCase;

abstract class UnitTest extends TestCase
{
    /**
     * @var Application
     */
    protected Application $app;

    /**
     * @param string $name
     */
    public function __construct(string $name)
    {
        parent::__construct($name);

        $this->app = $this->createApplication();
    }

    /**
     * Creates the application.
     */
    public function createApplication(): Application
    {
        $app = require __DIR__ . '/../../../../bootstrap/app.php';

        $app->make(Kernel::class)->bootstrap();

        return $app;
    }
}
