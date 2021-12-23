<?php

namespace App\Models;

/**
 * App\Models\PackageTypeTranslation
 *
 * @property int $id
 * @property int $package_type_id
 * @property string $name
 * @property string $locale
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PackageTypeTranslation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PackageTypeTranslation whereLocale($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PackageTypeTranslation whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PackageTypeTranslation wherePackageTypeId($value)
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PackageTypeTranslation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PackageTypeTranslation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PackageTypeTranslation query()
 */
class PackageTypeTranslation extends MainTranslate
{
    /**
     * @var array
     */
    protected $fillable = ['name'];
}
