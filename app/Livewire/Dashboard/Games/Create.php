<?php

namespace App\Livewire\Dashboard\Games;

use App\Models\Game;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Layout;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

#[Layout('components.layouts.dashboard')]
class Create extends Component
{
    use WithFileUploads;

    // نوع المشروع: upload, html5, quiz
    public $type = 'upload';

    // إعدادات الوقت (للمسابقات)
    public $time_limit = 0; 

    // المتغيرات الأساسية
    public $title, $slug, $description, $price = 0, $version = '1.0.0';
    public $platforms = [];
    public $game_file, $thumbnail, $screenshots = [];

    // متغيرات المسابقة
    public $questions = [['question' => '', 'options' => ['', '', '', ''], 'correct' => 0]];
    public $quiz_file; // لاستيراد ملف JSON

    // توليد الرابط تلقائياً
    public function generateSlug()
    {
        $this->slug = Str::slug($this->title);
    }

    // إضافة سؤال يدوي
    public function addQuestion()
    {
        $this->questions[] = ['question' => '', 'options' => ['', '', '', ''], 'correct' => 0];
    }

    // حذف سؤال
    public function removeQuestion($index)
    {
        unset($this->questions[$index]);
        $this->questions = array_values($this->questions);
    }

    // دالة معالجة ملف JSON تلقائياً عند الرفع
    public function updatedQuizFile()
    {
        $this->validate([
            'quiz_file' => 'file|mimes:json,txt|max:1024', // أقصى حجم 1MB
        ]);

        try {
            $content = File::get($this->quiz_file->getRealPath());
            $data = json_decode($content, true);

            if (is_array($data) && count($data) > 0 && isset($data[0]['question'])) {
                $this->questions = $data;
                session()->flash('success_file', 'تم استيراد ' . count($data) . ' سؤال بنجاح! ✅');
            } else {
                $this->addError('quiz_file', 'صيغة الملف غير صحيحة. تأكد من تطابق الهيكل المطلوب.');
            }
        } catch (\Exception $e) {
            $this->addError('quiz_file', 'حدث خطأ أثناء قراءة الملف: ' . $e->getMessage());
        }
    }

    public function save()
    {
        // 1. قواعد التحقق العامة
        $rules = [
            'title'       => 'required|string|max:255',
            'slug'        => 'required|unique:games,slug',
            'description' => 'required',
            'thumbnail'   => 'required|image|max:2048',
            'type'        => 'required|in:upload,quiz,html5',
        ];

        // 2. قواعد التحقق حسب النوع
        if ($this->type === 'upload') {
            $rules['game_file'] = 'required|file|mimes:zip,rar,exe,apk,dmg|max:1024000'; // 1GB
            $rules['platforms'] = 'required|array|min:1';
        } 
        elseif ($this->type === 'html5') {
            $rules['game_file'] = 'required|file|mimes:zip|max:512000'; // 500MB
        } 
        elseif ($this->type === 'quiz') {
            $rules['questions'] = 'required|array|min:1';
            $rules['time_limit'] = 'required|integer|min:0|max:300'; // التحقق من الوقت
        }

        $this->validate($rules);

        // 3. رفع الملفات
        $thumbnailPath = $this->thumbnail->store('games/thumbnails', 'public');
        
        $gameFilePath = null;
        if ($this->type === 'upload' || $this->type === 'html5') {
            $gameFilePath = $this->game_file->store('games/builds', 'public');
        }

        $screenshotsPaths = [];
        if ($this->screenshots) {
            foreach ($this->screenshots as $photo) {
                $screenshotsPaths[] = $photo->store('games/screenshots', 'public');
            }
        }

        // تحديد المنصات (الويب للمسابقات وHTML5)
        $finalPlatforms = ($this->type === 'html5' || $this->type === 'quiz') ? ['web'] : $this->platforms;

        // 4. الحفظ في قاعدة البيانات
        Game::create([
            'user_id'      => Auth::id(),
            'type'         => $this->type,
            'title'        => $this->title,
            'slug'         => $this->slug,
            'description'  => $this->description,
            'price'        => $this->price,
            'version'      => $this->version,
            'time_limit'   => ($this->type === 'quiz') ? $this->time_limit : 0, // حفظ الوقت
            'platforms'    => $finalPlatforms,
            'game_file'    => $gameFilePath,
            'thumbnail'    => $thumbnailPath,
            'screenshots'  => $screenshotsPaths,
            'quiz_data'    => ($this->type === 'quiz') ? $this->questions : null,
            'is_published' => true,
        ]);

        session()->flash('success', 'تم نشر المشروع بنجاح! 🚀');
        
        // التأكد من صحة الرابط (index وليس games فقط)
        return redirect()->route('dashboard.games');
    }

    public function render()
    {
        return view('livewire.dashboard.games.create');
    }
}