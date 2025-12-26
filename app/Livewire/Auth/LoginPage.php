<?php

namespace App\Livewire\Auth;

use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('components.layouts.auth')]
#[Title('تسجيل الدخول | Oneurai')]
class LoginPage extends Component
{
    public $email = '';
    public $password = '';
    public $remember = false;

public function login()
{
    $this->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    if (!Auth::attempt(['email' => $this->email, 'password' => $this->password], $this->remember)) {
        $this->addError('email', 'البريد الإلكتروني أو كلمة المرور غير صحيحة.');
        return;
    }

    $user = Auth::user();

    // توليد رمز جديد في كل عملية دخول
    $otp = $user->generateOtp();

    // إرسال الرمز عبر Hostinger
    try {
        \Illuminate\Support\Facades\Mail::to($user->email)->send(new \App\Mail\SendOtpMail($otp));
    } catch (\Exception $e) {
        // سجل الخطأ
    }

    // وسم الجلسة بأنها تحتاج تحقق OTP
    session(['otp_verified' => false]);

    return redirect()->route('verification.notice');
}

        // 4. نجاح الدخول (إذا كان مفعلاً أصلاً)

    public function render()
    {
        return view('livewire.auth.login-page');
    }
}
