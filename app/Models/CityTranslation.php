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
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CityTranslation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CityTranslation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CityTranslation query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CityTranslation whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CityTranslation whereCityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CityTranslation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CityTranslation whereLocale($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CityTranslation whereName($value)
 * @mixin \Eloquent
 */
class CityTranslation extends MainTranslate
{
    //
}
