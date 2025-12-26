<div class="bg-[#F8FAFC] min-h-screen pb-20 font-sans selection:bg-emerald-500 selection:text-white" dir="rtl">

    {{-- ================= HEADER SECTION ================= --}}
    <div class="bg-white border-b border-slate-200 pt-32 pb-0 relative overflow-hidden">
        <div class="absolute top-0 left-0 w-full h-full bg-gradient-to-b from-slate-50 to-transparent opacity-50 pointer-events-none"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6 mb-8">

                {{-- Breadcrumbs --}}
                <div class="flex items-center gap-3 text-2xl flex-wrap">
                    <div class="w-10 h-10 rounded-xl bg-slate-100 flex items-center justify-center text-emerald-600 border border-slate-200 shadow-sm">
                        <i class="fa-solid fa-boxes-stacked"></i> {{-- أيقونة احترافية للمستودع --}}
                    </div>
                    <div class="flex items-center gap-2 font-black tracking-tight" dir="ltr">
                        <a href="{{ route('profile.show', $projectOwner->username) }}" class="text-emerald-600 hover:text-emerald-700 transition">{{ $projectOwner->username }}</a>
                        <span class="text-slate-300 font-light">/</span>
                        <a href="#" class="text-slate-900 group flex items-center gap-2">{{ $project->slug }}</a>
                    </div>
                    @if($project->is_public)
                        <span class="px-2.5 py-0.5 rounded-full border border-emerald-200 text-[10px] font-black uppercase tracking-widest text-emerald-700 bg-emerald-50 ml-2">Public</span>
                    @else
                        <span class="px-2.5 py-0.5 rounded-full border border-amber-200 text-[10px] font-black uppercase tracking-widest text-amber-700 bg-amber-50 ml-2"><i class="fa-solid fa-lock mr-1"></i> Private</span>
                    @endif
                </div>

                {{-- Action Buttons --}}
                <div class="flex items-center gap-3" dir="ltr">
                    <div class="inline-flex shadow-sm rounded-xl overflow-hidden border border-slate-200 group">
                        <button class="flex items-center gap-2 px-4 py-2 bg-white text-slate-700 text-xs font-black hover:bg-slate-50 transition border-r border-slate-200">
                            <i class="fa-solid fa-star group-hover:text-amber-500 transition-colors"></i> Star
                        </button>
                        <span class="px-3 py-2 bg-slate-50 text-xs font-mono font-bold text-slate-600">{{ $project->stars_count }}</span>
                    </div>
                    <div class="inline-flex shadow-sm rounded-xl overflow-hidden border border-slate-200 group">
                        <button class="flex items-center gap-2 px-4 py-2 bg-white text-slate-700 text-xs font-black hover:bg-slate-50 transition border-r border-slate-200">
                            <i class="fa-solid fa-code-fork group-hover:text-emerald-600 transition-colors"></i> Fork
                        </button>
                        <span class="px-3 py-2 bg-slate-50 text-xs font-mono font-bold text-slate-600">4</span>
                    </div>
                </div>
            </div>

            {{-- Tabs Navigation --}}
            <div class="flex items-center gap-2 overflow-x-auto no-scrollbar border-b border-transparent">
               @php
                    $tabs = [
                        ['id' => 'code', 'label' => 'الكود', 'icon' => 'fa-solid fa-code'],
                        ['id' => 'issues', 'label' => 'المشاكل', 'icon' => 'fa-solid fa-circle-exclamation'],
                        ['id' => 'pulls', 'label' => 'طلبات الدمج', 'icon' => 'fa-solid fa-code-pull-request'],
                    ];

                    if (Auth::check() && Auth::id() === $project->user_id) {
                        $tabs[] = ['id' => 'settings', 'label' => 'الإعدادات', 'icon' => 'fa-solid fa-sliders'];
                    }
                @endphp
                @foreach($tabs as $tab)
                    <button wire:click="switchTab('{{ $tab['id'] }}')"
                       class="px-5 py-3 text-sm font-black flex items-center gap-2 transition-all duration-300 relative group
                       {{ $activeTab === $tab['id'] ? 'text-emerald-600 border-b-2 border-emerald-600 bg-emerald-50/50 rounded-t-xl' : 'text-slate-500 hover:text-slate-900' }}">
                        <i class="{{ $tab['icon'] }} text-xs opacity-70"></i>
                        {{ $tab['label'] }}
                    </button>
                @endforeach
            </div>
        </div>
    </div>

    {{-- ================= MAIN CONTENT ================= --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

        {{-- TAB 1: CODE VIEW --}}
        @if($activeTab === 'code')
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 animate-fade-in">
                <div class="lg:col-span-9 space-y-8">
                    <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
                        <div class="flex items-center gap-4 w-full sm:w-auto">
                            <button class="bg-white hover:bg-slate-50 border border-slate-200 text-slate-800 px-4 py-2 rounded-xl text-sm font-black flex items-center gap-2 shadow-sm transition group" dir="ltr">
                                <i class="fa-solid fa-code-branch text-emerald-500 transition-transform group-hover:rotate-12"></i>
                                main <i class="fa-solid fa-chevron-down text-[10px] opacity-40"></i>
                            </button>
                            <div class="text-xs font-bold text-slate-400 hidden sm:block">تحديث منذ {{ $project->updated_at->diffForHumans() }}</div>
                        </div>
                        <div class="flex gap-2 w-full sm:w-auto">
                            <button class="flex-1 sm:flex-none bg-slate-900 hover:bg-emerald-600 text-white px-6 py-2.5 rounded-xl text-sm font-black shadow-lg shadow-slate-200 transition-all flex items-center justify-center gap-2">
                                Clone <i class="fa-solid fa-terminal text-[10px] opacity-50"></i>
                            </button>
                            <button class="sm:w-12 w-full bg-white border border-slate-200 text-slate-600 rounded-xl flex items-center justify-center hover:text-emerald-600 transition shadow-sm">
                                <i class="fa-solid fa-download"></i>
                            </button>
                        </div>
                    </div>

                    {{-- File Browser --}}
                    <div class="bg-white border border-slate-200/60 rounded-[2rem] shadow-[0_8px_30px_rgb(0,0,0,0.03)] overflow-hidden">
                        <div class="bg-slate-50/80 backdrop-blur-md px-6 py-4 border-b border-slate-100 flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <img src="{{ $projectOwner->profile_photo_url }}" class="w-8 h-8 rounded-full border-2 border-white shadow-sm">
                                <div class="flex flex-col">
                                    <span class="text-sm font-black text-slate-900">{{ $projectOwner->username }}</span>
                                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-tighter" dir="ltr">Latest update</span>
                                </div>
                            </div>
                            <span class="text-[10px] font-black text-slate-400 bg-white px-2 py-1 rounded-lg border border-slate-100 font-mono">#{{ substr(md5($project->id), 0, 7) }}</span>
                        </div>

                        <div class="divide-y divide-slate-50">
                            @foreach($this->browserItems as $item)
                                <div class="px-6 py-3.5 hover:bg-slate-50/80 transition flex items-center justify-between group cursor-pointer">
                                    <div class="flex items-center gap-4 min-w-0">
                                        <div class="w-8 h-8 rounded-lg flex items-center justify-center transition-all group-hover:scale-110 {{ $item['type'] == 'folder' ? 'bg-blue-50 text-blue-500' : 'bg-slate-100 text-slate-400 group-hover:bg-emerald-50 group-hover:text-emerald-500' }}">
                                            <i class="{{ $item['type'] == 'folder' ? 'fa-solid fa-folder' : 'fa-solid fa-file-code' }}"></i>
                                        </div>
                                        <span class="text-sm font-black text-slate-800 hover:text-emerald-600 transition truncate" dir="ltr">{{ $item['name'] }}</span>
                                    </div>
                                    <span class="text-[10px] font-bold text-slate-400 font-mono">{{ $item['last_modified']->diffForHumans() }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <aside class="lg:col-span-3 space-y-10">
                    <div class="bg-white p-6 rounded-[2rem] border border-slate-200/60 shadow-sm">
                        <h3 class="font-black text-slate-900 text-xs uppercase tracking-widest mb-4 flex items-center gap-2">
                            <span class="w-1 h-3 bg-emerald-500 rounded-full"></span> عن المشروع
                        </h3>
                        <p class="text-sm text-slate-500 font-medium leading-relaxed mb-6">{{ $project->description }}</p>
                    </div>
                </aside>
            </div>

        {{-- TAB 2: ISSUES VIEW --}}
        @elseif($activeTab === 'issues')
            <div class="animate-fade-in max-w-full mx-auto">
                @if($selectedIssue)
                    <div class="max-w-5xl mx-auto">
                        <button wire:click="backToIssues" class="mb-6 text-slate-500 hover:text-emerald-600 font-bold text-sm flex items-center gap-2 transition">
                            <i class="fa-solid fa-chevron-right"></i> العودة للقائمة {{-- تم تصحيح السهم لـ RTL --}}
                        </button>

                        <div class="flex flex-col md:flex-row justify-between items-start gap-4 mb-8 border-b border-slate-200 pb-8">
                            <div class="flex-1">
                                <h2 class="text-3xl font-black text-slate-900 mb-3 leading-tight">
                                    {{ $selectedIssue->title }}
                                    <span class="text-slate-400 font-mono text-xl font-normal">#{{ $selectedIssue->id }}</span>
                                </h2>
                                <div class="flex items-center gap-3">
                                    @if($selectedIssue->status === 'open')
                                        <span class="px-3 py-1 bg-emerald-100 text-emerald-700 rounded-full text-xs font-black flex items-center gap-2 border border-emerald-200">
                                            <i class="fa-solid fa-circle-dot"></i> مفتوحة
                                        </span>
                                    @else
                                        <span class="px-3 py-1 bg-purple-100 text-purple-700 rounded-full text-xs font-black flex items-center gap-2 border border-purple-200">
                                            <i class="fa-solid fa-circle-check"></i> مغلقة
                                        </span>
                                    @endif
                                    <span class="text-slate-500 text-sm font-bold">بواسطة {{ $selectedIssue->author->name }}</span>
                                </div>
                            </div>

                            {{-- الحماية: مالك المشروع فقط من يرى زر التحكم بالحالة --}}
                            @if(Auth::id() === $project->user_id)
                                <button wire:click="toggleIssueStatus"
                                        class="px-5 py-2.5 rounded-xl text-sm font-black transition shadow-sm border flex items-center gap-2
                                        {{ $selectedIssue->status === 'open' ? 'bg-slate-900 text-white hover:bg-emerald-600 shadow-slate-200' : 'bg-emerald-50 border-emerald-200 text-emerald-600 hover:bg-emerald-100' }}">
                                    @if($selectedIssue->status === 'open')
                                        <i class="fa-solid fa-lock"></i> إغلاق المشكلة
                                    @else
                                        <i class="fa-solid fa-lock-open"></i> إعادة فتح
                                    @endif
                                </button>
                            @endif
                        </div>

                        {{-- محادثة المشكلة --}}
                        <div class="space-y-8">
                            <div class="flex gap-4">
                                <img src="{{ $selectedIssue->author->profile_photo_url }}" class="w-10 h-10 rounded-full border border-slate-200">
                                <div class="flex-1 bg-white border border-slate-200 rounded-2xl p-6 shadow-sm">
                                    <div class="text-slate-700 text-sm leading-relaxed whitespace-pre-line">{{ $selectedIssue->description }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="flex justify-between items-center mb-6">
                        <div class="relative w-96">
                            <i class="fa-solid fa-magnifying-glass absolute right-4 top-3.5 text-slate-400 text-xs"></i>
                            <input wire:model.live.debounce.300ms="searchIssues" type="text" placeholder="بحث في المشاكل..." 
                                   class="w-full bg-white border border-slate-200 rounded-xl py-2.5 pr-10 pl-4 text-sm font-bold focus:ring-emerald-500 transition shadow-sm">
                        </div>
                        <button wire:click="$set('showNewIssueModal', true)" class="bg-emerald-600 text-white px-6 py-2.5 rounded-xl text-sm font-black shadow-lg shadow-emerald-200 hover:bg-emerald-700 transition flex items-center gap-2">
                            مشكلة جديدة <i class="fa-solid fa-plus-circle"></i>
                        </button>
                    </div>

                    <div class="bg-white border border-slate-200 rounded-[1.5rem] shadow-sm overflow-hidden">
                        <div class="bg-slate-50/50 px-6 py-3 border-b border-slate-200 flex gap-6 text-xs font-black">
                            <button wire:click="setIssueFilter('open')" class="{{ $issueStatus === 'open' ? 'text-slate-900' : 'text-slate-400' }} flex items-center gap-2"><i class="fa-solid fa-circle-dot text-emerald-500"></i> مفتوحة</button>
                            <button wire:click="setIssueFilter('closed')" class="{{ $issueStatus === 'closed' ? 'text-slate-900' : 'text-slate-400' }} flex items-center gap-2"><i class="fa-solid fa-circle-check text-purple-500"></i> مغلقة</button>
                        </div>
                        <div class="divide-y divide-slate-50">
                            @forelse($issuesList as $issue)
                                <div wire:click="viewIssue({{ $issue->id }})" class="px-6 py-4 hover:bg-slate-50 transition cursor-pointer flex items-center justify-between">
                                    <div class="flex items-center gap-4">
                                        <i class="fa-solid {{ $issue->status == 'open' ? 'fa-circle-dot text-emerald-500' : 'fa-circle-check text-purple-500' }} text-lg"></i>
                                        <div class="flex flex-col">
                                            <span class="text-sm font-black text-slate-800">{{ $issue->title }}</span>
                                            <span class="text-[10px] text-slate-400 font-bold">#{{ $issue->id }} فتحها {{ $issue->author->name }} {{ $issue->created_at->diffForHumans() }}</span>
                                        </div>
                                    </div>
                                    <span class="text-xs font-bold text-slate-400"><i class="fa-regular fa-comment ml-1"></i> {{ $issue->comments->count() }}</span>
                                </div>
                            @empty
                                <div class="p-20 text-center text-slate-400 font-bold">لا توجد مشاكل حالياً.</div>
                            @endforelse
                        </div>
                    </div>
                @endif
            </div>
        @endif
    </div>

    {{-- ================= NEW ISSUE MODAL ================= --}}
    @if($showNewIssueModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center px-4">
            <div wire:click="$set('showNewIssueModal', false)" class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm cursor-pointer"></div>
            <div class="bg-white rounded-[2rem] shadow-2xl w-full max-w-2xl relative animate-fade-in-up overflow-hidden">
                <div class="px-8 py-6 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
                    <h3 class="text-lg font-black text-slate-900 flex items-center gap-2">
                        <i class="fa-solid fa-circle-exclamation text-emerald-600"></i> فتح مشكلة جديدة
                    </h3>
                    <button wire:click="$set('showNewIssueModal', false)" class="text-slate-400 hover:text-red-500"><i class="fa-solid fa-circle-xmark text-xl"></i></button>
                </div>
                <div class="p-8 space-y-6">
                    <div>
                        <label class="block text-xs font-black text-slate-500 uppercase tracking-wider mb-2">العنوان</label>
                        <input wire:model="newIssueTitle" type="text" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm font-bold focus:ring-emerald-500 outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-black text-slate-500 uppercase tracking-wider mb-2">الوصف</label>
                        <textarea wire:model="newIssueDescription" rows="5" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm font-medium outline-none resize-none"></textarea>
                    </div>
                </div>
                <div class="px-8 py-5 bg-slate-50 border-t border-slate-100 flex justify-end gap-3">
                    <button wire:click="createIssue" class="bg-slate-900 text-white px-8 py-2.5 rounded-xl text-sm font-black shadow-lg hover:bg-emerald-600 transition flex items-center gap-2">
                        نشر المشكلة <i class="fa-solid fa-paper-plane text-xs"></i>
                    </button>
                </div>
            </div>
        </div>
    @endif

    <style>
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .animate-fade-in { animation: fadeIn 0.4s ease-out forwards; }
        .animate-fade-in-up { animation: fadeInUp 0.3s ease-out forwards; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(5px); } to { opacity: 1; transform: translateY(0); } }
        @keyframes fadeInUp { from { opacity: 0; transform: scale(0.98) translateY(10px); } to { opacity: 1; transform: scale(1) translateY(0); } }
    </style>
</div>