<?php

namespace App\Livewire\Games;

use App\Models\Game;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Url; // ميزة مهمة لحفظ الفلتر في الرابط

class Index extends Component
{
    use WithPagination;

    #[Url] // يحفظ البحث في الرابط
    public $search = '';

    #[Url] // يحفظ الفلتر في الرابط
    public $filter = 'all'; // القيم: all, upload, html5, quiz

    // دالة تلقائية تعمل عند تغيير البحث لتعيدنا للصفحة الأولى
    public function updatingSearch()
    {
        $this->resetPage();
    }

    // دالة تعمل عند تغيير الفلتر
    public function updatingFilter()
    {
        $this->resetPage();
    }

    public function render()
    {
        $games = Game::query()
            // 1. شرط النشر (تعديل الاسم ليطابق قاعدة البيانات)
            ->where('is_published', true)

            // 2. منطق البحث (في العنوان والوصف)
            ->when($this->search, function($q) {
                $q->where('title', 'like', '%' . $this->search . '%')
                  ->orWhere('description', 'like', '%' . $this->search . '%');
            })

            // 3. منطق الفلترة حسب الأنواع الجديدة
            ->when($this->filter !== 'all', function($q) {
                $q->where('type', $this->filter);
            })

            // 4. تحسين الأداء (Eager Loading) لجلب اسم المطور
            ->with('developer') 

            ->latest()
            ->paginate(12);

        return view('livewire.games.index', [
            'games' => $games
        ]);
    }

    // دالة مساعدة للأزرار (إذا كنت تستخدم أزرار بدل القائمة المنسدلة)
    public function setFilter($type)
    {
        $this->filter = $type;
        // لا نحتاج لـ resetPage هنا لأن updatingFilter ستعمل تلقائياً عند تغيير القيمة
    }
}