<?php

namespace App\Models;

use Eloquent;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * App\Models\User
 *
 * @property int $id
 * @property string $email
 * @property int $active
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @mixin Eloquent
 */
class User extends Model
{
    use HasFactory;

    public const YES = 1;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email', 'active',
    ];

    public function userDetail(): HasOne
    {
        return $this->hasOne(UserDetail::class);
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('active', self::YES);
    }

    public function scopeIsAustrian(Builder $query): Builder
    {
        return $query->whereHas('userDetail.country', function ($query) {
            $query->where('name', 'Austria');
        });
    }
}
