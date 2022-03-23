<?php

namespace App\Models;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Filial
 *
 * @property int $id
 * @property string|null $location
 * @property string $status
 * @property string|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\FilialTranslation[] $translations
 * @property-read int|null $translations_count
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Filial listsTranslations($translationField)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Filial newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Filial newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Filial notTranslatedIn($locale = null)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Filial onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Filial orWhereTranslation($key, $value, $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Filial orWhereTranslationLike($key, $value, $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Filial query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Filial translated()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Filial translatedIn($locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Filial whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Filial whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Filial whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Filial whereLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Filial whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Filial whereTranslation($key, $value, $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Filial whereTranslationLike($key, $value, $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Filial whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Filial withTranslation()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Filial withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Filial withoutTrashed()
 * @mixin \Eloquent
 * @property string|null $cells
 * @property string|null $working_hours
 * @property string|null $phone
 * @method static \Illuminate\Database\Eloquent\Builder|Filial whereCells($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Filial wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Filial whereWorkingHours($value)
 */
class Filial extends Model
{
    use Translatable;
    use SoftDeletes;

    const DEFAULT_FILIAL_ID = 1;

    /**
     * @var array
     */
    protected $with = ['translations'];

    /**
     * @var array
     */
    public $translatedAttributes = ['name', 'address'];

    /**
     * Parse source url from embed
     *
     * @param $value
     * @return mixed
     */
    public function getLocationAttribute($value)
    {
        preg_match('/src="([^"]+)"/', $value, $match);
        $url = isset($match[1]) ? $match[1] : $value;

        return $url;
    }
}
