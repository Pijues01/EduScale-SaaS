<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;
    protected $table = 'student';
    protected $primaryKey = 'id';
    protected $fillable = ['stu_id', 'name', 'image', 'class', 'school_name', 'ph_no', 'email', 'address', 'medium', 'branch_id', 'status'];

    // Relationship to ClassLevel
    public function classLevel()
    {
        return $this->belongsTo(ClassLevels::class, 'class_level_id');
    }

    // Relationship to Branch
    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id');
    }

    // Relationship to Subject (if needed)
    public function subjects()
    {
        return $this->belongsToMany(Subject::class, 'student_subject', 'stu_id', 'subject_id');
    }
    public function class_level()
    {
        return $this->belongsTo(ClassLevels::class, 'class_level_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'stu_id', 'unique_id');
    }
}
