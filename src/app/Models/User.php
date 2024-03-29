<?php

namespace App\Models;

use App\Orchid\Presenters\UserPresenter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Notifications\Notifiable;
use Orchid\Platform\Models\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'name',
        'last_name',
        'middle_name',
        'phone',
        'email',
        'password',
        'permissions',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'permissions',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'permissions'          => 'array',
        'email_verified_at'    => 'datetime',
    ];

    /**
     * The attributes for which you can use filters in url.
     *
     * @var array
     */
    protected $allowedFilters = [
        'id',
        'last_name',
        'email',
        'permissions',
    ];

    /**
     * The attributes for which can use sort in url.
     *
     * @var array
     */
    protected $allowedSorts = [
        'id',
        'last_name',
        'email',
        'updated_at',
        'created_at',
    ];

    public function presenter()
    {
        return new UserPresenter($this);
    }

    public function getFullNameAttribute() : string
    {
        return $this->presenter()->fullName(). ' | ' . $this->presenter()->subTitle();
    }

    public function getFirstAndLastNameAttribute() : string
    {
        return $this->attributes['last_name'].' '.$this->attributes['name'];
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function meetups()
    {
        return $this->belongsToMany(Meetup::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function leads()
    {
        return $this->hasMany(Lead::class);
    }

    public function projects()
    {
        return $this->belongsToMany(Project::class);
    }

    public function scopeCustomers()
    {
        return $this->whereHas('roles', function (Builder $builder) {
            $builder->whereIn('slug', Role::CUSTOMERS);
        });
    }

    public function scopeEmployees()
    {
        return $this->whereHas('roles', function (Builder $builder) {
            $builder->whereIn('slug', Role::EMPLOYEES);
        });
    }

    public function isEmployee()
    {
        return $this->roles()->whereIn('slug', Role::EMPLOYEES)->exists();
    }

    public function finishedTasks()
    {
        $tasks = $this->tasks()->get();

        return $tasks->where('status', Task::STATUS_FINISHED);
    }

    public function pendingTasks()
    {
        $tasks = $this->tasks()->get();

        return $tasks->where('status', Task::STATUS_CREATED);
    }
}
