<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CompleteProfileController extends Controller
{
    public function show()
    {
        return view('auth.complete-profile');
    }

    public function store(Request $request)
    {
        $request->validate([
            'phone' => ['required', 'string', 'regex:/^\+\d{7,15}$/'], // E.164
        ]);

        $user = Auth::user();
        $user->phone = $request->phone;
        $user->save();

        if ($user->is_admin) {
            return redirect('/khan');
        }

        return redirect()->route('home.page');
    }
}
