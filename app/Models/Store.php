<?php

namespace App\Models;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Watson\Rememberable\Rememberable;

/**
 * App\Models\Store
 *
 * @property int $id
 * @property string $url
 * @property string|null $logo
 * @property int $featured
 * @property string|null $deleted_at
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Category[] $categories
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Coupon[] $coupons
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\StoreTranslation[] $translations
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Store listsTranslations($translationField)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Store notTranslatedIn($locale = null)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Store onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Store orWhereTranslation($key, $value, $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Store orWhereTranslationLike($key, $value, $locale = null)
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Store translated()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Store translatedIn($locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Store whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Store whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Store whereFeatured($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Store whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Store whereLogo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Store whereTranslation($key, $value, $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Store whereTranslationLike($key, $value, $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Store whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Store whereUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Store withTranslation()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Store withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Store withoutTrashed()
 * @mixin \Eloquent
 * @property float|null $sale
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Store featured()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Store whereSale($value)
 * @property-read int|null $categories_count
 * @property-read int|null $coupons_count
 * @property-read int|null $translations_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Store newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Store newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Store query()
 * @property int|null $country_id
 * @property float|null $cashback_percent
 * @property int|null $popularity
 * @property-read \App\Models\Country|null $country
 * @property-read mixed $cashback_link
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Store whereCashbackPercent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Store whereCountryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Store wherePopularity($value)
 */
class Store extends Model
{
    use Translatable;
    use Rememberable;
    use SoftDeletes;

    /**
     * @var array
     */
    protected $with = ['translations'];

    /**
     * @var string
     */
    public $uploadDir = 'uploads/stores/';

    /**
     * @var array
     */
    public $translatedAttributes = ['name', 'description'];

    /**
     * Categories
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function categories()
    {
        return $this->belongsToMany('App\Models\Category', 'store_categories');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function country()
    {
        return $this->belongsTo('App\Models\Country');
    }

    /**
     * Coupons related with this store
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function coupons()
    {
        return $this->hasMany('App\Models\Coupon');
    }

    /**
     * Logo attribute
     *
     * @param $value
     * @return string
     */
    public function getLogoAttribute($value)
    {
        return $value ? (str_contains($value, '//') ? $value : asset($this->uploadDir . $value)) : asset(config('ase.default.no-image'));
    }

    /**
     * @param $value
     * @return int
     */
    public function getSaleAttribute($value)
    {
        return $value + 0;
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeFeatured($query)
    {
        return $query->whereFeatured(true);
    }

    /**
     * @return string
     */
    public function getCashbackLinkAttribute()
    {
        return env('CASHBACK_URL') != '' ? ('http://' . env('CASHBACK_URL') . "/r?url=" . $this->attributes['url'] . (auth()->check() ? ('&user_id=' . auth()->user()->id) : null)) : $this->attributes['url'];
    }
}
