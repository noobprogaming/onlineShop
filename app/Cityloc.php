<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cityloc extends Model
{
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = "cityloc";
    
    protected $fillable = [
        'city_id', 'province_id', 'type', 'city_name',
    ];

}
