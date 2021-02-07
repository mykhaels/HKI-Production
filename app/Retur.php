<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Retur extends Model
{
    protected $fillable = ['code','transaction_date','good_receipt_id','supplier_id'];
    protected $with =['returDetails'];

    protected $attributes = [
        'status' => 1,
    ];

    public function goodReceipt()
    {
        return $this->belongsTo('App\GoodReceipt');
    }
    public function supplier()
    {
        return $this->belongsTo('App\Supplier');
    }
    public function returDetails()
    {
        return $this->hasMany('App\ReturDetail');
    }
}
