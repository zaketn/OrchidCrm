<?php

namespace App\Models;

use App\Orchid\Presenters\MeetupPresenter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

class Meetup extends Model
{
    use HasFactory, AsSource, Filterable;

    public const STATUS_ARRANGED = 'arranged';
    public const STATUS_PAST = 'past';

    protected $allowedSorts = [
        'id',
        'address',
        'date_time',
    ];

    protected $allowedFilters = [
        'address',
        'date_time',
    ];

    protected $fillable = [
        'lead_id',
        'address',
        'place',
        'date_time',
    ];

    public function presenter()
    {
        return new MeetupPresenter($this);
    }

    public function lead()
    {
        return $this->belongsTo(Lead::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function customers()
    {
        return $this->users()->whereHas('roles', function (Builder $builder) {
            $builder->whereIn('slug', Role::CUSTOMERS);
        });
    }

    public function employees()
    {
        return $this->users()->whereHas('roles', function (Builder $builder) {
            $builder->whereIn('slug', Role::EMPLOYEES);
        });
    }
}
