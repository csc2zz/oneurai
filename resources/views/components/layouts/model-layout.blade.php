@props(['model', 'author', 'activeTab'])

<div class="bg-[#F8FAFC] min-h-screen pb-20 font-sans selection:bg-emerald-500 selection:text-white" dir="rtl">

    {{-- 1. Hero Header Section --}}
    <div class="bg-white border-b border-slate-200 pt-36 pb-0 relative overflow-hidden">
        {{-- تأثير خلفية ناعم (Glow) --}}
        <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-emerald-50/50 rounded-full blur-[120px] -z-0 pointer-events-none"></div>

        <div class="max-w-7xl mx-auto px-6 relative z-10">

            {{-- المسار والمعلومات العلوية --}}
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6 mb-8">
                <div>
                    {{-- Breadcrumbs: User / Model --}}
                    <div class="flex items-center gap-2 text-xs font-black text-slate-400 mb-4 bg-slate-50 w-fit px-3 py-1.5 rounded-lg border border-slate-100" dir="ltr">
                        <a href="{{ route('profile.show', $author->username) }}" class="hover:text-emerald-600 transition tracking-tighter">{{ $author->username }}</a>
                        <span class="text-slate-300 font-light">/</span>
                        <span class="text-slate-900 tracking-tight">{{ $model->title }}</span>
                    </div>

                    {{-- العنوان مع أيقونة التوثيق --}}
                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 bg-white rounded-2xl shadow-sm border border-slate-100 flex items-center justify-center text-3xl text-emerald-600 transition-transform hover:scale-105 group">
                            <i class="fa-solid fa-brain group-hover:animate-pulse"></i>
                        </div>
                        <div>
                            <h1 class="text-3xl font-black text-slate-900 tracking-tighter flex items-center gap-3">
                                {{ $model->title }}
                                @if($model->is_public)
                                    <div class="group relative flex items-center">
                                        <i class="fa-solid fa-circle-check text-blue-500 text-lg cursor-help"></i>
                                        <span class="absolute bottom-full mb-2 right-0 hidden group-hover:block w-max bg-slate-900 text-white text-[10px] px-2 py-1 rounded shadow-xl font-bold">Verified Model</span>
                                    </div>
                                @else
                                    <i class="fa-solid fa-lock text-amber-500 text-lg shadow-sm" title="خاص"></i>
                                @endif
                            </h1>
                        </div>
                    </div>
                </div>

                {{-- أزرار التفاعل --}}
                <div class="flex items-center gap-3">
                    <button class="flex items-center gap-2 px-6 py-2.5 bg-slate-900 text-white rounded-xl font-black text-xs hover:bg-emerald-600 transition shadow-lg shadow-slate-200 active:scale-95 group">
                        <i class="fa-solid fa-terminal text-[10px] opacity-50 group-hover:rotate-12 transition-transform"></i>
                        <span dir="ltr">Use in API</span>
                    </button>

                    <button wire:click="$parent.toggleLike"
                            class="flex items-center gap-2 px-6 py-2.5 bg-white border border-slate-200 rounded-xl font-black text-xs transition shadow-sm active:scale-90 group
                            {{ $model->isLikedBy(auth()->user()) ? 'text-rose-600 border-rose-100 bg-rose-50' : 'text-slate-600 hover:bg-slate-50' }}">
                        <i class="{{ $model->isLikedBy(auth()->user()) ? 'fa-solid' : 'fa-regular' }} fa-heart {{ $model->isLikedBy(auth()->user()) ? 'animate-bounce' : 'group-hover:text-rose-500' }}"></i>
                        {{ number_format($model->likes_count) }}
                    </button>
                </div>
            </div>

            {{-- شريط الكبسولات التقنية (Meta Tags) --}}
            <div class="flex flex-wrap items-center gap-3 mb-10">
                <div class="flex items-center gap-1.5 bg-emerald-50 text-emerald-700 px-3 py-1.5 rounded-xl text-[10px] font-black uppercase tracking-widest border border-emerald-100 shadow-sm">
                    <i class="fa-solid fa-tag"></i> {{ $model->task ?? 'Text Generation' }}
                </div>
                <div class="flex items-center gap-1.5 bg-slate-100 text-slate-600 px-3 py-1.5 rounded-xl text-[10px] font-black uppercase tracking-widest border border-slate-200 font-sans" dir="ltr">
                    <i class="fa-solid fa-layer-group opacity-50"></i> {{ $model->framework ?? 'PyTorch' }}
                </div>
                <div class="flex items-center gap-1.5 bg-slate-100 text-slate-600 px-3 py-1.5 rounded-xl text-[10px] font-black uppercase tracking-widest border border-slate-200">
                    <i class="fa-solid fa-globe opacity-50"></i> {{ $model->language ?? 'Arabic' }}
                </div>
                <div class="flex items-center gap-1.5 bg-slate-100 text-slate-600 px-3 py-1.5 rounded-xl text-[10px] font-black uppercase tracking-widest border border-slate-200 font-sans" dir="ltr">
                    <i class="fa-solid fa-scale-balanced opacity-50"></i> {{ $model->license ?? 'Apache 2.0' }}
                </div>
            </div>

            {{-- نظام التبويبات (Modern Sliding Tabs) --}}
            <div class="flex items-center gap-2 overflow-x-auto no-scrollbar">
                @php
                    $tabs = [
                        ['id' => 'card', 'label' => 'بطاقة النموذج', 'icon' => 'fa-file-lines', 'route' => route('models.show', [$author->username, $model->slug])],
                        ['id' => 'files', 'label' => 'الملفات والنسخ', 'icon' => 'fa-box-archive', 'route' => route('models.files', [$author->username, $model->slug])],
                        ['id' => 'community', 'label' => 'المجتمع', 'icon' => 'fa-comments', 'route' => route('models.community', [$author->username, $model->slug]), 'count' => $model->comments()->count()],
                        ['id' => 'settings', 'label' => 'الإعدادات', 'icon' => 'fa-sliders', 'route' => route('models.settings', [$author->username, $model->slug]), 'admin' => true],
                    ];
                @endphp

                @foreach($tabs as $tab)
                    @if(!isset($tab['admin']) || (isset($tab['admin']) && auth()->id() === $author->id))
                        <a href="{{ $tab['route'] }}" wire:navigate
                           class="px-6 py-3.5 text-xs font-black flex items-center gap-2 transition-all duration-300 relative group whitespace-nowrap
                           {{ $activeTab === $tab['id'] ? 'text-emerald-700 border-b-4 border-emerald-500 bg-emerald-50/50 rounded-t-2xl shadow-inner' : 'text-slate-500 hover:text-slate-900 hover:bg-slate-50' }}">
                            <i class="fa-solid {{ $tab['icon'] }} opacity-70 group-hover:text-emerald-500"></i>
                            {{ $tab['label'] }}
                            @isset($tab['count'])
                                <span class="inline-flex items-center justify-center min-w-5 h-5 px-1.5 rounded-lg text-[9px] font-black {{ $activeTab === 'community' ? 'bg-emerald-500 text-white' : 'bg-slate-100 text-slate-500' }}">
                                    {{ $tab['count'] }}
                                </span>
                            @endisset
                        </a>
                    @endif
                @endforeach
            </div>
        </div>
    </div>

    {{-- المحتوى الديناميكي (Dynamic Content Area) --}}
    <div class="max-w-7xl mx-auto px-6 py-10 relative">
        {{-- مؤشر تحميل زجاجي --}}
        <div wire:loading.flex class="absolute inset-0 bg-white/40 backdrop-blur-[2px] z-50 flex items-start justify-center pt-20">
            <div class="bg-white px-6 py-4 rounded-3xl shadow-[0_20px_50px_rgba(0,0,0,0.1)] border border-slate-100 flex items-center gap-4 animate-fade-in-up">
                <i class="fa-solid fa-circle-notch fa-spin text-emerald-500 text-xl"></i>
                <span class="font-black text-slate-800 text-sm tracking-tight">جاري استدعاء المصفوفة...</span>
            </div>
        </div>

        {{-- Slot للبيانات --}}
        <div class="animate-fade-in-up">
            {{ $slot }}
        </div>
    </div>
<style>
    .no-scrollbar::-webkit-scrollbar { display: none; }
    .animate-fade-in-up {
        animation: fadeInUp 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards;
    }
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>
</div>

