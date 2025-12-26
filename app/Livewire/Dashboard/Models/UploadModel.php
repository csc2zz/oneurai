<?php

namespace App\Livewire\Dashboard\Models;

use App\Models\AiModel;
use App\Models\ModelFile;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

#[Layout('components.layouts.dashboard')]
#[Title('رفع نموذج جديد | Oneurai')]
class UploadModel extends Component
{
    use WithFileUploads;

    public $model_id;
    public $license = 'Apache 2.0';
    public $visibility = 'public';
    public $task = 'Text Generation';
    public $language = 'Arabic';
    public $framework = 'PyTorch';

    public $modelFiles = [];

    protected $rules = [
        'model_id' => 'required|string|max:255|unique:ai_models,title|regex:/^[a-zA-Z0-9\-_ ]+$/',
        'license' => 'required|string',
        'visibility' => 'required|in:public,private',
        'task' => 'required|string',
        'language' => 'required|string',
        'framework' => 'required|string',
        'modelFiles' => 'required|array|min:1',
        'modelFiles.*' => 'file|max:51200', // 50MB
    ];

    public function save()
    {
        $this->validate();

        // =================================================
        // 1. التحقق من الاسم (Name Validation)
        // =================================================
        try {
            $nameResponse = Http::timeout(5)->post('http://77.83.242.109:6000/validate', [
                'name' => $this->model_id,
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
        // 2. فحص الملفات (File Scanning)
        // =================================================
        foreach ($this->modelFiles as $file) {
            try {
                $scanResponse = Http::timeout(60)
                    ->attach(
                        'file',
                        file_get_contents($file->getRealPath()),
                        $file->getClientOriginalName()
                    )->post('http://77.83.242.109:5000/scan');

                $scan = $scanResponse->json();

            } catch (\Exception $e) {
                $this->dispatch('notify',
                    type: 'error',
                    title: 'تعذر الرفع',
                    message: "تم رفض الملف '{$file->getClientOriginalName()}' لاحتوائه على كود ضار."
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

            // 1) الملف ضار
            if ($scan['status'] === 'blocked') {
                $reasonText = "تم رفض الملف '{$file->getClientOriginalName()}' لاحتوائه على كود ضار.";
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

            // 2) حالة غير معروفة
            if ($scan['status'] !== 'allowed') {
                $this->dispatch('notify',
                    type: 'warning',
                    title: 'تنبيه',
                    message: "حالة غير معروفة للملف '{$file->getClientOriginalName()}'."
                );
                return;
            }
        }

        // =================================================
        // 3. الحفظ في قاعدة البيانات
        // =================================================

        $model = AiModel::create([
            'user_id' => Auth::id(),
            'title' => $this->model_id,
            'slug' => Str::slug($this->model_id),
            'license' => $this->license,
            'is_public' => $this->visibility === 'public',
            'task' => $this->task,
            'language' => $this->language,
            'framework' => $this->framework,
            'description' => 'تم الرفع بواسطة واجهة الويب',
            'file_path' => 'stored_in_files_table', // Dummy value
            'file_size' => 0, // Dummy value
        ]);

foreach ($this->modelFiles as $file) {
    $filename = $file->getClientOriginalName();

    // التعديل هنا: استخدام s3 بدلاً من public
    $path = $file->storeAs(
        'ai-models/' . Auth::user()->username . '/' . $model->slug,
        $filename,
        'wasabi'
    );


    $model->files()->create([
        'filename' => $filename,
        'path' => $path,
        'size' => $file->getSize(),
    ]);
}

        // نستخدم session flash هنا لأننا سنقوم بإعادة التوجيه
        session()->flash('success', 'تم فحص الملفات ورفع النموذج بنجاح!');

        return redirect()->route('dashboard.models');
    }

    public function removeFile($index)
    {
        array_splice($this->modelFiles, $index, 1);
    }

    public function render()
    {
        return view('livewire.dashboard.models.upload-model');
    }
}
