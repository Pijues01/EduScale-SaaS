<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    use HasFactory;
    protected $table = 'teacher';
    protected $primaryKey = 'id';
    protected $fillable = ['teacher_id', 'name', 'image', 'subject', 'ph_no', 'email', 'address'];

    public function subject()
    {
        return $this->belongsTo(Subject::class, 'subject');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'teacher_id', 'unique_id');
    }
}
