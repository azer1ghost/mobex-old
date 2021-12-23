<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\NotificationQueue
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\NotificationQueue newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\NotificationQueue newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\NotificationQueue query()
 * @mixin \Eloquent
 * @property int $id
 * @property string $type
 * @property string|null $to
 * @property string|null $extra_to
 * @property string|null $subject
 * @property string|null $content
 * @property int $sent
 * @property string|null $error_message
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\NotificationQueue whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\NotificationQueue whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\NotificationQueue whereErrorMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\NotificationQueue whereExtraTo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\NotificationQueue whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\NotificationQueue whereSent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\NotificationQueue whereSubject($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\NotificationQueue whereTo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\NotificationQueue whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\NotificationQueue whereUpdatedAt($value)
 * @property string $send_for
 * @property int|null $send_for_id
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\NotificationQueue whereSendFor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\NotificationQueue whereSendForId($value)
 * @property int $hour_after
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\NotificationQueue whereHourAfter($value)
 * @property int|null $user_id
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|NotificationQueue whereUserId($value)
 */
class NotificationQueue extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'type',
        'to',
        'extra_to',
        'subject',
        'content',
        'sent',
        'error_message',
        'send_for',
        'send_for_id',
        'hour_after',
        'user_id',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User')->withTrashed();
    }
}
