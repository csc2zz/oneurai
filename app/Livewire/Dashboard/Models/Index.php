<?php

namespace App\Livewire\Dashboard\Models;

use App\Models\AiModel; // <--- تم التعديل لاستخدام المودل الجديد
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Layout('components.layouts.dashboard')]
#[Title('النماذج | Oneurai')]
class Index extends Component
{
    public $search = '';

    public function render()
    {
        // جلب البيانات من جدول ai_models
        $models = AiModel::where('user_id', Auth::id())
            // حذفنا شرط النوع لأنه جدول مستقل
            ->where('title', 'like', '%'.$this->search.'%')
            ->latest()
            ->get();

        return view('livewire.dashboard.models.index', [
            'models' => $models
        ]);
    }
}
