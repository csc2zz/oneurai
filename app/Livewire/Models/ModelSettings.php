<?php
namespace App\Livewire\Models;

use App\Models\AiModel;
use App\Models\User;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Auth;

class ModelSettings extends Component
{
    public AiModel $model;
    public User $author;
    public $editTitle;

    public function mount($username, $slug)
    {
        $this->author = User::where('username', $username)->firstOrFail();
        $this->model = AiModel::where('user_id', $this->author->id)->where('slug', $slug)->firstOrFail();

        if (Auth::id() !== $this->author->id) abort(403);

        $this->editTitle = $this->model->title;
    }

    public function save()
    {
        $this->model->update(['title' => $this->editTitle]);
        session()->flash('message', 'تم الحفظ');
    }

    #[Layout('components.layouts.app')]
    public function render()
    {
        return view('livewire.models.model-settings');
    }
}
