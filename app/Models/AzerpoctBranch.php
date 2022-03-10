<?php

namespace App\Models;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @method static find(\Illuminate\Routing\Route|object|string $branch)
 */
class AzerpoctBranch extends Model
{
    use SoftDeletes;

    public function packages()
    {
        return $this->hasMany(Package::class, 'zip_code');
    }

    public function users()
    {
        return $this->hasMany(User::class, 'zip_code');
    }
}
