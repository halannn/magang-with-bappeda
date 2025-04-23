<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class PendaftaranMagang extends Model
{
    public function user(): HasOne
    {
        return $this->hasOne(User::class);
    }
    public function profile(): HasOne
    {
        return $this->hasOne(Profile::class);
    }
}
