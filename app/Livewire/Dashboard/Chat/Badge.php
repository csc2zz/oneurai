<?php

namespace App\Livewire\Dashboard\Chat;

use Livewire\Component;
use App\Models\Conversation;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;

class Badge extends Component
{
    // الاستماع لأحداث تحديث الرسائل (إذا كنت تستخدمها) أو الاعتماد على التحديث التلقائي
    protected $listeners = ['refreshBadge' => '$refresh'];

    public function getUnreadCountProperty()
    {
        if (!Auth::check()) return 0;

        $userId = Auth::id();

        // 1. عدد طلبات التواصل المعلقة (حيث أنا المستقبل)
        $pendingRequests = Conversation::where('receiver_id', $userId)
            ->where('status', 'pending')
            ->count();

        // 2. عدد الرسائل غير المقروءة في المحادثات المقبولة
        // (نبحث عن الرسائل التي لم أرسلها أنا، وغير مقروءة، وتتبع لمحادثات أنا طرف فيها)
        $unreadMessages = Message::where('user_id', '!=', $userId) // لست أنا المرسل
            ->where('is_read', false)
            ->whereHas('conversation', function ($query) use ($userId) {
                $query->where('sender_id', $userId)
                      ->orWhere('receiver_id', $userId);
            })
            ->count();

        return $pendingRequests + $unreadMessages;
    }

    public function render()
    {
        return view('livewire.dashboard.chat.badge');
    }
}
