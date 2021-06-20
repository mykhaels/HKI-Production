<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InitialPaymentSales extends Model
{
    protected $fillable = ['code','transaction_date','sales_order_id','customer_id','dp'];

    public function salesOrder()
    {
        return $this->belongsTo('App\SalesOrder');
    }
    public function customer()
    {
        return $this->belongsTo('App\Customer');
    }
}
