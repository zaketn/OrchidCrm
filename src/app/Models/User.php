<?php

namespace App\Models;

use App\Orchid\Presenters\UserPresenter;
use Illuminate\Database\Eloquent\Builder;
use Orchid\Platform\Models\User as Authenticatable;

class User extends Authenticatable
{
    public const ROLES_EMPLOYEES = ['cio', 'ceo', 'manager', 'agent', 'hl_dev', 'dev'];
    public const ROLES_CUSTOMERS = ['customer'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
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
        'name',
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
        'name',
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
        $userRoles = $this->getRoles()->implode('name', ', ');

        return $this->attributes['last_name'].' '.$this->attributes['name'].' '.$this->attributes['middle_name'].' | ' . $userRoles;
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
        return $this->hasMany(Project::class);
    }

    public function scopeCustomers()
    {
        return $this->whereHas('roles', function (Builder $builder) {
            $builder->whereIn('slug', $this::ROLES_CUSTOMERS);
        });
    }

    public function scopeEmployees()
    {
        return $this->whereHas('roles', function (Builder $builder) {
            $builder->whereIn('slug', $this::ROLES_EMPLOYEES);
        });
    }

    public function isEmployee()
    {
        return $this->roles()->whereIn('slug', $this::ROLES_EMPLOYEES)->exists();
    }
}
