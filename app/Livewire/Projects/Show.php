<?php

namespace App\Livewire\Projects;

use App\Models\Project;
use App\Models\ProjectFile;
use App\Models\Issue;
use App\Models\User;
use Livewire\WithPagination;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

#[Layout('components.layouts.app')]
class Show extends Component
{
    use WithPagination;

    public $username;
    public $slug;

    public Project $project;
    public User $projectOwner;

    // متغيرات التصفح
    public $currentPath = '';

    // حالة التبويبات
    public $activeTab = 'code';
    public $readmeContent = null;

    // ============ تصحيح المتغيرات هنا ============
    public $searchIssues = '';
    public $issueStatus = 'open'; // تم تغيير الاسم من issueFilter إلى issueStatus
    // ===========================================

    // متغيرات نموذج الإعدادات
    public $settingsName;
    public $settingsDescription;

    public $showNewIssueModal = false; // للتحكم في ظهور النافذة
public $newIssueTitle = '';
public $newIssueDescription = '';

public $selectedIssue = null; // المشكلة المختارة حالياً
public $newCommentBody = ''; // نص الرد الجديد

// 2. قواعد التحقق
protected $rules = [
    'newIssueTitle' => 'required|min:3|max:255',
    'newIssueDescription' => 'nullable|string',
];

    public function mount($username, $slug)
    {
        $this->username = $username;
        $this->slug = $slug;

        $this->projectOwner = User::where('username', $username)->firstOrFail();

        // 2. جلب المشروع مع الملفات (مهم جداً للمتصفح)
        $this->project = $this->projectOwner->projects()
            ->where('slug', $slug)
            ->with(['files']) // تم إعادتها ليعمل المتصفح بسرعة
            ->firstOrFail();

        $this->settingsName = $this->project->slug;
        $this->settingsDescription = $this->project->description;

        $this->checkAccess();

        if ($this->project->readme_content) {
            $this->readmeContent = Str::markdown($this->project->readme_content);
        }
    }

    public function viewIssue($issueId)
{
    $this->selectedIssue = Issue::with(['comments.user', 'author'])->find($issueId);
}

// دالة للعودة للقائمة
public function backToIssues()
{
    $this->selectedIssue = null;
    $this->newCommentBody = '';
}

// دالة إضافة رد
public function postComment()
{
    $this->validate(['newCommentBody' => 'required|min:2']);

    if (!Auth::check()) return redirect()->route('login');

    $this->selectedIssue->comments()->create([
        'user_id' => Auth::id(),
        'body' => $this->newCommentBody
    ]);

    $this->newCommentBody = '';
    $this->selectedIssue->refresh(); // تحديث البيانات

    $this->dispatch('notify', type: 'success', message: 'تم إضافة الرد بنجاح');
}

// دالة إغلاق/فتح المشكلة (Toggle)
public function toggleIssueStatus()
{
    // التحقق: فقط صاحب المشروع أو صاحب المشكلة يقدر يقفلها
    if (Auth::id() !== $this->project->user_id && Auth::id() !== $this->selectedIssue->user_id) {
        return $this->dispatch('notify', type: 'error', message: 'غير مصرح لك بذلك');
    }

    $newStatus = $this->selectedIssue->status === 'open' ? 'closed' : 'open';

    $this->selectedIssue->update([
        'status' => $newStatus,
        'closed_at' => $newStatus === 'closed' ? now() : null,
        'closed_by' => $newStatus === 'closed' ? Auth::id() : null,
    ]);

    $msg = $newStatus === 'closed' ? 'تم إغلاق المشكلة وحلها' : 'تم إعادة فتح المشكلة';
    $this->dispatch('notify', type: 'success', message: $msg);
}

    public function createIssue()
{
    // التحقق من تسجيل الدخول
    if (!Auth::check()) {
        return redirect()->route('login');
    }

    $this->validate();

    // إنشاء المشكلة
    $issue = Issue::create([
        'project_id' => $this->project->id,
        'user_id' => Auth::id(),
        'title' => $this->newIssueTitle,
        'description' => $this->newIssueDescription,
        'status' => 'open',
    ]);

    // إعادة تعيين الحقول وإغلاق النافذة
    $this->reset(['newIssueTitle', 'newIssueDescription', 'showNewIssueModal']);

    // إرسال إشعار نجاح
    $this->dispatch('notify', type: 'success', message: 'تم فتح المشكلة بنجاح #'.$issue->id);
}

    protected function checkAccess()
    {
        if (!$this->project->is_public) {
            if (!Auth::check()) {
                abort(404);
            }
            $hasAccess = Auth::id() === $this->project->user_id
                      || $this->project->members()->where('user_id', Auth::id())->exists();

            if (!$hasAccess) {
                abort(404);
            }
        }
    }

    // --- 1. المنطق الحقيقي لمستعرض الملفات ---
    public function getBrowserItemsProperty()
    {
        // تأكد أن المسار يطابق طريقة التخزين لديك
        $basePath = 'projects/' . $this->project->user_id . '/' . $this->project->slug . '/';
        $targetPath = $basePath . ($this->currentPath ? $this->currentPath . '/' : '');

        $items = [];
        $processedFolders = [];

        foreach ($this->project->files as $file) {
            if (str_starts_with($file->path, $targetPath)) {
                $relativePath = substr($file->path, strlen($targetPath));

                if (str_contains($relativePath, '/')) {
                    $folderName = explode('/', $relativePath)[0];
                    if (!in_array($folderName, $processedFolders)) {
                        $items[] = [
                            'type' => 'folder',
                            'name' => $folderName,
                            'path' => ($this->currentPath ? $this->currentPath . '/' : '') . $folderName,
                            'last_modified' => $file->created_at,
                            'size' => '-',
                            'file_id' => null
                        ];
                        $processedFolders[] = $folderName;
                    }
                } else {
                    $items[] = [
                        'type' => 'file',
                        'name' => $file->filename,
                        'path' => null,
                        'file_id' => $file->id,
                        'size' => $file->size_for_humans,
                        'last_modified' => $file->created_at,
                        'extension' => $file->extension,
                    ];
                }
            }
        }

        usort($items, function ($a, $b) {
            if ($a['type'] === $b['type']) {
                return strnatcasecmp($a['name'], $b['name']);
            }
            return $a['type'] === 'folder' ? -1 : 1;
        });

        return $items;
    }

    // --- 2. دوال التنقل ---
    public function navigateTo($path)
    {
        $this->currentPath = $path;
    }

    public function navigateUp()
    {
        if (!$this->currentPath) return;
        $parts = explode('/', $this->currentPath);
        array_pop($parts);
        $this->currentPath = implode('/', $parts);
    }

    public function switchTab($tab)
    {
        $this->activeTab = $tab;
    }

    // --- 3. منطق الإعدادات ---
    public function updateSettings()
    {
        if (Auth::id() !== $this->project->user_id) {
            return $this->dispatch('notify', type: 'error', message: 'ليس لديك صلاحية التعديل.');
        }

        $this->validate([
            'settingsName' => 'required|alpha_dash|max:255',
            'settingsDescription' => 'nullable|string|max:1000',
        ]);

        $this->project->update([
            'slug' => $this->settingsName,
            'description' => $this->settingsDescription,
        ]);

        if ($this->slug !== $this->settingsName) {
            return redirect()->route('projects.show', [$this->username, $this->settingsName]);
        }

        $this->dispatch('notify', type: 'success', message: 'تم تحديث إعدادات المشروع بنجاح.');
    }

    // --- دالة تغيير الفلتر ---
    public function setIssueFilter($status)
    {
        $this->issueStatus = $status; // الآن الاسم صحيح ومتطابق
        $this->resetPage();
    }

    // --- 4. العرض ---
    public function render()
    {
        $issuesList = [];

        if ($this->activeTab === 'issues') {
            $issuesList = Issue::with(['author', 'labels'])
                ->where('project_id', $this->project->id)
                ->where('status', $this->issueStatus) // استخدام المتغير الصحيح
                ->when($this->searchIssues, function($query) {
                    $query->where('title', 'like', '%' . $this->searchIssues . '%');
                })
                ->latest()
                ->paginate(10);
        }

        return view('livewire.projects.show', [
            'issuesList' => $issuesList
        ]);
    }

    public function downloadFile($fileId)
    {
        $file = ProjectFile::findOrFail($fileId);

        if ($file->project_id !== $this->project->id) {
            abort(403);
        }

        if (Storage::disk('s3')->exists($file->path)) {
             return Storage::disk('s3')->download($file->path, $file->filename);
        }

        $this->dispatch('notify', type: 'error', message: 'الملف غير موجود.');
    }

    protected function formatSize($bytes)
    {
        if ($bytes >= 1073741824) return number_format($bytes / 1073741824, 2) . ' GB';
        if ($bytes >= 1048576) return number_format($bytes / 1048576, 2) . ' MB';
        if ($bytes >= 1024) return number_format($bytes / 1024, 2) . ' KB';
        return $bytes . ' bytes';
    }
}
