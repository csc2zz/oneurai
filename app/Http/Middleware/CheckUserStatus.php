<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckUserStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
public function handle(Request $request, Closure $next)
{
    if (auth()->check()) {
        auth()->user()->update(['last_activity_at' => now()]);
        $status = auth()->user()->status;

        // 1. إذا كان محظوراً: تسجيل خروج فوراً وتوجيهه لرسالة الحظر
        if ($status === \App\Enums\UserStatus::BANNED) {
            auth()->logout();
            return redirect()->route('login')->with('error', 'حسابك محظور نهائياً من دخول المنصة.');
        }
    }

    return $next($request);
}
}
