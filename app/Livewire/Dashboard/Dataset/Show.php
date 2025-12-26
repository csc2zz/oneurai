<?php

namespace App\Livewire\Dashboard\Dataset;

use App\Models\Dataset;
use App\Models\DatasetFile; // استدعاء المودل الجديد
use Illuminate\Support\Facades\Auth;
use ZipArchive; // تأكد من استيراد هذا الكلاس في بداية الملف
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url; // <--- 1. استيراد الكلاس

#[Layout('components.layouts.dashboard')]
#[Title('تفاصيل البيانات | Oneurai')]
class Show extends Component
{
    use WithFileUploads;

    public Dataset $dataset;
#[Url(as: 'tab', keep: true)]
    public $activeTab = 'overview';

    // متغيرات التعديل
    public $edit_title;
    public $edit_description;
    public $edit_visibility;
    public $edit_task_type;
    public $edit_license;

    // متغيرات الملفات
public $newFile;

    public function mount($id)
    {
        $this->dataset = Dataset::with('files')->where('id', $id) // جلب الملفات مع الداتا سيت
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $this->edit_title = $this->dataset->title;
        $this->edit_description = $this->dataset->description;
        $this->edit_visibility = $this->dataset->visibility;
        $this->edit_task_type = $this->dataset->task_type;
        $this->edit_license = $this->dataset->license;
    }

    // --- دالة رفع ملفات متعددة ---
public function uploadFiles()
{
    // إعدادات الذاكرة والوقت للملفات الكبيرة
    ini_set('max_execution_time', 3600); 
    ini_set('memory_limit', '2048M');

    // 2. التحقق من الملف الواحد
    $this->validate([
        'newFile' => 'required|file|max:1258291', // 1.2GB
    ]);

    $baseStoragePath = 'datasets/' . Auth::id() . '/' . $this->dataset->slug;
    $file = $this->newFile; // الملف الحالي
    $uploadedCount = 0;

    $extension = strtolower($file->getClientOriginalExtension());

    // === [ السيناريو 1: الملف مضغوط ZIP ] ===
    if ($extension === 'zip') {
        $zip = new ZipArchive;
        if ($zip->open($file->getRealPath()) === TRUE) {
            
            for ($i = 0; $i < $zip->numFiles; $i++) {
                $filename = $zip->getNameIndex($i);
                $fileInfo = $zip->statIndex($i);

                if (substr($filename, -1) === '/') continue; 
                if (str_starts_with($filename, '__MACOSX')) continue;
                if (str_starts_with(basename($filename), '.')) continue;

                $cleanFilename = basename($filename); 
                $path = $baseStoragePath . '/' . $cleanFilename;

                // قراءة ورفع مباشر لـ Wasabi
                $stream = $zip->getStream($filename);
                if ($stream) {
                    $content = stream_get_contents($stream);
                    Storage::disk('wasabi')->put($path, $content);
                    fclose($stream);

                    $this->dataset->files()->create([
                        'user_id' => Auth::id(),
                        'filename' => $cleanFilename,
                        'path' => $path,
                        'extension' => pathinfo($filename, PATHINFO_EXTENSION),
                        'size_bytes' => $fileInfo['size'],
                    ]);

                    $this->dataset->increment('size_bytes', $fileInfo['size']);
                    $this->dataset->increment('files_count');
                    $uploadedCount++;
                }
            }
            $zip->close();
        }
    } 
    // === [ السيناريو 2: ملف عادي مفرد ] ===
    else {
        $path = $file->store($baseStoragePath, 'wasabi');

        $this->dataset->files()->create([
            'user_id' => Auth::id(),
            'filename' => $file->getClientOriginalName(),
            'path' => $path,
            'extension' => $extension,
            'size_bytes' => $file->getSize(),
        ]);

        $this->dataset->increment('size_bytes', $file->getSize());
        $this->dataset->increment('files_count');
        $uploadedCount++;
    }

    // تنظيف المتغير
    $this->reset('newFile');
    $this->dataset->refresh();

    $this->dispatch('notify',
        type: 'success',
        title: 'تمت العملية',
        message: "تم رفع ومعالجة {$uploadedCount} ملف بنجاح."
    );
}
    // --- تحميل ملف ---
    public function downloadFile($fileId)
    {
        $file = DatasetFile::findOrFail($fileId);

        if($file->dataset_id !== $this->dataset->id) abort(403);

        if (Storage::disk('wasabi')->exists($file->path)) {
            return Storage::disk('wasabi')->download($file->path, $file->filename);
        }

        $this->dispatch('notify', type: 'error', title: 'خطأ', message: 'الملف غير موجود.');
    }

    // --- حذف ملف ---
    public function deleteFile($fileId)
    {
        $file = DatasetFile::findOrFail($fileId);
        if($file->dataset_id !== $this->dataset->id) abort(403);

        // حذف من التخزين
        if (Storage::disk('wasabi')->exists($file->path)) {
            Storage::disk('wasabi')->delete($file->path);
        }

        // تحديث الإحصائيات (نقص الحجم والعدد)
        $this->dataset->decrement('size_bytes', $file->size_bytes);
        $this->dataset->decrement('files_count');

        // حذف من القاعدة
        $file->delete();
        $this->dataset->refresh();

        $this->dispatch('notify', type: 'success', title: 'تم الحذف', message: 'تم حذف الملف.');
    }

    // --- تبويب الإعدادات: تحديث البيانات ---
    public function updateDataset()
    {
        $this->validate([
            'edit_title' => 'required|string|max:255',
            'edit_description' => 'nullable|string|max:5000',
            'edit_visibility' => 'required|in:public,private',
        ]);

        $this->dataset->update([
            'title' => $this->edit_title,
            'description' => $this->edit_description,
            'visibility' => $this->edit_visibility,
            'task_type' => $this->edit_task_type,
            'license' => $this->edit_license,
        ]);

        $this->dispatch('notify',
            type: 'success',
            title: 'تم التحديث',
            message: 'تم تحديث معلومات مجموعة البيانات بنجاح.'
        );
    }

    // --- حذف المجموعة بالكامل ---
    public function deleteDataset()
    {
        // حذف الملفات من التخزين (يمكن تطويرها لحذف المجلد بالكامل)
        // Storage::disk('wasabi')->deleteDirectory('datasets/' . Auth::id() . '/' . $this->dataset->slug);

        $this->dataset->delete();

        return redirect()->route('dashboard.datasets');
    }

    public function render()
    {
        return view('livewire.dashboard.dataset.show');
    }
}
