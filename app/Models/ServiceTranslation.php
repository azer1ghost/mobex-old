<?php

namespace App\Models;

/**
 * Class ServiceTranslation
 *
 * @package App\Models
 * @property int $id
 * @property int $service_id
 * @property string $locale
 * @property string $name
 * @property string|null $description
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ServiceTranslation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ServiceTranslation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ServiceTranslation query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ServiceTranslation whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ServiceTranslation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ServiceTranslation whereLocale($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ServiceTranslation whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ServiceTranslation whereServiceId($value)
 * @mixin \Eloquent
 */
class ServiceTranslation extends MainTranslate
{
    //
}
