<?php

namespace App\Livewire\Profile;

use App\Models\User;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.app')]
class OverviewTab extends Component
{
    public User $user;
    public $pinnedProjects = [];

    public function mount($username)
    {
        $this->user = User::where('username', $username)->firstOrFail();
        $this->loadPinnedProjects();
    }

    private function loadPinnedProjects()
    {
        $this->pinnedProjects = $this->user->projects()
            ->where('is_public', true)
            ->latest()
            ->take(4)
            ->get();
    }

    /**
     * دالة لجلب بيانات المساهمات وتنسيقها للرسم البياني
     * (Computed Property)
     * يتم استدعاؤها في الـ Blade عبر $this->contributions
     */
    public function getContributionsProperty()
    {
        // تأكد من أن العلاقة contributions() موجودة في مودل User
        return $this->user->contributions()
            ->where('created_at', '>=', now()->subDays(365)) // آخر سنة
            ->selectRaw('DATE(created_at) as date, count(*) as count')
            ->groupBy('date')
            ->pluck('count', 'date')
            ->toArray();
    }

    public function render()
    {
        return view('livewire.profile.overview-tab', [
            // نمرر البيانات للواجهة باسم 'contributionList' أو نستخدم $this->contributions مباشرة
            'contributionList' => $this->contributions
        ]);
    }
}
