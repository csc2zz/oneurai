<?php

namespace App\Livewire\Dashboard\Projects;

use App\Models\Project;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http; // تم إضافة هذا السطر
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Layout('components.layouts.dashboard')]
#[Title('مشروع جديد | Oneurai')]
class Create extends Component
{
    // البيانات الأساسية
    public $title = '';
    public $slug = '';
    public $description = '';

    // التصنيف والنوع
    public $type = 'repo';
    public $framework = '';
    public $license = '';
    public $tags = '';

    // الإعدادات
    public $visibility = 'public';
    public $add_readme = false;
    public $add_gitignore = false;
    public $gitignore_template = 'Python';

    public $isAvailable = true;

    // دالة توليد الرابط
    public function generateSlug()
    {
        $this->slug = Str::slug($this->title);
        $this->checkAvailability();
    }

    public function updatedTitle()
    {
        $this->generateSlug();
    }

    public function updatedSlug()
    {
        $this->slug = Str::slug($this->slug);
        $this->checkAvailability();
    }

    protected function checkAvailability()
    {
        if (empty($this->slug)) {
            $this->isAvailable = true;
            return;
        }
        $exists = Project::where('slug', $this->slug)->exists();
        $this->isAvailable = !$exists;
    }

    public function create()
    {
        // 1. التحقق من توفر الاسم محلياً
        $this->checkAvailability();
        if (!$this->isAvailable) {
            $this->addError('slug', 'هذا الاسم محجوز مسبقاً.');
            return;
        }

        // 2. التحقق من صحة البيانات (Laravel Validation)
        $this->validate([
            'title' => 'required|min:2|max:255',
            'slug' => 'required|alpha_dash|unique:projects,slug',
            'type' => 'required|in:repo,model,dataset',
            'visibility' => 'required|in:public,private',
            'framework' => 'nullable|string|max:255',
            'license' => 'nullable|string|max:255',
            'tags' => 'nullable|string',
            'description' => 'nullable|string|max:1000',
        ]);

        // =================================================
        // 3. التحقق من الاسم عبر VPS (إضافة جديدة)
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
        // متابعة عملية الحفظ الأصلية
        // =================================================

        // 4. معالجة محتوى README
        $readmeContent = null;
        if ($this->add_readme) {
            $readmeContent = "# {$this->title}\n\n{$this->description}";
        }

        // 5. 🔥 إصلاح مشكلة JSON (معالجة الوسوم)
        $tagsArray = [];
        if (!empty($this->tags)) {
            $normalizedTags = str_replace('،', ',', $this->tags); // دعم الفاصلة العربية
            $tagsArray = collect(explode(',', $normalizedTags))
                ->map(fn($tag) => trim($tag))
                ->filter()
                ->values()
                ->toArray();
        }

        // 6. إنشاء المشروع
        Auth::user()->projects()->create([
            'title' => $this->title,
            'slug' => $this->slug,
            'description' => $this->description ?: null,
            'type' => $this->type,
            'is_public' => $this->visibility === 'public',
            'framework' => $this->framework ?: null,
            'license' => $this->license ?: null,
            'tags' => $tagsArray, // سيتم تخزينها كـ JSON
            'readme_content' => $readmeContent,
        ]);

        // 7. 🔥 إرسال الإشعار
        $this->dispatch('notify',
            type: 'success',
            title: 'تم الإنشاء بنجاح',
            message: "تم إطلاق مشروعك {$this->title} وأصبح جاهزاً للعمل."
        );

        // 8. التوجيه
        return redirect()->route('dashboard.repos');
    }

    public function render()
    {
        return view('livewire.dashboard.projects.create');
    }
}