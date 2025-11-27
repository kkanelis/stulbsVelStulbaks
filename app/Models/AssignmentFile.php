<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssignmentFile extends Model
{
    use HasFactory;

    protected $fillable = [
        'assignment_id', 'user_id', 'path', 'original_name', 'mime', 'size', 'note'
    ];

    public function assignment()
    {
        return $this->belongsTo(Assignment::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
