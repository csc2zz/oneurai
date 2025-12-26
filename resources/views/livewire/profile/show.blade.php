<div>
    {{-- شريط التبويبات --}}
    <div class="border-b border-slate-200 mb-6 overflow-x-auto no-scrollbar">
        <nav class="flex flex-row gap-8 min-w-max" dir="rtl">
            <button
                    wire:click="switchTab('overview')"
                    class="pb-3 px-1 flex items-center gap-2 text-sm transition focus:outline-none {{ $activeTab === 'overview' ? 'border-b-2 border-emerald-600 text-slate-900 font-bold' : 'text-slate-500 hover:text-slate-700 hover:border-slate-300 border-b-2 border-transparent' }}">
                <i class="fa-solid fa-book-open"></i> نظرة عامة
            </button>

            <button
                    wire:click="switchTab('repositories')"
                    class="pb-3 px-1 flex items-center gap-2 text-sm transition focus:outline-none {{ $activeTab === 'repositories' ? 'border-b-2 border-emerald-600 text-slate-900 font-bold' : 'text-slate-500 hover:text-slate-700 hover:border-slate-300 border-b-2 border-transparent' }}">
                <i class="fa-solid fa-laptop-code"></i> المستودعات
            </button>

            <button
                    wire:click="switchTab('models')"
                    class="pb-3 px-1 flex items-center gap-2 text-sm transition focus:outline-none {{ $activeTab === 'models' ? 'border-b-2 border-emerald-600 text-slate-900 font-bold' : 'text-slate-500 hover:text-slate-700 hover:border-slate-300 border-b-2 border-transparent' }}">
                <i class="fa-solid fa-brain"></i> النماذج
            </button>
        </nav>
    </div>

    {{-- تحميل التبويب النشط --}}
    @if($activeTab === 'overview')
        <livewire:profile.overview-tab :user="$user" />
    @elseif($activeTab === 'repositories')
        <livewire:profile.repositories-tab :user="$user" />
    @elseif($activeTab === 'models')
        <livewire:profile.models-tab :user="$user" />
    @endif
    @elseif($activeTab === 'api')
        <livewire:profile.api-tokens />
    @endif
</div>
