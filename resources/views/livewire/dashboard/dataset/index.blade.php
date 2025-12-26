<div class="flex h-screen overflow-hidden bg-slate-50/50 text-slate-900 font-sans" dir="rtl">

    <main class="flex-1 flex flex-col h-full overflow-hidden relative">

        {{-- خلفية جمالية خفيفة جداً --}}
        <div class="absolute top-0 left-0 w-full h-96 bg-gradient-to-b from-white to-transparent pointer-events-none -z-10"></div>

        <div class="flex-1 overflow-y-auto p-6 lg:p-10 scroll-smooth">
            <div class="max-w-7xl mx-auto space-y-10">

                {{-- 1. قسم الإحصائيات (Hero Stats) --}}
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="relative bg-white p-6 rounded-3xl border border-slate-100 shadow-[0_8px_30px_rgb(0,0,0,0.04)] group hover:-translate-y-1 transition-all duration-300">
                        <div class="absolute top-0 right-0 w-20 h-20 bg-blue-50 rounded-bl-[100px] -mr-4 -mt-4 opacity-50 group-hover:bg-blue-100 transition"></div>
                        <div class="relative z-10 flex justify-between items-start">
                            <div>
                                <p class="text-xs font-bold text-slate-400 tracking-wider uppercase mb-2">عدد المجموعات</p>
                                <h3 class="text-3xl font-extrabold text-slate-800">{{ $datasets->count() }}</h3>
                            </div>
                            <div class="w-12 h-12 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center text-xl shadow-sm group-hover:scale-110 group-hover:rotate-3 transition duration-300">
                                <i class="fa-solid fa-database"></i>
                            </div>
                        </div>
                    </div>

                    <div class="relative bg-white p-6 rounded-3xl border border-slate-100 shadow-[0_8px_30px_rgb(0,0,0,0.04)] group hover:-translate-y-1 transition-all duration-300">
                        <div class="absolute top-0 right-0 w-20 h-20 bg-emerald-50 rounded-bl-[100px] -mr-4 -mt-4 opacity-50 group-hover:bg-emerald-100 transition"></div>
                        <div class="relative z-10 flex justify-between items-start">
                            <div>
                                <p class="text-xs font-bold text-slate-400 tracking-wider uppercase mb-2">إجمالي التحميلات</p>
                                <h3 class="text-3xl font-extrabold text-slate-800 font-mono">{{ $datasets->sum('downloads_count') }}</h3>
                            </div>
                            <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-xl shadow-sm group-hover:scale-110 group-hover:rotate-3 transition duration-300">
                                <i class="fa-solid fa-download"></i>
                            </div>
                        </div>
                    </div>

                    <div class="relative bg-white p-6 rounded-3xl border border-slate-100 shadow-[0_8px_30px_rgb(0,0,0,0.04)] group hover:-translate-y-1 transition-all duration-300">
                        <div class="absolute top-0 right-0 w-20 h-20 bg-amber-50 rounded-bl-[100px] -mr-4 -mt-4 opacity-50 group-hover:bg-amber-100 transition"></div>
                        <div class="relative z-10 flex justify-between items-start">
                            <div>
                                <p class="text-xs font-bold text-slate-400 tracking-wider uppercase mb-2">المساحة المستخدمة</p>
                                <h3 class="text-3xl font-extrabold text-slate-800 font-mono" dir="ltr">{{ $this->formatted_total_size }}</h3>
                            </div>
                            <div class="w-12 h-12 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center text-xl shadow-sm group-hover:scale-110 group-hover:rotate-3 transition duration-300">
                                <i class="fa-solid fa-hard-drive"></i>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- 2. شريط الأدوات (Toolbar) --}}
                <div class="flex flex-col md:flex-row justify-between items-center gap-4 bg-white p-2 rounded-2xl border border-slate-200 shadow-sm">

                    {{-- البحث --}}
                    <div class="relative w-full md:w-96 group">
                        <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none text-slate-400 group-focus-within:text-emerald-500 transition">
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </div>
                        <input type="text"
                               wire:model.live="search"
                               placeholder="ابحث عن البيانات..."
                               class="w-full bg-transparent border-none text-slate-800 text-sm font-medium rounded-xl py-3 pr-10 pl-4 focus:ring-0 placeholder:text-slate-400">
                    </div>

                    {{-- الفلاتر والأزرار --}}
                    <div class="flex flex-wrap items-center gap-2 w-full md:w-auto p-1">

                        <div class="h-8 w-px bg-slate-200 hidden md:block mx-2"></div>

                        {{-- الفلاتر --}}
                        <div class="flex gap-2">
                            <select wire:model.live="filter_visibility" class="bg-slate-50 hover:bg-slate-100 border-none text-slate-600 text-xs font-bold rounded-xl px-4 py-2.5 focus:ring-0 cursor-pointer transition">
                                <option value="all">الكل</option>
                                <option value="public">عام</option>
                                <option value="private">خاص</option>
                            </select>

                            <select wire:model.live="sort_by" class="bg-slate-50 hover:bg-slate-100 border-none text-slate-600 text-xs font-bold rounded-xl px-4 py-2.5 focus:ring-0 cursor-pointer transition">
                                <option value="latest">الأحدث</option>
                                <option value="downloads">التحميلات</option>
                                <option value="size">الحجم</option>
                            </select>
                        </div>

                        {{-- زر الرفع --}}
                        <a href="{{ route('dashboard.dataset.create') }}"
                           class="bg-slate-900 hover:bg-emerald-600 text-white px-6 py-2.5 rounded-xl text-xs font-bold transition-all shadow-lg hover:shadow-emerald-500/30 flex items-center gap-2 transform active:scale-95 mr-auto md:mr-0">
                            <i class="fa-solid fa-plus"></i>
                            <span>جديد</span>
                        </a>
                    </div>
                </div>

                {{-- 3. قائمة البيانات (Cards List) --}}
                <div class="space-y-4">
                    @forelse($datasets as $dataset)
                        <div class="group relative bg-white rounded-2xl p-5 border border-slate-100 shadow-sm hover:border-emerald-500/30 hover:shadow-[0_8px_30px_rgb(16,185,129,0.06)] transition-all duration-300" wire:key="{{ $dataset->id }}">
                            <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">

                                {{-- المعلومات الأساسية --}}
                                <div class="flex items-start gap-5">
                                    {{-- الأيقونة --}}
                                    <div class="relative shrink-0">
                                        <div class="w-16 h-16 rounded-2xl flex items-center justify-center text-2xl transition-colors duration-300
                                            {{ $dataset->visibility == 'private' ? 'bg-slate-50 text-slate-400 group-hover:bg-slate-100' : 'bg-emerald-50 text-emerald-600 group-hover:bg-emerald-100' }}">
                                            <i class="{{ $dataset->visibility == 'private' ? 'fa-solid fa-lock' : 'fa-solid fa-database' }}"></i>
                                        </div>
                                        @if($dataset->visibility == 'public')
                                            <div class="absolute -top-1 -right-1 w-4 h-4 bg-emerald-500 border-2 border-white rounded-full"></div>
                                        @endif
                                    </div>

                                    <div class="flex-1 min-w-0">
                                        <div class="flex items-center gap-3 mb-1">
                                            <h3 class="text-lg font-bold text-slate-800 group-hover:text-emerald-600 transition truncate" dir="ltr">
                                                <a href="{{ route('dashboard.dataset.show', $dataset->id) }}">
                                                    {{ $dataset->title }}
                                                </a>
                                            </h3>
                                            @if($dataset->visibility == 'private')
                                                <span class="px-2 py-0.5 rounded-md bg-slate-100 text-slate-500 text-[10px] font-bold border border-slate-200">Private</span>
                                            @else
                                                <span class="px-2 py-0.5 rounded-md bg-emerald-50 text-emerald-600 text-[10px] font-bold border border-emerald-100">Public</span>
                                            @endif
                                        </div>

                                        <p class="text-sm text-slate-500 mb-4 line-clamp-1 max-w-2xl leading-relaxed">
                                            {{ $dataset->description ?? 'لا يوجد وصف متاح لهذا المشروع.' }}
                                        </p>

                                        {{-- الاحصائيات المصغرة والوسوم --}}
                                        <div class="flex flex-wrap items-center gap-x-6 gap-y-2 text-xs font-medium text-slate-400">
                                            @if($dataset->task_type)
                                                <span class="flex items-center gap-1.5 text-slate-600 bg-slate-50 px-2 py-1 rounded-lg border border-slate-100">
                                                    <i class="fa-solid fa-tag text-emerald-500"></i> {{ $dataset->task_type }}
                                                </span>
                                            @endif

                                            <span class="flex items-center gap-1.5 hover:text-slate-600 transition">
                                                <i class="fa-solid fa-hard-drive"></i> {{ $dataset->formatted_size }}
                                            </span>
                                            <span class="flex items-center gap-1.5 hover:text-slate-600 transition">
                                                <i class="fa-solid fa-download"></i> {{ $dataset->formatted_downloads }}
                                            </span>
                                            <span class="flex items-center gap-1.5 hover:text-slate-600 transition" title="{{ $dataset->updated_at }}">
                                                <i class="fa-regular fa-clock"></i> {{ $dataset->updated_at->diffForHumans() }}
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                {{-- الأزرار (تظهر بشكل أوضح عند التمرير) --}}
                                <div class="flex items-center gap-2 pt-4 md:pt-0 border-t md:border-t-0 border-slate-50">
                                    <a href="{{ route('dashboard.dataset.show', ['id' => $dataset->id, 'tab' => 'overview']) }}"
                                       class="w-10 h-10 rounded-xl flex items-center justify-center text-slate-400 bg-slate-50 hover:bg-blue-50 hover:text-blue-600 transition-all"
                                       title="تحليل">
                                        <i class="fa-solid fa-chart-simple"></i>
                                    </a>

                                    <a href="{{ route('dashboard.dataset.show', ['id' => $dataset->id, 'tab' => 'settings']) }}"
                                       class="w-10 h-10 rounded-xl flex items-center justify-center text-slate-400 bg-slate-50 hover:bg-slate-200 hover:text-slate-700 transition-all"
                                       title="إعدادات">
                                        <i class="fa-solid fa-gear"></i>
                                    </a>

                                    <a href="{{ route('dashboard.dataset.show', $dataset->id) }}"
                                       class="px-5 py-2.5 rounded-xl bg-slate-900 text-white text-xs font-bold hover:bg-emerald-600 transition-colors shadow-md shadow-slate-200 ml-2">
                                        عرض التفاصيل
                                    </a>
                                </div>
                            </div>
                        </div>
                    @empty
                        {{-- حالة الفراغ --}}
                        <div class="flex flex-col items-center justify-center py-20 bg-white rounded-3xl border border-dashed border-slate-200 text-center animate-fade-in-up">
                            <div class="w-24 h-24 bg-slate-50 rounded-full flex items-center justify-center mb-6">
                                <i class="fa-solid fa-database text-4xl text-slate-300"></i>
                            </div>
                            <h3 class="text-xl font-extrabold text-slate-900 mb-2">لا توجد بيانات حالياً</h3>
                            <p class="text-slate-500 max-w-sm mx-auto mb-8">لم تقم برفع أي مجموعات بيانات حتى الآن، ابدأ برفع أول مجموعة لك.</p>
                            <a href="{{ route('dashboard.dataset.create') }}" class="bg-emerald-600 hover:bg-emerald-700 text-white px-8 py-3 rounded-xl font-bold shadow-lg shadow-emerald-500/20 transition transform hover:-translate-y-1">
                                <i class="fa-solid fa-cloud-arrow-up ml-2"></i> رفع بيانات جديدة
                            </a>
                        </div>
                    @endforelse
                </div>

                {{-- Pagination --}}
                <div class="mt-8">
                     {{-- {{ $datasets->links() }} --}}
                </div>

            </div>
        </div>
    </main>
</div>
