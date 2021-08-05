<?php

namespace App\Models;

use Str;
use Eloquent;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;
use App\Models\PrestashopModels\Currency;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\Transaction
 *
 * @mixin Eloquent
 * @property string $first_name
 * @property string $last_name
 * @property integer $citizenship_country_id
 * @property integer $phone_number
 * @property integer $user_id
 * @property integer $id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read User $user
 * @property-read Country $country
 */
class UserDetail extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $dates = [
        'transacted_at',
        'created_at',
        'updated_at'
    ];

    public $timestamps = false;

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function country(): HasOne
    {
        return $this->hasOne(Country::class, 'id', 'citizenship_country_id');
    }
}
