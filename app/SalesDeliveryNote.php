<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SalesDeliveryNote extends Model
{
    protected $fillable = ['code','transaction_date','sales_order_id','customer_id'];
    protected $with =['salesDeliveryNoteDetails','salesOrder','returSales'];

    protected $attributes = [
        'status' => 1,
    ];

    public function salesOrder()
    {
        return $this->belongsTo('App\SalesOrder');
    }
    public function customer()
    {
        return $this->belongsTo('App\Customer');
    }
    public function salesDeliveryNoteDetails()
    {
        return $this->hasMany('App\SalesDeliveryNoteDetail');
    }
    public function returSales()
    {
        return $this->hasOne('App\ReturSales');
    }
}
