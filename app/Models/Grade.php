<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Assignment;
use App\Models\User;

class Grade extends Model
{
    use HasFactory;

    protected $fillable = ['assignment_id', 'student_id', 'grade', 'feedback'];

    protected $casts = [
        'grade' => 'float',
    ];

    public function assignment()
    {
        return $this->belongsTo(Assignment::class);
    }

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }
}
