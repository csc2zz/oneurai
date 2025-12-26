<?php

namespace App\Livewire\Profile;

use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Notifications\SystemNotification; // 1. استدعاء كلاس الإشعارات

class FollowButton extends Component
{
    public User $user;
    public $isFollowing = false;
    public $followersCount = 0;

    public function mount(User $user)
    {
        $this->user = $user;
        $this->followersCount = $user->followers()->count();

        if (Auth::check()) {
            $this->isFollowing = Auth::user()->isFollowing($user);
        }
    }

    public function toggleFollow()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        if (Auth::id() === $this->user->id) {
            return;
        }

        if ($this->isFollowing) {
            // إلغاء المتابعة
            Auth::user()->followings()->detach($this->user->id);
            $this->isFollowing = false;
            $this->followersCount--;
        } else {
            // تفعيل المتابعة
            Auth::user()->followings()->attach($this->user->id);
            $this->isFollowing = true;
            $this->followersCount++;

            // ==========================================
            // 2. إرسال الإشعار للطرف الثاني
            // ==========================================

            // نرسل الإشعار للمستخدم المتابَع ($this->user)
            $this->user->notify(new SystemNotification(
                'متابع جديد', // العنوان
                'قام ' . Auth::user()->name . ' بمتابعتك.', // الرسالة
                route('profile.show', Auth::user()->username), // الرابط (بروفايل المتابع)
                'fa-user-plus', // الأيقونة
                'text-emerald-600' // اللون
            ));
        }
    }

    public function render()
    {
        return view('livewire.profile.follow-button');
    }
}
