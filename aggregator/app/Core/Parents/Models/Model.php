<?php

namespace App\Core\Parents\Models;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasOne;


/**
 * @method static Builder byTestSystem(array $data)
 * @method Builder active
 * @method Builder visible
 * @method Builder withRating
 * @method Builder withReviewsCount
 */
abstract class Model extends \Illuminate\Database\Eloquent\Model
{
    /**
     * @param Arrayable $object
     * @return static
     */
    public static function makeFromDto(Arrayable $object): static
    {
        return new static($object->toArray());
    }

    /**
     * @param Builder $builder
     * @param array $data
     * @return Builder
     */
    public function scopeByTestSystem(Builder $builder, array $data): Builder
    {
        $wheres = [];

        if ($data["test"] ?? null) {
            $wheres[] = ["test", $data["test"]];
        }

        if ($data["test1"] ?? null) {
            $wheres[] = ["test1", $data["test1"]];
        }

        return $builder->where($wheres);
    }

    /**
     * @param Builder $builder
     * @return Builder
     */
    public function scopeActive(Builder $builder): Builder
    {
        return $builder->where("is_active", 1);
    }

    /**
     * @param Builder $builder
     * @return Builder
     */
    public function scopeVisible(Builder $builder): Builder
    {
        return $builder->where("is_hidden", 0);
    }


    public function getSortParams(): array
    {
        return $this->getFillable(); // by default
    }


    public function isActive(): bool
    {
        return $this->is_active;
    }

    public function isVisible(): bool
    {
        return !$this->is_hidden;
    }
}
