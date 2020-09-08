<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductionOrderDetail extends Model
{
    protected $fillable = ['product_id','qty','uom_id'];
    public $timestamps = false;

    public function product()
    {
        return $this->belongsTo('App\Product');
    }

    public function uom()
    {
        return $this->belongsTo('App\Uom');
    }

    public function productionOrder()
    {
        return $this->belongsTo('App\ProductionOrder');
    }
}
