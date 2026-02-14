<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    use HasFactory;

    protected $table = 'applications';
    protected $primaryKey = 'id';

    protected $fillable = ['job_id', 'name', 'email', 'phone', 'resume','message'];
    public $timestamps = true;
    public function job()
    {
        return $this->belongsTo(Job::class);
    }
}
