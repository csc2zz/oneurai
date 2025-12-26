<?php

namespace App\Livewire\Dashboard\Games;

use App\Models\Game;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Layout;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File; // لاستيراد JSON

#[Layout('components.layouts.dashboard')]
class Edit extends Component
{
    use WithFileUploads;

    public Game $game;

    public $type;
    public $title, $slug, $description, $price, $version;
    public $platforms = [];
    
    // متغيرات المسابقة
    public $quiz_data = [];
    public $time_limit = 0; // للمؤقت
    public $quiz_file; // لاستيراد JSON

    // متغيرات للملفات الجديدة (اختيارية عند التعديل)
    public $new_game_file;
    public $new_thumbnail;
    public $new_screenshots = [];

    public function mount(Game $game)
    {
        // التحقق من الملكية
        if ($game->user_id !== Auth::id()) {
            abort(403);
        }

        $this->game = $game;
        
        // تعبئة البيانات من قاعدة البيانات
        $this->type = $game->type;
        $this->title = $game->title;
        $this->slug = $game->slug;
        $this->description = $game->description;
        $this->price = $game->price;
        $this->version = $game->version;
        $this->platforms = $game->platforms ?? [];
        
        // تعبئة بيانات الكويز
        $this->quiz_data = $game->quiz_data ?? [['question' => '', 'options' => ['', '', '', ''], 'correct' => 0]];
        $this->time_limit = $game->time_limit; // جلب الوقت المحفوظ
    }

    public function generateSlug()
    {
        $this->slug = Str::slug($this->title);
    }

    public function addQuestion()
    {
        $this->quiz_data[] = ['question' => '', 'options' => ['', '', '', ''], 'correct' => 0];
    }

    public function removeQuestion($index)
    {
        unset($this->quiz_data[$index]);
        $this->quiz_data = array_values($this->quiz_data);
    }

    // دالة استيراد JSON في صفحة التعديل
    public function updatedQuizFile()
    {
        $this->validate(['quiz_file' => 'file|mimes:json,txt|max:1024']);

        try {
            $content = File::get($this->quiz_file->getRealPath());
            $data = json_decode($content, true);

            if (is_array($data) && count($data) > 0 && isset($data[0]['question'])) {
                // دمج الأسئلة الجديدة مع القديمة أو استبدالها (هنا سنستبدل)
                $this->quiz_data = $data;
                session()->flash('success_file', 'تم تحديث الأسئلة من الملف! ✅');
            } else {
                $this->addError('quiz_file', 'صيغة الملف غير صحيحة.');
            }
        } catch (\Exception $e) {
            $this->addError('quiz_file', 'حدث خطأ: ' . $e->getMessage());
        }
    }

    public function save()
    {
        $rules = [
            'title'       => 'required|string|max:255',
            // تجاهل الـ ID الحالي عند التحقق من الـ Slug
            'slug'        => ['required', Rule::unique('games', 'slug')->ignore($this->game->id)],
            'description' => 'required',
        ];

        if ($this->type === 'quiz') {
            $rules['quiz_data'] = 'required|array|min:1';
            $rules['time_limit'] = 'required|integer|min:0|max:300';
        }

        // التحقق من الملفات الجديدة فقط إذا تم رفعها
        if ($this->new_game_file) {
            $rules['new_game_file'] = 'file|max:1024000';
        }
        if ($this->new_thumbnail) {
            $rules['new_thumbnail'] = 'image|max:2048';
        }

        $this->validate($rules);

        // تحديث الملفات إذا وجدت
        if ($this->new_thumbnail) {
            $this->game->thumbnail = $this->new_thumbnail->store('games/thumbnails', 'public');
        }
        
        if ($this->new_game_file && in_array($this->type, ['upload', 'html5'])) {
            $this->game->game_file = $this->new_game_file->store('games/builds', 'public');
        }

        // تحديث السكرين شوت (إضافة للقديم)
        if ($this->new_screenshots) {
            $currentScreenshots = $this->game->screenshots ?? [];
            foreach ($this->new_screenshots as $photo) {
                $currentScreenshots[] = $photo->store('games/screenshots', 'public');
            }
            $this->game->screenshots = $currentScreenshots;
        }

        $this->game->update([
            'title'       => $this->title,
            'slug'        => $this->slug,
            'description' => $this->description,
            'price'       => $this->price,
            'version'     => $this->version,
            'platforms'   => $this->platforms,
            'time_limit'  => ($this->type === 'quiz') ? $this->time_limit : 0, // تحديث الوقت
            'quiz_data'   => ($this->type === 'quiz') ? $this->quiz_data : null,
        ]);

        session()->flash('success', 'تم حفظ التعديلات بنجاح! ✅');
        return redirect()->route('dashboard.games');
    }

    public function render()
    {
        return view('livewire.dashboard.games.edit');
    }
}