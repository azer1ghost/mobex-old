<?php

namespace App\Models;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Watson\Rememberable\Rememberable;

/**
 * App\Models\Faq
 *
 * @property int $id
 * @property int $in_order
 * @property int $status
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\FaqTranslation[] $translations
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Faq listsTranslations($translationField)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Faq notTranslatedIn($locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Faq orWhereTranslation($key, $value, $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Faq orWhereTranslationLike($key, $value, $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Faq translated()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Faq translatedIn($locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Faq whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Faq whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Faq whereInOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Faq whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Faq whereTranslation($key, $value, $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Faq whereTranslationLike($key, $value, $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Faq whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Faq withTranslation()
 * @mixin \Eloquent
 * @property-read int|null $translations_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Faq newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Faq newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Faq query()
 */
class Faq extends Model
{
    use Translatable;
    use Rememberable;

    /**
     * @var array
     */
    protected $with = ['translations'];

    /**
     * @var bool
     */
    public $useTranslationFallback = true;

    /**
     * @var array
     */
    public $translatedAttributes = ['question', 'answer'];
}
