<?php

namespace App\Models;

use App\Traits\ModelEventLogger;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Milon\Barcode\DNS1D;

/**
 * App\Models\Package
 *
 * @property int $id
 * @property int|null $user_id
 * @property int|null $warehouse_id
 * @property int|null $country_id
 * @property string $custom_id
 * @property mixed $weight
 * @property int $weight_type
 * @property float|null $width
 * @property float|null $height
 * @property float|null $length
 * @property int $length_type
 * @property string|null $tracking_code
 * @property string|null $website_name
 * @property int|null $type_id
 * @property int|null $number_items
 * @property float|null $shipping_amount
 * @property int $shipping_amount_cur
 * @property string $invoice
 * @property string|null $user_comment
 * @property string|null $warehouse_comment
 * @property string|null $screen_file
 * @property string|null $admin_comment
 * @property int $show_label
 * @property int|null $declaration
 * @property float|null $delivery_price
 * @property int $status
 * @property int $paid
 * @property \Carbon\Carbon|null $deleted_at
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \App\Models\Country|null $country
 * @property-read mixed $country_flag
 * @property-read mixed $delivery_price_with_label
 * @property-read string $full_size
 * @property-read mixed $paid_with_label
 * @property-read string $shipping_price
 * @property-read mixed $show_label_with_label
 * @property-read mixed $size
 * @property-read mixed $size_unit
 * @property-read mixed $status_label
 * @property-read mixed $status_with_label
 * @property-read mixed $total_price
 * @property-read mixed $web_site_logo
 * @property-read mixed $weight_unit
 * @property-read string $weight_with_type
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\PackageLog[] $logs
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\PackageOwner[] $owners
 * @property-read \App\Models\PackageType|null $type
 * @property-read \App\Models\User|null $user
 * @property-read \App\Models\Warehouse|null $warehouse
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Package done()
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Package onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Package whereAdminComment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Package whereCountryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Package whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Package whereCustomId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Package whereDeclaration($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Package whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Package whereDeliveryPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Package whereHeight($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Package whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Package whereInvoice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Package whereLength($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Package whereLengthType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Package whereNumberItems($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Package wherePaid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Package whereScreenFile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Package whereShippingAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Package whereShippingAmountCur($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Package whereShowLabel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Package whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Package whereTrackingCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Package whereTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Package whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Package whereUserComment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Package whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Package whereWarehouseComment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Package whereWarehouseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Package whereWebsiteName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Package whereWeight($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Package whereWeightType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Package whereWidth($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Package withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Package withoutTrashed()
 * @mixin \Eloquent
 * @property-read mixed $total_price_with_label
 * @property-read mixed $delivery_manat_price
 * @property-read int|null $logs_count
 * @property-read int|null $owners_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Package newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Package newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Package query()
 * @property string|null $other_type
 * @property int $dec_message
 * @property-read mixed $merged_delivery_price
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Parcel[] $parcel
 * @property-read int|null $parcel_count
 * @property-read \App\Models\Transaction $portmanat
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Package likeTracking($code)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Package whereDecMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Package whereOtherType($value)
 * @property float|null $gross_weight
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Package ready()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Package whereGrossWeight($value)
 * @property float|null $shipping_fee
 * @property int $has_liquid
 * @property \Illuminate\Support\Carbon|null $scanned_at
 * @property string|null $requested_at
 * @property string|null $cell
 * @property string $detailed_type
 * @property-read int $alert
 * @property-read bool $dont_delete
 * @property-read false|mixed $fake_address
 * @property-read bool $is_ready
 * @property-read float|int|mixed $net_weight
 * @property-read string $paid_by
 * @property-read float|null $shipping_converted_price
 * @property-read string $shipping_org_price
 * @property-read float|int $volume_weight
 * @property-read mixed|string $worker
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Worker[] $manager
 * @property-read int|null $manager_count
 * @property-read \App\Models\Transaction $transaction
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Package whereCell($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Package whereDetailedType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Package whereHasLiquid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Package whereRequestedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Package whereScannedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Package whereShippingFee($value)
 * @property int|null $filial_id
 * @property int $print_invoice
 * @property \Illuminate\Support\Carbon|null $sent_at
 * @property-read mixed $label_logo
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Package whereFilialId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Package wherePrintInvoice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Package whereSentAt($value)
 * @property int $check_limit
 * @property string|null $categories
 * @property int|null $custom_status
 * @property string|null $custom_comment
 * @property string|null $ref_number
 * @property-read mixed $customs_type
 * @property-read mixed $depo_dept
 * @property-read mixed $depo_dept_exp
 * @property-read mixed $invoice_numbers
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Package whereCategories($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Package whereCheckLimit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Package whereCustomComment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Package whereCustomStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Package whereRefNumber($value)
 * @property int|null $worker_id
 * @property int|null $order_id
 * @property string|null $links
 * @property string|null $custom_awb
 * @property string|null $custom_parcel_number
 * @property int $has_battery
 * @property \Illuminate\Support\Carbon|null $arrived_at
 * @property \Illuminate\Support\Carbon|null $done_at
 * @property string|null $warehouse_cell
 * @property string|null $custom_data
 * @property string|null $reg_number
 * @property int $notified
 * @method static \Illuminate\Database\Eloquent\Builder|Package whereArrivedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Package whereCustomAwb($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Package whereCustomData($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Package whereCustomParcelNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Package whereDoneAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Package whereHasBattery($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Package whereLinks($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Package whereNotified($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Package whereOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Package whereRegNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Package whereWarehouseCell($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Package whereWorkerId($value)
 */
class Package extends Model
{
    use SoftDeletes;
    use ModelEventLogger;

    /**
     * @var string
     */
    public $uploadDir = 'uploads/packages/';

    /**
     * @var array
     */
    protected $appends = ['full_size', 'weight_with_type', 'status_label', 'shipping_price', 'total_price'];

    /**
     * @var array
     */
    public $with = ['type', 'warehouse', 'branch', 'user', 'country', 'manager'];

    /**
     * @var array
     */
    public $dates = ['deleted_at', 'scanned_at', 'sent_at', 'requested_at', 'arrived_at', 'done_at', 'branch_arrived_at'];

    /* * * * * * * *
     *  Relations *
     * * * * * * * */
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function country()
    {
        return $this->belongsTo('App\Models\Country');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function parcel()
    {
        return $this->belongsToMany(Parcel::class, 'parcel_package')->orderBy('parcel_id', 'desc');
    }

    /**
     * @return mixed|null
     */
    public function main_parcel()
    {
        return ($this->belongsToMany(Parcel::class, 'parcel_package'))->first();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User')->withTrashed();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function warehouse()
    {
        return $this->belongsTo('App\Models\Warehouse')->withTrashed();
    }

    /**
     * @return string|null
     */
    public function getCountryFlagAttribute()
    {
        $country = $this->defaultCountry();

        return $country ? $country->flag : null;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function type()
    {
        return $this->belongsTo('App\Models\PackageType', 'type_id')->withTrashed();
    }

    public function getCustomsTypeAttribute($lang = 'az')
    {
        if ($this->attributes['categories'] != null) {
            $explode = explode(',', $this->attributes['categories']);

            $packageTypes = PackageType::whereIn('custom_id', $explode)->get();

            $packageTypeLine = null;

            if ($packageTypes) {
                foreach ($packageTypes as $packageType) {
                    $packageTypeLine .= $packageType->translateOrDefault($lang)->name . " / ";
                    if ($lang != 'az') {
                        break;
                    }
                }
            }

            return $packageTypeLine ? $packageTypeLine : 'Digər';
        }

        $type = explode("x", explode(";", $this->detailed_type)[0]);
        $type = isset($type[1]) ? $type[1] : $type[0];

        return $type ?: 'Digər';
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function owners()
    {
        return $this->hasMany('App\Models\PackageOwner');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function logs()
    {
        return $this->hasMany(PackageLog::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function portmanat()
    {
        return $this->hasOne(Transaction::class, 'custom_id')->where('type', 'OUT')->whereIn('paid_for', [
            'PACKAGE_BALANCE',
            'PACKAGE',
        ])->where('paid_by', 'PORTMANAT');
    }


    /* * * * * * * *
     * Attributes *
     * * * * * * */

    /**
     * @param $value
     * @return mixed
     */
    public function getWeightAttribute($value)
    {
        return $value + 0;
    }

    /**
     * @return mixed
     */
    public function getWeightUnitAttribute()
    {
        return config('ase.attributes.weight')[$this->attributes['weight_type']];
    }

    /**
     * @return string
     */
    public function getWeightWithTypeAttribute()
    {
        return ($this->attributes['weight'] + 0) . ' ' . config('ase.attributes.weight')[$this->attributes['weight_type']];
    }

    /**
     * @return string
     */
    public function getFullSizeAttribute()
    {
        return ($this->attributes['width'] + 0) . '/' . ($this->attributes['height'] + 0) . '/' . ($this->attributes['length'] + 0) . "(" . config('ase.attributes.length')[$this->attributes['length_type']] . ")";
    }

    /**
     * @return string
     */
    public function getSizeAttribute()
    {
        $size = $this->attributes['width'] and $this->attributes['height'];

        return ($this->attributes['width'] + 0) . '/' . ($this->attributes['height'] + 0) . '/' . ($this->attributes['length'] + 0);
    }

    /**
     * @return mixed
     */
    public function getSizeUnitAttribute()
    {
        return config('ase.attributes.length')[$this->attributes['length_type']];
    }

    /**
     * @return mixed
     */
    public function getStatusLabelAttribute()
    {
        return config('ase.attributes.package.status')[$this->attributes['status']];
    }

    /**
     * @return float|null
     */
    public function getShippingConvertedPriceAttribute()
    {
        $country = $this->defaultCountry();

        return $country && $country->convert_invoice_to_usd ? (round($this->shipping_amount * 1 / getCurrencyRate($this->attributes['shipping_amount_cur']), 2)) : $this->shipping_amount;
    }

    /**
     * @return string
     */
    public function getShippingPriceAttribute()
    {
        $country = $this->defaultCountry();

        return $country && $country->convert_invoice_to_usd ? (number_format(0 + round($this->shipping_amount * 1 / getCurrencyRate($this->attributes['shipping_amount_cur']), 2), 2, ".", " ") . " USD") : ($this->shipping_amount . " " . config('ase.attributes.currencies')[$this->attributes['shipping_amount_cur']]);
    }

    /**
     * @return string
     */
    public function getShippingOrgPriceAttribute()
    {
        return ($this->shipping_amount . " " . config('ase.attributes.currencies')[$this->attributes['shipping_amount_cur']]);
    }

    /**
     * @param $value
     * @return string
     */
    public function getInvoiceAttribute($value)
    {
        $invoice = ($this->warehouse && $this->warehouse->allow_make_fake_invoice) ? route('custom_invoice', $this->id) : null;

        return $value ? asset($this->uploadDir . $value) : $invoice;
    }

    /**
     * @return mixed
     */
    public function getStatusWithLabelAttribute()
    {
        return config('ase.attributes.package.status')[$this->attributes['status']];
    }

    /**
     * @return mixed
     */
    public function getPaidWithLabelAttribute()
    {
        return config('ase.attributes.package.paid')[$this->attributes['paid']];
    }

    /**
     * @return mixed
     */
    public function getShowLabelWithLabelAttribute()
    {
        return config('ase.attributes.package.label')[$this->attributes['show_label']];
    }

    /**
     * @param $value
     * @return false|string|null
     */
    public function getDeliveryPriceAttribute($value)
    {
        if (! $this->warehouse) {
            return null;
        }

        $price = null;

        if ($value) {
            $price = $value;
        } else {
            if ($this->id && $this->attributes['weight']) {
                $price = $this->warehouse->calculateDeliveryPrice($this->attributes['weight'], $this->attributes['weight_type'], $this->attributes['width'], $this->attributes['height'], $this->attributes['length'], $this->attributes['length_type'], false, $this->user, $this->attributes['has_liquid']);
                //$this->delivery_price = $price;
                //$this->save();
            }
        }

        if (! $price) {
            return null;
        }
        $price = $price + $this->getDepoDeptAttribute() / getCurrencyRate(1);

        return round($price, 2);
    }

    public function getDepoDeptAttribute()
    {
        if ($this->scanned_at && $this->status == 2) {
            $days = diffInDays($this->scanned_at);
            if ($days > 14) {
                return round(($days - 14) * 0.2, 2);
            }
        }

        return 0;
    }

    public function getDepoDeptExpAttribute()
    {
        if ($this->scanned_at && $this->status == 2) {
            $days = diffInDays($this->scanned_at);
            if ($days > 14) {
                return round(($days - 14) * 0.2, 2) . "₼/" . ($days - 14) . ' days';
            }
        }

        return "-";
    }

    /**
     * @param $value
     * @return float|null
     */
    public function getDeliveryManatPriceAttribute($value)
    {
        if (! $this->warehouse || ! $this->delivery_price) {
            return null;
        }

        $mult = (getCurrencyRate(1) / getCurrencyRate($this->warehouse->currency));
        $manatPrice = round($this->delivery_price * $mult, 2);

        return $manatPrice;
    }

    /**
     * @return string
     */
    public function getMergedDeliveryPriceAttribute()
    {
        return $this->delivery_price ? ("$" . $this->delivery_price . "/" . $this->delivery_manat_price . "₼") : '-';
    }

    /**
     * @return false|string
     */
    public function getDeliveryPriceWithLabelAttribute()
    {
        if (! $this->warehouse) {
            return '-';
        }

        return $this->attributes['delivery_price'] ? ($this->attributes['delivery_price'] . " " . $this->warehouse->currency_with_label) : $this->warehouse->calculateDeliveryPrice($this->attributes['weight'], $this->attributes['weight_type'], $this->attributes['width'], $this->attributes['height'], $this->attributes['length'], $this->attributes['length_type'], true, $this->user, $this->attributes['has_liquid']);
    }

    /**
     * @return float
     */
    public function getTotalPriceAttribute()
    {
        $shippingAmount = $this->shipping_amount / getCurrencyRate($this->shipping_amount_cur);
        $deliveryAmount = $this->delivery_price / ($this->warehouse ? getCurrencyRate($this->warehouse->currency) : 1);

        return round($shippingAmount + $deliveryAmount, 1);
    }

    /**
     * @return string
     */
    public function getTotalPriceWithLabelAttribute()
    {
        $shippingAmount = $this->shipping_amount / getCurrencyRate($this->shipping_amount_cur);
        $deliveryAmount = $this->delivery_price / ($this->warehouse ? getCurrencyRate($this->warehouse->currency) : 1);

        return "$" . round($shippingAmount + $deliveryAmount, 1);
    }

    /**
     * @return string|null
     */
    public function getWebSiteLogoAttribute()
    {
        $domain = getDomain($this->attributes['website_name']);
        $url = explode("(", $this->attributes['website_name'])[0];

        $domain = strtolower($domain ?: str_slug(str_replace(" ", "", $url), "-") . ".com");

        return $this->attributes['website_name'] ? 'http://logo.clearbit.com/' . $domain : null;
    }

    /* * * * * *
     * Setters *
     * * * * */

    /**
     * @param $id
     */
    public function setWarehouseIdAttribute($id)
    {
        $this->attributes['warehouse_id'] = $id;
    }

    /**
     * @param int $digits
     * @return string
     */
    public static function generateCustomId($digits = 9)
    {
        do {

            $code = env('MEMBER_PREFIX_CODE', 'ASE') . str_pad(rand(0, pow(10, $digits) - 1), $digits, '0', STR_PAD_LEFT);

            $check = Package::whereCustomId($code)->withTrashed()->first();
            if (! $check) {
                break;
            }
        } while (true);

        return $code;
    }

    /* * * * * *
     * Scopes *
     * * * * */

    /**
     * @param $query
     * @return mixed
     */
    public function scopeDone($query)
    {
        return $query->where('status', 3);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne|\Illuminate\Database\Query\Builder
     */
    public function transaction()
    {
        return $this->hasOne(Transaction::class, 'custom_id')->where('type', 'OUT')->whereIn('paid_for', [
            'PACKAGE_BALANCE',
            'PACKAGE',
        ])->latest();
    }

    /**
     * @return string
     */
    public function getPaidByAttribute()
    {
        return $this->attributes['paid'] ? ($this->transaction ? $this->transaction->paid_by : '-') : "-";
    }

    public function links()
    {
        $links = $this->attributes['links'];
        if ($links) {
            $explode = array_filter(explode(",", $links));

            $links = Link::whereIn('id', $explode)->get();

            return $links;
        }

        return [];
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
            $query->worker_id = auth()->guard('worker')->check() ? auth()->guard('worker')->user()->id : null;

            if ($query->weight && $query->weight_type) {
                $weight = $query->weight;
                $query->weight = ((float) str_replace(",", ".", $weight)) * config('ase.attributes.weightConvert')[$query->weight_type];
                $query->weight_type = 0;
            }

            $webSiteName = getOnlyDomainWithExt($query->website_name);
            $query->website_name = str_limit($webSiteName ?: $query->website_name, 100);

            if ($query->warehouse_id and ! $query->delivery_price) {
                if ($query->warehouse_id) {
                    $warehouse = Warehouse::find($query->warehouse_id);
                } elseif ($query->country_id) {
                    $warehouse = Warehouse::whereCountryId($query->country_id)->latest()->first();
                } else {
                    $warehouse = null;
                }

                if ($warehouse) {
                    $query->warehouse_id = $warehouse->id;
                    if ($query->weight && ! request()->has('delivery_price') && request()->get('name') != 'delivery_price') {
                        $user = User::find($query->user_id);
                        $deliveryPrice = $warehouse->calculateDeliveryPrice($query->weight, $query->weight_type, $query->width, $query->height, $query->length, $query->length_type, false, $user, $query->has_liquid);
                        $query->delivery_price = $deliveryPrice;
                    }
                }
            }
        });

        static::updating(function ($query) {
            $pack = Package::find($query->id);

            if ($pack) {
                if ($query->weight && $query->weight_type) {
                    $weight = $query->weight;
                    $query->weight = ((float) str_replace(",", ".", $weight)) * config('ase.attributes.weightConvert')[$query->weight_type];
                    $query->weight_type = 0;
                }

                if ($pack->weight != $query->weight || $pack->user_id != $query->user_id) {
                    $wId = $query->warehouse_id ?: $pack->warehouse_id;
                    $uId = $query->user_id ?: $pack->user_id;
                    $warehouse = Warehouse::find($wId);
                    if ($warehouse) {
                        $user = User::find($uId);
                        $deliveryPrice = $warehouse->calculateDeliveryPrice($query->weight, $query->weight_type, $query->width, $query->height, $query->length, $query->length_type, false, $user, $query->has_liquid);

                        if ($pack->getOriginal('delivery_price') != $deliveryPrice) {
                            $query->delivery_price = $deliveryPrice;
                        }
                    }
                }

                if (! $query->delivery_price) {
                    $query->paid = 0;
                }

                if ($query->status == 1 && ! $query->sent_at) {
                    $query->sent_at = Carbon::now();
                }

                if ($query->status == 3 && ! $query->done_at) {
                    $query->done_at = Carbon::now();
                }

                if ($query->status == 0 && ! $query->arrived_at) {
                    $query->arrived_at = Carbon::now();
                }

                if ($query->website_name) {
                    $webSiteName = getOnlyDomainWithExt($query->website_name);
                    $query->website_name = $webSiteName ?: $query->website_name;
                    if ($query->warehouse_cell) {
                        $query->warehouse_cell = strtoupper($query->warehouse_cell);
                    }
                }

                if (! $query->worker_id) {
                    $query->worker_id = auth()->guard('worker')->check() ? auth()->guard('worker')->user()->id : null;
                }
            }
        });
    }

    /**
     * @param $trackingNumber
     * @return string|null
     */
    public static function getCarrier($trackingNumber)
    {
        $carrier = null;

        $matchUPS1 = '/\b(1Z ?[0-9A-Z]{3} ?[0-9A-Z]{3} ?[0-9A-Z]{2} ?[0-9A-Z]{4} ?[0-9A-Z]{3} ?[0-9A-Z]|[\dT]\d\d\d ?\d\d\d\d ?\d\d\d)\b/';
        $matchUPS2 = '/^[kKJj]{1}[0-9]{10}$/';

        $matchUSPS0 = '/(\b\d{30}\b)|(\b91\d+\b)|(\b\d{20}\b)/';
        $matchUSPS1 = '/(\b\d{30}\b)|(\b91\d+\b)|(\b\d{20}\b)|(\b\d{26}\b)| ^E\D{1}\d{9}\D{2}$|^9\d{15,21}$| ^91[0-9]+$| ^[A-Za-z]{2}[0-9]+US$/i';
        $matchUSPS2 = '/^E\D{1}\d{9}\D{2}$|^9\d{15,21}$/';
        $matchUSPS3 = '/^91[0-9]+$/';
        $matchUSPS4 = '/^[A-Za-z]{2}[0-9]+US$/';
        $matchUSPS5 = '/(\b\d{30}\b)|(\b91\d+\b)|(\b\d{20}\b)|(\b\d{26}\b)| ^E\D{1}\d{9}\D{2}$|^9\d{15,21}$| ^91[0-9]+$| ^[A-Za-z]{2}[0-9]+US$/i';

        $matchFedex1 = '/(\b96\d{20}\b)|(\b\d{15}\b)|(\b\d{12}\b)/';
        $matchFedex2 = '/\b((98\d\d\d\d\d?\d\d\d\d|98\d\d) ?\d\d\d\d ?\d\d\d\d( ?\d\d\d)?)\b/';
        $matchFedex3 = '/^[0-9]{15}$/';

        if (preg_match($matchUPS1, $trackingNumber) || preg_match($matchUPS2, $trackingNumber)) {
            $carrier = 'UPS';
        } else {
            if (preg_match($matchUSPS0, $trackingNumber) || preg_match($matchUSPS1, $trackingNumber) || preg_match($matchUSPS2, $trackingNumber) || preg_match($matchUSPS3, $trackingNumber) || preg_match($matchUSPS4, $trackingNumber) || preg_match($matchUSPS5, $trackingNumber)) {

                $carrier = 'USPS';
            } else {
                if (preg_match($matchFedex1, $trackingNumber) || preg_match($matchFedex2, $trackingNumber) || preg_match($matchFedex3, $trackingNumber)) {

                    $carrier = 'FedEx';
                } else {
                    if (0) {
                        $carrier = 'DHL';
                    }
                }
            }
        }

        return $carrier;
    }

    /**
     * @param $query
     * @param $code
     * @return mixed
     */
    public function scopeLikeTracking($query, $code)
    {
        return $query->where('tracking_code', 'like', '%' . $code);
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeReady($query)
    {
        return $query->whereNotNull('number_items')->whereNotNull('shipping_amount')->whereNotNull('weight')->doesntHave('parcel');
    }

    /**
     * @return bool
     */
    public function getIsReadyAttribute()
    {
        return $this->attributes['warehouse_id'] != null && $this->attributes['user_id'] != null && $this->attributes['weight'] != null;
    }

    public function getPrintInvoiceAttribute($value)
    {
        return $value && $this->attributes['shipping_amount'];
    }

    /**
     * @return mixed
     */
    public function getShowLabelAttribute()
    {
        return true;//$this->is_ready;
    }

    /**
     * @param $value
     * @return string|null
     */
    public function getWebsiteNameAttribute($value)
    {
        $webSiteName = getOnlyDomainWithExt($value);

        return $webSiteName ?: ($value ? strtolower($value) : $value);
    }

    /**
     * @param $value
     * @return string
     */
    public function getTrackingCodeAttribute($value)
    {
        if ($value) {
            $value = str_replace("<", "", $value);
            $value = str_replace(">", "", $value);
            $value = str_replace("", "", $value);
        }

        return $value ? str_limit($value, 40) : (71059151900 + $this->id);
    }

    /**
     * @return int
     */
    public function getAlertAttribute()
    {
        return ($this->attributes['invoice'] == null && $this->attributes['dec_message'] == 3) ? 1 : 0;
    }

    /**
     * @return float|int|mixed
     */
    public function getNetWeightAttribute()
    {
        $weight = $this->attributes['weight'];
        $weightUnit = $this->attributes['weight_type'];
        $weight = $weight * config('ase.attributes.weightConvert')[$weightUnit];
        $size_index = $this->volume_weight;

        return $size_index > $weight ? $size_index : $weight;
    }

    /**
     * @return float|int
     */
    public function getVolumeWeightAttribute()
    {
        $width = $this->attributes['width'];
        $height = $this->attributes['height'];
        $length = $this->attributes['length'];
        $sizeUnit = $this->attributes['length_type'];

        if ($width) {
            $width = $width * config('ase.attributes.lengthConvert')[$sizeUnit];
        }
        if ($height) {
            $height = $height * config('ase.attributes.lengthConvert')[$sizeUnit];
        }
        if ($length) {
            $length = $length * config('ase.attributes.lengthConvert')[$sizeUnit];
        }

        $country = $this->defaultCountry();

        $size_index = ($country && $country->delivery_index) ? ($width * $height * $length / $country->delivery_index) : 0;

        return $size_index;
    }

    /**
     * @param $value
     * @return string
     */
    public function getDetailedTypeAttribute($value)
    {
        return $value ?: $this->attributes['number_items'] . " x " . ($this->type ? $this->type->translateOrDefault('en')->name : "-");
    }

    /**
     * @return false|mixed
     */
    public function getFakeAddressAttribute()
    {
        $country = $this->defaultCountry();

        return $country ? isset(config('ase.addresses.' . strtolower($country->code))[$this->id % 2]) ? config('ase.addresses.' . strtolower($country->code))[$this->id % 2] : false : false;
    }

    /**
     * @return bool
     */
    public function getDontDeleteAttribute()
    {
        return false;//auth()->guard('worker')->check() && $this->declaration;
    }

    /**
     * @return Country|null
     */
    public function defaultCountry()
    {
        return ($this->warehouse and $this->warehouse->country) ? $this->warehouse->country : ($this->country ? $this->country : null);
    }

    /**
     * @return mixed|null
     */
    public function delivery()
    {
        return ($this->belongsToMany(Delivery::class, 'delivery_package'))->first();
    }

    public function manager()
    {
        return $this->belongsTo(Worker::class, 'worker_id');
    }

    /**
     * @return mixed|string
     */
    public function getWorkerAttribute()
    {
        return $this->manager ? $this->manager->name : "-";
    }

    public function getCustomIdAttribute($value)
    {
        if (isset($this->attributes['id'])) {
            $prefix = $this->user ? substr($this->user->customer_id, 0, 3) : env('MEMBER_PREFIX_CODE');

            if (! starts_with($value, $prefix)) {
                $value = str_replace(env('MEMBER_PREFIX_CODE'), $prefix, $value);
                $package = Package::find($this->attributes['id']);
                if ($package) {
                    $package->custom_id = $value;
                    $package->save();
                }
            }
        }

        return $value;
    }

    public function getLabelLogoAttribute()
    {
        $logo = ($this->user && $this->user->dealer && $this->user->dealer->type == 'COMPANY' && $this->user->dealer->logo) ? $this->user->dealer->logo : asset('admin/images/logo_cert.png');

        return $logo;
    }

    public function isFakeAddress()
    {
        return ($this->user && $this->user->dealer && $this->user->dealer->type == 'COMPANY');
    }

    public function getInvoiceNumbersAttribute()
    {
        $percent = 20 + $this->id % 10;
        $withoutKDV = round($this->shipping_amount * 0.992, 2);
        $iskonto = round($withoutKDV * (1 - $percent / 100), 2);
        //$type = explode("x", explode(";", $this->detailed_type)[0]);
        //$type = isset($type[1]) ? $type[1] : $type[0];
        $type = $this->getCustomsTypeAttribute('tr');

        return [
            'tci'           => 'TCI' . (2020011720573 + $this->id),
            'tys'           => 'TYS' . (2020024055022 + $this->id),
            'track'         => 71059151900 + $this->id,
            'product'       => (86817417404 + $this->id),
            'date'          => $this->created_at->format("d.m.Y"),
            'hour'          => $this->created_at->subHours(rand(2, 4))->format("h") . ":" . rand(10, 55),
            'vade'          => $this->created_at->subDays(4)->format("d.m.Y"),
            'ettn'          => strtolower(guid()),
            'iskonto'       => trNumber($iskonto),
            'total_iskonto' => trNumber(9.99 + $iskonto),
            'birim'         => trNumber(round($iskonto + $withoutKDV, 2)),
            'total_birim'   => trNumber(round(9.99 + $iskonto + $withoutKDV, 2)),
            'kdv'           => trNumber(round($this->shipping_amount * 0.08, 2)),
            'net_tutar'     => trNumber($withoutKDV),
            'net'           => trNumber(round($this->shipping_amount, 2)),
            'sayi_net'      => sayiyiYaziyaCevir(round($this->shipping_amount, 2)),
            'product_name'  => ($this->warehouse_comment ?: $type) . " " . randomProduct(),
        ];
    }

    public function getBarcodeAttribute()
    {
        $base64Barcode = (new DNS1D())->getBarcodePNG($this->getAttribute('custom_id'), 'C128',6,100, array(1, 1, 1));

        return 'data:image/png;base64,' . $base64Barcode;
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class)->withDefault();
    }

    public function setWebsiteNameAttribute($value)
    {
        $this->attributes['website_name'] = mb_strtolower($value);
    }
}
