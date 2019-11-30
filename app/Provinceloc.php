<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Provinceloc extends Model
{
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = "provinceloc";
    
    protected $fillable = [
        'province_id', 'province_name',
    ];

}
