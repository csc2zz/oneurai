<div class="min-h-screen bg-[#F1F5F9] font-sans text-slate-900 selection:bg-indigo-500 selection:text-white pb-20" dir="rtl">

    {{-- ========================================== --}}
    {{-- 1. Header Section: المختبر الرقمي --}}
    {{-- ========================================== --}}
    <div class="relative bg-[#0B1120] pt-28 pb-24 overflow-hidden isolate">
        {{-- خلفية جمالية بتأثير الدوائر --}}
        <div class="absolute inset-0 -z-10">
            <div class="absolute inset-0 bg-[url('https://grainy-gradients.vercel.app/noise.svg')] opacity-20 brightness-100 contrast-150"></div>
            <div class="absolute top-0 right-0 -translate-y-12 translate-x-12 blur-3xl opacity-30">
                <div class="aspect-[801/1036] w-[50.0625rem] bg-gradient-to-tr from-[#ff80b5] to-[#9089fc] opacity-30" style="clip-path: polygon(63.1% 29.5%, 100% 17.1%, 76.6% 3%, 48.4% 0%, 44.6% 4.7%, 54.5% 25.3%, 59.8% 49%, 55.2% 57.8%, 44.4% 57.2%, 27.8% 47.9%, 35.1% 81.5%, 0% 97.7%, 39.2% 100%, 35.2% 81.4%, 97.2% 52.8%, 63.1% 29.5%)"></div>
            </div>
        </div>

        <div class="max-w-7xl mt-16 mx-auto px-6 relative z-10">
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-10">
                <div class="relative">
                    <div class="absolute -left-4 top-0 bottom-0 w-1 bg-gradient-to-b from-indigo-500 to-transparent"></div>
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded bg-indigo-500/10 border border-indigo-500/20 text-indigo-300 text-[10px] font-mono font-bold uppercase tracking-widest mb-4">
                        <span class="w-1.5 h-1.5 rounded-full bg-indigo-400 animate-pulse"></span>
                        AI MODEL REPOSITORY
                    </div>
                    <h1 class="text-5xl lg:text-7xl font-black text-white tracking-tighter leading-none mb-1">
                        النماذج الذكية
                    </h1>
                    <div class="flex items-baseline gap-2">
                        <span class="text-slate-500 font-mono text-lg">INDEXING_</span>
                        <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-400 to-cyan-400 font-mono text-4xl lg:text-5xl font-bold">
                            {{ number_format($modelsCount) }}
                        </span>
                        <span class="text-slate-500 font-mono text-sm">MODELS</span>
                    </div>
                </div>

                {{-- بار البحث بتصميم تقني --}}
                <div class="w-full md:w-[500px]">
                    <div class="relative group">
                        <div class="absolute -inset-0.5 bg-gradient-to-r from-indigo-500 to-purple-600 rounded-lg blur opacity-30 group-hover:opacity-75 transition duration-200"></div>
                        <div class="relative flex items-center bg-slate-900 border border-slate-700 rounded-lg p-1">
                            <div class="flex items-center justify-center w-12 text-slate-500 pl-2 border-l border-slate-700">
                                <i class="fa-solid fa-terminal text-sm"></i>
                            </div>
                            <input wire:model.live.debounce.300ms="search"
                                   type="text"
                                   placeholder="بحث في النواة (Llama 3, GPT, Whisper)..."
                                   class="w-full py-3 px-4 bg-transparent border-none focus:ring-0 font-mono text-sm text-white placeholder-slate-600 h-12">
                            <div wire:loading wire:target="search" class="px-4">
                                <i class="fa-solid fa-circle-notch fa-spin text-indigo-500"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-6 -mt-12 relative z-20">
        <div class="flex flex-col lg:flex-row gap-8">

            {{-- ========================================== --}}
            {{-- 2. Sidebar Filters: لوحة التحكم التقنية --}}
            {{-- ========================================== --}}
            <aside class="w-full lg:w-72 flex-shrink-0 space-y-4 lg:sticky lg:top-8 h-fit pb-10">

                {{-- زر التنظيف --}}
                @if(!empty($task) || !empty($framework) || !empty($language) || $search)
                    <button wire:click="clearFilters"
                            class="w-full group relative overflow-hidden flex items-center justify-center gap-2 py-3 rounded bg-slate-900 text-white text-xs font-mono border border-slate-700 hover:border-red-500 hover:text-red-400 transition-all shadow-lg">
                        <span class="absolute inset-0 bg-red-500/10 translate-y-full group-hover:translate-y-0 transition-transform duration-300"></span>
                        <i class="fa-solid fa-power-off"></i>
                        RESET_SYSTEM
                    </button>
                @endif

                <div class="bg-white/90 backdrop-blur border border-slate-200 shadow-sm rounded-lg p-5 space-y-8">
                    
                    {{-- Task Filter --}}
                    <div>
                        <h3 class="font-bold text-slate-900 mb-4 text-[10px] uppercase tracking-[0.2em] flex items-center gap-2">
                            <span class="w-1 h-4 bg-indigo-500"></span> تصنيف المهام
                        </h3>
                        <div class="space-y-1 max-h-[300px] overflow-y-auto custom-scrollbar pl-1">
                            @foreach($tasksList as $taskName => $icon)
                                <label class="flex items-center justify-between p-2 rounded cursor-pointer transition-all hover:bg-indigo-50 group border border-transparent hover:border-indigo-100">
                                    <div class="flex items-center gap-3">
                                        <i class="{{ $icon }} w-4 text-center text-slate-400 group-hover:text-indigo-600 transition-colors text-xs"></i>
                                        <span class="text-[11px] font-bold text-slate-600 group-hover:text-slate-900 uppercase tracking-wide">{{ $taskName }}</span>
                                    </div>
                                    <input type="checkbox" wire:model.live="task" value="{{ $taskName }}"
                                           class="appearance-none w-3 h-3 border border-slate-300 rounded-sm bg-slate-50 checked:bg-indigo-600 checked:border-indigo-600 focus:ring-0 transition-all cursor-pointer">
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <div class="h-px bg-gradient-to-r from-transparent via-slate-200 to-transparent"></div>

                    {{-- Framework Filter --}}
                    <div>
                        <h3 class="font-bold text-slate-900 mb-4 text-[10px] uppercase tracking-[0.2em] flex items-center gap-2">
                             <span class="w-1 h-4 bg-purple-500"></span> البنية البرمجية
                        </h3>
                        <div class="flex flex-wrap gap-1.5">
                            @foreach($frameworksList as $fw)
                                <label class="cursor-pointer group relative">
                                    <input type="checkbox" wire:model.live="framework" value="{{ $fw }}" class="peer hidden">
                                    <div class="px-3 py-1.5 rounded border border-slate-200 bg-slate-50 text-[10px] font-mono font-bold text-slate-500 
                                                peer-checked:bg-slate-800 peer-checked:text-white peer-checked:border-slate-800 peer-checked:shadow-md
                                                transition-all hover:border-slate-400">
                                        {{ $fw }}
                                    </div>
                                </label>
                            @endforeach
                        </div>
                    </div>
                </div>
            </aside>

            {{-- ========================================== --}}
            {{-- 3. Main Content: شبكة المعالجات --}}
            {{-- ========================================== --}}
            <div class="flex-1">

                {{-- الفرز العلوي --}}
                <div class="flex flex-wrap justify-between items-center mb-6 gap-4 border-b border-slate-200 pb-4 bg-white/50 backdrop-blur rounded-lg px-4 pt-4">
                    <div class="flex gap-1">
                        @foreach(['popular' => 'RISING', 'newest' => 'LATEST', 'downloads' => 'TOP_LOAD'] as $key => $label)
                            <button wire:click="setSort('{{ $key }}')"
                                    class="px-4 py-1.5 rounded text-[10px] font-mono font-bold uppercase tracking-wider transition-all border
                                    {{ $sort === $key ? 'bg-slate-800 text-white border-slate-800' : 'bg-white border-slate-200 text-slate-500 hover:bg-slate-100' }}">
                                {{ $label }}
                            </button>
                        @endforeach
                    </div>
                    <div wire:loading class="text-indigo-600 text-[10px] font-mono font-bold animate-pulse">
                         // UPDATING_DATA_STREAM...
                    </div>
                </div>

                {{-- مصفوفة البطاقات --}}
                @php
                    // ستايلات أكثر جدية وتقنية
                    $styles = [
                        ['border' => 'hover:border-indigo-500', 'bg' => 'bg-indigo-50', 'text' => 'text-indigo-600', 'accent' => 'bg-indigo-500'],
                        ['border' => 'hover:border-emerald-500', 'bg' => 'bg-emerald-50', 'text' => 'text-emerald-600', 'accent' => 'bg-emerald-500'],
                        ['border' => 'hover:border-cyan-500', 'bg' => 'bg-cyan-50', 'text' => 'text-cyan-600', 'accent' => 'bg-cyan-500'],
                        ['border' => 'hover:border-rose-500', 'bg' => 'bg-rose-50', 'text' => 'text-rose-600', 'accent' => 'bg-rose-500'],
                        ['border' => 'hover:border-amber-500', 'bg' => 'bg-amber-50', 'text' => 'text-amber-600', 'accent' => 'bg-amber-500'],
                        ['border' => 'hover:border-violet-500', 'bg' => 'bg-violet-50', 'text' => 'text-violet-600', 'accent' => 'bg-violet-500'],
                    ];
                @endphp

                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-5">
                    @forelse($models as $model)
                        @php
                            $style = $styles[$loop->index % count($styles)];
                        @endphp

                        {{-- الكارد التقني --}}
                        <div class="group bg-white rounded-lg p-0 transition-all duration-300 flex flex-col h-full relative overflow-hidden hover:-translate-y-1 hover:shadow-2xl hover:shadow-slate-200/50 border border-slate-200 {{ $style['border'] }}">
                            
                            {{-- شريط ملون علوي --}}
                            <div class="h-1 w-full {{ $style['accent'] }} opacity-0 group-hover:opacity-100 transition-opacity"></div>

                            {{-- زخرفة خلفية --}}
                            <div class="absolute top-0 left-0 p-4 opacity-[0.03] group-hover:opacity-10 transition-opacity pointer-events-none">
                                <i class="fa-solid fa-microchip text-8xl text-slate-900 transform -rotate-12"></i>
                            </div>

                            <div class="p-6 flex flex-col h-full relative z-10">
                                
                                {{-- Header --}}
                                <div class="flex justify-between items-start mb-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded flex items-center justify-center text-lg {{ $style['bg'] }} {{ $style['text'] }} border border-transparent group-hover:border-current transition-all">
                                            <i class="fa-solid {{ $style['icon'] ?? 'fa-cube' }}"></i>
                                        </div>
                                        <div>
                                             <span class="block text-[9px] font-mono text-slate-400 uppercase tracking-wider mb-0.5">Framework</span>
                                             <span class="px-1.5 py-0.5 rounded-sm bg-slate-100 text-slate-600 text-[10px] font-bold uppercase border border-slate-200">
                                                {{ $model->framework }}
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                {{-- Content --}}
                                <div class="flex-grow">
                                    <a href="{{ route('models.show', [$model->user->username, $model->slug]) }}"
                                       class="text-base font-bold text-slate-900 group-hover:text-indigo-600 transition-colors mb-2 block line-clamp-1 font-mono tracking-tight" dir="ltr">
                                        {{ $model->title }}
                                    </a>
                                    
                                    <div class="flex items-center gap-2 mb-3">
                                        <div class="w-4 h-4 rounded-full bg-slate-200 flex items-center justify-center">
                                            <i class="fa-solid fa-user text-[8px] text-slate-500"></i>
                                        </div>
                                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest" dir="ltr">{{ $model->user->username }}</span>
                                    </div>

                                    <p class="text-[11px] text-slate-500 leading-relaxed line-clamp-2 mb-5 font-medium h-8">
                                        {{ $model->description ?? 'No system description available.' }}
                                    </p>
                                </div>

                                {{-- Tech Footer --}}
                                <div class="pt-3 border-t border-slate-100 flex items-center justify-between mt-auto">
                                    <div class="flex items-center gap-3 text-[10px] font-mono text-slate-500 font-bold">
                                        <span class="flex items-center gap-1.5 group-hover:text-indigo-600 transition-colors">
                                            <i class="fa-solid fa-download"></i> {{ \Illuminate\Support\Number::abbreviate($model->downloads_count) }}
                                        </span>
                                        <span class="flex items-center gap-1.5 group-hover:text-rose-500 transition-colors">
                                            <i class="fa-solid fa-heart"></i> {{ \Illuminate\Support\Number::abbreviate($model->likes_count) }}
                                        </span>
                                    </div>

                                    <span class="text-[9px] font-black uppercase tracking-wider px-2 py-1 rounded-sm {{ $style['bg'] }} {{ $style['text'] }}">
                                        {{ $model->task }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full py-20 text-center border border-dashed border-slate-300 rounded-lg bg-slate-50">
                            <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center mx-auto mb-4 text-2xl shadow-sm text-slate-300">
                                <i class="fa-solid fa-laptop-code"></i>
                            </div>
                            <h3 class="text-lg font-bold text-slate-900 mb-1 font-mono">SYSTEM_EMPTY</h3>
                            <p class="text-slate-500 text-xs">No matching models found in the registry.</p>
                        </div>
                    @endforelse
                </div>

                <div class="mt-16 flex justify-center" dir="ltr">
                    {{ $models->links('vendor.livewire.oneurai-pagination') }}
                </div>

            </div>
        </div>
    </div>
    
    <style>
        .custom-scrollbar::-webkit-scrollbar { width: 3px; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #CBD5E1; border-radius: 0px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
    </style>
</div>