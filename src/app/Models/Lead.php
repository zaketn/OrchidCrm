<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    use HasFactory;

    public function customers()
    {
        return $this->belongsTo(Customer::class);
    }

    public function meetups()
    {
        return $this->hasMany(Meetup::class);
    }

    public function contract()
    {
        return $this->hasOne(Contract::class);
    }
}
