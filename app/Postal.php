<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Postal extends Model
{
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = "postal";
    
    protected $fillable = [
        'postal_code', 'district', 'urban', 'city',
    ];

}
