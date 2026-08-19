<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Models\Car;


class OrderController extends Controller
{
    public function index(Request $request)
    {
        $initialModel = null;
        if ($request->filled('model')) {
        $car = \App\Models\Car::find($request->query('model'));
            if ($car) {
                $initialModel = [
                    'id' => $car->id,
                    'car' => $car->car,
                    'price' => $car->price,
                    'colors' => $car->colors,
                    'complectation' => $car->complectation,
                    'interior' => $car->interior,
                ];
            }
        }

        return view('store', [
            'initialModel' => $initialModel
        ]);
    }
}
