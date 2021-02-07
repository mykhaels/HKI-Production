<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WriteOff extends Model
{
    protected $fillable = ['code','transaction_date','supplier_id','total'];
    protected $with =['writeOffDetails'];

    //default value
    protected $attributes = [
        'status' => 1,
    ];

    public function writeOffDetails()
    {
        return $this->hasMany('App\WriteOffDetail');
    }
    public function supplier()
    {
        return $this->belongsTo('App\Supplier');
    }
}
