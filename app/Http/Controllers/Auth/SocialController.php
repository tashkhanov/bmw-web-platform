<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;


class SocialController extends Controller
{
    public function redirectToProvider(string $provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function handleProviderCallback($provider)
    {
        try {
            $socialUser = Socialite::driver($provider)->user();
        } catch (\Exception $e) {
            return redirect()->route('login')->withErrors('Ошибка авторизации через социальную сеть.');
        }

        $user = User::where('email', $socialUser->getEmail())->first();

        $isNewUser = false;
        if (!$user) {
            $user = User::create([
                'name' => $socialUser->getName(),
                'email' => $socialUser->getEmail(),
                'password' => Hash::make(Str::random(16)),
            ]);
            $isNewUser = true;
        }

        Auth::login($user, true);

        if ($isNewUser || empty($user->phone)) {
            return redirect()->route('profile.complete');
        }

        if ($user->is_admin) {
            return redirect('/khan');
        }

        return redirect()->intended(route('home.page'));
    }
}
