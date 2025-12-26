<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Project;
use App\Models\User;
use App\Models\AiModel;
use App\Models\Dataset; // تأكد من استيراد الموديل

class SearchModal extends Component
{
    public $search = '';
    public $showSearch = false;

    protected $listeners = ['openSearch' => 'open'];

    public function open() { $this->showSearch = true; }

    public function goToSearchPage()
    {
        if (strlen($this->search) >= 2) {
            return redirect()->route('search', ['q' => $this->search]);
        }
    }

    public function render()
    {
        $results = [
            'projects' => collect(),
            'models' => collect(),
            'datasets' => collect(), // المصفوفة الجديدة
            'users' => collect()
        ];

        if (strlen($this->search) >= 2) {
            $query = "%{$this->search}%";

            $results['projects'] = Project::with('user')->where('title', 'like', $query)->limit(3)->get();
            $results['models'] = AiModel::with('user')->where('title', 'like', $query)->limit(3)->get();
            
            // إضافة البحث في مجموعات البيانات
            $results['datasets'] = Dataset::with('user')->where('title', 'like', $query)
                ->orWhere('description', 'like', $query)
                ->limit(3)->get();
                
            $results['users'] = User::where('username', 'like', $query)->limit(3)->get();
        }

        return view('livewire.search-modal', ['results' => $results]);
    }
}