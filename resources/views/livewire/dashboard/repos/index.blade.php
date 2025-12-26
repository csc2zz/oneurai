<div class="animate-fade-in space-y-8">

    {{-- 1. الهيدر: العنوان وزر الإضافة --}}
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-6">
        <div>
            <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight mb-2">
                المستودعات البرمجية
            </h1>
            <p class="text-slate-500">
                لديك <span class="font-bold text-emerald-600 font-sans mx-1">{{ $repos->count() }}</span> مشروع تقني. العالم بانتظار إبداعك القادم! 🚀
            </p>
        </div>

        <a href="{{ route('projects.create') }}" class="group bg-slate-900 hover:bg-emerald-600 text-white px-6 py-3 rounded-xl text-sm font-bold transition-all duration-300 shadow-lg hover:shadow-emerald-500/30 flex items-center gap-2">
            <span class="bg-white/10 group-hover:bg-white/20 p-1 rounded-lg transition">
                <i class="fa-solid fa-plus text-xs"></i>
            </span>
            <span>مشروع جديد</span>
        </a>
    </div>

    {{-- 2. شريط التحكم: البحث والفلتر --}}
    <div class="bg-white border border-slate-200 rounded-2xl p-2 shadow-sm flex flex-col md:flex-row gap-2">
        {{-- البحث --}}
        <div class="relative flex-1">
            <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none text-slate-400 group-focus-within:text-emerald-500 transition-colors">
                <i class="fa-solid fa-magnifying-glass"></i>
            </div>
            <input
                wire:model.live.debounce.300ms="search"
                type="text"
                placeholder="ابحث عن مستودع..."
                class="w-full bg-slate-50 hover:bg-white focus:bg-white border border-transparent focus:border-emerald-500 rounded-xl py-3 pr-11 pl-4 text-sm outline-none transition-all duration-300 placeholder:text-slate-400 font-medium"
            >
        </div>

        {{-- الفلتر --}}
        <div class="relative min-w-[180px]">
            <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none text-slate-400">
                <i class="fa-solid fa-filter"></i>
            </div>
            <select class="w-full appearance-none bg-slate-50 hover:bg-white focus:bg-white border border-transparent focus:border-emerald-500 rounded-xl py-3 pr-11 pl-4 text-sm text-slate-600 font-bold outline-none transition-all cursor-pointer">
                <option>كل الأنواع</option>
                <option>عام (Public)</option>
                <option>خاص (Private)</option>
            </select>
            <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none text-slate-400">
                <i class="fa-solid fa-chevron-down text-xs"></i>
            </div>
        </div>
    </div>

    {{-- 3. شبكة المستودعات --}}
    <div class="grid grid-cols-1 gap-4">
        @forelse($repos as $repo)
            <div class="group bg-white border border-slate-200 rounded-2xl p-6 hover:border-emerald-500/30 hover:shadow-[0_8px_30px_rgb(0,0,0,0.06)] hover:-translate-y-1 transition-all duration-300 relative overflow-hidden">

                {{-- شريط جانبي ملون --}}
                <div class="absolute top-0 right-0 w-1 h-full bg-slate-100 group-hover:bg-emerald-500 transition-colors duration-300"></div>

                <div class="flex flex-col md:flex-row gap-6 pr-3">
                    {{-- الأيقونة --}}
                    <div class="shrink-0">
                        <div class="w-14 h-14 rounded-2xl bg-slate-50 text-slate-400 group-hover:bg-emerald-50 group-hover:text-emerald-600 flex items-center justify-center transition-colors duration-300 border border-slate-100 group-hover:border-emerald-100">
                            <i class="fa-solid fa-code-branch text-2xl"></i>
                        </div>
                    </div>

                    {{-- المحتوى --}}
                    <div class="flex-1 min-w-0">
                        <div class="flex flex-wrap items-center justify-between gap-3 mb-2">
                            <div class="flex items-center gap-3">
                                <a href="{{ route('projects.show', ['username' => Auth::user()->username, 'slug' => $repo->slug]) }}" class="text-lg font-extrabold text-slate-900 group-hover:text-emerald-600 transition-colors tracking-tight" dir="ltr">
                                    {{ $repo->title }}
                                </a>
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold border flex items-center gap-1 uppercase tracking-wider
                                    {{ $repo->is_public
                                        ? 'bg-emerald-50 text-emerald-700 border-emerald-100'
                                        : 'bg-amber-50 text-amber-700 border-amber-100' }}">
                                    @if($repo->is_public)
                                        <i class="fa-solid fa-globe"></i> Public
                                    @else
                                        <i class="fa-solid fa-lock"></i> Private
                                    @endif
                                </span>
                            </div>

                            {{-- زر التعديل --}}
                            <a href="{{ route('projects.show', ['username' => Auth::user()->username, 'slug' => $repo->slug]) }}" class="opacity-0 group-hover:opacity-100 text-slate-400 hover:text-emerald-600 bg-slate-50 hover:bg-emerald-50 px-3 py-1.5 rounded-lg text-xs font-bold transition-all transform translate-x-2 group-hover:translate-x-0">
                                <i class="fa-solid fa-pen-to-square"></i> تعديل
                            </a>
                        </div>

                        <p class="text-slate-500 text-sm leading-relaxed mb-5 line-clamp-2 max-w-3xl">
                            {{ $repo->description ?? 'لا يوجد وصف متاح لهذا المستودع حالياً.' }}
                        </p>

                        {{-- الفوتر: المعلومات الإضافية --}}
                        <div class="flex items-center gap-6 text-xs text-slate-400 font-medium border-t border-dashed border-slate-100 pt-4">
                            @if($repo->language)
                                <div class="flex items-center gap-2 text-slate-600 bg-slate-50 px-2 py-1 rounded-md">
                                    <span class="w-2 h-2 rounded-full bg-indigo-500 shadow-[0_0_8px_rgba(99,102,241,0.5)]"></span>
                                    <span>{{ $repo->language }}</span>
                                </div>
                            @endif

                            <div class="flex items-center gap-1.5 hover:text-amber-500 transition cursor-help" title="النجوم">
                                <i class="fa-solid fa-star text-amber-400"></i>
                                <span class="font-sans font-bold">{{ $repo->stars_count }}</span>
                            </div>

                            <div class="flex items-center gap-1.5" title="آخر تحديث">
                                <i class="fa-regular fa-clock"></i>
                                <span>{{ $repo->updated_at->diffForHumans() }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            {{-- حالة الفراغ --}}
            <div class="flex flex-col items-center justify-center py-16 bg-white border-2 border-dashed border-slate-200 rounded-2xl group hover:border-emerald-300 hover:bg-emerald-50/10 transition-colors duration-300">
                <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mb-4 shadow-sm text-slate-300 group-hover:text-emerald-500 group-hover:scale-110 transition duration-300">
                    <i class="fa-solid fa-box-open text-4xl"></i>
                </div>
                <h3 class="text-lg font-bold text-slate-900 mb-1">المستودع فارغ!</h3>
                <p class="text-slate-500 text-sm mb-6 text-center max-w-xs">
                    لم نتمكن من العثور على أي مشاريع. ابدأ رحلتك البرمجية الآن وأنشئ أول مستودع لك.
                </p>
                @if($search)
                    <button wire:click="$set('search', '')" class="text-emerald-600 font-bold hover:underline text-sm">
                        مسح البحث والعودة
                    </button>
                @else
                    <a href="{{ route('projects.create') }}" class="bg-emerald-600 text-white px-6 py-2.5 rounded-xl font-bold text-sm hover:bg-emerald-700 hover:shadow-lg transition">
                        <i class="fa-solid fa-plus ml-1"></i> إنشاء أول مشروع
                    </a>
                @endif
            </div>
        @endforelse
    </div>

    {{-- ترقيم الصفحات (إن وجد) --}}
    @if(method_exists($repos, 'links'))
        <div class="mt-8">
            {{ $repos->links() }}
        </div>
    @endif
</div>
