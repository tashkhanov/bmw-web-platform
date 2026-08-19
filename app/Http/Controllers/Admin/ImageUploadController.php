<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Car;
use App\Models\CarImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImageUploadController extends Controller
{
    public function updateCarImage(Request $request, $id)
    {
        $request->validate([
            'image' => 'required|image|max:10240',
        ]);

        $car = Car::findOrFail($id);


        if ($car->image && file_exists(public_path($car->image))) {
            unlink(public_path($car->image));
        }


        $file = $request->file('image');
        $filename = time() . '_' . $file->getClientOriginalName();
        $path = 'images/images/' . $filename;

        $file->move(public_path('images/images'), $filename);

        $car->update(['image' => $path]);

        return response()->json([
            'success' => true,
            'message' => 'Изображение успешно обновлено',
            'image_path' => asset($path)
        ]);
    }

    public function updateCarImageImage(Request $request, $id)
    {
        $request->validate([
            'image' => 'required|image|max:10240',
        ]);

        $carImage = CarImage::findOrFail($id);


        if ($carImage->image_path && file_exists(public_path($carImage->image_path))) {
            unlink(public_path($carImage->image_path));
        }

        
        $file = $request->file('image');
        $filename = time() . '_' . $file->getClientOriginalName();
        $path = 'images/images/' . $filename;

        $file->move(public_path('images/images'), $filename);

        $carImage->update(['image_path' => $path]);

        return response()->json([
            'success' => true,
            'message' => 'Изображение успешно обновлено',
            'image_path' => asset($path)
        ]);
    }
}
