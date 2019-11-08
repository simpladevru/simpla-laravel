<?php

namespace App\Entity\Shop\Feature;

use App\Helpers\Tables;
use Illuminate\Database\Eloquent\Model;
use App\Entity\Shop\Catalog\Category\Category;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Feature extends Model
{
    protected $table = Tables::SHOP_FEATURES;

    protected $guarded = ['id'];

    protected $fillable = ['name', 'in_filter', 'sort'];

    /**
     * @return BelongsToMany
     */
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, Tables::SHOP_CATEGORY_FEATURES, 'feature_id', 'category_id');
    }
}
