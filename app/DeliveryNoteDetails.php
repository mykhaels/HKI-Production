<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DeliveryNoteDetails extends Model
{
    protected $fillable = ['product_id','qty','uom_id'];
    protected $with = ['product','uom'];
    public $timestamps = false;

    public function product()
    {
        return $this->belongsTo('App\Product', 'product_id');
    }

    public function uom()
    {
        return $this->belongsTo('App\Uom', 'uom_id');
    }

    public function deliveryNotes()
    {
        return $this->belongsTo('App\DeliveryNote');
    }
}
