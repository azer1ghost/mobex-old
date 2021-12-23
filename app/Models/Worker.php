<?php

namespace App\Models;

use App\Traits\ModelEventLogger;
use App\Traits\Password;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * App\Models\Worker
 *
 * @property int $id
 * @property int|null $warehouse_id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property string|null $remember_token
 * @property string|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Warehouse|null $warehouse
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Worker newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Worker newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Worker onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Worker query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Worker whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Worker whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Worker whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Worker whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Worker whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Worker wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Worker whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Worker whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Worker whereWarehouseId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Worker withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Worker withoutTrashed()
 * @mixin \Eloquent
 */
class Worker extends Authenticatable
{
    use Password;
    use SoftDeletes;
    use ModelEventLogger;

    /**
     * @var array
     */
    protected $with = ['warehouse'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }
}
