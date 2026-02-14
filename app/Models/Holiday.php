<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Holiday extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';
    protected $table = 'holidays';


    // protected $fillable = ['title', 'date', 'description', 'is_recurring', 'branch_id'];
    // app/Models/Holiday.php
    protected $fillable = ['title', 'date', 'description', 'is_recurring', 'branch_id'];

    // app/Models/Holiday.php
    protected $casts = [
        'date' => 'date',
        'is_recurring' => 'boolean',
    ];

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }
}
