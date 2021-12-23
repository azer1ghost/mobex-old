<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;

/**
 * App\Models\PageTranslation
 *
 * @property int $id
 * @property int $page_id
 * @property string $slug
 * @property string $locale
 * @property string $name
 * @property string|null $content
 * @property string|null $meta_title
 * @property string|null $meta_description
 * @property string|null $meta_keywords
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PageTranslation whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PageTranslation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PageTranslation whereLocale($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PageTranslation whereMetaDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PageTranslation whereMetaKeywords($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PageTranslation whereMetaTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PageTranslation whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PageTranslation wherePageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PageTranslation whereSlug($value)
 * @mixin \Eloquent
 * @property string $title
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PageTranslation findSimilarSlugs(\Illuminate\Database\Eloquent\Model $model, $attribute, $config, $slug)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PageTranslation whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PageTranslation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PageTranslation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PageTranslation query()
 * @property string|null $author
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PageTranslation whereAuthor($value)
 */
class PageTranslation extends MainTranslate
{
    use Sluggable;
    use SluggableScopeHelpers;

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'title',
            ],
        ];
    }
}
