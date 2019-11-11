<?php

// @formatter:off
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Entity\Blog{
/**
 * App\Entity\Blog\Post
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Blog\Post newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Blog\Post newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Blog\Post query()
 * @mixin \Eloquent
 */
	class Post extends \Eloquent {}
}

namespace App\Entity\Shop\Catalog{
/**
 * Class Brand
 *
 * @property int $id
 * @property string $name
 * @property string|null $slug
 * @property string|null $image
 * @property string|null $description
 * @property string|null $meta_title
 * @property string|null $meta_keywords
 * @property string|null $meta_description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Brand\Brand newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Brand\Brand newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Brand\Brand query()
 * @method static \Illuminate\Database\Eloquent\Builder|Brand\Brand whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Brand\Brand whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Brand\Brand whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Brand\Brand whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Brand\Brand whereMetaDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Brand\Brand whereMetaKeywords($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Brand\Brand whereMetaTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Brand\Brand whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Brand\Brand whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Brand\Brand whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class Brand extends \Eloquent {}
}

namespace App\Entity\Shop\Feature{
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
 * @property int $in_filter
 * @property int $sort
 * @property-read \Kalnoy\Nestedset\Collection|\App\Entity\Shop\Catalog\Category\Category[] $categories
 * @property-read int|null $categories_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Catalog\Feature\Feature whereInFilter($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Catalog\Feature\Feature whereSort($value)
 */
	class Feature extends \Eloquent {}
}

namespace App\Entity\Shop\Catalog\Product\Attribute{
/**
 * App\Entity\Shop\Catalog\Product\Attribute\Attribute
 *
 * @property int $id
 * @property int $product_id
 * @property int $feature_id
 * @property string $value
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Catalog\Product\Attribute\Attribute newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Catalog\Product\Attribute\Attribute newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Catalog\Product\Attribute\Attribute query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Catalog\Product\Attribute\Attribute whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Catalog\Product\Attribute\Attribute whereFeatureId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Catalog\Product\Attribute\Attribute whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Catalog\Product\Attribute\Attribute whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Catalog\Product\Attribute\Attribute whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Catalog\Product\Attribute\Attribute whereValue($value)
 */
	class Attribute extends \Eloquent {}
}

namespace App\Entity\Shop\Catalog\Product\Comment{
/**
 * App\Entity\Shop\Catalog\Product\Comment\Comment
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Catalog\Product\Comment\Comment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Catalog\Product\Comment\Comment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Catalog\Product\Comment\Comment query()
 */
	class Comment extends \Eloquent {}
}

namespace App\Entity\Shop\Catalog\Product\Image{
/**
 * App\Entity\Shop\Catalog\Product\Image\Image
 *
 * @property int $id
 * @property int $product_id
 * @property string $file
 * @property int $sort
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Catalog\Product\Image\Image newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Catalog\Product\Image\Image newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Catalog\Product\Image\Image query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Catalog\Product\Image\Image whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Catalog\Product\Image\Image whereFile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Catalog\Product\Image\Image whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Catalog\Product\Image\Image whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Catalog\Product\Image\Image whereSort($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Catalog\Product\Image\Image whereUpdatedAt($value)
 */
	class Image extends \Eloquent {}
}

namespace App\Entity\Shop\Catalog\Product\Product\Pivot{
/**
 * App\Entity\Shop\Catalog\Product\Product\Pivot\CategoryPivot
 *
 * @property int $product_id
 * @property int $category_id
 * @property int $sort
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Catalog\Product\Product\Pivot\CategoryPivot newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Catalog\Product\Product\Pivot\CategoryPivot newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Catalog\Product\Product\Pivot\CategoryPivot query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Catalog\Product\Product\Pivot\CategoryPivot whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Catalog\Product\Product\Pivot\CategoryPivot whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Catalog\Product\Product\Pivot\CategoryPivot whereSort($value)
 */
	class CategoryPivot extends \Eloquent {}
}

namespace App\Entity\Shop\Catalog\Product\Product{
/**
 * App\Entity\Shop\Catalog\Product\Product\Product
 *
 * @property int $id
 * @property string $name
 * @property string|null $slug
 * @property int|null $brand_id
 * @property int|null $is_active
 * @property int|null $is_featured
 * @property string|null $annotation
 * @property string|null $description
 * @property string|null $meta_title
 * @property string|null $meta_keywords
 * @property string|null $meta_description
 * @property int|null $sort
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entity\Shop\Catalog\Product\Attribute\Attribute[] $attributes
 * @property-read int|null $attributes_count
 * @property-read \Kalnoy\Nestedset\Collection|\App\Entity\Shop\Catalog\Category\Category[] $categories
 * @property-read int|null $categories_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entity\Shop\Catalog\Product\Product\Pivot\CategoryPivot[] $categoryPivot
 * @property-read int|null $category_pivot_count
 * @property-read \App\Entity\Shop\Catalog\Product\Image\Image $image
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entity\Shop\Catalog\Product\Image\Image[] $images
 * @property-read int|null $images_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entity\Shop\Catalog\Product\Variant\Variant[] $variants
 * @property-read int|null $variants_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Catalog\Product\Product\Product newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Catalog\Product\Product\Product newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Catalog\Product\Product\Product query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Catalog\Product\Product\Product whereAnnotation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Catalog\Product\Product\Product whereBrandId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Catalog\Product\Product\Product whereBrandIds($ids)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Catalog\Product\Product\Product whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Catalog\Product\Product\Product whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Catalog\Product\Product\Product whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Catalog\Product\Product\Product whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Catalog\Product\Product\Product whereIsFeatured($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Catalog\Product\Product\Product whereJoinedCategory($ids)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Catalog\Product\Product\Product whereJoinedCategoryNested($ids)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Catalog\Product\Product\Product whereMetaDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Catalog\Product\Product\Product whereMetaKeywords($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Catalog\Product\Product\Product whereMetaTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Catalog\Product\Product\Product whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Catalog\Product\Product\Product whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Catalog\Product\Product\Product whereSort($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Catalog\Product\Product\Product whereUpdatedAt($value)
 */
	class Product extends \Eloquent {}
}

namespace App\Entity\Shop\Catalog\Product\Variant{
/**
 * App\Entity\Shop\Catalog\Product\Variant\Variant
 *
 * @property int $id
 * @property int|null $product_id
 * @property string|null $name
 * @property string|null $sku
 * @property int|null $stock
 * @property float|null $price
 * @property float|null $compare_price
 * @property int|null $sort
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Catalog\Product\Variant\Variant newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Catalog\Product\Variant\Variant newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Catalog\Product\Variant\Variant query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Catalog\Product\Variant\Variant whereComparePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Catalog\Product\Variant\Variant whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Catalog\Product\Variant\Variant whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Catalog\Product\Variant\Variant whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Catalog\Product\Variant\Variant wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Catalog\Product\Variant\Variant whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Catalog\Product\Variant\Variant whereSku($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Catalog\Product\Variant\Variant whereSort($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Catalog\Product\Variant\Variant whereStock($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Catalog\Product\Variant\Variant whereUpdatedAt($value)
 */
	class Variant extends \Eloquent {}
}

namespace App\Entity\Shop\Order{
/**
 * App\Entity\Shop\Order\Coupon
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Order\Coupon newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Order\Coupon newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Order\Coupon query()
 * @mixin \Eloquent
 */
	class Coupon extends \Eloquent {}
}

namespace App\Entity\Order{
/**
 * App\Entity\Order\Label
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Order\Label newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Order\Label newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Order\Label query()
 * @mixin \Eloquent
 */
	class Label extends \Eloquent {}
}

namespace App\Entity\Order{
/**
 * App\Entity\Order\Order
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Order\Order newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Order\Order newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Order\Order query()
 * @mixin \Eloquent
 */
	class Order extends \Eloquent {}
}

namespace App\Entity\Order{
/**
 * App\Entity\Order\Purchase
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Order\Purchase newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Order\Purchase newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Order\Purchase query()
 * @mixin \Eloquent
 */
	class Purchase extends \Eloquent {}
}

namespace App\Entity\Shop{
/**
 * App\Entity\Shop\Currency
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Currency newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Currency newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Currency query()
 * @mixin \Eloquent
 */
	class Currency extends \Eloquent {}
}

namespace App\Entity\Shop{
/**
 * App\Entity\Shop\Delivery
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Delivery newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Delivery newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Delivery query()
 * @mixin \Eloquent
 */
	class Delivery extends \Eloquent {}
}

namespace App\Entity\Shop{
/**
 * App\Entity\Shop\PaymentMethod
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\PaymentMethod newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\PaymentMethod newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\PaymentMethod query()
 * @mixin \Eloquent
 */
	class PaymentMethod extends \Eloquent {}
}

namespace App\Entity\Site{
/**
 * App\Entity\Site\Feedback
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Site\Feedback newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Site\Feedback newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Site\Feedback query()
 * @mixin \Eloquent
 */
	class Feedback extends \Eloquent {}
}

namespace App\Entity\Site{
/**
 * App\Entity\Site\Page
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Site\Page newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Site\Page newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Site\Page query()
 * @mixin \Eloquent
 */
	class Page extends \Eloquent {}
}

namespace App{
/**
 * App\User
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class User extends \Eloquent {}
}

