<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductionOrder extends Model
{
    protected $fillable = ['code','transaction_date','production_type'];

    //default value
    protected $attributes = [
        'status' => 1,
    ];

    public function productionOrderDetails()
    {
        return $this->hasMany('App\ProductionOrderDetail');
    }

    public function deliveryRequest()
    {
        return $this->hasOne('App\DeliveryRequest');
    }
}
