<aside 
    x-cloak
    {{-- المنطق السحري هنا: في الجوال يتحرك بناء على sidebarOpen، وفي الكمبيوتر يبقى ثابتاً lg:translate-x-0 --}}
    :class="sidebarOpen ? 'translate-x-0' : 'translate-x-full lg:translate-x-0'"
    class="fixed inset-y-0 right-0 z-50 w-72 bg-[#0B1120] text-white flex-shrink-0 
           transition-transform duration-300 ease-in-out border-l border-white/5 shadow-2xl
           lg:static lg:inset-0 lg:z-30 h-full flex flex-col overflow-hidden"
>
    {{-- الخلفية الجمالية --}}
    <div class="absolute top-0 left-0 w-full h-full bg-gradient-to-b from-emerald-900/10 to-transparent pointer-events-none"></div>

    {{-- 1. الهيدر (الشعار) --}}
    <div class="h-20 flex items-center px-8 justify-between lg:justify-start relative z-10">
        <a href="{{ route('home') }}" class="flex items-center gap-3 group">
            <div class="relative">
                <div class="absolute inset-0 bg-emerald-500 blur-md opacity-20 group-hover:opacity-50 transition duration-500 rounded-lg"></div>
                <div class="w-9 h-9 bg-gradient-to-br from-emerald-500 to-emerald-700 rounded-xl flex items-center justify-center text-white text-sm shadow-lg border border-emerald-400/20 relative z-10 group-hover:scale-105 transition-transform">
                    <i class="fa-solid fa-code-branch"></i>
                </div>
            </div>
            <div>
                <span class="font-extrabold text-xl tracking-tight text-white group-hover:text-emerald-400 transition font-sans">Oneurai</span>
                <span class="block text-[10px] text-slate-500 font-mono tracking-widest -mt-1 uppercase">Dashboard</span>
            </div>
        </a>
        <button @click="sidebarOpen = false" class="lg:hidden text-slate-400 hover:text-white transition transform hover:rotate-90">
            <i class="fa-solid fa-xmark text-2xl"></i>
        </button>
    </div>

    {{-- 2. القائمة الرئيسية (Scrollable Area) --}}
    <div class="flex-1 overflow-y-auto py-6 px-4 space-y-8 relative z-10 custom-scrollbar">

        {{-- قسم التطبيق --}}
        <div>
            <p class="px-4 text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-3 font-mono">App Navigation</p>
            <div class="space-y-1">
                @php
                    $links = [
                        ['route' => 'dashboard', 'icon' => 'fa-house', 'label' => 'لوحة التحكم'],
                        ['route' => 'dashboard.repos', 'icon' => 'fa-folder', 'label' => 'مستودعاتي'],
                        ['route' => 'dashboard.models', 'icon' => 'fa-brain', 'label' => 'النماذج'],
                        ['route' => 'dashboard.datasets', 'icon' => 'fa-database', 'label' => 'البيانات'],
                    ];
                @endphp

                @foreach($links as $link)
                    @php $isActive = request()->routeIs($link['route']); @endphp
                    <a href="{{ route($link['route']) }}"
                       class="relative flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-xl transition-all duration-300 group overflow-hidden
                       {{ $isActive ? 'bg-white/5 text-white shadow-[0_0_20px_rgba(16,185,129,0.1)]' : 'text-slate-400 hover:bg-white/5 hover:text-white' }}">

                        {{-- تأثير الليزر الجانبي عند التفعيل --}}
                        @if($isActive)
                            <div class="absolute right-0 top-1/2 -translate-y-1/2 w-1 h-8 bg-emerald-500 rounded-l-full shadow-[0_0_10px_#10b981]"></div>
                        @endif

                        <i class="fa-solid {{ $link['icon'] }} w-5 text-center transition-colors duration-300 {{ $isActive ? 'text-emerald-400' : 'text-slate-500 group-hover:text-emerald-400' }}"></i>
                        <span class="relative z-10 {{ $isActive ? 'translate-x-1' : 'group-hover:translate-x-1' }} transition-transform duration-300">{{ $link['label'] }}</span>
                    </a>
                @endforeach

                {{-- ==================== قسم الألعاب الجديد (Rose Style) ==================== --}}
                @php $isGamesActive = request()->routeIs('games'); @endphp
                <a href="{{ route('dashboard.games') }}"
                   class="relative flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-xl transition-all duration-300 group overflow-hidden mt-2 border border-transparent
                   {{ $isGamesActive ? 'bg-gradient-to-r from-rose-900/20 to-transparent text-white border-rose-500/20' : 'text-slate-400 hover:bg-white/5 hover:text-white hover:border-rose-500/10' }}">

                    @if($isGamesActive)
                        <div class="absolute right-0 top-0 bottom-0 w-0.5 bg-rose-500 shadow-[0_0_15px_#f43f5e]"></div>
                    @endif

                    <div class="relative">
                        <i class="fa-solid fa-gamepad w-5 text-center transition-colors {{ $isGamesActive ? 'text-rose-400' : 'text-slate-500 group-hover:text-rose-400' }}"></i>
                        {{-- نقطة تنبيه وردية نابضة --}}
                        <span class="absolute -top-0.5 -right-0.5 w-1.5 h-1.5 bg-rose-500 rounded-full animate-pulse shadow-[0_0_5px_#f43f5e]"></span>
                    </div>

                    <span class="flex-1 {{ $isGamesActive ? 'translate-x-1' : 'group-hover:translate-x-1' }} transition-transform">الألعاب</span>

                    {{-- بادج "جديد" --}}
                    <span class="text-[9px] font-bold bg-rose-500/10 text-rose-400 px-1.5 py-0.5 rounded border border-rose-500/20 group-hover:bg-rose-500 group-hover:text-white transition-colors">
                        جديد
                    </span>
                </a>
                {{-- ================================================================= --}}

                {{-- رابط الرسائل --}}
                @php $isChatActive = request()->routeIs('dashboard.chat'); @endphp
                <a href="{{ route('dashboard.chat') }}"
                   class="relative flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-xl transition-all duration-300 group overflow-hidden mt-2
                   {{ $isChatActive ? 'bg-gradient-to-r from-emerald-900/20 to-transparent text-white border border-emerald-500/20' : 'text-slate-400 hover:bg-white/5 hover:text-white' }}">

                    @if($isChatActive)
                        <div class="absolute right-0 top-0 bottom-0 w-0.5 bg-emerald-500 shadow-[0_0_15px_#10b981]"></div>
                    @endif

                    <div class="relative">
                        <i class="fa-solid fa-comments w-5 text-center transition-colors {{ $isChatActive ? 'text-emerald-400' : 'text-slate-500 group-hover:text-emerald-400' }}"></i>
                    </div>

                    <span class="flex-1 {{ $isChatActive ? 'translate-x-1' : 'group-hover:translate-x-1' }} transition-transform">الرسائل</span>

                    {{-- Badge --}}
                    <div class="{{ $isChatActive ? 'bg-emerald-500 text-[#0B1120]' : 'bg-slate-800 text-slate-300 group-hover:bg-emerald-500 group-hover:text-[#0B1120]' }} transition-colors text-[10px] font-bold px-2 py-0.5 rounded-md min-w-[20px] text-center">
                        <livewire:dashboard.chat.badge />
                    </div>
                </a>

                @php 
                    $isTicketsActive = request()->routeIs('dashboard.tickets*');
                    $openTicketsCount = auth()->user()->tickets()->where('status', 'open')->count();
                @endphp

                <a href="{{ route('dashboard.tickets') }}"
                   class="relative flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-xl transition-all duration-300 group overflow-hidden
                   {{ $isTicketsActive ? 'bg-white/5 text-white shadow-[0_0_20px_rgba(16,185,129,0.1)]' : 'text-slate-400 hover:bg-white/5 hover:text-white' }}">
                    
                    @if($isTicketsActive)
                        <div class="absolute right-0 top-1/2 -translate-y-1/2 w-1 h-8 bg-emerald-500 rounded-l-full shadow-[0_0_10px_#10b981]"></div>
                    @endif

                    <i class="fa-solid fa-ticket-alt w-5 text-center transition-colors duration-300 {{ $isTicketsActive ? 'text-emerald-400' : 'text-slate-500 group-hover:text-emerald-400' }}"></i>
                    <span class="flex-1 {{ $isTicketsActive ? 'translate-x-1' : 'group-hover:translate-x-1' }} transition-transform duration-300">تذاكري</span>
                    
                    @if($openTicketsCount > 0)
                        <span class="text-[10px] bg-slate-800 text-slate-400 px-2 py-0.5 rounded-md group-hover:bg-emerald-500 group-hover:text-[#0B1120] transition-colors">
                            {{ $openTicketsCount }}
                        </span>
                    @endif
                </a>

                {{-- مركز المساعدة --}}
                @php $isHelpActive = request()->routeIs('dashboard.help'); @endphp
                <a href="{{ route('dashboard.help') }}"
                   class="relative flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-xl transition-all duration-300 group overflow-hidden
                   {{ $isHelpActive ? 'bg-white/5 text-white shadow-[0_0_20px_rgba(16,185,129,0.1)]' : 'text-slate-400 hover:bg-white/5 hover:text-white' }}">
                    
                    @if($isHelpActive)
                        <div class="absolute right-0 top-1/2 -translate-y-1/2 w-1 h-8 bg-emerald-500 rounded-l-full shadow-[0_0_10px_#10b981]"></div>
                    @endif

                    <i class="fa-solid fa-circle-question w-5 text-center transition-colors duration-300 {{ $isHelpActive ? 'text-emerald-400' : 'text-slate-500 group-hover:text-emerald-400' }}"></i>
                    <span class="relative z-10 {{ $isHelpActive ? 'translate-x-1' : 'group-hover:translate-x-1' }} transition-transform duration-300">مركز المساعدة</span>
                </a>
            </div>
        </div>

        {{-- قسم مساحات العمل --}}
        @if(auth()->user()->joinedProjects()->count() > 0)
            <div>
                <p class="px-4 text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-3 font-mono">Workspaces</p>
                <div class="grid grid-cols-1 gap-1">
                    @foreach(auth()->user()->joinedProjects as $project)
                        <a href="{{ route('projects.show', ['username' => $project->user->username, 'slug' => $project->slug]) }}"
                           class="flex items-center gap-3 px-4 py-2.5 text-sm rounded-xl transition-all duration-200 group border border-transparent hover:border-slate-700/50 hover:bg-slate-800/50
                           {{ request()->is('*'.$project->slug.'*') ? 'bg-slate-800 border-slate-700 text-white' : 'text-slate-400' }}">

                            <div class="w-8 h-8 rounded-lg flex items-center justify-center text-xs font-bold text-white shadow-inner
                                @if($project->id % 3 == 0) bg-gradient-to-br from-indigo-500 to-indigo-700
                                @elseif($project->id % 3 == 1) bg-gradient-to-br from-emerald-500 to-emerald-700
                                @else bg-gradient-to-br from-amber-500 to-amber-700 @endif
                                group-hover:scale-110 transition-transform duration-300">
                                {{ mb_substr($project->title, 0, 1) }}
                            </div>

                            <div class="flex-1 min-w-0">
                                <div class="truncate text-xs font-medium group-hover:text-white transition">{{ $project->title }}</div>
                                <div class="text-[10px] text-slate-600 truncate group-hover:text-slate-500">{{ $project->user->username }}</div>
                            </div>

                            @if($project->pivot->role === 'admin')
                                <i class="fa-solid fa-crown text-[10px] text-amber-500 opacity-0 group-hover:opacity-100 transition-opacity"></i>
                            @endif
                        </a>
                    @endforeach
                </div>
            </div>
        @endif
    </div>

    {{-- 3. الفوتر (الملف الشخصي) --}}
    <div class="p-4 border-t border-white/5 bg-[#0B1120] relative z-10">

        <style>
            @keyframes royal-pulse {
                0%, 100% { box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.4); }
                70% { box-shadow: 0 0 0 6px rgba(16, 185, 129, 0); }
            }
            .avatar-glow { animation: royal-pulse 2s infinite; }
        </style>

        <a href="{{ route('dashboard.profile') }}"
           class="flex items-center gap-3 p-3 rounded-2xl bg-slate-800/50 border border-white/5 hover:bg-slate-800 hover:border-emerald-500/30 transition-all duration-300 group relative overflow-hidden">

            <div class="absolute inset-0 bg-gradient-to-r from-emerald-500/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>

            <div class="relative shrink-0">
                @if (Auth::user()->avatar)
                    <img src="{{ asset('storage/' . Auth::user()->avatar) }}" class="w-10 h-10 rounded-full object-cover border-2 border-slate-700 group-hover:border-emerald-500 transition-colors {{ Auth::user()->is_admin ? 'avatar-glow' : '' }}">
                @else
                    <div class="w-10 h-10 rounded-full bg-gradient-to-br from-slate-700 to-slate-900 flex items-center justify-center font-bold text-sm text-white border-2 border-slate-600 group-hover:border-emerald-500 transition-colors">
                        {{ substr(Auth::user()->name, 0, 1) }}
                    </div>
                @endif

                <div class="absolute bottom-0 right-0 w-2.5 h-2.5 bg-emerald-500 border-2 border-[#0B1120] rounded-full"></div>
            </div>

            <div class="flex-1 min-w-0 relative z-10 text-right">
                <div class="flex items-center gap-1.5 justify-end">
                    @if(Auth::user()->is_admin)
                        <i class="fa-solid fa-circle-check text-emerald-500 text-[10px]" title="Verified Admin"></i>
                    @endif
                    <p class="text-sm font-bold text-white truncate group-hover:text-emerald-400 transition-colors">{{ Auth::user()->name }}</p>
                </div>
                <p class="text-[10px] text-slate-500 truncate font-mono">@ {{ Auth::user()->username }}</p>
            </div>

            <div class="relative z-10 text-slate-600 group-hover:text-white transition-transform duration-300 group-hover:-translate-x-1">
                <i class="fa-solid fa-chevron-left text-xs"></i>
            </div>
        </a>
    </div>
</aside>