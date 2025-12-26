<?php

namespace App\Livewire\Datasets;

use App\Models\Dataset;
use App\Models\User;
use App\Models\DatasetFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;

#[Layout('components.layouts.app')]
#[Title('مجموعات البيانات | Oneurai')]
class Show extends Component
{
    public Dataset $dataset;
    public User $user;

    // ✅ الحل لمشكلة الانتقال:
    // history: true -> يضيف التغيير لسجل المتصفح (زر الرجوع يعمل)
    // as: 'tab' -> يغير اسم المتغير في الرابط ليكون أنيقاً (?tab=files)
    #[Url(as: 'tab', history: true)]
    public $activeTab = 'card';

    public function mount($username, $slug)
    {
        // جلب المستخدم
        $this->user = User::where('username', $username)->firstOrFail();

        // جلب البيانات (مع التأكد أنها عامة)
        $this->dataset = Dataset::where('user_id', $this->user->id)
            ->where('slug', $slug)
            ->where('visibility', 'public')
            ->with(['files', 'user']) // Eager Loading للأداء
            ->firstOrFail();

        // التحقق من صلاحية التبويب (حماية من الروابط الخاطئة)
        if (!in_array($this->activeTab, ['card', 'files', 'community'])) {
            $this->activeTab = 'card';
        }
    }

    // دالة التبديل (تستخدم في الـ View للتنقل)
    public function switchTab($tab)
    {
        $this->activeTab = $tab;
    }

    // دالة التحميل
    public function downloadFile($fileId)
    {
        $file = DatasetFile::findOrFail($fileId);

        // حماية: التأكد أن الملف يتبع لهذه المجموعة
        if ($file->dataset_id !== $this->dataset->id) abort(404);

        if (Storage::disk('wasabi')->exists($file->path)) {
            // زيادة العداد
            $this->dataset->increment('downloads_count');
            return Storage::disk('wasabi')->download($file->path, $file->filename);
        }

        $this->dispatch('notify', type: 'error', message: 'الملف غير موجود.');
    }

    public function render()
    {
        return view('livewire.datasets.show');
    }
}
