<?php

namespace App\Models;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Page
 *
 * @property int $id
 * @property int $type
 * @property string|null $image
 * @property string|null $keyword
 * @property int $status
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\PageTranslation[] $translations
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Page listsTranslations($translationField)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Page news()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Page notTranslatedIn($locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Page orWhereTranslation($key, $value, $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Page orWhereTranslationLike($key, $value, $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Page self()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Page translated()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Page translatedIn($locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Page whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Page whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Page whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Page whereKeyword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Page whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Page whereTranslation($key, $value, $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Page whereTranslationLike($key, $value, $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Page whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Page whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Page withTranslation()
 * @mixin \Eloquent
 * @property \Carbon\Carbon|null $deleted_at
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Page onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Page whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Page withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Page withoutTrashed()
 * @property-read int|null $translations_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Page newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Page newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Page query()
 * @property string|null $intro_image
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Page whereIntroImage($value)
 */
class Page extends Model
{
    use Translatable;
    use SoftDeletes;

    /**
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * @var array
     */
    protected $with = ['translations'];

    /**
     * @var string
     */
    public $uploadDir = 'uploads/news/';

    /**
     * @var array
     */
    public $translatedAttributes = [
        'title',
        'content',
        'slug',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'author',
    ];

    /**
     * @param $query
     * @return mixed
     */
    public function scopeNews($query)
    {
        return $query->where('type', 1);
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeSelf($query)
    {
        return $query->where('type', 0);
    }

    /**
     * @param $value
     * @return string
     */
    public function getImageAttribute($value)
    {
        return $value ? (str_contains($value, "http") ? $value : asset($this->uploadDir . $value)) : asset(config('ase.default.no-image'));
    }

    /**
     * @param $value
     * @return string
     */
    public function getIntroImageAttribute($value)
    {
        return $value ? (str_contains($value, "http") ? $value : asset($this->uploadDir . $value)) : asset(config('ase.default.no-image'));
    }
}
