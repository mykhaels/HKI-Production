<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SalesWriteOffDetail extends Model
{
    protected $fillable = ['sales_invoice_id', 'write_off_total'];

    public function salesWriteOff()
    {
        return $this->hasOne('App\SalesWriteOff');
    }

    public function salesInvoice()
    {
        return $this->belongsTo('App\SalesInvoice');
    }
}
