<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Activity
 *
 * @property int $id
 * @property int $admin_id
 * @property int $content_id
 * @property string $content_type
 * @property string $action
 * @property string $description
 * @property string $details
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Admin $admin
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Activity newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Activity newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Activity query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Activity whereAction($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Activity whereAdminId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Activity whereContentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Activity whereContentType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Activity whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Activity whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Activity whereDetails($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Activity whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Activity whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property int|null $user_id
 * @property int|null $worker_id
 * @property string|null $ip
 * @property string|null $user_agent
 * @property-read mixed $data
 * @property-read \App\Models\Worker|null $worker
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Activity whereIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Activity whereUserAgent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Activity whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Activity whereWorkerId($value)
 */
class Activity extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'admin_id',
        'worker_id',
        'user_id',
        'content_id',
        'content_type',
        'action',
        'description',
        'details',
        'ip',
        'user_agent',
    ];

    /**
     * @var array
     */
    protected $with = ['admin', 'worker'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function worker()
    {
        return $this->belongsTo(Worker::class);
    }

    /**
     * @return string
     */
    public function getDataAttribute()
    {
        $arr = json_decode($this->attributes['details'], true);
        $data = "<ul>";
        foreach ($arr as $key => $value) {
            if (! is_array($value)) {
                $data .= "<li><b>" . ucfirst(str_replace("_", " ", $key)) . "</b> : <i>" . str_limit($value, 130) . "</i></li>";
            }

            if (is_array($value)) {
                foreach ($value as $_key => $_value) {
                    $data .= "<li><b>" . ucfirst(str_replace("_", " ", $_key)) . "</b> : <i>" . str_limit($_value, 130) . "</i></li>";
                }
            }
        }
        $data .= "</ul>";

        return $data;
    }
}
