<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LoginSession extends Model
{
    protected $fillable = ['user_id', 'ip_address', 'login_at'];
    public $timestamps = true;
    protected $dates = ['login_at', 'logout_at'];

    // app/Models/LoginSession.php

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
