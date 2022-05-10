<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TransferIn extends Model
{
    protected $fillable = ['transfer_request_id','code','transaction_date','product_type'];
     //default value
     protected $attributes = [
        'status' => 1,
    ];


    public function transferInDetails()
    {
        return $this->hasMany('App\TransferInDetail');
    }

    public function transferRequest()
    {
        return $this->belongsTo('App\TransferRequest');
    }
}
