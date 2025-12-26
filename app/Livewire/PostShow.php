<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Post;

class PostShow extends Component
{
    public $post;
    public $newComment = '';

public function toggleLike()
{
    if (!auth()->check()) return redirect()->route('login');

    $like = $this->post->likes()->where('user_id', auth()->id())->first();
    
    if ($like) {
        $like->delete();
    } else {
        $this->post->likes()->create(['user_id' => auth()->id()]);
    }
    
    $this->post->refresh(); // لتحديث العداد في الواجهة
}

public function addComment()
{
    $this->validate(['newComment' => 'required|min:3']);
    
    $this->post->comments()->create([
        'user_id' => auth()->id(),
        'body' => $this->newComment
    ]);

    $this->newComment = '';
    $this->post->refresh();
}

public function mount($slug)
{
    $this->post = Post::where('slug', $slug)
        ->where('is_published', true)
        ->firstOrFail();

    // منطق لمنع زيادة المشاهدة عند كل تحديث (Refresh)
    $sessionKey = 'post_viewed_' . $this->post->id;

    if (!session()->has($sessionKey)) {
        $this->post->increment('views'); // زيادة العداد بمقدار 1
        session()->put($sessionKey, true); // حفظ الحالة في الجلسة
    }
}

    public function render()
    {
        return view('livewire.post-show')->layout('components.layouts.app');
    }
}