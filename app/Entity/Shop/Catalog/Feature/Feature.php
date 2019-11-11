<?php

namespace App\Entity\Shop\Catalog\Feature;

use App\Helpers\Tables;
use Illuminate\Database\Eloquent\Model;
use App\Entity\Shop\Catalog\Category\Category;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * App\Entity\Shop\Catalog\Feature\Feature
 *
 * @property int $id
 * @property string $name
 * @property int $in_filter
 * @property int $sort
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Kalnoy\Nestedset\Collection|\App\Entity\Shop\Catalog\Category\Category[] $categories
 * @property-read int|null $categories_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Catalog\Feature\Feature newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Catalog\Feature\Feature newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Catalog\Feature\Feature query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Catalog\Feature\Feature whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Catalog\Feature\Feature whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Catalog\Feature\Feature whereInFilter($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Catalog\Feature\Feature whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Catalog\Feature\Feature whereNameLike($name)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Catalog\Feature\Feature whereSort($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Catalog\Feature\Feature whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Feature extends Model
{
    use Scopes;

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
