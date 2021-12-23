<?php

namespace App\Models;

use App\Traits\ModelEventLogger;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Order
 *
 * @property int $id
 * @property int $user_id
 * @property string $custom_id
 * @property string|null $note
 * @property string|null $extra_contacts
 * @property string|null $admin_note
 * @property string|null $affiliate
 * @property string|null $price
 * @property string|null $service_fee
 * @property string|null $coupon_sale
 * @property string|null $total_price
 * @property int|null $package_id
 * @property int|null $country_id
 * @property int $status
 * @property \Carbon\Carbon|null $deleted_at
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \App\Models\Country|null $country
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Link[] $links
 * @property-read \App\Models\Package|null $package
 * @property-read \App\Models\User $user
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Order onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order whereAdminNote($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order whereAffiliate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order whereCountryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order whereCouponSale($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order whereCustomId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order whereExtraContacts($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order whereNote($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order wherePackageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order whereServiceFee($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order whereTotalPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Order withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Order withoutTrashed()
 * @mixin \Eloquent
 * @property-read mixed $status_info
 * @property-read int|null $links_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order query()
 * @property int $paid
 * @property-read string $paid_info
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order wherePaid($value)
 * @property int|null $admin_id
 * @property int|null $card_id
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order whereAdminId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order whereCardId($value)
 * @property float|null $admin_paid
 * @property string|null $delivery_date
 * @property-read \App\Models\Admin|null $admin
 * @property-read \App\Models\Card|null $card
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order whereAdminPaid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order whereDeliveryDate($value)
 * @property \Illuminate\Support\Carbon|null $paid_at
 * @property-read \App\Models\Package|null $declaration
 * @property-read mixed $response
 * @property-read mixed $status_with_label
 * @method static \Illuminate\Database\Eloquent\Builder|Order wherePaidAt($value)
 */
class Order extends Model
{
    use SoftDeletes;
    use ModelEventLogger;

    /**
     * @var array
     */
    public $with = ['user', 'country', 'admin', 'card'];

    /**
     * @var array
     */
    public $dates = ['deleted_at', 'paid_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User')->withTrashed();
    }

    /**
     * @return mixed
     */
    public function admin()
    {
        return $this->belongsTo('App\Models\Admin')->withTrashed();
    }

    /**
     * @return mixed
     */
    public function declaration()
    {
        return $this->hasOne('App\Models\Package')->withTrashed();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function card()
    {
        return $this->belongsTo('App\Models\Card');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function country()
    {
        return $this->belongsTo('App\Models\Country');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function package()
    {
        return $this->belongsTo('App\Models\Package');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function links()
    {
        return $this->hasMany('App\Models\Link');
    }

    /**
     * @return array
     */
    public function getStatusInfoAttribute()
    {
        $labels = ['warning', 'info', 'primary', 'success', 'danger', 'success'];

        return [
            'text'  => trans(config('ase.attributes.request.statusTrans')[$this->attributes['status']]),
            'label' => $labels[$this->attributes['status']],
        ];
    }

    /**
     * @return string
     */
    public function getPaidInfoAttribute()
    {
        $labels = [trans('front.user_orders.status_paid'), trans('front.user_orders.status_not_paid')];

        if ($this->attributes['paid'] == 1) {
            return $labels[0];
        } else {
            return $labels[1];
        }
    }

    /**
     *
     */
    protected static function boot()
    {
        parent::boot();

        static::updating(function ($query) {

            // set admin
            if (auth()->guard('admin')->check() && ! $query->admin_id) {
                $query->admin_id = auth()->guard('admin')->user()->id;
            }

            // set paid data
            if (! auth()->guard('admin')->check() && $query->paid == 1 && ! $query->admin_id) {
                $query->paid_at = Carbon::now();
                $admin_id = null;
                $tt = null;

                // Determine admin for purchase
                $previousUser = Order::where('user_id', $query->user_id)->where('status', 1)->first();
                if ($previousUser && $previousUser->admin_id) {
                    $admin_id = $previousUser->admin_id;
                } else {
                    $admins = Admin::where('separate_order', 1)->orderBy('id', 'asc')->pluck('id')->all();
                    $last = Order::whereNotNull('admin_id')->latest()->first();
                    if ($last) {
                        $lastAdmin = $last->admin_id;
                        $find = array_search($lastAdmin, $admins);

                        if ($admins) {
                            if ($find !== false) {
                                $index = ($find + 1) % count($admins);
                                $admin_id = $admins[$index];
                            } else {
                                $admin_id = $admins[array_rand($admins)];
                            }
                        }
                    }
                }

                $query->admin_id = $admin_id;
            }
        });
    }

    /**
     * @return mixed
     */
    public function getStatusWithLabelAttribute()
    {
        return config('ase.attributes.request.status')[$this->attributes['status']];
    }

    /**
     * Calculate response time
     *
     * @return string
     */
    public function getResponseAttribute()
    {
        $diffBy = $this->status > 1 ? $this->updated_at : Carbon::now();

        return $this->paid_at ? ($diffBy->diff($this->paid_at)->format('%H:%I:%S')) : '-';
    }
}
