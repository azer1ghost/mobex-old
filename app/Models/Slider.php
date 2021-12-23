<?php

namespace App\Models;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Slider
 *
 * @property int $id
 * @property string|null $name
 * @property string $image
 * @property string|null $url
 * @property int $target_black
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Slider whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Slider whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Slider whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Slider whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Slider whereTargetBlack($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Slider whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Slider whereUrl($value)
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\SliderTranslation[] $translations
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Slider listsTranslations($translationField)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Slider notTranslatedIn($locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Slider orWhereTranslation($key, $value, $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Slider orWhereTranslationLike($key, $value, $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Slider translated()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Slider translatedIn($locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Slider whereTranslation($key, $value, $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Slider whereTranslationLike($key, $value, $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Slider withTranslation()
 * @property-read int|null $translations_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Slider newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Slider newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Slider query()
 * @property int $target_blank
 * @property int $alert
 * @property int $active
 * @property int $show_after
 * @method static \Illuminate\Database\Eloquent\Builder|Slider whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Slider whereAlert($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Slider whereShowAfter($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Slider whereTargetBlank($value)
 */
class Slider extends Model
{
    use Translatable;

    public $uploadDir = 'uploads/slider/';

    public $translatedAttributes = ['title', 'content', 'button_label'];

    public function getImageAttribute($value)
    {
        return $value ? (str_contains($value, '//') ? $value : asset($this->uploadDir . $value)) : asset('assets/images/s-' . $this->id . '.png');
    }
}
