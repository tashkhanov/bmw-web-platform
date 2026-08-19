<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Wallpaper extends Model
{
    use HasFactory;

    protected $fillable = ['image_path'];

   protected static function booted()
    {
        static::deleting(function ($model) {
            if ($model->image_path) {
                Storage::disk('public_html')->delete($model->image_path);
            }
        });
    }
}
