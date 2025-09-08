<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Newsletter extends Model
{
    //
    protected $table = 'newsletter';
    protected $fillable = ['name', 'email', 'is_subscribed'];
}
