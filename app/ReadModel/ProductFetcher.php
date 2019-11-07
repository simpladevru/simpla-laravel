<?php

namespace App\ReadModel;

use App\Helpers\Tables;
use Illuminate\Support\Facades\DB;

class ProductFetcher
{
    public function getProductCountByCategoryLeftAndRight(array $intervals)
    {
        $products           = Tables::PRODUCTS;
        $product_categories = Tables::PRODUCT_CATEGORIES;
        $categories         = Tables::CATEGORIES;

        $select_count = DB::raw('COUNT(' . $products . '.id) as products_count');

        $query = DB::table($products)
            ->select($select_count)
            ->join(
                $product_categories,
                $product_categories . '.product_id',
                '=',
                $products . '.id'
            )
            ->join(
                $categories,
                $categories . '.id',
                '=',
                $product_categories . '.category_id'
            );

        foreach ($intervals as $interval) {
            $query->whereBetween($categories . '._lft', $interval);
        }

        $query->get();
    }
}
