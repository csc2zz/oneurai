<x-layouts.app>
    <x-slot:title>التوثيق البرمجي | Oneurai Docs</x-slot:title>

    <style>
        /* ستايلات المحتوى البرمجي الفخم */
        .docs-content h1 { @apply text-4xl lg:text-5xl font-black text-slate-900 mb-8 tracking-tighter; }
        .docs-content h2 { @apply text-2xl font-black text-slate-900 mt-16 mb-6 tracking-tight flex items-center gap-3 scroll-mt-32; }
        .docs-content h2::before { content: ''; @apply w-2 h-6 bg-emerald-500 rounded-full; }
        .docs-content h3 { @apply text-xl font-bold text-slate-800 mt-10 mb-4; }
        .docs-content p { @apply text-slate-600 leading-loose mb-6 text-base font-medium; }
        .docs-content code:not(pre code) { @apply bg-emerald-50 text-emerald-700 px-1.5 py-0.5 rounded-md font-mono text-sm font-bold border border-emerald-100; }
        .docs-content ul { @apply list-disc list-inside text-slate-600 mb-6 space-y-2; }

        .sidebar-link-active { @apply bg-slate-900 text-white shadow-lg shadow-slate-200 border-none !important; }
        .no-scrollbar::-webkit-scrollbar { display: none; }
    </style>

    <div class="flex h-screen bg-white overflow-hidden pt-20">

        {{-- 1. القائمة الجانبية اليسرى (Navigation) --}}
        <aside class="w-80 border-l border-slate-100 flex-shrink-0 hidden lg:flex flex-col bg-slate-50/50 backdrop-blur-sm">
            <div class="p-8 overflow-y-auto no-scrollbar flex-1 space-y-10">

                {{-- قسم البحث --}}
                <div class="relative group">
                    <i class="fa-solid fa-magnifying-glass absolute right-3 top-3 text-slate-400 group-focus-within:text-emerald-500 transition-colors"></i>
                    <input type="text" placeholder="بحث في التوثيق..." class="w-full bg-white border border-slate-200 rounded-xl py-2.5 pr-10 pl-4 text-xs font-bold focus:ring-4 focus:ring-emerald-500/5 focus:border-emerald-500 outline-none transition-all shadow-sm">
                </div>

                <nav class="space-y-8">
                    <div>
                        <h5 class="px-4 mb-4 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">البداية</h5>
                        <div class="space-y-1">
                            <a href="#installation" class="sidebar-link-active flex items-center gap-3 px-4 py-2.5 text-xs font-black rounded-xl border border-transparent transition-all">
                                <i class="fa-solid fa-download text-[10px]"></i> التثبيت والإعداد
                            </a>
                            <a href="#authentication" class="flex items-center gap-3 px-4 py-2.5 text-xs font-bold text-slate-500 hover:bg-white hover:text-emerald-600 hover:shadow-sm rounded-xl border border-transparent transition-all">
                                <i class="fa-solid fa-key text-[10px]"></i> المصادقة (Auth)
                            </a>
                        </div>
                    </div>

                    <div>
                        <h5 class="px-4 mb-4 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">العمليات الأساسية</h5>
                        <div class="space-y-1">
                            <a href="#repos" class="flex items-center gap-3 px-4 py-2.5 text-xs font-bold text-slate-500 hover:bg-white hover:text-emerald-600 hover:shadow-sm rounded-xl border border-transparent transition-all">
                                <i class="fa-solid fa-code-branch text-[10px]"></i> رفع الأكواد (Repos)
                            </a>
                            <a href="#datasets" class="flex items-center gap-3 px-4 py-2.5 text-xs font-bold text-slate-500 hover:bg-white hover:text-emerald-600 hover:shadow-sm rounded-xl border border-transparent transition-all">
                                <i class="fa-solid fa-database text-[10px]"></i> البيانات (Datasets)
                            </a>
                            <a href="#models" class="flex items-center gap-3 px-4 py-2.5 text-xs font-bold text-slate-500 hover:bg-white hover:text-emerald-600 hover:shadow-sm rounded-xl border border-transparent transition-all">
                                <i class="fa-solid fa-brain text-[10px]"></i> النماذج (Models)
                            </a>
                        </div>
                    </div>
                </nav>
            </div>

            {{-- فوتر القائمة --}}
            <div class="p-6 border-t border-slate-100">
                <div class="bg-slate-900 rounded-2xl p-4 text-white relative overflow-hidden group cursor-pointer">
                    <div class="absolute -right-4 -bottom-4 w-16 h-16 bg-emerald-500 rounded-full blur-xl group-hover:scale-150 transition-transform opacity-20"></div>
                    <p class="text-[10px] font-black uppercase tracking-widest opacity-60 mb-1">نسخة المكتبة</p>
                    <p class="text-xs font-bold font-mono text-emerald-400">v0.2.1 (Stable)</p>
                </div>
            </div>
        </aside>

        {{-- 2. المحتوى الرئيسي (Content) --}}
        <main class="flex-1 overflow-y-auto bg-white relative scroll-smooth px-6 lg:px-20 py-16 no-scrollbar">
            <div class="max-w-4xl mx-auto">

                {{-- Breadcrumbs --}}
                <div class="flex items-center gap-3 text-[10px] font-black uppercase tracking-widest text-slate-400 mb-10">
                    <span class="hover:text-emerald-600 cursor-pointer transition">Docs</span>
                    <i class="fa-solid fa-chevron-left text-[8px]"></i>
                    <span class="text-emerald-600">Python SDK</span>
                </div>

                <div class="docs-content animate-fade-in-up">
                    <h1>تثبيت واستخدام Oneurai SDK</h1>
                    <p class="text-xl text-slate-500 font-medium leading-relaxed">
                        مكتبة <code>oneurai</code> هي الحل المتكامل لعمليات MLOps. تمكنك من رفع الشيفرات البرمجية، مجموعات البيانات، وتدريب نماذج الذكاء الاصطناعي ورفعها إلى السحابة بأسطر قليلة، مع دعم التجاوز التلقائي لجدران الحماية وضغط البيانات.
                    </p>

                    {{-- التثبيت --}}
                    <h2 id="installation">1. التثبيت (Installation)</h2>
                    <p>تأكد من وجود <code>Python 3.8+</code> و <code>PyTorch</code> مثبتاً في بيئتك. قم بتنفيذ الأمر التالي في الطرفية:</p>

                    <div class="relative group my-8">
                        <div class="absolute -top-3 -left-3 w-8 h-8 bg-slate-800 rounded-lg flex items-center justify-center text-white text-xs shadow-xl z-10"><i class="fa-solid fa-terminal"></i></div>
                        <pre class="bg-[#0B1120] text-emerald-400 p-6 pt-10 rounded-2xl overflow-x-auto font-mono text-sm shadow-2xl border border-white/5" dir="ltr"><code><span class="text-slate-500">$</span> pip install <span class="text-white">oneurai</span> --upgrade</code></pre>
                    </div>

                    {{-- المصادقة --}}
                    <h2 id="authentication">2. المصادقة (Authentication)</h2>
                    <p>للبدء، تحتاج إلى مفتاح API (Token) من لوحة التحكم. المكتبة تستخدم هذا المفتاح للاتصال الآمن بخوادم ونوراي.</p>
                    
                    <div class="bg-amber-50 border-r-4 border-amber-400 p-4 rounded-xl mb-6 flex gap-3">
                        <i class="fa-solid fa-triangle-exclamation text-amber-500 mt-1"></i>
                        <p class="text-amber-800 text-sm font-bold mb-0">هام: لا تشارك التوكن الخاص بك علناً أو ترفعه إلى GitHub.</p>
                    </div>

                    <div class="relative group my-8">
                        <div class="absolute -top-3 -left-3 w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center text-white text-xs shadow-xl z-10"><i class="fa-brands fa-python"></i></div>
                        <pre class="bg-[#0B1120] text-slate-300 p-6 pt-10 rounded-2xl overflow-x-auto font-mono text-sm shadow-2xl border border-white/5 leading-loose" dir="ltr"><code><span class="text-purple-400">import</span> oneurai <span class="text-purple-400">as</span> one

<span class="text-slate-500"># إعداد التوكن الخاص بك</span>
<span class="text-blue-400">MY_TOKEN</span> = <span class="text-emerald-400">"YOUR_API_TOKEN_HERE"</span>

<span class="text-slate-500"># تسجيل الدخول والتحقق من الاتصال</span>
<span class="text-purple-400">try</span>:
    one.login(MY_TOKEN)
    <span class="text-purple-400">print</span>(<span class="text-amber-200">"✅ Connected Successfully!"</span>)
<span class="text-purple-400">except</span> <span class="text-yellow-200">Exception</span> <span class="text-purple-400">as</span> e:
    <span class="text-purple-400">print</span>(<span class="text-amber-200">f"❌ Error: {e}"</span>)</code></pre>
                    </div>

                    {{-- العمليات الشاملة --}}
                    <h2 id="full-workflow">3. أمثلة الاستخدام الشاملة</h2>
                    <p>فيما يلي الأكواد الرسمية لرفع أنواع المشاريع الثلاثة المدعومة (Repos, Datasets, Models).</p>

                    <h3 id="repos" class="text-lg font-bold text-slate-800 mt-8 flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-blue-500"></span> رفع الأكواد (Repos)
                    </h3>
                    <p>المكتبة تدعم رفع ملفات مفردة (مثل <code>.py</code>, <code>.txt</code>) أو ملفات مضغوطة لمشاريع كاملة.</p>

                    <div class="relative group my-6">
                         <pre class="bg-[#0B1120] text-slate-300 p-6 rounded-2xl overflow-x-auto font-mono text-sm border border-white/5 leading-loose" dir="ltr"><code><span class="text-slate-500"># رفع ملف نصي أو كود</span>
<span class="text-blue-400">repo_name</span> = <span class="text-emerald-400">"username/my-project"</span>
one.upload_to_repo(
    <span class="text-orange-300">file_path</span>=<span class="text-emerald-400">"main.py"</span>,
    <span class="text-orange-300">full_repo_name</span>=repo_name,
    <span class="text-orange-300">description</span>=<span class="text-emerald-400">"Initial commit for my AI project"</span>
)</code></pre>
                    </div>

                    <h3 id="datasets" class="text-lg font-bold text-slate-800 mt-8 flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-purple-500"></span> رفع البيانات (Datasets)
                    </h3>
                    <p>تم تحسين المكتبة لرفع ملفات <code>CSV</code> و <code>JSON</code> الكبيرة وتجاوز قيود الاستضافة تلقائياً.</p>

                    <div class="relative group my-6">
                         <pre class="bg-[#0B1120] text-slate-300 p-6 rounded-2xl overflow-x-auto font-mono text-sm border border-white/5 leading-loose" dir="ltr"><code><span class="text-slate-500"># رفع ملف بيانات ضخم</span>
<span class="text-blue-400">data_project</span> = <span class="text-emerald-400">"username/sales-data-2025"</span>

one.upload_dataset(
    <span class="text-orange-300">file_path</span>=<span class="text-emerald-400">"large_data.csv"</span>,
    <span class="text-orange-300">full_repo_name</span>=data_project,
    <span class="text-orange-300">description</span>=<span class="text-emerald-400">"Sales data Q1 2025 - Cleaned"</span>
)</code></pre>
                    </div>

                    <h3 id="models" class="text-lg font-bold text-slate-800 mt-8 flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-emerald-500"></span> النماذج (AI Models)
                    </h3>
                    <p>الميزة الأقوى في Oneurai. يمكنك بناء نموذج PyTorch محلياً، ثم رفعه بسطر واحد. تقوم المكتبة بضغط النموذج (Zip) تلقائياً لضمان سرعة الرفع وتجاوز الحماية.</p>

                    <div class="relative group my-6">
                        <div class="absolute top-4 right-4 bg-emerald-500/10 text-emerald-500 px-2 py-1 rounded text-[10px] font-bold uppercase tracking-wider">Auto-Zip Enabled</div>
                        <pre class="bg-[#0B1120] text-slate-300 p-6 rounded-2xl overflow-x-auto font-mono text-sm border border-white/5 leading-loose" dir="ltr"><code><span class="text-slate-500"># 1. بناء النموذج محلياً</span>
<span class="text-slate-500"># Layers: [Input: 100, Hidden: 50, Output: 1]</span>
<span class="text-blue-400">my_model</span> = one.create_model([<span class="text-emerald-400">100</span>, <span class="text-emerald-400">50</span>, <span class="text-emerald-400">1</span>])

<span class="text-purple-400">print</span>(<span class="text-amber-200">"✅ Model created locally."</span>)

<span class="text-slate-500"># 2. رفع النموذج إلى السحابة</span>
<span class="text-slate-500"># سيتم ضغطه تلقائياً إلى .zip قبل الرفع</span>
one.push_to_hub(
    <span class="text-orange-300">repo_id</span>=<span class="text-emerald-400">"username/my-ai-model-v1"</span>,
    <span class="text-orange-300">model</span>=my_model,
    <span class="text-orange-300">description</span>=<span class="text-emerald-400">"First iteration of the prediction model"</span>
)</code></pre>
                    </div>

                </div>

                {{-- أزرار التنقل السفلي --}}
                <div class="mt-20 pt-10 border-t border-slate-100 flex justify-between items-center">
                    <div class="flex flex-col gap-1">
                        <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">السابق</span>
                        <a href="#" class="text-slate-900 font-black hover:text-emerald-600 transition-colors flex items-center gap-2">
                             الرئيسية
                        </a>
                    </div>
                    <div class="flex flex-col gap-1 text-left">
                        <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest text-left">التالي</span>
                        <a href="#" class="text-slate-900 font-black hover:text-emerald-600 transition-colors flex items-center gap-2">
                            إدارة المشاريع <i class="fa-solid fa-arrow-left text-xs"></i>
                        </a>
                    </div>
                </div>
            </div>
        </main>

        {{-- 3. القائمة الجانبية اليمنى (Table of Contents) --}}
        <aside class="w-72 hidden xl:flex flex-col border-r border-slate-100 p-10 bg-white shadow-[-20px_0_40px_rgba(0,0,0,0.01)]">
            <h5 class="text-[10px] font-black text-slate-900 uppercase tracking-[0.3em] mb-6">في هذه الصفحة</h5>
            <nav class="space-y-4 relative">
                <div class="absolute right-0 top-0 w-0.5 h-full bg-slate-100 rounded-full"></div>

                <a href="#installation" class="block pr-4 border-r-2 border-emerald-500 text-xs font-black text-emerald-600 transition-all">التثبيت</a>
                <a href="#authentication" class="block pr-4 border-r-2 border-transparent text-xs font-bold text-slate-400 hover:text-slate-800 hover:border-slate-300 transition-all">المصادقة</a>
                <a href="#repos" class="block pr-4 border-r-2 border-transparent text-xs font-bold text-slate-400 hover:text-slate-800 hover:border-slate-300 transition-all">رفع الأكواد</a>
                <a href="#datasets" class="block pr-4 border-r-2 border-transparent text-xs font-bold text-slate-400 hover:text-slate-800 hover:border-slate-300 transition-all">رفع البيانات</a>
                <a href="#models" class="block pr-4 border-r-2 border-transparent text-xs font-bold text-slate-400 hover:text-slate-800 hover:border-slate-300 transition-all">رفع النماذج</a>
            </nav>

            <div class="mt-auto">
                <div class="p-5 bg-slate-50 rounded-[1.5rem] border border-slate-100">
                    <p class="text-[10px] font-black text-slate-900 uppercase tracking-widest mb-2">حالة النظام</p>
                    <div class="flex items-center gap-2">
                        <span class="w-2 h-2 bg-emerald-500 rounded-full animate-pulse"></span>
                        <p class="text-[10px] text-slate-500 font-bold">API Online</p>
                    </div>
                </div>
            </div>
        </aside>

    </div>
</x-layouts.app>