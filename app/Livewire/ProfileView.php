<?php

namespace App\Livewire;

use App\Models\User;
use App\Models\Project;
use App\Models\AiModel;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Url;
use Livewire\WithPagination; // 1. استدعاء التريت
use Illuminate\Support\Facades\Auth;

#[Layout('components.layouts.app')]
class ProfileView extends Component
{
    use WithPagination; // 2. تفعيل التريت

    public User $user;

    #[Url]
    public $activeTab = 'overview';

    public $repositorySearch = '';
    public $modelSearch = '';

    public $pinnedProjects = [];
    public $contributionGraph = [];

    public function mount($username)
    {
        $this->loadUserData($username);
        $this->initializePageData();
    }

    private function loadUserData($username)
    {
        $this->user = User::where('username', $username)
            ->withCount(['projects', 'aiModels'])
            ->firstOrFail();
    }

    private function initializePageData()
    {
        $this->loadPinnedProjects();
        $this->generateContributionGraph();
    }

    // 3. تحسين منطق المشاريع المثبتة (عرض الخاص للمالك فقط)
    private function loadPinnedProjects()
    {
        $query = $this->user->projects()
            ->where('is_pinned', true);

        // إذا لم يكن هو صاحب البروفايل، اعرض العام فقط
        if (Auth::id() !== $this->user->id) {
            $query->where('is_public', true);
        }

        $this->pinnedProjects = $query->withCount('stars')
            ->latest()
            ->take(6)
            ->get();
    }

    private function generateContributionGraph()
    {
        $this->contributionGraph = [];
        for ($i = 0; $i < 365; $i++) {
            $this->contributionGraph[] = rand(0, 10);
        }
    }

    // ========== COMPUTED PROPERTIES ==========

    // 4. استخدام Pagination بدلاً من get()
    public function getRepositoriesProperty()
    {
        return $this->buildProjectsQuery()->paginate(10);
    }

    public function getAiModelsProperty()
    {
        return $this->buildModelsQuery()->paginate(10);
    }

    public function getUserStatsProperty()
    {
        return [
            'projects' => $this->user->projects()->where('is_public', true)->count(),
            'models' => $this->user->aiModels()->where('is_public', true)->count(),
            'stars' => $this->user->projects()->sum('stars_count'),
            'followers' => $this->user->followers()->count(), // تأكد من وجود علاقة followers
        ];
    }

    // ========== QUERY BUILDERS ==========

    private function buildProjectsQuery()
    {
        $query = $this->user->projects()
            ->with(['user', 'stars'])
            ->withCount('stars');

        if (!Auth::check() || Auth::id() !== $this->user->id) {
            $query->where('is_public', true);
        }

        if (!empty($this->repositorySearch)) {
            $query->where(function ($q) {
                $q->where('title', 'LIKE', '%' . $this->repositorySearch . '%')
                  ->orWhere('description', 'LIKE', '%' . $this->repositorySearch . '%');
            });
        }

        return $query->latest();
    }

    private function buildModelsQuery()
    {
        $query = AiModel::where('user_id', $this->user->id)
            ->with(['user', 'likes'])
            ->withCount('likes');

        if (!Auth::check() || Auth::id() !== $this->user->id) {
            $query->where('is_public', true);
        }

        if (!empty($this->modelSearch)) {
            $query->where(function ($q) {
                $q->where('title', 'LIKE', '%' . $this->modelSearch . '%')
                  ->orWhere('description', 'LIKE', '%' . $this->modelSearch . '%')
                  ->orWhere('task', 'LIKE', '%' . $this->modelSearch . '%');
            });
        }

        return $query->latest();
    }

    // ========== ACTIONS ==========

    public function togglePin($projectId)
    {
        if (Auth::id() !== $this->user->id) {
            return;
        }

        $project = Project::where('id', $projectId)
            ->where('user_id', Auth::id())
            ->first();

        if ($project) {
            $project->update(['is_pinned' => !$project->is_pinned]);
            $this->loadPinnedProjects();
        }
    }

    public function toggleStar($projectId)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $project = Project::findOrFail($projectId);

        // تأكد من وجود دالة isStarredBy في موديل Project
        if ($project->isStarredBy(Auth::user())) {
            $project->stars()->where('user_id', Auth::id())->delete();
        } else {
            $project->stars()->create(['user_id' => Auth::id()]);
        }

        // ملاحظة: مع الـ Computed Properties التحديث تلقائي غالباً، لكن dispatch مفيد للـ frontend
        $this->dispatch('project-starred', projectId: $projectId);
    }

    // ========== LIFECYCLE ==========

    // 5. إعادة تعيين الصفحة الأولى عند البحث
    public function updatedRepositorySearch()
    {
        $this->activeTab = 'repositories';
        $this->resetPage();
    }

    public function updatedModelSearch()
    {
        $this->activeTab = 'models';
        $this->resetPage();
    }

    public function render()
    {
        return view('livewire.profile-view', [
            'pageTitle' => $this->user->name . ' (@' . $this->user->username . ') - Oneurai'
        ]);
    }
}
