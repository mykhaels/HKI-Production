<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SalesOrder extends Model
{
    protected $fillable = ['code','transaction_date','customer_id','subtotal','ppn','total'];
    protected $with =['salesOrderDetails','initialPaymentSales'];


    //default value
    protected $attributes = [
        'status' => 1,
    ];

    public function salesOrderDetails()
    {
        return $this->hasMany('App\SalesOrderDetail');
    }
    public function customer()
    {
        return $this->belongsTo('App\Customer');
    }
    public function initialPaymentSales()
    {
        return $this->hasOne('App\InitialPaymentSales');
    }
}
