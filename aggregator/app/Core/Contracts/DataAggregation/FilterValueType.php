<?php

namespace App\Core\Contracts\DataAggregation;

enum FilterValueType: string
{
    case Value = 'value';
    case Values = 'values';
    case Range = 'range';
    case Entities = 'entities';
}
