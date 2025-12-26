<?php

namespace App\Livewire\Profile;

use App\Models\User;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Auth;

#[Layout('components.layouts.app')]
class DatasetsTab extends Component
{
    public User $user;
    public $datasets = [];
    public $activeTab = 'datasets'; // لتفعيل التبويب في الهيدر

    public function mount($username)
{
    $this->user = User::where('username', $username)->firstOrFail();

    $this->datasets = $this->user->datasets()
        // تقليل الاستعلامات إذا كنت ستعرض عدد الملفات
        ->withCount('files')
        ->when(Auth::id() !== $this->user->id, function ($query) {
            // تأكد أن العمود في الداتابيز هو visibility والقيمة public
            return $query->where('visibility', 'public');
        })
        ->latest()
        ->get();
}

    public function render()
    {
        return view('livewire.profile.datasets-tab');
    }
}
