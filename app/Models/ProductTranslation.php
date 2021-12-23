<?php

namespace App\Models;

/**
 * App\Models\ProductTranslation
 *
 * @property int $id
 * @property int $product_id
 * @property string $locale
 * @property string $name
 * @property string|null $description
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProductTranslation whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProductTranslation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProductTranslation whereLocale($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProductTranslation whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProductTranslation whereProductId($value)
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProductTranslation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProductTranslation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProductTranslation query()
 */
class ProductTranslation extends MainTranslate
{
    //
}
