<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = "city";
    
    protected $fillable = [
        'city_id', 'province_id', 'type', 'city_name',
    ];

}
