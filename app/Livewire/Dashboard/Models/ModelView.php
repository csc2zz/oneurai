<?php

namespace App\Livewire\Dashboard\Models;

use App\Models\AiModel;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.dashboard')]
class ModelView extends Component
{
    use WithFileUploads;

    public $model;
    public $username;
    public $slug;

    // إدارة الملفات
    public $newFiles = [];
    public $isUploading = false;

    // إدارة الـ README
    public $readmeContent;
    public $isEditingReadme = false;

    // إدارة الإعدادات (للتعديل)
    public $edit_title;
    public $edit_description;
    public $edit_license;
    public $edit_visibility;
    public $edit_task;

    // التبويب النشط (الافتراضي: بطاقة النموذج)
    public $activeTab = 'readme';

    public function mount($username, $slug)
    {
        $this->username = $username;
        $this->slug = $slug;

        $user = User::where('username', $username)->firstOrFail();

        $this->model = AiModel::where('user_id', $user->id)
            ->where('slug', $slug)
            ->with(['files', 'user'])
            ->firstOrFail();

        if (!$this->model->is_public && Auth::id() !== $this->model->user_id) {
            abort(403);
        }

        // تعبئة البيانات
        $this->readmeContent = $this->model->readme_content; // تأكد من وجود هذا العمود في الجدول

        // تعبئة بيانات التعديل
        $this->edit_title = $this->model->title;
        $this->edit_description = $this->model->description;
        $this->edit_license = $this->model->license;
        $this->edit_visibility = $this->model->is_public ? 'public' : 'private';
        $this->edit_task = $this->model->task;
    }

    // --- دوال الـ README ---
    public function editReadme()
    {
        $this->isEditingReadme = true;
    }

    public function cancelEditReadme()
    {
        $this->readmeContent = $this->model->readme_content;
        $this->isEditingReadme = false;
    }

    public function saveReadme()
    {
        if (Auth::id() !== $this->model->user_id) abort(403);

        $this->validate(['readmeContent' => 'nullable|string']);

        $this->model->update(['readme_content' => $this->readmeContent]); // تأكد أن العمود readme_content موجود في الداتابيز
        $this->model->refresh();
        $this->isEditingReadme = false;

        $this->dispatch('notify', type: 'success', title: 'تم', message: 'تم تحديث بطاقة النموذج.');
    }

    // --- دوال الملفات (كما هي سابقاً) ---
    public function uploadFiles()
{
    // 1. التحقق من الصلاحية
    if (Auth::id() !== $this->model->user_id) abort(403);

    // 2. التحقق من الملفات
    $this->validate(['newFiles.*' => 'required|file|max:51200']); // 50MB Max

    // 3. عملية الرفع والحفظ
    foreach ($this->newFiles as $file) {
        try {
            $filename = $file->getClientOriginalName();

            // رفع الملف إلى Wasabi
            $path = $file->storeAs(
                'ai-models/' . Auth::user()->username . '/' . $this->model->slug,
                $filename,
                'wasabi'
            );

            // حفظ معلومات الملف في قاعدة البيانات
            // تأكد أن العلاقة files() موجودة في موديل المشروع
            $this->model->files()->create([
                'filename' => $filename,
                'path'     => $path,
                'disk'     => 'wasabi', // يفضل حفظ اسم الديسك للمستقبل
                'size'     => $file->getSize(),
            ]);

        } catch (\Exception $e) {
            // في حال فشل رفع ملف واحد، نوقف العملية ونظهر خطأ
            $this->dispatch('notify', type: 'error', title: 'فشل الرفع', message: 'حدث خطأ أثناء رفع: ' . $filename);
            \Log::error("Wasabi Upload Error: " . $e->getMessage()); // تسجيل الخطأ في ملف اللوج
            return;
        }
    }

    // 4. إرسال إشعار النجاح وتنظيف القائمة
    $this->dispatch('notify', type: 'success', title: 'تم', message: 'تم رفع الملفات بنجاح.');
    $this->newFiles = []; // تفريغ مصفوفة الملفات المؤقتة
    $this->model->refresh(); // تحديث الموديل لإظهار الملفات الجديدة في الصفحة
}
    public function deleteFile($fileId)
    {
        // ... (نفس كود الحذف السابق) ...
        if (Auth::id() !== $this->model->user_id) abort(403);
        $file = $this->model->files()->findOrFail($fileId);
        Storage::disk('wasabi')->delete($file->path);
        $file->delete();
        $this->dispatch('notify', type: 'success', title: 'تم', message: 'تم حذف الملف.');
        $this->model->refresh();
    }

    public function downloadFile($fileId)
    {
        // ... (نفس كود التحميل السابق) ...
        $file = $this->model->files()->findOrFail($fileId);
        return Storage::disk('wasabi')->download($file->path, $file->filename);
    }

    // --- دوال الإعدادات ---
    public function updateModelSettings()
    {
        if (Auth::id() !== $this->model->user_id) abort(403);

        $this->validate([
            'edit_title' => 'required|string|max:255',
            'edit_description' => 'nullable|string|max:1000',
            'edit_license' => 'required|string',
            'edit_visibility' => 'required|in:public,private',
            'edit_task' => 'required|string',
        ]);

        $this->model->update([
            'title' => $this->edit_title,
            'description' => $this->edit_description,
            'license' => $this->edit_license,
            'is_public' => $this->edit_visibility === 'public',
            'task' => $this->edit_task,
        ]);

        $this->dispatch('notify', type: 'success', title: 'تم', message: 'تم تحديث إعدادات النموذج.');
    }

    public function deleteModel()
    {
        if (Auth::id() !== $this->model->user_id) abort(403);

        // حذف المجلد بالكامل
        Storage::disk('wasabi')->deleteDirectory('ai-models/' . $this->model->user->username . '/' . $this->model->slug);

        $this->model->delete();

        return redirect()->route('dashboard.models');
    }

    public function render()
    {
        return view('livewire.dashboard.models.model-view')
            ->title($this->model->title . ' | Oneurai');
    }
}
