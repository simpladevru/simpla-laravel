<?php

namespace App\Entity\Shop\Catalog\Feature;

use Illuminate\Database\Eloquent\Builder;

trait Scopes
{
    /**
     * @param Builder $query
     * @param string $name
     */
    public function scopeWhereNameLike(Builder $query, string $name)
    {
        $words = explode(' ', $name);

        foreach ($words as $word) {
            $word = trim($word);

            if ($word) {
                $query->where('name', 'like', '%' . $word . '%');
            }
        }
    }
}
