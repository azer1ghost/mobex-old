<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @method static find(\Illuminate\Routing\Route|object|string $branch)
 */
class AzerpoctBranch extends Model
{
    use SoftDeletes;

    public function packages(): HasMany
    {
        return $this->hasMany(Package::class, 'zip_code');
    }

    public function users(): HasMany
    {
        return $this->hasMany(User::class, 'zip_code');
    }

    public function getFeeAttribute($value)
    {
        if (is_null($value))
            switch ($this->getAttribute('regionEN')) {
                case 'BAKU':
                case 'BAKI':
                    return config('services.azerpost.in_baku_fee');
                default:
                    return config('services.azerpost.out_baku_fee');
            }
        else
            return $value;
    }

    public function scopeActive(Builder $builder)
    {
        $builder->where('status', '=', 'ACTIVE');
    }
}
