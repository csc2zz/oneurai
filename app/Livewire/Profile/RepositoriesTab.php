<?php

namespace App\Livewire\Profile;

use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\WithPagination;

#[Layout('components.layouts.app')]
class RepositoriesTab extends Component
{
    use WithPagination;

    public User $user;
    public $search = '';

    public function mount($username)
    {
        $this->user = User::where('username', $username)->firstOrFail();
    }

    // 🔥 هذه الدالة مهمة جداً: تعيد الترقيم للصفحة 1 عند تغيير نص البحث
    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        // نبدأ الاستعلام
        $query = $this->user->projects(); // تأكد أن لديك علاقة projects() في مودل User

        // 1. فلتر الخصوصية (الأمان أولاً)
        if (!Auth::check() || Auth::id() !== $this->user->id) {
            $query->where('is_public', true);
        }

        // 2. فلتر البحث (محسن)
        if ($this->search) {
            $query->where(function ($q) {
                $q->where('title', 'like', '%' . $this->search . '%')
                  ->orWhere('description', 'like', '%' . $this->search . '%') // البحث في الوصف أيضاً
                  ->orWhere('slug', 'like', '%' . $this->search . '%');       // البحث في الرابط
            });
        }

        return view('livewire.profile.repositories-tab', [
            'projects' => $query->latest()->paginate(9)
        ]);
    }
}
