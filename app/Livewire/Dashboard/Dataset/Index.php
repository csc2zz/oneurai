<?php

namespace App\Livewire\Dashboard\Dataset;

use App\Models\Dataset;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\WithPagination;

#[Layout('components.layouts.dashboard')]
#[Title('البيانات | Oneurai')]
class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $filter_visibility = 'all';
    public $sort_by = 'latest';

    // لحفظ الإحصائيات
    public $totalCount;
    public $totalDownloads;
    public $totalSizeBytes;

    public function mount()
    {
        // حساب الإحصائيات مرة واحدة عند التحميل
        $userDatasets = Dataset::where('user_id', Auth::id());

        $this->totalCount = $userDatasets->count();
        $this->totalDownloads = $userDatasets->sum('downloads_count');
        $this->totalSizeBytes = $userDatasets->sum('size_bytes');
    }

    // دالة مساعدة لتنسيق الحجم في الإحصائيات العلوية
    public function getFormattedTotalSizeProperty()
    {
        $bytes = $this->totalSizeBytes;
        if ($bytes >= 1073741824) return number_format($bytes / 1073741824, 2) . ' GB';
        if ($bytes >= 1048576) return number_format($bytes / 1048576, 2) . ' MB';
        return number_format($bytes / 1024, 2) . ' KB';
    }

    public function render()
    {
        $query = Dataset::where('user_id', Auth::id());

        if (!empty($this->search)) {
            $query->where('title', 'like', '%' . $this->search . '%');
        }

        if ($this->filter_visibility !== 'all') {
            $query->where('visibility', $this->filter_visibility);
        }

        switch ($this->sort_by) {
            case 'downloads': $query->orderByDesc('downloads_count'); break;
            case 'size': $query->orderByDesc('size_bytes'); break;
            default: $query->latest(); break;
        }

        return view('livewire.dashboard.dataset.index', [
            'datasets' => $query->paginate(12) // تفعيل الـ Pagination
        ]);
    }
}
