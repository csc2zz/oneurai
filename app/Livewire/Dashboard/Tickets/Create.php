<?php

namespace App\Livewire\Dashboard\Tickets;

use Livewire\Component;
use App\Models\Ticket;
use Livewire\WithFileUploads;

class Create extends Component
{
    use WithFileUploads;

    public $subject, $category = 'technical', $priority = 'low', $message, $attachments = [];

    protected $rules = [
        'subject' => 'required|min:5|max:100',
        'category' => 'required',
        'priority' => 'required',
        'message' => 'required|min:10',
    ];

   public function save()
{
    $this->validate();

    Ticket::create([
        'user_id'  => auth()->id(),
        'name'     => auth()->user()->name,  // أضف هذا السطر
        'email'    => auth()->user()->email, // أضف هذا السطر
        'subject'  => $this->subject,
        'category' => $this->category,
        'priority' => $this->priority,
        'message'  => $this->message,
        'status'   => 'open',
    ]);

    session()->flash('success', 'تم إرسال تذكرتك بنجاح!');
    return redirect()->route('dashboard.tickets.show', $ticket->id);
}

    public function render()
    {
        return view('livewire.dashboard.tickets.create')->layout('components.layouts.dashboard');
    }
}
