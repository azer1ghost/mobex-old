<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\PackageLog
 *
 * @property int $id
 * @property int $package_id
 * @property string|null $meta_key
 * @property string|null $meta_value
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \App\Models\Package $package
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PackageLog whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PackageLog whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PackageLog whereMetaKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PackageLog whereMetaValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PackageLog wherePackageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PackageLog whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \App\Models\Admin $admin
 * @property-read mixed $json_data
 * @property-read \App\Models\Warehouse $warehouse
 * @property int|null $warehouse_id
 * @property int|null $admin_id
 * @property string $data
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PackageLog whereAdminId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PackageLog whereData($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PackageLog whereWarehouseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PackageLog newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PackageLog newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PackageLog query()
 */
class PackageLog extends Model
{
    /**
     * @var array
     */
    protected $appends = ['json_data'];

    /**
     * @var array
     */
    protected $with = ['warehouse', 'admin'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function package()
    {
        return $this->belongsTo('App\Models\Package');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function admin()
    {
        return $this->belongsTo('App\Models\Admin');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function warehouse()
    {
        return $this->belongsTo('App\Models\Warehouse');
    }

    /**
     * @return mixed
     */
    public function getJsonDataAttribute()
    {
        return json_decode(rtrim($this->attributes['data']), true);
    }
}
