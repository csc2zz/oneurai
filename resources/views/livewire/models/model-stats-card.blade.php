<div wire:poll.5s class="font-arabic">
    <div class="relative group">
        {{-- تأثير التوهج الخلفي (Neon Glow) --}}
        <div class="absolute -inset-1 bg-gradient-to-r from-emerald-600 to-teal-900 rounded-[35px] blur opacity-20 group-hover:opacity-40 transition duration-1000"></div>
        
        <div class="relative bg-slate-950 rounded-[32px] p-8 border border-white/5 overflow-hidden shadow-2xl">
            
            {{-- خلفية النقاط العصبية --}}
            <div class="absolute inset-0 opacity-[0.03]" style="background-image: m-radial-gradient(#2dd4bf 0.5px, transparent 0.5px); background-size: 30px 30px;"></div>

            {{-- الهيدر: مؤشر الحالة الحية --}}
            <div class="relative flex flex-row-reverse items-center justify-between mb-12">
                <div class="text-right">
                    <div class="flex flex-row-reverse items-center gap-2 mb-1">
                        <span class="relative flex h-2 w-2">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                        </span>
                        <h3 class="text-emerald-500 text-[10px] font-black uppercase tracking-widest italic">معالجة عصبية حية</h3>
                    </div>
                    <h2 class="text-3xl font-[900] text-white italic tracking-tighter">إحصائيات ونوراي</h2>
                </div>
                <div class="p-4 bg-emerald-500/5 rounded-2xl border border-emerald-500/10 text-emerald-500 shadow-[0_0_30px_rgba(16,185,129,0.05)]">
                    <i class="fa-solid fa-brain text-2xl animate-pulse"></i>
                </div>
            </div>

            {{-- الرقم الرئيسي: إجمالي التشغيل --}}
            <div class="relative mb-12 text-center">
                <div class="inline-block relative">
                    <div class="absolute -inset-4 bg-emerald-500/5 blur-2xl rounded-full"></div>
                    <span class="relative text-8xl font-black font-sans tracking-tighter text-white">
                        {{ number_format($total) }}
                    </span>
                    <div class="mt-2 text-[10px] font-black uppercase tracking-[0.4em] text-slate-500">إجمالي عمليات التنفيذ</div>
                </div>
            </div>

            {{-- شبكة البيانات الصغرى --}}
            <div class="relative grid grid-cols-2 gap-4">
                {{-- نبض اليوم --}}
                <div class="bg-white/[0.02] backdrop-blur-xl rounded-2xl p-5 border border-white/5 hover:bg-white/[0.05] transition-colors group/item">
                    <div class="text-slate-500 text-[9px] font-black uppercase tracking-widest mb-2 text-right">نبض اليوم</div>
                    <div class="flex flex-row-reverse items-end justify-between">
                        <span class="text-3xl font-black font-sans text-white">{{ $today }}</span>
                        <div class="flex items-center gap-1 text-emerald-400 text-[10px] font-black bg-emerald-500/10 px-2 py-1 rounded-lg">
                            <span>%{{ $growth }}</span>
                            <i class="fa-solid fa-arrow-trend-up"></i>
                        </div>
                    </div>
                </div>

                {{-- تحليل المنصات --}}
                <div class="bg-white/[0.02] backdrop-blur-xl rounded-2xl p-5 border border-white/5">
                    <div class="text-slate-500 text-[9px] font-black uppercase tracking-widest mb-3 text-right">تزامن المنصات</div>
                    <div class="flex flex-col gap-2">
                        <div class="h-1.5 w-full bg-slate-900 rounded-full overflow-hidden flex flex-row-reverse">
                            <div class="h-full bg-emerald-500 shadow-[0_0_10px_rgba(16,185,129,0.4)]" style="width: 75%"></div>
                            <div class="h-full bg-blue-600 opacity-50" style="width: 25%"></div>
                        </div>
                        <div class="flex flex-row-reverse justify-between text-[8px] font-black uppercase text-slate-600 tracking-tighter">
                            <span>كولاب (75%)</span>
                            <span>أخرى (25%)</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- تذييل البطاقة --}}
            <div class="relative mt-8 pt-6 border-t border-white/5">
                <button class="w-full py-4 bg-emerald-500/5 hover:bg-emerald-500 hover:text-slate-950 text-emerald-500 rounded-xl text-[11px] font-[900] uppercase tracking-[0.2em] transition-all duration-500 flex flex-row-reverse items-center justify-center gap-3 group/btn border border-emerald-500/10">
                    <span>الدخول إلى سجلات الذكاء</span>
                    <i class="fa-solid fa-angle-left transition-transform group-hover/btn:-translate-x-1"></i>
                </button>
            </div>
        </div>
    </div>
</div>