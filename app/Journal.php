<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Journal extends Model
{
    protected $fillable = ['code', 'transaction_date'];
    protected $with = ['journalDetails'];

    public function journalDetails()
    {
        return $this->hasMany('App\JournalDetail');
    }
}
