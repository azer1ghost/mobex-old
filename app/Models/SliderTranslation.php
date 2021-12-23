<?php

namespace App\Models;

/**
 * App\Models\StoreTranslation
 *
 * @property int $id
 * @property int $store_id
 * @property string $slug
 * @property string $locale
 * @property string $name
 * @property string|null $description
 * @property string|null $meta_title
 * @property string|null $meta_description
 * @property string|null $meta_keywords
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\StoreTranslation findSimilarSlugs(\Illuminate\Database\Eloquent\Model $model, $attribute, $config, $slug)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\StoreTranslation whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\StoreTranslation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\StoreTranslation whereLocale($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\StoreTranslation whereMetaDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\StoreTranslation whereMetaKeywords($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\StoreTranslation whereMetaTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\StoreTranslation whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\StoreTranslation whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\StoreTranslation whereStoreId($value)
 * @mixin \Eloquent
 * @property int $slider_id
 * @property string|null $title
 * @property string|null $content
 * @property string|null $button_label
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SliderTranslation whereButtonLabel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SliderTranslation whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SliderTranslation whereSliderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SliderTranslation whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SliderTranslation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SliderTranslation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SliderTranslation query()
 */
class SliderTranslation extends MainTranslate
{
    //
}
