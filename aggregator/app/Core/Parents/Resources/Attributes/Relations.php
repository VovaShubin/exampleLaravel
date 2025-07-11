<?php

namespace App\Core\Parents\Resources\Attributes;

use Closure;

class Relations extends Relation
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
     * @return void
     */
    protected function init(): void
    {
        $this->calls["data"] = fn($value) => [
            Attribute::make("id", $value["id"]),
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

    /**
     * @param Closure $closure
     * @return $this
     */
    public function relations(Closure $closure): self
    {
        $this->calls["relationships"] = $closure;

        return $this;
    }

    public function attributes(Closure $closure): self
    {
        $this->calls["attributes"] = $closure;

        return $this;
    }

    /**
     * @return array[]
     */
    public function toArray(): array
    {
        if (is_null($this->value)) {
            return [];
        }

        foreach ($this->calls as $key => $call) {

            if ($key != "attributes") {

                foreach ($this->value as $index => $valueItem) {

                    $data = $call($valueItem);

                    foreach ($data as $item) {

                        if ($item instanceof AbstractAttribute) {
                            $item = $item->toArray();
                        }

                        if($key == 'relationships'){
                            if(!empty($item)){
                                $result[$this->key][$index][$key] = array_merge($result[$this->key][$index][$key] ?? [], $item);
                            }
                        }else{
                            $result[$this->key][$index][$key] = array_merge($result[$this->key][$index][$key] ?? [], $item);
                        }

                    }
                }
            }
        }

        return $result ?? [];
    }

    /**
     * @return array
     */
    public function toIncluded(): array
    {
        if (is_null($this->value) || !$this->include()) {
            return [];
        }

        $extendIncluded = [];

        foreach ($this->calls as $key => $call) {

            foreach ($this->value as $index => $valueItem) {

                $data = $call($valueItem);

                if ($key == 'relationships') {
                    $subRelations = $call($valueItem);
                    foreach ($subRelations as $subRelation) {
                        if ($subRelation instanceof Relation && $subRelation->include()) {
                            if (!empty($subRelation->toIncluded())) {
                                $extendIncluded = array_merge($extendIncluded,  $subRelation->toIncluded());
                            }
                        }
                    }
                }

                foreach ($data as $item) {

                    if ($item instanceof Relation && !$item->include()) {
                        continue;
                    }

                    if ($item instanceof AbstractAttribute) {
                        $item = $item->toArray();
                    }

                    if ($key == 'data') {
                        $result[$index] = array_merge($result[$index] ?? [], $item);
                    } else {
                        $result[$index][$key] = array_merge($result[$index][$key] ?? [], $item);
                    }

                }
            }
        }

        $result = array_merge($result ?? [], $extendIncluded ?? []);

        $result = array_map(function($item){
            if(empty($item['relationships'] ?? null)){
                unset($item['relationships']);
            }
            return $item;
        }, $result);

        return $result ?? [];
    }
}
