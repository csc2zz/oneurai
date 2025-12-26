<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class Developers extends Component
{
    use WithPagination;

    public $search = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $developers = User::query()
            ->where('name', 'like', '%' . $this->search . '%')
            ->orWhere('username', 'like', '%' . $this->search . '%')
            ->withCount(['projects', 'models', 'followers']) // 🔥 أضفنا followers هنا
->orderBy('followers_count', 'desc') // ترتيب المطورين حسب الأكثر متابعة
        ->paginate(15); // زدت العدد لأننا صغرنا البطاقات

        return view('livewire.developers', [
            'developers' => $developers
        ])->layout('components.layouts.app');
    }
}
