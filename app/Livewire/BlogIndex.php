<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Post;

class BlogIndex extends Component
{
    public $category = 'الكل';

    public function setCategory($cat)
    {
        $this->category = $cat;
    }

public function render()
{
    $posts = Post::where('is_published', true)
        ->when($this->category !== 'الكل', function($query) {
            return $query->where('category', $this->category);
        })
        ->latest()
        ->get();

    return view('livewire.blog-index', [
        'posts' => $posts,
        'categories' => ['الكل', 'أخبار', 'تقنية', 'دروس', 'بيانات']
    ]);
}
}
