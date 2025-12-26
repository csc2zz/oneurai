<?php

namespace App\Livewire\Dashboard\Tickets;

use Livewire\Component;
use App\Models\Ticket;

class Index extends Component
{
    public function render()
    {
        return view('livewire.dashboard.tickets.index', [
            'tickets' => Ticket::where('user_id', auth()->id())->latest()->get()
        ])->layout('components.layouts.dashboard');
    }
}