<?php

namespace App\Models;

use App\Models\Extra\SMS;
use App\Notifications\ResetPassword;
use App\Traits\ModelEventLogger;
use App\Traits\Password;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Lunaweb\EmailVerification\Traits\CanVerifyEmail;
use Lunaweb\EmailVerification\Contracts\CanVerifyEmail as CanVerifyEmailContract;

/**
 * App\Models\User
 *
 * @property int $id
 * @property string $name
 * @property string $surname
 * @property string $email
 * @property string $password
 * @property string|null $phone
 * @property string $passport
 * @property string $customer_id
 * @property string|null $address
 * @property string|null $city
 * @property string|null $company
 * @property string|null $remember_token
 * @property \Carbon\Carbon|null $login_at
 * @property \Carbon\Carbon|null $deleted_at
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereCompany($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereCustomerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereLoginAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User wherePassport($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereSurname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User withoutTrashed()
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Package[] $packages
 * @property string|null $zip_code
 * @property-read mixed $full_name
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereZipCode($value)
 * @property string|null $birthday
 * @property int $gender
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereBirthday($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereGender($value)
 * @property string|null $old_password
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereOldPassword($value)
 * @property string|null $friend_reference
 * @property string|null $pass_key
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereFriendReference($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User wherePassKey($value)
 * @property string|null $fin
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereFin($value)
 * @property string|null $sms_verification_code
 * @property int $sms_verification_status
 * @property bool $verified
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereSmsVerificationCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereSmsVerificationStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereVerified($value)
 * @property int|null $city_id
 * @property int $check_verify
 * @property-read mixed $city_name
 * @property-read mixed $cleared_phone
 * @property-read mixed $pos_passport
 * @property-read mixed $pre_passport
 * @property-read mixed $rate
 * @property-read int|null $notifications_count
 * @property-read int|null $packages_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereCheckVerify($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereCityId($value)
 * @property int|null $parent_id
 * @property string $status
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\User[] $children
 * @property-read int|null $children_count
 * @property-read \App\Models\User|null $dealer
 * @property-read mixed $is_banned
 * @property-read mixed $order_balance
 * @property-read mixed $package_balance
 * @property-read mixed $referral_balance
 * @property-read mixed $referrer_balance
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Transaction[] $referralTransactions
 * @property-read int|null $referral_transactions_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\User[] $referrals
 * @property-read int|null $referrals_count
 * @property-read \App\Models\User $referrer
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Transaction[] $transactions
 * @property-read int|null $transactions_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereStatus($value)
 * @property string|null $district
 * @property int|null $district_id
 * @property int $elite
 * @property float $discount
 * @property-read mixed $total_discount
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereDiscount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereDistrict($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereDistrictId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereElite($value)
 * @property float $liquid_discount
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereLiquidDiscount($value)
 * @property string $type
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereType($value)
 * @property int $notification
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereNotification($value)
 * @property int|null $filial_id
 * @property int|null $promo_id
 * @property string $logo
 * @property-read mixed $full_district
 * @property-read mixed $spending
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereFilialId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereLogo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User wherePromoId($value)
 * @property-read \App\Models\Filial|null $filial
 * @property-read mixed|string $filial_name
 * @property int $refresh_customs
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereRefreshCustoms($value)
 * @property string|null $ios_device_id
 * @property string|null $android_device_id
 * @property string|null $web_device_id
 * @property string|null $other_device_id
 * @property int $campaign_notifications
 * @property int $auto_charge
 * @property-read \App\Models\Promo|null $promo
 * @method static \Illuminate\Database\Eloquent\Builder|User whereAndroidDeviceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereAutoCharge($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCampaignNotifications($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereIosDeviceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereOtherDeviceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereWebDeviceId($value)
 */
class User extends Authenticatable implements CanVerifyEmailContract
{
    use Notifiable;
    use SoftDeletes;
    use Password;
    use CanVerifyEmail;
    use ModelEventLogger;

    /**
     * @var array
     */
    protected $with = ['filial', 'dealer'];

    /**
     * @var string[]
     */
    protected $appends = ['full_name'];

    /**
     * @var array
     */
    protected $dates = ['login_at', 'deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'parent_id',
        'name',
        'surname',
        'phone',
        'passport',
        'fin',
        'company',
        'email',
        'password',
        'customer_id',
        'city_id',
        'district_id',
        'address',
        'notification',
        'sms_verification_code',
        'sms_verification_status',
        'discount',
        'liquid_discount',
        'promo_id',
        'filial_id',
        'gender',
        'verified',
        'refresh_customs'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * @var string[]
     */
    //protected $with = ['city', 'district'];

    /**
     * @var string
     */
    public $uploadDir = 'uploads/setting/';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function dealer()
    {
        return $this->belongsTo(User::class, 'parent_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function children()
    {
        return $this->hasMany(User::class, 'parent_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function packages()
    {
        return $this->hasMany('App\Models\Package');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function referralTransactions()
    {
        return $this->hasMany(Transaction::class, 'referral_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function promo()
    {
        return $this->belongsTo(Promo::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function district()
    {
        return $this->belongsTo(District::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function referrer()
    {
        return $this->belongsTo(User::class, 'referred_by');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function referrals()
    {
        return $this->hasMany(User::class, 'referred_by');
    }

    /**
     * @param string $token
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPassword($token));
    }

    /**
     * Generate unique costumer number
     *
     * @param null $pre
     * @return string
     */
    public static function generateCode($pre = null)
    {
        $prefix = $pre ?: env('MEMBER_PREFIX_CODE', 'ASE');
        $chars = '0123456789';
        $latestUser = User::orderBy('id', 'DESC')->first();
        $latestBest = $latestUser ? $latestUser->id : 1;
        $latest = null;
        $count = 0;
        do {
            for ($x = 0; $x < 5; $x++) {
                $latest .= $chars[rand(0, strlen($chars) - 1)];
            }

            $code = $prefix . substr((string) $latest, 0, 5);
            $check = User::whereCustomerId($code)->first();
            if (! $check) {
                break;
            }
            $count++;
            if ($count >= 2) {
                $code = $prefix . sprintf("%04d", $latestBest + 1);
                break;
            }
        } while (true);

        return $code;
    }

    /**
     * Just in case replacement for admin mistakes
     *
     * @param $value
     * @return string|string[]
     */
    public function getCustomerIdAttribute($value)
    {
        return str_replace("-", "", $value);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function city()
    {
        return $this->belongsTo(City::class, 'city_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function filial()
    {
        return $this->belongsTo(Filial::class, 'filial_id');
    }

    /**
     * @return mixed|string
     */
    public function getCityNameAttribute()
    {
        return isset($this->attributes['city_id']) ? ($this->city ? $this->city->name : 'Bakı') : 'Bakı';
    }

    /**
     * @return mixed|string
     */
    public function getFilialNameAttribute()
    {
        return isset($this->attributes['filial_id']) ? ($this->filial ? $this->filial->name : 'Merkez') : 'Merkez';
    }

    /**
     * @return string
     */
    public function getFullDistrictAttribute()
    {
        return ucwords(str_slug(($this->city ? $this->city->name : "UnKnown") . " - " . ($this->district ? $this->district->name : "UnKnown"), " "));
    }

    /**
     * Profile feel rate calculation
     *
     * @return float
     */
    public function getRateAttribute()
    {
        $rateIndex = [
            'phone'                   => 1,
            'passport'                => 1,
            'fin'                     => 1,
            'address'                 => 1,
            'city_id'                 => 1,
            'company'                 => 1,
            'zip_code'                => 1,
            'birthday'                => 1,
            'gender'                  => 1,
            'verified'                => 1,
            'sms_verification_status' => 1,
        ];

        $totalRate = array_sum($rateIndex);

        $rate = 0;
        foreach ($rateIndex as $field => $index) {
            if (! empty($this->attributes[$field])) {
                $rate += $index;
            }
        }

        return round(100 * $rate / $totalRate, 2);
    }

    /**
     * @param $value
     * @return string
     */
    public function getEmailAttribute($value)
    {
        return strtolower($value);
    }

    /**
     * @return string|string[]
     */
    public function getPrePassportAttribute()
    {
        $num = preg_replace('/[^0-9]/', '', $this->attributes['passport']);

        $rt = str_replace($num, "", $this->attributes['passport']);
        $rt = str_replace("-", "", $rt);

        return $rt;
    }

    /**
     * @return string|string[]|null
     */
    public function getPosPassportAttribute()
    {
        return preg_replace('/[^0-9]/', '', $this->attributes['passport']);
    }

    /**
     * @return string|string[]|null
     */
    public function getClearedPhoneAttribute()
    {
        return SMS::clearNumber($this->attributes['phone'], true);
    }

    /**
     * @param $value
     * @return string
     */
    public function getPassportAttribute($value)
    {
        return strtoupper($value);
    }

    /**
     * @return string
     */
    public function getFullNameAttribute()
    {
        return ucfirst(Str::slug($this->attributes['name'], '_')) . ' ' . ucfirst(Str::slug($this->attributes['surname'], '_'));
    }

    /**
     * @param $value
     * @return string|null
     */
    public function getFinAttribute($value)
    {
        return $value ? strtoupper($value) : null;
    }

    /**
     * @param bool $symbol
     * @return string
     */
    public function packageBalance($symbol = false)
    {

        $in = $this->transactions()->where('type', '!=', 'ERROR')->where('paid_for', 'PACKAGE_BALANCE')->get();
        $out = $this->transactions()->where('type', '!=', 'ERROR')->where('paid_for', 'PACKAGE')->where('paid_by', 'PACKAGE_BALANCE')->get();

        if ($in) {
            $inTotal = 0;
            foreach ($in as $value) {
                $inTotal += $value->prefix * $value->amount * $value->rate;
            }

            $outTotal = 0;
            foreach ($out as $value) {
                $outTotal += $value->prefix * $value->amount * $value->rate;
            }
            $balance = $inTotal + $outTotal;
        }

        return round($balance, 2) . ($symbol ? ' ₼' : null);
    }

    /**
     * @param bool $symbol
     * @return string
     */
    public function orderBalance($symbol = false)
    {
        $balance = 0;

        $in = $this->transactions()->where('type', '!=', 'ERROR')->where('paid_for', 'ORDER_BALANCE')->get();
        $out = $this->transactions()->where('type', '!=', 'ERROR')->where('paid_for', 'ORDER')->where('paid_by', 'ORDER_BALANCE')->get();

        if (1) {
            $inTotal = 0;

            foreach ($in as $value) {
                $rate = $value->currency == 'TRY' ? 1 : (getCurrencyRate(3) / getCurrencyRate(1));
                $inTotal += $value->prefix * $value->amount * $rate;
            }

            $outTotal = 0;

            foreach ($out as $value) {
                $rate = $value->currency == 'TRY' ? 1 : (getCurrencyRate(3) / getCurrencyRate(1));
                $outTotal += $value->prefix * $value->amount * $rate;
            }

            $balance = $inTotal + $outTotal;
        }

        return round($balance, 2) . ($symbol ? ' ₺' : null);
    }

    /**
     * @return string
     */
    public function getReferralBalanceAttribute()
    {
        return $this->transactions()->where('paid_by', 'REFERRAL')->sum('amount') . ' ₼';
    }

    /**
     * @return string
     */
    public function getPackageBalanceAttribute()
    {

        return $this->packageBalance(true);
    }

    /**
     * @return string
     */
    public function getOrderBalanceAttribute()
    {

        return $this->orderBalance(true);
    }

    /**
     * @return string
     */
    public function getReferrerBalanceAttribute()
    {
        $total = $this->referralTransactions()->sum('amount');

        return $total . ' ₼';
    }

    /**
     * @return bool
     */
    public function getIsBannedAttribute()
    {
        return $this->attributes['status'] == 'BANNED';
    }

    /**
     * @return mixed
     */
    public function getTotalDiscountAttribute()
    {
        return $this->attributes['discount'];
    }

    /**
     * Logo attribute
     *
     * @param $value
     * @return string
     */
    public function getLogoAttribute($value)
    {
        return $value ? (str_contains($value, '//') ? $value : asset($this->uploadDir . $value)) : asset(config('ase.default.no-image'));
    }

    /**
     * @return string
     */
    public function getSpendingAttribute()
    {
        $sum = $this->spending();

        return $sum > 290 ? "Don't sent" : ((300 - $sum) . "$");
    }

    /**
     * Monthly spending
     *
     * @return int
     */
    public function spending()
    {
        $startForExists = Carbon::now()->firstOfMonth()->format('Y-m-d h:i:s');

        $data = Package::where('user_id', $this->id)->where(function ($query) use ($startForExists) {
            $query->where(function ($query) use ($startForExists) {
                $query->whereNotNull('sent_at')->where('sent_at', '>=', $startForExists);
            })->orWhere('status', 0);
        })->get();

        $sum = 0;

        if ($data) {
            foreach ($data as $package) {
                $sum += $package->total_price;
            }
        }

        return $sum;
    }

    public function referral()
    {
        return $this->hasOne(Referral::class);
    }
}
