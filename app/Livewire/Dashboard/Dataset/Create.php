<?php

namespace App\Livewire\Dashboard\Dataset;

use App\Models\Dataset;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http; // تم إضافة هذا السطر

#[Layout('components.layouts.dashboard')]
#[Title('رفع بيانات جديدة | Oneurai')]
class Create extends Component
{
    use WithFileUploads;

    // خصائص النموذج
    public $title;
    public $slug;
    public $description;

    // القيم الافتراضية بناءً على التصميم
    public $task_type = 'Text Classification';
    public $license = 'MIT License';
    public $language = 'العربية (MSA)';
    public $visibility = 'public';

    // الملف المرفق
    public $datasetFile;

    // قواعد التحقق
    protected function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:datasets,slug',
            'description' => 'nullable|string|max:5000',
            'task_type' => 'required|string',
            'license' => 'required|string',
            'visibility' => 'required|in:public,private',
            'datasetFile' => 'required|file|max:102400', // الحد الأقصى 100MB
        ];
    }

    // توليد Slug تلقائياً عند كتابة العنوان
    public function updatedTitle($value)
    {
        $this->slug = Str::slug($value);
    }

    public function save()
    {
        $this->validate(); // التحقق من البيانات

        // =================================================
        // 1. التحقق من الاسم (Name Validation) عبر VPS
        // =================================================
        try {
            $nameResponse = Http::timeout(5)->post('http://77.83.242.109:6000/validate', [
                'name' => $this->title,
            ]);

            if (!$nameResponse->ok() || !isset($nameResponse['status'])) {
                $this->dispatch('notify',
                    type: 'error',
                    title: 'خطأ',
                    message: 'رد غير صالح من خدمة فحص الأسماء.'
                );
                return;
            }

            if ($nameResponse['status'] === 'blocked') {
                $reason = $nameResponse['reasons'][0]['description'] ?? 'اسم غير مناسب.';
                $this->dispatch('notify',
                    type: 'error',
                    title: 'اسم مرفوض',
                    message: $reason
                );
                return;
            }

        } catch (\Exception $e) {
            $this->dispatch('notify',
                type: 'error',
                title: 'خطأ اتصال',
                message: 'تعذر الاتصال بخدمة فحص الأسماء.'
            );
            return;
        }

        // =================================================
        // 2. فحص الملف (File Scanning) عبر VPS
        // =================================================
        try {
            $scanResponse = Http::timeout(60) // وقت انتظار أطول للملفات الكبيرة
                ->attach(
                    'file',
                    file_get_contents($this->datasetFile->getRealPath()),
                    $this->datasetFile->getClientOriginalName()
                )->post('http://77.83.242.109:5000/scan');

            $scan = $scanResponse->json();

        } catch (\Exception $e) {
            $this->dispatch('notify',
                type: 'error',
                title: 'تعذر الرفع',
                message: "فشل الاتصال بخدمة فحص الملفات."
            );
            return;
        }

        if (!$scanResponse->ok() || !isset($scan['status'])) {
            $this->dispatch('notify',
                type: 'error',
                title: 'خطأ',
                message: 'رد غير صالح من خدمة فحص الملفات.'
            );
            return;
        }

        // أ) الملف ضار
        if ($scan['status'] === 'blocked') {
            $reasonText = "تم رفض الملف لاحتوائه على كود ضار.";
            if (!empty($scan['reasons'])) {
                $first = $scan['reasons'][0];
                $reasonText .= " (" . ($first['description'] ?? '') . ")";
            }

            $this->dispatch('notify',
                type: 'error',
                title: 'تم رفض الملف!',
                message: $reasonText
            );
            return;
        }

        // ب) حالة غير معروفة (اختياري: يمكن منع الرفع أو تحذير فقط)
        if ($scan['status'] !== 'allowed') {
            $this->dispatch('notify',
                type: 'warning',
                title: 'تنبيه',
                message: "حالة غير معروفة للملف، يرجى المحاولة لاحقاً."
            );
            return;
        }

        // =================================================
        // بداية كود الحفظ الأصلي (لم يتم حذفه)
        // =================================================

        // 1. إنشاء الداتا سيت أولاً
        $dataset = Dataset::create([
            'user_id' => Auth::id(),
            'title' => $this->title,
            'slug' => $this->slug,
            'description' => $this->description,
            'task_type' => $this->task_type,
            'license' => $this->license,
            'visibility' => $this->visibility,
            'files_count' => 1, // نبدأ بملف واحد
            'size_bytes' => $this->datasetFile->getSize(),
        ]);

        // 2. رفع الملف وتخزينه
        $path = $this->datasetFile->store(
            'datasets/' . Auth::id() . '/' . $this->slug,
            'wasabi'
        );

        // 3. إنشاء سجل للملف وربطه بالداتا سيت
        $dataset->files()->create([
            'user_id'  => Auth::id(),
            'filename' => $this->datasetFile->getClientOriginalName(),
            'path'     => $path,
            'size_bytes' => $this->datasetFile->getSize(),
            'extension' => $this->datasetFile->getClientOriginalExtension(),
            'type'     => 'main',
        ]);

        // 4. إشعار وتوجيه
        $this->dispatch('notify', type: 'success', title: 'تم', message: 'تم فحص البيانات ونشرها بنجاح');
        return redirect()->route('dashboard.datasets', $dataset->id);
    }

    public function render()
    {
        return view('livewire.dashboard.dataset.create');
    }
}