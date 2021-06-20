<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SalesWriteOff extends Model
{
    protected $fillable = ['code','transaction_date','customer_id','total'];
    protected $with =['salesWriteOffDetails'];

    //default value
    protected $attributes = [
        'status' => 1,
    ];

    public function salesWriteOffDetails()
    {
        return $this->hasMany('App\SalesWriteOffDetail');
    }
    public function customer()
    {
        return $this->belongsTo('App\Customer');
    }
}
