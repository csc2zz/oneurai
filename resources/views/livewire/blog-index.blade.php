<div class="font-arabic bg-[#F8FAFC] min-h-screen pb-32">
    {{-- 1. Hero & Featured Section --}}
    <div class="bg-[#0B1120] relative pt-32 pb-60 overflow-hidden">
        {{-- تأثيرات الخلفية التقنية --}}
        <div class="absolute inset-0 opacity-[0.05]" style="background-image: radial-gradient(#10b981 1px, transparent 1px); background-size: 40px 40px;"></div>
        <div class="absolute -top-24 -right-24 w-96 h-96 bg-emerald-500/10 rounded-full blur-[120px]"></div>

        <div class="max-w-7xl mx-auto px-6 relative z-10">
            <div class="text-center mb-16">
                <div class="inline-flex items-center gap-2 px-4 py-2 rounded-2xl bg-white/5 border border-white/10 text-emerald-400 text-[11px] font-black uppercase tracking-[0.3em] mb-6 backdrop-blur-xl">
                    <span class="relative flex h-2 w-2">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                    </span>
                    مختبر ونوراي المعرفي
                </div>
                <h1 class="text-5xl lg:text-7xl font-black text-white mb-8 tracking-tighter leading-tight">
                    استكشف <span class="text-transparent bg-clip-text bg-gradient-to-r from-emerald-400 to-teal-300">آفاق البرمجة</span>
                </h1>
                
                {{-- شريط التصنيفات --}}
                <div class="flex flex-wrap justify-center gap-4 mt-12">
                    @foreach($categories as $cat)
                        <button 
                            wire:click="setCategory('{{ $cat }}')"
                            class="px-8 py-3.5 rounded-2xl text-sm font-black transition-all duration-500 relative group overflow-hidden {{ $category === $cat ? 'bg-emerald-600 text-white shadow-[0_0_30px_rgba(16,185,129,0.3)]' : 'bg-white/5 text-slate-400 hover:bg-white/10 border border-white/5 hover:border-white/20' }}">
                            <span class="relative z-10">{{ $cat }}</span>
                        </button>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    {{-- 2. Posts Layout --}}
    <div class="max-w-7xl mx-auto px-6 -mt-32 relative z-20">
        
        @if($posts->count() > 0 && $category === 'الكل')
            @php $featured = $posts->first(); @endphp
            <div class="mb-16 group">
                <a href="{{ route('post.show', $featured->slug) }}" wire:navigate class="grid grid-cols-1 lg:grid-cols-12 bg-white rounded-[3.5rem] overflow-hidden shadow-2xl shadow-slate-200/50 border border-white group-hover:border-emerald-500/20 transition-all duration-700">
                    <div class="lg:col-span-7 h-80 lg:h-[500px] overflow-hidden">
                        <img src="{{ asset('storage/' . $featured->image) ?? 'https://via.placeholder.com/1200x800' }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-1000">
                    </div>
                    <div class="lg:col-span-5 p-10 lg:p-16 flex flex-col justify-center">
                        <div class="flex items-center gap-3 mb-6 text-emerald-600 font-black text-xs uppercase tracking-widest">
                            <span class="w-10 h-[2px] bg-emerald-600"></span>
                            مقال مختار
                        </div>
                        <h2 class="text-3xl lg:text-4xl font-black text-slate-900 mb-6 leading-tight group-hover:text-emerald-600 transition-colors">
                            {{ $featured->title }}
                        </h2>
                        
                        {{-- إحصائيات المقال المميز --}}
                        <div class="flex items-center gap-6 mb-8">
                            <div class="flex items-center gap-2 text-slate-400 text-xs font-bold">
                                <i class="fa-regular fa-eye text-emerald-500"></i>
                                {{ number_format($featured->views) }}
                            </div>
                            <div class="flex items-center gap-2 text-slate-400 text-xs font-bold">
                                <i class="fa-solid fa-heart text-rose-500"></i>
                                {{ $featured->likes->count() }}
                            </div>
                        </div>

                        <p class="text-slate-500 leading-relaxed mb-8 text-lg font-medium">
                            {{ Str::limit(strip_tags($featured->content), 180) }}
                        </p>
                        <div class="flex items-center justify-between mt-auto">
                            <span class="text-emerald-600 font-black text-sm">اقرأ المزيد ←</span>
                        </div>
                    </div>
                </a>
            </div>
        @endif

        {{-- باقي المقالات --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
            @forelse($posts->skip($category === 'الكل' ? 1 : 0) as $post)
                <article class="flex flex-col bg-white rounded-[3rem] p-4 shadow-sm border border-slate-100 hover:shadow-2xl hover:shadow-slate-200/60 hover:-translate-y-2 transition-all duration-500 group">
                    <div class="relative h-72 rounded-[2.5rem] overflow-hidden mb-8">
                        @if($post->image)
            {{-- 🔥 الحل هنا: إضافة asset('storage/' . $post->image) --}}
            <img src="{{ asset('storage/' . $post->image) ?? 'https://via.placeholder.com/1200x800' }}" 
                 alt="{{ $post->title }}"
                 class="w-full h-full object-cover transform scale-100 group-hover:scale-110 transition-transform duration-[1.5s] ease-out">
        @else
            {{-- صورة احتياطية في حال عدم وجود صورة للمقال --}}
            <img src="https://via.placeholder.com/1200x800?text=Oneurai+News" 
                 class="w-full h-full object-cover opacity-50">
        @endif
                        <div class="absolute bottom-6 right-6">
                            <span class="bg-white/20 backdrop-blur-md border border-white/30 px-5 py-2 rounded-2xl text-[10px] font-black text-white uppercase">
                                {{ $post->category }}
                            </span>
                        </div>
                    </div>

                    <div class="px-4 pb-6 flex flex-col flex-1">
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center gap-2 text-slate-400 text-[10px] font-bold uppercase">
                                <i class="fa-regular fa-calendar-check text-emerald-500"></i>
                                {{ $post->created_at->diffForHumans() }}
                            </div>
                            {{-- إحصائيات مصغرة في الكارد --}}
                            <div class="flex items-center gap-3">
                                <span class="text-[10px] font-bold text-slate-400 flex items-center gap-1">
                                    <i class="fa-regular fa-eye"></i> {{ $post->views }}
                                </span>
                                <span class="text-[10px] font-bold text-slate-400 flex items-center gap-1">
                                    <i class="fa-regular fa-heart"></i> {{ $post->likes->count() }}
                                </span>
                            </div>
                        </div>
                        
                        <h3 class="text-2xl font-black text-slate-900 mb-5 leading-[1.4] group-hover:text-emerald-600 transition-colors">
                            <a href="{{ route('post.show', $post->slug) }}" wire:navigate>{{ $post->title }}</a>
                        </h3>
                        
                        <div class="mt-auto pt-6 border-t border-slate-50 flex items-center justify-between">
                            <a href="{{ route('post.show', $post->slug) }}" wire:navigate class="flex items-center gap-2 text-slate-900 font-black text-[11px] group/link">
                                الدخول للمصفوفة
                                <span class="w-8 h-8 rounded-full bg-slate-900 text-white flex items-center justify-center group-hover/link:bg-emerald-600 transition-all">
                                    <i class="fa-solid fa-arrow-left text-[10px]"></i>
                                </span>
                            </a>
                        </div>
                    </div>
                </article>
            @empty
                @if(!($posts->count() > 0 && $category === 'الكل'))
                <div class="col-span-full py-32 text-center bg-white rounded-[4rem] border-2 border-dashed border-slate-100">
                    <div class="w-24 h-24 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-8 text-slate-200 text-4xl">
                        <i class="fa-solid fa-terminal"></i>
                    </div>
                    <h3 class="text-2xl font-black text-slate-900 mb-3">Null Results</h3>
                    <p class="text-slate-500 font-medium">لم نجد أي مصفوفات برمجية في هذا التصنيف حالياً.</p>
                </div>
                @endif
            @endforelse
        </div>
    </div>
</div>