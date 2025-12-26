<div class="min-h-screen bg-[#F8FAFC] font-sans text-slate-900 selection:bg-emerald-500 selection:text-white pb-20" dir="rtl">

    {{-- ========================================== --}}
    {{-- 1. الهيرو: القسم العلوي الكحلي (Dark Header) --}}
    {{-- ========================================== --}}
    <div class="relative border-b border-slate-800/50 bg-[#0F172A] pt-24 pb-24 overflow-hidden shadow-xl shadow-slate-900/20 z-10">
        {{-- خلفية شبكية داكنة --}}
        <div class="absolute inset-0 z-0 opacity-[0.1]" 
             style="background-image: linear-gradient(#334155 1px, transparent 1px), linear-gradient(to right, #334155 1px, transparent 1px); background-size: 40px 40px;">
        </div>
        
        {{-- تأثير التوهج العلوي --}}
        <div class="absolute top-0 left-1/2 -translate-x-1/2 w-full max-w-3xl h-64 bg-emerald-500/10 blur-[100px] rounded-full pointer-events-none"></div>

        <div class="max-w-7xl mt-16 mx-auto px-6 relative z-10">
            <div class="flex flex-col lg:flex-row items-end justify-between gap-12">
                <div class="w-full max-w-2xl">
                    {{-- البادج العلوي (مضيء على خلفية داكنة) --}}
                    <div class="inline-flex items-center gap-3 px-3 py-1.5 rounded-lg bg-slate-800/50 border border-slate-700/50 text-emerald-400 text-[11px] font-black mb-6 shadow-sm backdrop-blur-sm">
                        <span class="flex h-2 w-2 relative">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                        </span>
                        <span>المكتبة المركزية / المصادر المفتوحة</span>
                    </div>

                    <h1 class="text-4xl lg:text-6xl font-black text-white mb-6 tracking-tight leading-tight">
                        مستودع
                        <span class="text-transparent bg-clip-text bg-gradient-to-l from-emerald-400 to-cyan-400">النخبة البرمجية</span>
                    </h1>
                    
                    <p class="text-slate-400 text-lg mb-10 font-medium max-w-xl leading-relaxed">
                        المرجع العربي الأول للمطورين. استكشف آلاف المشاريع مفتوحة المصدر، السكربتات، والنماذج الجاهزة للدمج في مشروعك القادم.
                    </p>

                    {{-- مربع البحث (مدمج في الخلفية الداكنة) --}}
                    <div class="relative group">
                        {{-- توهج خفيف خلف البحث --}}
                        <div class="absolute -inset-0.5 bg-gradient-to-r from-emerald-500/30 to-cyan-500/30 rounded-xl blur opacity-20 group-hover:opacity-40 transition duration-500"></div>
                        
                        <div class="relative flex items-center bg-[#1E293B] rounded-xl p-1 border border-slate-700/80 shadow-lg">
                            <div class="flex-shrink-0 w-12 h-12 flex items-center justify-center text-slate-500 font-bold text-xl border-l border-slate-700 ml-1 group-focus-within:text-emerald-500 transition-colors">
                                <i class="fa-solid fa-search"></i>
                            </div>
                            <input wire:model.live.debounce.300ms="search" 
                                   type="text" 
                                   class="w-full bg-transparent border-none focus:ring-0 text-white font-bold text-sm placeholder-slate-500 h-12" 
                                   placeholder="أدخل كلمات البحث (اسم المشروع، المطور، اللغة)...">
                            
                            <div wire:loading wire:target="search" class="px-4 text-emerald-400 text-xs font-bold animate-pulse whitespace-nowrap">
                                جاري البحث...
                            </div>
                        </div>
                    </div>
                </div>

                {{-- زخرفة أيقونة داكنة --}}
                <div class="hidden lg:block relative group select-none">
                     <div class="absolute inset-0 bg-emerald-500/5 blur-3xl rounded-full"></div>
                    <i class="fa-solid fa-layer-group text-[120px] text-slate-800 drop-shadow-2xl group-hover:text-slate-700 transition-colors duration-500 transform rotate-[-15deg]"></i>
                </div>
            </div>
        </div>
    </div>

    {{-- ========================================== --}}
    {{-- 2. شريط التصنيفات (فاتح لعمل تباين) --}}
    {{-- ========================================== --}}
    <div class="sticky top-0 z-40 bg-white/90 backdrop-blur-md border-b border-slate-200 shadow-sm -mt-[1px]">
        <div class="max-w-7xl mx-auto px-6">
            <div class="flex items-center gap-2 overflow-x-auto py-4 no-scrollbar">
                <button wire:click="$set('category', '')" 
                        class="flex-shrink-0 px-5 py-2 rounded-lg text-xs font-bold transition-all border 
                        {{ !$category ? 'bg-[#0F172A] text-white border-[#0F172A] shadow-md' : 'bg-white text-slate-600 border-slate-200 hover:border-slate-300 hover:bg-slate-50' }}">
                    الكل
                </button>
                @foreach([
                    ['id' => 'nlp', 'label' => 'معالجة اللغات (NLP)', 'icon' => 'fa-comments'],
                    ['id' => 'vision', 'label' => 'الرؤية الحاسوبية', 'icon' => 'fa-eye'],
                    ['id' => 'audio', 'label' => 'الصوتيات', 'icon' => 'fa-microphone'],
                    ['id' => 'finance', 'label' => 'التقنية المالية', 'icon' => 'fa-chart-line'],
                    ['id' => 'robotics', 'label' => 'الروبوتات', 'icon' => 'fa-robot'],
                ] as $cat)
                <button wire:click="setCategory('{{ $cat['id'] }}')" 
                        class="flex-shrink-0 px-4 py-2 rounded-lg text-xs font-bold border transition-all flex items-center gap-2 whitespace-nowrap
                        {{ $category === $cat['id'] ? 'bg-emerald-50 text-emerald-700 border-emerald-200 shadow-sm' : 'bg-white text-slate-600 border-slate-200 hover:border-emerald-200 hover:text-emerald-600' }}">
                    <i class="fa-solid {{ $cat['icon'] }}"></i> {{ $cat['label'] }}
                </button>
                @endforeach
            </div>
        </div>
    </div>

    {{-- ========================================== --}}
    {{-- 3. المحتوى (فاتح كما كان) --}}
    {{-- ========================================== --}}
    <div class="max-w-7xl mx-auto px-6 py-12">
        
        {{-- أ) القسم المميز (Featured) --}}
        @if(!$search && !$category)
        <div class="mb-20">
            <div class="flex items-center gap-3 mb-8 pb-3 border-b border-slate-200">
                <div class="w-10 h-10 rounded-full bg-orange-50 flex items-center justify-center text-orange-500 shadow-sm border border-orange-100">
                    <i class="fa-solid fa-fire animate-pulse"></i>
                </div>
                <h2 class="text-xl font-black text-slate-800">تحليل التريند :: المشاريع الرائجة</h2>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach($trendingProjects as $project)
                <div class="group relative bg-white rounded-2xl border border-slate-200 p-6 hover:border-emerald-400 hover:shadow-xl hover:shadow-emerald-500/10 transition-all duration-300 hover:-translate-y-1 overflow-hidden">
                    
                    {{-- بادج الرائج --}}
                    <div class="absolute top-4 left-4">
                        <span class="text-[10px] font-bold bg-orange-50 text-orange-600 px-2 py-1 rounded-md border border-orange-100 shadow-sm">رائج 🔥</span>
                    </div>

                    <div class="relative z-10">
                        <div class="w-14 h-14 bg-slate-50 rounded-2xl flex items-center justify-center text-2xl mb-4 text-emerald-600 border border-slate-100 group-hover:bg-emerald-50 transition-colors shadow-sm">
                            @if($project->type == 'model') <i class="fa-solid fa-brain"></i> @else <i class="fa-solid fa-cube"></i> @endif
                        </div>
                        
                        <h3 class="text-lg font-black text-slate-900 mb-2 group-hover:text-emerald-600 transition-colors truncate">
                            <a href="{{ route('project.showing', ['username' => $project->user->username, 'slug' => $project->slug]) }}" class="block">{{ $project->title }}</a>
                        </h3>
                        
                        <p class="text-slate-500 text-xs font-medium line-clamp-2 mb-6 h-8 leading-relaxed">{{ $project->description }}</p>
                        
                        <div class="flex items-center gap-3 text-xs font-bold text-slate-400 border-t border-slate-50 pt-4 bg-slate-50/50 -mx-6 -mb-6 px-6 py-3 mt-4">
                            <img src="https://ui-avatars.com/api/?name={{ $project->user->username }}&background=e2e8f0&color=64748b" class="w-6 h-6 rounded-full border border-white shadow-sm" alt="">
                            <span class="text-slate-600">{{ $project->user->username }}</span>
                            <div class="mr-auto flex items-center gap-1 text-amber-500 bg-white px-2 py-0.5 rounded shadow-sm border border-slate-100">
                                <i class="fa-solid fa-star text-[10px]"></i> {{ $project->stars_count }}
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        {{-- مصفوفة الألوان (Light Mode Colors) --}}
        @php
            $styles = [
                ['icon' => 'fa-code', 'bg' => 'bg-blue-50', 'text' => 'text-blue-600', 'border' => 'group-hover:border-blue-400'],
                ['icon' => 'fa-terminal', 'bg' => 'bg-emerald-50', 'text' => 'text-emerald-600', 'border' => 'group-hover:border-emerald-400'],
                ['icon' => 'fa-microchip', 'bg' => 'bg-purple-50', 'text' => 'text-purple-600', 'border' => 'group-hover:border-purple-400'],
                ['icon' => 'fa-database', 'bg' => 'bg-cyan-50', 'text' => 'text-cyan-600', 'border' => 'group-hover:border-cyan-400'],
                ['icon' => 'fa-cloud', 'bg' => 'bg-indigo-50', 'text' => 'text-indigo-600', 'border' => 'group-hover:border-indigo-400'],
                ['icon' => 'fa-robot', 'bg' => 'bg-rose-50', 'text' => 'text-rose-600', 'border' => 'group-hover:border-rose-400'],
                ['icon' => 'fa-fingerprint', 'bg' => 'bg-amber-50', 'text' => 'text-amber-600', 'border' => 'group-hover:border-amber-400'],
                ['icon' => 'fa-network-wired', 'bg' => 'bg-teal-50', 'text' => 'text-teal-600', 'border' => 'group-hover:border-teal-400'],
            ];
        @endphp

        {{-- ب) كل المشاريع --}}
        <div id="all-projects">
            <div class="mb-8 pb-4 border-b border-slate-200 flex justify-between items-end">
                <div>
                    <h2 class="text-xl font-black text-slate-800 flex items-center gap-2">
                        @if($search) 
                            <span class="text-emerald-500"><i class="fa-solid fa-angles-left"></i></span> نتائج البحث: "{{ $search }}"
                        @else 
                            <span class="text-emerald-500"><i class="fa-solid fa-angles-left"></i></span> فهرس المشاريع
                        @endif
                    </h2>
                    <div class="mt-2 text-[11px] font-bold text-slate-400">تم العثور على {{ $projects->count() }} ملف.</div>
                </div>
            </div>

            {{-- Grid --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
                @forelse($projects as $project)
                
                @php
                    $style = $styles[$loop->index % count($styles)];
                @endphp

                <a href="{{ route('project.showing', ['username' => $project->user->username, 'slug' => $project->slug]) }}" 
                   class="group bg-white rounded-xl border border-slate-200 hover:border-opacity-100 transition-all duration-200 flex flex-col h-[230px] overflow-hidden hover:shadow-lg hover:shadow-slate-200/50 {{ $style['border'] }}">
                    
                    <div class="p-5 flex flex-col h-full relative">
                        {{-- رأس الكارد --}}
                        <div class="flex justify-between items-start mb-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl flex items-center justify-center text-sm {{ $style['bg'] }} {{ $style['text'] }} shadow-sm">
                                    <i class="fa-solid {{ $style['icon'] }}"></i>
                                </div>
                                <span class="text-[11px] font-bold text-slate-400 group-hover:text-slate-600 transition-colors uppercase" dir="ltr">
                                    {{ $project->user->username }}
                                </span>
                            </div>
                            
                            @if($project->created_at->diffInDays() < 7)
                                <span class="text-[9px] font-bold text-emerald-600 px-2 py-0.5 bg-emerald-50 border border-emerald-100 rounded-full shadow-sm">جديد</span>
                            @endif
                        </div>

                        <h3 class="font-bold text-slate-800 text-sm mb-2 group-hover:text-emerald-600 transition-colors line-clamp-1 tracking-tight">
                            {{ $project->title }}
                        </h3>
                        
                        <p class="text-[11px] text-slate-500 leading-relaxed line-clamp-2 mb-auto font-medium group-hover:text-slate-600 transition-colors">
                            {{ $project->description }}
                        </p>

                        {{-- فوتر الكارد --}}
                        <div class="flex items-center justify-between pt-3 mt-2 border-t border-slate-50 text-[10px] font-bold text-slate-400">
                            <span class="flex items-center gap-1.5 bg-slate-50 px-2 py-1 rounded text-slate-500">
                                <i class="fa-regular fa-clock"></i> {{ $project->created_at->format('Y/m/d') }}
                            </span>
                            <span class="flex items-center gap-1.5 group-hover:text-amber-500 transition-colors">
                                <i class="fa-solid fa-star"></i> {{ $project->stars_count }}
                            </span>
                        </div>
                    </div>
                </a>
                @empty
                <div class="col-span-full py-20 text-center bg-slate-50/50 rounded-xl border-2 border-dashed border-slate-200">
                    <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center mx-auto mb-4 text-slate-300 text-2xl shadow-sm">
                        <i class="fa-solid fa-folder-open"></i>
                    </div>
                    <h3 class="text-slate-900 font-bold text-lg mb-1">عفواً، البيانات غير متوفرة</h3>
                    <p class="text-slate-500 text-xs font-bold">لم يتم العثور على نتائج تطابق بحثك. حاول تغيير الكلمات المفتاحية.</p>
                </div>
                @endforelse
            </div>

            <div class="mt-12 flex justify-center" dir="ltr">
                {{ $projects->links('vendor.livewire.oneurai-pagination') }}
            </div>
        </div>
    </div>
</div>