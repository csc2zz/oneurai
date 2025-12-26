<?php

namespace App\Livewire\Models;

use Livewire\Component;
use App\Models\AiModel;
use Carbon\Carbon;

class ModelStatsCard extends Component
{
    public AiModel $model;

    // ✅ هذه الدالة تضمن تهيئة المتغير فور استدعاء المكون
    public function mount(AiModel $model)
    {
        $this->model = $model;
    }

    public function render()
    {
        // الآن السطر 17 سيعمل بأمان لأن $model أصبحت جاهزة
        $total = $this->model->stats()->count();

        $today = $this->model->stats()
            ->where('executed_at', '>=', Carbon::today())
            ->count();

        $yesterday = $this->model->stats()
            ->whereDate('executed_at', Carbon::yesterday())
            ->count();
            
        $growth = $yesterday > 0 ? (($today - $yesterday) / $yesterday) * 100 : ($today * 100);

        return view('livewire.models.model-stats-card', [
            'total' => $total,
            'today' => $today,
            'growth' => round($growth, 1)
        ]);
    }
}