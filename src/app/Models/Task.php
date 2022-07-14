<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;

class Task extends Model
{
    use HasFactory, AsSource;

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

    protected $casts = [
        'finished' => 'boolean'
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
