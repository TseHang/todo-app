<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tasks extends Model
{
    protected $fillable = [
        'user_id',
        'content',
        'is_done',
    ];

    public function user() {
        return $this->belongsTo('App\User');
    }
}
