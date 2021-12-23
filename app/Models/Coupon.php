<?php

namespace App\Models;

use Carbon\Carbon;
use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Watson\Rememberable\Rememberable;

/**
 * App\Models\Coupon
 *
 * @property int $id
 * @property int|null $store_id
 * @property int|null $type_id
 * @property string|null $url
 * @property string|null $code
 * @property string|null $image
 * @property int $featured
 * @property string|null $start_at
 * @property string|null $end_at
 * @property string|null $deleted_at
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Category[] $categories
 * @property-read \App\Models\Store|null $store
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\CouponTranslation[] $translations
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Coupon listsTranslations($translationField)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Coupon notTranslatedIn($locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Coupon orWhereTranslation($key, $value, $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Coupon orWhereTranslationLike($key, $value, $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Coupon translated()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Coupon translatedIn($locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Coupon whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Coupon whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Coupon whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Coupon whereEndAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Coupon whereFeatured($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Coupon whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Coupon whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Coupon whereStartAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Coupon whereStoreId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Coupon whereTranslation($key, $value, $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Coupon whereTranslationLike($key, $value, $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Coupon whereTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Coupon whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Coupon whereUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Coupon withTranslation()
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Coupon active()
 *  * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Coupon featured()
 * @property-read int|null $categories_count
 * @property-read int|null $translations_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Coupon newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Coupon newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Coupon query()
 */
class Coupon extends Model
{
    use Translatable;
    use Rememberable;

    /**
     * @var string
     */
    public $uploadDir = 'uploads/coupons/';

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
        return $this->belongsToMany('App\Models\Category', 'coupon_categories');
    }

    /**
     * @param $value
     * @return string
     */
    public function getImageAttribute($value)
    {
        return $value ? (str_contains($value, '//') ? $value : asset($this->uploadDir . $value)) : asset(config('ase.default.no-image'));
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeActive($query)
    {
        return $query->whereNull('end_at')->orWhere('end_at', '>=', Carbon::now());
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeFeatured($query)
    {
        return $query->whereFeatured(true);
    }
}
