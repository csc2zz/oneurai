<div x-data="{ open: @entangle('showSearch') }" 
     @keydown.window.prevent.slash="open = true"
     @keydown.escape.window="open = false"
     x-show="open" 
     class="fixed inset-0 z-[60] overflow-y-auto p-4 md:p-20" 
     x-cloak>
    
    {{-- الخلفية الضبابية (Backdrop) --}}
    <div x-show="open" 
         x-transition:enter="transition opacity-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         class="fixed inset-0 bg-slate-900/60 backdrop-blur-md" 
         @click="open = false"></div>

    {{-- صندوق البحث (Spotlight Box) --}}
    <div x-show="open" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 scale-95 translate-y-4"
         x-transition:enter-end="opacity-100 scale-100 translate-y-0"
         class="relative mx-auto max-w-3xl transform divide-y divide-slate-100 overflow-hidden rounded-[2.5rem] bg-white shadow-2xl transition-all border border-white/20">
        
        {{-- حقل الإدخال العلوي --}}
        <div class="relative group">
            <i class="fa-solid fa-magnifying-glass absolute right-8 top-1/2 -translate-y-1/2 text-emerald-500 text-xl group-focus-within:scale-110 transition-transform"></i>
            
            <input type="text" 
                   wire:model.live.debounce.300ms="search"
                   wire:keydown.enter="goToSearchPage"
                   class="h-24 w-full border-0 bg-transparent pr-20 pl-28 text-slate-900 placeholder:text-slate-400 focus:ring-0 text-lg font-black outline-none" 
                   placeholder="ابحث عن كود، نموذج AI، بيانات، أو مطور..." 
                   autofocus>
            
            {{-- مؤشر التحميل (Loading Spinner) --}}
            <div wire:loading wire:target="search" class="absolute left-20 top-1/2 -translate-y-1/2">
                <i class="fa-solid fa-circle-notch fa-spin text-emerald-500"></i>
            </div>

            {{-- زر البحث السريع --}}
            <button wire:click="goToSearchPage" 
                    class="absolute left-6 top-1/2 -translate-y-1/2 bg-slate-900 hover:bg-emerald-600 text-white px-5 py-2.5 rounded-xl text-xs font-black shadow-lg transition-all active:scale-95">
                بحث
            </button>
        </div>

        @if(strlen($search) >= 2)
            <div class="max-h-[65vh] overflow-y-auto p-6 space-y-8 custom-scrollbar bg-slate-50/30">
                
                {{-- 1. نتائج نماذج الذكاء الاصطناعي (AI Models) --}}
                @if($results['models']->count() > 0)
                <section>
                    <h3 class="text-[11px] font-black text-slate-400 uppercase tracking-[0.2em] mb-4 flex items-center gap-2 px-2">
                        <i class="fa-solid fa-brain text-emerald-500"></i> نماذج الذكاء الاصطناعي
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                        @foreach($results['models'] as $model)
                        <a href="{{ route('models.show', [$model->user->username, $model->slug]) }}" 
                           class="flex items-center gap-4 p-3 rounded-2xl bg-white border border-slate-100 hover:border-emerald-500 hover:shadow-xl transition-all group">
                            <div class="w-11 h-11 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-lg group-hover:bg-emerald-600 group-hover:text-white transition-all">
                                <i class="fa-solid fa-robot"></i>
                            </div>
                            <div class="min-w-0">
                                <p class="text-sm font-black text-slate-800 truncate">{{ $model->title }}</p>
                                <p class="text-[10px] text-slate-400 font-bold">@ {{ $model->user->username }}</p>
                            </div>
                        </a>
                        @endforeach
                    </div>
                </section>
                @endif

                {{-- 2. نتائج الداتا سيت (Datasets) --}}
                @if($results['datasets']->count() > 0)
                <section>
                    <h3 class="text-[11px] font-black text-slate-400 uppercase tracking-[0.2em] mb-4 flex items-center gap-2 px-2">
                        <i class="fa-solid fa-database text-cyan-500"></i> مجموعات البيانات
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                        @foreach($results['datasets'] as $dataset)
                        <a href="{{ route('datasets.public.show', [$dataset->user->username, $dataset->slug]) }}" 
                           class="flex items-center gap-4 p-3 rounded-2xl bg-white border border-slate-100 hover:border-cyan-500 hover:shadow-xl transition-all group">
                            <div class="w-11 h-11 rounded-xl bg-cyan-50 text-cyan-600 flex items-center justify-center text-lg group-hover:bg-cyan-600 group-hover:text-white transition-all">
                                <i class="fa-solid fa-table-list"></i>
                            </div>
                            <div class="min-w-0">
                                <p class="text-sm font-black text-slate-800 truncate">{{ $dataset->title }}</p>
                                <p class="text-[10px] text-slate-400 font-bold">Data Hub</p>
                            </div>
                        </a>
                        @endforeach
                    </div>
                </section>
                @endif

                {{-- 3. نتائج المستودعات (Projects) --}}
                @if($results['projects']->count() > 0)
                <section>
                    <h3 class="text-[11px] font-black text-slate-400 uppercase tracking-[0.2em] mb-4 flex items-center gap-2 px-2">
                        <i class="fa-solid fa-code-branch text-blue-500"></i> المستودعات والأكواد
                    </h3>
                    <div class="space-y-2">
                        @foreach($results['projects'] as $project)
                        <a href="{{ route('projects.show', [$project->user->username, $project->slug]) }}" 
                           class="flex items-center justify-between p-4 rounded-2xl bg-white border border-slate-100 hover:bg-blue-50/50 transition-all border-r-4 border-r-transparent hover:border-r-blue-500">
                            <div class="flex items-center gap-4">
                                <i class="fa-solid fa-cube text-slate-300"></i>
                                <span class="text-sm font-bold text-slate-700">{{ $project->title }}</span>
                            </div>
                            <i class="fa-solid fa-chevron-left text-slate-200 text-[10px]"></i>
                        </a>
                        @endforeach
                    </div>
                </section>
                @endif

                {{-- 4. نتائج المطورين (Users) --}}
                @if($results['users']->count() > 0)
                <section>
                    <h3 class="text-[11px] font-black text-slate-400 uppercase tracking-[0.2em] mb-4 flex items-center gap-2 px-2">
                        <i class="fa-solid fa-users text-purple-500"></i> المبدعين
                    </h3>
                    <div class="flex flex-wrap gap-3">
                        @foreach($results['users'] as $user)
                        <a href="{{ route('profile.show', $user->username) }}" 
                           class="flex items-center gap-3 px-4 py-2 bg-white border border-slate-200 rounded-full hover:border-emerald-500 transition-all group shadow-sm">
                            <img src="{{ $user->avatar_url ?? 'https://ui-avatars.com/api/?name='.urlencode($user->name) }}" class="w-7 h-7 rounded-full object-cover border border-slate-100">
                            <span class="text-xs font-black text-slate-700 group-hover:text-emerald-600 transition-colors">{{ $user->name }}</span>
                        </a>
                        @endforeach
                    </div>
                </section>
                @endif

                {{-- حالة عدم وجود نتائج --}}
                @if(collect($results)->flatten()->isEmpty())
                    <div class="py-20 text-center space-y-4">
                        <div class="w-20 h-20 bg-slate-100 rounded-full flex items-center justify-center mx-auto text-slate-300 text-3xl">
                            <i class="fa-solid fa-magnifying-glass-chart"></i>
                        </div>
                        <p class="text-slate-500 font-bold">لم نجد أي تطابق لـ "{{ $search }}" في Oneurai</p>
                    </div>
                @endif

                {{-- زر الانتقال لصفحة البحث الشاملة --}}
                <div class="pt-4">
                    <button wire:click="goToSearchPage" 
                            class="w-full py-4 bg-slate-900 text-white rounded-2xl text-sm font-black hover:bg-emerald-600 transition-all shadow-xl shadow-slate-200 flex items-center justify-center gap-3 group">
                        <span>عرض كافة النتائج في صفحة مستقلة</span>
                        <i class="fa-solid fa-arrow-left group-hover:-translate-x-1 transition-transform"></i>
                    </button>
                </div>
            </div>
        @else
            {{-- الحالة الافتراضية عند فتح المودال --}}
            <div class="p-12 text-center">
                <div class="w-16 h-16 bg-emerald-50 text-emerald-500 rounded-2xl flex items-center justify-center mx-auto mb-6">
                    <i class="fa-solid fa-bolt-lightning text-2xl"></i>
                </div>
                <p class="text-sm font-black text-slate-800 mb-2">البحث الذكي من Oneurai</p>
                <p class="text-xs text-slate-400 max-w-xs mx-auto leading-relaxed">اكتب اسم المشروع، نوع النموذج، أو اسم المطور للوصول السريع.</p>
                
                <div class="mt-8 flex flex-wrap justify-center gap-2">
                    <span class="px-3 py-1.5 bg-slate-50 rounded-lg text-[10px] font-bold text-slate-500 border border-slate-100"># نماذج_عربية</span>
                    <span class="px-3 py-1.5 bg-slate-50 rounded-lg text-[10px] font-bold text-slate-500 border border-slate-100"># مستودعات_AI</span>
                </div>
            </div>
        @endif

        {{-- فوتر المودال (التعليمات) --}}
        <div class="bg-slate-900 px-8 py-4 flex items-center justify-between text-[10px] font-black text-white/40 uppercase tracking-widest">
            <div class="flex gap-6">
                <span class="flex items-center gap-2"><kbd class="bg-white/10 px-1.5 py-0.5 rounded text-white">ESC</kbd> للإغلاق</span>
                <span class="flex items-center gap-2"><kbd class="bg-white/10 px-1.5 py-0.5 rounded text-white">ENTER</kbd> للبحث الشامل</span>
            </div>
            <div class="flex items-center gap-2 text-emerald-400/80">
                <i class="fa-solid fa-shield-halved"></i> Oneurai Secure Search
            </div>
        </div>
    </div><style>
    /* منع ظهور الفراغ الأبيض قبل تحميل Alpine.js */
    [x-cloak] { display: none !important; }
    
    /* سكرول بار ناعم يتناسب مع التصميم */
    .custom-scrollbar::-webkit-scrollbar { width: 5px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: #e2e8f0; border-radius: 10px; }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #10b981; }
</style>
</div>

