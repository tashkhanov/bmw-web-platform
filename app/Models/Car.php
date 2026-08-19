<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use App\Models\CarImage;

class Car extends Model
{
    use HasFactory;

    protected $fillable = [
        'car','category','fuel','description','short_description','price','image',
        'complectation','colors','interior',
    ];

    protected $casts = [
        'colors' => 'array',
        'complectation' => 'array',
        'interior' => 'array',
        'price' => 'float',
    ];

    public function images()
    {
        return $this->hasMany(CarImage::class);
    }

    public function mainImage()
    {
        return $this->hasOne(CarImage::class)->where('is_main', true);
    }

    public function otherImages()
    {
        return $this->hasMany(CarImage::class)->where('is_main', false);
    }

    protected static function booted()
    {
        static::created(function (Car $car) {
            if (!empty($car->image)) {
                $car->images()->update(['is_main' => false]);

                $car->images()->create([
                    'image_path' => $car->image,
                    'is_main'    => true,
                ]);
            }
        });

        static::updated(function (Car $car) {
            if ($car->wasChanged('image') && !empty($car->image)) {
                $main = $car->images()->where('is_main', true)->first();

                if ($main) {
                    $main->update(['image_path' => $car->image]);
                } else {
                    $car->images()->update(['is_main' => false]);

                    $car->images()->create([
                        'image_path' => $car->image,
                        'is_main'    => true,
                    ]);
                }
            }
        });


        static::updating(function (Car $car) {
            if ($car->isDirty('image')) {
                $old = $car->getOriginal('image');
                if ($old) {
                    $disk = Storage::disk('cars');

                    if ($disk->exists($old)) {
                        $disk->delete($old);
                        return;
                    }

                    $maybe = 'images/images/' . basename($old);
                    if ($disk->exists($maybe)) {
                        $disk->delete($maybe);
                        return;
                    }
                }
            }
        });

        static::deleting(function (Car $car) {
            if ($car->image) {
                $disk = Storage::disk('cars');
                if ($disk->exists($car->image)) {
                    $disk->delete($car->image);
                } else {
                    $maybe = 'images/images/' . basename($car->image);
                    if ($disk->exists($maybe)) {
                        $disk->delete($maybe);
                    }
                }
            }
        });
    }
}
