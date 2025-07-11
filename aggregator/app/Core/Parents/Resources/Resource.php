<?php

namespace App\Core\Parents\Resources;

use App\Core\Contracts\Resource\IResource;
use App\Core\Parents\Resources\Attributes\Relation;
use App\Core\Parents\Resources\Resolvers\Payload\ArraybleResourcePayloadResolver;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Request;

abstract class Resource implements IResource
{
    /**
     * @var ResourcePayload
     */
    protected ResourcePayload $resourcePayload;

    /**
     * @var ResourceMapper
     */
    protected ResourceMapper $resourceMapper;

    /**
     * @var Request|null
     */
    protected ?Request $request = null;

    /**
     * @var mixed
     */
    protected mixed $payload;

    /**
     * @var array|string[]
     */
    protected array $resourcePayloadResolvers = [
        ArraybleResourcePayloadResolver::class,
    ];

    /**
     * @param mixed $payload
     * @param ResourceMapper $resourceMapper
     */
    public function __construct(mixed $payload, ResourceMapper $resourceMapper)
    {
        $this->payload = $payload;

        $this->resourceMapper = $resourceMapper;

        $this->boot();
    }

    /**
     * @param mixed $payload
     * @param string $resourceMapperClass
     * @return self
     */
    public static function make(mixed $payload, string $resourceMapperClass): self
    {
        $resourceMapper = new $resourceMapperClass();

        return new static($payload, $resourceMapper);
    }

    /**
     * @param Request $request
     * @return $this
     */
    public function withRequest(Request $request): self
    {
        $this->request = $request;

        return $this;
    }

    /**
     * @param $request
     * @return JsonResponse
     */
    public function toResponse($request)
    {
        return new JsonResponse($this->toArray());
    }

    /**
     * @return mixed
     */
    public function jsonSerialize(): mixed
    {
        return json_encode($this->toArray());
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        $resourceId = $this->resourceMapper->id($this->resourcePayload->data());
        $result["data"] = $resourceId // if no resource id provided then don't fill data member
            ? ["id" => $resourceId, "type" => $this->resourceMapper->type()]
            : [];

        $request = $this->request ?: request();

        $data = $this->resourceMapper->data($this->resourcePayload->data(), $this->request) ?? [];
        $relations = array_filter($data, fn($item) => $item instanceof Relation);
        $this->prepare($this->resourceMapper->jsonapi($this->resourcePayload->data(), $this->request) ?? [], $result);
        $this->prepare($data, $result["data"]);
        $this->prepare($this->resourceMapper->links($this->resourcePayload->data(), $this->request) ?? [], $result);
        $this->prepare($this->resourceMapper->meta($this->resourcePayload->data(), $this->request) ?? [], $result);
        $this->prepare($this->resourceMapper->errors($this->resourcePayload->data(), $this->request) ?? [], $result);

        $result["meta"] = array_merge(
            $this->resourcePayload->meta(),
            $result["meta"] ?? []
        );

        $result["links"] = array_merge(
            $this->resourcePayload->links(),
            $result["links"] ?? []
        );

        foreach ($relations as $relation) {
            $data = $relation->toIncluded();
            if(!empty($data)){
                foreach ($data as $item){
                    $result["included"][$item['type'].$item['id']] = $item;
                }
            }
        }

        if(!empty($result["included"] ?? [])){
            usort($result["included"], fn($a, $b) => $a["type"] <=> $b["type"]);
        }

        if(empty($result["data"]["test"])){
            unset($result["data"]["test"]);
        }

        return array_filter($result, fn($item) => !empty($item));
    }

    /**
     * @param $data
     * @param $pusher
     * @return void
     */
    protected function prepare($data, &$pusher): void
    {
        foreach ($data as $item) {
            if (!empty($item)) {
                $pusher[$item->container()] = array_merge($item->toArray(), $pusher[$item->container()] ?? []);
            }
        }
    }

    /**
     * @return void
     */
    protected function boot(): void
    {
        foreach ($this->resourcePayloadResolvers as $resourcePayloadResolver) {

            $resolver = new $resourcePayloadResolver();

            /**
             * @var ResourcePayload|null $result
             */
            $result = $resolver->resolve($this->payload);

            if ($result instanceof ResourcePayload) {

                $this->resourcePayload = $result;

            }
        }

        if (!isset($this->resourcePayload)) {
            throw new \InvalidArgumentException("payload type is unsupported");
        }
    }
}
