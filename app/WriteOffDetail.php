<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WriteOffDetail extends Model
{
    protected $fillable = ['invoice_id', 'write_off_total'];

    public function writeOff()
    {
        return $this->hasOne('App\WriteOff');
    }

    public function invoice()
    {
        return $this->belongsTo('App\Invoice');
    }
}
