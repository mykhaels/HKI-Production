<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JournalDetail extends Model
{
    protected $fillable = ['coa_id', 'account','total'];
    protected $with = ['coa'];

    public function journal()
    {
        return $this->belongsTo('App\Journal');
    }

    public function coa()
    {
        return $this->belongsTo('App\Coa');
    }
}
