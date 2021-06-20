<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SalesInvoice extends Model
{
    protected $fillable = ['code','transaction_date','sales_delivery_note_id','customer_id','total'];
    protected $with =['salesInvoiceDetails'];

    //default value
    protected $attributes = [
        'status' => 1,
        'settlement_total' => 0,
    ];

    public function salesInvoiceDetails()
    {
        return $this->hasMany('App\SalesInvoiceDetail');
    }
    public function SalesDeliveryNote()
    {
        return $this->belongsTo('App\SalesDeliveryNote');
    }
    public function customer()
    {
        return $this->belongsTo('App\Customer');
    }
}
