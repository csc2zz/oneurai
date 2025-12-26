<?php

namespace App\Livewire\Chat;

use Livewire\Component;
use App\Models\Conversation;
use App\Models\Message;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Notifications\SystemNotification; // ✅ استدعاء كلاس الإشعار الموجود لديك

class SendInvitation extends Component
{
    public User $receiver;
    public $message = '';
    public $isOpen = false;

    public $conversationStatus = null;
    public $conversationId = null;

    public function mount(User $user)
    {
        $this->receiver = $user;
        $this->checkStatus();
    }

    public function checkStatus()
    {
        $conversation = Conversation::where(function ($q) {
            $q->where('sender_id', Auth::id())->where('receiver_id', $this->receiver->id);
        })->orWhere(function ($q) {
            $q->where('sender_id', $this->receiver->id)->where('receiver_id', Auth::id());
        })->first();

        if ($conversation) {
            $this->conversationStatus = $conversation->status;
            $this->conversationId = $conversation->id;
        }
    }

    public function openModal()
    {
        if ($this->conversationId) {
            return redirect()->route('dashboard.chat', ['id' => $this->conversationId]);
        }
        $this->isOpen = true;
    }

    public function sendInvitation()
    {
        $this->validate([
            'message' => 'required|string|max:500',
        ]);

        // 1. إنشاء المحادثة
        $conversation = Conversation::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $this->receiver->id,
            'status' => 'pending',
            'last_message_at' => now(),
        ]);

        // 2. إنشاء الرسالة الأولى
        Message::create([
            'conversation_id' => $conversation->id,
            'user_id' => Auth::id(),
            'body' => $this->message,
            'type' => 'text',
        ]);

        // 3. ✅ إرسال الإشعار باستخدام SystemNotification
        $senderName = Auth::user()->name;
        $chatUrl = route('dashboard.chat', ['id' => $conversation->id]);

        $this->receiver->notify(new SystemNotification(
            'طلب تواصل جديد',                               // العنوان
            "يرغب {$senderName} في التواصل معك.",           // الرسالة
            $chatUrl,                                       // الرابط
            'fa-solid fa-comments',                         // الأيقونة
            'text-emerald-600'                              // اللون
        ));

        // تحديث الحالة وإغلاق المودال
        $this->conversationStatus = 'pending';
        $this->conversationId = $conversation->id;
        $this->isOpen = false;
        $this->message = '';

        $this->dispatch('toast', message: 'تم إرسال الطلب والإشعار بنجاح', type: 'success');
    }

    public function render()
    {
        return view('livewire.chat.send-invitation');
    }
}
