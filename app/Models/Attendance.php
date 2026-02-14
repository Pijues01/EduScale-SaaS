<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';
    protected $table = 'student_attendance';


    protected $fillable = ['student_id', 'class_routine_id', 'date', 'status', 'remarks'];


    public function classRoutine()
    {
        return $this->belongsTo(ClassRoutine::class, 'class_routine_id');
    }
    
    /**
     * Get the student for this attendance record
     */
    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id', 'stu_id');
    }



}
