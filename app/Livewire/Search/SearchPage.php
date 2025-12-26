<?php

namespace App\Livewire\Search;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Project;
use App\Models\AiModel;
use App\Models\Dataset;
use App\Models\User;

class SearchPage extends Component
{
    use WithPagination;

    public $q = ''; // نص البحث
    public $type = 'all'; // الفلتر: all, projects, models, users

    // ربط نص البحث بالـ URL
    protected $queryString = [
        'q' => ['except' => ''],
        'type' => ['except' => 'all']
    ];

    public function updatingQ() { $this->resetPage(); }

    public function render()
    {
        $query = trim($this->q);

        $results = [
            'projects' => ($this->type == 'all' || $this->type == 'projects') && $query 
                ? Project::where('title', 'like', "%{$query}%")->orWhere('description', 'like', "%{$query}%")->paginate(10, ['*'], 'projectsPage') 
                : collect(),
                
            'models' => ($this->type == 'all' || $this->type == 'models') && $query 
                ? AiModel::where('title', 'like', "%{$query}%")->paginate(10, ['*'], 'modelsPage') // استخدمنا title بدلاً من name
                : collect(),
                
            'datasets' => ($this->type == 'all' || $this->type == 'datasets') && $query 
                ? Dataset::where('title', 'like', "%{$query}%")->paginate(10, ['*'], 'datasetsPage') // استخدمنا title بدلاً من name
                : collect(),

            'users' => ($this->type == 'all' || $this->type == 'users') && $query 
                ? User::where('name', 'like', "%{$query}%")->orWhere('username', 'like', "%{$query}%")->paginate(12, ['*'], 'usersPage') 
                : collect(),
        ];

        return view('livewire.search.search-page', [
            'results' => $results
        ])->layout('components.layouts.app', ['title' => 'نتائج البحث عن: ' . $this->q]);
    }
}
