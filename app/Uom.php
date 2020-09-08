<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Uom extends Model
{
    /**
     * The Uom that belong to the Product.
     */
    public function products()
    {
        return $this->belongsToMany('App\Product');
    }
    public function deliveryNoteDetail()
    {
        return $this->hasOne('App\DeliveryNoteDetail');
    }

    public function productionOrderDetail()
    {
        return $this->hasOne('App\ProductionOrderDetail');
    }

    public function deliveryRequestDetail()
    {
        return $this->hasOne('App\DeliveryRequestDetail');
    }
    public function productionResultDetail()
    {
        return $this->hasOne('App\ProductionResultDetail');
    }
}
