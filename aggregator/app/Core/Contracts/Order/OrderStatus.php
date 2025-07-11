<?php

namespace App\Core\Contracts\TestOrder;

interface TestOrderStatus
{
    //Заказ создан
    const CREATED_STATUS = 'Created';
    //Ожидает оплаты
    const PENDING_STATUS = 'Pending';
    //Оплачен
    const SUCCEEDED_STATUS = 'Succeeded';
    //Отменен
    const CANCELED_STATUS = 'Canceled';
    //Завершен с ошибкой
    const FAILED_STATUS = 'Failed';
    //Завершен успешно
    const COMPLETED_STATUS = 'Completed';
    //Частично оплачен
    const PARTIALLY_STATUS = 'Partially';
}
