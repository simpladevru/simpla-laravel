<?php

namespace App\Entity\Shop\Catalog\Feature;

use App\Helpers\Tables;
use Illuminate\Database\Query\Expression;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\Builder as QueryBuilder;

trait Scopes
{
    /**
     * @param Builder $query
     * @param array $ids
     */
    public function scopeWhereJoinedCategory(Builder $query, array $ids)
    {
        $query->whereExists(function (QueryBuilder $query) use ($ids) {
            $query
                ->selectRaw('1')
                ->from(Tables::SHOP_CATEGORY_FEATURES)
                ->where('feature_id', new Expression(Tables::SHOP_FEATURES . '.id'))
                ->whereIn('category_id', $ids);
        });
    }

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
