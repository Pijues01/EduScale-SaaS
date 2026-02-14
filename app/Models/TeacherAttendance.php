<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeacherAttendance extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';
    protected $table = 'teacher_attendances';
    protected $fillable = [
        'teacher_id',
        'class_routine_id',
        'date',
        'status',
        'remarks'
    ];

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    public function classRoutine()
    {
        return $this->belongsTo(ClassRoutine::class);
    }
}
