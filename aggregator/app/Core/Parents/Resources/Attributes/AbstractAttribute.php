<?php

namespace App\Core\Parents\Resources\Attributes;

use App\Core\Contracts\Resource\IAttribute;

abstract class AbstractAttribute implements IAttribute
{
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
     * @param string $key
     * @param mixed $value
     * @param string|null $type
     */
    public function __construct(string $key, mixed $value, ?string $type = null)
    {
        $this->key = $key;
        $this->value = $value;
        $this->type = $type;
    }

    /**
     * @param ...$params
     * @return $this
     */
    public static function make(...$params): self
    {
        return new static(...$params);
    }

    /**
     * @return mixed
     */
    public function value(): mixed
    {
        return $this->value;
    }

    /**
     * @return string
     */
    public function key(): string
    {
        return $this->key;
    }

    /**
     * @return string
     */
    public function type(): string
    {
        return $this->type;
    }

    /**
     * @param \Closure $closure
     * @return self
     */
    public function format(\Closure $closure): self
    {
        $this->value = $closure($this->value);

        return $this;
    }
}
