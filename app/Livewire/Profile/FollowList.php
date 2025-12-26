<?php

namespace App\Livewire\Profile;

use App\Models\User;
use Livewire\Component;
use Livewire\Attributes\On;

class FollowList extends Component
{
    public $isOpen = false;
    public $title = '';
    public $users = [];

    // نستمع للحدث 'open-follow-modal'
    #[On('open-follow-modal')]
    public function openModal($userId, $type)
    {
        $user = User::findOrFail($userId);

        if ($type === 'followers') {
            $this->title = 'المتابعون';
            $this->users = $user->followers()->latest()->get();
        } else {
            $this->title = 'يتابع';
            $this->users = $user->followings()->latest()->get();
        }

        $this->isOpen = true;
    }

    public function closeModal()
    {
        $this->isOpen = false;
        $this->users = []; // تنظيف القائمة
    }

    public function render()
    {
        return view('livewire.profile.follow-list');
    }
}
