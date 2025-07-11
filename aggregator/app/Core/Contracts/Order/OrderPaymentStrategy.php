<?php

namespace App\Core\Contracts\TestOrder;

interface OrderPaymentStrategy
{
    // 100% от стоимости
    const FULL_PAYMENT_STRATEGY = 'fullPayment';
    // 50% процентов от стоимости
    const HALF_PRICE_PAYMENT_STRATEGY = 'halfPricePayment';
    // 0% от стоимости
    const ZERO_PAYMENT_STRATEGY = 'zeroPayment';
}
