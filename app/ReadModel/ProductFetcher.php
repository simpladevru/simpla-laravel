<?php

namespace App\ReadModel;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class ProductFetcher
{
    /**
     * @param array $ids
     * @return Collection
     */
    public function countByCategoryIds(array $ids)
    {
        $subSelect = DB::table('categories')
            ->selectRaw('count(distinct product_categories.product_id)')
            ->join('product_categories', 'product_categories.category_id', 'categories.id')
            ->whereRaw('categories._lft between c._lft and c._rgt')
            ->toSql();

        $counter = DB::table('categories', 'c')
            ->select('id', DB::raw("($subSelect) as count"))
            ->whereIn('id', $ids)
            ->get();

        return $counter->pluck('count', 'id');
    }
}
