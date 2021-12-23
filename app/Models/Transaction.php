<?php

namespace App\Models;

use App\Traits\ModelEventLogger;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Transaction
 *
 * @property int $id
 * @property int|null $user_id
 * @property int|null $custom_id
 * @property string|null $paid_for
 * @property string|null $paid_by
 * @property string $type
 * @property float|null $amount
 * @property string|null $extra_data
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Transaction newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Transaction newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Transaction query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Transaction whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Transaction whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Transaction whereCustomId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Transaction whereExtraData($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Transaction whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Transaction wherePaidBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Transaction wherePaidFor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Transaction whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Transaction whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Transaction whereUserId($value)
 * @mixin \Eloquent
 * @property int|null $admin_id
 * @property int|null $referral_id
 * @property string|null $note
 * @property-read \App\Models\Admin|null $admin
 * @property-read mixed $symbol_amount
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Transaction whereAdminId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Transaction whereNote($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Transaction whereReferralId($value)
 * @property int|null $warehouse_id
 * @property int|null $city_id
 * @property string $who
 * @property \Illuminate\Support\Carbon|null $done_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\City|null $city
 * @property-read mixed $admin_amount
 * @property-read mixed $r_r_n
 * @property-read mixed $symbol_admin_amount
 * @property-read \App\Models\Package|null $package
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Transaction whereCityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Transaction whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Transaction whereDoneAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Transaction whereWarehouseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Transaction whereWho($value)
 * @property string $currency
 * @property float|null $rate
 * @property-read mixed $country
 * @property-read mixed $custom_number
 * @property-read \App\Models\Order|null $order
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Transaction whereCurrency($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Transaction whereRate($value)
 * @property int|null $filial_id
 * @property-read \App\Models\Filial|null $filial
 * @property-read mixed $prefix
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Transaction whereFilialId($value)
 * @property-read mixed $org_amount
 */
class Transaction extends Model
{
    use ModelEventLogger;

    /**
     * @var array
     */
    protected $fillable = [
        'paid_by',
        'user_id',
        'amount',
        'extra_data',
        'type',
        'custom_id',
        'paid_for',
        'referral_id',
        'admin_id',
        'city_id',
        'currency',
        'rate',
        'who',
        'note',
        'hash',
        'done_at',
    ];

    /**
     * @var array
     */
    protected $with = ['admin', 'user', 'package'];

    /**
     * @var array
     */
    protected $dates = ['done_at', 'deleted_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class)->withTrashed();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function admin()
    {
        return $this->belongsTo(Admin::class)->withTrashed();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function filial()
    {
        return $this->belongsTo(Filial::class)->withTrashed();
    }

    /**
     * @return mixed
     */
    public function package()
    {
        return $this->belongsTo(Package::class, 'custom_id', 'id')->withTrashed();
    }

    /**
     * @return mixed
     */
    public function order()
    {
        return $this->belongsTo(Order::class, 'custom_id', 'id')->withTrashed();
    }

    /**
     * @return int|string
     */
    public function getCustomNumberAttribute()
    {
        return $this->paid_for == 'ORDER' ? ($this->order ? $this->order->id : "-") : ($this->package ? $this->package->custom_id : "-");
    }

    /**
     * @return \App\Models\Country|null
     */
    public function getCountryAttribute()
    {
        return $this->paid_for == 'ORDER' ? ($this->order ? $this->order->country : null) : (($this->package && $this->package->warehouse && $this->package->warehouse->country) ? $this->package->warehouse->country : null);
    }

    /**
     * @param bool $plus
     * @return int|string
     */
    public function getPrefixAttribute($plus = false)
    {
        $symbol = 1;

        if ($this->who == 'USER') {
            if ($this->type == 'IN') {
                $symbol = 1;
            } elseif ($this->type != 'ERROR') {
                $symbol = -1;
            }
        } else {
            if ($this->type == 'IN') {
                $symbol = -1;
            } elseif ($this->type != 'ERROR') {
                $symbol = 1;
            }
        }

        if ($plus) {
            $symbol = $symbol == 1 ? "+" : "-";
        }

        return $symbol;
    }

    /**
     * @return string
     */
    public function getSymbolAmountAttribute()
    {
        $symbol = $this->getPrefixAttribute() == 1 ? "+" : "-";

        return $symbol . round($this->amount * $this->rate, 2) . " ₼";
    }

    /**
     * @param bool $rate
     * @return string
     */
    public function symbolAdminAmountAttribute($rate = true)
    {
        $symbol = "";

        if ($this->who == 'USER') {
            if ($this->type == 'IN') {
                $symbol = "-";
                if ($this->paid_for == 'ORDER_BALANCE' || $this->paid_for == 'PACKAGE_BALANCE') {
                    $symbol = "+";
                }
            } elseif ($this->type != 'ERROR') {
                $symbol = "+";

                if ($this->paid_by == 'ORDER_BALANCE' || $this->paid_by == 'PACKAGE_BALANCE') {
                    $symbol = "-";
                }
            }
        } else {
            if ($this->type == 'IN') {
                $symbol = "+";
            } elseif ($this->type != 'ERROR') {
                $symbol = "-";
            }
        }

        return $symbol . ($rate ? (round($this->amount * $this->rate, 2) . " ₼") : ($this->amount . " " . $this->currency));
    }

    /**
     * @return string
     */
    public function getSymbolAdminAmountAttribute()
    {
        return $this->symbolAdminAmountAttribute(true);
    }

    /**
     * @return string
     */
    public function getOrgAmountAttribute()
    {
        return $this->symbolAdminAmountAttribute(false);
    }

    /**
     * @return float|int
     */
    public function getAdminAmountAttribute()
    {
        $symbol = 1;

        if ($this->who == 'USER') {
            if ($this->type == 'IN') {
                $symbol = -1;
                if ($this->paid_for == 'ORDER_BALANCE' || $this->paid_for == 'PACKAGE_BALANCE') {
                    $symbol = 1;
                }
            } elseif ($this->type != 'ERROR') {
                $symbol = 1;

                if ($this->paid_by == 'ORDER_BALANCE' || $this->paid_by == 'PACKAGE_BALANCE') {
                    $symbol = 0;
                }
            }
        } else {
            if ($this->type == 'IN') {
                $symbol = 1;
            } elseif ($this->type != 'ERROR') {
                $symbol = -1;
            }
            if ($this->paid_for == 'ORDER_BALANCE' || $this->paid_for == 'PACKAGE_BALANCE') {
                $symbol = 0;
            }
        }

        return $symbol * round($this->amount * $this->rate, 2);
    }

    /**
     * @param $packageId
     * @param string $type
     * @param string $note
     */
    public static function addPackage($packageId, $type = 'CASH', $note = null)
    {
        $package = Package::find($packageId);
        $deliveryManatPrice = $package->delivery_manat_price;

        $user = User::find($package->user_id);

        //enum('GIFT_CARD','CASH','PAY_TR','MILLION','PORTMANAT','POST_TERMINAL','REFERRAL','CASHBACK','PACKAGE_BALANCE','ORDER_BALANCE','OTHER','REFUND')
        $check = Transaction::where('custom_id', $package->id)->where('paid_for', 'PACKAGE')->where('type', 'OUT')->first();
        if ($check && $check->paid_by != 'PORTMANAT') {
            Transaction::where('custom_id', $package->id)->where('paid_for', 'PACKAGE')->delete();
        }
        if ($user && $package->delivery_price) {

            Transaction::create([
                'user_id'   => $user->id,
                'custom_id' => $package->id,
                'paid_for'  => 'PACKAGE',
                'type'      => 'OUT',
                'paid_by'   => $type,
                'note'      => $package->custom_id . ' id-li bağlamaya görə ödəmə. ' . $note,
                'amount'    => $deliveryManatPrice,
            ]);
        }
    }

    /**
     * @param $deliveryId
     * @param int $fee
     * @param string $type
     */
    public static function addDeliveryFee($deliveryId, $fee = 3, $type = 'CASH')
    {
        $delivery = Delivery::find($deliveryId);
        $user = User::find($delivery->user_id);

        if ($user) {
            Transaction::where('custom_id', $delivery->id)->where('paid_for', 'PACKAGE_SHIPPING')->delete();
            //$main = Transaction::where('custom_id', $package->id)->where('paid_for', 'PACKAGE')->where('type', 'OUT')->first();
            //$type = ($main && $main->paid_by != 'PORTMANAT') ? $main->paid_by : 'CASH';
            $check = Transaction::where('custom_id', $delivery->id)->where('paid_for', 'PACKAGE_SHIPPING')->where('type', 'OUT')->first();
            if (! $check && $fee != 0) {
                Transaction::create([
                    'user_id'   => $user->id,
                    'custom_id' => $delivery->id,
                    'paid_for'  => 'PACKAGE_SHIPPING',
                    'type'      => 'OUT',
                    'paid_by'   => $type,
                    'note'      => $delivery->id . ' id-e görə kuryer xidmət haqqı',
                    'amount'    => $fee,
                ]);
            }
        }
    }

    /**
     *
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($query) {
            $query->admin_id = auth()->guard('admin')->check() ? auth()->guard('admin')->user()->id : null;
            $query->done_at = $query->done_at ?: Carbon::now();
            if ($query->currency) {
                $rate = getCurrencyRate(1) / getCurrencyRate(array_search($query->currency, config('ase.attributes.currencies')));
                $query->rate = $query->rate ?: $rate;
            }

            if ($query->user_id) {
                $user = User::find($query->user_id);
                if ($user && $user->filial_id) {
                    $query->filial_id = $user->filial_id;
                }
            }
        });
    }

    /**
     * @return string
     */
    public function getRRNAttribute()
    {
        if (! $this->attributes['extra_data']) {
            return "-";
        }

        $data = \GuzzleHttp\json_decode($this->attributes['extra_data'], true);

        return isset($data['body']['psp_rrn']) ? $data['body']['psp_rrn'] : "-";
    }

    /**
     * @param $value
     * @return \Illuminate\Support\Carbon|null
     */
    public function getDoneAtAttribute($value)
    {
        return $value ?: $this->created_at;
    }
}
