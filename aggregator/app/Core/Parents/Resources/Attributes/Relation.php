<?php

namespace App\Core\Parents\Resources\Attributes;

use Closure;

class Relation extends AbstractAttribute
{
    const PAYLOAD_KEY = "relationships";

    /**
     * @var string
     */
    protected string $key;

    /**
     * @var mixed
     */
    protected mixed $value;

    /**
     * @var string|null
     */
    protected ?string $type;

    /**
     * @var Closure[]
     */
    protected array $calls = [];

    /**
     * @var bool
     */
    protected bool $include = true;

    /**
     * @param string $key
     * @param mixed $value
     * @param string|null $type
     */
    public function __construct(string $key, mixed $value, ?string $type = null)
    {
        parent::__construct($key, $value, $type);

        $this->init();
    }

    /**
     * @return $this
     */
    public function withoutInclude(): self
    {
        $this->include = false;

        return $this;
    }

    /**
     * @return bool
     */
    public function include(): bool
    {
        return $this->include;
    }

    /**
     * @return void
     */
    protected function init(): void
    {
        $this->calls["data"] = fn() => [
            Attribute::make("id", $this->value["id"] ?? null),
            Attribute::make("type", $this->type ?? $this->key)
        ];
    }

    /**
     * @param Closure $closure
     * @return self
     */
    public function data(Closure $closure): self
    {
        $this->calls["data"] = $closure;

        return $this;
    }

    /**
     * @param Closure $closure
     * @return self
     */
    public function meta(Closure $closure): self
    {
        $this->calls["meta"] = $closure;

        return $this;
    }

    /**
     * @param Closure $closure
     * @return self
     */
    public function links(Closure $closure): self
    {
        $this->calls["links"] = $closure;

        return $this;
    }

    public function attributes(Closure $closure): self
    {
        $this->calls["attributes"] = $closure;

        return $this;
    }

    /**
     * @param Closure $closure
     * @return $this
     */
    public function relations(Closure $closure): self
    {
        $this->calls["relationships"] = $closure;

        return $this;
    }

    /**
     * @return array[]
     */
    public function toArray(): array
    {
        if(is_null($this->value)){
            return [];
        }

        foreach ($this->calls as $key => $call) {

            if ($key != "attributes") {

                $data = $call($this->value);

                foreach ($data as $item) {

                    if ($item instanceof AbstractAttribute) {
                        $item = $item->toArray();
                    }

                    $result[$this->key][$key] =
                        array_merge($result[$this->key][$key] ?? [], $item);

                }
            }
        }

        if(isset($result[$this->key]['relationships']) && empty($result[$this->key]['relationships'])){
            unset($result[$this->key]['relationships']);
        }

        return $result ?? [];
    }

    /**
     * @return array
     */
    public function toIncluded(): array
    {
        if(is_null($this->value) || !$this->include()){
            return [];
        }

        $extendIncluded = [];

        foreach ($this->calls as $key => $call) {

            $data = $call($this->value);

            if ($key == 'relationships') {
                $subRelations = $call($this->value);
                foreach ($subRelations as $subRelation) {
                    if ($subRelation instanceof Relation && $subRelation->include()) {
                        if (!empty($subRelation->toIncluded())) {
                            $extendIncluded = array_merge($extendIncluded,  $subRelation->toIncluded());
                        }
                    }
                }
            }

            foreach ($data as $item) {

                if($item instanceof Relation && !$item->include()){
                    continue;
                }

                if ($item instanceof AbstractAttribute) {
                    $item = $item->toArray();
                }

                $result[$key] = array_merge($result[$key] ?? [], $item);

            }
        }

        $data = $result["data"];

        $result = array_merge($data, $result);

        unset($result["data"]);

        $result = array_merge([$result], $extendIncluded);

        return array_map(function($item){
            if(empty($item['relationships'] ?? null)){
                unset($item['relationships']);
            }
            return $item;
        }, $result);
    }

    /**
     * @return string
     */
    public function container(): string
    {
        return "relationships";
    }
}
