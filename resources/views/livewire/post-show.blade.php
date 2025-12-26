<div class="font-arabic bg-white min-h-screen">
    {{-- 1. Hero Section: عنوان المقال والمعلومات --}}
    <header class="bg-[#0B1120] pt-32 pb-20 relative overflow-hidden">
        <div class="absolute inset-0 opacity-[0.05]" style="background-image: radial-gradient(#fff 1px, transparent 1px); background-size: 40px 40px;"></div>
        
        <div class="max-w-4xl mx-auto px-6 relative z-10 text-center">
            <a href="/blog" class="inline-flex items-center gap-2 text-emerald-400 text-xs font-black mb-8 hover:gap-4 transition-all group">
                <i class="fa-solid fa-arrow-right"></i>
                العودة للمدونة
            </a>
            
            <div class="flex items-center justify-center gap-3 mb-6">
                <span class="px-4 py-1.5 rounded-full bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 text-[10px] font-black uppercase tracking-widest">
                    {{ $post->category }}
                </span>
                <span class="text-slate-500 text-[10px] font-bold">
                    <i class="fa-regular fa-clock ml-1"></i>
                    {{ $post->created_at->diffForHumans() }}
                </span>
            </div>

            <h1 class="text-3xl lg:text-5xl font-black text-white leading-tight tracking-tighter mb-8">
                {{ $post->title }}
            </h1>
        </div>
    </header>

    {{-- 2. Content Section: صورة المقال والمحتوى --}}
    <main class="max-w-4xl mx-auto px-6 -mt-10 relative z-20 pb-24">
        {{-- صورة المقال الرئيسية --}}
        <div class="rounded-[2.5rem] overflow-hidden shadow-2xl border-4 border-white mb-16">
            <img src="{{ asset('storage/' . $post->image) ?? 'https://via.placeholder.com/1200x800' }}" alt="{{ $post->title }}" class="w-full h-auto object-cover">
        </div>

        {{-- نص المقال --}}
{{-- ملف: post-detail.blade.php --}}
<article class="max-w-4xl mx-auto px-6 py-20 bg-white rounded-[4rem] shadow-2xl shadow-slate-200/50 border border-slate-100 relative overflow-hidden" dir="rtl">
    
    {{-- لمسة جمالية في الزاوية --}}
    <div class="absolute top-0 left-0 w-32 h-32 bg-emerald-500/5 rounded-br-[5rem] -z-0"></div>

    {{-- المحتوى البرمجي المعالج --}}
    <div class="prose prose-slate prose-lg max-w-none 
                prose-headings:font-black prose-headings:text-slate-900 prose-headings:tracking-tighter
                prose-p:text-slate-600 prose-p:leading-[1.8] prose-p:font-medium
                prose-strong:text-emerald-600 prose-strong:font-black
                prose-li:font-bold prose-li:text-slate-700">
        
        {!! $post->content !!} {{-- هنا يظهر المحتوى الذي أرفقته --}}
        
    </div>

    {{-- 2. التوقيع النهائي الفخم --}}
@if($post->show_signature)
    <div class="mt-20 pt-12 border-t border-slate-100 flex flex-col items-center animate-fade-in">
        <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.4em] mb-6">Digital Authentication</p>
        <div class="flex items-center gap-6">
            {{-- توقيع محمد (NOS) --}}
            <a href="https://oneurai.com/@ksa">
            <div class="flex flex-col items-center group">
                <span class="text-xl font-black text-slate-900 tracking-tighter group-hover:text-emerald-600 transition-colors">NOS</span>
                <span class="h-1 w-8 bg-emerald-500 rounded-full mt-1"></span>
            </div>
            </a>
            
            <span class="text-slate-300 font-light text-2xl">&</span>
            
            {{-- توقيع أبو متعب (MTMA) --}}.
            <a href="https://oneurai.com/@MTMA">
            <div class="flex flex-col items-center group">
                <span class="text-xl font-black text-slate-900 tracking-tighter group-hover:text-blue-600 transition-colors">MTMA</span>
                <span class="h-1 w-8 bg-blue-500 rounded-full mt-1"></span>
            </div>
            </a>
        </div>
    </div>
@endif
</article>

        <div class="flex items-center justify-center gap-6 py-10 border-y border-slate-100 my-16">
    {{-- زر الإعجاب التفاعلي --}}
    <button wire:click="toggleLike" class="flex items-center gap-3 px-8 py-4 rounded-2xl transition-all {{ $post->isLikedBy(auth()->user()) ? 'bg-rose-50 text-rose-600' : 'bg-slate-50 text-slate-400 hover:bg-rose-50 hover:text-rose-600' }}">
        <i class="fa-{{ $post->isLikedBy(auth()->user()) ? 'solid' : 'regular' }} fa-heart text-xl animate-bounce-short"></i>
        <span class="font-black">{{ $post->likes->count() }} إعجاب</span>
    </button>

    {{-- عداد القراءات --}}
<div class="flex items-center gap-2 px-6 py-3 rounded-2xl bg-slate-50 text-slate-400 font-black text-xs">
    <i class="fa-regular fa-eye text-lg text-emerald-500"></i>
    <span>{{ number_format($post->views) }} مشاهدة</span>
</div>
</div>

<section class="mt-20">
    <h3 class="text-2xl font-black text-slate-900 mb-10 flex items-center gap-3">
        <i class="fa-solid fa-comments text-emerald-500"></i>
        المناقشات البرمجية ({{ $post->comments->count() }})
    </h3>

    {{-- صندوق كتابة تعليق جديد --}}
    @auth
        <div class="bg-slate-50 rounded-[2rem] p-8 mb-12 border border-slate-100 focus-within:border-emerald-500/30 transition-all">
            <textarea wire:model="newComment" placeholder="أضف بصمتك البرمجية هنا..." class="w-full bg-transparent border-none outline-none resize-none font-medium text-slate-700 h-24"></textarea>
            <div class="flex justify-end mt-4">
                <button wire:click="addComment" class="bg-slate-900 text-white px-8 py-3 rounded-xl font-black text-sm hover:bg-emerald-600 transition-all">
                    نشر التعليق
                </button>
            </div>
        </div>
    @else
        <div class="bg-amber-50 rounded-[2rem] p-8 mb-12 text-center border border-amber-100">
            <p class="text-amber-800 font-bold text-sm">يجب عليك <a href="/login" class="underline">تسجيل الدخول</a> للمشاركة في النقاش.</p>
        </div>
    @endauth

    {{-- قائمة التعليقات --}}
    <div class="space-y-8">
        @foreach($post->comments as $comment)
            <div class="flex gap-6 p-6 rounded-[2rem] bg-white border border-slate-50 shadow-sm">
                <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-slate-100 to-slate-200 flex items-center justify-center text-slate-400 shrink-0">
                    <i class="fa-solid fa-user-gear"></i>
                </div>
                <div>
                    <div class="flex items-center gap-3 mb-2">
                        <h4 class="font-black text-slate-900 text-sm">{{ $comment->user->name }}</h4>
                        <span class="text-[10px] text-slate-400 font-bold">{{ $comment->created_at->diffForHumans() }}</span>
                    </div>
                    <p class="text-slate-600 text-sm leading-relaxed font-medium">
                        {{ $comment->body }}
                    </p>
                </div>
            </div>
        @endforeach
    </div>
</section>

        {{-- 3. Author / Footer: تذييل المقال --}}
        <footer class="mt-20 pt-10 border-t border-slate-100 flex flex-col md:flex-row items-center justify-between gap-6">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center font-black text-xl">
                    <i class="fa-solid fa-user-ninja"></i>
                </div>
                <div>
                    <h4 class="font-black text-slate-900">فريق ونوراي التقني</h4>
                    <p class="text-slate-500 text-xs">نكتب من أجل مجتمع تقني سعودي أفضل.</p>
                </div>
            </div>

            <div class="flex gap-3">
                <button class="w-10 h-10 rounded-xl bg-slate-50 text-slate-400 hover:bg-emerald-500 hover:text-white transition-all">
                    <i class="fa-brands fa-x-twitter"></i>
                </button>
                <button class="w-10 h-10 rounded-xl bg-slate-50 text-slate-400 hover:bg-emerald-500 hover:text-white transition-all">
                    <i class="fa-solid fa-link"></i>
                </button>
            </div>
        </footer>
    </main>
    <style>
        /* تنسيق خاص لمحتوى مصفوفة ونوراي المعرفية */
.oneurai-content {
    line-height: 2;
    text-align: justify;
}

/* 1. إظهار رمز البرمجة قبل كل نقطة في القائمة */
.oneurai-content ul {
    margin-right: 1.5rem;
    list-style: none !important;
}

.oneurai-content ul li {
    position: relative;
    padding-right: 1.8rem;
    margin-bottom: 1rem;
}

.oneurai-content ul li::before {
    content: "/>"; /* رمز المطورين */
    position: absolute;
    right: 0;
    top: 0;
    color: #10b981; /* أخضر إيميرالد */
    font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, monospace;
    font-weight: 900;
    font-size: 0.85rem;
    opacity: 0.8;
}

/* 2. إضافة رمز "الهاشتاق" أو "النقطتين" قبل العناوين الجانبية (Strong) */
.oneurai-content strong {
    color: #0f172a;
    position: relative;
    display: inline-block;
    margin-left: 4px;
}

.oneurai-content strong::before {
    content: "::"; /* رمز تقني فخم قبل العنوان */
    color: #10b981;
    margin-left: 6px;
    font-family: monospace;
    opacity: 0.6;
}
    </style>
</div>