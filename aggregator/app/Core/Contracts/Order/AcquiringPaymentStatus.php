<?php

namespace App\Core\Contracts\TestOrder;

interface AcquiringPaymentStatus
{
    //Успешно оплачен
    const SUCCEEDED_STATUS = 'Succeeded';
    //Отменен
    const CANCELED_STATUS = 'Canceled';
    //Ожидает оплаты
    const PENDING_STATUS = 'Pending';
}
