<?php

namespace App\Models;

use App\Models\Extra\SMS;
use App\Traits\ModelEventLogger;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Delivery
 *
 * @property int $id
 * @property int|null $user_id
 * @property int|null $admin_id
 * @property int|null $city_id
 * @property int|null $district_id
 * @property int|null $tariff_id
 * @property string|null $full_name
 * @property string|null $phone
 * @property string|null $location
 * @property string|null $address
 * @property string|null $note
 * @property string|null $courier_note
 * @property int $fast
 * @property float|null $fee
 * @property float|null $total_weight
 * @property float|null $total_price
 * @property int $paid
 * @property string|null $status
 * @property string|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Package[] $packages
 * @property-read int|null $packages_count
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Delivery newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Delivery newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Delivery onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Delivery query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Delivery whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Delivery whereAdminId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Delivery whereCityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Delivery whereCourierNote($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Delivery whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Delivery whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Delivery whereDistrictId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Delivery whereFast($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Delivery whereFee($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Delivery whereFullName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Delivery whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Delivery whereLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Delivery whereNote($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Delivery wherePaid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Delivery wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Delivery whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Delivery whereTariffId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Delivery whereTotalPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Delivery whereTotalWeight($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Delivery whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Delivery whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Delivery withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Delivery withoutTrashed()
 * @mixin \Eloquent
 * @property int|null $filial_id
 * @property-read \App\Models\Admin|null $admin
 * @property-read \App\Models\City|null $city
 * @property-read \App\Models\District|null $district
 * @property-read \App\Models\Filial|null $filial
 * @property-read string|string[]|null $cleared_phone
 * @property-read mixed $custom_id
 * @property-read mixed $full_address
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|Delivery whereFilialId($value)
 */
class Delivery extends Model
{
    use SoftDeletes;
    use ModelEventLogger;

    protected $with = ['district', 'user', 'city', 'packages', 'filial'];

    public function packages()
    {
        return $this->belongsToMany(Package::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function district()
    {
        return $this->belongsTo(District::class);
    }

    public function filial()
    {
        return $this->belongsTo(Filial::class);
    }

    public function getFullAddressAttribute()
    {
        return ($this->city ? $this->city->name : 'Bakı') . " " . ($this->district ? $this->district->name : '-') . ", " . $this->attributes['address'];
    }

    /**
     * @return string|string[]|null
     */
    public function getClearedPhoneAttribute()
    {
        return SMS::clearNumber($this->attributes['phone'], true, " ");
    }

    public function getCustomIdAttribute()
    {
        return sprintf('%06d', $this->id);
    }

    public function getTotalPriceAttribute($value)
    {

        if ($this->paid) {
            return $value;
        }

        $totalPrice = 0;

        foreach ($this->packages as $myPackage) {
            if ($myPackage) {
                if (! $myPackage->paid) {
                    $totalPrice += $myPackage->delivery_manat_price;
                    $paid = false;
                }
            }
        }

        return round($totalPrice + $this->fee, 2);
    }
}
