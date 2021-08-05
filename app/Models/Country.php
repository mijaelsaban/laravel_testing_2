<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * App\Models\Country
 *
 * @mixin Eloquent
 * @property integer $iso3
 * @property integer $iso2
 * @property integer $name
 * @property integer $id
 */
class Country extends Model
{
    use HasFactory;

    public $timestamps = false;
}
