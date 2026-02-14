<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Parents extends Model
{
    use HasFactory;
    protected $table = 'parent';
    protected $primaryKey = 'id';
    protected $fillable = ['parent_id', 'name', 'image', 'ph_no', 'email', 'address', 'stu_id'];


    public function user()
    {
        return $this->belongsTo(User::class, 'parent_id', 'unique_id');
    }
}
