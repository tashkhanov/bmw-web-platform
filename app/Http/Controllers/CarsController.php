<?php

namespace App\Http\Controllers;

use App\Models\Car;
use Illuminate\Http\Request;

class CarsController extends Controller
{
    public function index(Request $request, $category = null)
    {
        $allowed = ['sedans', 'crossovers', 'electrocars', 'm-series'];

        $query = Car::with('mainImage', 'otherImages');

        if ($category && in_array($category, $allowed)) {
            $query->where('category', $category);
            $currentCategory = $category;
        } else {
            $currentCategory = null;
        }

        if ($request->has('q') && $request->q) {
            $q = $request->q;
            $query->where(function ($sub) use ($q) {
                $sub->where('car', 'like', "%{$q}%")
                    ->orWhere('fuel', 'like', "%{$q}%")
                    ->orWhere('colors', 'like', "%{$q}%")
                    ->orWhere('interior', 'like', "%{$q}%");
            });
        }

        $cars = $query->get();

        $categoryNames = [
            'sedans' => 'Седаны',
            'crossovers' => 'Кроссоверы',
            'electrocars' => 'Электромобили',
            'm-series' => 'M-серия'
        ];

        return view('models', compact('cars', 'currentCategory', 'categoryNames'));
    }

    public function search(Request $request)
    {
        $q = $request->query('query', '');
        if (mb_strlen($q) < 2) {
            return response()->json([]);
        }

        $cars = Car::where('car', 'like', "%{$q}%")
            ->limit(10)
            ->get(['id', 'car']);

        return response()->json($cars);
    }

    public function getModelJson($id)
    {
        $car = Car::find($id);
        if (! $car) {
            return response()->json(null, 404);
        }

        return response()->json([
            'id' => $car->id,
            'car' => $car->car,
            'price' => $car->price,
            'colors' => $car->colors,
            'complectation' => $car->complectation,
            'interior' => $car->interior,
        ]);
    }
}
