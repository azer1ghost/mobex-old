<?php

namespace App\Models;

/**
 * App\Models\CityTranslation
 *
 * @property int $id
 * @property int $city_id
 * @property string $locale
 * @property string $name
 * @property string|null $address
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DistrictTranslation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DistrictTranslation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DistrictTranslation query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DistrictTranslation whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DistrictTranslation whereCityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DistrictTranslation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DistrictTranslation whereLocale($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DistrictTranslation whereName($value)
 * @mixin \Eloquent
 * @property int $district_id
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DistrictTranslation whereDistrictId($value)
 */
class DistrictTranslation extends MainTranslate
{
    //
}
