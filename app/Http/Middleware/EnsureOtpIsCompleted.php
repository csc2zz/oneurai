<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureOtpIsCompleted
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            $user = Auth::user();

            // 🆕 الاستثناء: إذا كان المستخدم مسجلاً عبر قوقل، نتخطى فحص الـ OTP
            // تأكد أن 'google_id' هو اسم العمود الموجود لديك في قاعدة البيانات
            if ($user->google_id !== null) {
                return $next($request);
            }

            // إذا لم يكن من مستخدمي قوقل، نتحقق من الـ OTP
            if (session('otp_verified') !== true) {

                // السماح فقط بصفحة التحقق وتسجيل الخروج والـ Livewire
                if (!$request->routeIs('verification.notice') && !$request->routeIs('logout') && !$request->is('livewire/*')) {

                    // تسجيل الخروج للأمان إذا حاول الوصول لصفحات محمة
                    Auth::logout();
                    $request->session()->invalidate();
                    $request->session()->regenerateToken();

                    return redirect()->route('login')->withErrors([
                        'email' => 'يجب إكمال التحقق الثنائي في كل مرة تدخل فيها إلى ونوراي.'
                    ]);
                }
            }
        }

        return $next($request);
    }
}