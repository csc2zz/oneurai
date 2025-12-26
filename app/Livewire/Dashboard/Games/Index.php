<?php

namespace App\Livewire\Dashboard\Games;

use App\Models\Game;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

#[Layout('components.layouts.dashboard')]
class Index extends Component
{
    use WithPagination;
    use AuthorizesRequests; // لاستخدام دوال الحماية authorize

    public $search = '';
    public $filter_status = ''; // القيم: '' (الكل), 'published', 'draft'

    // هذه الدوال تعمل تلقائياً عند تغيير البحث أو الفلتر
    // الهدف: إرجاع المستخدم للصفحة رقم 1 عند البحث لتجنب الأخطاء
    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingFilterStatus()
    {
        $this->resetPage();
    }

    // دالة حذف اللعبة
    public function delete($id)
    {
        $game = Game::findOrFail($id);

        // حماية: التأكد أن اللعبة تابعة للمستخدم الحالي
        if ($game->user_id !== Auth::id()) {
            abort(403, 'لا تملك صلاحية حذف هذه اللعبة');
        }

        // حذف الملفات المرتبطة (اختياري: يفضل عملها داخل Model Observer)
        // Storage::disk('public')->delete($game->game_file);
        // Storage::disk('public')->delete($game->thumbnail);

        $game->delete();

        session()->flash('success', 'تم حذف اللعبة بنجاح.');
    }

    public function render()
    {
        $games = Game::query()
            // 1. جلب ألعاب المستخدم الحالي فقط
            ->where('user_id', Auth::id())
            
            // 2. البحث في العنوان
            ->when($this->search, function ($q) {
                $q->where('title', 'like', '%' . $this->search . '%');
            })
            
            // 3. الفلترة حسب الحالة (منشور / مسودة)
            ->when($this->filter_status, function ($q) {
                if ($this->filter_status === 'published') {
                    $q->where('is_published', true);
                } elseif ($this->filter_status === 'draft') {
                    $q->where('is_published', false);
                }
            })
            
            // 4. الترتيب (الأحدث أولاً)
            ->latest()
            
            // 5. التصفح
            ->paginate(9);

        return view('livewire.dashboard.games.index', [
            'games' => $games
        ]);
    }
}