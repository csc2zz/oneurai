<?php

namespace App\Livewire\Models;

use App\Models\AiModel;
use App\Models\User;
use Livewire\Component;
use Livewire\Attributes\Layout;

class ShowModel extends Component
{
    public AiModel $model;
    public User $author;

    public function mount($username, $slug)
    {
        // ✅ بحث case-insensitive على username
        $this->author = User::whereRaw('LOWER(username) = ?', [strtolower($username)])
            ->firstOrFail();

        // ✅ جلب الملفات مع الموديل (Eager Loading)
        $this->model = AiModel::where('user_id', $this->author->id)
            ->where('slug', $slug)
            ->with('files')
            ->firstOrFail();
    }
    
    public function recordExecution()
{
    // تسجيل العملية فوراً عند الضغط على الزر
    $this->model->stats()->create([
        'platform'   => 'colab', // نحدد أنها تمت من زر الكولاب
        'ip_address' => request()->ip(),
        'executed_at' => now(),
    ]);
}

    /**
     * ✅ الدالة الذكية لاختيار الملف المناسب للتشغيل
     */
    public function getDownloadUrlProperty()
    {
        $files = $this->model->files;

        // 1) الأولوية الأولى: GGUF (أفضل للكولاب مع llama.cpp غالباً)
        $file = $files->first(function ($file) {
            return str_ends_with(strtolower($file->filename), '.gguf');
        });

        // 2) الأولوية الثانية: صيغ الموديلات القياسية الأخرى
        if (!$file) {
            $file = $files->first(function ($file) {
                $ext = strtolower(pathinfo($file->filename, PATHINFO_EXTENSION));
                return in_array($ext, ['safetensors', 'bin', 'pt', 'pth', 'onnx']);
            });
        }

        // 3) (اختياري) إذا ما فيه مودل جاهز، خذ Notebook للكولاب
        if (!$file) {
            $file = $files->first(function ($file) {
                $ext = strtolower(pathinfo($file->filename, PATHINFO_EXTENSION));
                return $ext === 'ipynb';
            });
        }

        // 4) إذا ما لقينا شيء محدد، خذ أي ملف موجود
        if (!$file) {
            $file = $files->first();
        }

        // 5) إذا ما فيه ملفات نهائياً
        if (!$file) {
            return null;
        }

        // 6) توليد رابط التحميل
        return route('api.universal.download', [
            'type'      => 'models',
            'username'  => strtolower($this->author->username), // ✅ مهم
            'repo_name' => $this->model->slug,
            'filename'  => $file->filename,
        ]);
    }

    #[Layout('components.layouts.app')]
    public function render()
    {
$this->hasFile = !empty($this->model->main_file);

if ($this->hasFile) {
    $oneuraiApiUrl = route('api.universal.download', [
        'type' => 'models',
        'username' => $this->model->user->username,
        'repo_name' => $this->model->slug,
        'filename' => $this->model->main_file,
    ]);
    
    $this->colabUrl = "https://colab.research.google.com/...&model_url=" . urlencode($oneuraiApiUrl);
}
        return view('livewire.models.show-model');
    }
}
