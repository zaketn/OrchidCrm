<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;

class Meetup extends Model
{
    use HasFactory, AsSource;

    protected $fillable = [
        'address',
        'place',
        'date_time',
    ];

    public function lead()
    {
        return $this->belongsTo(Lead::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

}
