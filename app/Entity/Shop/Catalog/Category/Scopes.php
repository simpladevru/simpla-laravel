<?php

namespace App\Entity\Shop\Catalog\Category;

use Illuminate\Database\Eloquent\Builder;

trait Scopes
{
    /**
     * @param Builder $query
     * @param $name
     * @return Builder
     */
    public function scopeWhereNameLike(Builder $query, $name)
    {
        return $query->where('name', 'like', '%' . $name . '%');
    }
}
