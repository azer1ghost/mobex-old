<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Campaign
 *
 * @property int $id
 * @property string|null $title
 * @property int $send_after
 * @property string|null $content
 * @property string|null $filtering
 * @property string|null $users
 * @property string|null $excluded_users
 * @property string $type
 * @property string|null $response_data
 * @property int $sent
 * @property int $matched
 * @property string|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Campaign newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Campaign newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Campaign onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Campaign query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Campaign whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Campaign whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Campaign whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Campaign whereExcludedUsers($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Campaign whereFiltering($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Campaign whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Campaign whereMatched($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Campaign whereResponseData($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Campaign whereSendAfter($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Campaign whereSent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Campaign whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Campaign whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Campaign whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Campaign whereUsers($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Campaign withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Campaign withoutTrashed()
 * @mixin \Eloquent
 * @property-read mixed $no_action
 */
class Campaign extends Model
{
    use SoftDeletes;

    /**
     * @return bool
     */
    public function getNoActionAttribute()
    {
        return boolval($this->attributes['sent']);
    }
}
