<?php

namespace App\Core\Parents\TestSystemsIntegrations\Dto\Items;

use App\Core\Contracts\TestOrder\TestOrderStatus;
use App\Core\Parents\Dto\Item;

abstract class BaseTestOrder extends Item implements TestOrderStatus
{
    public ?int $test_id = null;
    public ?string $test_uid = null;
    public ?string $status = null;
    public ?string $pay_date = null;
    /**
     * @inheritDoc
     */
    public function toArray()
    {
        return [
            'test_id' => $this->test_id,
            'test_uid' => $this->test_uid,
            'status' => $this->status,
            'pay_date' => $this->pay_date
        ];
    }
}
