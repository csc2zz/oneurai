<?php

namespace App\Livewire\Dashboard\Help;

use Livewire\Component;

class Index extends Component
{
    public $search = '';

    // مصفوفة الأسئلة (يمكنك نقلها لاحقاً لقاعدة البيانات)
    public function getFaqsProperty()
    {
        $allFaqs = [
            ['q' => 'كيف يمكنني رفع مستودع (Repo) جديد؟', 'a' => 'من القائمة الجانبية اختر "مستودعاتي" ثم اضغط على زر "إنشاء مستودع جديد" وقم بتعبئة البيانات.'],
            ['q' => 'هل منصة Oneurai مجانية للمطورين؟', 'a' => 'نعم، توفر Oneurai خطة مجانية تتيح لك مشاركة الكود البرمجي ورفع المستودعات العامة مجاناً.'],
            ['q' => 'كيف أقوم بتعديل ملفي الشخصي؟', 'a' => 'توجه إلى صفحة "الملف الشخصي" من أسفل السايدبار، حيث يمكنك تغيير صورتك واسم المستخدم.'],
            ['q' => 'ما هي أنواع الملفات المدعومة في نظام التذاكر؟', 'a' => 'نقبل حالياً الصور (JPG, PNG) لتوثيق المشاكل التقنية التي قد تواجهك.'],
        ];

        if (empty($this->search)) {
            return $allFaqs;
        }

        return array_filter($allFaqs, function($faq) {
            return str_contains($faq['q'], $this->search) || str_contains($faq['a'], $this->search);
        });
    }

    public function render()
    {
        return view('livewire.dashboard.help.index', [
            'faqs' => $this->faqs
        ])->layout('components.layouts.dashboard');
    }
}
