<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @method static where(string $string, mixed $key)
 */
class Referral extends Model
{
    protected $table = 'referral_user';

    public $timestamps = false;

    protected $fillable = ['referral_key', 'request_time'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
