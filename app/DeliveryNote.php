<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DeliveryNote extends Model
{
    protected $fillable = ['delivery_request_id','code','transaction_date','product_type','delivery_type'];



    public function deliveryNoteDetails()
    {
        return $this->hasMany('App\DeliveryNoteDetails');
    }

    public function deliveryRequest()
    {
        return $this->belongsTo('App\DeliveryRequest');
    }
}
