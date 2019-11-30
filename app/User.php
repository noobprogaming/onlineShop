<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = "users";
    
    public function purchase_item() {
        return $this->hasMany(Purchase_item::class);
    }

    public function rating() {
        return $this->hasMany(Rating::class);
    }

    public function item() {
        return $this->hasMany(Item::class);
    }

    public function purchase() {
        return $this->hasMany(Purchase::class);
    }

    public function location() {
        return $this->hasMany(Location::class);
    }

    protected $fillable = [
        'id', 'name', 'email', 'phone_number', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
