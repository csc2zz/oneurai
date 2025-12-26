<?php

namespace App\Livewire\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('components.layouts.auth')]
#[Title('إنشاء حساب جديد | Oneurai')]
class RegisterPage extends Component
{
    public string $name = '';
    public string $username = '';
    public ?string $usernameStatus = null; // available | taken | invalid | null
    public string $email = '';
    public ?string $emailStatus = null; // available | taken | invalid | null
    public string $password = '';
    public bool $terms = false;

    public function updatedUsername($value): void
    {
        $value = strtolower(preg_replace('/[^a-z0-9_]/', '', (string) $value));

        // ✅ خله دايمًا sanitized داخل السيرفر
        if ($this->username !== $value) {
            $this->username = $value;
        }

        if ($value === '') {
            $this->usernameStatus = null;
            return;
        }

        if (strlen($value) < 3 || strlen($value) > 20 || !preg_match('/^[a-z0-9_]+$/', $value)) {
            $this->usernameStatus = 'invalid';
            return;
        }

        $exists = User::where('username', $value)->exists();
        $this->usernameStatus = $exists ? 'taken' : 'available';
    }
    
    public function updatedEmail($value): void
{
    $value = trim(strtolower((string) $value));
    $this->email = $value;

    if ($value === '') {
        $this->emailStatus = null;
        return;
    }

    // تحقق صيغة الإيميل
    if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
        $this->emailStatus = 'invalid';
        return;
    }

    // تحقق هل مستخدم
    $exists = User::whereRaw('LOWER(email) = ?', [$value])->exists();
    $this->emailStatus = $exists ? 'taken' : 'available';
}


    public function register()
    {
        $this->validate([
            'name' => 'required|min:3',
            'username' => ['required', 'string', 'min:3', 'max:20', 'regex:/^[a-z0-9_]+$/', 'unique:users,username'],
            'email' => 'required|email|unique:users,email',
            'password' => [
                'required',
                'string',
                Password::min(8)->mixedCase()->numbers()->symbols()->uncompromised(),
            ],
            'terms' => 'accepted',
        ], [
            'username.unique' => 'اسم المستخدم هذا محجوز مسبقاً.',
            'username.regex' => 'اسم المستخدم يجب أن يكون أحرف إنجليزية صغيرة وأرقام و _ فقط.',
            'terms.accepted' => 'يجب الموافقة على الشروط.',
            'password.uncompromised' => 'كلمة المرور هذه ضعيفة جداً أو تم تسريبها سابقاً، اختر كلمة أصعب.',
        ]);

        $user = User::create([
            'name' => $this->name,
            'username' => $this->username,
            'email' => $this->email,
            'password' => Hash::make($this->password),
        ]);

        $otp = $user->generateOtp();
        \Illuminate\Support\Facades\Mail::to($user->email)->send(new \App\Mail\SendOtpMail($otp));

        Auth::login($user);

        return redirect()->route('home');
    }

    public function render()
    {
        return view('livewire.auth.register-page');
    }
}
