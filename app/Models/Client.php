<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $fillable = ['name', 'card_number'];

    public function cars()
    {
        return $this->hasMany(Car::class);
    }

    public function services()
    {
        return $this->hasMany(Service::class);
    }
}
