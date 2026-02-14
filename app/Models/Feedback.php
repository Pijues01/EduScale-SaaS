<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    use HasFactory;
    protected $primaryKey = 'id';
    protected $table = 'feedbacks';

    protected $fillable = [
        'type', 'role_type', 'user_id', 'branch_id',
        'title', 'description', 'status', 'admin_notes'
    ];

    public function user()
    {
        // return $this->belongsTo(User::class);
         return $this->belongsTo(User::class, 'user_id', 'unique_id');
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }
}
