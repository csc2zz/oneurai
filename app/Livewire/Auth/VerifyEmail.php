<?php

namespace App\Livewire\Auth;

use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('components.layouts.auth')]
#[Title('التحقق من الرمز | Oneurai')]
class VerifyEmail extends Component
{
    public $otp = '';
    public $is_verified = false; // متغير للتحكم بحالة التحقق أمام Alpine

public function verify()
{
    $user = Auth::user();

    if ($user->verifyOtp($this->otp)) {
        // تحديث الجلسة: تم التحقق بنجاح لهذا الدخول
        session(['otp_verified' => true]);

        $this->dispatch('otp-success');
        return redirect()->intended(route('home'));
    } else {
        $this->otp = '';
        $this->dispatch('otp-error');
    }
}

    public function render()
    {
        return view('livewire.auth.verify-email');
    }
}
