<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ClassLevels extends Model
{
    // use HasFactory;
    // protected $table = 'class_levels';
    // protected $primaryKey = 'id';

    // // Relationship with ClassRoutine
    // public function classRoutines(): HasMany
    // {
    //     return $this->hasMany(ClassRoutine::class);
    // }

     use HasFactory;

    protected $table = 'class_levels';
    protected $primaryKey = 'id';

    protected $fillable = ['name', 'description'];


    // Relationship with ClassRoutine
    public function classRoutines(): HasMany
    {
        return $this->hasMany(ClassRoutine::class);
    }

     public function routines()
    {
        return $this->hasMany(ClassRoutine::class);
    }
    public function students()
    {
        return $this->hasMany(Student::class, 'class');
    }
}
