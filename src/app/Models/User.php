<?php

namespace App\Models;

use App\Orchid\Presenters\UserPresenter;
use Orchid\Platform\Models\User as Authenticatable;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'employment_date',
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

    public function getFullNameWithRolesAttribute() : string {
        $userRoles = [];
        foreach($this->getRoles() as $role){
            $userRoles[] = $role->name;
        }
        $userRoles = implode(' ', $userRoles);

        return $this->attributes['last_name'].' '.$this->attributes['name'].' '.$this->attributes['middle_name'].' | ' . $userRoles;
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function meetups()
    {
        return $this->hasMany(Meetup::class);
    }

    public function presenter() : UserPresenter
    {
        return new UserPresenter($this);
    }
}
