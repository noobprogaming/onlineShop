<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = "transaction";

    public function purchase() {
        return $this->belongsTo(Purchase::class);
    }

    protected $fillable = [
        'purchase_id', 'resi', 'pay', 'checked',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'time' => 'datetime',
    ];
}
