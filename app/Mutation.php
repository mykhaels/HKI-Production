<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mutation extends Model
{
    use HasFactory;
    protected $fillable = ['code','transaction_date','to_product_type','from_product_type'];
     //default value
     protected $attributes = [
        'status' => 1,
    ];


    public function mutationDetails()
    {
        return $this->hasMany('App\MutationDetails');
    }
}
