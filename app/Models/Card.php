<?php

namespace App\Models;

use App\Traits\ModelEventLogger;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Card
 *
 * @property int $id
 * @property string $name
 * @property string $name_on_card
 * @property string $number
 * @property string $end_date
 * @property string $cvv
 * @property string $status
 * @property string|null $data
 * @property float|null $limit
 * @property string $currency
 * @property string $phone_number
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Admin $admin
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Admin[] $admins
 * @property-read int|null $admins_count
 * @property-read mixed $currency_value
 * @property-read mixed $hidden_number
 * @property-read mixed $logo
 * @property-read mixed $month
 * @property-read mixed $type
 * @property-read mixed $year
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Order[] $orders
 * @property-read int|null $orders_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Card newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Card newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Card query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Card whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Card whereCurrency($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Card whereCvv($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Card whereData($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Card whereEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Card whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Card whereLimit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Card whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Card whereNameOnCard($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Card whereNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Card wherePhoneNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Card whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Card whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read mixed $last_digit
 */
class Card extends Model
{
    use ModelEventLogger;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function admin()
    {
        return $this->hasOne(Admin::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function admins()
    {
        return $this->hasMany(Admin::class);
    }

    /**
     * @return int|string
     */
    public function getTypeAttribute()
    {
        return detectCardType($this->attributes['number']);
    }

    /**
     * @return mixed|string
     */
    public function getHiddenNumberAttribute()
    {
        $maskingCharacter = "*";
        $number = str_replace("-", "", $this->attributes['number']);

        return strlen($number) == 16 ? substr($number, 0, 4) . str_repeat($maskingCharacter, strlen($number) - 8) . substr($number, -4) : $number;
    }

    /**
     * @return string
     */
    public function getLastDigitAttribute()
    {
        return "****" . substr($this->attributes['number'], -4);
    }

    /**
     * @return string|null
     */
    public function getLogoAttribute()
    {
        return $this->attributes['number'] ? asset('admin/cards/' . detectCardType($this->attributes['number']) . ".png") : null;
    }

    /**
     * @return mixed
     */
    public function getMonthAttribute()
    {
        return explode("/", $this->attributes['end_date'])[0];
    }

    /**
     * @return string
     */
    public function getYearAttribute()
    {
        return "20" . explode("/", $this->attributes['end_date'])[1];
    }

    /**
     * @return \Illuminate\Config\Repository|int|mixed
     */
    public function getCurrencyValueAttribute()
    {
        return config('ase.attributes.currencies.' . $this->attributes['currency']);
    }

    /**
     * @param $value
     * @return string
     */
    public function getNumberAttribute($value)
    {
        return join(" ", str_split(str_replace(" ", "", $value), 4));
    }
}