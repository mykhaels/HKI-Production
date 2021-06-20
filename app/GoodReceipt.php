<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GoodReceipt extends Model
{
    protected $fillable = ['code','transaction_date','purchase_order_id','supplier_id'];
    protected $with =['goodReceiptDetails','purchaseOrder','retur'];

    protected $attributes = [
        'status' => 1,
    ];

    public function purchaseOrder()
    {
        return $this->belongsTo('App\PurchaseOrder');
    }
    public function supplier()
    {
        return $this->belongsTo('App\Supplier');
    }
    public function goodReceiptDetails()
    {
        return $this->hasMany('App\GoodReceiptDetail');
    }
    public function retur()
    {
        return $this->hasOne('App\Retur');
    }
}
