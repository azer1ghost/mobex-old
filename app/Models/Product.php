<?php

namespace App\Models;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Watson\Rememberable\Rememberable;

/**
 * App\Models\Product
 *
 * @property int $id
 * @property int|null $store_id
 * @property string|null $url
 * @property string|null $old_price
 * @property string|null $price
 * @property string|null $product
 * @property string|null $image
 * @property int $featured
 * @property string|null $start_at
 * @property string|null $end_at
 * @property string|null $deleted_at
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Category[] $categories
 * @property-read \App\Models\Store|null $store
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ProductTranslation[] $translations
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product listsTranslations($translationField)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product notTranslatedIn($locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product orWhereTranslation($key, $value, $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product orWhereTranslationLike($key, $value, $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product translated()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product translatedIn($locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereEndAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereFeatured($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereOldPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereProduct($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereStartAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereStoreId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereTranslation($key, $value, $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereTranslationLike($key, $value, $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product withTranslation()
 * @mixin \Eloquent
 * @property string|null $sale
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereSale($value)
 * @property-read int|null $categories_count
 * @property-read int|null $translations_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product query()
 */
class Product extends Model
{
    use Translatable;
    use Rememberable;

    public $uploadDir = 'uploads/products/';

    /**
     * @var array
     */
    public $translatedAttributes = ['name', 'description'];

    /**
     * @var array
     */
    public $with = ['store', 'translations', 'categories'];

    /**
     * @return mixed
     */
    public function store()
    {
        return $this->belongsTo('App\Models\Store')->withTrashed();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function categories()
    {
        return $this->belongsToMany('App\Models\Category', 'product_categories');
    }

    public function getImageAttribute($value)
    {
        return $value ? (str_contains($value, '//') ? $value : asset($this->uploadDir . $value)) : asset(config('ase.default.no-image'));
    }
}
