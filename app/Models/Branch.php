<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Branch extends Model
{
    // use HasFactory;

    // protected $table = 'branches';
    // protected $primaryKey = 'id';

    // protected $fillable = [
    //     'branch_name', 'location', 'description', 'working_hours', 'contact', 'email', 'images'
    // ];

    // protected $casts = [
    //     'images' => 'array'
    // ];
    // public $timestamps = true;

    // public function classRoutines(): HasMany
    // {
    //     return $this->hasMany(ClassRoutine::class);
    // }

    use HasFactory;

    protected $table = 'branches';
    protected $primaryKey = 'id';

    protected $fillable = [
        'branch_name',
        'location',
        'description',
        'working_hours',
        'contact',
        'email',
        'images'
    ];

    protected $casts = [
        'images' => 'array'
    ];
    public $timestamps = true;

    public function classRoutines(): HasMany
    {
        return $this->hasMany(ClassRoutine::class);
    }


    public function todayClasses()
    {
        $today = strtolower(now()->format('l'));

        return $this->hasMany(ClassRoutine::class)
            ->where('day_of_week', $today)
            ->orderBy('start_time');
    }
}
