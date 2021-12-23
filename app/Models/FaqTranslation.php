<?php

namespace App\Models;

/**
 * App\Models\FaqTranslation
 *
 * @property int $id
 * @property int $faq_id
 * @property string $locale
 * @property string|null $question
 * @property string|null $answer
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FaqTranslation whereAnswer($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FaqTranslation whereFaqId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FaqTranslation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FaqTranslation whereLocale($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FaqTranslation whereQuestion($value)
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FaqTranslation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FaqTranslation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FaqTranslation query()
 */
class FaqTranslation extends MainTranslate
{
    //
}
