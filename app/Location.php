<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = "location";
    
    public function user() {
        return $this->belongsTo(User::class);
    }
    
    protected $fillable = [
        'id', 'address', 'city_id', 'province_id', 'postal_code',
    ];

}
