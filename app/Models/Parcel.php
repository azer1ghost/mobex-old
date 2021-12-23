<?php

namespace App\Models;

use App\Traits\ModelEventLogger;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Parcel
 *
 * @property int $id
 * @property int $warehouse_id
 * @property string $custom_id
 * @property int $sent
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Package[] $packages
 * @property-read int|null $packages_count
 * @property-read \App\Models\Warehouse $warehouse
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Parcel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Parcel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Parcel query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Parcel whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Parcel whereCustomId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Parcel whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Parcel whereSent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Parcel whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Parcel whereWarehouseId($value)
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Package[] $waiting
 * @property-read int|null $waiting_count
 * @property-read mixed $sent_with_label
 * @property string|null $awb
 * @property int $customs_sent
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Parcel whereAwb($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Parcel whereCustomsSent($value)
 * @property int $real
 * @property int $awb_changed
 * @property-read mixed $can_send
 * @property-read mixed $is_real
 * @property-read mixed $name
 * @method static \Illuminate\Database\Eloquent\Builder|Parcel whereAwbChanged($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Parcel whereReal($value)
 */
class Parcel extends Model
{
    use ModelEventLogger;

    /**
     * @var array
     */
    protected $fillable = ['warehouse_id', 'custom_id'];

    /**
     * @param int $digits
     * @return string
     */
    public static function generateCustomId($digits = 8)
    {
        do {

            $code = str_pad(rand(0, pow(10, $digits) - 1), $digits, '0', STR_PAD_LEFT);

            $check = Parcel::whereCustomId($code)->first();
            if (! $check) {
                break;
            }
        } while (true);

        return $code;
    }

    /**
     *
     */
    protected static function boot()
    {
        parent::boot();

        // auto-sets values on creation
        static::creating(function ($query) {
            $query->custom_id = $query->custom_id ?: self::generateCustomId();
            $query->real =  (str_contains($query->custom_id, "-"));
        });

        static::updating(function ($query) {
            if ($query->isDirty('awb') && $query->awb) {
                $query->awb_changed = true;
            }
        });
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function packages()
    {
        return $this->belongsToMany(Package::class, 'parcel_package')->orderBy('custom_status', 'desc')->orderBy('status', 'asc');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function waiting()
    {
        return $this->belongsToMany(Package::class, 'parcel_package')->where('status', 1);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }

    /**
     * @return \Illuminate\Config\Repository|int|mixed
     */
    public function getSentWithLabelAttribute()
    {
        if ($this->sent == 1) {
            $inBaku = $this->packages->where('status', '>', 1)->count();
            if ($inBaku) {
                $this->sent = 2;
                $this->save();
            }
        }

        return config('ase.attributes.package.status.' . $this->sent);
    }

    /**
     * @return bool
     */
    public function getIsRealAttribute()
    {
        return str_contains($this->custom_id, "-") || $this->real;
    }

    /**
     * @return mixed
     */
    public function getNameAttribute()
    {
        return substr(explode("-", $this->attributes['custom_id'])[0], 0, 3);
    }

    /**
     * @return bool
     */
    public function getCanSendAttribute()
    {
        return $this->is_real && ! $this->sent;
    }
}
