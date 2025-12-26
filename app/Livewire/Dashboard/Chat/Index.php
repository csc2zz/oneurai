<?php

namespace App\Livewire\Dashboard\Chat;

use Livewire\Component;
use App\Models\Conversation;
use App\Models\Message;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache; // ضروري للكاش

#[Layout('components.layouts.dashboard')]
class Index extends Component
{
    public $selectedConversationId;
    public $body = '';
    public $search = '';
    public $replyingTo = null; // لتخزين الرسالة التي يتم الرد عليها

    protected $listeners = ['refreshChat' => '$refresh', 'scrollToBottom'];

    // عندما يكتب المستخدم، نحدث الحالة في الكاش
    public function updatedBody()
    {
        if ($this->selectedConversationId) {
            // المفتاح: user_typing_[conversation_id]_[user_id]
            // ينتهي بعد 3 ثواني
            Cache::put('user_typing_' . $this->selectedConversationId . '_' . Auth::id(), true, now()->addSeconds(3));
        }
    }

    // التحقق هل الطرف الآخر يكتب الآن؟
    public function getIsOtherUserTypingProperty()
    {
        if (!$this->selectedConversationId) return false;

        $conversation = Conversation::find($this->selectedConversationId);
        $otherUserId = $conversation->receiver_id == Auth::id() ? $conversation->sender_id : $conversation->receiver_id;

        return Cache::has('user_typing_' . $this->selectedConversationId . '_' . $otherUserId);
    }

    public function getConversationsProperty()
    {
        return Conversation::query()
            ->where(function ($query) {
                $query->where('sender_id', Auth::id())
                      ->orWhere('receiver_id', Auth::id());
            })
            ->when($this->search, function ($query) {
                $query->where(function ($subQuery) {
                    $subQuery->whereHas('sender', function ($q) {
                        $q->where('name', 'like', '%' . $this->search . '%')
                          ->where('id', '!=', Auth::id());
                    })
                    ->orWhereHas('receiver', function ($q) {
                        $q->where('name', 'like', '%' . $this->search . '%')
                          ->where('id', '!=', Auth::id());
                    });
                });
            })
            ->with(['lastMessage', 'sender', 'receiver'])
            ->orderByDesc('last_message_at')
            ->get();
    }


    public function selectConversation($id)
    {
        $this->selectedConversationId = $id;
        
        Message::where('conversation_id', $id)
            ->where('user_id', '!=', Auth::id())
            ->where('is_read', false)
            ->update(['is_read' => true]);

        $this->dispatch('scrollToBottom');
    }

    public function setReplyTo($messageId)
{
    $this->replyingTo = Message::find($messageId);
    $this->dispatch('focus-input'); // تركيز المؤشر على حقل الكتابة
}

// 2. دالة إلغاء الرد
public function cancelReply()
{
    $this->replyingTo = null;
}

// 3. دالة إضافة/إزالة رياكشن
public function toggleReaction($messageId, $emoji)
{
    $message = Message::find($messageId);
    if (!$message) return;

    // التحقق هل الرياكشن موجود مسبقاً؟
    $existing = $message->reactions()
        ->where('user_id', Auth::id())
        ->where('emoji', $emoji)
        ->first();

    if ($existing) {
        $existing->delete(); // إزالة الرياكشن (Toggle Off)
    } else {
        $message->reactions()->create([
            'user_id' => Auth::id(),
            'emoji' => $emoji
        ]);
    }
}

// 4. تعديل دالة الإرسال (sendMessage) لدعم الردود
public function sendMessage()
{
    $this->validate(['body' => 'required|string|max:2000']);

    if ($this->selectedConversationId) {
        $conversation = Conversation::find($this->selectedConversationId);

        if ($conversation->status !== 'accepted') return;

        $conversation->messages()->create([
            'user_id' => Auth::id(),
            'body' => $this->body,
            'type' => 'text',
            'parent_id' => $this->replyingTo ? $this->replyingTo->id : null // حفظ الرد
        ]);

        $conversation->update(['last_message_at' => now()]);

        $this->body = '';
        $this->replyingTo = null; // تصفير الرد بعد الإرسال
        $this->dispatch('scrollToBottom');
    }
}

// ... تأكد من إضافة 'parent' و 'reactions' في دالة with()
public function getSelectedConversationProperty()
{
    if (!$this->selectedConversationId) return null;
    return Conversation::with([
        'messages.user', 
        'messages.parent.user', // جلب الرسالة الأصلية وصاحبها
        'messages.reactions',   // جلب الرياكشنات
        'sender', 
        'receiver'
    ])->find($this->selectedConversationId);
}

    public function acceptRequest()
    {
        $conversation = Conversation::find($this->selectedConversationId);
        if ($conversation && $conversation->receiver_id === Auth::id()) {
            $conversation->update(['status' => 'accepted']);
            $this->dispatch('scrollToBottom');
        }
    }

    public function rejectRequest()
    {
        $conversation = Conversation::find($this->selectedConversationId);
        if ($conversation && $conversation->receiver_id === Auth::id()) {
            $conversation->delete();
            $this->selectedConversationId = null;
        }
    }

    public function isUserOnline($userId)
    {
        return DB::table('sessions')
            ->where('user_id', $userId)
            ->where('last_activity', '>', now()->subMinutes(5)->getTimestamp())
            ->exists();
    }

    public function getUserLastSeen($userId)
    {
        $lastActivity = DB::table('sessions')
            ->where('user_id', $userId)
            ->latest('last_activity')
            ->value('last_activity');

        return $lastActivity ? \Carbon\Carbon::createFromTimestamp($lastActivity) : null;
    }

    public function render()
    {
        return view('livewire.dashboard.chat.index');
    }
}