<?php

namespace App\Core\Data\Models;

use App\Core\Parents\Models\Model;

class Log extends Model
{
    const EMERGENCY_LEVEL = 'Emergency';
    const ALERT_LEVEL = 'Alert';
    const CRITICAL_LEVEL = 'Critical';
    const ERROR_LEVEL = 'Error';
    const WARNING_LEVEL = 'Warning';
    const INFO_LEVEL = 'Info';
    const DEBUG_LEVEL = 'Debug';
    const NOTICE_LEVEL = 'Notice';


    //Агрегатор не дает создать заказ
    const FAILED_AGGREGATOR_ORDER_TARGET = 'aggregator_failed_orders';

    const COMMON_TARGET = 'commons';

    protected $casts = [
        'context' => 'array'
    ];

    protected $fillable = [
        'target',
        'message',
        'context',
        'level'
    ];
}
