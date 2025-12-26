<div class="bg-[#F8FAFC] min-h-screen font-sans selection:bg-emerald-500 selection:text-white" dir="rtl">

    {{-- 1. Header Section: تصميم Hero مع Breadcrumbs --}}
    <div class="bg-white border-b border-slate-200 pt-32 pb-0 relative overflow-hidden">
        {{-- تأثير خلفية ناعم --}}
        <div class="absolute top-0 right-0 w-full h-full bg-gradient-to-b from-emerald-50/20 to-transparent opacity-60 pointer-events-none"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6 mb-8">
                <div>
                    {{-- المسار (Breadcrumbs) بتصميم عالي الجودة --}}
                    <div class="flex items-center gap-2 text-xs font-black text-slate-400 mb-3 bg-slate-50 w-fit px-3 py-1.5 rounded-lg border border-slate-100" dir="ltr">
                        <a href="{{ route('profile.show', $user->username) }}" class="hover:text-emerald-600 transition tracking-tighter">{{ $user->username }}</a>
                        <span class="text-slate-300 font-light">/</span>
                        <span class="text-slate-900 tracking-tight">{{ $dataset->slug }}</span>
                    </div>

                    {{-- العنوان والأيقونة --}}
                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 bg-white rounded-2xl shadow-sm border border-slate-100 flex items-center justify-center text-3xl text-emerald-600 group transition-transform hover:scale-105">
                            <i class="fa-solid fa-database"></i>
                        </div>
                        <h1 class="text-3xl font-black text-slate-900 tracking-tighter">{{ $dataset->title }}</h1>
                    </div>
                </div>

                {{-- أزرار الإجراءات السريعة --}}
                <div class="flex items-center gap-3">
                    <button class="flex items-center gap-2 px-5 py-2.5 bg-white border border-slate-200 text-slate-700 rounded-xl font-black text-xs hover:bg-slate-50 transition shadow-sm active:scale-95 group">
                        <i class="fa-regular fa-heart group-hover:text-rose-500 transition-colors"></i> إعجاب
                    </button>
                    <button class="flex items-center gap-2 px-5 py-2.5 bg-slate-900 text-white rounded-xl font-black text-xs hover:bg-emerald-600 transition shadow-lg shadow-slate-200 active:scale-95">
                        <i class="fa-solid fa-cloud-arrow-down"></i> تحميل المجموعة
                    </button>
                </div>
            </div>

            {{-- التبويبات (Modern Pills Design) --}}
            <div class="flex items-center gap-2 overflow-x-auto no-scrollbar pb-1">
                @php
                    $tabs = [
                        ['id' => 'card', 'label' => 'بطاقة البيانات', 'icon' => 'fa-file-lines'],
                        ['id' => 'files', 'label' => 'الملفات', 'icon' => 'fa-folder-open', 'count' => $dataset->files->count()],
                        ['id' => 'community', 'label' => 'المجتمع', 'icon' => 'fa-comments'],
                    ];
                @endphp
                @foreach($tabs as $tab)
                    <button wire:click="switchTab('{{ $tab['id'] }}')"
                            class="px-6 py-3 rounded-t-2xl text-xs font-black flex items-center gap-2 transition-all duration-300 relative group
                            {{ $activeTab === $tab['id'] ? 'text-emerald-700 border-b-4 border-emerald-500 bg-emerald-50/50' : 'text-slate-500 hover:text-slate-900 hover:bg-slate-50' }}">
                        <i class="fa-solid {{ $tab['icon'] }} opacity-70"></i>
                        {{ $tab['label'] }}
                        @isset($tab['count'])
                            <span class="inline-flex items-center justify-center w-5 h-5 rounded-lg bg-slate-100 text-slate-600 text-[9px] group-hover:bg-white transition-colors">{{ $tab['count'] }}</span>
                        @endisset
                    </button>
                @endforeach
            </div>
        </div>
    </div>

    {{-- منطقة المحتوى --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 relative min-h-[500px]">

        {{-- Loading Overlay --}}
        <div wire:loading.flex class="absolute inset-0 bg-slate-50/60 backdrop-blur-sm z-50 flex items-start justify-center pt-32">
            <div class="bg-white px-6 py-4 rounded-3xl shadow-xl border border-slate-100 flex items-center gap-4 animate-bounce">
                <i class="fa-solid fa-spinner fa-spin text-emerald-500 text-xl"></i>
                <span class="font-black text-slate-800 text-sm tracking-tight">جاري المزامنة...</span>
            </div>
        </div>

        {{-- TAB CONTENT: CARD --}}
        @if($activeTab === 'card')
            <div wire:key="tab-card" class="grid grid-cols-1 lg:grid-cols-12 gap-10 animate-fade-in-up">

                {{-- الوصف الرئيسي --}}
                <div class="lg:col-span-8">
                    <div class="bg-white border border-slate-200 rounded-[2.5rem] p-10 shadow-[0_8px_30px_rgb(0,0,0,0.02)] overflow-hidden">
                        <div class="flex items-center gap-3 mb-8 border-b border-slate-50 pb-6">
                            <div class="w-10 h-10 rounded-xl bg-slate-900 text-white flex items-center justify-center">
                                <i class="fa-solid fa-book-open text-sm"></i>
                            </div>
                            <span class="text-sm font-black text-slate-900 uppercase tracking-widest">README.md</span>
                        </div>
                        <div class="prose prose-slate max-w-none prose-headings:font-black prose-a:text-emerald-600 prose-img:rounded-[2rem] leading-loose text-slate-600 font-medium" dir="auto">
                            {{ $dataset->description ?? 'لا يوجد وصف متاح لهذه المجموعة الاستثنائية.' }}
                        </div>
                    </div>
                </div>

                {{-- الشريط الجانبي (Side Panel) --}}
                <div class="lg:col-span-4 space-y-8">

                    {{-- كرت كود الاستخدام --}}
                    <div class="bg-[#0B1120] rounded-[2rem] p-8 shadow-2xl relative overflow-hidden group border border-white/5">
                        <div class="absolute top-0 right-0 w-24 h-24 bg-emerald-500/10 rounded-full blur-3xl -mr-10 -mt-10"></div>
                        <div class="flex justify-between items-center mb-5 relative z-10">
                            <h3 class="text-white font-black text-xs uppercase tracking-[0.2em] flex items-center gap-2">
                                <i class="fa-brands fa-python text-emerald-400"></i> الاستخدام السريع
                            </h3>
                            <button class="w-8 h-8 rounded-lg bg-white/5 text-slate-400 hover:text-white transition flex items-center justify-center shadow-sm"><i class="fa-regular fa-copy text-xs"></i></button>
                        </div>
                        <div class="font-mono text-[11px] text-emerald-400/90 bg-black/40 p-5 rounded-2xl border border-white/5 relative z-10 leading-relaxed shadow-inner" dir="ltr">
                            <span class="text-slate-500"># تثبيت المكتبة ونوراي</span><br>
                            <span class="text-purple-400">from</span> oneurai <span class="text-purple-400">import</span> load_dataset<br><br>
                            ds = load_dataset(<span class="text-amber-200">"{{ $user->username }}/{{ $dataset->slug }}"</span>)
                        </div>
                    </div>

                    {{-- الإحصائيات --}}
                    <div class="bg-white rounded-[2rem] border border-slate-200 p-8 shadow-sm">
                        <h3 class="font-black text-slate-900 text-xs uppercase tracking-widest mb-6 border-b border-slate-50 pb-4 flex items-center gap-2">
                            <span class="w-1 h-3 bg-emerald-500 rounded-full"></span> تفاصيل البيانات
                        </h3>
                        <div class="space-y-5">
                            <div class="flex justify-between items-center">
                                <span class="text-slate-400 text-[11px] font-black uppercase">التحميلات</span>
                                <span class="text-slate-900 font-mono font-black text-lg">{{ $dataset->formatted_downloads }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-slate-400 text-[11px] font-black uppercase">الحجم الإجمالي</span>
                                <span class="text-slate-900 font-mono font-black text-lg">{{ $dataset->formatted_size }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-slate-400 text-[11px] font-black uppercase">المهمة</span>
                                <span class="bg-emerald-50 text-emerald-700 px-3 py-1 rounded-lg text-[10px] font-black uppercase border border-emerald-100">{{ $dataset->task_type }}</span>
                            </div>
                        </div>
                    </div>

                    {{-- المالك --}}
                    <div class="bg-white rounded-[2rem] border border-slate-200 p-6 shadow-sm flex items-center gap-4 group cursor-pointer hover:border-emerald-500/30 transition-all duration-300">
                        <div class="relative">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=0f172a&color=fff&bold=true" class="w-12 h-12 rounded-2xl shadow-md border-2 border-white group-hover:rotate-6 transition-transform">
                            <span class="absolute -bottom-1 -right-1 w-4 h-4 bg-emerald-500 border-2 border-white rounded-full"></span>
                        </div>
                        <div>
                            <div class="font-black text-slate-900 text-sm flex items-center gap-1">{{ $user->name }} <x-admin-badge :user="$user" /></div>
                            <div class="text-[10px] font-black text-slate-400 uppercase tracking-widest">الناشر المعتمد</div>
                        </div>
                    </div>

                </div>
            </div>
        @endif

        {{-- TAB CONTENT: FILES --}}
        @if($activeTab === 'files')
            <div wire:key="tab-files" class="animate-fade-in-up">
                <div class="bg-white border border-slate-200 rounded-[2.5rem] overflow-hidden shadow-sm">
                    <div class="bg-slate-50 px-8 py-5 border-b border-slate-100 flex justify-between items-center">
                        <div class="font-black text-slate-800 text-sm tracking-tight">مستكشف الملفات</div>
                        <span class="bg-white border border-slate-200 px-3 py-1 rounded-xl text-[10px] font-mono font-bold text-slate-500 uppercase tracking-widest">{{ $dataset->files->count() }} objects</span>
                    </div>

                    <table class="w-full text-right">
                        <thead class="bg-white text-slate-400 text-[10px] font-black uppercase tracking-widest border-b border-slate-50">
                            <tr>
                                <th class="px-8 py-5">اسم الملف</th>
                                <th class="px-8 py-5">الحجم</th>
                                <th class="px-8 py-5 text-left">الإجراء</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50 text-sm text-slate-700">
                            @foreach($dataset->files as $file)
                                <tr class="hover:bg-slate-50 transition group">
                                    <td class="px-8 py-4">
                                        <div class="flex items-center gap-4">
                                            <div class="w-10 h-10 rounded-xl flex items-center justify-center transition-all group-hover:scale-110
                                                {{ in_array($file->extension, ['csv', 'json']) ? 'bg-emerald-50 text-emerald-600' : 'bg-slate-100 text-slate-400' }}">
                                                <i class="fa-solid {{ in_array($file->extension, ['csv', 'json']) ? 'fa-file-csv' : 'fa-file' }} text-lg"></i>
                                            </div>
                                            <span class="font-bold text-slate-800 tracking-tight font-mono truncate max-w-md" dir="ltr">{{ $file->filename }}</span>
                                        </div>
                                    </td>
                                    <td class="px-8 py-4 font-mono text-xs font-bold text-slate-500 uppercase">{{ $file->formatted_size }}</td>
                                    <td class="px-8 py-4 text-left">
                                        <button wire:click="downloadFile({{ $file->id }})" class="w-10 h-10 rounded-xl bg-white border border-slate-200 text-slate-400 hover:text-emerald-600 hover:border-emerald-500 transition-all shadow-sm flex items-center justify-center transform active:scale-90">
                                            <i class="fa-solid fa-download text-sm"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif

        {{-- TAB CONTENT: COMMUNITY --}}
        @if($activeTab === 'community')
            <div wire:key="tab-community" class="py-24 text-center bg-white border border-slate-200 rounded-[3rem] animate-fade-in">
                <div class="w-24 h-24 bg-slate-50 rounded-[2.5rem] flex items-center justify-center mx-auto mb-6 transform rotate-12 border border-dashed border-slate-200 group-hover:rotate-0 transition-transform">
                    <i class="fa-regular fa-comments text-4xl text-slate-200"></i>
                </div>
                <h3 class="text-2xl font-black text-slate-900 tracking-tight mb-2">غرفة النقاش</h3>
                <p class="text-slate-400 font-medium max-w-xs mx-auto">لا توجد مناقشات حالية. كن الأول في طرح استفسار حول هذه البيانات.</p>
                <button class="mt-8 px-8 py-3 bg-slate-900 text-white rounded-2xl font-black text-sm hover:bg-emerald-600 transition-all shadow-lg shadow-slate-200">
                    بدء نقاش جديد
                </button>
            </div>
        @endif

    </div>
    <style>
    .no-scrollbar::-webkit-scrollbar { display: none; }
    .animate-fade-in-up {
        animation: fadeInUp 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards;
    }
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>
</div>


