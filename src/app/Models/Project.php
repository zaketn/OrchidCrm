<?php

namespace App\Models;

use App\Orchid\Presenters\ProjectPresenter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Filters\Filterable;
use Orchid\Metrics\Chartable;
use Orchid\Screen\AsSource;

class Project extends Model
{
    use HasFactory, AsSource, Filterable, Chartable;

    public const STATUS_STARTED = 'started';
    public const STATUS_FINISHED = 'finished';
    public const STATUS_STOPPED = 'stopped';
    public const STATUS_CANCELLED = 'cancelled';

    protected $fillable = [
        'status',
        'name',
        'repo_link',
    ];

    protected $allowedFilters = [
        'name',
        'status',
        'created_at',
    ];

    protected $allowedSorts = [
        'id',
        'created_at',
    ];

    public function contract()
    {
        return $this->belongsTo(Contract::class);
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function presenter()
    {
        return new ProjectPresenter($this);
    }

    public function scopeStarted(Builder $query)
    {
        return $query->where('status', $this::STATUS_STARTED);
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

    public function getRoleNamesOfTeam(): array
    {
        return Role::whereHas('users',
            fn(Builder $query) => $query->whereIn('id', $this->employees->pluck('id')))
            ->get()
            ->pluck('name')
            ->toArray();
    }

    public function countTeamMembersByRole(): array
    {
        return $this->employees()->get()
            ->mapToGroups(fn($value) => [$value->roles()->first()->name => $value])
            ->map(fn($value) => $value->count())
            ->flatten()
            ->toArray();
    }
}
