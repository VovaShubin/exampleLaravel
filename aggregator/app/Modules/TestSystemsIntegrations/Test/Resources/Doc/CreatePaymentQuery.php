<?php

namespace App\Modules\Test\Resources\Doc;

use App\Core\Parents\TestSystemsIntegrations\BasicQuery;

class CreatePaymentQuery extends BasicQuery
{
    protected string $url = "https://test";
    protected string $method = "POST";
    protected array $headers = ["content-type" => "application/json"];

    protected function expectPayloadKeys(): array
    {
        return [
            'order_id', //Уникальный ID заказа.
            'date', //Дата платёжного документа.1
            'number', //Номер платёжного документа.
            'sum', //Сумма платежа.
            'way', //Способ платежа: 0 - платеж наличными, 1 - платеж банковским переводом, 2 - взаимозачет, 3 - платеж он-лайн.
            'rec_id', //Уникальный ID платёжного документа.
        ];
    }

    protected function bindBody(): void
    {
        $data = [[
            'OrderID' => $this->payload['order_id'],
            'Date' => $this->payload['date'],
            'Number' => $this->payload['number'],
            'Sum' => $this->payload['sum'],
            'Way' => $this->payload['way'],
            'Note' => $this->payload['note'] ?? '',
            'RecID' => $this->payload['rec_id'],
        ]];
        $this->body = json_encode($data);
    }
}
