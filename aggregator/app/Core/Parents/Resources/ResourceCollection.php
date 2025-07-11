<?php

namespace App\Core\Parents\Resources;

use App\Core\Contracts\Resource\IResourceCollection;
use App\Core\Parents\Resources\Attributes\Relation;
use App\Core\Parents\Resources\Resolvers\Payload\ArraybleResourcePayloadResolver;
use App\Core\Parents\Resources\Resolvers\Payload\PaginatorResourcePayloadResolver;

class ResourceCollection extends Resource implements IResourceCollection
{
    /**
     * @var array|string[]
     */
    protected array $resourcePayloadResolvers = [
        ArraybleResourcePayloadResolver::class,
        PaginatorResourcePayloadResolver::class
    ];

    /**
     * @return array
     */
    public function toArray(): array
    {
        $payloads = array_values($this->resourcePayload->data() ?? []);

        $allRelations = [];

        $this->prepare($this->resourceMapper->jsonapi([], $this->request) ?? [], $result);

        foreach ($payloads as $payload) {

            $item = [
                "id" => $this->resourceMapper->id($payload),
                "type" => $this->resourceMapper->type()
            ];

            $data = $this->resourceMapper->data($payload, $this->request) ?? [];

            $relations = array_filter($data, fn($item) => $item instanceof Relation);

            $allRelations = array_merge($allRelations, $relations);

            $this->prepare($data, $item);
            $this->prepare($relations, $item);
            $this->prepare($this->resourceMapper->errors($payload, $this->request) ?? [], $result);
            if(empty($item["data"]["test"])){
                unset($item["data"]["test"]);
            }
            $result["data"][] = $item;
        }

        $this->prepare($this->resourceMapper->links($payloads, $this->request) ?? [], $result);

        $this->prepare($this->resourceMapper->meta($payloads, $this->request) ?? [], $result);

        $result["meta"] = array_merge(
            $this->resourcePayload->meta(),
            $result["meta"] ?? []
        );

        $result["links"] = array_merge(
            $this->resourcePayload->links(),
            $result["links"] ?? []
        );

        foreach ($allRelations as $relation) {
            $data = $relation->toIncluded();
            if (!empty($data)) {
                foreach ($data as $item){
                    $result["included"][$item['type'].$item['id']] = $item;
                }
            }
        }

        if (!empty($result["included"] ?? [])) {
            usort($result["included"], fn($a, $b) => $a["type"] <=> $b["type"]);
        }

        return array_filter($result, fn($item) => !empty($item));
    }

}
