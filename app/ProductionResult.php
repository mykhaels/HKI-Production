<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductionResult extends Model
{
    protected $fillable = ['production_order_id','code','transaction_date','production_type'];
     //default value
     protected $attributes = [
        'status' => 1,
    ];


    public function productionResultDetails()
    {
        return $this->hasMany('App\ProductionResultDetail');
    }

    public function productionOrder()
    {
        return $this->belongsTo('App\ProductionOrder');
    }
}
