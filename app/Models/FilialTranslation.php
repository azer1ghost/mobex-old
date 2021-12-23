<?php

namespace App\Models;

/**
 * App\Models\FilialTranslation
 *
 * @property int $id
 * @property int $filial_id
 * @property string $locale
 * @property string $name
 * @property string|null $address
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FilialTranslation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FilialTranslation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FilialTranslation query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FilialTranslation whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FilialTranslation whereFilialId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FilialTranslation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FilialTranslation whereLocale($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FilialTranslation whereName($value)
 * @mixin \Eloquent
 */
class FilialTranslation extends MainTranslate
{
    //
}
