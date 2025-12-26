<?php

namespace App\Livewire\Dashboard\Projects;

use App\Models\FileHistory;
use App\Models\ProjectFile;
use App\Models\Project;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.dashboard')]
class ViewFile extends Component
{
    public Project $project;
    public ProjectFile $file;
    public $content;
    public $editingContent;
    public $lines = [];
    public $mode = 'preview'; // code, blame, diff
    public $isEditing = false;

    public $historyIdToRestore = null; // لتخزين رقم النسخة المراد استعادتها مؤقتاً
public $restoreModalMessage = '';  // رسالة التأكيد

    // متغير لتخزين نتيجة المقارنة
    public $diffLines = [];

public $fileType = 'text'; // text, image, video, audio, pdf, binary
    public $fileUrl; // رابط الملف للعرض

    public function mount(Project $project, ProjectFile $file)
    {
        $this->project = $project;
        $this->file = $file;
        if ($file->project_id !== $project->id) abort(404);

        // 1. تحديد نوع الملف ورابطه
        $this->detectFileType();
        $this->fileUrl = Storage::disk('wasabi')->url($this->file->path);

        // 2. تحميل المحتوى فقط إذا كان ملف نصي
        if ($this->fileType === 'text') {
            $this->loadFileContent();
            $this->mode = 'code'; // الافتراضي للكود
        } else {
            $this->mode = 'preview'; // الافتراضي للوسائط
        }
    }

    // دالة لتحديد نوع الملف بناءً على الامتداد والـ MIME
    public function detectFileType()
    {
        $mime = Storage::disk('wasabi')->mimeType($this->file->path);
        $ext = strtolower($this->file->extension);

        if (str_starts_with($mime, 'image/')) {
            $this->fileType = 'image';
        } elseif (str_starts_with($mime, 'video/')) {
            $this->fileType = 'video';
        } elseif (str_starts_with($mime, 'audio/')) {
            $this->fileType = 'audio';
        } elseif ($ext === 'pdf') {
            $this->fileType = 'pdf';
        } elseif (in_array($ext, ['php', 'js', 'css', 'html', 'py', 'java', 'c', 'cpp', 'sql', 'json', 'xml', 'md', 'txt', 'env', 'gitignore'])) {
            $this->fileType = 'text';
        } else {
            // محاولة أخيرة: هل هو ملف نصي؟
            // إذا كان حجمه صغير نحاول قراءة أول جزء
            if ($this->file->size < 2000000 && mb_check_encoding(file_get_contents($this->file->getRealPath() ?? Storage::disk('wasabi')->path($this->file->path)), 'UTF-8')) {
                 $this->fileType = 'text';
            } else {
                 $this->fileType = 'binary'; // ملفات مضغوطة، exe، الخ
            }
        }
    }

    public function loadFileContent()
    {
        // حماية إضافية: لا تقرأ إلا النصوص
        if ($this->fileType !== 'text') return;

        if (Storage::disk('wasabi')->exists($this->file->path)) {
            $this->content = Storage::disk('wasabi')->get($this->file->path);
            $this->lines = explode("\n", $this->content);
        }
    }

    // دالة التبديل بين الأوضاع
    public function setMode($mode)
    {
        $this->mode = $mode;
        $this->isEditing = false;

        // إذا اختار المستخدم وضع الفروقات، نحسب الفرق
        if ($mode === 'diff') {
            $this->calculateDiff();
        }
    }

    // دالة حساب الفروقات (Diff Algorithm)
    public function calculateDiff()
    {
        // 1. المحتوى الحالي (الجديد)
        $currentContent = explode("\n", $this->content);

        // 2. المحتوى السابق (من السجل القبل الأخير)
        // نأخذ آخر تعديل، وإذا لم يوجد نعتبر الملف فارغاً في السابق
        $lastHistory = $this->file->history()->latest()->skip(1)->first(); // تخطينا 1 لأننا نبي نقارن بالحالة "قبل" الأخيرة

        // ملاحظة: إذا أردت مقارنة "آخر نسخة محفوظة" مع "ما قبلها"، نستخدم logic مختلف.
        // هنا سنقارن (الملف الحالي في السيرفر) مع (آخر نسخة مسجلة في History)

        $oldContentString = $lastHistory ? $lastHistory->content : '';
        // إذا لم يوجد سجل سابق، نعتبر القديم فارغاً (يعني كل الملف جديد)

        $oldContent = explode("\n", $oldContentString);

        // خوارزمية مقارنة بسيطة (Line-by-Line Diff)
        $this->diffLines = $this->computeDiff($oldContent, $currentContent);
    }

    // خوارزمية Diff بسيطة (LCS implementation simplified)
    private function computeDiff($old, $new)
    {
        $matrix = [];
        $maxlen = 0;
        $omax = 0;
        $nmax = 0;

        // هذه طريقة مبسطة جداً للمقارنة سطر بسطر (ليست دقيقة 100% مثل Git لكنها تفي بالغرض للعرض)
        // للحصول على دقة Git نحتاج مكتبة مثل "sebastian/diff"
        // سأستخدم هنا منطق بسيط للعرض المباشر:

        $diff = [];
        $o = 0; // مؤشر القديم
        $n = 0; // مؤشر الجديد

        while($o < count($old) || $n < count($new)) {
            $oldLine = $old[$o] ?? null;
            $newLine = $new[$n] ?? null;

            if ($oldLine === $newLine) {
                // سطر متطابق
                $diff[] = ['type' => 'same', 'content' => $oldLine, 'line_n' => $n + 1];
                $o++; $n++;
            } elseif ($oldLine !== null && in_array($oldLine, array_slice($new, $n, 5))) {
                // السطر القديم موجود لاحقاً في الجديد (يعني تم إدخال أسطر جديدة قبله)
                $diff[] = ['type' => 'add', 'content' => $newLine, 'line_n' => $n + 1];
                $n++;
            } elseif ($newLine !== null && in_array($newLine, array_slice($old, $o, 5))) {
                 // السطر الجديد موجود لاحقاً في القديم (يعني تم حذف الأسطر الحالية)
                 $diff[] = ['type' => 'remove', 'content' => $oldLine, 'line_o' => $o + 1];
                 $o++;
            } else {
                // اختلاف تام (تعديل)
                if($oldLine !== null) {
                    $diff[] = ['type' => 'remove', 'content' => $oldLine, 'line_o' => $o + 1];
                    $o++;
                }
                if($newLine !== null) {
                    $diff[] = ['type' => 'add', 'content' => $newLine, 'line_n' => $n + 1];
                    $n++;
                }
            }
        }
        return $diff;
    }

public function restoreVersion($historyId)
    {
        // 1. التحقق من الصلاحيات
        if(Auth::id() !== $this->project->user_id) abort(403);

        // 2. جلب النسخة
        $history = FileHistory::findOrFail($historyId);

        // التحقق أن السجل يتبع نفس الملف
        if($history->project_file_id !== $this->file->id) abort(404);

        // === [بداية الإصلاح] ===
        // التحقق مما إذا كانت النسخة تحتوي على محتوى فعلي أم أنها نسخة قديمة فارغة
        if (is_null($history->content)) {
            $this->dispatch('notify',
                type: 'error',
                title: 'غير متاح',
                message: 'عذراً، هذه النسخة قديمة جداً ولا تحتوي على نسخة احتياطية من الكود.'
            );

            // إغلاق المودال إذا كان مفتوحاً
            $this->dispatch('close-delete-modal-restore');
            return;
        }
        // === [نهاية الإصلاح] ===

        // 3. استعادة المحتوى (الكتابة فوق الملف الحالي)
        // الآن نحن متأكدون أن $history->content ليس null
        Storage::disk('wasabi')->put($this->file->path, $history->content);

        // 4. تسجيل عملية الاستعادة
        FileHistory::create([
            'project_file_id' => $this->file->id,
            'user_id' => Auth::id(),
            'commit_message' => "استعادة نسخة بتاريخ " . $history->created_at->format('Y-m-d H:i'),
            'ip_address' => request()->ip(),
            'content' => $history->content
        ]);

        // 5. تحديث العرض
        $this->loadFileContent();
        $this->setMode('code');

        $this->dispatch('notify',
            type: 'success',
            title: 'تمت الاستعادة',
            message: 'تم استرجاع النسخة السابقة بنجاح.'
        );
    }

public function editMode()
    {
        if ($this->fileType !== 'text') {
             $this->dispatch('notify', type: 'error', title: 'غير مدعوم', message: 'لا يمكن تعديل هذا النوع من الملفات داخل المتصفح.');
             return;
        }

        if(Auth::id() !== $this->project->user_id) abort(403);
        $this->editingContent = $this->content;
        $this->isEditing = true;
        $this->mode = 'code';
    }

    public function cancelEdit()
    {
        $this->isEditing = false;
        $this->editingContent = null;
    }
    public function confirmRestore($historyId)
{
    $this->historyIdToRestore = $historyId;
    $this->restoreModalMessage = "هل أنت متأكد تماماً من استعادة هذه النسخة؟\n\nسيتم استبدال محتوى الملف الحالي بمحتوى هذه النسخة المؤرشفة.";

    // نفتح المودال باستخدام ID فريد (مثلاً 'restore')
    $this->dispatch('open-delete-modal-restore');
}

// 2. دالة التنفيذ الفعلي (يستدعيها زر "نعم" في المودال)
public function restoreVersionConfirmed()
{
    if ($this->historyIdToRestore) {
        // نستدعي دالة الاستعادة الأصلية
        $this->restoreVersion($this->historyIdToRestore);

        // نصفر المتغيرات ونغلق المودال
        $this->historyIdToRestore = null;
        $this->dispatch('close-delete-modal-restore');
    }
}
    public function save()
    {
        if(Auth::id() !== $this->project->user_id) abort(403);

        Storage::disk('wasabi')->put($this->file->path, $this->editingContent);

        // ✅ حفظ المحتوى في السجل
        FileHistory::create([
            'project_file_id' => $this->file->id,
            'user_id' => Auth::id(),
            'commit_message' => 'تحديث الملف',
            'ip_address' => request()->ip(),
            'content' => $this->editingContent // تخزين المحتوى
        ]);

        $this->loadFileContent();
        $this->isEditing = false;

        $this->dispatch('notify', type: 'success', title: 'تم الحفظ', message: 'تم تحديث الملف.');
    }

    public function render()
    {
        return view('livewire.dashboard.projects.view-file');
    }
}
