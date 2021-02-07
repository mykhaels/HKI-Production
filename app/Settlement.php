<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Settlement extends Model
{
    protected $fillable = ['code','transaction_date','supplier_id','total'];
    protected $with =['settlementDetails'];

    //default value
    protected $attributes = [
        'status' => 1,
    ];

    public function settlementDetails()
    {
        return $this->hasMany('App\SettlementDetail');
    }
    public function supplier()
    {
        return $this->belongsTo('App\Supplier');
    }
}
