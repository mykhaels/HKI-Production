<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SalesSettlement extends Model
{
    protected $fillable = ['code','transaction_date','customer_id','total'];
    protected $with =['salesSettlementDetails'];

    //default value
    protected $attributes = [
        'status' => 1,
    ];

    public function salesSettlementDetails()
    {
        return $this->hasMany('App\SalesSettlementDetail');
    }
    public function customer()
    {
        return $this->belongsTo('App\Customer');
    }
}
