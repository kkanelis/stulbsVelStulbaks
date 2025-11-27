<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Assignment;

class Subject extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'teacher_id', 'code'];

    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    public function assignments()
    {
        return $this->hasMany(Assignment::class);
    }

    public function students()
    {
        return $this->belongsToMany(User::class, 'subject_student', 'subject_id', 'student_id');
    }
}
