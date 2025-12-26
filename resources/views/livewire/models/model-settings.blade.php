<x-layouts.model-layout :model="$model" :author="$author" active-tab="settings">
    <div class="max-w-4xl mx-auto space-y-10 animate-fade-in-up pb-20">

        {{-- 1. التنبيهات الذكية --}}
        @if(session('message'))
            <div class="group relative overflow-hidden bg-emerald-50 border border-emerald-200 p-4 rounded-2xl flex items-center gap-3 shadow-sm animate-bounce-short">
                <div class="absolute inset-0 bg-gradient-to-r from-emerald-100/50 to-transparent -translate-x-full group-hover:translate-x-full transition-transform duration-1000"></div>
                <div class="w-8 h-8 rounded-full bg-emerald-500 text-white flex items-center justify-center shrink-0 shadow-lg shadow-emerald-200">
                    <i class="fa-solid fa-check text-xs"></i>
                </div>
                <p class="text-emerald-800 text-sm font-black tracking-tight">{{ session('message') }}</p>
            </div>
        @endif

        {{-- 2. قسم المعلومات الأساسية --}}
        <div class="bg-white border border-slate-200/60 rounded-[2.5rem] p-8 shadow-[0_8px_30px_rgb(0,0,0,0.02)] relative overflow-hidden">
            <div class="flex items-center gap-3 mb-8 border-b border-slate-50 pb-6">
                <div class="w-10 h-10 rounded-xl bg-slate-900 text-white flex items-center justify-center shadow-lg shadow-slate-200">
                    <i class="fa-solid fa- signature text-sm"></i>
                </div>
                <div>
                    <h2 class="text-xl font-black text-slate-900 tracking-tighter">المعلومات الأساسية</h2>
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-0.5">Core Configuration</p>
                </div>
            </div>

            <div class="space-y-8">
                {{-- اسم النموذج --}}
                <div class="group">
                    <label class="block text-xs font-black text-slate-500 uppercase tracking-widest mb-3 mr-1 group-focus-within:text-emerald-600 transition-colors">اسم النموذج المعرف</label>
                    <div class="flex items-stretch rounded-2xl border-2 border-slate-100 bg-slate-50 overflow-hidden focus-within:border-emerald-500/30 focus-within:bg-white focus-within:ring-4 focus-within:ring-emerald-500/5 transition-all">
                        <span class="inline-flex items-center px-5 bg-slate-100 text-slate-400 text-xs font-black font-mono border-l border-slate-200" dir="ltr">
                            {{ $author->username }} /
                        </span>
                        <input wire:model="editTitle" type="text"
                               class="flex-1 px-4 py-3.5 bg-transparent border-none focus:ring-0 text-sm font-black text-slate-800 placeholder:text-slate-300 font-sans" dir="ltr">
                    </div>
                </div>

                {{-- الرخصة --}}
                <div class="group">
                    <label class="block text-xs font-black text-slate-500 uppercase tracking-widest mb-3 mr-1 group-focus-within:text-emerald-600 transition-colors">اتفاقية الترخيص</label>
                    <div class="relative">
                        <select class="w-full bg-slate-50 border-2 border-slate-100 rounded-2xl py-4 px-5 text-sm font-bold text-slate-700 appearance-none focus:bg-white focus:border-emerald-500/30 focus:ring-4 focus:ring-emerald-500/5 outline-none transition-all cursor-pointer">
                            <option value="apache-2.0">Apache 2.0 (الموصى به)</option>
                            <option value="mit">MIT License</option>
                            <option value="openrail">OpenRAIL</option>
                            <option value="other">أخرى / ترخيص مخصص</option>
                        </select>
                        <div class="absolute inset-y-0 left-4 flex items-center pointer-events-none text-slate-400">
                            <i class="fa-solid fa-chevron-down text-[10px]"></i>
                        </div>
                    </div>
                </div>

                {{-- الوسوم --}}
                <div class="group">
                    <label class="block text-xs font-black text-slate-500 uppercase tracking-widest mb-3 mr-1 group-focus-within:text-emerald-600 transition-colors">الوسوم الذكية (Tags)</label>
                    <div class="min-h-[100px] border-2 border-slate-100 rounded-[1.5rem] p-4 flex flex-wrap gap-2 bg-slate-50 focus-within:bg-white focus-within:border-emerald-500/30 transition-all">
                        <div class="bg-emerald-600 text-white px-3 py-1.5 rounded-xl text-[10px] font-black flex items-center gap-2 shadow-md shadow-emerald-200">
                            {{ $model->task }}
                            <button class="hover:rotate-90 transition-transform"><i class="fa-solid fa-xmark"></i></button>
                        </div>
                        <div class="bg-slate-900 text-white px-3 py-1.5 rounded-xl text-[10px] font-black flex items-center gap-2 shadow-md shadow-slate-200">
                            {{ $model->framework }}
                            <button class="hover:rotate-90 transition-transform"><i class="fa-solid fa-xmark"></i></button>
                        </div>
                        <input type="text" placeholder="+ إضافة وسم جديد" class="flex-1 min-w-[120px] text-xs font-bold outline-none bg-transparent py-1 px-2 text-slate-600">
                    </div>
                    <p class="text-[10px] text-slate-400 mt-3 font-medium px-1 flex items-center gap-2">
                        <i class="fa-solid fa-circle-info text-emerald-500"></i>
                        الوسوم الصحيحة تزيد من ظهور نموذجك في نتائج البحث بنسبة 40%.
                    </p>
                </div>
            </div>

            <div class="mt-10 pt-6 border-t border-slate-50 flex justify-end">
                <button wire:click="save" class="group bg-slate-900 text-white px-10 py-4 rounded-2xl text-xs font-black hover:bg-emerald-600 transition-all shadow-xl shadow-slate-200 active:scale-95 flex items-center gap-3">
                    تحديث مصفوفة المعلومات <i class="fa-solid fa-arrow-left transition-transform group-hover:-translate-x-1"></i>
                </button>
            </div>
        </div>

        {{-- 3. قسم الخصوصية والوصول --}}
        <div class="bg-white border border-slate-200/60 rounded-[2.5rem] p-8 shadow-sm">
            <h2 class="text-xl font-black text-slate-900 tracking-tighter mb-8 flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center shadow-inner">
                    <i class="fa-solid fa-shield-halved text-sm"></i>
                </div>
                الخصوصية والوصول المتقدم
            </h2>

            <div class="space-y-8">
                {{-- رؤية النموذج --}}
                <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between p-6 rounded-3xl bg-slate-50 border border-slate-100 gap-6">
                    <div class="max-w-md">
                        <h4 class="text-sm font-black text-slate-800 tracking-tight">رؤية النموذج (Visibility)</h4>
                        <p class="text-[11px] text-slate-500 mt-1 font-medium leading-relaxed">تحويل النموذج إلى "خاص" يمنع أي شخص من تحميله أو رؤيته باستثناء الملاك المعينين.</p>
                    </div>
                    <div class="flex p-1.5 bg-slate-200/50 rounded-2xl w-fit shrink-0">
                        <button class="px-6 py-2.5 rounded-[0.9rem] text-[10px] font-black uppercase tracking-widest transition-all {{ $model->is_public ? 'bg-white text-emerald-600 shadow-md' : 'text-slate-500' }}">Public</button>
                        <button class="px-6 py-2.5 rounded-[0.9rem] text-[10px] font-black uppercase tracking-widest transition-all {{ !$model->is_public ? 'bg-white text-rose-600 shadow-md' : 'text-slate-500' }}">Private</button>
                    </div>
                </div>

                {{-- Gated Model Toggle --}}
                <div class="flex items-center justify-between p-6">
                    <div class="max-w-md">
                        <div class="flex items-center gap-3 mb-1">
                            <h4 class="text-sm font-black text-slate-800 tracking-tight">نموذج مقيد الوصول (Gated)</h4>
                            <span class="px-2 py-0.5 rounded-md bg-amber-50 text-amber-600 text-[8px] font-black uppercase tracking-widest border border-amber-100">Enterprise</span>
                        </div>
                        <p class="text-[11px] text-slate-500 font-medium leading-relaxed">يتطلب من المستخدمين تقديم معلوماتهم الشخصية والموافقة على شروطك قبل الوصول للأوزان.</p>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer group">
                        <input type="checkbox" id="toggle-gate" class="sr-only peer">
                        <div class="w-14 h-7 bg-slate-200 rounded-full peer peer-checked:after:-translate-x-full rtl:peer-checked:after:-translate-x-full after:content-[''] after:absolute after:top-1 after:right-[4px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-emerald-500 shadow-inner group-active:after:w-7"></div>
                    </label>
                </div>

                {{-- API Toggle --}}
                <div class="flex items-center justify-between p-6">
                    <div class="max-w-md">
                        <h4 class="text-sm font-black text-slate-800 tracking-tight">واجهة التجربة (Inference API)</h4>
                        <p class="text-[11px] text-slate-500 font-medium leading-relaxed">تفعيل ميزة الـ Playground لتجربة النموذج برمجياً أو عبر واجهة المنصة مباشرة.</p>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer group">
                        <input type="checkbox" id="toggle-api" class="sr-only peer" checked>
                        <div class="w-14 h-7 bg-slate-200 rounded-full peer peer-checked:after:-translate-x-full rtl:peer-checked:after:-translate-x-full after:content-[''] after:absolute after:top-1 after:right-[4px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-emerald-500 shadow-inner group-active:after:w-7"></div>
                    </label>
                </div>
            </div>
        </div>

        {{-- 4. منطقة الخطر (The Danger Zone) --}}
        <div class="relative overflow-hidden group">
            <div class="absolute inset-0 bg-red-600/5 -z-0 opacity-0 group-hover:opacity-100 transition-opacity duration-700"></div>
            <div class="bg-white border-2 border-red-100 rounded-[2.5rem] shadow-sm relative z-10 overflow-hidden">
                <div class="bg-red-50/80 backdrop-blur-md px-8 py-5 border-b border-red-100 flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg bg-red-600 text-white flex items-center justify-center animate-pulse">
                        <i class="fa-solid fa-triangle-exclamation text-xs"></i>
                    </div>
                    <h2 class="font-black text-red-700 text-xs uppercase tracking-[0.2em]">إجراءات لا يمكن التراجع عنها</h2>
                </div>

                <div class="p-8 space-y-10">
                    {{-- نقل الملكية --}}
                    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-6">
                        <div class="max-w-md">
                            <h4 class="text-sm font-black text-slate-900 tracking-tight">نقل ملكية المستودع</h4>
                            <p class="text-[11px] text-slate-500 font-medium leading-relaxed">تحويل السيطرة الكاملة على هذا النموذج إلى حساب مستخدم آخر أو منظمة تقنية.</p>
                        </div>
                        <button class="px-8 py-3 bg-white border border-slate-200 text-slate-800 rounded-xl text-xs font-black hover:bg-slate-900 hover:text-white hover:border-slate-900 transition-all shadow-sm active:scale-95">بدء عملية النقل</button>
                    </div>

                    <div class="h-px bg-slate-100 w-full"></div>

                    {{-- حذف النموذج --}}
                    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-6">
                        <div class="max-w-md">
                            <h4 class="text-sm font-black text-slate-900 tracking-tight text-red-600 uppercase">تدمير المستودع نهائياً</h4>
                            <p class="text-[11px] text-slate-500 font-medium leading-relaxed">سيتم مسح كافة ملفات الأوزان، الالتزامات، والبيانات الوصفية. لن يتمكن أحد من استعادتها أبداً.</p>
                        </div>
                        <button class="px-8 py-3 bg-red-600 text-white rounded-xl text-xs font-black hover:bg-red-700 transition-all shadow-lg shadow-red-200 active:scale-95">حذف النموذج الآن</button>
                    </div>
                </div>
            </div>
        </div>

    </div><style>
    @keyframes bounce-short {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-4px); }
    }
    .animate-bounce-short { animation: bounce-short 2s ease-in-out infinite; }
</style>
</x-layouts.model-layout>

