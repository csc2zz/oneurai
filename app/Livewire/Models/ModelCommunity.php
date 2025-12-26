<?php

namespace App\Livewire\Models;

use App\Models\AiModel;
use App\Models\User;
use App\Models\ModelComment;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Auth;
use App\Notifications\SystemNotification;

class ModelCommunity extends Component
{
    public AiModel $model;
    public User $author;

    public $sort = 'popular'; // القيم: 'latest' أو 'popular'

    // المتغيرات
    public $newComment = '';
    public $replyContent = ''; // محتوى الرد
    public $replyingToId = null; // تحديد التعليق الذي نرد عليه
    public $search = '';

    public function mount($username, $slug)
    {
        $this->author = User::where('username', $username)->firstOrFail();
        $this->model = AiModel::where('user_id', $this->author->id)
            ->where('slug', $slug)
            ->firstOrFail();
    }

    public function setSort($sortType)
{
    $this->sort = $sortType;
}

    // نشر تعليق رئيسي
    public function postComment()
    {
        $this->validate(['newComment' => 'required|string|min:3|max:1000']);

        if (!Auth::check()) return redirect()->route('login');

        $this->model->comments()->create([
            'user_id' => Auth::id(),
            'content' => $this->newComment,
            'parent_id' => null // تعليق رئيسي
        ]);

        $this->notifyOwner($this->model->title);
        $this->reset('newComment');
    }

    // تفعيل وضع الرد (يفتح صندوق الرد تحت التعليق)
    public function setReplyTo($commentId)
    {
        $this->replyingToId = $commentId;
        $this->replyContent = ''; // تنظيف الحقل
    }

    // نشر الرد
    public function postReply()
    {
        $this->validate(['replyContent' => 'required|string|min:1|max:1000']);

        if (!Auth::check()) return redirect()->route('login');

        $parentComment = ModelComment::findOrFail($this->replyingToId);

        $this->model->comments()->create([
            'user_id' => Auth::id(),
            'content' => $this->replyContent,
            'parent_id' => $parentComment->id // ربط بالأب
        ]);

        // إشعار لصاحب التعليق الأصلي
        if (Auth::id() !== $parentComment->user_id) {
            $parentComment->user->notify(new SystemNotification(
                'رد جديد',
                'قام ' . Auth::user()->name . ' بالرد على تعليقك.',
                route('models.community', [$this->author->username, $this->model->slug]),
                'fa-reply',
                'text-indigo-600'
            ));
        }

        $this->reset(['replyContent', 'replyingToId']);
    }

    // الإعجاب / إزالة الإعجاب
    public function toggleLike($commentId)
    {
        if (!Auth::check()) return redirect()->route('login');

        $comment = ModelComment::findOrFail($commentId);
        $user = Auth::user();

        if ($comment->likes()->where('user_id', $user->id)->exists()) {
            $comment->likes()->detach($user->id); // إزالة اللايك
        } else {
            $comment->likes()->attach($user->id); // إضافة لايك
        }
    }

    // حذف التعليق
    public function deleteComment($commentId)
    {
        $comment = ModelComment::findOrFail($commentId);
        if (Auth::id() === $comment->user_id || Auth::id() === $this->model->user_id) {
            $comment->delete();
        }
    }

    // دالة مساعدة للإشعارات
    private function notifyOwner($title)
    {
        if (Auth::id() !== $this->model->user_id) {
            $this->model->user->notify(new SystemNotification(
                'مناقشة جديدة',
                'تعليق جديد على النموذج: ' . $title,
                route('models.community', [$this->author->username, $this->model->slug])
            ));
        }
    }

    #[Layout('components.layouts.app')]
    public function render()
    {
        $comments = $this->model->comments()
        ->whereNull('parent_id') // التعليقات الرئيسية فقط
        ->with([
            'user',
            'likes',
            // هنا التغيير المهم: نجلب الردود ونحسب لايكاتها لنستطيع الترتيب
            'replies' => function($q) {
                $q->with(['user', 'likes'])->withCount('likes');
            }
        ])
        ->withCount('likes') // عدد لايكات التعليق الرئيسي
        ->when($this->search, fn($q) => $q->where('content', 'like', '%' . $this->search . '%'))
        ->get();

    // 2. منطق الترتيب (للتعليقات الرئيسية + الردود الداخلية)
    foreach ($comments as $comment) {
        if ($this->sort === 'popular') {
            // ترتيب الردود حسب الأكثر إعجاباً
            $sortedReplies = $comment->replies->sortByDesc('likes_count');
            $comment->setRelation('replies', $sortedReplies);
        } else {
            // ترتيب الردود حسب الأحدث
            $sortedReplies = $comment->replies->sortByDesc('created_at');
            $comment->setRelation('replies', $sortedReplies);
        }
    }

    // 3. ترتيب التعليقات الرئيسية نفسها
    if ($this->sort === 'popular') {
        $comments = $comments->sortByDesc('likes_count');
    } else {
        $comments = $comments->sortByDesc('created_at');
    }

        return view('livewire.models.model-community', ['comments' => $comments]);
    }
}
