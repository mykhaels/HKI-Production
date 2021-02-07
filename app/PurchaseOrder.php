<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PurchaseOrder extends Model
{
    protected $fillable = ['code','transaction_date','supplier_id','product_type','subtotal','ppn','total'];
    protected $with =['purchaseOrderDetails','initialPayment'];

    //default value
    protected $attributes = [
        'status' => 1,
    ];

    public function purchaseOrderDetails()
    {
        return $this->hasMany('App\PurchaseOrderDetail');
    }
    public function supplier()
    {
        return $this->belongsTo('App\Supplier');
    }
    public function initialPayment()
    {
        return $this->hasOne('App\InitialPayment');
    }
}
