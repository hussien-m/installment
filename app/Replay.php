<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Replay extends Model
{
    protected $guarded = [];

    public function message()
    {
        return $this->belongsTo(Messages::class, 'message_id');
    }
}
