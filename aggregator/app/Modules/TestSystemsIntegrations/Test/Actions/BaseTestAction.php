<?php

namespace App\Modules\TestSystemsIntegrations\Test\Actions;

use App\Core\Logger\LoggerManager;
use App\Modules\DataAggregation\Content\Actions\Test;

abstract class BaseTestAction
{
    protected readonly LoggerManager $loggerManager;

    public function __construct() {
        $this->loggerManager = app(LoggerManager::class);
    }

    protected function regions(int $testSystemId): array
    {
        /** @var TestServer $test */
        $testServer = app(TestServer::class);
        $testSettings = $testServer->getSettingsByTest($test);
        return array_filter(explode(",", $test["test"]));
    }

    protected function filterAndPrepareEntitiesMap($entitiesMap, $selectedEntities): array
    {
        foreach ($entitiesMap as $entityMapKey => $entities) {

            if (in_array($entityMapKey, $selectedEntities)) { // filter only selected entities

                $value = is_callable($entities) ? $entities() : $entities; //! performing requests to bs to get entities' values, or get generators in some cases

                $result[$entityMapKey] = $value;
            }
        }
        return $result ?? [];
    }
}
