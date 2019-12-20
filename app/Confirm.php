<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Confirm extends Model
{
    // public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = "confirm";

    protected $fillable = [
        'confirm_id', 'confirm',
    ];

}
