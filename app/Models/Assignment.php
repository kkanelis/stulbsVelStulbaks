<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Subject;
use App\Models\User;
use App\Models\Grade;
use App\Models\AssignmentFile;

class Assignment extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'due_date', 'subject_id', 'teacher_id'];

    protected $casts = [
        'due_date' => 'datetime',
    ];

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    public function grades()
    {
        return $this->hasMany(Grade::class);
    }

    public function files()
    {
        return $this->hasMany(AssignmentFile::class);
    }
}
