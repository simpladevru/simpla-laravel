<?php

namespace App\Entity\Shop\Feature;

use Illuminate\Database\Eloquent\Model;
use App\Entity\Shop\Catalog\Category\Category;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * Class Feature
 *
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Feature newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Feature newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Feature query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Feature whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Feature whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Feature whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Feature whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Feature extends Model
{
    protected $guarded = ['id'];

    protected $fillable = ['name', 'in_filter', 'sort'];

    /**
     * @return BelongsToMany
     */
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'category_features', 'feature_id', 'category_id');
    }
}
