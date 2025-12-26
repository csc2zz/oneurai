<?php

namespace App\Livewire;

use App\Models\Project;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;

#[Layout('components.layouts.app')]
#[Title('Oneurai | استكشف المشاريع')]
class ExploreProjects extends Component
{
    use WithPagination;

    #[Url]
    public $search = '';

    #[Url]
    public $category = '';

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function setCategory($category)
    {
        $this->category = $category === $this->category ? '' : $category;
        $this->resetPage();
    }

    public function render()
    {
        // استعلام المشاريع العادية (Recently Added)
        $projects = Project::where('is_public', true)
            ->with('user')
            ->when($this->search, function ($query) {
                $query->where('title', 'like', '%' . $this->search . '%')
                      ->orWhere('description', 'like', '%' . $this->search . '%');
            })
            // مثال: إذا كان لديك عمود category في قاعدة البيانات
            // ->when($this->category, function ($query) {
            //     $query->where('category', $this->category);
            // })
            ->latest()
            ->paginate(12);

        // استعلام المشاريع الرائجة (Editors Picks)
        $trendingProjects = Project::where('is_public', true)
            ->with('user')
            ->orderByDesc('stars_count')
            ->take(3)
            ->get();

        return view('livewire.explore-projects', [
            'projects' => $projects,
            'trendingProjects' => $trendingProjects
        ]);
    }
}
