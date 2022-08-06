<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
class Customer extends Authenticatable
{
    use Notifiable;
    protected $table = 'customers';

    protected $fillable = [
        'name',
        'email',
        'phone',
        'phone2',
        'address',
        'password',
        'balance',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function messages()
    {
        return $this->hasMany(Messages::class, 'customer_id');
    }
}
