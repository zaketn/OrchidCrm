<?php

namespace App\Models;

use App\Orchid\Presenters\TaskPresenter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

class Task extends Model
{
    use HasFactory, AsSource, Filterable;

    public const STATUS_CREATED = 'Ожидает выполнения';
    public const STATUS_STARTED = 'Начата';
    public const STATUS_FINISHED = 'Завершена';

    protected $fillable = [
        'user_id',
        'project_id',
        'header',
        'description',
        'finished',
        'hours',
        'start_date',
        'end_date'
    ];

    protected $allowedSorts = [
        'id',
        'created_at',
    ];

    protected $allowedFilters = [
        'header',
        'user_id',
        'project_id',
        'created_at',
    ];

    public function getRuntimeAttribute() : string
    {
        return $this->presenter()->readableTimeDiff($this->start_date, $this->end_date);
    }

    public function getStatusAttribute() : string
    {
        if(empty($this->start_date))
            return $this::STATUS_CREATED;

        elseif(empty($this->end_date))
            return $this::STATUS_STARTED;

        return $this::STATUS_FINISHED;
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function presenter()
    {
        return new TaskPresenter($this);
    }
}
