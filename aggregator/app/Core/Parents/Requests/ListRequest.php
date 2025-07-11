<?php

namespace App\Core\Parents\Requests;

abstract class ListRequest extends Request
{
    /**
     * @inheritDoc
     */
    public function rules(): array
    {
        return [
            "perPage" => ["numeric"],
            "pageName" => ["string"],
            "columns"  => ["array"],
            "page" => ["numeric"],
        ];
    }

    /**
     * @return void
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            "page" => $this->page ?? 1,
            "perPage" => $this->size ?? 10,
            "pageName" => "page",
            "columns" => ["*"]
        ]);
    }

    public function attributes(): array
    {
        return [
            'perPage' => 'size',
        ];
    }
}
