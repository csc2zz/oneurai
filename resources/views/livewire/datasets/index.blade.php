<div class="min-h-screen bg-[#F0F4F8] font-sans text-slate-900 selection:bg-emerald-500 selection:text-white pb-20" dir="rtl">

    {{-- ========================================== --}}
    {{-- 1. Header Section: تصميم سيبراني حديث --}}
    {{-- ========================================== --}}
    <div class="relative bg-slate-900 pt-28 pb-20 overflow-hidden isolate">
        
        {{-- خلفية جمالية متحركة --}}
        <div class="absolute inset-0 -z-10 overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-br from-slate-900 via-[#0B1120] to-slate-900"></div>
            {{-- شبكة رقمية --}}
            <svg class="absolute inset-0 h-full w-full stroke-white/10 [mask-image:radial-gradient(100%_100%_at_top_right,white,transparent)]" aria-hidden="true">
                <defs>
                    <pattern id="983e3e4c-de6d-4c3f-8d64-b9761d1534cc" width="200" height="200" x="50%" y="-1" patternUnits="userSpaceOnUse">
                        <path d="M.5 200V.5H200" fill="none" />
                    </pattern>
                </defs>
                <rect width="100%" height="100%" stroke-width="0" fill="url(#983e3e4c-de6d-4c3f-8d64-b9761d1534cc)" />
            </svg>
            {{-- تأثير ضوئي --}}
            <div class="absolute left-[calc(50%-4rem)] top-10 -z-10 transform-gpu blur-3xl sm:left-[calc(50%-18rem)] lg:left-48 lg:top-[calc(50%-30rem)] xl:left-[calc(50%-24rem)]" aria-hidden="true">
                <div class="aspect-[1108/632] w-[69.25rem] bg-gradient-to-r from-[#80caff] to-[#4ade80] opacity-20" style="clip-path: polygon(73.6% 51.7%, 91.7% 11.8%, 100% 46.4%, 97.4% 82.2%, 92.5% 84.9%, 75.7% 64%, 55.3% 47.5%, 46.5% 49.4%, 45% 62.9%, 50.3% 87.2%, 21.3% 64.1%, 0.1% 100%, 5.4% 51.1%, 21.4% 63.9%, 58.9% 0.2%, 73.6% 51.7%)"></div>
            </div>
        </div>

        <div class="max-w-7xl mt-16 mx-auto px-6 relative z-10">
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-8">
                <div>
                    <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-slate-800/50 border border-slate-700 backdrop-blur-md text-emerald-400 text-[11px] font-mono font-bold mb-6 shadow-lg">
                        <span class="relative flex h-2 w-2">
                          <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                          <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                        </span>
                        DATA WAREHOUSE_V1
                    </div>
                    
                    <h1 class="text-4xl lg:text-7xl font-black text-white tracking-tight leading-none mb-2">
                        مكتبة البيانات
                        <span class="block text-transparent bg-clip-text bg-gradient-to-l from-emerald-400 to-cyan-400 font-mono mt-2 text-5xl lg:text-7xl">
                            {{ number_format($total_count) }}
                            <span class="text-2xl text-slate-500 align-top">+</span>
                        </span>
                    </h1>
                    <p class="text-slate-400 mt-6 text-lg font-medium max-w-xl leading-relaxed">
                        المستودع الأضخم للبيانات العربية. نصوص، صور، وأصوات جاهزة لتدريب نماذج الذكاء الاصطناعي الخاصة بك.
                    </p>
                </div>

                {{-- بار البحث بتصميم زجاجي --}}
                <div class="w-full md:w-[480px]">
                    <div class="relative group">
                        <div class="absolute -inset-1 bg-gradient-to-r from-emerald-600 to-cyan-600 rounded-2xl blur opacity-25 group-hover:opacity-75 transition duration-1000 group-hover:duration-200"></div>
                        <div class="relative bg-slate-900/80 backdrop-blur-xl border border-slate-700/50 rounded-2xl flex items-center p-1 shadow-2xl">
                            <div class="flex items-center justify-center w-14 text-slate-500 pl-2">
                                <i class="fa-solid fa-magnifying-glass text-xl group-focus-within:text-emerald-400 transition-colors"></i>
                            </div>
                            <input wire:model.live.debounce.300ms="search"
                                   type="text"
                                   placeholder="بحث في السجلات (نصوص، صوت، صور)..."
                                   class="w-full py-4 px-2 bg-transparent border-none focus:ring-0 font-bold text-lg text-white placeholder-slate-500 h-14">
                            
                            {{-- مؤشر التحميل --}}
                            <div wire:loading wire:target="search" class="absolute left-4">
                                <i class="fa-solid fa-circle-notch fa-spin text-emerald-500 text-xl"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-6 -mt-10 relative z-20">
        <div class="flex flex-col lg:flex-row gap-8">

            {{-- ========================================== --}}
            {{-- 2. Sidebar Filters: تصميم أنظف --}}
            {{-- ========================================== --}}
            <aside class="w-full lg:w-72 flex-shrink-0 space-y-6 lg:sticky lg:top-8 h-fit pb-10">

                @if($selected_tasks || $selected_sizes || $selected_licenses || $search)
                    <button wire:click="clearFilters"
                            class="w-full group relative overflow-hidden flex items-center justify-center gap-2 py-3 rounded-xl bg-white text-rose-600 text-xs font-black border border-rose-100 hover:border-rose-500 hover:shadow-lg transition-all shadow-sm">
                        <div class="absolute inset-0 w-0 bg-rose-500 transition-all duration-[250ms] ease-out group-hover:w-full opacity-10"></div>
                        <i class="fa-solid fa-trash-can group-hover:shake z-10"></i>
                        <span class="z-10">إعادة تعيين الفلاتر</span>
                    </button>
                @endif

                <div class="bg-white/80 backdrop-blur-sm rounded-2xl border border-white shadow-xl shadow-slate-200/50 p-6 space-y-8">
                    
                    {{-- Task Filter --}}
                    <div>
                        <h3 class="font-black text-slate-900 mb-5 text-[10px] uppercase tracking-widest flex items-center gap-2 border-b border-slate-100 pb-2">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                            نوع البيانات
                        </h3>
                        <div class="space-y-2 max-h-[300px] overflow-y-auto custom-scrollbar pl-1">
                            @foreach($tasks_list as $index => $task)
                                <label class="flex items-center gap-3 p-2 rounded-lg cursor-pointer transition-all hover:bg-slate-50 group border border-transparent hover:border-slate-100" wire:key="task-{{ $index }}">
                                    <div class="relative flex items-center">
                                        <input type="checkbox" wire:model.live="selected_tasks" value="{{ $task }}"
                                               class="peer shrink-0 appearance-none w-4 h-4 border-2 border-slate-300 rounded bg-white checked:bg-emerald-600 checked:border-emerald-600 focus:ring-0 transition-all">
                                        <i class="fa-solid fa-check absolute w-4 h-4 text-white text-[8px] flex items-center justify-center opacity-0 peer-checked:opacity-100 pointer-events-none"></i>
                                    </div>
                                    <span class="text-xs font-bold text-slate-600 group-hover:text-slate-900 transition-colors">{{ $task }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    {{-- Size Filter --}}
                    <div>
                        <h3 class="font-black text-slate-900 mb-5 text-[10px] uppercase tracking-widest flex items-center gap-2 border-b border-slate-100 pb-2">
                             <span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span>
                             حجم الملفات
                        </h3>
                        <div class="space-y-2">
                            @php
                                $size_options = [
                                    ['val' => 'small', 'label' => '< 10 MB', 'icon' => 'fa-feather', 'color' => 'text-emerald-500'],
                                    ['val' => 'medium', 'label' => '10 MB - 1 GB', 'icon' => 'fa-box', 'color' => 'text-blue-500'],
                                    ['val' => 'large', 'label' => '> 1 GB', 'icon' => 'fa-server', 'color' => 'text-purple-500'],
                                ];
                            @endphp
                            @foreach($size_options as $option)
                                <label class="flex items-center gap-3 cursor-pointer group">
                                    <input type="checkbox" wire:model.live="selected_sizes" value="{{ $option['val'] }}" class="peer hidden">
                                    <div class="w-full flex items-center justify-between px-4 py-2.5 rounded-lg border border-slate-200 bg-slate-50 text-[11px] font-mono font-bold text-slate-500 peer-checked:bg-slate-800 peer-checked:text-white peer-checked:border-slate-800 transition-all hover:bg-white hover:shadow-sm">
                                        <span>{{ $option['label'] }}</span>
                                        <i class="fa-solid {{ $option['icon'] }} {{ $option['color'] }} peer-checked:text-white"></i>
                                    </div>
                                </label>
                            @endforeach
                        </div>
                    </div>
                </div>
            </aside>

            {{-- ========================================== --}}
            {{-- 3. Main Content: البطاقات التقنية --}}
            {{-- ========================================== --}}
            <div class="flex-1">

                {{-- الفرز العلوي --}}
                <div class="flex flex-wrap justify-between items-center mb-8 gap-4 pb-2">
                    <div class="flex gap-1 bg-white p-1 rounded-xl shadow-sm border border-slate-200">
                        @foreach(['trending' => 'الرائج', 'newest' => 'الأحدث', 'downloads' => 'الأكثر تحميلاً'] as $key => $label)
                            <button wire:click="$set('sort', '{{ $key }}')"
                                    class="px-5 py-2 rounded-lg text-xs font-bold transition-all relative
                                    {{ $sort === $key ? 'bg-slate-900 text-white shadow-md' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-900' }}">
                                {{ $label }}
                                @if($sort === $key)
                                    <span class="absolute top-1 left-1 w-1.5 h-1.5 bg-emerald-400 rounded-full animate-pulse"></span>
                                @endif
                            </button>
                        @endforeach
                    </div>
                    <div wire:loading class="text-emerald-600 text-xs font-mono font-bold">
                         // FETCHING_DATA...
                    </div>
                </div>

                {{-- مصفوفة الأيقونات (تم تحسين الألوان لتكون أكثر احترافية) --}}
                @php
                    // تم تقليل عشوائية الألوان للتركيز على طابع تقني موحد مع لمسات ملونة
                    $styles = [
                        ['icon' => 'fa-database', 'bg' => 'bg-emerald-500/10', 'text' => 'text-emerald-600', 'border' => 'group-hover:border-emerald-500'],
                        ['icon' => 'fa-table', 'bg' => 'bg-blue-500/10', 'text' => 'text-blue-600', 'border' => 'group-hover:border-blue-500'],
                        ['icon' => 'fa-images', 'bg' => 'bg-purple-500/10', 'text' => 'text-purple-600', 'border' => 'group-hover:border-purple-500'],
                        ['icon' => 'fa-align-left', 'bg' => 'bg-slate-500/10', 'text' => 'text-slate-600', 'border' => 'group-hover:border-slate-500'],
                        ['icon' => 'fa-wave-square', 'bg' => 'bg-orange-500/10', 'text' => 'text-orange-600', 'border' => 'group-hover:border-orange-500'],
                        ['icon' => 'fa-video', 'bg' => 'bg-rose-500/10', 'text' => 'text-rose-600', 'border' => 'group-hover:border-rose-500'],
                        ['icon' => 'fa-microchip', 'bg' => 'bg-cyan-500/10', 'text' => 'text-cyan-600', 'border' => 'group-hover:border-cyan-500'],
                    ];
                @endphp

                {{-- Datasets Grid --}}
                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                    @forelse($datasets as $dataset)
                        @php
                            $style = $styles[$loop->index % count($styles)];
                        @endphp

                        <div class="group bg-white rounded-2xl p-0 transition-all duration-300 flex flex-col h-full relative hover:-translate-y-2 hover:shadow-2xl hover:shadow-slate-200/50 border border-slate-200 overflow-hidden {{ $style['border'] }}">
                            
                            {{-- Pattern Background inside card --}}
                            <div class="absolute top-0 right-0 p-4 opacity-[0.03] group-hover:opacity-10 transition-opacity">
                                <i class="fa-solid {{ $style['icon'] }} text-9xl text-slate-900 transform rotate-12 translate-x-4 -translate-y-4"></i>
                            </div>

                            <div class="p-6 flex flex-col h-full relative z-10">
                                {{-- Header --}}
                                <div class="flex justify-between items-start mb-5">
                                    <div class="w-14 h-14 rounded-2xl flex items-center justify-center text-2xl transition-all duration-300 {{ $style['bg'] }} {{ $style['text'] }} group-hover:scale-110 group-hover:rotate-3 shadow-inner">
                                        <i class="fa-solid {{ $style['icon'] }}"></i>
                                    </div>
                                    
                                    <div class="flex flex-col items-end">
                                        <span class="px-2.5 py-1 rounded-md bg-slate-900 text-white text-[10px] font-mono font-bold uppercase tracking-wider mb-1">
                                            {{ $dataset->task_type }}
                                        </span>
                                    </div>
                                </div>

                                {{-- Content --}}
                                <div class="flex-grow">
                                    <a href="{{ route('datasets.public.show', ['username' => $dataset->user->username, 'slug' => $dataset->slug]) }}"
                                       class="text-lg font-black text-slate-900 group-hover:text-emerald-600 transition-colors mb-2 block leading-tight line-clamp-1" dir="ltr">
                                        {{ $dataset->title }}
                                    </a>

                                    <div class="flex items-center gap-2 mb-4">
                                        <div class="w-5 h-5 rounded-full bg-slate-100 flex items-center justify-center text-[10px] text-slate-400">
                                            <i class="fa-solid fa-user"></i>
                                        </div>
                                        <span class="text-[11px] font-bold text-slate-400 font-mono" dir="ltr">{{ $dataset->user->username }}</span>
                                    </div>

                                    <p class="text-xs text-slate-500 leading-relaxed line-clamp-2 mb-6 font-medium h-8 opacity-80 group-hover:opacity-100 transition-opacity">
                                        {{ $dataset->description ?? 'لا يوجد وصف متاح لهذا السجل.' }}
                                    </p>
                                </div>

                                {{-- Tech Footer --}}
                                <div class="pt-4 border-t border-slate-100 flex items-center justify-between mt-auto">
                                    <div class="flex items-center gap-4 text-[11px] font-mono font-bold text-slate-500">
                                        {{-- Downloads --}}
                                        <span class="flex items-center gap-1.5 group-hover:text-emerald-600 transition-colors bg-slate-50 px-2 py-1 rounded">
                                            <i class="fa-solid fa-download text-[10px]"></i> {{ $dataset->formatted_downloads }}
                                        </span>
                                        
                                        {{-- Size --}}
                                        <span class="flex items-center gap-1.5 group-hover:text-blue-600 transition-colors">
                                            <i class="fa-solid fa-database text-[10px]"></i> {{ $dataset->formatted_size }}
                                        </span>
                                    </div>

                                    <span class="text-[9px] font-bold text-slate-300 uppercase tracking-wide group-hover:text-slate-400 transition-colors">
                                        {{ $dataset->updated_at->diffForHumans(short: true) }}
                                    </span>
                                </div>
                            </div>
                            
                            {{-- Hover Progress Line --}}
                            <div class="h-1 w-full bg-slate-100 absolute bottom-0 left-0">
                                <div class="h-full bg-emerald-500 w-0 group-hover:w-full transition-all duration-700 ease-out"></div>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full py-24 text-center border-2 border-dashed border-slate-200 rounded-3xl bg-slate-50/50">
                            <div class="w-24 h-24 bg-white rounded-full flex items-center justify-center mx-auto mb-6 text-4xl shadow-sm text-slate-200">
                                <i class="fa-solid fa-wind"></i>
                            </div>
                            <h3 class="text-xl font-black text-slate-900 mb-2">لا توجد سجلات</h3>
                            <p class="text-slate-400 font-medium text-sm font-mono">0 RESULTS FOUND_</p>
                        </div>
                    @endforelse
                </div>

                <div class="mt-16 flex justify-center" dir="ltr">
                    {{ $datasets->links() }}
                </div>

            </div>
        </div>
    </div>
    
    <style>
        .custom-scrollbar::-webkit-scrollbar { width: 3px; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #CBD5E1; border-radius: 10px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
    </style>
</div>