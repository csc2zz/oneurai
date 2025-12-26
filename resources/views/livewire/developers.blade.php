<div class="min-h-screen bg-[#050505] font-sans selection:bg-emerald-500 selection:text-white pb-20 overflow-x-hidden text-slate-200" dir="rtl">

    {{-- ================= الخلفية السينمائية ================= --}}
    <div class="fixed inset-0 z-0 pointer-events-none">
        <div class="absolute inset-0 opacity-[0.03] bg-[url('https://grainy-gradients.vercel.app/noise.svg')]"></div>
        <div class="absolute top-[-10%] right-[-10%] w-[50%] h-[50%] bg-emerald-600/20 blur-[150px] rounded-full animate-pulse"></div>
        <div class="absolute bottom-[-10%] left-[-10%] w-[50%] h-[50%] bg-blue-600/10 blur-[150px] rounded-full"></div>
        <div class="absolute inset-0 bg-[linear-gradient(to_right,#ffffff05_1px,transparent_1px),linear-gradient(to_bottom,#ffffff05_1px,transparent_1px)] bg-[size:60px_60px] [mask-image:radial-gradient(ellipse_60%_50%_at_50%_0%,#000_70%,transparent_100%)]"></div>
    </div>

    {{-- ================= الهيدر (Hero Section) ================= --}}
    <div class="relative z-10 pt-24 pb-16 md:pt-32 md:pb-24 text-center px-4">
        <div class="max-w-6xl mt-16 mx-auto">
            
            {{-- بادج لوحة الشرف --}}
            <div class="mb-8 flex justify-center animate-fade-in-down">
                <div class="inline-flex items-center gap-3 px-5 py-2 rounded-full border border-white/10 bg-white/5 backdrop-blur-md shadow-2xl">
                    <span class="relative flex h-2.5 w-2.5">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-emerald-500"></span>
                    </span>
                    <span class="text-xs font-black tracking-widest text-emerald-400 uppercase">مجتمع نخبة المطورين</span>
                </div>
            </div>

            {{-- العنوان --}}
            <h1 class="text-6xl sm:text-7xl md:text-8xl lg:text-9xl font-black mb-8 leading-none">
                <span class="text-white drop-shadow-[0_0_30px_rgba(255,255,255,0.2)]">عمالقة</span>
                <br>
                <span class="relative inline-block mt-4 text-transparent bg-clip-text bg-gradient-to-l from-emerald-400 via-teal-300 to-blue-500 animate-gradient-x">
                    Oneurai
                </span>
            </h1>
            
            <p class="text-slate-400 text-lg md:text-2xl font-light max-w-2xl mx-auto mb-12 leading-relaxed">
                اكتشف العقول المبدعة التي ترسم ملامح <span class="text-white font-bold underline decoration-emerald-500/50 underline-offset-8">المستقبل الذكي</span>.
            </p>

            {{-- بار البحث --}}
            <div class="mt-12 max-w-2xl mx-auto relative group z-20">
                <div class="absolute -inset-1 bg-gradient-to-r from-emerald-500 to-blue-600 rounded-[28px] blur opacity-20 group-focus-within:opacity-60 transition duration-1000"></div>
                <div class="relative bg-[#0a0a0a]/90 backdrop-blur-2xl border border-white/10 rounded-[24px] p-2 flex items-center">
                    <div class="pr-6 text-emerald-500">
                        <i class="fa-solid fa-magnifying-glass text-xl"></i>
                    </div>
                    <input wire:model.live="search" type="text"
                           placeholder="ابحث عن مطور، خبير، أو مهندس برمجيات..."
                           class="w-full bg-transparent border-none focus:ring-0 text-white font-medium placeholder:text-slate-600 h-14 text-lg px-4">
                    <button class="ml-2 px-8 py-3.5 bg-emerald-600 hover:bg-emerald-500 text-white font-black rounded-xl transition-all shadow-lg active:scale-95">
                        بحث
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- ================= شبكة المطورين ================= --}}
    <div class="max-w-[1700px] mx-auto px-6 relative z-20">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 2xl:grid-cols-5 gap-8">
            
            @forelse($developers as $dev)
                @php
                    $devColor = match($dev->id) {
                        1 => 'emerald',
                        3 => 'blue',
                        7 => 'purple',
                        default => 'emerald'
                    };
                @endphp

                <div class="group relative">
                    {{-- التوهج الخلفي --}}
                    <div class="absolute -inset-0.5 bg-gradient-to-b from-{{ $devColor }}-500/30 to-transparent rounded-[40px] opacity-0 group-hover:opacity-100 transition duration-700 blur-2xl"></div>
                    
                    <div class="relative h-full bg-[#0f0f0f] border border-white/5 rounded-[38px] overflow-hidden transition-all duration-500 group-hover:-translate-y-4 group-hover:border-white/20 shadow-2xl">
                        
                        {{-- خلفية الهيدر --}}
                        <div class="relative h-32 overflow-hidden">
                            <div class="absolute inset-0 bg-gradient-to-bl from-{{ $devColor }}-900/40 to-black"></div>
                        </div>

                        {{-- محتوى الكارت --}}
                        <div class="relative px-6 pb-8">
                            {{-- الصورة الشخصية --}}
                            <div class="relative -mt-16 mb-6 flex justify-center">
                                <div class="relative p-1 rounded-[32px] bg-gradient-to-t from-white/10 to-transparent group-hover:from-{{ $devColor }}-500 transition-all duration-500">
                                    <div class="w-24 h-24 rounded-[28px] overflow-hidden bg-[#151515] p-1">
                                        @if($dev->avatar)
                                            <img src="{{ asset('storage/' . $dev->avatar) }}" class="w-full h-full object-cover rounded-[24px] grayscale-[30%] group-hover:grayscale-0 transition-all">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center rounded-[24px] bg-{{ $devColor }}-500/10 text-{{ $devColor }}-500 text-4xl font-black">
                                                {{ mb_substr($dev->name, 0, 1) }}
                                            </div>
                                        @endif
                                    </div>

                                    @if($dev->is_admin)
                                        <div class="absolute -top-2 -left-2 w-9 h-9 bg-gradient-to-br from-amber-400 to-orange-600 rounded-xl flex items-center justify-center shadow-xl border border-white/20 animate-bounce-slow">
                                            <i class="fa-solid fa-crown text-white text-[10px]"></i>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            {{-- المعلومات الشخصية --}}
                            <div class="text-center">
                                <h3 class="text-2xl font-black text-white mb-1 group-hover:text-{{ $devColor }}-400 transition-colors">
                                    {{ $dev->name }}
                                </h3>
                                <div class="flex items-center justify-center gap-2 mb-8">
                                    <span class="text-sm font-medium text-slate-500">{{ '@' . $dev->username }}</span>
                                    <span class="h-1 w-1 rounded-full bg-slate-800"></span>
                                    <span class="text-[10px] font-black text-emerald-400 bg-emerald-500/5 px-2 py-0.5 rounded border border-emerald-500/10 uppercase tracking-tighter">موثق</span>
                                </div>

                                {{-- الإحصائيات --}}
                                <div class="grid grid-cols-3 gap-2 mb-8">
                                    <div class="py-3 px-1 rounded-2xl bg-white/[0.03] border border-white/[0.05] group-hover:bg-{{ $devColor }}-500/5 transition-all">
                                        <div class="text-base font-black text-white">{{ $dev->followers_count }}</div>
                                        <div class="text-[9px] text-slate-500 font-bold mt-1">متابع</div>
                                    </div>
                                    <div class="py-3 px-1 rounded-2xl bg-white/[0.03] border border-white/[0.05] group-hover:bg-{{ $devColor }}-500/5 transition-all">
                                        <div class="text-base font-black text-white">{{ $dev->projects_count }}</div>
                                        <div class="text-[9px] text-slate-500 font-bold mt-1">مشروع</div>
                                    </div>
                                    <div class="py-3 px-1 rounded-2xl bg-white/[0.03] border border-white/[0.05] group-hover:bg-{{ $devColor }}-500/5 transition-all">
                                        <div class="text-base font-black text-white">{{ $dev->models_count }}</div>
                                        <div class="text-[9px] text-slate-500 font-bold mt-1">نموذج</div>
                                    </div>
                                </div>

                                {{-- الزر --}}
                               <a href="{{ route('profile.show', $dev->username) }}" 
   class="relative flex items-center justify-center w-full py-4 bg-white/[0.05] text-white font-black text-xs uppercase tracking-widest rounded-2xl transition-all duration-500 overflow-hidden group/btn">
    
    {{-- النص الأساسي: أضفنا group-hover/btn:hidden ليختفي عند الهوفر --}}
    <span class="relative z-10 flex items-center gap-2 group-hover/btn:hidden transition-all duration-300">
         استعراض الملف <i class="fa-solid fa-arrow-left text-[10px]"></i>
    </span>

    {{-- الخلفية المتدرجة --}}
    <div class="absolute inset-0 bg-gradient-to-l from-emerald-500 to-blue-600 opacity-0 group-hover/btn:opacity-100 transition-opacity duration-500"></div>

    {{-- النص البديل: يظهر فقط عند الهوفر --}}
    <span class="relative z-10 hidden group-hover/btn:flex items-center gap-2 text-white transition-all duration-300">
         زيارة الهوية الرقمية <i class="fa-solid fa-arrow-left text-[10px]"></i>
    </span>
</a>
                            </div>
                        </div>
                    </div>
                </div>

            @empty
                <div class="col-span-full py-40 text-center">
                    <div class="relative inline-block mb-8">
                        <div class="absolute inset-0 blur-3xl bg-emerald-500/10 rounded-full"></div>
                        <i class="fa-solid fa-mask-soft text-8xl text-white/5"></i>
                    </div>
                    <h3 class="text-3xl font-black text-white mb-4">لم نجد أي عملاق!</h3>
                    <p class="text-slate-500 max-w-sm mx-auto mb-10 text-lg">لا توجد نتائج تطابق بحثك حالياً، جرب البحث باسم آخر.</p>
                    <button wire:click="$set('search', '')" class="px-12 py-4 bg-emerald-600 hover:bg-emerald-500 text-white font-black rounded-2xl transition-all">
                        عرض جميع المطورين
                    </button>
                </div>
            @endforelse
        </div>

        {{-- الترقيم --}}
        @if($developers->hasPages())
        <div class="mt-24 flex justify-center">
            <div class="px-8 py-3 rounded-full bg-white/5 border border-white/10 backdrop-blur-xl">
                {{ $developers->links() }}
            </div>
        </div>
        @endif
    </div>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Cairo:wght@200;400;700;900&display=swap');
        
        body { font-family: 'Cairo', sans-serif; }

        .animate-bounce-slow { animation: bounce 4s infinite; }
        @keyframes bounce { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-8px); } }

        .animate-gradient-x {
            background-size: 200% 200%;
            animation: gradient-x 4s linear infinite;
        }
        @keyframes gradient-x {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        .animate-fade-in-down { animation: fadeInDown 1s ease-out; }
        @keyframes fadeInDown {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</div>