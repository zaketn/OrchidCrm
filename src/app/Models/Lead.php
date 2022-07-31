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
        'user_id',
        'header',
        'description',
        'desired_date',
        'status',
        'employee_message'
    ];

    protected $allowedSorts = [
        'id',
        'status',
        'desired_date'
    ];

    protected $allowedFilters = [
        'header',
        'desired_date',
        'status'
    ];

    public function presenter()
    {
        return new LeadPresenter($this);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function meetups()
    {
        return $this->hasMany(Meetup::class);
    }

    public function contract()
    {
        return $this->hasOne(Contract::class);
    }

    public function isProcessed() : bool
    {
        return $this->status == $this::STATUS_PENDING;
    }
}
