<?php

namespace App\Livewire\Layouts;

use App\Models\ProjectInvitation;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class HeaderNotifications extends Component
{
    // 1. جلب الدعوات (كما كانت)
    public function getInvitationsProperty()
    {
        if (!Auth::check()) return collect([]);
        return ProjectInvitation::with(['project.user'])
            ->where('email', Auth::user()->email)
            ->latest()
            ->get();
    }

    // 2. جلب الإشعارات العامة (الجديدة)
    public function getNotificationsProperty()
    {
        if (!Auth::check()) return collect([]);
        // نأخذ آخر 10 إشعارات فقط للأداء
        return Auth::user()->notifications()->latest()->take(10)->get();
    }

    // 3. حساب العدد الكلي للإشعارات غير المقروءة + الدعوات
    public function getUnreadCountProperty()
    {
        return $this->invitations->count() + Auth::user()->unreadNotifications->count();
    }

    public function markAsRead($notificationId)
    {
        $notification = Auth::user()->notifications()->findOrFail($notificationId);
        $notification->markAsRead();
    }

    public function markAllAsRead()
    {
        Auth::user()->unreadNotifications->markAsRead();
    }

    // ... (دوال accept و reject تبقى كما هي) ...

    public function render()
    {
        return view('livewire.layouts.header-notifications');
    }
}
