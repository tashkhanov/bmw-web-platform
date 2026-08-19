<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckAdminAccess
{
    public function handle(Request $request, Closure $next): Response
    {
        // Проверяем, что пользователь аутентифицирован и является администратором
        if (!Auth::check() || !Auth::user()->is_admin) {
            return redirect('/')->with('error', 'У вас нет доступа к панели администратора');
        }

        return $next($request);
    }
}