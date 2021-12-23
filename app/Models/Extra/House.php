<?php

namespace App\Models\Extra;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Extra\House
 *
 * @property int $id
 * @property string $provider
 * @property int $custom_id
 * @property string|null $city
 * @property string $type
 * @property string $condition
 * @property float $area
 * @property int $number_of_rooms
 * @property string|null $place_or_district
 * @property string $uploaded_at
 * @property string|null $name
 * @property string|null $phone
 * @property \Illuminate\Support\Carbon|null $sold_at
 * @property string $url
 * @property int $price
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Extra\House newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Extra\House newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Extra\House query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Extra\House whereArea($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Extra\House whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Extra\House whereCondition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Extra\House whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Extra\House whereCustomId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Extra\House whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Extra\House whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Extra\House whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Extra\House whereNumberOfRooms($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Extra\House wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Extra\House wherePlaceOrDistrict($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Extra\House wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Extra\House whereProvider($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Extra\House whereSoldAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Extra\House whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Extra\House whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Extra\House whereUploadedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Extra\House whereUrl($value)
 * @mixin \Eloquent
 */
class House extends Model
{
    protected $dates = ['checked_at', 'sold_at', 'deleted_at'];
}
