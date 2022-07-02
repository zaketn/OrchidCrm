<?php

namespace App\Models;

use App\Orchid\Presenters\LeadPresenter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

class Lead extends Model
{
    use HasFactory, AsSource, Filterable;

    public const STATUS_APPLIED = 'applied';
    public const STATUS_DECLINED = 'declined';
    public const STATUS_PENDING = 'pending';

    protected $fillable = [
        'customer_id',
        'header',
        'description',
        'desired_date',
        'status',
        'employee_message'
    ];

    protected $allowedSorts = [
        'id',
        'status'
    ];

    public function presenter()
    {
        return new LeadPresenter($this);
    }

    public function customer()
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
