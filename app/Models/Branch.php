<?php

namespace App\Models;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @method static find(\Illuminate\Routing\Route|object|string $branch)
 */
class Branch extends Model
{
    use Translatable;
    use SoftDeletes;

    /**
     * @var array
     */
    protected $with = ['translations'];

    /**
     * @var array
     */
    public $translatedAttributes = ['name', 'address'];

    /**
     * Parse source url from embed
     *
     * @param $value
     * @return mixed
     */
//    public function getLocationAttribute($value)
//    {
//        preg_match('/src="([^"]+)"/', $value, $match);
//        $url = isset($match[1]) ? $match[1] : $value;
//
//        return $url;
//    }


    public function packages()
    {
        return $this->hasMany(Package::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
