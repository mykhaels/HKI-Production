<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['product_category_id', 'product_type','code','name'];
    protected $with = ['uoms'];
     /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $attributes = [
        'status' => 1,
    ];

    /**
     * The Product that belong to the UOM.
     */
    public function uoms()
    {
        return $this->belongsToMany('App\Uom')->withPivot(['conversion','level']);
    }

    public function productCategory(){
        return $this->belongsTo('App\ProductCategory');
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
        return $this->hasOne('App\DeliverRequestDetail');
    }
}
