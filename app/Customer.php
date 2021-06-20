<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
      /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['address', 'phone','email','npwp','code','name'];
     /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $attributes = [
        'status' => 1,
    ];

    public function salesOrder()
    {
        return $this->hasOne('App\SalesOrder');
    }
}
