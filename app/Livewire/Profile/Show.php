<?php

namespace App\Livewire\Profile;

use App\Models\User;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Url;

// استخدم الـ layout هنا في الكومبوننت الرئيسي فقط
#[Layout('components.layouts.profile', ['user' => 'user', 'activeTab' => 'activeTab'])]
class Show extends Component
{
    public User $user;

    #[Url]
    public $activeTab = 'overview';

    public function mount($username)
    {
        $this->user = User::where('username', $username)->firstOrFail();
    }

    public function switchTab($tab)
    {
        $this->activeTab = $tab;
    }

    public function render()
    {
        return view('livewire.profile.show');
    }
}
