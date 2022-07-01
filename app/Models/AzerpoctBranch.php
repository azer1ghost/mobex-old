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

    public function getFee($weight)
    {
        $inBakuFee = config('services.azerpost.in_baku_fee');
        $inBakuFeePerKq = config('services.azerpost.in_baku_fee_per_kq');

        $outBakuFee = config('services.azerpost.out_baku_fee');
        $outBakuFeePerKq = config('services.azerpost.out_baku_fee_per_kq');

        switch ($this->getAttribute('regionEN')) {
            case 'BAKU':
            case 'BAKI':
                return $this->calculate($weight, $inBakuFee, $inBakuFeePerKq, $this->getAttribute('fee'), $this->getAttribute('fee_per_kq'));
            default:
                return $this->calculate($weight, $outBakuFee, $outBakuFeePerKq, $this->getAttribute('fee'), $this->getAttribute('fee_per_kq'));
        }
    }

    private function calculate($weight, $defaultStaticFee = 0, $defaultPerKqFee = 0, $staticFee = null, $perKqFee = null)
    {
        return $staticFee ?? $defaultStaticFee + ($perKqFee ?? $defaultPerKqFee) * $weight;
    }

    public function scopeActive(Builder $builder)
    {
        $builder->where('status', '=', 'ACTIVE');
    }
}
