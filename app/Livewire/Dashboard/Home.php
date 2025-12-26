<?php

namespace App\Livewire\Dashboard;

use App\Models\Project;
use App\Models\AiModel;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Layout('components.layouts.dashboard')]
#[Title('لوحة التحكم | Oneurai')]
class Home extends Component
{
    public $stats = [];
    public $pinnedProjects;
    public $trendingProjects;
    public $activities;

    public function mount()
    {
        $user = Auth::user();

        // 1. الإحصائيات الحية (مشاريع + نماذج)
        $reposCount = $user->projects()->count();
        $modelsCount = AiModel::where('user_id', $user->id)->count();

        $this->stats = [
            'total_items' => $reposCount + $modelsCount, // مجموع المساهمات
            'total_stars' => $user->projects()->sum('stars_count'), // النجوم حالياً للمشاريع فقط
            'repos_count' => $reposCount,
            'models_count' => $modelsCount
        ];

        // 2. المشاريع المثبتة (أعلى مشروعين تقييماً)
        $this->pinnedProjects = $user->projects()
            ->orderByDesc('stars_count')
            ->take(2)
            ->get();

        // 3. استكشف (أعلى المشاريع العامة)
        $this->trendingProjects = Project::where('is_public', true)
            ->orderByDesc('stars_count')
            ->take(3)
            ->get();

        // 4. سجل النشاطات (Activities Feed) - الجزء "الحي"
        // ندمج آخر المشاريع والنماذج التي أنشأها المستخدم ونرتبها زمنياً
        $latestRepos = $user->projects()->latest()->take(3)->get()
            ->map(fn($item) => ['type' => 'repo', 'data' => $item, 'created_at' => $item->created_at]);

        $latestModels = AiModel::where('user_id', $user->id)->latest()->take(3)->get()
            ->map(fn($item) => ['type' => 'model', 'data' => $item, 'created_at' => $item->created_at]);

        // دمج وترتيب وتحديد أحدث 5 نشاطات
$this->activities = $latestRepos->toBase()->merge($latestModels)
    ->sortByDesc('created_at')
    ->take(5);
    }

    public function render()
    {
        return view('livewire.dashboard.home');
    }
}
