<?php

namespace App\Livewire\Models;

use App\Models\AiModel;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Url;

class ModelsIndex extends Component
{
    use WithPagination;

    #[Url(history: true)]
    public $search = '';

    #[Url(history: true)]
    public $task = [];

    #[Url(history: true)]
    public $framework = [];

    #[Url(history: true)]
    public $language = [];

    #[Url(history: true)]
    public $sort = 'popular'; // popular, newest, downloads

    // قوائم الفلاتر الثابتة (يمكنك جعلها ديناميكية لاحقاً)
    public $tasksList = [
        'Text Generation' => 'fa-solid fa-pen-nib',
        'Translation' => 'fa-solid fa-language',
        'Object Detection' => 'fa-solid fa-image',
        'Audio-to-Text' => 'fa-solid fa-microphone',
    ];

    public $frameworksList = ['PyTorch', 'TensorFlow', 'SafeTensors', 'ONNX', 'JAX'];
    public $languagesList = ['Arabic', 'English', 'Multilingual'];

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function setSort($sort)
    {
        $this->sort = $sort;
        $this->resetPage();
    }

    public function clearFilters()
    {
        $this->task = [];
        $this->framework = [];
        $this->language = [];
        $this->search = '';
        $this->resetPage();
    }

    #[Layout('components.layouts.app')]
    public function render()
    {
        $query = AiModel::query()->where('is_public', true);

        // البحث
        if ($this->search) {
            $query->where(function ($q) {
                $q->where('title', 'like', '%' . $this->search . '%')
                  ->orWhere('description', 'like', '%' . $this->search . '%');
            });
        }

        // فلترة المهام
        if (!empty($this->task)) {
            $query->whereIn('task', $this->task);
        }

        // فلترة المكتبات
        if (!empty($this->framework)) {
            $query->whereIn('framework', $this->framework);
        }

        // فلترة اللغات
        if (!empty($this->language)) {
            $query->whereIn('language', $this->language);
        }

        // الترتيب
        switch ($this->sort) {
            case 'newest':
                $query->latest();
                break;
            case 'downloads':
                $query->orderByDesc('downloads_count');
                break;
            case 'popular':
            default:
                $query->orderByDesc('likes_count');
                break;
        }

        return view('livewire.models.models-index', [
            'models' => $query->with('user')->paginate(12),
            'modelsCount' => AiModel::where('is_public', true)->count(),
        ]);
    }
}
