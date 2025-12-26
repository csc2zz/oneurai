<x-layouts.model-layout :model="$model" :author="$author" active-tab="files">
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 animate-fade-in-up">

        {{-- 1. المنطقة الرئيسية: مستعرض الملفات الفاخر (9 أعمدة) --}}
        <div class="lg:col-span-9 space-y-6">

            {{-- شريط التحكم العلوي --}}
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                <div class="flex items-center gap-3">
                    <div class="inline-flex items-center gap-2 bg-white border border-slate-200 px-4 py-2 rounded-xl text-sm font-black shadow-sm transition-all hover:bg-slate-50 cursor-pointer group" dir="ltr">
                        <i class="fa-solid fa-code-branch text-emerald-500 transition-transform group-hover:rotate-12"></i>
                        <span class="font-mono">main</span>
                        <i class="fa-solid fa-chevron-down text-[10px] opacity-30"></i>
                    </div>
                    <div class="h-4 w-px bg-slate-200 hidden sm:block"></div>
                    <nav class="flex items-center text-xs font-bold text-slate-400 font-mono tracking-tighter" dir="ltr">
                        <a href="#" class="hover:text-emerald-600 transition">{{ $model->slug }}</a>
                        <span class="mx-1 opacity-30">/</span>
                        <span class="text-slate-800">Files</span>
                    </nav>
                </div>

                <div class="flex items-center gap-2 w-full sm:w-auto">
                    <button class="flex-1 sm:flex-none text-slate-500 hover:text-slate-900 text-xs font-black px-4 py-2 rounded-xl hover:bg-slate-100 transition uppercase tracking-widest">History</button>
                    @if(auth()->id() === $author->id)
                        <a href="{{ route('dashboard.models.upload') }}" class="flex-1 sm:flex-none bg-slate-900 text-white px-5 py-2.5 rounded-xl text-xs font-black hover:bg-emerald-600 transition-all shadow-lg shadow-slate-200 flex items-center justify-center gap-2 transform active:scale-95">
                            <i class="fa-solid fa-plus text-[10px]"></i> إضافة ملف
                        </a>
                    @endif
                </div>
            </div>

            {{-- حاوية الجدول الذكية --}}
            <div class="bg-white border border-slate-200/60 rounded-[2rem] overflow-hidden shadow-[0_8px_30px_rgb(0,0,0,0.03)] transition-all">

                {{-- هيدر الالتزام الأخير (Commit Style) --}}
                <div class="bg-slate-50/80 backdrop-blur-md px-6 py-4 border-b border-slate-100 flex justify-between items-center">
                    <div class="flex items-center gap-3">
                        <div class="relative">
                            <img src="{{ $author->avatar ? asset('storage/'.$author->avatar) : 'https://ui-avatars.com/api/?name='.urlencode($author->name).'&background=0f172a&color=fff&bold=true' }}" class="w-8 h-8 rounded-full border-2 border-white shadow-sm">
                            <span class="absolute bottom-0 right-0 w-2.5 h-2.5 bg-emerald-500 border-2 border-white rounded-full"></span>
                        </div>
                        <div class="flex flex-col">
                            <div class="flex items-center gap-2">
                                <span class="text-sm font-black text-slate-900 leading-none">{{ $author->username }}</span>
                                <x-admin-badge :user="$author" />
                            </div>
                            <span class="text-[10px] font-bold text-slate-400 mt-0.5">تحديث مصفوفة أوزان النموذج</span>
                        </div>
                    </div>
                    <div class="flex items-center gap-4 text-[10px] font-black text-slate-400 font-mono tracking-tighter">
                        <span class="bg-white px-2 py-1 rounded-lg border border-slate-100 shadow-sm">{{ substr(md5($model->updated_at), 0, 7) }}</span>
                        <span class="font-sans uppercase">{{ $model->updated_at->shortAbsoluteDiffForHumans() }}</span>
                    </div>
                </div>

                <table class="w-full text-right">
                    <thead class="bg-white text-slate-400 text-[10px] font-black uppercase tracking-[0.2em] border-b border-slate-50">
                        <tr>
                            <th class="px-8 py-5 w-1/2">File Name</th>
                            <th class="px-8 py-5">Size</th>
                            <th class="px-8 py-5 text-left">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50 text-sm text-slate-700">
                        @forelse($files as $file)
                            <tr class="hover:bg-slate-50/80 transition-all group">
                                <td class="px-8 py-4">
                                    <div class="flex items-center gap-4 min-w-0">
                                        @php
                                            $ext = pathinfo($file->filename, PATHINFO_EXTENSION);
                                            $style = match($ext) {
                                                'json' => ['icon' => 'fa-file-code', 'bg' => 'bg-blue-50 text-blue-500'],
                                                'md', 'txt' => ['icon' => 'fa-file-lines', 'bg' => 'bg-slate-100 text-slate-500'],
                                                'safetensors', 'bin', 'pt' => ['icon' => 'fa-cube', 'bg' => 'bg-emerald-50 text-emerald-600'],
                                                default => ['icon' => 'fa-file', 'bg' => 'bg-slate-50 text-slate-400']
                                            };
                                        @endphp
                                        <div class="w-10 h-10 rounded-xl flex items-center justify-center transition-all group-hover:scale-110 shadow-sm {{ $style['bg'] }}">
                                            <i class="fa-solid {{ $style['icon'] }} text-lg"></i>
                                        </div>
                                        <div class="flex flex-col min-w-0">
                                            <a href="#" class="font-bold text-slate-900 group-hover:text-emerald-600 transition-colors truncate font-mono tracking-tighter" dir="ltr">{{ $file->filename }}</a>
                                            @if($file->size > 10*1024*1024)
                                                <span class="text-[9px] font-black text-emerald-600 uppercase tracking-widest mt-0.5 flex items-center gap-1">
                                                    <i class="fa-solid fa-cloud-arrow-down"></i> LFS storage
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td class="px-8 py-4 font-mono text-xs font-black text-slate-400 tracking-tighter">
                                    {{ $file->size > 1024*1024 ? round($file->size/1024/1024, 2).' MB' : round($file->size/1024, 2).' KB' }}
                                </td>
                                <td class="px-8 py-4 text-left">
                                    <a href="{{ Storage::url($file->path) }}" download class="w-10 h-10 rounded-xl bg-white border border-slate-200 text-slate-400 hover:text-emerald-600 hover:border-emerald-200 transition-all shadow-sm flex items-center justify-center transform active:scale-90 group-hover:shadow-md">
                                        <i class="fa-solid fa-download text-sm"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="py-24 text-center">
                                    <div class="w-20 h-20 bg-slate-50 rounded-[2rem] flex items-center justify-center mx-auto mb-4 border border-dashed border-slate-200">
                                        <i class="fa-regular fa-folder-open text-3xl text-slate-300"></i>
                                    </div>
                                    <h4 class="text-slate-900 font-black">المصفوفة فارغة</h4>
                                    <p class="text-xs text-slate-400 font-bold">لا توجد ملفات مرفوعة حالياً.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- README Card --}}
            <div class="bg-white border border-slate-200/60 rounded-[2.5rem] p-10 shadow-sm relative overflow-hidden group">
                <div class="absolute top-0 right-0 w-24 h-24 bg-slate-50 rounded-bl-full -mr-10 -mt-10 group-hover:bg-emerald-50 transition-colors"></div>
                <h3 class="font-black text-slate-900 mb-6 flex items-center gap-3 text-sm uppercase tracking-widest relative z-10">
                    <i class="fa-solid fa-book-open text-emerald-500"></i> README.md
                </h3>
                <div class="prose prose-slate max-w-none text-sm font-medium leading-loose text-slate-600 relative z-10">
                    {!! nl2br(e($model->description)) !!}
                </div>
            </div>
        </div>

        {{-- 2. الشريط الجانبي (3 أعمدة) --}}
        <div class="lg:col-span-3 space-y-8">

            {{-- بطاقة النسخ (Clone) --}}
            <div class="bg-white border border-slate-200 rounded-[2rem] p-6 shadow-sm group">
                <h3 class="font-black text-slate-900 text-[11px] uppercase tracking-[0.2em] mb-4 flex items-center gap-2">
                    <span class="w-1 h-3 bg-emerald-500 rounded-full"></span> جلب النموذج
                </h3>
                <div x-data="{ protocol: 'https' }">
                    <div class="flex p-1 bg-slate-50 rounded-xl mb-4 border border-slate-100">
                        <button @click="protocol = 'https'" :class="protocol === 'https' ? 'bg-white text-slate-900 shadow-sm' : 'text-slate-400'" class="flex-1 py-1.5 rounded-lg text-[10px] font-black transition-all">HTTPS</button>
                        <button @click="protocol = 'ssh'" :class="protocol === 'ssh' ? 'bg-white text-slate-900 shadow-sm' : 'text-slate-400'" class="flex-1 py-1.5 rounded-lg text-[10px] font-black transition-all">SSH</button>
                    </div>

                    <div class="relative group/input">
                        <input type="text" readonly
                               :value="protocol === 'https' ? 'https://oneurai.sa/{{ $author->username }}/{{ $model->slug }}' : 'git@oneurai.sa:{{ $author->username }}/{{ $model->slug }}.git'"
                               class="w-full bg-slate-950 border border-slate-800 text-emerald-400 px-3 py-3 rounded-xl text-[10px] font-mono outline-none shadow-inner" dir="ltr">
                        <button @click="navigator.clipboard.writeText($el.previousElementSibling.value)" class="absolute left-2 top-1/2 -translate-y-1/2 w-8 h-8 rounded-lg bg-white/5 text-emerald-500 hover:bg-emerald-500 hover:text-white transition-all flex items-center justify-center">
                            <i class="fa-regular fa-copy text-xs"></i>
                        </button>
                    </div>
                </div>
                <p class="text-[9px] text-slate-400 mt-4 leading-relaxed font-bold">
                    استخدم <span class="text-emerald-600">Git LFS</span> للتعامل مع ملفات الأوزان الكبيرة بسلاسة.
                </p>
            </div>

            {{-- بطاقة الإحصائيات السريعة --}}
            <div class="bg-slate-900 rounded-[2rem] p-8 text-white shadow-xl relative overflow-hidden">
                <div class="absolute bottom-0 right-0 w-32 h-32 bg-emerald-500/10 rounded-full blur-3xl -mr-16 -mb-16"></div>
                <div class="space-y-6 relative z-10">
                    <div class="flex justify-between items-end">
                        <div class="flex flex-col">
                            <span class="text-[10px] font-black text-slate-500 uppercase tracking-widest">إجمالي الحجم</span>
                            <span class="text-2xl font-black font-mono tracking-tighter text-emerald-400">
                                {{ round($files->sum('size') / (1024**3), 2) }} <span class="text-xs uppercase">GB</span>
                            </span>
                        </div>
                        <i class="fa-solid fa-database text-slate-800 text-4xl"></i>
                    </div>
                    <div class="h-px bg-white/5 w-full"></div>
                    <div class="flex justify-between items-center">
                        <span class="text-[10px] font-black text-slate-500 uppercase tracking-widest">عدد العناصر</span>
                        <span class="text-xl font-black font-mono tracking-tighter">{{ $files->count() }}</span>
                    </div>
                </div>
            </div>

        </div>
    </div><style>
    .animate-fade-in-up {
        animation: fadeInUp 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards;
    }
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>
</x-layouts.model-layout>

