<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Car;
use App\Models\Wallpaper;

class PageController extends Controller
{
    public function homePage()
    {
        $latestCars = Car::with('otherImages')->latest()->take(2)->get();
        $wallpapers = Wallpaper::latest()->take(10)->get();
        return view('index', compact('latestCars', 'wallpapers'));
    }

    public function store()
    {
        return view('store');
    }

    public function carInfo($id)
    {
        $car = Car::with('otherImages')->findOrFail($id);
        return view('car-info', compact('car'));
    }

    public function wallpapers()
    {
        $latest = Wallpaper::latest()->take(7)->get();
        $wallpapers = Wallpaper::latest()->paginate(6);
        return view('wallpapers', compact('wallpapers', 'latest'));
    }

    public function downloadWallpaper($id)
    {
        $wallpaper = Wallpaper::findOrFail($id);

        $filePath = public_path($wallpaper->image_path);

        if (!file_exists($filePath)) {
            return redirect()->back()->with('error', 'Файл не найден.');
        }

        $fileName = basename($filePath);

        return response()->download($filePath, $fileName, [
            'Content-Type' => mime_content_type($filePath),
            'Cache-Control' => 'no-cache, must-revalidate',
        ]);
    }
}
