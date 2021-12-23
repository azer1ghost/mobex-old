<?php

namespace App\Models;

use App\Traits\ModelEventLogger;
use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Watson\Rememberable\Rememberable;

/**
 * App\Models\Country
 *
 * @property int $id
 * @property string $code
 * @property string $flag
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\CountryTranslation[] $translations
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Country listsTranslations($translationField)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Country notTranslatedIn($locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Country orWhereTranslation($key, $value, $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Country orWhereTranslationLike($key, $value, $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Country translated()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Country translatedIn($locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Country whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Country whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Country whereFlag($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Country whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Country whereTranslation($key, $value, $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Country whereTranslationLike($key, $value, $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Country whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Country withTranslation()
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Country[] $warehouses
 * @property-read \App\Models\Warehouse $warehouse
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Package[] $packages
 * @property int $delivery_index
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Country whereDeliveryIndex($value)
 * @property string|null $emails
 * @property int $status
 * @property-read int|null $packages_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Page[] $pages
 * @property-read int|null $pages_count
 * @property-read int|null $translations_count
 * @property-read int|null $warehouses_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Country newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Country newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Country query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Country whereEmails($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Country whereStatus($value)
 * @property int $allow_declaration
 * @property int $convert_invoice_to_usd
 * @property int $currency
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Store[] $stores
 * @property-read int|null $stores_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Country whereAllowDeclaration($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Country whereConvertInvoiceToUsd($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Country whereCurrency($value)
 * @property int|null $custom_id
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Country whereCustomId($value)
 * @property int $weight_type
 * @property int $length_type
 * @method static \Illuminate\Database\Eloquent\Builder|Country whereLengthType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Country whereWeightType($value)
 */
class Country extends Model
{
    use Translatable;
    use Rememberable;
    use ModelEventLogger;

    /**
     * @var string
     */
    public $uploadDir = 'uploads/countries/';

    /**
     * @var array
     */
    protected $with = ['translations'];

    /**
     * @var array
     */
    public $translatedAttributes = ['name'];

    /**
     * @var array
     */
    protected $fillable = ['code'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function warehouses()
    {
        return $this->hasMany('App\Models\Warehouse');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function packages()
    {
        return $this->hasMany('App\Models\Package');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function stores()
    {
        return $this->hasMany('App\Models\Store');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function warehouse()
    {
        return $this->hasOne('App\Models\Warehouse')->orderBy('id', 'desc');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function pages()
    {
        return $this->belongsToMany('App\Models\Page', 'country_pages');
    }

    /**
     * @param $value
     * @return string
     */
    public function getFlagAttribute($value)
    {
        return $value ? asset($this->uploadDir . $value) : (file_exists(public_path('uploads/default/countries/' . $this->attributes['code'] . '.png')) ? asset('uploads/default/countries/' . $this->attributes['code'] . '.png') : asset(config('ase.default.no-image')));
    }

    /**
     *
     */
    protected static function boot()
    {
        parent::boot();

        static::updated(function ($query) {
            \Cache::forget('countries');
            \Cache::forget('main_warehouse');
        });

        static::created(function ($query) {
            \Cache::forget('countries');
            \Cache::forget('main_warehouse');
        });

        static::deleted(function ($query) {
            \Cache::forget('countries');
            \Cache::forget('main_warehouse');
        });
    }
}
