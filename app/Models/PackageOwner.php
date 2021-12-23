<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\PackageOwner
 *
 * @property int $id
 * @property int $user_id
 * @property int $package_id
 * @property string|null $invoice
 * @property string|null $note
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \App\Models\Package $package
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PackageOwner whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PackageOwner whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PackageOwner whereInvoice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PackageOwner whereNote($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PackageOwner wherePackageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PackageOwner whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PackageOwner whereUserId($value)
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PackageOwner newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PackageOwner newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PackageOwner query()
 */
class PackageOwner extends Model
{
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function package()
    {
        return $this->belongsTo('App\Models\Package');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
