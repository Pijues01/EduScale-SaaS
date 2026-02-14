<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class ClassRoutine extends Model
{
    // use HasFactory;
    // protected $table = 'class_routines';
    // protected $primaryKey = 'id';
    // protected $fillable = ['branch_id', 'class_level_id', 'day_of_week'];

    // public function periods()
    // {
    //     return $this->hasMany(ClassPeriod::class, 'routine_id');
    // }

    // public function branch()
    // {
    //     return $this->belongsTo(Branch::class);
    // }

    // public function classLevel()
    // {
    //     return $this->belongsTo(ClassLevel::class);
    // }

    use HasFactory;

    protected $table = 'class_routines';
    protected $primaryKey = 'id';
    // protected $fillable = ['branch_id', 'class_level_id', 'day_of_week'];

    // public function periods(): HasMany
    // {
    //     return $this->hasMany(ClassPeriod::class, 'routine_id');
    // }

    // public function branch(): BelongsTo
    // {
    //     return $this->belongsTo(Branch::class);
    // }

    // public function classLevel(): BelongsTo
    // {
    //     return $this->belongsTo(ClassLevels::class);
    // }
    protected $fillable = [
        'branch_id',
        'class_level_id',
        'day_of_week',
        'start_time',
        'end_time',
        'subject_id',
        'teacher_id'
    ];

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function classLevel()
    {
        return $this->belongsTo(ClassLevels::class);
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    // public function teacher()
    // {
    //     return $this->belongsTo(Teacher::class);
    // }
    public function teacher()
    {
        return $this->belongsTo(Teacher::class, 'teacher_id', 'teacher_id');
        //                        Model       Foreign Key     Owner Key (in Teacher table)
    }

    public function class_levels()
    {
        return $this->belongsTo(ClassLevels::class, 'class_level_id');
    }

    // public function subject()
    // {
    //     return $this->belongsTo(Subject::class, 'subject_id');
    // }
}
