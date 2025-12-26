<div class="animate-fade-in space-y-8">

    {{-- 1. الهيدر المطور --}}
    <div class="relative bg-white border border-slate-100 rounded-2xl p-6 sm:p-10 shadow-[0_8px_30px_rgb(0,0,0,0.04)] overflow-hidden group">
        <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-emerald-500 via-teal-500 to-emerald-500"></div>
        <div class="absolute -right-10 -top-10 w-64 h-64 bg-emerald-50 rounded-full blur-3xl opacity-50 group-hover:opacity-100 transition duration-1000"></div>

        <div class="relative z-10 flex flex-col md:flex-row md:items-end justify-between gap-6">
            <div>
                <div class="flex items-center gap-2 text-emerald-600 font-bold text-xs uppercase tracking-wider mb-2">
                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                    لوحة التحكم
                </div>
                <h1 class="text-3xl md:text-4xl font-extrabold text-slate-900 mb-2" x-data="{ greeting: new Date().getHours() < 12 ? 'صباح الخير' : 'مساء الخير' }">
                    <span x-text="greeting" class="text-emerald-500 font-bold"></span>،
                    <span class="bg-clip-text text-transparent bg-gradient-to-r from-slate-900 to-slate-700">{{ Auth::user()->name }}</span>
                    <span class="inline-block transform hover:rotate-12 transition-transform cursor-default">👋</span>
                </h1>
                <p class="text-slate-500 max-w-lg leading-relaxed">أهلاً بك مجدداً في مركز قيادة إبداعك. إليك نظرة سريعة على أداء مساهماتك وتأثيرك.</p>
            </div>

            <div class="flex gap-4">
                <div class="bg-white/80 backdrop-blur-sm p-4 rounded-xl border border-slate-200 shadow-sm hover:shadow-md hover:-translate-y-1 transition duration-300 min-w-[140px] relative overflow-hidden group/card">
                    <i class="fa-solid fa-star absolute -left-4 -bottom-4 text-5xl text-amber-500/10 group-hover/card:text-amber-500/20 transition-colors"></i>
                    <div class="flex items-center gap-3 mb-1">
                        <div class="w-8 h-8 rounded-lg bg-amber-100 text-amber-600 flex items-center justify-center text-sm shadow-inner"><i class="fa-solid fa-star"></i></div>
                        <span class="text-[10px] text-slate-400 font-bold uppercase tracking-widest">النجوم</span>
                    </div>
                    <div class="text-2xl font-black text-slate-900 font-sans mt-2">{{ number_format($stats['total_stars']) }}</div>
                </div>

                <div class="bg-white/80 backdrop-blur-sm p-4 rounded-xl border border-slate-200 shadow-sm hover:shadow-md hover:-translate-y-1 transition duration-300 min-w-[140px] relative overflow-hidden group/card">
                    <i class="fa-solid fa-layer-group absolute -left-4 -bottom-4 text-5xl text-emerald-500/10 group-hover/card:text-emerald-500/20 transition-colors"></i>
                    <div class="flex items-center gap-3 mb-1">
                        <div class="w-8 h-8 rounded-lg bg-emerald-100 text-emerald-600 flex items-center justify-center text-sm shadow-inner"><i class="fa-solid fa-code-branch"></i></div>
                        <span class="text-[10px] text-slate-400 font-bold uppercase tracking-widest">المساهمات</span>
                    </div>
                    <div class="text-2xl font-black text-slate-900 font-sans mt-2">{{ number_format($stats['total_items']) }}</div>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">

        {{-- العمود الأيمن (الرئيسي) - يشغل 2/3 من المساحة --}}
        <div class="lg:col-span-2 space-y-8">

            {{-- 2. المستودعات المثبتة --}}
            <section>
                <div class="flex justify-between items-end mb-6">
                    <div>
                        <h2 class="text-xl font-bold text-slate-900 flex items-center gap-2"><i class="fa-solid fa-thumbtack text-emerald-500"></i> المستودعات المثبتة</h2>
                        <p class="text-xs text-slate-400 mt-1">أهم المشاريع التي تعمل عليها حالياً</p>
                    </div>
                    <a href="{{ route('dashboard.repos') }}" class="group text-xs font-bold text-slate-500 hover:text-emerald-600 transition flex items-center gap-1 bg-slate-50 hover:bg-white px-3 py-1.5 rounded-full border border-slate-200">
                        عرض الكل <i class="fa-solid fa-arrow-left group-hover:-translate-x-1 transition-transform text-[10px]"></i>
                    </a>
                </div>

                <div class="grid md:grid-cols-2 gap-5">
                    @forelse($pinnedProjects as $project)
                        <a href="{{ route('projects.show', ['username' => $project->user->username, 'slug' => $project->slug]) }}" class="group h-full">
                            <div class="bg-white border border-slate-200 rounded-2xl p-6 hover:border-emerald-500/50 hover:shadow-lg hover:-translate-y-1 transition-all duration-300 h-full flex flex-col relative overflow-hidden">
                                <div class="absolute top-0 left-0 w-1 h-full bg-slate-100 group-hover:bg-emerald-500 transition-colors"></div>
                                <div class="flex items-center gap-3 mb-3">
                                    <div class="w-10 h-10 rounded-xl bg-slate-50 text-slate-400 group-hover:bg-emerald-50 group-hover:text-emerald-600 flex items-center justify-center transition-colors shadow-sm"><i class="fa-solid fa-book-bookmark text-lg"></i></div>
                                    <h3 class="font-bold text-slate-900 text-sm truncate group-hover:text-emerald-700 transition-colors">{{ $project->title }}</h3>
                                </div>
                                <p class="text-slate-500 text-xs mb-4 line-clamp-2 leading-relaxed">{{ $project->description ?? 'لا يوجد وصف.' }}</p>
                                <div class="flex items-center justify-between text-[10px] text-slate-400 mt-auto pt-3 border-t border-dashed border-slate-100">
                                    <span class="flex items-center gap-1"><i class="fa-solid fa-star text-amber-400"></i> {{ $project->stars_count }}</span>
                                    <span>{{ $project->updated_at->diffForHumans() }}</span>
                                </div>
                            </div>
                        </a>
                    @empty
                        <div class="col-span-2 py-10 bg-slate-50 border-2 border-dashed border-slate-200 rounded-2xl text-center">
                            <p class="text-slate-400 text-sm italic">لا توجد مشاريع مثبتة بعد.</p>
                        </div>
                    @endforelse
                </div>
            </section>

            {{-- 3. سجل النشاطات (Timeline) --}}
            <section>
                <div class="flex items-center gap-3 mb-6">
                    <div class="p-2 bg-amber-50 text-amber-500 rounded-lg">
                        <i class="fa-solid fa-bolt"></i>
                    </div>
                    <div>
                        <h2 class="font-bold text-slate-900">سجل النشاطات الحديثة</h2>
                        <p class="text-xs text-slate-400">آخر التحديثات والإجراءات التي قمت بها</p>
                    </div>
                </div>

                <div class="relative pl-4 sm:pl-0">
                    {{-- خط الزمن العمودي --}}
                    <div class="absolute right-[21px] top-4 bottom-4 w-0.5 bg-gradient-to-b from-slate-200 via-slate-100 to-transparent hidden sm:block"></div>

                    <div class="space-y-4">
                        @forelse($activities as $activity)
                            <div class="relative flex gap-4 group">
                                {{-- الأيقونة --}}
                                <div class="relative z-10 w-11 h-11 rounded-full flex items-center justify-center border-[3px] border-white shadow-sm shrink-0 transition-transform duration-300 group-hover:scale-110
                                    {{ $activity['type'] == 'repo' ? 'bg-gradient-to-br from-blue-50 to-blue-100 text-blue-600' : 'bg-gradient-to-br from-purple-50 to-purple-100 text-purple-600' }}">
                                    <i class="{{ $activity['type'] == 'repo' ? 'fa-solid fa-code-branch' : 'fa-solid fa-brain' }}"></i>
                                </div>

                                {{-- المحتوى --}}
                                <div class="flex-1 bg-white border border-slate-200 rounded-xl p-4 hover:border-slate-300 hover:shadow-sm transition-all relative">
                                    {{-- مثلث صغير --}}
                                    <div class="absolute top-3.5 -right-[7px] w-3 h-3 bg-white border-t border-l border-slate-200 rotate-45 hidden sm:block"></div>

                                    <div class="flex justify-between items-start mb-1">
                                        <div class="text-sm text-slate-800 font-medium">
                                            @if($activity['type'] == 'repo')
                                                أنشأت مستودعاً جديداً <a href="{{ route('projects.show', ['username' => Auth::user()->username, 'slug' => $activity['data']->slug]) }}" class="font-bold text-blue-600 hover:underline mx-1" dir="ltr">{{ $activity['data']->title }}</a>
                                            @else
                                                أطلقت نموذج ذكاء اصطناعي <a href="{{ route('models.show', ['username' => Auth::user()->username, 'slug' => $activity['data']->slug]) }}" class="font-bold text-purple-600 hover:underline mx-1" dir="ltr">{{ $activity['data']->title }}</a>
                                            @endif
                                        </div>
                                        <span class="text-[10px] text-slate-400 bg-slate-50 px-2 py-1 rounded-full font-sans whitespace-nowrap border border-slate-100">
                                            {{ $activity['created_at']->diffForHumans(null, true, true) }}
                                        </span>
                                    </div>
                                    <p class="text-xs text-slate-500 mt-1 flex items-center gap-2">
                                        <span class="w-1.5 h-1.5 rounded-full {{ $activity['type'] == 'repo' ? 'bg-blue-400' : 'bg-purple-400' }}"></span>
                                        {{ $activity['type'] == 'repo' ? ($activity['data']->description ?? 'مشروع برمجي جديد') : 'Framework: ' . $activity['data']->framework }}
                                    </p>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-10 bg-slate-50 rounded-xl border border-dashed border-slate-200">
                                <p class="text-slate-400 text-sm">السكون يعم المكان... لا توجد نشاطات حديثة.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </section>
        </div>

        {{-- العمود الأيسر (الجانبي) - يشغل 1/3 من المساحة --}}
        <div class="space-y-6 lg:sticky lg:top-6">
            
            {{-- 4. مشاريع صاعدة --}}
            <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm">
                <h3 class="font-bold text-slate-900 text-sm flex items-center gap-2 mb-6">
                    <span class="w-8 h-8 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center"><i class="fa-solid fa-arrow-trend-up"></i></span>
                    مشاريع صاعدة
                </h3>

                <div class="space-y-5">
                    @forelse($trendingProjects as $trend)
                        <div class="group flex gap-3 items-center">
                            <img src="{{ $trend->user->avatar ? asset('storage/' . $trend->user->avatar) : 'https://ui-avatars.com/api/?name='.$trend->user->name }}" class="rounded-xl w-10 h-10 object-cover shadow-sm">
                            <div class="flex-1 min-w-0">
                                <a href="{{ route('project.showing', ['username' => $trend->user->username, 'slug' => $trend->slug]) }}" class="font-bold text-slate-900 hover:text-emerald-600 transition text-sm block truncate">{{ $trend->title }}</a>
                                <span class="text-[10px] text-slate-500">بواسطة {{ $trend->user->name }}</span>
                            </div>
                            <div class="text-[10px] text-amber-500 font-bold bg-amber-50 px-2 py-1 rounded-lg"><i class="fa-solid fa-star text-[8px]"></i> {{ $trend->stars_count }}</div>
                        </div>
                    @empty
                        <p class="text-xs text-slate-400 text-center">جاري البحث...</p>
                    @endforelse
                </div>
                <a href="{{ route('explore') }}" class="mt-6 w-full py-2.5 rounded-xl border border-emerald-100 bg-emerald-50/50 text-emerald-700 text-xs font-bold hover:bg-emerald-100 transition flex items-center justify-center gap-2 group">
                    استكشف المزيد <i class="fa-solid fa-arrow-left group-hover:-translate-x-1 transition-transform"></i>
                </a>
            </div>

            {{-- 5. الإجراءات السريعة (موقعها الجديد تحت الصاعدة) --}}
            <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm">
                <div class="flex items-center gap-2 mb-6 text-slate-900">
                    <div class="w-8 h-8 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center"><i class="fa-solid fa-bolt-lightning text-sm"></i></div>
                    <h3 class="font-bold text-sm tracking-tight">إجراءات سريعة</h3>
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <a href="{{ route('dashboard.tickets.create') }}" class="group flex flex-col items-center p-4 rounded-2xl bg-slate-50 hover:bg-emerald-50 border border-transparent hover:border-emerald-100 transition-all">
                        <div class="w-8 h-8 rounded-full bg-white shadow-sm flex items-center justify-center text-slate-400 group-hover:text-emerald-600"><i class="fa-solid fa-headset text-xs"></i></div>
                        <span class="text-[9px] font-bold text-slate-600 mt-2">طلب دعم</span>
                    </a>
                    <a href="{{ route('dashboard.help') }}" class="group flex flex-col items-center p-4 rounded-2xl bg-slate-50 hover:bg-blue-50 border border-transparent hover:border-blue-100 transition-all">
                        <div class="w-8 h-8 rounded-full bg-white shadow-sm flex items-center justify-center text-slate-400 group-hover:text-blue-600"><i class="fa-solid fa-circle-info text-xs"></i></div>
                        <span class="text-[9px] font-bold text-slate-600 mt-2">المساعدة</span>
                    </a>
                    <a href="{{ route('dashboard.chat') }}" class="group flex flex-col items-center p-4 rounded-2xl bg-slate-50 hover:bg-purple-50 border border-transparent hover:border-purple-100 transition-all">
                        <div class="w-8 h-8 rounded-full bg-white shadow-sm flex items-center justify-center text-slate-400 group-hover:text-purple-600"><i class="fa-solid fa-comments text-xs"></i></div>
                        <span class="text-[9px] font-bold text-slate-600 mt-2">محادثات</span>
                    </a>
                    <a href="{{ route('dashboard.profile') }}" class="group flex flex-col items-center p-4 rounded-2xl bg-slate-50 hover:bg-amber-50 border border-transparent hover:border-amber-100 transition-all">
                        <div class="w-8 h-8 rounded-full bg-white shadow-sm flex items-center justify-center text-slate-400 group-hover:text-amber-600"><i class="fa-solid fa-user-gear text-xs"></i></div>
                        <span class="text-[9px] font-bold text-slate-600 mt-2">إعدادات</span>
                    </a>
                </div>

                <div class="mt-6 p-4 rounded-xl bg-slate-900 relative overflow-hidden group/tip">
                    <p class="text-[9px] font-bold text-emerald-400 uppercase mb-1">نصيحة Oneurai</p>
                    <p class="text-[10px] text-slate-300 leading-relaxed relative z-10">حدث مستودعاتك باستمرار لتصدر قائمة المشاريع الصاعدة.</p>
                </div>
            </div>

        </div>
    </div>
</div>