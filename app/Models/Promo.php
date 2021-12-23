<?php

namespace App\Models;

use App\Traits\ModelEventLogger;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Promo
 *
 * @property int $id
 * @property string|null $title
 * @property string $code
 * @property float $discount
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\User[] $users
 * @property-read int|null $users_count
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Promo newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Promo newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Promo onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Promo query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Promo whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Promo whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Promo whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Promo whereDiscount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Promo whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Promo whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Promo whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Promo whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Promo withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Promo withoutTrashed()
 * @mixin \Eloquent
 * @property float|null $l_discount
 * @property float|null $order_balance
 * @property float|null $package_balance
 * @property int|null $limited_use
 * @property string|null $end_date
 * @property int $action
 * @property int $checked
 * @property-read mixed $efficiency
 * @property-read mixed $package_query
 * @property-read mixed $package_weight
 * @property-read mixed $transactions_query
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\User[] $prod
 * @property-read int|null $prod_count
 * @method static \Illuminate\Database\Eloquent\Builder|Promo whereAction($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Promo whereChecked($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Promo whereEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Promo whereLDiscount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Promo whereLimitedUse($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Promo whereOrderBalance($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Promo wherePackageBalance($value)
 */
class Promo extends Model
{
    use SoftDeletes;
    use ModelEventLogger;

    public $dates = ['deleted_at'];

    protected $withCount = ['users', 'prod'];

    public function users()
    {
        return $this->hasMany('App\Models\User');
    }

    public function prod()
    {
        return $this->hasMany('App\Models\User')->whereHas('transactions', function ($q) {
            return $q->where('paid_by', '!=', 'BONUS');
        });
    }

    public function getPackageWeightAttribute()
    {
        $sum = Package::whereIn('user_id', $this->users->pluck('id')->all())->sum('weight');

        return round($sum, 2) . " kg";
    }

    public function getEfficiencyAttribute()
    {
        return ($this->users_count != 0 ? (round(100 * $this->prod_count / $this->users_count, 2)) : 0) . "%";
    }

    public function getPackageQueryAttribute()
    {
        return route('packages.index') . "?promo_id=" . $this->id . "&limit=500";
    }

    public function getTransactionsQueryAttribute()
    {
        return route('transactions.index') . "?promo_id=" . $this->id . "&limit=500";
    }
}
