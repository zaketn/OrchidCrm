<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    public const LOCAL_COMPANY = 'local';
    public const LOCAL_EMAIL = 'local';
    public const LOCAL_PHONE = 'local';

    protected $fillable = [
        'name',
        'email',
        'phone'
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function projects()
    {
        return $this->hasMany(Project::class);
    }
}
