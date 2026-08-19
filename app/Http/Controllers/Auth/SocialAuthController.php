<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class SocialAuthController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        $googleUser = Socialite::driver('google')->stateless()->user();

        $email = $googleUser->getEmail();
        $name = $googleUser->getName() ?? $googleUser->getNickname();

        if (!$email) {
            return redirect()->route('login')->with('error', 'Не удалось получить email из Google.');
        }

        $user = User::where('email', $email)->first();

        if (!$user) {
            $user = User::create([
                'name' => $name ?? $email,
                'email' => $email,
                'password' => Hash::make(Str::random(24)),
            ]);
        } else {
            if ($name && $user->name !== $name) {
                $user->name = $name;
                $user->save();
            }
        }

        Auth::login($user, true);

        if (empty($user->phone)) {
            return redirect()->route('profile.complete');
        }

        $redirect = session()->pull('url.intended', null);
        if ($user->is_admin) {
            return redirect()->intended(config('filament.path', 'khan'));
        }

        return redirect()->intended($redirect ?: route('models'));
    }
}
