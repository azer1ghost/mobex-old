<?php

namespace App\Models;

use App\Traits\ModelEventLogger;
use App\Traits\Password;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Watson\Rememberable\Rememberable;

/**
 * App\Models\Warehouse
 *
 * @property int $id
 * @property string|null $company_name
 * @property string|null $contact_name
 * @property string $address_line_1
 * @property string|null $address_line_2
 * @property int|null $country_id
 * @property string $phone
 * @property string|null $mobile
 * @property string $city
 * @property string|null $state
 * @property string|null $region
 * @property string $zip_code
 * @property string|null $passport
 * @property string|null $attention
 * @property string|null $reminder
 * @property float $half_kg
 * @property float $per_kg
 * @property float|null $width
 * @property float|null $height
 * @property float|null $length
 * @property int $currency
 * @property int $per_week
 * @property string $email
 * @property string $password
 * @property string|null $remember_token
 * @property \Carbon\Carbon|null $deleted_at
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \App\Models\Country|null $country
 * @property-read mixed $currency_with_label
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Package[] $packages
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Warehouse onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Warehouse whereAddressLine1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Warehouse whereAddressLine2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Warehouse whereAttention($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Warehouse whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Warehouse whereCompanyName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Warehouse whereContactName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Warehouse whereCountryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Warehouse whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Warehouse whereCurrency($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Warehouse whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Warehouse whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Warehouse whereHalfKg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Warehouse whereHeight($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Warehouse whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Warehouse whereLength($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Warehouse whereMobile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Warehouse wherePassport($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Warehouse wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Warehouse wherePerKg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Warehouse wherePerWeek($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Warehouse wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Warehouse whereRegion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Warehouse whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Warehouse whereReminder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Warehouse whereState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Warehouse whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Warehouse whereWidth($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Warehouse whereZipCode($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Warehouse withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Warehouse withoutTrashed()
 * @mixin \Eloquent
 * @property string|null $key
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Warehouse whereKey($value)
 * @property float|null $to_100g
 * @property float|null $from_100g_to_200g
 * @property float|null $from_200g_to_500g
 * @property float|null $from_500g_to_1kq
 * @property float $up_10_kg
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Warehouse whereFrom100gTo200g($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Warehouse whereFrom200gTo500g($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Warehouse whereFrom500gTo1kq($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Warehouse whereTo100g($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Warehouse whereUp10Kg($value)
 * @property float|null $per_g
 * @property int $parcelling
 * @property-read mixed $flies_per_week
 * @property-read mixed $flies_week
 * @property-read int|null $packages_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Warehouse newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Warehouse newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Warehouse query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Warehouse whereParcelling($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Warehouse wherePerG($value)
 * @property int $auto_print
 * @property int $show_invoice
 * @property int $show_label
 * @property string|null $panel_login
 * @property string|null $panel_password
 * @property-read \App\Models\Address $address
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Address[] $addresses
 * @property-read int|null $addresses_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Warehouse whereAutoPrint($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Warehouse wherePanelLogin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Warehouse wherePanelPassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Warehouse whereShowInvoice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Warehouse whereShowLabel($value)
 * @property int $allow_make_fake_invoice
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Warehouse whereAllowMakeFakeInvoice($value)
 * @property float|null $from_500g_to_750g
 * @property float|null $from_750g_to_1kq
 * @property int $has_liquid
 * @property float|null $l_to_100g
 * @property float|null $l_from_100g_to_200g
 * @property float|null $l_from_200g_to_500g
 * @property float|null $l_from_500g_to_750g
 * @property float|null $l_from_750g_to_1kq
 * @property float|null $l_half_kg
 * @property float|null $l_per_kg
 * @property float|null $l_per_g
 * @property float|null $l_up_10_kg
 * @property int $only_weight_input
 * @property float|null $limit_weight
 * @property float|null $limit_amount
 * @property int $limit_currency
 * @property string|null $web_site
 * @property int $label
 * @property int $invoice
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Warehouse whereFrom500gTo750g($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Warehouse whereFrom750gTo1kq($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Warehouse whereHasLiquid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Warehouse whereInvoice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Warehouse whereLFrom100gTo200g($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Warehouse whereLFrom200gTo500g($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Warehouse whereLFrom500gTo750g($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Warehouse whereLFrom750gTo1kq($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Warehouse whereLHalfKg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Warehouse whereLPerG($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Warehouse whereLPerKg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Warehouse whereLTo100g($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Warehouse whereLUp10Kg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Warehouse whereLabel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Warehouse whereLimitAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Warehouse whereLimitCurrency($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Warehouse whereLimitWeight($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Warehouse whereOnlyWeightInput($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Warehouse whereWebSite($value)
 * @property float $discount_dealer
 * @property float $liquid_discount_dealer
 * @property float $discount_user
 * @property float $liquid_discount_user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Warehouse whereDiscountDealer($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Warehouse whereDiscountUser($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Warehouse whereLiquidDiscountDealer($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Warehouse whereLiquidDiscountUser($value)
 * @property float|null $from_1kq_to_5kq
 * @property float|null $from_5kq_to_10kq
 * @property float|null $l_from_1kq_to_5kq
 * @property float|null $l_from_5kq_to_10kq
 * @property string|null $main_cells
 * @property string|null $liquid_cells
 * @property string|null $battery_cells
 * @property float $cell_limit_weight
 * @property float $cell_limit_amount
 * @property int $min_size_vw
 * @method static \Illuminate\Database\Eloquent\Builder|Warehouse whereBatteryCells($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Warehouse whereCellLimitAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Warehouse whereCellLimitWeight($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Warehouse whereFrom1kqTo5kq($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Warehouse whereFrom5kqTo10kq($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Warehouse whereLFrom1kqTo5kq($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Warehouse whereLFrom5kqTo10kq($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Warehouse whereLiquidCells($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Warehouse whereMainCells($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Warehouse whereMinSizeVw($value)
 */
class Warehouse extends Authenticatable
{
    use Rememberable;
    use SoftDeletes;
    use Password;
    use ModelEventLogger;

    /**
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * @var array
     */
    protected $appends = ['currency_with_label'];

    /**
     * @var array
     */
    public $with = ['country', 'addresses'];

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
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function country()
    {
        return $this->belongsTo('App\Models\Country');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function packages()
    {
        return $this->hasMany('App\Models\Package');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function address()
    {
        return $this->hasOne('App\Models\Address');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function addresses()
    {
        return $this->hasMany('App\Models\Address');
    }

    /**
     * @return mixed
     */
    public function getCurrencyWithLabelAttribute()
    {
        return config('ase.attributes.currencies')[$this->attributes['currency']];
    }

    /**
     * @return mixed
     */
    public function getFliesPerWeekAttribute()
    {
        $flies = $this->attributes['per_week'];
        $exploded = explode("/", $flies);

        return isset($exploded[1]) ? $exploded[1] : $exploded[0];
    }

    /**
     * @return |null
     */
    public function getFliesWeekAttribute()
    {
        $flies = $this->attributes['per_week'];
        $exploded = explode("/", $flies);

        return isset($exploded[1]) ? $exploded[0] : null;
    }

    /**
     * Calculate delivery price
     *
     * @param $weight
     * @param int $weightUnit
     * @param null $width
     * @param null $height
     * @param null $length
     * @param int $sizeUnit
     * @param bool $showCurrency
     * @param null $user
     * @param bool $hasLiquid
     * @return bool|string
     */
    public function calculateDeliveryPrice(
        $weight,
        $weightUnit = 0,
        $width = null,
        $height = null,
        $length = null,
        $sizeUnit = 0,
        $showCurrency = false,
        $user = null,
        $hasLiquid = false
    ) {
        $result = 0;

        $weight = ((float) str_replace(",", ".", $weight)) * config('ase.attributes.weightConvert')[$weightUnit];
        if (isset(config('ase.attributes.lengthConvert')[$sizeUnit])) {
            if ($width) {
                $width = ((float) $width) * config('ase.attributes.lengthConvert')[$sizeUnit];
            }
            if ($height) {
                $height = ((float) $height) * config('ase.attributes.lengthConvert')[$sizeUnit];
            }
            if ($length) {
                $length = ((float) $length) * config('ase.attributes.lengthConvert')[$sizeUnit];
            }
        }

        $minSize = $this->min_size_vw;

        $size_index = ($this->country && $this->country->delivery_index && ($width > $minSize && $height > $minSize && $length > $minSize)) ? ($width * $height * $length / $this->country->delivery_index) : 0;

        $kq = $size_index > $weight ? $size_index : $weight;

        $discount = 0;

        $type = $user ? strtolower($user->type) : 'user';
        $mainDiscountKey = "discount";
        $discountKey = $mainDiscountKey . "_" . $type;

        if ($kq) {

            if ($hasLiquid && $this->has_liquid) {

                $discountKey = 'liquid_' . $discountKey;
                $mainDiscountKey = 'liquid_' . $mainDiscountKey;

                if ($this->l_per_g) {
                    if ($kq <= 0.5) {
                        $result = $this->l_half_kg;
                    } else {
                        $result = $this->l_half_kg + ($this->l_per_g * ($kq - 0.5) * 1000);
                    }
                } else {
                    if ($kq <= 0.1) {
                        $result = $this->l_to_100g ?: $this->l_half_kg;
                    } elseif ($kq > 0.1 && $kq <= 0.2) {
                        $result = $this->l_from_100g_to_200g ?: $this->l_half_kg;
                    } elseif ($kq > 0.2 && $kq <= 0.5) {
                        $result = $this->l_from_200g_to_500g ?: $this->l_half_kg;
                    } elseif ($kq > 0.5 && $kq <= 0.75) {
                        $result = $this->l_from_500g_to_750g ?: $this->l_per_kg;
                    } elseif ($kq > 0.75 && $kq <= 1) {
                        $result = $this->l_from_750g_to_1kq ?: $this->l_per_kg;
                    } elseif ($kq > 1 && $kq <= 5) {
                        $result = ($this->l_from_1kq_to_5kq ?: $this->l_per_kg) * $kq;
                    } elseif ($kq > 5 && $kq <= 10) {
                        $result = ($this->l_from_5kq_to_10kq ?: $this->l_per_kg) * $kq;
                    } elseif ($kq >= 10) {
                        $result = ($this->l_up_10_kg ?: $this->l_per_kg) * $kq;
                    } else {
                        $result = $this->l_per_kg * $kq;
                    }
                }
            } else {
                if ($this->per_g) {
                    if ($kq <= 0.5) {
                        $result = $this->half_kg;
                    } else {
                        $result = $this->half_kg + ($this->per_g * ($kq - 0.5) * 1000);
                    }
                } else {
                    if ($kq <= 0.1) {
                        $result = $this->to_100g ?: $this->half_kg;
                    } elseif ($kq > 0.1 && $kq <= 0.2) {
                        $result = $this->from_100g_to_200g ?: $this->half_kg;
                    } elseif ($kq > 0.2 && $kq <= 0.5) {
                        $result = $this->from_200g_to_500g ?: $this->half_kg;
                    } elseif ($kq > 0.5 && $kq <= 0.75) {
                        $result = $this->from_500g_to_750g ?: $this->per_kg;
                    } elseif ($kq > 0.75 && $kq <= 1) {
                        $result = $this->from_750g_to_1kq ?: $this->per_kg;
                    } elseif ($kq > 1 && $kq <= 5) {
                        $result = ($this->from_1kq_to_5kq ?: $this->per_kg) * $kq;
                    } elseif ($kq > 5 && $kq <= 10) {
                        $result = ($this->from_5kq_to_10kq ?: $this->per_kg) * $kq;
                    } elseif ($kq >= 10) {
                        $result = ($this->up_10_kg ?: $this->per_kg) * $kq;
                    } else {
                        $result = $this->per_kg * $kq;
                    }
                }
            }
        }

        if ($type && $this->{$discountKey} && $this->{$discountKey} > $discount) {
            $discount = $this->{$discountKey};
        }

        if ($user) {

            if ($user->{$mainDiscountKey} && $user->{$mainDiscountKey} > $discount) {
                $discount = $user->{$mainDiscountKey};
            }

            if ($user->sent_by_post && $user->zip_code) {
                if ($user->azerpoctBranch) {
                    $azerpoctFee = $user->azerpoctBranch->getFee($kq);
                    $result += $azerpoctFee;
                }
            }
        }

        if ($discount) {
            $result = $result * (1 - floatval($discount) / 100);
        }

        return $result ? (round($result, 2) . ($showCurrency ? (" " . $this->currency_with_label) : null)) : False;
    }

    /**
     * Flush cache
     */
    protected static function boot()
    {
        parent::boot();

        static::updated(function ($query) {
            \Cache::forget('countries');
            \Cache::forget('main_warehouse');
        });

        static::created(function ($query) {
            \Cache::forget('countries');
            \Cache::forget('main_warehouse');
        });

        static::deleted(function ($query) {
            \Cache::forget('countries');
            \Cache::forget('main_warehouse');
        });
    }
}
