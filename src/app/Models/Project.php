<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    public function contract()
    {
        return $this->belongsTo(Contract::class);
    }

    public function tasks()
    {
        $this->hasMany(Task::class);
    }
}
