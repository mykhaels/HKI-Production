<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TransferRequest extends Model
{
    protected $fillable = ['code','transaction_date','delivery_date','product_type'];
    protected $with =['transferRequestDetails'];
    //default value
    protected $attributes = [
        'status' => 1,
    ];


    public function transferRequestDetails()
    {
        return $this->hasMany('App\TransferRequestDetail');
    }

}
