<?php

namespace App\Livewire\Dashboard\Tickets;

use Livewire\Component;
use App\Models\Ticket;

class Show extends Component
{
    public Ticket $ticket;
    public $reply;

    public function mount(Ticket $ticket)
    {
        // التأكد أن المستخدم لا يرى تذاكر غيره
        if ($ticket->user_id !== auth()->id()) {
            abort(403);
        }
        $this->ticket = $ticket;
    }

    public function sendReply()
    {
        $this->validate(['reply' => 'required|min:2']);

        // هنا يمكنك إضافة منطق حفظ الرد في جدول منفصل (TicketReply)
        // أو تحديث الرسالة الأصلية مؤقتاً
        
        $this->reset('reply');
        session()->flash('success', 'تم إرسال ردك!');
    }

    public function render()
    {
        return view('livewire.dashboard.tickets.show')->layout('components.layouts.dashboard');
    }
}
