<?php

namespace App\Models;

use App\Traits\ModelEventLogger;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Address
 *
 * @property int $id
 * @property int|null $warehouse_id
 * @property string|null $title
 * @property string|null $contact_name
 * @property string $address_line_1
 * @property string|null $address_line_2
 * @property string|null $phone
 * @property string|null $mobile
 * @property string $city
 * @property string|null $state
 * @property string|null $region
 * @property string $zip_code
 * @property string|null $passport
 * @property string|null $attention
 * @property string|null $reminder
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Warehouse|null $warehouse
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Address newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Address newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Address query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Address whereAddressLine1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Address whereAddressLine2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Address whereAttention($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Address whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Address whereContactName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Address whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Address whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Address whereMobile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Address wherePassport($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Address wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Address whereRegion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Address whereReminder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Address whereState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Address whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Address whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Address whereWarehouseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Address whereZipCode($value)
 * @mixin \Eloquent
 * @property string|null $district
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Address whereDistrict($value)
 */
class Address extends Model
{
    use ModelEventLogger;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }
}
