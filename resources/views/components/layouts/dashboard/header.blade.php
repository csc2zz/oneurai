<header class="h-20 flex items-center justify-between px-6 sticky top-0 z-20 transition-all duration-300"
        x-data="{ isScrolled: false }"
        @scroll.window="isScrolled = (window.pageYOffset > 10)"
        :class="isScrolled ? 'bg-white/80 backdrop-blur-xl border-b border-slate-200/60 shadow-sm' : 'bg-transparent border-b border-transparent'">

    {{-- 1. القسم الأيمن: البحث والقائمة --}}
    <div class="flex items-center gap-6 w-full max-w-2xl">

        {{-- زر القائمة للجوال --}}
        <button @click="sidebarOpen = true" class="lg:hidden p-2 text-slate-500 hover:text-emerald-600 transition rounded-xl hover:bg-slate-100">
            <i class="fa-solid fa-bars-staggered text-xl"></i>
        </button>

        {{-- شريط البحث المتطور (Spotlight Style) --}}
        <div class="relative w-full max-w-md hidden sm:block group">
            <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none text-slate-400 group-focus-within:text-emerald-500 transition-colors">
                <i class="fa-solid fa-magnifying-glass"></i>
            </div>

            <input type="text"
                   placeholder="بحث في المشاريع، الملفات..."
                   class="w-full bg-slate-100/50 border border-slate-200 rounded-2xl py-2.5 pr-11 pl-12 text-sm text-slate-700 placeholder:text-slate-400 focus:bg-white focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 outline-none transition-all shadow-sm group-hover:bg-white group-hover:shadow-md">

            {{-- تلميح اختصار الكيبورد (شكل جمالي) --}}
            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                <span class="text-[10px] font-bold text-slate-400 bg-white border border-slate-200 rounded px-1.5 py-0.5 shadow-sm">⌘ K</span>
            </div>
        </div>
    </div>

    {{-- 2. القسم الأيسر: الإجراءات --}}
    <div class="flex items-center gap-3">

        {{-- زر تحميل البرنامج (بتأثير التحميل) --}}
        <div x-data="{ loading: false, finished: false }">
            <button @click="loading = true; setTimeout(() => { loading = false; finished = true; setTimeout(() => finished = false, 2000) }, 3000)"
                    :class="{ 'bg-blue-50 text-blue-600 cursor-wait': loading, 'bg-emerald-50 text-emerald-600': finished, 'hover:bg-slate-100 text-slate-500': !loading && !finished }"
                    class="w-10 h-10 rounded-xl flex items-center justify-center transition-all duration-300 relative overflow-hidden group"
                    title="تحميل التطبيق">

                {{-- الأيقونة العادية --}}
                <i x-show="!loading && !finished" class="fa-solid fa-cloud-arrow-down text-lg transition-transform group-hover:-translate-y-0.5"></i>

                {{-- أيقونة التحميل --}}
                <i x-show="loading" class="fa-solid fa-circle-notch fa-spin text-lg" style="display: none;"></i>

                {{-- أيقونة النجاح --}}
                <i x-show="finished" class="fa-solid fa-check text-lg animate-bounce-short" style="display: none;"></i>

                {{-- شريط التقدم السفلي --}}
                <div x-show="loading" class="absolute bottom-0 left-0 h-1 bg-blue-500 transition-all duration-[3000ms] ease-out w-0"
                     x-init="$watch('loading', value => { if(value) { $el.style.width = '100%' } else { $el.style.width = '0' } })"></div>
            </button>
        </div>

        {{-- التنبيهات (بتصميم متناسق) --}}
        <div class="w-10 h-10 rounded-xl hover:bg-slate-100 flex items-center justify-center transition cursor-pointer text-slate-500 hover:text-emerald-600 relative group">
             {{-- استبدل هذا بالمكون الحقيقي --}}
             <livewire:layouts.header-notifications wire:poll.1s />
        </div>

        {{-- فاصل --}}
        <div class="h-8 w-px bg-slate-200 hidden sm:block mx-1"></div>
        @if(Auth::user()->is_admin)
    <form action="{{ url('/admin') }}" method="GET" class="inline">
        <button type="submit" 
                class="w-10 h-10 rounded-xl border border-slate-200 text-slate-500 hover:text-emerald-600 hover:bg-emerald-50 hover:border-emerald-100 flex items-center justify-center transition-all shadow-sm"
                title="إدارة النظام">
            <i class="fa-solid fa-user-shield text-sm"></i>
        </button>
    </form>
@endif

        {{-- زر "جديد" المميز --}}
        <a href="{{ route('projects.create') }}"
           class="hidden sm:flex items-center gap-2 bg-slate-900 hover:bg-emerald-600 text-white px-5 py-2.5 rounded-xl text-sm font-bold transition-all shadow-lg hover:shadow-emerald-500/30 transform active:scale-95 group">
            <i class="fa-solid fa-plus transition-transform group-hover:rotate-90"></i>
            <span>مشروع</span>
        </a>

        {{-- زر تسجيل الخروج (مخصص) --}}
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit"
                    class="w-10 h-10 rounded-xl border border-slate-200 text-slate-500 hover:text-red-600 hover:bg-red-50 hover:border-red-100 flex items-center justify-center transition-all shadow-sm"
                    title="تسجيل الخروج">
                <i class="fa-solid fa-power-off text-sm"></i>
            </button>
        </form>

    </div>
</header>
