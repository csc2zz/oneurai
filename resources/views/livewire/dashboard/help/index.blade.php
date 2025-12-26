<div class="py-8 px-4 max-w-6xl mx-auto space-y-12 overflow-y-auto h-full custom-scrollbar">
    
    {{-- هيدر البحث --}}
    <div class="text-center space-y-6">
        <h1 class="text-3xl md:text-4xl font-extrabold text-slate-800 tracking-tight">مركز مساعدة Oneurai</h1>
        <p class="text-slate-500 max-w-lg mx-auto text-sm md:text-base leading-relaxed">
            كل ما تحتاجه للنجاح في تطوير مشاريعك ومشاركتها مع مجتمع المطورين السعودي.
        </p>
        
        <div class="max-w-2xl mx-auto relative group mt-8">
            <div class="absolute inset-0 bg-emerald-500/5 blur-xl rounded-full group-focus-within:bg-emerald-500/10 transition"></div>
            <input type="text" wire:model.live.debounce.300ms="search" placeholder="ابحث عن حل لمشكلتك..."
                class="relative w-full bg-white border border-slate-200 rounded-3xl py-4 md:py-5 pr-14 pl-6 text-sm shadow-sm focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 outline-none transition-all">
            <i class="fa-solid fa-magnifying-glass absolute right-6 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-emerald-500 transition"></i>
        </div>
    </div>

    {{-- أقسام الدعم --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        @php
            $sections = [
                ['icon' => 'fa-rocket', 'title' => 'البداية السريعة', 'color' => 'bg-blue-50 text-blue-600'],
                ['icon' => 'fa-code-merge', 'title' => 'إدارة الأكواد', 'color' => 'bg-emerald-50 text-emerald-600'],
                ['icon' => 'fa-shield-halved', 'title' => 'الأمان والخصوصية', 'color' => 'bg-purple-50 text-purple-600'],
            ];
        @endphp
        @foreach($sections as $section)
            <div class="bg-white p-6 rounded-[2rem] border border-slate-100 hover:shadow-xl hover:shadow-slate-200/50 transition-all cursor-pointer group">
                <div class="w-12 h-12 {{ $section['color'] }} rounded-2xl flex items-center justify-center text-xl mb-4 group-hover:scale-110 transition-transform">
                    <i class="fa-solid {{ $section['icon'] }}"></i>
                </div>
                <h3 class="font-bold text-slate-800">{{ $section['title'] }}</h3>
                <p class="text-xs text-slate-400 mt-2">استكشف الدروس المتعلقة بـ {{ $section['title'] }}</p>
            </div>
        @endforeach
    </div>

    {{-- الأسئلة الشائعة --}}
    <div class="bg-white rounded-[2.5rem] border border-slate-100 p-6 md:p-10 shadow-sm">
        <h2 class="text-xl font-bold text-slate-800 mb-8 flex items-center gap-3">
            <i class="fa-solid fa-lightbulb text-amber-400"></i> الأسئلة الأكثر شيوعاً
        </h2>

        <div class="space-y-4" x-data="{ active: null }">
            @forelse($faqs as $index => $faq)
                <div class="border border-slate-50 rounded-2xl overflow-hidden transition-all" :class="active === {{ $index }} ? 'bg-slate-50 border-slate-200' : ''">
                    <button @click="active = (active === {{ $index }} ? null : {{ $index }})" 
                        class="w-full flex items-center justify-between p-4 md:p-5 text-right outline-none">
                        <span class="text-sm font-bold text-slate-700" :class="active === {{ $index }} ? 'text-emerald-600' : ''">{{ $faq['q'] }}</span>
                        <i class="fa-solid fa-chevron-down text-[10px] text-slate-400 transition-transform" :class="active === {{ $index }} ? 'rotate-180 text-emerald-500' : ''"></i>
                    </button>
                    <div x-show="active === {{ $index }}" x-collapse x-cloak>
                        <div class="px-5 pb-5 text-xs text-slate-500 leading-relaxed italic">
                            {{ $faq['a'] }}
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center py-10">
                    <p class="text-slate-400 text-sm">لم نجد نتائج مطابقة لبحثك..</p>
                </div>
            @endforelse
        </div>
    </div>

    {{-- فوتر المساعدة --}}
    <div class="bg-[#0B1120] rounded-[2.5rem] p-8 md:p-12 text-center relative overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-r from-emerald-600/20 to-transparent"></div>
        <div class="relative z-10 space-y-6">
            <h2 class="text-2xl font-bold text-white">مازلت تحتاج للمساعدة؟</h2>
            <p class="text-slate-400 text-sm max-w-md mx-auto">فريق دعم Oneurai متاح دائماً للإجابة على استفساراتك البرمجية والتقنية.</p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('dashboard.tickets.create') }}" class="bg-emerald-600 hover:bg-emerald-700 text-white px-8 py-4 rounded-2xl font-bold text-sm transition-all shadow-lg shadow-emerald-600/20 flex items-center justify-center gap-2">
                    <i class="fa-solid fa-ticket"></i> فتح تذكرة دعم
                </a>
                <button disabled class="bg-white/5 hover:bg-white/10 text-white px-8 py-4 rounded-2xl font-bold text-sm transition-all border border-white/10 flex items-center justify-center gap-2">
                    <i class="fa-solid fa-comments"></i> دردشة مباشرة
                </button>
            </div>
        </div>
    </div>
</div>