<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Link
 *
 * @property int $id
 * @property int $order_id
 * @property string $url
 * @property string|null $note
 * @property string|null $affiliate
 * @property int $status
 * @property-read \App\Models\Order $order
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Link whereAffiliate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Link whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Link whereNote($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Link whereOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Link whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Link whereUrl($value)
 * @mixin \Eloquent
 * @property-read mixed $status_with_label
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Link newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Link newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Link query()
 * @property string|null $color
 * @property string|null $size
 * @property string|null $total_price
 * @property string|null $price
 * @property string|null $cargo_fee
 * @property int|null $amount
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Link whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Link whereCargoFee($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Link whereColor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Link wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Link whereSize($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Link whereTotalPrice($value)
 */
class Link extends Model
{
    /**
     * @var array
     */
    protected $appends = ['status_with_label'];

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function order()
    {
        return $this->belongsTo('App\Models\Order');
    }

    /**
     * @return mixed
     */
    public function getStatusWithLabelAttribute()
    {
        return config('ase.attributes.request.link.status')[$this->attributes['status']];
    }
}
