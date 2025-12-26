<?php

namespace App\Livewire\Dashboard\Repos;

use App\Models\Project;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Layout('components.layouts.dashboard')]
#[Title('مستودعاتي | Oneurai')]
class Index extends Component
{
    public $search = '';

    public function render()
    {
        // جلب مستودعات المستخدم الحالي فقط
        $repos = Project::where('user_id', Auth::id())
            ->where('type', 'repo') // نحدد النوع مستودع
            ->where('title', 'like', '%'.$this->search.'%') // للبحث
            ->latest()
            ->get();

        return view('livewire.dashboard.repos.index', [
            'repos' => $repos
        ]);
    }
}
