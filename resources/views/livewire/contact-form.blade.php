<div class="bg-white p-10 md:p-16 rounded-[3.5rem] shadow-2xl shadow-slate-200/60 border border-slate-100">
    <div class="text-center mb-12">
        <h2 class="text-4xl font-black text-slate-900 mb-3 tracking-tighter">أرسل رسالة مباشرة</h2>
        <p class="text-slate-400 text-sm font-medium">سيتم تحويل رسالتك إلى تذكرة دعم في نظام ونوراي.</p>
    </div>

    {{-- تنبيه تسجيل الدخول (كما في الصورة) --}}
    @guest
        <div class="bg-[#FFFBEB] border border-amber-100 rounded-[2.5rem] p-8 mb-12 flex items-center gap-6 text-right">
            <div class="w-14 h-14 bg-amber-500 text-white rounded-2xl flex items-center justify-center text-2xl shrink-0 shadow-lg shadow-amber-200">
                <i class="fa-solid fa-user-lock"></i>
            </div>
            <div class="flex-1">
                <h4 class="font-black text-amber-900 text-base mb-1">تسجيل الدخول مطلوب</h4>
                <p class="text-amber-700 text-sm leading-relaxed mb-3">عذراً يا مبدع، لفتح تذكرة دعم فني وتتبع حالتها، يجب أن تكون مسجلاً في منظومة ونوراي.</p>
                <div class="flex gap-6">
                    <a href="{{ route('login') }}" class="text-amber-900 font-black text-sm underline underline-offset-4">تسجيل الدخول</a>
                    <a href="{{ route('register') }}" class="text-amber-900 font-black text-sm underline underline-offset-4">إنشاء حساب جديد</a>
                </div>
            </div>
        </div>
    @endguest

    <form wire:submit.prevent="sendTicket" class="space-y-10 text-right @guest opacity-30 pointer-events-none @endguest">
        @if (session()->has('success'))
            <div class="bg-emerald-500 text-white p-5 rounded-2xl font-black text-center animate-bounce">
                {{ session('success') }}
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
            <div class="space-y-3">
                <label class="block text-xs font-black text-slate-500 uppercase tracking-widest mr-1 text-left md:text-right">الاسم الكامل</label>
                <input type="text" wire:model.blur="name" class="w-full bg-slate-50 border-2 border-transparent rounded-2xl py-5 px-8 text-sm font-bold focus:bg-white focus:border-emerald-500/20 outline-none transition-all">
                @error('name') <span class="text-red-500 text-[10px] font-bold">{{ $message }}</span> @enderror
            </div>
            <div class="space-y-3">
                <label class="block text-xs font-black text-slate-500 uppercase tracking-widest mr-1 text-left md:text-right">البريد الإلكتروني</label>
                <input type="email" wire:model.blur="email" class="w-full bg-slate-50 border-2 border-transparent rounded-2xl py-5 px-8 text-sm font-bold focus:bg-white focus:border-emerald-500/20 outline-none transition-all font-sans">
                @error('email') <span class="text-red-500 text-[10px] font-bold">{{ $message }}</span> @enderror
            </div>
        </div>

        <div class="space-y-3">
            <label class="block text-xs font-black text-slate-500 uppercase tracking-widest mr-1 text-left md:text-right">عنوان الموضوع</label>
            <input type="text" wire:model.blur="subject" placeholder="مثال: مشكلة في رفع النماذج البرمجية" class="w-full bg-slate-50 border-2 border-transparent rounded-2xl py-5 px-8 text-sm font-bold focus:bg-white focus:border-emerald-500/20 outline-none transition-all">
            @error('subject') <span class="text-red-500 text-[10px] font-bold">{{ $message }}</span> @enderror
        </div>

        <div class="space-y-3">
            <label class="block text-xs font-black text-slate-500 uppercase tracking-widest mr-1 text-left md:text-right">تفاصيل الرسالة</label>
            <textarea wire:model.blur="message" rows="5" placeholder="كيف يمكن لـ ونوراي خدمتك اليوم؟" class="w-full bg-slate-50 border-2 border-transparent rounded-2xl py-5 px-8 text-sm font-bold focus:bg-white focus:border-emerald-500/20 outline-none transition-all resize-none"></textarea>
            @error('message') <span class="text-red-500 text-[10px] font-bold">{{ $message }}</span> @enderror
        </div>

        <button type="submit" wire:loading.attr="disabled" class="w-full bg-slate-900 hover:bg-emerald-600 text-white font-black py-6 rounded-[2rem] shadow-xl transition-all flex items-center justify-center gap-4 active:scale-95 group">
            <span wire:loading.remove>إرسال المصفوفة البرمجية</span>
            <span wire:loading>جاري حقن البيانات...</span>
            <i wire:loading.remove class="fa-solid fa-paper-plane text-xl transition-transform group-hover:translate-x-2 group-hover:-translate-y-2"></i>
        </button>
    </form>
</div>