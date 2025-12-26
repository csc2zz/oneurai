<div class="min-h-screen bg-[#050505] text-slate-200 pb-20 font-sans selection:bg-rose-500 selection:text-white relative overflow-hidden" dir="rtl">

    {{-- ================= الخلفية الفضائية (Rose Nebula) ================= --}}
    <div class="absolute inset-0 z-0 pointer-events-none">
        <div class="absolute top-[-10%] left-[20%] w-[60%] h-[60%] bg-rose-900/10 blur-[150px] rounded-full animate-pulse"></div>
        <div class="absolute bottom-[-10%] right-[10%] w-[60%] h-[60%] bg-purple-900/10 blur-[150px] rounded-full"></div>
        <div class="absolute inset-0 bg-[url('https://grainy-gradients.vercel.app/noise.svg')] opacity-[0.03]"></div>
    </div>

    <div class="relative z-10 max-w-7xl mt-16 mx-auto px-6 py-10 lg:py-16">

        {{-- ================= الهيدر والبحث ================= --}}
        <div class="flex flex-col items-center justify-center text-center mb-16 animate-fade-in-down">
            
            {{-- بادج العنوان --}}
            <div class="inline-flex items-center gap-3 px-6 py-2 rounded-full border border-rose-500/20 bg-rose-500/5 backdrop-blur-md mb-8 shadow-[0_0_40px_rgba(244,63,94,0.15)]">
                <i class="fa-solid fa-gamepad text-rose-500 animate-bounce"></i>
                <span class="text-xs font-black text-rose-300 tracking-widest uppercase">Oneurai Arcade</span>
            </div>

            <h1 class="text-4xl md:text-6xl lg:text-7xl font-black text-white mb-6 leading-tight">
                ساحة <span class="text-transparent bg-clip-text bg-gradient-to-l from-rose-500 via-pink-500 to-purple-500 animate-gradient">الألعاب والتحديات</span>
            </h1>
            
            {{-- شريط الفلترة والبحث --}}
            <div class="w-full max-w-4xl mt-10 p-2 rounded-3xl bg-[#0f0f0f]/80 backdrop-blur-xl border border-white/10 flex flex-col md:flex-row items-center gap-2 shadow-2xl">
                
                {{-- أزرار الفلترة --}}
                <div class="flex items-center gap-2 w-full md:w-auto overflow-x-auto p-1 no-scrollbar">
                    @foreach(['all' => 'الكل', 'html5' => 'ويب', 'python' => 'سطح مكتب', 'quiz' => 'تحديات'] as $key => $label)
                        <button wire:click="setFilter('{{ $key }}')" 
                                class="px-6 py-3 rounded-xl text-sm font-bold transition-all duration-300 whitespace-nowrap
                                {{ $filter === $key 
                                    ? 'bg-rose-600 text-white shadow-lg shadow-rose-600/20' 
                                    : 'text-slate-400 hover:bg-white/5 hover:text-white' }}">
                            {{ $label }}
                        </button>
                    @endforeach
                </div>

                <div class="h-8 w-[1px] bg-white/10 hidden md:block mx-2"></div>

                {{-- حقل البحث --}}
                <div class="relative flex-1 w-full">
                    <i class="fa-solid fa-magnifying-glass absolute right-4 top-1/2 -translate-y-1/2 text-slate-500"></i>
                    <input wire:model.live.debounce.300ms="search" type="text" 
                           placeholder="ابحث عن لعبة، تحدي، أو مسابقة..." 
                           class="w-full bg-transparent border-none focus:ring-0 text-white placeholder:text-slate-600 h-12 pr-10 rounded-xl font-medium">
                </div>
            </div>
        </div>

        {{-- ================= شبكة الألعاب ================= --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            
            @forelse($games as $game)
                @php
                    // تحديد الألوان والأيقونات بناءً على النوع
                    $badgeColor = match($game->type) {
                        'html5' => 'text-orange-400 border-orange-500/50 bg-orange-500/10',
                        'python', 'download', 'download_file', 'external_link' => 'text-blue-400 border-blue-500/50 bg-blue-500/10',
                        'quiz' => 'text-purple-400 border-purple-500/50 bg-purple-500/10',
                        default => 'text-slate-400 border-slate-500/50 bg-slate-500/10'
                    };
                    $icon = match($game->type) {
                        'html5' => 'fa-globe',
                        'python', 'download', 'download_file', 'external_link' => 'fa-desktop',
                        'quiz' => 'fa-stopwatch', // ساعة توقيت للكويز
                        default => 'fa-gamepad'
                    };
                    $btnText = match($game->type) {
                        'html5' => 'العب الآن',
                        'quiz' => 'ابدأ التحدي',
                        default => 'تحميل اللعبة'
                    };
                @endphp

                <div class="group relative h-[420px] rounded-[35px] overflow-hidden bg-[#0a0a0a] border border-white/5 hover:border-rose-500/50 transition-all duration-500 hover:-translate-y-2 hover:shadow-[0_20px_50px_-10px_rgba(244,63,94,0.15)]">
                    
                    {{-- 1. صورة الغلاف (خلفية) --}}
                    <div class="absolute inset-0">
                        @if($game->thumbnail)
                            <img src="{{ asset('storage/' . $game->thumbnail) }}" class="w-full h-full object-cover opacity-60 group-hover:scale-110 group-hover:opacity-40 transition-all duration-700 grayscale-[30%] group-hover:grayscale-0">
                        @else
                            {{-- اذا مافيه صورة، نحط تدرج لوني افتراضي --}}
                            <div class="w-full h-full bg-gradient-to-br from-slate-800 via-rose-900/20 to-black group-hover:scale-110 transition-transform duration-700"></div>
                        @endif
                        {{-- طبقة تعتيم سفلية لقراءة النص --}}
                        <div class="absolute inset-0 bg-gradient-to-t from-[#0a0a0a] via-[#0a0a0a]/80 to-transparent"></div>
                    </div>

                    {{-- 2. المحتوى --}}
                    <div class="absolute inset-0 p-8 flex flex-col justify-between z-10">
                        
                        {{-- الجزء العلوي: البادج --}}
                        <div class="flex justify-between items-start translate-y-4 opacity-0 group-hover:translate-y-0 group-hover:opacity-100 transition-all duration-500 delay-100">
                            <span class="{{ $badgeColor }}/20 border px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest backdrop-blur-md {{ $badgeColor }}">
                                <i class="fa-solid {{ $icon }} ml-1"></i> {{ strtoupper($game->type == 'html5' ? 'WEB GAME' : ($game->type == 'quiz' ? 'QUIZ' : 'DESKTOP')) }}
                            </span>
                        </div>

                        {{-- الجزء السفلي: المعلومات --}}
                        <div class="translate-y-4 group-hover:translate-y-0 transition-transform duration-500">
                            <h3 class="text-3xl font-black text-white mb-2 leading-none group-hover:text-rose-400 transition-colors drop-shadow-lg">
                                {{ $game->title }}
                            </h3>
                            <p class="text-slate-400 text-sm mb-6 line-clamp-2 leading-relaxed">
                                {{ $game->description ?? 'استعد لتجربة فريدة وتحدي جديد في ساحة Oneurai.' }}
                            </p>

                            {{-- زر الإجراء (Action Button) --}}
                            {{-- ملاحظة: هنا سنحتاج لاحقاً لصفحة 'Play' --}}
                            <a href="{{ route('games.show', $game->slug) }}" class="block w-full py-4 rounded-2xl bg-white/5 border border-white/10 hover:bg-rose-600 hover:border-rose-500 text-white font-bold text-center backdrop-blur-md transition-all duration-300 group/btn overflow-hidden relative shadow-lg">
                                <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/20 to-transparent -translate-x-full group-hover/btn:translate-x-full transition-transform duration-1000"></div>
                                <span class="relative flex items-center justify-center gap-2">
                                    {{ $btnText }}
                                    <i class="fa-solid fa-arrow-left transition-transform group-hover/btn:-translate-x-1"></i>
                                </span>
                            </a>
                        </div>
                    </div>
                </div>

            @empty
                {{-- حالة عدم وجود ألعاب --}}
                <div class="col-span-full py-20 text-center animate-fade-in-down">
                    <div class="relative inline-block mb-6">
                        <div class="absolute inset-0 blur-2xl bg-rose-500/20 rounded-full"></div>
                        <i class="fa-solid fa-gamepad text-7xl text-white/20 relative"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-white mb-2">لا توجد ألعاب حالياً</h3>
                    <p class="text-slate-500">جاري تجهيز الساحة، عد قريباً للمزيد من التحديات!</p>
                </div>
            @endforelse

        </div>

        {{-- الترقيم --}}
        <div class="mt-16 flex justify-center">
            <div class="bg-white/5 border border-white/10 rounded-2xl p-2 backdrop-blur-xl">
                {{ $games->links() }}
            </div>
        </div>
    </div>
    
    <style>
        .animate-fade-in-down { animation: fadeInDown 0.8s ease-out; }
        @keyframes fadeInDown { from { opacity: 0; transform: translateY(-20px); } to { opacity: 1; transform: translateY(0); } }
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
        .animate-gradient { background-size: 200% auto; animation: gradient 3s linear infinite; }
        @keyframes gradient { to { background-position: 200% center; } }
    </style>
</div>