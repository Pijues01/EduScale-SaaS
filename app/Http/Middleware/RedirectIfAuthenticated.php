<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    // public function handle(Request $request, Closure $next, string ...$guards): Response
    // {
    //     $guards = empty($guards) ? [null] : $guards;

    //     foreach ($guards as $guard) {
    //         if (Auth::guard($guard)->check()) {
    //             return redirect(RouteServiceProvider::HOME);
    //         }
    //     }

    //     return $next($request);
    // }

    //     public function handle(Request $request, Closure $next)
    // {
    //     if (Auth::check()) {
    //         return redirect($this->redirectToDashboard(Auth::user()->role));
    //     }

    //     return $next($request);
    // }
    // private function redirectToDashboard($role)
    // {
    //     switch ($role) {
    //         case 'admin':
    //             return route('admin.dashboard');
    //         case 'teacher':
    //             return route('teacher.dashboard');
    //         case 'student':
    //             return route('student.dashboard');
    //         case 'parent':
    //             return route('parent.dashboard');
    //         default:
    //             return route('login');
    //     }
    // }


        public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            return redirect($this->redirectToDashboard(Auth::user()->role));
        }
        return $next($request);
    }

    private function redirectToDashboard($role)
    {
        switch ($role) {
            case 'admin':
                return route('admin.dashboard');
            case 'teacher':
                return route('teacher.dashboard');
            case 'student':
                return route('student.dashboard');
            case 'parent':
                return route('parent.dashboard');
            default:
                return route('login');
        }
    }
}
