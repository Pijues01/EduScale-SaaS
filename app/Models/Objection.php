<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Objection extends Model
{
    use HasFactory;
    protected $table = 'objections';
    protected $primaryKey = 'id';

    protected $fillable = [
        'student_id',
        'class_level_id',
        'branch_id',
        'teacher_id',
        'title',
        'description',
        'approved'
    ];

    // In app/Models/Objection.php
    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id', 'stu_id');
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class, 'teacher_id', 'teacher_id');
    }

    public function classLevel()
    {
        return $this->belongsTo(ClassLevels::class);
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }
}
