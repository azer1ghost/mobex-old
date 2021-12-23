<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\SMSTemplate
 *
 * @property int $id
 * @property string $key
 * @property string $name
 * @property string $content
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\SMSTemplate onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SMSTemplate whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SMSTemplate whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SMSTemplate whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SMSTemplate whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SMSTemplate whereKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SMSTemplate whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SMSTemplate whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\SMSTemplate withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\SMSTemplate withoutTrashed()
 * @mixin \Eloquent
 * @property int $active
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SMSTemplate newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SMSTemplate newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SMSTemplate query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SMSTemplate whereActive($value)
 * @property string|null $push_link
 * @method static \Illuminate\Database\Eloquent\Builder|SMSTemplate wherePushLink($value)
 */
class SMSTemplate extends Model
{
    use SoftDeletes;

    /**
     * @var string
     */
    protected $table = "s_m_s_templates";

    /**
     * @var array
     */
    protected $fillable = [
        "key",
        "name",
        "content",
    ];
}
