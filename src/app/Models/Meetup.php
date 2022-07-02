<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;

class Meetup extends Model
{
    use HasFactory, AsSource;

    protected $fillable = [
        'user_id',
        'customer_id',
        'address',
        'place',
        'date_time',
        'status',
        'employee_message'
    ];

    public function lead()
    {
        return $this->belongsTo(Lead::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
