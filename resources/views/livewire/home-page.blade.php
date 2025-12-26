<div class="overflow-x-hidden bg-slate-50 font-sans text-slate-900 selection:bg-emerald-500 selection:text-white">

    {{-- 1. Hero Section (القسم الرئيسي الأسطوري) --}}
    <section class="relative pt-32 pb-20 lg:pt-52 lg:pb-40 overflow-hidden">
        {{-- الخلفية العميقة مع حركة السديم --}}
        <div class="absolute inset-0 bg-[#020617] z-0">
            <div class="absolute inset-0 bg-gradient-to-br from-slate-900 via-[#020617] to-[#064e3b]/30 bg-[length:400%_400%] animate-[gradient-flow_20s_ease_infinite]"></div>
            {{-- تأثير الشبكة الرقمية --}}
            <div class="absolute inset-0 opacity-[0.15] animate-[pan-pattern_60s_linear_infinite]" style="background-image: url('https://www.transparenttextures.com/patterns/carbon-fibre.png');"></div>
            {{-- الكرات الضوئية (Blobs) --}}
            <div class="absolute top-[-10%] left-[-10%] w-[800px] h-[800px] bg-emerald-600/20 rounded-full blur-[120px] animate-[blob-bounce_25s_infinite]"></div>
            <div class="absolute bottom-[-10%] right-[-10%] w-[600px] h-[600px] bg-blue-600/10 rounded-full blur-[100px] animate-[blob-bounce_30s_infinite_reverse]"></div>
        </div>

        <div class="max-w-7xl mx-auto px-6 relative z-10">
            <div class="grid lg:grid-cols-2 gap-20 items-center">

                {{-- النصوص --}}
                <div class="text-center lg:text-right animate-fade-in-up">
                    <div class="inline-flex items-center gap-2 px-4 py-2 rounded-2xl bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 text-xs font-black uppercase tracking-widest mb-8 backdrop-blur-md">
                        <span class="relative flex h-2 w-2">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                        </span>
                        الذكاء الاصطناعي.. برؤية سعودية
                    </div>

                    <h1 class="text-5xl lg:text-8xl font-black text-white leading-[1.05] mb-8 tracking-tighter">
                        اصنع مستقبل <br>
                        <span class="text-transparent bg-clip-text bg-gradient-to-r from-emerald-400 via-teal-300 to-emerald-500 drop-shadow-[0_0_30px_rgba(16,185,129,0.3)]">التقنية العربية</span>.
                    </h1>

                    <p class="text-lg lg:text-xl text-slate-400 mb-12 leading-relaxed max-w-2xl mx-auto lg:mx-0 font-medium">
                        المنصة الأولى لاستضافة النماذج والمستودعات البرمجية مفتوحة المصدر في المملكة. نجمع المبدعين لبناء غدٍ أذكى.
                    </p>

                    <div class="flex flex-col sm:flex-row gap-5 justify-center lg:justify-start">
                        <a href="#explore" class="group relative px-10 py-5 bg-emerald-600 text-white rounded-2xl font-black text-lg shadow-[0_20px_40px_rgba(16,185,129,0.3)] hover:bg-emerald-500 transition-all transform hover:-translate-y-1 active:scale-95 overflow-hidden">
                            <span class="relative z-10 flex items-center gap-3">
                                ابدأ التصفح <i class="fa-solid fa-arrow-left group-hover:-translate-x-1 transition-transform"></i>
                            </span>
                            <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/20 to-transparent -translate-x-full group-hover:animate-[shimmer_1.5s_infinite]"></div>
                        </a>
                        <a href="{{ route('projects.create') }}" class="px-10 py-5 bg-white/5 backdrop-blur-xl text-white border border-white/10 rounded-2xl font-black text-lg hover:bg-white/10 transition-all flex items-center justify-center gap-3">
                            <i class="fa-solid fa-plus-circle text-emerald-500"></i> ارفع مشروعك
                        </a>
                    </div>
                </div>

                {{-- التيرمنال الذكي --}}
                <div class="relative group animate-fade-in-up" style="animation-delay: 0.2s">
                    <div class="absolute -inset-1 bg-gradient-to-r from-emerald-500 to-blue-600 rounded-[2.5rem] blur opacity-25 group-hover:opacity-40 transition duration-1000"></div>
                    <div class="relative bg-[#0B1120]/90 backdrop-blur-3xl rounded-[2rem] border border-white/10 shadow-2xl overflow-hidden">
                        <div class="flex items-center justify-between px-6 py-4 bg-white/5 border-b border-white/5">
                            <div class="flex gap-2">
                                <div class="w-3 h-3 rounded-full bg-[#FF5F56]"></div>
                                <div class="w-3 h-3 rounded-full bg-[#FFBD2E]"></div>
                                <div class="w-3 h-3 rounded-full bg-[#27C93F]"></div>
                            </div>
                            <div class="text-[10px] font-mono text-slate-500 uppercase tracking-widest flex items-center gap-2">
                                <i class="fa-brands fa-python"></i> najd_api.py
                            </div>
                        </div>
                        <div class="p-8 font-mono text-sm sm:text-base leading-relaxed overflow-x-auto text-emerald-400/90" dir="ltr">
                            <p class="mb-2"><span class="text-purple-400 font-bold">import</span> oneurai <span class="text-white">as</span> ai</p>
                            <p class="mb-2 text-slate-500"># Initializing Saudi LLM</p>
                            <p class="mb-2"><span class="text-blue-400">model</span> = ai.<span class="text-emerald-300">load</span>(<span class="text-amber-200">'saudi-llm/najd-7b'</span>)</p>
                            <p class="mb-2"><span class="text-blue-400">prompt</span> = <span class="text-amber-200">"ما هي رؤية 2030؟"</span></p>
                            <p class="mb-6"><span class="text-purple-400">response</span> = model.<span class="text-emerald-300">generate</span>(prompt)</p>
                            <div class="p-4 bg-emerald-500/10 rounded-xl border border-emerald-500/20 animate-pulse">
                                <p class="text-xs text-emerald-500 font-bold mb-1">OUTPUT:</p>
                                <p class="text-white text-xs leading-relaxed">الرؤية هي خطة طموحة لبناء مستقبل مزدهر لوطننا..</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- 2. قسم المميزات (التصميم الشبكي الفخم) --}}
    <section class="py-32 bg-white relative">
        <div class="max-w-7xl mx-auto px-6 relative z-10">
            <div class="text-center mb-24">
                <span class="text-emerald-600 font-black uppercase tracking-[0.3em] text-xs">Environment</span>
                <h2 class="text-4xl lg:text-5xl font-black text-slate-900 mt-4 tracking-tighter">لماذا يختارنا المبدعون؟</h2>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                @php
                    $features = [
                        ['icon' => 'fa-brain', 'title' => 'نماذج لغوية محلية', 'desc' => 'استضافة وتدريب النماذج بلهجاتنا المحلية وبياناتنا الخاصة بكل أمان.', 'color' => 'emerald'],
                        ['icon' => 'fa-shield-halved', 'title' => 'سيادة البيانات', 'desc' => 'بياناتك تُخزن وتُعالج داخل حدود الوطن، بمعايير عالمية.', 'color' => 'blue'],
                        ['icon' => 'fa-users-gear', 'title' => 'مجتمع تفاعلي', 'desc' => 'تعاون مع آلاف المطورين السعوديين في مشاريع برمجية مفتوحة.', 'color' => 'amber'],
                    ];
                @endphp

                @foreach($features as $f)
                    <div class="group p-10 rounded-[2.5rem] bg-slate-50 border border-slate-100 hover:bg-white hover:shadow-[0_30px_60px_rgb(0,0,0,0.05)] hover:border-{{ $f['color'] }}-200 transition-all duration-500 hover:-translate-y-2">
                        <div class="w-16 h-16 rounded-2xl bg-{{ $f['color'] }}-500/10 text-{{ $f['color'] }}-600 flex items-center justify-center text-3xl mb-8 group-hover:scale-110 group-hover:rotate-6 transition-all shadow-inner">
                            <i class="fa-solid {{ $f['icon'] }}"></i>
                        </div>
                        <h3 class="text-2xl font-black text-slate-900 mb-4">{{ $f['title'] }}</h3>
                        <p class="text-slate-500 leading-relaxed font-medium">{{ $f['desc'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- 3. سحابة التقنيات (Technology Cloud) --}}
    <div class="py-20 bg-slate-50 border-y border-slate-100 overflow-hidden">
        <div class="max-w-7xl mx-auto px-6">
            <p class="text-center text-slate-400 text-xs font-black uppercase tracking-widest mb-12">ندعم أشهر التقنيات العالمية</p>
            <div class="flex flex-wrap justify-center items-center gap-16 opacity-30 grayscale hover:grayscale-0 transition-all duration-1000">
                <i class="fa-brands fa-python text-5xl"></i>
                <i class="fa-brands fa-laravel text-5xl"></i>
                <i class="fa-brands fa-docker text-5xl"></i>
                <i class="fa-brands fa-aws text-5xl"></i>
                <i class="fa-brands fa-react text-5xl"></i>
                <div class="text-3xl font-black font-sans">PYTORCH</div>
                <div class="text-3xl font-black font-sans">TENSORFLOW</div>
            </div>
        </div>
    </div>

    {{-- 4. المشاريع الرائجة (الزجاجية) --}}
    <section class="py-32 bg-white" id="explore">
        <div class="max-w-7xl mx-auto px-6">
            <div class="flex flex-col md:flex-row justify-between items-end mb-20 gap-6">
                <div>
                    <h2 class="text-4xl font-black text-slate-900 tracking-tighter flex items-center gap-3">
                        <i class="fa-solid fa-bolt-lightning text-amber-500 animate-pulse"></i> نبض المجتمع
                    </h2>
                    <p class="text-slate-500 mt-2 font-medium">أبرز المشاريع التي تُشكل ملامح تقنيتنا اليوم.</p>
                </div>
                <a href="{{ route('explore') }}" class="px-6 py-3 rounded-2xl bg-slate-900 text-white font-bold text-sm hover:bg-emerald-600 transition-all shadow-xl shadow-slate-900/10 flex items-center gap-2">
                    اكتشف المزيد <i class="fa-solid fa-arrow-left"></i>
                </a>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-10">
                @forelse($trendingProjects as $project)
                    {{-- كرت المشروع الفخم --}}
                    <a href="{{ route('project.showing', ['username' => $project->user->username, 'slug' => $project->slug]) }}">
                    <div class="group relative p-1 rounded-[3rem] bg-gradient-to-br from-slate-200 to-transparent hover:from-emerald-400 hover:to-blue-500 transition-all duration-700">
                        <div class="bg-white rounded-[2.8rem] p-8 h-full flex flex-col relative overflow-hidden shadow-sm">
                            <div class="flex justify-between items-start mb-8">
                                <div class="w-14 h-14 rounded-[1.2rem] bg-slate-50 border border-slate-100 flex items-center justify-center text-3xl group-hover:scale-110 transition-transform duration-500">
                                    @if($project->type == 'model') 🤖 @else 📦 @endif
                                </div>
                                <span class="px-3 py-1 rounded-full bg-emerald-50 text-emerald-600 text-[10px] font-black uppercase tracking-tighter border border-emerald-100">Trending</span>
                            </div>
                            <div class="flex-grow">
                                <h3 class="text-2xl font-black text-slate-900 group-hover:text-emerald-600 transition-colors mb-3 leading-tight" dir="ltr">
                                    {{ $project->title }}
                                </h3>
                                <p class="text-slate-500 text-sm leading-relaxed line-clamp-3 mb-8 font-medium">
                                    {{ $project->description }}
                                </p>
                            </div>
                            <div class="pt-6 border-t border-slate-50 flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <img src="https://ui-avatars.com/api/?name={{ $project->user->name }}&bg=0f172a&color=fff" class="w-8 h-8 rounded-full border-2 border-white shadow-sm">
                                    <span class="text-xs font-bold text-slate-700" dir="ltr">@ {{ $project->user->username }}</span>
                                </div>
                                <div class="flex items-center gap-3 text-slate-400">
                                    <span class="flex items-center gap-1 text-xs font-bold"><i class="fa-regular fa-star text-amber-500"></i> {{ $project->stars_count }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    </a>
                @empty
                    {{-- كرت تجريبي --}}
                    <div class="group relative p-1 rounded-[3rem] bg-slate-100 hover:from-emerald-400 hover:to-blue-500 transition-all">
                        <div class="bg-white rounded-[2.8rem] p-8 h-full">
                            <div class="w-14 h-14 bg-indigo-50 rounded-2xl flex items-center justify-center text-2xl text-indigo-600 mb-6"><i class="fa-brands fa-laravel"></i></div>
                            <h3 class="text-xl font-black mb-2">ZatcaConnect-SDK</h3>
                            <p class="text-slate-500 text-sm mb-6 leading-relaxed">نظام ربط متكامل مع هيئة الزكاة والضريبة والجمارك للمرحلة الثانية.</p>
                            <div class="flex -space-x-2 space-x-reverse pt-4 border-t border-slate-50">
                                <img src="https://i.pravatar.cc/100?u=1" class="w-8 h-8 rounded-full border-2 border-white shadow-sm">
                                <img src="https://i.pravatar.cc/100?u=2" class="w-8 h-8 rounded-full border-2 border-white shadow-sm">
                                <div class="w-8 h-8 rounded-full border-2 border-white bg-slate-100 flex items-center justify-center text-[10px] font-black text-slate-400">+12</div>
                            </div>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    {{-- 5. إحصائيات حية (Live Ticker Stats) --}}
    <section class="bg-[#020617] py-24 relative border-y border-white/5 overflow-hidden">
        <div class="max-w-7xl mx-auto px-6 relative z-10 text-center">
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-12">
                <div>
                    <div class="text-4xl lg:text-6xl font-black text-white mb-2 font-mono tabular-nums">98k+</div>
                    <p class="text-emerald-500 text-[10px] font-black uppercase tracking-[0.2em]">مطور نشط</p>
                </div>
                <div>
                    <div class="text-4xl lg:text-6xl font-black text-white mb-2 font-mono tabular-nums">7.4k+</div>
                    <p class="text-emerald-500 text-[10px] font-black uppercase tracking-[0.2em]">نموذج ذكاء</p>
                </div>
                <div>
                    <div class="text-4xl lg:text-6xl font-black text-white mb-2 font-mono tabular-nums">1.2k</div>
                    <p class="text-emerald-500 text-[10px] font-black uppercase tracking-[0.2em]">مجموعة بيانات</p>
                </div>
                <div>
                    <div class="text-4xl lg:text-6xl font-black text-white mb-2 font-mono tabular-nums">25k+</div>
                    <p class="text-emerald-500 text-[10px] font-black uppercase tracking-[0.2em]">مساهمة كود</p>
                </div>
            </div>
        </div>
    </section>

    {{-- 6. Call to Action (نهاية القصة) --}}
    <section class="py-40 bg-white relative overflow-hidden text-center">
        <div class="absolute inset-0 bg-gradient-to-t from-emerald-50 to-transparent"></div>
        <div class="max-w-3xl mx-auto px-6 relative z-10">
            <div class="w-24 h-24 bg-emerald-600 rounded-[2.5rem] flex items-center justify-center text-white text-4xl mx-auto mb-10 shadow-[0_20px_50px_rgba(16,185,129,0.3)] animate-bounce-slow">
                <i class="fa-solid fa-paper-plane"></i>
            </div>
            <h2 class="text-4xl lg:text-6xl font-black text-slate-900 tracking-tighter mb-8 leading-[1.1]">
                ابدأ رحلتك في <span class="text-emerald-600 underline decoration-slate-200 underline-offset-8">عالم ونوراي</span> اليوم.
            </h2>
            <p class="text-slate-500 text-lg lg:text-xl font-medium mb-12">كن جزءاً من النهضة التقنية الأكبر في المنطقة.</p>

            <div class="flex flex-col sm:flex-row justify-center gap-6">
                <a href="{{ route('register') }}" class="px-12 py-5 bg-slate-900 text-white rounded-2xl font-black text-lg hover:bg-emerald-600 transition-all shadow-2xl hover:shadow-emerald-500/40">انضم للوصول المبكر</a>
                <a href="{{ route('pages.contact') }}" class="px-12 py-5 bg-white border border-slate-200 text-slate-900 rounded-2xl font-black text-lg hover:bg-slate-50 transition-all">تواصل مع الفريق</a>
            </div>
        </div>
    </section>

    {{-- 🎨 الأنميشن المعقد (يضاف لملف CSS أو هنا مباشرة) --}}
    <style>
        @keyframes gradient-flow {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        @keyframes blob-bounce {
            0%, 100% { transform: translate(0, 0) scale(1); }
            33% { transform: translate(40px, -60px) scale(1.1); }
            66% { transform: translate(-30px, 30px) scale(0.9); }
        }
        @keyframes pan-pattern {
            0% { background-position: 0 0; }
            100% { background-position: 1000px 1000px; }
        }
        @keyframes shimmer {
            100% { transform: translateX(100%); }
        }
        @keyframes bounce-slow {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-15px); }
        }
        .animate-bounce-slow { animation: bounce-slow 4s ease-in-out infinite; }
        .animate-fade-in-up {
            animation: fade-in-up 1s cubic-bezier(0.16, 1, 0.3, 1) forwards;
            opacity: 0;
        }
        @keyframes fade-in-up {
            from { opacity: 0; transform: translateY(40px); }
            to { opacity: 1; transform: translateY(0); }
        }
        /* سكرول بار ناعم */
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: #f8fafc; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
    </style>

</div>
