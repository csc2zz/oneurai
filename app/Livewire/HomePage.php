<?php

namespace App\Livewire;

use App\Models\Project;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Layout('components.layouts.app')]
#[Title('Oneurai | الرئيسية')]
class HomePage extends Component
{
    // 👇 1. يجب إضافة هذا السطر لتعريف المتغير
    public $trendingProjects;

    public function mount()
    {
        // 2. الآن يمكنك تعبئة المتغير وسيظهر في ملف العرض
        $this->trendingProjects = Project::where('is_public', true)
            ->with('user')
            ->orderByDesc('stars_count')
            ->take(3)
            ->get();
    }

    public function render()
    {
        return view('livewire.home-page');
    }
}
