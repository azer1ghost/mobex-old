<?php

namespace App\Models;

use App\Traits\ModelEventLogger;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\GiftCard
 *
 * @property int $id
 * @property int|null $user_id
 * @property string $card_number
 * @property float|null $amount
 * @property string $status
 * @property string|null $used_at
 * @property string|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User|null $user
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\GiftCard newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\GiftCard newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\GiftCard onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\GiftCard query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\GiftCard whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\GiftCard whereCardNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\GiftCard whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\GiftCard whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\GiftCard whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\GiftCard whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\GiftCard whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\GiftCard whereUsedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\GiftCard whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\GiftCard withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\GiftCard withoutTrashed()
 * @mixin \Eloquent
 */
class GiftCard extends Model
{
    use SoftDeletes;
    use ModelEventLogger;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return mixed|string
     */
    public static function generateCardNumber()
    {
        $latest = (self::latest()->first());

        if (! $latest) {
            return '100000001';
        }

        $latest = $latest->card_number;
        do {
            $latest++;

            $code = $latest;
            $check = self::where('card_number', $code)->first();
            if (! $check) {
                break;
            }
        } while (true);

        return $code;
    }

    /**
     *
     */
    protected static function boot()
    {
        parent::boot();

        // auto-sets values on creation
        static::creating(function ($query) {
            $query->card_number = $query->card_number ?: self::generateCardNumber();
        });
    }
}
