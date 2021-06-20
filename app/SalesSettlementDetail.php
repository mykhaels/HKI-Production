<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SalesSettlementDetail extends Model
{
    protected $fillable = ['sales_invoice_id', 'settlement_total'];

    public function salesSettlement()
    {
        return $this->hasOne('App\SalesSettlement');
    }

    public function salesInvoice()
    {
        return $this->belongsTo('App\SalesInvoice');
    }
}
