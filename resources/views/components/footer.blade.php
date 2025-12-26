<footer class="relative bg-gradient-to-br from-slate-50 via-white to-emerald-50/30 pt-32 pb-16 overflow-hidden border-t border-slate-200">
    {{-- تأثيرات خلفية متعددة المستويات --}}
    <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_bottom_left,_var(--tw-gradient-stops))] from-emerald-100/20 via-transparent to-transparent -z-20"></div>
    <div class="absolute bottom-0 right-0 w-[600px] h-[600px] bg-gradient-to-br from-purple-500/5 via-pink-500/5 to-blue-500/5 rounded-full blur-[150px] -z-10 animate-pulse-slow"></div>
    <div class="absolute top-1/2 left-10 w-[400px] h-[400px] bg-gradient-to-r from-emerald-400/10 to-cyan-400/10 rounded-full blur-[120px] -z-10 animate-float"></div>
    
    {{-- جزيرة عائمة ثلاثية الأبعاد --}}
    <div class="absolute -top-20 left-1/2 -translate-x-1/2 w-40 h-40 bg-gradient-to-br from-emerald-400/20 to-cyan-400/20 rounded-[40%_60%_60%_40%/50%_40%_60%_50%] blur-2xl animate-spin-slow"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        {{-- شريط علوي مميز (Call to Action) --}}
        <div class="bg-gradient-to-r from-slate-900/5 via-emerald-500/10 to-slate-900/5 backdrop-blur-sm border border-white/20 rounded-2xl p-6 mb-20 shadow-xl shadow-emerald-500/5">
            <div class="flex flex-col lg:flex-row items-center justify-between gap-8">
                <div class="text-center lg:text-right">
                    <h3 class="text-2xl font-black text-slate-900 mb-2 font-sans">🚀 انضم إلى ثورة الذكاء الاصطناعي العربي</h3>
                    <p class="text-slate-600 text-sm font-bold">اكتب مستقبلك الرقمي مع مجتمع المطورين والمبدعين في Oneurai</p>
                </div>
               <a href="{{ Auth::check() ? route('dashboard') : route('register') }}" 
   class="group relative px-8 py-4 bg-gradient-to-r from-emerald-600 to-cyan-600 text-white font-bold rounded-xl hover:shadow-2xl hover:shadow-emerald-500/30 transition-all duration-500 hover:scale-105">
    
    <span class="relative z-10">ابدأ رحلتك الآن</span>
    
    {{-- تأثير الخلفية عند التمرير --}}
    <div class="absolute inset-0 bg-gradient-to-r from-emerald-700 to-cyan-700 rounded-xl opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
    
    {{-- هالة التوهج الخارجي --}}
    <div class="absolute -inset-1 bg-gradient-to-r from-emerald-500 to-cyan-500 rounded-xl blur-lg opacity-0 group-hover:opacity-70 transition-opacity duration-500"></div>
</a>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-12 gap-12 lg:gap-16 mb-24">
            {{-- عمود العلامة التجارية الفاخر --}}
            <div class="col-span-1 sm:col-span-2 lg:col-span-4">
                <div class="relative group">
                    <a href="{{ route('home') ?? '/' }}" class="flex items-center gap-4 mb-8 w-fit relative z-10">
                        <div class="relative">
                            <div class="absolute inset-0 bg-gradient-to-br from-emerald-500 to-cyan-500 blur-xl opacity-30 group-hover:opacity-50 transition-all duration-700 rounded-2xl"></div>
                            <div class="relative w-14 h-14 bg-gradient-to-br from-emerald-600 via-emerald-700 to-emerald-800 rounded-2xl flex items-center justify-center text-white shadow-2xl shadow-emerald-500/30 transform group-hover:rotate-12 transition-transform duration-500">
                                <i class="fa-solid fa-code-branch text-2xl"></i>
                            </div>
                        </div>
                        <div class="flex flex-col">
                            <span class="font-black text-3xl tracking-tighter text-slate-900 font-sans bg-gradient-to-r from-emerald-600 to-cyan-600 bg-clip-text text-transparent">Oneurai</span>
                            <span class="text-[10px] font-black text-slate-500 tracking-widest uppercase mt-1">AI & Innovation Hub</span>
                        </div>
                    </a>
                    
                    <div class="relative mb-8 p-6 bg-white/50 backdrop-blur-sm rounded-2xl border border-white shadow-lg shadow-slate-100/50">
                        <p class="text-slate-600 text-sm leading-relaxed font-bold">
                            نقود التحول الرقمي في الوطن العربي من خلال بناء منظومة ذكاء اصطناعي مفتوحة المصدر تتكامل مع الهوية الثقافية السعودية.
                        </p>
                    </div>

                    {{-- شبكة اجتماعية فخمة --}}
                    <div class="flex items-center gap-3">
                        @php
                            $socials = [
                                ['icon' => 'fa-x-twitter', 'link' => '#', 'color' => 'hover:bg-black'],
                                ['icon' => 'fa-github', 'link' => '#', 'color' => 'hover:bg-[#24292e]'],
                                ['icon' => 'fa-discord', 'link' => '#', 'color' => 'hover:bg-[#5865F2]'],
                                ['icon' => 'fa-linkedin', 'link' => '#', 'color' => 'hover:bg-[#0077b5]']
                            ];
                        @endphp
                        @foreach($socials as $social)
                            <a href="{{ $social['link'] }}" 
                               class="relative group/social w-11 h-11 rounded-xl bg-white border border-slate-200 flex items-center justify-center text-slate-400 {{ $social['color'] }} hover:text-white hover:shadow-xl transition-all duration-500 hover:-translate-y-1">
                                <i class="fa-brands {{ $social['icon'] }} text-lg"></i>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- أعمدة التنقل --}}
            @php
    $navColumns = [
        'المنصة' => [
            ['icon' => 'fa-compass', 'route' => 'explore', 'text' => 'استكشف', 'badge' => 'جديد'],
            ['icon' => 'fa-cube', 'route' => 'models', 'text' => 'مكتبة النماذج', 'badge' => '50+'],
            ['icon' => 'fa-newspaper', 'route' => 'pages.blog', 'text' => 'المدونة التقنية', 'badge' => ''],
            ['icon' => 'fa-address-card', 'route' => 'pages.about', 'text' => 'قصة ونوراي', 'badge' => ''],
        ],
        'المصادر' => [
            ['icon' => 'fa-book', 'route' => 'pages.docs', 'text' => 'مركز التوثيق', 'badge' => '📚'],
            ['icon' => 'fa-terminal', 'route' => 'pages.api', 'text' => 'مرجع الـ API', 'badge' => 'PRO'],
            ['icon' => 'fa-users', 'route' => 'pages.community', 'text' => 'المجتمع الرقمي', 'badge' => '10K+'],
            ['icon' => 'fa-briefcase', 'route' => 'pages.careers', 'text' => 'انضم للفريق', 'badge' => 'هنا'],
        ],
        'الدعم والقانون' => [
            ['icon' => 'fa-headset', 'route' => 'pages.contact', 'text' => 'اتصل بنا', 'badge' => '24/7'],
            ['icon' => 'fa-shield-alt', 'route' => 'pages.privacy', 'text' => 'الخصوصية', 'badge' => 'آمن'],
            ['icon' => 'fa-file-signature', 'route' => 'pages.terms', 'text' => 'الشروط', 'badge' => ''],
            ['icon' => 'fa-ticket', 'route' => 'dashboard.tickets.create', 'text' => 'مركز المساعدة', 'badge' => ''],
        ]
    ];
@endphp

            @foreach($navColumns as $title => $links)
                <div class="lg:col-span-2">
                    <h4 class="font-black text-slate-900 mb-8 text-sm uppercase tracking-[0.2em] flex items-center gap-3">
                        <span class="w-6 h-0.5 bg-emerald-500"></span> {{ $title }}
                    </h4>
                    <ul class="space-y-4">
                        @foreach($links as $link)
                            <li>
                                <a href="{{ $link['route'] === '#' ? '#' : (Route::has($link['route']) ? route($link['route']) : '#') }}" 
                                   class="group/link flex items-center justify-between text-slate-500 hover:text-emerald-600 transition-all duration-300">
                                    <span class="text-sm font-bold">{{ $link['text'] }}</span>
                                    @if($link['badge'])
                                        <span class="text-[9px] font-black px-2 py-0.5 rounded-full bg-emerald-50 text-emerald-600 border border-emerald-100">{{ $link['badge'] }}</span>
                                    @endif
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endforeach

            {{-- بطاقة الاشتراك الذهبية --}}
            <div class="col-span-1 sm:col-span-2 lg:col-span-12 xl:col-span-2">
                <div class="bg-slate-900 rounded-3xl p-6 text-white relative overflow-hidden shadow-2xl border border-white/10 group/newsletter">
                    <div class="absolute top-0 right-0 w-24 h-24 bg-emerald-500/10 rounded-full blur-2xl -mr-12 -mt-12 group-hover/newsletter:bg-emerald-500/20 transition-all"></div>
                    <p class="text-[10px] font-black uppercase tracking-widest text-emerald-400 mb-2">النشرة الذهبية</p>
                    <p class="text-sm font-bold mb-6">ابقَ على اطلاع بأحدث النماذج.</p>
                    
                    <form class="space-y-3">
                        <input type="email" placeholder="بريدك.." class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-xs focus:ring-1 focus:ring-emerald-500 outline-none">
                        <button class="w-full bg-gradient-to-r from-emerald-600 to-cyan-600 font-black py-3 rounded-xl text-xs hover:shadow-lg hover:shadow-emerald-500/20 transition-all">
                            اشترك الآن <i class="fa-solid fa-arrow-left mr-1"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>

        {{-- البار السفلي النهائي --}}
        <div class="pt-12 border-t border-slate-200/50 flex flex-col lg:flex-row justify-between items-center gap-8">
            <div class="text-center lg:text-right">
                <p class="text-sm font-black text-slate-400 tracking-widest uppercase">
                    © {{ date('Y') }} <span class="text-emerald-600">Oneurai</span> Technologies
                </p>
                <p class="text-[10px] text-slate-500 mt-1 font-bold">🇸🇦 مقرنا الرئيسي: الرياض، المملكة العربية السعودية</p>
            </div>

            <div class="flex items-center gap-4">
                <div class="flex items-center gap-2 px-4 py-2 bg-white rounded-2xl border border-slate-200 shadow-sm">
                    <span class="relative flex h-2 w-2">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                    </span>
                    <span class="text-[10px] font-black text-slate-900 uppercase">System Active</span>
                </div>
            </div>
        </div>
    </div>

    <style>
        @keyframes float { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-20px); } }
        @keyframes pulse-slow { 0%, 100% { opacity: 0.3; } 50% { opacity: 0.6; } }
        .animate-float { animation: float 8s ease-in-out infinite; }
        .animate-spin-slow { animation: spin 20s linear infinite; }
        .animate-pulse-slow { animation: pulse-slow 4s ease-in-out infinite; }
    </style>
</footer>