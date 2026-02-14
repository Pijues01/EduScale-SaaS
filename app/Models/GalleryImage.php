<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GalleryImage extends Model
{
    use HasFactory;

    protected $table = 'gallery_images';
    protected $primaryKey = 'id';
    protected $fillable = ['image_path', 'is_featured'];
    public $timestamps = true;
}

