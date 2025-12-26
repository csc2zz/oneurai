<x-layouts.model-layout :model="$model" :author="$author" active-tab="community">
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 animate-fade-in-up">

        {{-- 1. المنطقة الرئيسية: سجل المناقشات (9 أعمدة) --}}
        <div class="lg:col-span-8 space-y-8">

            {{-- شريط البحث والفلترة الاحترافي --}}
            <div class="flex flex-col sm:flex-row justify-between items-center gap-4 bg-white p-2 rounded-2xl border border-slate-100 shadow-sm">
                <div class="relative flex-1 w-full group">
                    <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none text-slate-400 group-focus-within:text-emerald-500 transition-colors">
                        <i class="fa-solid fa-magnifying-glass text-sm"></i>
                    </div>
                    <input
                        wire:model.live.debounce.300ms="search"
                        type="text"
                        placeholder="ابحث في أفكار المجتمع..."
                        class="w-full bg-transparent border-none text-sm font-bold text-slate-800 placeholder:text-slate-400 focus:ring-0 py-2.5 pr-11"
                    >
                </div>

                <div class="flex items-center gap-1 bg-slate-50 p-1 rounded-xl shrink-0">
                    <button wire:click="setSort('latest')"
                            class="px-4 py-2 text-[10px] font-black uppercase tracking-widest rounded-lg transition-all
                            {{ $sort === 'latest' ? 'bg-white text-slate-900 shadow-sm' : 'text-slate-400 hover:text-slate-600' }}">
                        الأحدث
                    </button>
                    <button wire:click="setSort('popular')"
                            class="px-4 py-2 text-[10px] font-black uppercase tracking-widest rounded-lg transition-all flex items-center gap-2
                            {{ $sort === 'popular' ? 'bg-amber-100 text-amber-700 shadow-sm' : 'text-slate-400 hover:text-slate-600' }}">
                        <i class="fa-solid fa-fire-flame-curved text-[9px]"></i> الأفضل
                    </button>
                </div>
            </div>

            {{-- صندوق إضافة تعليق جديد (Glass Effect) --}}
            <div class="bg-white rounded-[2rem] border border-slate-200/60 p-8 shadow-sm relative overflow-hidden group">
                <div class="absolute top-0 left-0 w-2 h-full bg-emerald-500 opacity-20 group-focus-within:opacity-100 transition-opacity"></div>
                <div class="flex gap-5">
                    <div class="shrink-0 hidden sm:block">
                        <img src="https://ui-avatars.com/api/?name={{ auth()->user()->name ?? 'Guest' }}&bg=0f172a&color=fff&bold=true"
                             class="w-12 h-12 rounded-2xl shadow-sm border-2 border-white object-cover">
                    </div>
                    <div class="flex-1 space-y-4">
                        <textarea wire:model="newComment"
                                  class="w-full bg-slate-50 border-slate-100 rounded-[1.5rem] p-5 text-sm font-medium text-slate-700 focus:ring-4 focus:ring-emerald-500/5 focus:bg-white focus:border-emerald-500 outline-none transition-all placeholder:text-slate-400 min-h-[120px] resize-none shadow-inner"
                                  placeholder="شارك المبدعين رأيك أو استفسارك..."></textarea>

                        <div class="flex justify-between items-center">
                            <div class="flex items-center gap-2 text-slate-400">
                                <i class="fa-brands fa-markdown text-lg"></i>
                                <span class="text-[10px] font-black uppercase tracking-tighter">Markdown Support</span>
                            </div>
                            <button wire:click="postComment"
                                    wire:loading.attr="disabled"
                                    class="bg-slate-900 hover:bg-emerald-600 text-white px-8 py-3 rounded-2xl text-xs font-black transition-all shadow-lg hover:shadow-emerald-500/30 flex items-center gap-2 transform active:scale-95">
                                <span wire:loading.remove wire:target="postComment">نشر الآن <i class="fa-solid fa-paper-plane-top ml-1"></i></span>
                                <span wire:loading wire:target="postComment"><i class="fa-solid fa-circle-notch fa-spin"></i></span>
                            </button>
                        </div>
                        @error('newComment') <span class="text-red-500 text-[10px] font-black uppercase tracking-tight block">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>

            {{-- قائمة التعليقات بنظام الخيوط (Threading) --}}
            <div class="space-y-10">
                @forelse($comments as $comment)
                    <div class="relative group/main">
                        {{-- التعليق الرئيسي --}}
                        <div class="flex gap-5">
                            <div class="shrink-0 relative">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($comment->user->name) }}&bg=10b981&color=fff&bold=true"
                                     class="w-12 h-12 rounded-2xl shadow-md border-2 border-white object-cover group-hover/main:rotate-3 transition-transform">
                                @if($comment->user_id === $model->user_id)
                                    <div class="absolute -bottom-1 -right-1 w-5 h-5 bg-emerald-600 text-white rounded-lg flex items-center justify-center text-[8px] border-2 border-white shadow-sm" title="Model Author">
                                        <i class="fa-solid fa-crown"></i>
                                    </div>
                                @endif
                            </div>

                            <div class="flex-1 min-w-0">
                                <div class="bg-white border border-slate-100 rounded-[2rem] rounded-tr-none p-6 shadow-sm group-hover/main:shadow-md transition-shadow relative">
                                    <div class="flex items-center justify-between mb-3">
                                        <div class="flex items-center gap-2">
                                            <span class="font-black text-slate-900 text-sm tracking-tight">{{ $comment->user->name }}</span>
                                            <span class="text-[10px] font-bold text-slate-300">{{ $comment->created_at->diffForHumans() }}</span>
                                        </div>
                                        @if(auth()->id() === $comment->user_id || auth()->id() === $model->user_id)
                                            <button wire:click="deleteComment({{ $comment->id }})" wire:confirm="حذف التعليق؟" class="text-slate-300 hover:text-red-500 transition-colors opacity-0 group-hover/main:opacity-100"><i class="fa-solid fa-trash-can text-xs"></i></button>
                                        @endif
                                    </div>
                                    <p class="text-sm text-slate-600 leading-relaxed font-medium whitespace-pre-line">{{ $comment->content }}</p>
                                </div>

                                {{-- الإجراءات --}}
                                <div class="flex items-center gap-6 mt-3 mr-4">
                                    <button wire:click="toggleLike({{ $comment->id }})"
                                            class="flex items-center gap-2 text-[10px] font-black uppercase tracking-widest transition-all {{ $comment->isLikedByAuthUser() ? 'text-rose-500' : 'text-slate-400 hover:text-rose-500' }}">
                                        <i class="{{ $comment->isLikedByAuthUser() ? 'fa-solid' : 'fa-regular' }} fa-heart text-sm"></i>
                                        <span>{{ $comment->likes_count }}</span>
                                    </button>
                                    <button wire:click="setReplyTo({{ $comment->id }})" class="flex items-center gap-2 text-[10px] font-black uppercase tracking-widest text-slate-400 hover:text-emerald-600 transition-all">
                                        <i class="fa-solid fa-reply-all text-sm"></i> رد
                                    </button>
                                </div>

                                {{-- ردود المجتمع (Nested) --}}
                                @if($comment->replies->count() > 0)
                                    <div class="mt-6 space-y-6 pr-8 border-r-2 border-slate-100 mr-4">
                                        @foreach($comment->replies as $reply)
                                            <div class="relative group/reply">
                                                <div class="flex gap-4">
                                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($reply->user->name) }}&bg=f1f5f9&color=64748b&bold=true"
                                                         class="w-9 h-9 rounded-xl border border-slate-100 object-cover shadow-sm">
                                                    <div class="flex-1 bg-slate-50/50 border border-slate-100 rounded-2xl p-4">
                                                        <div class="flex items-center justify-between mb-2">
                                                            <div class="flex items-center gap-2">
                                                                <span class="font-black text-slate-800 text-xs tracking-tight">{{ $reply->user->name }}</span>
                                                                @if($reply->user_id === $model->user_id)
                                                                    <span class="text-[8px] font-black bg-emerald-100 text-emerald-700 px-1.5 py-0.5 rounded uppercase">Author</span>
                                                                @endif
                                                            </div>
                                                            <span class="text-[9px] font-bold text-slate-300">{{ $reply->created_at->diffForHumans() }}</span>
                                                        </div>
                                                        <p class="text-xs text-slate-600 font-medium leading-relaxed">{{ $reply->content }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif

                                {{-- فورم الرد العائم --}}
                                @if($replyingToId === $comment->id)
                                    <div class="mt-6 mr-8 animate-fade-in-down">
                                        <div class="bg-emerald-50/50 border border-emerald-100 p-4 rounded-3xl">
                                            <textarea wire:model="replyContent" class="w-full bg-white border-slate-100 rounded-2xl p-4 text-xs font-bold text-slate-700 focus:ring-0 outline-none shadow-inner resize-none h-24" placeholder="اكتب ردك الذكي..."></textarea>
                                            <div class="flex justify-end gap-3 mt-3">
                                                <button wire:click="$set('replyingToId', null)" class="text-[10px] font-black uppercase text-slate-400 hover:text-slate-600">إلغاء</button>
                                                <button wire:click="postReply" class="bg-emerald-600 text-white px-5 py-2 rounded-xl text-[10px] font-black uppercase shadow-lg shadow-emerald-500/20 transform active:scale-95 transition-all">إرسال الرد</button>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="py-24 text-center animate-fade-in">
                        <div class="w-24 h-24 bg-white border border-dashed border-slate-200 rounded-[2.5rem] flex items-center justify-center mx-auto mb-6 text-3xl text-slate-200">
                            <i class="fa-solid fa-comments-bubble"></i>
                        </div>
                        <h4 class="text-xl font-black text-slate-900 tracking-tight">لا توجد همسات بعد!</h4>
                        <p class="text-slate-400 font-medium text-sm mt-2">ابدأ الحوار وكن أول من يضع بصمته في هذا النموذج.</p>
                    </div>
                @endforelse
            </div>
        </div>

        {{-- 2. القائمة الجانبية (3 أعمدة) --}}
        <div class="lg:col-span-4 space-y-8">

            {{-- بطاقة إحصائيات المجتمع --}}
            <div class="bg-gradient-to-br from-emerald-600 to-emerald-800 rounded-[2.5rem] p-8 text-white shadow-2xl relative overflow-hidden group">
                {{-- زخرفة خلفية --}}
                <div class="absolute -right-10 -bottom-10 w-40 h-40 bg-white/10 rounded-full blur-3xl group-hover:bg-white/20 transition duration-1000"></div>
                <div class="relative z-10">
                    <h3 class="text-lg font-black tracking-tight mb-4 flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-white/20 backdrop-blur-md flex items-center justify-center">
                            <i class="fa-solid fa-users-rays text-sm"></i>
                        </div>
                        مجتمع المبدعين
                    </h3>
                    <p class="text-emerald-50/80 text-sm leading-relaxed mb-8 font-medium">
                        هنا نتبادل الخبرات. اطرح أسئلتك التقنية حول مصفوفات الأوزان، بيانات التدريب، أو طرق التحسين.
                    </p>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="bg-black/20 p-4 rounded-2xl border border-white/10 text-center">
                            <span class="block text-xl font-black font-mono leading-none">{{ $model->comments()->count() }}</span>
                            <span class="text-[9px] font-black uppercase tracking-widest text-emerald-300">مناقشة</span>
                        </div>
                        <div class="bg-black/20 p-4 rounded-2xl border border-white/10 text-center">
                            <span class="block text-xl font-black font-mono leading-none">{{ number_format($model->likes_count) }}</span>
                            <span class="text-[9px] font-black uppercase tracking-widest text-emerald-300">إعجاب</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- شارة المطور (المصغر) --}}
            <div class="bg-white border border-slate-200 p-6 rounded-[2rem] shadow-sm group hover:border-emerald-500/30 transition-all duration-500">
                <h4 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-5">ناشر النموذج</h4>
                <div class="flex items-center gap-4">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($author->name) }}&bg=0f172a&color=fff&bold=true"
                         class="w-14 h-14 rounded-[1.2rem] shadow-md border-2 border-white group-hover:scale-105 transition-transform">
                    <div class="min-w-0">
                        <div class="font-black text-slate-900 text-base leading-none mb-1 flex items-center gap-1">
                            {{ $author->name }}
                            <i class="fa-solid fa-circle-check text-blue-500 text-[10px]"></i>
                        </div>
                        <p class="text-xs font-bold text-slate-400 font-mono tracking-tighter" dir="ltr">{{ '@' . $author->username }}</p>
                    </div>
                </div>
                <a href="{{ route('profile.show', $author->username) }}" class="mt-6 flex items-center justify-center gap-2 w-full py-3 bg-slate-50 text-slate-700 rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-slate-900 hover:text-white transition-all">
                    عرض البروفايل الكامل <i class="fa-solid fa-arrow-left text-[9px]"></i>
                </a>
            </div>

        </div>
    </div>
</x-layouts.model-layout>
