<?php

namespace App\Modules\TestSystemsIntegrations\Test\Tests;

use App\Core\Parents\Tests\UnitTest;
use App\Modules\TestSystemsIntegrations\Test\ClientFactory;
use App\Modules\TestSystemsIntegrations\Test\Communication\Server;
use App\Modules\TestSystemsIntegrations\Test\FrontApi;
use App\Modules\TestSystemsIntegrations\Test\TestIntegrationServiceProvider;
use Illuminate\Foundation\Application;

class UnitTestCase extends UnitTest
{

    /**
     * @var Application
     */
    protected Application $app;

    /**
     * @var FrontApi
     */
    protected FrontApi $frontApi;

    /**
     * @var Server
     */
    protected Server $server;

    /**
     * @param string $name
     */
    public function __construct(string $name)
    {
        parent::__construct($name);

        $this->app = $this->createApplication();

        $this->app->register(TestIntegrationServiceProvider::class);
        /**
         * Make test to client
         */
        $client = ClientFactory::make(1);

        $this->frontApi = new FrontApi($client);

        $this->server = new Server(1);
    }

    /**
     * @param array $keys
     * @return mixed
     */
    protected function payload(array $keys): mixed
    {
        $data = ['test_object_id' => 9, 'test_entity_id' => 40, 'test_region_id' => 9, "from" => date('Y-m-d')];

        return array_intersect_key($data, array_flip($keys));
    }
}
