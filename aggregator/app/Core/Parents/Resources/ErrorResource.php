<?php

namespace App\Core\Parents\Resources;

use App\Core\Contracts\Resource\IResource;
use Illuminate\Http\JsonResponse;
use Throwable;

class ErrorResource implements IResource
{
    /**
     * @var Throwable
     */
    protected Throwable $exception;

    /**
     * @var mixed
     */
    protected mixed $detail;

    /**
     * @param Throwable $exception
     * @param mixed|null $detail
     */
    public function __construct(Throwable $exception, mixed $detail = null)
    {
        $this->exception = $exception;
        $this->detail = $detail;
    }

    /**
     * @inheritDoc
     */
    public function toArray()
    {
        $fields = [
            "id" => null,
            "links" => null,
            "type" => null,
            "status" => $this->exception->getCode(),
            "code" => null,
            "title" => $this->exception->getMessage(),
            "detail" => $this->detail,
            "source" => null,
            "pointer" => null,
            "parameter" => null,
            "header" => null,
            "meta" => null
        ];

        $result = [];

        foreach ($fields as $fieldKey => $field) {

            if (is_null($field) && method_exists($this->exception, $fieldKey)) {
                $payload = $this->exception?->$fieldKey();
            } else {
                $payload = $field;
            }

            if (!empty($payload)) {
                $result["errors"][$fieldKey] = $payload;
            }

        }

        return $result;
    }

    /**
     * @inheritDoc
     */
    public function toResponse($request)
    {
        return new JsonResponse($this->toArray(), $this->exception->getCode());
    }

    /**
     * @inheritDoc
     */
    public function jsonSerialize(): mixed
    {
        return json_encode($this->toArray());
    }
}
