<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $fillable = ['code','transaction_date','good_receipt_id','supplier_id','total'];
    protected $with =['invoiceDetails'];

    //default value
    protected $attributes = [
        'status' => 1,
        'settlement_total' => 0,
    ];

    public function invoiceDetails()
    {
        return $this->hasMany('App\InvoiceDetail');
    }
    public function goodReceipt()
    {
        return $this->belongsTo('App\GoodReceipt');
    }
    public function supplier()
    {
        return $this->belongsTo('App\Supplier');
    }
}
