<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PasswordReset extends Model
{
    protected $fillable = [
        'email', 'token',
    ];


    protected function user() {
        return $this->belongsTo('App\User', 'email', 'email');
    }
}
