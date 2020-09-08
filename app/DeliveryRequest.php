<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DeliveryRequest extends Model
{
    protected $fillable = ['production_order_id','code','transaction_date','product_type'];
    protected $with =['deliveryRequestDetails'];

    //default value
    protected $attributes = [
        'status' => 1,
    ];

    public function deliveryRequestDetails()
    {
        return $this->hasMany('App\DeliveryRequestDetail');
    }

    public function productionOrder()
    {
        return $this->belongsTo('App\ProductionOrder');
    }
}
