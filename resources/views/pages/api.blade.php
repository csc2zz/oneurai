<x-layouts.app>
    <x-slot:title>واجهة البرمجة API | Oneurai</x-slot:title>

    {{-- 1. Hero Section: ترويسة المهندسين --}}
    <div class="relative bg-[#0B1120] py-24 lg:py-32 overflow-hidden border-b border-white/5">
        {{-- خلفية تقنية (Matrix-ish Grid) --}}
        <div class="absolute inset-0 opacity-[0.05]" style="background-image: url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNDAiIGhlaWdodD0iNDAiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PHBhdGggZD0iTTAgNDBoNDBWMGgtNDB6IiBmaWxsPSJub25lIi8+PHBhdGggZD0iTTAgMGg0MHY0MEgwem0zOSAxSDV2MzRoMzR6IiBmaWxsPSIjZmZmIiBmaWxsLW9wYWNpdHk9Ii4xIi8+PC9zdmc+');"></div>
        <div class="absolute top-0 right-0 w-[600px] h-[600px] bg-emerald-500/10 rounded-full blur-[120px] animate-pulse"></div>

        <div class="max-w-7xl mx-auto px-6 relative z-10 text-center animate-fade-in-up">
            <div class="inline-flex items-center gap-2 px-4 py-2 rounded-2xl bg-white/5 border border-white/10 text-emerald-400 text-[10px] font-black uppercase tracking-[0.3em] mb-8 backdrop-blur-xl">
                <span class="w-2 h-2 rounded-full bg-emerald-500 animate-ping"></span> v1.0 Production Ready
            </div>
            <h1 class="text-5xl lg:text-7xl font-black text-white mb-6 tracking-tighter font-mono uppercase">API <span class="text-transparent bg-clip-text bg-gradient-to-r from-emerald-400 to-blue-400">Reference</span></h1>
            <p class="text-slate-400 text-lg md:text-xl max-w-3xl mx-auto font-medium leading-relaxed">
                واجهة برمجية موحدة تربط تطبيقاتك بأقوى خوارزميات الذكاء الاصطناعي العربي. سرعة، أمان، ودقة متناهية.
            </p>
        </div>
    </div>

    {{-- 2. Content Section --}}
    <div class="bg-[#F8FAFC] py-20 px-6">
        <div class="max-w-7xl mx-auto">
            <div class="grid lg:grid-cols-2 gap-16 items-start">

                {{-- الجانب النظري (Documentation) --}}
                <div class="space-y-12 animate-fade-in-up" style="animation-delay: 0.1s">
                    <section>
                        <h2 class="text-3xl font-black text-slate-900 tracking-tighter mb-6 flex items-center gap-3">
                            <div class="w-1.5 h-8 bg-emerald-500 rounded-full"></div>
                            بروتوكول الاستخدام
                        </h2>
                        <p class="text-slate-600 leading-loose font-medium text-lg">
                            تعتمد واجهة Oneurai على معايير <span class="text-slate-900 font-black">RESTful</span> الحديثة. نستخدم تكنولوجيا الـ <span class="text-emerald-600 font-bold">Bearer Tokens</span> لتأمين كافة الطلبات الصادرة والواردة.
                        </p>
                    </section>

                    {{-- بطاقة الـ Endpoint --}}
                    <div class="group relative bg-white p-8 rounded-[2.5rem] border border-slate-200 shadow-sm hover:shadow-xl transition-all duration-500">
                        <div class="flex items-center gap-3 mb-6">
                            <div class="w-10 h-10 rounded-xl bg-slate-900 text-white flex items-center justify-center shadow-lg"><i class="fa-solid fa-bolt-lightning text-xs"></i></div>
                            <h3 class="font-black text-slate-900 text-sm uppercase tracking-widest">Base Endpoint</h3>
                        </div>
                        <div class="relative group/code">
                            <code class="block bg-slate-50 text-emerald-700 p-5 rounded-2xl text-sm font-black font-mono border border-slate-100 shadow-inner group-hover:bg-white transition-colors" dir="ltr">
                                https://api.oneurai.sa/v1
                            </code>
                            <button class="absolute left-4 top-1/2 -translate-y-1/2 w-8 h-8 rounded-lg bg-white border border-slate-200 text-slate-400 hover:text-emerald-500 transition-all opacity-0 group-hover/code:opacity-100 shadow-sm flex items-center justify-center">
                                <i class="fa-regular fa-copy text-xs"></i>
                            </button>
                        </div>
                    </div>

                    <div class="p-8 bg-emerald-50 border border-emerald-100 rounded-[2.5rem] flex items-start gap-5 group">
                        <div class="w-12 h-12 bg-white rounded-2xl flex items-center justify-center text-emerald-600 shadow-sm shrink-0 group-hover:rotate-12 transition-transform">
                            <i class="fa-solid fa-book-open-reader"></i>
                        </div>
                        <div>
                            <h4 class="font-black text-emerald-900 mb-2">هل تحتاج لتفاصيل أكثر؟</h4>
                            <p class="text-emerald-700 text-sm leading-relaxed mb-4">وثيقتنا الكاملة تحتوي على شرح لكل الـ Endpoints، حدود الاستخدام (Rate Limits)، ونماذج الاستجابة.</p>
                            <a href="{{ route('pages.docs') }}" class="inline-flex items-center gap-2 text-emerald-800 font-black text-xs uppercase tracking-[0.2em] hover:text-emerald-500 transition-colors">
                                تصفح الدليل الكامل <i class="fa-solid fa-arrow-left"></i>
                            </a>
                        </div>
                    </div>
                </div>

                {{-- الجانب العملي (Code Console) --}}
                <div class="lg:sticky lg:top-32 animate-fade-in-up" style="animation-delay: 0.2s">
                    <div class="bg-[#0B1120] rounded-[2.5rem] shadow-[0_20px_60px_rgba(0,0,0,0.2)] overflow-hidden border border-white/10 group">
                        {{-- شريط العنوان العلوي --}}
                        <div class="bg-white/5 px-8 py-5 border-b border-white/5 flex justify-between items-center">
                            <div class="flex gap-2">
                                <div class="w-3 h-3 rounded-full bg-rose-500/80 shadow-[0_0_10px_rgba(244,63,94,0.4)]"></div>
                                <div class="w-3 h-3 rounded-full bg-amber-500/80 shadow-[0_0_10px_rgba(245,158,11,0.4)]"></div>
                                <div class="w-3 h-3 rounded-full bg-emerald-500/80 shadow-[0_0_10px_rgba(16,185,129,0.4)]"></div>
                            </div>
                            <div class="flex items-center gap-3">
                                <span class="text-[10px] font-black text-slate-500 uppercase tracking-widest">Python SDK</span>
                                <div class="w-px h-3 bg-white/10"></div>
                                <i class="fa-brands fa-python text-blue-400"></i>
                            </div>
                        </div>

                        {{-- محتوى الكود --}}
                        <div class="p-8 md:p-10 font-mono text-sm leading-relaxed relative overflow-hidden" dir="ltr">
                            {{-- لمعة خلفية للكود --}}
                            <div class="absolute -right-20 -bottom-20 w-40 h-40 bg-emerald-500/5 rounded-full blur-3xl"></div>

                            <pre class="relative z-10"><span class="text-purple-400">import</span> <span class="text-white">requests</span>

<span class="text-slate-500"># 1. تعريف واجهة الطلب</span>
<span class="text-blue-400">url</span> = <span class="text-emerald-400">"https://api.oneurai.sa/v1/generate"</span>
<span class="text-blue-400">headers</span> = {
    <span class="text-amber-200">"Authorization"</span>: <span class="text-emerald-400">"Bearer YOUR_SECRET_KEY"</span>,
    <span class="text-amber-200">"Content-Type"</span>: <span class="text-emerald-400">"application/json"</span>
}

<span class="text-slate-500"># 2. إعداد البيانات (Payload)</span>
<span class="text-blue-400">payload</span> = {
    <span class="text-amber-200">"model"</span>: <span class="text-emerald-400">"saudi/najd-v2"</span>,
    <span class="text-amber-200">"prompt"</span>: <span class="text-emerald-400">"مستقبل التقنية في المملكة"</span>,
    <span class="text-amber-200">"max_tokens"</span>: <span class="text-emerald-400">512</span>
}

<span class="text-slate-500"># 3. استدعاء المصفوفة</span>
<span class="text-blue-400">response</span> = requests.post(url, json=payload, headers=headers)
<span class="text-purple-400">print</span>(response.json())</pre>

                            {{-- زر نسخ سريع --}}
                            <div class="mt-8 pt-6 border-t border-white/5 flex justify-between items-center">
                                <span class="text-[10px] font-black text-slate-600 uppercase tracking-widest">Example Request v1.0</span>
                                <button class="flex items-center gap-2 px-4 py-2 bg-emerald-500 text-slate-900 rounded-xl font-black text-[10px] uppercase transition-all hover:bg-emerald-400 hover:-translate-y-0.5 active:scale-95 shadow-lg shadow-emerald-500/20">
                                    Copy snippet <i class="fa-solid fa-copy"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    {{-- 3. Features Section: مميزات الـ API --}}
    <div class="bg-white py-24 border-t border-slate-100 overflow-hidden">
        <div class="max-w-7xl mx-auto px-6">
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-12">
                <div class="space-y-3">
                    <div class="text-2xl font-black text-slate-900 font-mono tracking-tighter">&lt; 100ms</div>
                    <p class="text-[10px] font-black text-emerald-600 uppercase tracking-widest">زمن استجابة فائق</p>
                    <p class="text-xs text-slate-500 font-medium">بنية تحتية موزعة في مراكز بيانات سعودية لضمان أقل تأخير.</p>
                </div>
                <div class="space-y-3">
                    <div class="text-2xl font-black text-slate-900 font-mono tracking-tighter">99.9%</div>
                    <p class="text-[10px] font-black text-emerald-600 uppercase tracking-widest">جهوزية الخدمة</p>
                    <p class="text-xs text-slate-500 font-medium">نضمن استمرارية خدماتك بأعلى معايير الـ SLA العالمية.</p>
                </div>
                <div class="space-y-3">
                    <div class="text-2xl font-black text-slate-900 font-mono tracking-tighter">AES-256</div>
                    <p class="text-[10px] font-black text-emerald-600 uppercase tracking-widest">تشفير سيادي</p>
                    <p class="text-xs text-slate-500 font-medium">بياناتك مشفرة ومؤمنة بالكامل وفقاً للمعايير الوطنية.</p>
                </div>
                <div class="space-y-3">
                    <div class="text-2xl font-black text-slate-900 font-mono tracking-tighter">Unlimited</div>
                    <p class="text-[10px] font-black text-emerald-600 uppercase tracking-widest">قابلية التوسع</p>
                    <p class="text-xs text-slate-500 font-medium">من طلب واحد في اليوم إلى ملايين الطلبات، نحن ندعم نموك.</p>
                </div>
            </div>
        </div>
    </div>

    <style>
        .animate-fade-in-up {
            animation: fadeInUp 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</x-layouts.app>
