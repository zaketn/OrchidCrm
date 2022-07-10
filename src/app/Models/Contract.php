<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    use HasFactory;

    public function project()
    {
        return $this->hasOne(Project::class);
    }

    public function company()
    {
        return $this->belongsTo(Contract::class);
    }
}
