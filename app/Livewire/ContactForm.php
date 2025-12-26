<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Ticket;
use Illuminate\Support\Facades\Auth;

class ContactForm extends Component
{
    // الخصائص المرتبطة بالنموذج
    public $name = '';
    public $email = '';
    public $subject = ''; // أضفنا الموضوع كما في المايجريشن
    public $message = '';
    public $priority = 'medium'; // قيمة افتراضية

    // قواعد التحقق
    protected $rules = [
        'name' => 'required|min:3',
        'email' => 'required|email',
        'subject' => 'required|min:5',
        'message' => 'required|min:10',
    ];

    protected $messages = [
        'name.required' => 'الاسم مطلوب لفتح التذكرة.',
        'email.required' => 'البريد الإلكتروني ضروري للتواصل.',
        'subject.required' => 'يرجى تحديد عنوان للمشكلة.',
        'message.required' => 'اشرح لنا تفاصيل مصفوفتك البرمجية.',
    ];

  public function sendTicket()
{
    // التأكد من أن المستخدم مسجل قبل أي شيء
    if (!Auth::check()) {
        return session()->flash('error', 'يجب عليك تسجيل الدخول أولاً.');
    }

    $this->validate();

    Ticket::create([
        'user_id'  => Auth::id(), // حذفنا الـ ?? 1 لضمان الارتباط بالمستخدم الحالي فقط
        'name'     => $this->name,
        'email'    => $this->email,
        'subject'  => $this->subject,
        'priority' => $this->priority,
        'message'  => $this->message,
        'status'   => 'open',
    ]);

    session()->flash('success', 'تم فتح التذكرة بنجاح! فريق الدعم الفني سيعالج مصفوفتك الآن.');

    $this->reset(['name', 'email', 'subject', 'message']);
}

    public function render()
    {
        return view('livewire.contact-form');
    }
}