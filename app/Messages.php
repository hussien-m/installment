<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Messages extends Model
{
    protected $guarded = [];

    public function customer()
    {
        return $this->belongsTo(Customer::class,'customer_id');
    }

    public function replay()
    {
        return $this->hasOne(Replay::class,'message_id');
    }
}
