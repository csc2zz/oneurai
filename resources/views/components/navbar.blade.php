<nav x-data="{ mobileMenuOpen: false, scrolled: false, userMenuOpen: false }"
     @scroll.window="scrolled = (window.pageYOffset > 20)"
     :class="scrolled ? 'py-2 bg-white/90 shadow-lg border-b border-slate-200 backdrop-blur-md' : 'py-4 bg-white border-b border-slate-100'"
     class="fixed w-full z-50 transition-all duration-300 ease-out">

    <div class="max-w-7xl mx-auto px-3 sm:px-4 lg:px-6">
        <div class="flex justify-between items-center">

            {{-- 1. الشعار (مع الأنميشن المجنون) --}}
            <a href="{{ route('home') ?? '/' }}" class="group flex items-center gap-2 sm:gap-3 shrink-0">
                {{-- أيقونة الشعار --}}
                <div class="relative" bis_skin_checked="1">
                    {{-- توهج خلف الأيقونة --}}
                    <div class="absolute inset-0 bg-emerald-500 blur-lg opacity-20 group-hover:opacity-50 transition duration-500" bis_skin_checked="1"></div>
                    
                    {{-- مربع الأيقونة --}}
                    <div class="w-10 h-10 sm:w-11 sm:h-11 bg-gradient-to-br from-emerald-500 to-emerald-700 rounded-2xl flex items-center justify-center text-white shadow-xl shadow-emerald-500/20 relative z-10 group-hover:rotate-[10deg] group-hover:scale-110 transition-all duration-300 ease-out" bis_skin_checked="1">
                        <i class="fa-solid fa-code-branch text-lg sm:text-xl"></i>
                    </div>
                </div>

                {{-- نص الشعار --}}
                <div class="flex flex-col" bis_skin_checked="1">
                    <span class="font-black text-xl sm:text-2xl tracking-tighter font-sans relative transition-all duration-500 magic-glow-text">
                        Oneurai
                    </span>
                    <span class="text-[9px] font-bold text-slate-400 uppercase tracking-widest -mt-1 group-hover:text-emerald-600 transition-colors duration-300">
                        Intelligence Lab
                    </span>
                </div>
            </a>

            {{-- 2. القائمة الرئيسية (الأزرار الملونة) --}}
            <div class="hidden lg:flex items-center gap-1 p-1">
                @php
                    $navLinks = [
                        ['route' => 'home', 'label' => 'الرئيسية', 'icon' => 'fa-house', 'color' => 'slate', 'icon_color' => 'text-slate-500'],
                        ['route' => 'explore', 'label' => 'تصفح', 'icon' => 'fa-compass', 'color' => 'indigo', 'icon_color' => 'text-indigo-500'],
                        ['route' => 'models', 'label' => 'النماذج', 'icon' => 'fa-robot', 'color' => 'blue', 'icon_color' => 'text-blue-500'],
                        ['route' => 'datasets.public.index', 'label' => 'البيانات', 'icon' => 'fa-database', 'color' => 'amber', 'icon_color' => 'text-amber-500'],
                        ['route' => 'developers.index', 'label' => 'المطورين', 'icon' => 'fa-code', 'color' => 'emerald', 'icon_color' => 'text-emerald-500'],
                        ['route' => 'games', 'label' => 'العاب', 'icon' => 'fa-gamepad', 'color' => 'rose', 'icon_color' => 'text-rose-500'],
                    ];
                @endphp

                @foreach($navLinks as $link)
                    @php 
                        $isActive = request()->routeIs($link['route']); 
                        $color = $link['color'];
                    @endphp
                    
                    <a href="{{ route($link['route']) }}"
                       class="group/link relative px-3 py-2 rounded-xl text-sm font-bold transition-all duration-300 flex items-center gap-2
                       {{ $isActive 
                           ? "bg-{$color}-50 text-{$color}-700 shadow-sm ring-1 ring-{$color}-200" 
                           : "text-slate-600 hover:bg-{$color}-50 hover:text-{$color}-700" }}">
                        
                        <span class="relative transition-transform duration-300 group-hover/link:scale-110 {{ $isActive ? '' : 'grayscale group-hover/link:grayscale-0' }}">
                            <i class="fa-solid {{ $link['icon'] }} text-xs {{ $link['icon_color'] }}"></i>
                        </span>
                        {{ $link['label'] }}
                    </a>
                @endforeach
            </div>

            {{-- 3. الأدوات المميزة (مدونة + فحص) --}}
            <div class="hidden lg:flex items-center gap-2 pl-2 border-r border-slate-200 mr-2">
                
                {{-- زر المدونة --}}
                <a href="https://oneurai.com/blog" 
                   class="group/blog relative flex items-center gap-2 px-3 py-2 rounded-xl text-sm font-bold text-slate-600 hover:text-orange-700 hover:bg-orange-50 transition-all duration-300">
                    <div class="w-6 h-6 rounded-lg bg-white border border-slate-200 group-hover/blog:border-orange-200 flex items-center justify-center shadow-sm group-hover/blog:rotate-12 transition-transform">
                        <i class="fa-solid fa-feather-pointed text-[10px] text-orange-500"></i>
                    </div>
                    <span>المدونة</span>
                    {{-- نقطة تنبيه --}}
                    <span class="absolute top-1.5 right-1.5 flex h-2 w-2">
                      <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-orange-400 opacity-75"></span>
                      <span class="relative inline-flex rounded-full h-2 w-2 bg-orange-500"></span>
                    </span>
                </a>

                {{-- زر الفحص --}}
                <a href="https://scan.oneurai.com/" target="_blank"
                   class="group/scanner relative flex items-center gap-2 px-4 py-2 rounded-xl bg-slate-900 hover:bg-black text-white overflow-hidden shadow-lg hover:shadow-slate-900/50 transition-all duration-300">
                    <div class="absolute inset-0 bg-[url('https://grainy-gradients.vercel.app/noise.svg')] opacity-20"></div>
                    {{-- شعاع الفحص --}}
                    <div class="absolute inset-0 bg-gradient-to-r from-transparent via-emerald-500/30 to-transparent skew-x-[-20deg] w-[50%] h-full animate-scanner-beam"></div>
                    
                    <i class="fa-solid fa-shield-virus text-emerald-400 text-xs relative z-10"></i>
                    <span class="text-xs font-black tracking-wider relative z-10">AI SCAN</span>
                </a>
            </div>

            {{-- 4. إجراءات المستخدم --}}
            <div class="flex items-center gap-2 sm:gap-3">
                
                {{-- زر البحث --}}
                <button @click="$dispatch('openSearch')" 
                        class="w-9 h-9 sm:w-10 sm:h-10 rounded-xl bg-slate-50 hover:bg-white text-slate-500 hover:text-emerald-600 border border-slate-200 hover:border-emerald-200 hover:shadow-md hover:shadow-emerald-100 transition-all duration-300 flex items-center justify-center group">
                    <i class="fa-solid fa-magnifying-glass text-sm group-hover:scale-110 transition-transform"></i>
                </button>
                <livewire:search-modal />

                @guest
                    <div class="hidden sm:flex items-center gap-2">
                        <a href="{{ route('login') }}" class="px-5 py-2.5 rounded-xl text-sm font-bold text-slate-600 hover:text-slate-900 hover:bg-slate-100 transition-all duration-300">
                            دخول
                        </a>
                        <a href="{{ route('register') }}" class="group relative px-6 py-2.5 rounded-xl text-sm font-black text-white shadow-lg shadow-emerald-500/30 hover:shadow-emerald-500/50 transition-all duration-300 overflow-hidden">
                            <div class="absolute inset-0 bg-gradient-to-r from-emerald-600 to-teal-500 transition-all duration-300 group-hover:scale-105"></div>
                            <span class="relative">ابدأ مجاناً</span>
                        </a>
                    </div>
                @else
                    <livewire:layouts.header-notifications />
                    
                    {{-- بروفايل المستخدم --}}
                    <div class="relative" x-data="{ userMenuOpen: false }">
                        <button @click="userMenuOpen = !userMenuOpen" @click.away="userMenuOpen = false"
                                class="flex items-center gap-2 p-1 pr-2 sm:p-1.5 sm:pl-3 sm:pr-4 bg-white hover:bg-slate-50 rounded-xl sm:rounded-2xl border border-slate-200 transition-all duration-300 shadow-sm hover:shadow-md group">
                            
                            <div class="flex flex-col items-end text-right hidden sm:flex">
                                <span class="text-sm font-bold text-slate-800">{{ Auth::user()->name }}</span>
                                <span class="text-[10px] text-slate-400 group-hover:text-emerald-500 transition-colors">عضو مميز</span>
                            </div>

                            <div class="relative shrink-0">
                                @if(Auth::user()->avatar)
                                    <img src="{{ asset('storage/' . Auth::user()->avatar) }}" class="w-9 h-9 sm:w-10 sm:h-10 rounded-xl object-cover ring-2 ring-white shadow-sm">
                                @else
                                    <div class="w-9 h-9 sm:w-10 sm:h-10 rounded-xl bg-gradient-to-br from-emerald-500 to-emerald-600 flex items-center justify-center text-white font-bold text-sm shadow-md ring-2 ring-white">
                                        {{ substr(Auth::user()->name, 0, 1) }}
                                    </div>
                                @endif
                            </div>
                        </button>
                        
                        {{-- قائمة المستخدم المنسدلة --}}
                        <div x-show="userMenuOpen" x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 translate-y-4 scale-95"
                             x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                             class="absolute left-0 mt-3 w-72 bg-white rounded-2xl shadow-2xl ring-1 ring-slate-900/5 overflow-hidden z-50 origin-top-left">
                            <div class="p-4 bg-slate-50 border-b border-slate-100">
                                <p class="text-xs font-bold text-slate-400 uppercase mb-2">الحساب الحالي</p>
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-600 font-bold">{{ substr(Auth::user()->name, 0, 1) }}</div>
                                    <div>
                                        <p class="font-bold text-slate-800">{{ Auth::user()->name }}</p>
                                        <p class="text-xs text-slate-500">{{ Auth::user()->email }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="p-2 space-y-1">
                                <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl hover:bg-emerald-50 text-slate-600 hover:text-emerald-600 transition-colors">
                                    <i class="fa-solid fa-gauge-high w-5 text-center"></i> <span class="font-bold text-sm">لوحة التحكم</span>
                                </a>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button class="w-full flex items-center gap-3 px-3 py-2.5 rounded-xl hover:bg-red-50 text-slate-600 hover:text-red-600 transition-colors">
                                        <i class="fa-solid fa-power-off w-5 text-center"></i> <span class="font-bold text-sm">تسجيل الخروج</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endguest

                {{-- زر الموبايل --}}
                <button @click="mobileMenuOpen = !mobileMenuOpen" 
                        class="lg:hidden w-10 h-10 rounded-xl bg-white border border-slate-200 text-slate-600 flex items-center justify-center hover:bg-slate-50 transition-colors">
                    <i class="fa-solid" :class="mobileMenuOpen ? 'fa-xmark' : 'fa-bars-staggered'"></i>
                </button>
            </div>
        </div>
    </div>

    {{-- قائمة الموبايل --}}
    <div x-show="mobileMenuOpen" x-collapse
         class="lg:hidden absolute top-full left-0 w-full bg-white/95 backdrop-blur-xl border-t border-slate-200 shadow-2xl max-h-[85vh] overflow-y-auto">
        <div class="p-4 space-y-3">
            <div class="grid grid-cols-2 gap-3">
                <a href="https://scan.oneurai.com/" class="flex flex-col items-center justify-center gap-2 p-4 rounded-2xl bg-slate-900 text-white shadow-lg">
                    <i class="fa-solid fa-shield-virus text-emerald-400 text-xl"></i> <span class="font-bold text-xs">فحص الكود</span>
                </a>
                <a href="https://oneurai.com/blog" class="flex flex-col items-center justify-center gap-2 p-4 rounded-2xl bg-orange-50 text-orange-700 border border-orange-100">
                    <i class="fa-solid fa-feather-pointed text-xl"></i> <span class="font-bold text-xs">المدونة</span>
                </a>
            </div>
            <div class="h-px bg-slate-100 my-2"></div>
            @foreach($navLinks as $link)
                @php $color = $link['color']; @endphp
                <a href="{{ route($link['route']) }}" class="flex items-center gap-4 p-3 rounded-2xl transition-all duration-300 {{ request()->routeIs($link['route']) ? "bg-{$color}-50 text-{$color}-700 ring-1 ring-{$color}-200" : "hover:bg-slate-50 text-slate-600" }}">
                   <div class="w-10 h-10 rounded-xl flex items-center justify-center {{ request()->routeIs($link['route']) ? "bg-white shadow-sm text-{$color}-500" : "bg-slate-100 text-slate-400" }}">
                       <i class="fa-solid {{ $link['icon'] }}"></i>
                   </div>
                   <span class="font-bold text-base">{{ $link['label'] }}</span>
                </a>
            @endforeach
            @guest
                <div class="pt-4 mt-4 border-t border-slate-100">
                    <a href="{{ route('register') }}" class="flex items-center justify-center w-full p-4 rounded-2xl bg-gradient-to-r from-emerald-600 to-teal-500 text-white font-black text-lg shadow-lg mb-3">ابدأ مجاناً</a>
                    <a href="{{ route('login') }}" class="flex items-center justify-center w-full p-4 rounded-2xl bg-slate-50 text-slate-600 font-bold border border-slate-100">دخول</a>
                </div>
            @endguest
        </div>
    </div>
</nav>

<style>
    /* 1. أنميشن الوميض البطيء للنص */
    @keyframes crazy-glow {
        0%, 100% {
            text-shadow: 0 0 0px rgba(16, 185, 129, 0);
            color: #0f172a; /* Slate 900 */
        }
        50% {
            text-shadow: 0 0 20px rgba(16, 185, 129, 0.4),
                         0 0 40px rgba(52, 211, 153, 0.2);
            color: #059669; /* Emerald 600 */
        }
    }

    /* 2. أنميشن اللمعة السريعة (Shimmer) */
    @keyframes shimmer-fast {
        0% { background-position: 200% center; }
        100% { background-position: -200% center; }
    }

    /* 3. أنميشن شعاع الفحص (Scanner Beam) */
    @keyframes scanner-beam {
        0% { transform: translateX(-150%) skewX(-20deg); }
        50%, 100% { transform: translateX(200%) skewX(-20deg); }
    }
    .animate-scanner-beam {
        animation: scanner-beam 3s infinite linear;
    }

    /* تطبيق الكلاسات */
    .magic-glow-text {
        animation: crazy-glow 4s ease-in-out infinite;
        background-size: 200% auto;
        -webkit-background-clip: text;
        transition: all 0.3s ease;
    }

    /* التأثير عند الهوفر (الجنون الحقيقي) */
    .group:hover .magic-glow-text {
        animation: none; /* نوقف الأنميشن البطيء */
        
        /* تدرج لوني رهيب */
        background-image: linear-gradient(
            to right,
            #10b981 20%, /* Emerald */
            #34d399 40%, /* Emerald Light */
            #fbbf24 50%, /* Amber (Gold) */
            #34d399 60%, 
            #10b981 80%
        );
        
        -webkit-text-fill-color: transparent;
        animation: shimmer-fast 1.5s linear infinite; /* تشغيل اللمعة السريعة */
        filter: drop-shadow(0 0 8px rgba(16, 185, 129, 0.4));
        transform: scale(1.05); /* تكبير بسيط */
    }
</style>