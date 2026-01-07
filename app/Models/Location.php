<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    protected $fillable = [
        'city',
        'name',
        'type',
        'range_cc',
        'image',
        'address',
        'latitude',
        'longitude',
    ];
}
