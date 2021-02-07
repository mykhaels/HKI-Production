<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SettlementDetail extends Model
{
    protected $fillable = ['invoice_id', 'settlement_total'];

    public function settlement()
    {
        return $this->hasOne('App\Settlement');
    }

    public function invoice()
    {
        return $this->belongsTo('App\Invoice');
    }
}
