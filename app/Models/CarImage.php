<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class CarImage extends Model
{
    use HasFactory;

    protected $fillable = ['car_id', 'image_path', 'is_main'];

    protected $casts = [
        'is_main' => 'boolean',
    ];

    public function car()
    {
        return $this->belongsTo(Car::class);
    }

    protected static function booted()
    {
        static::updating(function (CarImage $image) {
            if ($image->isDirty('image_path')) {
                $old = $image->getOriginal('image_path');
                if ($old) {
                    $disk = Storage::disk('cars');
                    if ($disk->exists($old)) {
                        $disk->delete($old);
                        return;
                    }
                    $maybe = 'images/images/' . basename($old);
                    if ($disk->exists($maybe)) {
                        $disk->delete($maybe);
                    }
                }
            }
        });

        static::deleting(function (CarImage $image) {
            if ($image->image_path) {
                $disk = Storage::disk('cars');
                if ($disk->exists($image->image_path)) {
                    $disk->delete($image->image_path);
                } else {
                    $maybe = 'images/images/' . basename($image->image_path);
                    if ($disk->exists($maybe)) {
                        $disk->delete($maybe);
                    }
                }
            }
        });
    }
}
