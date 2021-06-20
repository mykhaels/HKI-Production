<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SalesOrderDetail extends Model
{
    protected $fillable = ['product_id','qty','uom_id','price','discount','tax_status','total'];
    protected $with = ['product','uom'];
    public $timestamps = false;

    public function product()
    {
        return $this->belongsTo('App\Product');
    }

    public function uom()
    {
        return $this->belongsTo('App\Uom');
    }

    public function salesOrder()
    {
        return $this->belongsTo('App\SalesOrder');
    }
}
