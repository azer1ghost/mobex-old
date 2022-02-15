<?php

namespace App\Models;

use App\Traits\ModelEventLogger;
use App\Traits\Password;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Manager extends Authenticatable
{
    use Password;
    use SoftDeletes;
    use ModelEventLogger;

    /**
     * @var array
     */
    protected $with = ['branch'];

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }
}
