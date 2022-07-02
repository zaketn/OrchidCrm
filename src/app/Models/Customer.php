<?php

namespace App\Models;

use App\Orchid\Presenters\CustomerPresenter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    public function getFullNameAttribute() : string
    {
        return $this->attributes['last_name'].' '.$this->attributes['name'].' '.$this->attributes['middle_name'];
    }

    public function presenter()
    {
        return new CustomerPresenter($this);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function leads()
    {
        return $this->hasMany(Lead::class);
    }

    public function meetups()
    {
        return $this->hasMany(Meetup::class);
    }
}
