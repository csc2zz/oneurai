<div class="bg-slate-50 min-h-screen" wire:key="profile-{{ $user->id }}">

    <style>
        .badge-task { background-color: #f3e8ff; color: #7e22ce; border: 1px solid #d8b4fe; }
        .badge-lib { background-color: #e0f2fe; color: #0369a1; border: 1px solid #bae6fd; }
    </style>

    <div class="max-w-7xl mx-auto pt-36 px-4 sm:px-6 lg:px-8 py-8">
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">

            {{-- ================= القائمة الجانبية ================= --}}
            <div class="lg:col-span-1">
                <div class="relative group">
                    @if($user->avatar)
                        <img src="{{ asset('storage/'.$user->avatar) }}" class="w-full rounded-full border-4 border-white shadow-lg mb-4 object-cover">
                    @else
                        <div class="w-48 h-48 mx-auto lg:mx-0 bg-emerald-600 rounded-full flex items-center justify-center text-white text-6xl font-sans font-normal border-4 border-white shadow-sm mb-4">
                            {{ substr($user->name, 0, 2) }}
                        </div>
                    @endif
                </div>

                <h1 class="text-2xl font-bold text-slate-900 leading-tight text-center lg:text-right">                <x-admin-badge :user="$user" />{{ $user->name }}</h1>
                <p class="text-slate-500 text-lg mb-4 font-sans text-center lg:text-right" dir="ltr">{{ '@' . $user->username }}</p>

                <p class="text-slate-700 mb-6 leading-relaxed text-sm text-center lg:text-right">
                    {{ $user->bio ?? 'لا توجد نبذة تعريفية.' }}
                </p>

                @if(auth()->id() !== $user->id)
                <livewire:chat.send-invitation :user="$user" />
                @endif

                @if(auth()->id() === $user->id)
                    <a href="{{ route('dashboard.profile') }}" class="block w-full text-center bg-slate-900 text-white font-bold py-2 rounded-lg border border-slate-800 hover:bg-slate-800 transition mb-6">
                        تعديل الملف الشخصي
                    </a>
                @endif

                <div class="space-y-3 text-sm text-slate-600 mb-8 border-t border-slate-200 pt-6">
                    @if($user->company)
                        <div class="flex items-center gap-3 justify-center lg:justify-start">
                            <i class="fa-solid fa-building w-4 text-center text-slate-400"></i>
                            <span>{{ $user->company }}</span>
                        </div>
                    @endif
                    @if($user->location)
                        <div class="flex items-center gap-3 justify-center lg:justify-start">
                            <i class="fa-solid fa-location-dot w-4 text-center text-slate-400"></i>
                            <span>{{ $user->location }}</span>
                        </div>
                    @endif
                    <div class="flex items-center gap-3 justify-center lg:justify-start">
                        <i class="fa-solid fa-envelope w-4 text-center text-slate-400"></i>
                        <a href="mailto:{{ $user->email }}" class="hover:text-emerald-600 truncate">{{ $user->email }}</a>
                    </div>
                    @if($user->website)
                        <div class="flex items-center gap-3 justify-center lg:justify-start">
                            <i class="fa-solid fa-link w-4 text-center text-slate-400"></i>
                            <a href="{{ $user->website }}" target="_blank" class="hover:text-emerald-600 font-sans" dir="ltr">{{ parse_url($user->website, PHP_URL_HOST) }}</a>
                        </div>
                    @endif
                </div>
            </div>

            {{-- ================= منطقة المحتوى ================= --}}
            <div class="lg:col-span-3">

                {{-- شريط التبويبات --}}
                <div class="border-b border-slate-200 mb-6 overflow-x-auto no-scrollbar">
                    <nav class="flex flex-row gap-8 min-w-max" dir="rtl">
                        <button type="button" wire:click="$set('activeTab', 'overview')" wire:key="nav-overview" class="pb-3 px-1 flex items-center gap-2 text-sm transition focus:outline-none {{ $activeTab === 'overview' ? 'border-b-2 border-emerald-600 text-slate-900 font-bold' : 'text-slate-500 hover:text-slate-700 hover:border-slate-300 border-b-2 border-transparent' }}">
                            <i class="fa-solid fa-book-open"></i> نظرة عامة
                        </button>

                        <button type="button" wire:click="$set('activeTab', 'repositories')" wire:key="nav-repos" class="pb-3 px-1 flex items-center gap-2 text-sm transition focus:outline-none {{ $activeTab === 'repositories' ? 'border-b-2 border-emerald-600 text-slate-900 font-bold' : 'text-slate-500 hover:text-slate-700 hover:border-slate-300 border-b-2 border-transparent' }}">
                            <i class="fa-solid fa-laptop-code"></i> المستودعات
                            <span class="bg-slate-100 px-2 rounded-full text-xs {{ $activeTab === 'repositories' ? 'text-slate-800' : 'text-slate-600' }}">
                                {{ $this->userStats['projects'] ?? 0 }}
                            </span>
                        </button>

                        <button type="button" wire:click="$set('activeTab', 'models')" wire:key="nav-models" class="pb-3 px-1 flex items-center gap-2 text-sm transition focus:outline-none {{ $activeTab === 'models' ? 'border-b-2 border-emerald-600 text-slate-900 font-bold' : 'text-slate-500 hover:text-slate-700 hover:border-slate-300 border-b-2 border-transparent' }}">
                            <i class="fa-solid fa-brain"></i> النماذج
                            <span class="{{ $activeTab === 'models' ? 'bg-emerald-100 text-emerald-800' : 'bg-slate-100 text-slate-600' }} px-2 rounded-full text-xs">
                                {{ $this->userStats['models'] ?? 0 }}
                            </span>
                        </button>
                    </nav>

                    <div wire:loading class="opacity-50 pointer-events-none text-xs text-emerald-600 pt-1">
                        جاري التحميل...
                    </div>
                </div>

                {{-- ================= تبويب نظرة عامة ================= --}}
                @if($activeTab === 'overview')
                    <div wire:key="tab-overview" class="animate-fade-in">
                        {{-- المشاريع المثبتة --}}
                        <div class="mb-10">
                            <div class="flex justify-between items-center mb-4">
                                <h2 class="text-lg font-bold text-slate-900">مثبتة</h2>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                @forelse($pinnedProjects as $project)
                                    <div class="border border-slate-200 rounded-xl p-4 hover:border-emerald-400 transition cursor-pointer bg-white group">
                                        <div class="flex items-center gap-2 mb-2">
                                            <i class="fa-solid fa-book-bookmark text-slate-400 group-hover:text-emerald-500 transition"></i>
                                            <a href="{{ route('projects.show', [$user->username, $project->slug]) }}" class="font-bold text-emerald-600 hover:underline font-sans" dir="ltr">{{ $project->title }}</a>
                                            <span class="px-2 py-0.5 rounded-full border border-slate-200 text-[10px] text-slate-500">{{ $project->is_public ? 'Public' : 'Private' }}</span>
                                        </div>
                                        <p class="text-xs text-slate-500 mb-4 h-10 overflow-hidden line-clamp-2">{{ $project->description ?? 'لا يوجد وصف.' }}</p>
                                        <div class="flex items-center gap-4 text-xs text-slate-500">
                                            <div class="flex items-center gap-1"><span class="w-3 h-3 rounded-full bg-slate-300"></span> {{ $project->language ?? 'Code' }}</div>
                                            <div class="hover:text-emerald-600 cursor-pointer" wire:click="toggleStar({{ $project->id }})">
                                                <i class="fa-regular fa-star"></i> {{ $project->stars_count }}
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="col-span-full text-center py-8 text-slate-500 border border-dashed border-slate-300 rounded-xl">لا توجد مشاريع مثبتة.</div>
                                @endforelse
                            </div>
                        </div>

                        {{-- رسم المساهمات --}}
                        <div class="mb-10">
                            <h2 class="text-lg font-bold text-slate-900 mb-4">المساهمات ({{ date('Y') }})</h2>
                            <div class="bg-white border border-slate-200 rounded-xl p-4 overflow-x-auto">
                                <div class="min-w-[600px] flex flex-col gap-1" dir="ltr">
                                    <div class="grid grid-rows-7 grid-flow-col gap-1 h-32">
                                        @for($i = 0; $i < 365; $i++)
                                            @php $level = rand(0, 4); $cls = match($level) { 0=>'bg-slate-100', 1=>'bg-emerald-100', 2=>'bg-emerald-300', 3=>'bg-emerald-500', 4=>'bg-emerald-700' }; @endphp
                                            <div class="w-3 h-3 rounded-sm {{ $cls }}"></div>
                                        @endfor
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                {{-- ================= تبويب المستودعات ================= --}}
                @if($activeTab === 'repositories')
                    <div wire:key="tab-repositories" class="animate-fade-in">
                        {{-- البحث --}}
                        <div class="flex flex-col sm:flex-row gap-4 mb-6 pb-6 border-b border-slate-200">
                            <div class="flex-1 relative">
                                <input wire:model.live.debounce.300ms="repositorySearch" type="text" placeholder="ابحث عن مستودع..." class="w-full bg-white border border-slate-300 rounded-lg py-2 pr-4 pl-10 text-sm focus:ring-2 focus:ring-emerald-500 outline-none">
                                <i class="fa-solid fa-magnifying-glass absolute left-3 top-2.5 text-slate-400"></i>
                            </div>
                            <div class="flex gap-2">
                                <select class="bg-white border border-slate-300 rounded-lg py-2 px-3 text-sm text-slate-600 outline-none focus:border-emerald-500">
                                    <option>النوع: الكل</option>
                                    <option>عام (Public)</option>
                                    <option>خاص (Private)</option>
                                </select>
                                @if(auth()->id() === $user->id)
                                    <a href="{{ route('dashboard.repos') }}" class="bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2 rounded-lg text-sm font-bold transition flex items-center gap-2">
                                        <i class="fa-solid fa-plus"></i> جديد
                                    </a>
                                @endif
                            </div>
                        </div>

                        {{-- القائمة --}}
                        <div class="space-y-4">
                            @forelse($this->repositories as $project)
                                <div wire:key="repo-{{ $project->id }}" class="flex flex-col sm:flex-row justify-between items-start p-5 border border-slate-200 rounded-xl hover:bg-slate-50 transition bg-white group">
                                    <div class="flex-1">
                                        <div class="flex items-center gap-3 mb-2">
                                            <a href="{{ route('projects.show', [$user->username, $project->slug]) }}" class="text-xl font-bold text-emerald-600 hover:underline font-sans" dir="ltr">{{ $project->title }}</a>
                                            <span class="px-2 py-0.5 rounded-full border {{ $project->is_public ? 'border-slate-200 text-slate-500 bg-white' : 'border-amber-200 text-amber-700 bg-amber-50' }} text-[10px]">
                                                {{ $project->is_public ? 'Public' : 'Private' }}
                                            </span>
                                        </div>
                                        <p class="text-slate-600 text-sm mb-4 max-w-2xl line-clamp-2">
                                            {{ $project->description ?? 'لا يوجد وصف.' }}
                                        </p>
                                        <div class="flex items-center gap-5 text-xs text-slate-500">
                                            <div class="flex items-center gap-1.5">
                                                <span class="w-3 h-3 rounded-full bg-yellow-400"></span>
                                                {{ $project->language ?? 'Code' }}
                                            </div>
                                            <div class="hover:text-emerald-600 cursor-pointer flex items-center gap-1" wire:click="toggleStar({{ $project->id }})">
                                                <i class="fa-regular fa-star"></i> {{ $project->stars_count }}
                                            </div>
                                            <div>تحديث {{ $project->updated_at->diffForHumans() }}</div>
                                        </div>
                                    </div>
                                    <div class="mt-4 sm:mt-0">
                                        @if(auth()->id() === $user->id)
                                            <button wire:click="togglePin({{ $project->id }})" class="text-slate-400 hover:text-emerald-600 border border-slate-200 rounded-lg px-3 py-1.5 text-sm bg-white hover:bg-slate-50 flex items-center gap-2 transition">
                                                <i class="fa-solid fa-thumbtack"></i>
                                                <span class="hidden sm:inline">{{ $project->is_pinned ? 'إلغاء التثبيت' : 'تثبيت' }}</span>
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-12 text-slate-500">
                                    <i class="fa-solid fa-box-open text-4xl mb-4 text-slate-300"></i>
                                    <p>لا توجد مستودعات تطابق بحثك.</p>
                                </div>
                            @endforelse
                        </div>

                        {{-- Pagination Links --}}
                        <div class="mt-6">
                            {{ $this->repositories->links('vendor.livewire.oneurai-pagination') }}
                        </div>
                    </div>
                @endif

                {{-- ================= تبويب النماذج ================= --}}
                @if($activeTab === 'models')
                    <div wire:key="tab-models" class="animate-fade-in">
                        {{-- البحث --}}
                        <div class="flex flex-col sm:flex-row gap-4 mb-6 pb-6 border-b border-slate-200">
                            <div class="flex-1 relative">
                                <input wire:model.live.debounce.300ms="modelSearch" type="text" placeholder="ابحث في النماذج..." class="w-full bg-white border border-slate-300 rounded-lg py-2 pr-4 pl-10 text-sm focus:ring-2 focus:ring-emerald-500 outline-none">
                                <i class="fa-solid fa-magnifying-glass absolute left-3 top-2.5 text-slate-400"></i>
                            </div>
                            <div class="flex gap-2">
                                <select class="bg-white border border-slate-300 rounded-lg py-2 px-3 text-sm text-slate-600 outline-none focus:border-emerald-500">
                                    <option>المهمة: الكل</option>
                                    <option>Text Generation</option>
                                    <option>Computer Vision</option>
                                </select>
                                @if(auth()->id() === $user->id)
                                    <a href="{{ route('dashboard.models.upload') }}" class="bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2 rounded-lg text-sm font-bold transition flex items-center gap-2 shadow-sm shadow-emerald-600/20 whitespace-nowrap">
                                        <i class="fa-solid fa-cloud-arrow-up"></i> رفع نموذج
                                    </a>
                                @endif
                            </div>
                        </div>

                        {{-- الشبكة --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            @forelse($this->aiModels as $model)
                                <div wire:key="model-{{ $model->id }}" class="p-5 border border-slate-200 rounded-xl hover:border-emerald-400 hover:shadow-md transition bg-white group h-full flex flex-col">
                                    <div class="flex justify-between items-start mb-3">
                                        <div class="flex items-center gap-2">
                                            <div class="w-8 h-8 rounded-lg bg-purple-50 text-purple-600 flex items-center justify-center text-sm">
                                                <i class="fa-solid fa-brain"></i>
                                            </div>
                                            <a href="#" class="font-bold text-lg text-slate-900 group-hover:text-emerald-600 hover:underline font-sans" dir="ltr">{{ $model->title }}</a>
                                        </div>
                                        <span class="px-2 py-0.5 rounded-full border {{ $model->is_public ? 'border-slate-200 text-slate-500 bg-white' : 'border-amber-200 text-amber-700 bg-amber-50' }} text-[10px]">
                                            {{ $model->is_public ? 'Public' : 'Private' }}
                                        </span>
                                    </div>

                                    <p class="text-slate-600 text-sm mb-4 line-clamp-2 flex-grow">
                                        {{ $model->description ?? 'لا يوجد وصف' }}
                                    </p>

                                    <div class="flex flex-wrap gap-2 mb-4">
                                        <span class="badge-task px-2 py-0.5 rounded text-[10px] font-bold">{{ $model->task }}</span>
                                        <span class="badge-lib px-2 py-0.5 rounded text-[10px] font-bold">{{ $model->framework }}</span>
                                    </div>

                                    <div class="flex items-center justify-between text-xs text-slate-500 pt-3 border-t border-slate-50">
                                        <div class="flex gap-3">
                                            <span class="flex items-center gap-1 hover:text-emerald-600 cursor-pointer" wire:click="toggleModelLike({{ $model->id }})">
                                                <i class="fa-regular fa-heart"></i> {{ $model->likes_count }}
                                            </span>
                                            <span class="flex items-center gap-1 hover:text-emerald-600">
                                                <i class="fa-solid fa-download"></i> {{ $model->downloads_count }}
                                            </span>
                                        </div>
                                        <span>تحديث: {{ $model->updated_at->diffForHumans() }}</span>
                                    </div>
                                </div>
                            @empty
                                <div class="col-span-full text-center py-12 text-slate-500">
                                    <i class="fa-solid fa-cube text-4xl mb-4 text-slate-300"></i>
                                    <p>لا توجد نماذج متاحة.</p>
                                </div>
                            @endforelse
                        </div>

                        {{-- Pagination Links --}}
                        <div class="mt-6">
                            {{ $this->aiModels->links('vendor.livewire.oneurai-pagination') }}
                        </div>
                    </div>
                @endif

            </div>
        </div>
    </div>
</div>
