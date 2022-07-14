<?php

namespace App\Models;

use App\Orchid\Presenters\ProjectPresenter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    public const STATUS_STARTED = 'started';
    public const STATUS_FINISHED = 'finished';
    public const STATUS_STOPPED = 'stopped';
    public const STATUS_DEV = 'dev';
    public const STATUS_CANCELLED = 'cancelled';

    public function contract()
    {
        return $this->belongsTo(Contract::class);
    }

    public function tasks()
    {
        $this->hasMany(Task::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function presenter()
    {
        return new ProjectPresenter($this);
    }
}
