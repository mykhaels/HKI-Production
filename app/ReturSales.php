<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReturSales extends Model
{
    protected $fillable = ['code','transaction_date','sales_delivery_note_id','customer_id'];
    protected $with =['returSalesDetails'];

    protected $attributes = [
        'status' => 1,
    ];

    public function salesDeliveryNote()
    {
        return $this->belongsTo('App\SalesDeliveryNote');
    }
    public function customer()
    {
        return $this->belongsTo('App\Customer');
    }
    public function returSalesDetails()
    {
        return $this->hasMany('App\ReturSalesDetail');
    }
}
