<?php

namespace App\Modules\Test\Data\Dto;

use App\Core\Contracts\TestOrder\TestOrderStatus;

use App\Core\Parents\TestSystemsIntegrations\Dto\Items\BaseTestOrder;
use Carbon\Carbon;

class TestOrder extends BaseTestOrder
{
    private array $bindingTestPaymentStatusToAggregatorStatus = [

        1 => TestOrderStatus::PENDING_STATUS,
        //Снят
        2 => TestOrderStatus::CANCELED_STATUS,
        //Оплачен
        3 => TestOrderStatus::SUCCEEDED_STATUS,
    ];

    protected function bind(array $payload): void
    {
        if ($testStatus = $payload['TestOrderStatus']) {
            $this->status = $this->bindingTestPaymentStatusToAggregatorStatus[$testStatus];
        }
        $this->test_uid = $payload['ID'] ?? null;
        $this->test_id = $payload['test_id'] ?? null;
        $this->pay_date = $payload['DateToPay'] ? Carbon::parse($payload['DateToPay']) : null;
    }
}
