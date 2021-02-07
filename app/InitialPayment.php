<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InitialPayment extends Model
{
    protected $fillable = ['code','transaction_date','purchase_order_id','supplier_id','dp'];

    public function purchaseOrder()
    {
        return $this->belongsTo('App\PurchaseOrder');
    }
    public function supplier()
    {
        return $this->belongsTo('App\Supplier');
    }
}
