<?php

namespace App\Models;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Watson\Rememberable\Rememberable;

/**
 * App\Models\PackageType
 *
 * @property int $id
 * @property int|null $parent_id
 * @property string|null $icon
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Package[] $packages
 * @property-read \App\Models\PackageType|null $parent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\PackageType[] $sub
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\PackageTypeTranslation[] $translations
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PackageType listsTranslations($translationField)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PackageType notTranslatedIn($locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PackageType orWhereTranslation($key, $value, $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PackageType orWhereTranslationLike($key, $value, $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PackageType translated()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PackageType translatedIn($locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PackageType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PackageType whereIcon($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PackageType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PackageType whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PackageType whereTranslation($key, $value, $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PackageType whereTranslationLike($key, $value, $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PackageType whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PackageType withTranslation()
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\PackageType[] $children
 * @property \Carbon\Carbon|null $deleted_at
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\PackageType onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PackageType whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\PackageType withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\PackageType withoutTrashed()
 * @property-read int|null $children_count
 * @property-read int|null $packages_count
 * @property-read int|null $translations_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PackageType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PackageType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PackageType query()
 * @property float|null $weight
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PackageType whereWeight($value)
 * @property int|null $custom_id
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PackageType whereCustomId($value)
 */
class PackageType extends Model
{
    use Translatable;
    use Rememberable;
    use SoftDeletes;

    public $fillable = [
        'parent_id',
        'custom_id',
    ];

    protected $with = ['translations'];

    /**
     * @var string
     */
    public $uploadDir = 'uploads/category/';

    /**
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * @var array
     */
    public $translatedAttributes = ['name'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function children()
    {
        return $this->hasMany('App\Models\PackageType', 'parent_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function parent()
    {
        return $this->belongsTo('App\Models\PackageType', 'parent_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function packages()
    {
        return $this->hasMany('App\Models\Package', 'type_id');
    }

    /**
     * @param $value
     * @return string
     */
    public function getIconAttribute($value)
    {
        return $value ? asset($this->uploadDir . $value) : asset(config('ase.default.no-image'));
    }
}
