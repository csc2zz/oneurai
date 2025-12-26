<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class GoogleAuthController extends Controller
{
    // 1. توجيه المستخدم إلى صفحة جوجل
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    // 2. استقبال المستخدم بعد الموافقة
public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            // البحث عن المستخدم
            $user = User::where('email', $googleUser->getEmail())->first();

            if(!$user) {
                // مستخدم جديد: ننشئ الحساب مع حفظ الـ ID والـ Token
                $user = User::create([
                    'name' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                    'username' => strtolower(str_replace(' ', '_', $googleUser->getName())) . rand(100, 999),
                    'google_id' => $googleUser->getId(),
                    'google_token' => $googleUser->token, // <--- تم إضافة هذا السطر
                    'password' => Hash::make(Str::random(16))
                ]);
            } else {
                // مستخدم موجود: نحدث بيانات جوجل فقط (مفيد لو تغير التوكن)
                $user->update([
                    'google_id' => $googleUser->getId(),
                    'google_token' => $googleUser->token, // <--- وتحديثه هنا أيضاً
                ]);
            }

            Auth::login($user);

            return redirect()->route('dashboard');

        } catch (\Exception $e) {
            // يفضل تسجيل الخطأ لنعرف السبب الدقيق في الـ Log
            \Illuminate\Support\Facades\Log::error('Google Login Error: ' . $e->getMessage());

            return redirect()->route('login')->with('error', 'حدث خطأ أثناء تسجيل الدخول، يرجى المحاولة مرة أخرى.');
        }
    }
}
