<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Zone extends Model
{
    protected $guarded = ['id'];

    public function areas() {
        return $this->hasMany(Area::class);
    }
}
