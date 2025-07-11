<?php

namespace App\Core\Parents\Rules;

use App\Core\Parents\Models\Model;
use Closure;

class SortParamsValidationRule implements ValidationRule
{
    public function __construct(
        protected readonly string $modelClassName = '',
    )
    {
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        /** @var Model $model */
        $model = new $this->modelClassName();

        $availableSortParams = array_merge(
            $model->getSortParams(),    // can sort by model's sort params
            [$model->getKeyName()],   // can sort by model's id
            [ /* add any supported sort params here */]
        );


        $sortParams = str_replace('-', '', array_unique(array_filter(explode(',', $value))));

        if (!empty($diff = array_diff($sortParams, $availableSortParams))) {

            $fail('Unsupported values ' . implode(', ', $diff) . ' for :attribute');
        };
    }
}
