<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;


    public function classRoom()
    {
        return $this->hasOne(User::class);
    }
    public function subjects()
    {
        return $this->hasMany(Subject::class);
    }
}
