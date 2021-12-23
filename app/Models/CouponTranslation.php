<?php

namespace App\Models;

/**
 * App\Models\CouponTranslation
 *
 * @property int $id
 * @property int $coupon_id
 * @property string $slug
 * @property string $locale
 * @property string $name
 * @property string|null $description
 * @property string|null $meta_title
 * @property string|null $meta_description
 * @property string|null $meta_keywords
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CouponTranslation findSimilarSlugs(\Illuminate\Database\Eloquent\Model $model, $attribute, $config, $slug)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CouponTranslation whereCouponId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CouponTranslation whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CouponTranslation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CouponTranslation whereLocale($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CouponTranslation whereMetaDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CouponTranslation whereMetaKeywords($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CouponTranslation whereMetaTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CouponTranslation whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CouponTranslation whereSlug($value)
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CouponTranslation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CouponTranslation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CouponTranslation query()
 */
class CouponTranslation extends MainTranslate
{
    //
}
