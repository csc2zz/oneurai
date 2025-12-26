<?php
namespace App\Livewire\Models;

use App\Models\AiModel;
use App\Models\User;
use Livewire\Component;
use Livewire\Attributes\Layout;

class ModelFiles extends Component
{
    public AiModel $model;
    public User $author;

    public function mount($username, $slug)
    {
        $this->author = User::where('username', $username)->firstOrFail();
        $this->model = AiModel::where('user_id', $this->author->id)->where('slug', $slug)->firstOrFail();
    }

    #[Layout('components.layouts.app')]
    public function render()
    {
        return view('livewire.models.model-files', [
            'files' => $this->model->files()->latest()->get()
        ]);
    }
}
