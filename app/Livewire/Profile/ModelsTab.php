<?php

namespace App\Livewire\Profile;

use App\Models\User;
use App\Models\AiModel; // استيراد الموديل
use Livewire\Component;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Auth;

#[Layout('components.layouts.app')]
class ModelsTab extends Component
{
    public User $user;

    public function mount($username)
    {
        $this->user = User::where('username', $username)->firstOrFail();
    }

    public function render()
    {
        // بدء الاستعلام لجلب النماذج الخاصة بهذا المستخدم
        $query = AiModel::where('user_id', $this->user->id);

        // التحقق من الصلاحيات:
        // إذا لم يكن المستخدم الحالي هو صاحب البروفايل، نقوم بفلترة النماذج لتظهر "العامة" فقط
        if (Auth::id() !== $this->user->id) {
            $query->where('is_public', true);
        }

        return view('livewire.profile.models-tab', [
            'models' => $query->latest()->get()
        ]);
    }
}
