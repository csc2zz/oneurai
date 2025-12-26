<?php

namespace App\Livewire\Datasets;

use App\Models\Dataset;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;

#[Layout('components.layouts.app')]
#[Title('مجموعات البيانات | Oneurai')]
class Index extends Component
{
    use WithPagination;

    #[Url]
    public $search = '';

    #[Url]
    public $sort = 'trending';

    // ✅ إضافة #[Url] للمصفوفات أمر ضروري لعمل الفلترة وتحديث الرابط
    #[Url]
    public $selected_tasks = [];

    #[Url]
    public $selected_sizes = [];

    #[Url]
    public $selected_licenses = [];

    // القوائم (تستخدم للفلترة فقط)
    public $tasks_list = [
        'Text Classification',
        'Sentiment Analysis',
        'Automatic Speech Recognition',
        'Object Detection',
        'Translation',
        'Image Segmentation'
    ];

    public $licenses_list = [
        'MIT License',
        'Apache 2.0',
        'CC BY-SA 4.0',
        'OpenRAIL'
    ];

    public function updated($property)
    {
        // إعادة التعيين للصفحة الأولى عند أي تغيير في الفلاتر
        if (in_array($property, ['search', 'selected_tasks', 'selected_sizes', 'selected_licenses', 'sort'])) {
            $this->resetPage();
        }
    }

    public function clearFilters()
    {
        $this->reset(['selected_tasks', 'selected_sizes', 'selected_licenses', 'search']);
        $this->resetPage();
    }

    public function render()
    {
        $query = Dataset::where('visibility', 'public')->with('user');

        // 1. البحث
        if (!empty($this->search)) {
            $query->where(function($q) {
                $q->where('title', 'like', '%' . $this->search . '%')
                  ->orWhere('description', 'like', '%' . $this->search . '%');
            });
        }

        // 2. فلتر المهام (Task) - استخدام Like لضمان المطابقة الجزئية
        if (!empty($this->selected_tasks)) {
            $query->where(function($q) {
                foreach ($this->selected_tasks as $task) {
                    // نستخدم like %...% لأن القيمة في الداتا بيس قد تكون "Text Classification (تصنيف نصوص)"
                    $q->orWhere('task_type', 'like', '%' . $task . '%');
                }
            });
        }

        // 3. فلتر الرخص
        if (!empty($this->selected_licenses)) {
            $query->whereIn('license', $this->selected_licenses);
        }

        // 4. فلتر الحجم
        if (!empty($this->selected_sizes)) {
            $query->where(function($q) {
                foreach ($this->selected_sizes as $size) {
                    if ($size === 'small') $q->orWhere('size_bytes', '<', 10485760); // < 10MB
                    if ($size === 'medium') $q->orWhereBetween('size_bytes', [10485760, 1073741824]); // 10MB - 1GB
                    if ($size === 'large') $q->orWhere('size_bytes', '>', 1073741824); // > 1GB
                }
            });
        }

        // 5. الترتيب
        if ($this->sort === 'newest') {
            $query->latest();
        } elseif ($this->sort === 'downloads') {
            $query->orderByDesc('downloads_count');
        } else {
            // Trending
            $query->orderByDesc('downloads_count')->orderByDesc('created_at');
        }

        return view('livewire.datasets.index', [
            'datasets' => $query->paginate(15),
            'total_count' => Dataset::where('visibility', 'public')->count()
        ]);
    }
}
