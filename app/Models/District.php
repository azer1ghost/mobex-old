<?php

namespace App\Models;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\City
 *
 * @property int $id
 * @property int $status
 * @property string|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\DistrictTranslation[] $translations
 * @property-read int|null $translations_count
 * @method static bool|null forceDelete()
 *  * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\District listsTranslations($translationField)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\District newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\District newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\District notTranslatedIn($locale = null)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\District onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\District orWhereTranslation($key, $value, $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\District orWhereTranslationLike($key, $value, $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\District query()
 * @method static bool|null restore()
 *  * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\District translated()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\District translatedIn($locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\District whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\District whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\District whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\District whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\District whereTranslation($key, $value, $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\District whereTranslationLike($key, $value, $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\District whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\District withTranslation()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\District withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\District withoutTrashed()
 * @mixin \Eloquent
 */

/**
 * Class District
 *
 * @package App\Models
 * @property int $id
 * @property int $city_id
 * @property int $status
 * @property string|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\City $city
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\DistrictTranslation[] $translations
 * @property-read int|null $translations_count
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\District listsTranslations($translationField)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\District newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\District newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\District notTranslatedIn($locale = null)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\District onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\District orWhereTranslation($key, $value, $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\District orWhereTranslationLike($key, $value, $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\District query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\District translated()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\District translatedIn($locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\District whereCityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\District whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\District whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\District whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\District whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\District whereTranslation($key, $value, $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\District whereTranslationLike($key, $value, $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\District whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\District withTranslation()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\District withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\District withoutTrashed()
 * @mixin \Eloquent
 * @property int $has_delivery
 * @property float|null $delivery_fee
 * @property float|null $km
 * @property string|null $zip_index
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\District whereDeliveryFee($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\District whereHasDelivery($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\District whereKm($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\District whereZipIndex($value)
 * @property-read mixed $full_name
 */
class District extends Model
{
    use Translatable;
    use SoftDeletes;

    /**
     * @var array
     */
    protected $with = ['translations'];

    /**
     * @var array
     */
    public $translatedAttributes = ['name', 'address'];

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function getFullNameAttribute()
    {
        return ($this->city ? $this->city->name : 'Bakı') . " - " . $this->translateOrDefault('en')->name . " : " . $this->attributes['delivery_fee'] . "₼";
    }
}
