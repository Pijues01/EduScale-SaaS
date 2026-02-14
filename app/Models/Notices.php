<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notices extends Model
{
    use HasFactory;
    protected $table = 'notices';
    protected $primaryKey = 'id';

    protected $fillable = ['title', 'shortdescription', 'description', 'audience', 'attachment'];

    protected $casts = [
        'audience' => 'array', // Store checkboxes as an array
    ];
    public $timestamps = true;

    // protected $casts = [
    //     'audience' => 'array'
    // ];

    public function getAudienceDisplayAttribute()
    {
        return ucfirst(implode(', ', $this->audience));
    }
}
