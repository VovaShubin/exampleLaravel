<?php

namespace App\Modules\TestSystemsIntegrations\Test\Communication;


use Carbon\Carbon;
use Psr\Http\Client\ClientExceptionInterface;
use Psr\Http\Client\ClientInterface;
use Throwable;

class Server implements ServerCommunication
{
    private FrontApi $frontApi;
    private SyncApi $syncApi;
    private int $test;

    public function __construct(int $test)
    {
        $this->withTest($test);
    }

    public function withTest(int $test): self
    {
        /**@var ClientInterface $client */
        $client = ClientFactory::make($test);
        $this->test = $test;
        $this->frontApi = new FrontApi($client);
        $this->syncApi = new SyncApi($client);
        $this->docApi = new DocApi($client);
        return $this;
    }

    public function sendPayment(array $payload): array
    {
        /** @var SendPaymentTask $action */
        $task = app(SendPaymentTask::class);
        return $task->run($this->docApi, $payload);
    }


    /**@throws Throwable */
    public function reserve(array $payload = []): mixed
    {
        /** @var ReserveTask $task */
        $task = app(ReserveTask::class);
        return $task->run($this->testApi, $this->docApi, $payload);
    }

    /**@throws ClientExceptionInterface|Throwable */
    public function confirmReserve(array $payload): array
    {
        /** @var ConfirmReserveTask $task */
        $task = app(ConfirmReserveTask::class);
        return $task->run($this->testApi, $payload);
    }


    /**@throws Throwable */
    public function import(array $selectedEntities = [], array $selectedShipUids = []): iterable
    {
        /** @var ImportAction $action */
        $action = app(ImportAction::class);
        return $action->run(
            $this->frontApi,
            $this->test,
            $selectedEntities,
            $selectedShipUids
        );
    }

    /**@throws Throwable */
    public function sync(array $selectedEntities = []): iterable
    {
        /** @var SyncAction $action */
        $action = app(SyncAction::class);
        return $action->run(
            $this->frontApi,
            $this->syncApi,
            $this->docApi,
            $this->test,
            $selectedEntities
        );
    }

    public function orders(array $payload): array
    {
        return [];
    }
}
