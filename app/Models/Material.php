<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';
    protected $table = 'materials';

    protected $fillable = [
        'teacher_id', 'class_id', 'title', 'description',
        'type', 'file_path', 'content'
    ];

    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    public function class()
    {
        return $this->belongsTo(ClassLevels::class, 'class_id');
    }
}
