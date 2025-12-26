<x-layouts.app>
    <x-slot:title>إرشادات المجتمع | Oneurai</x-slot:title>

    {{-- 1. Hero Section: ترويسة تعكس روح الجماعة --}}
    <div class="relative bg-[#0B1120] py-24 lg:py-32 overflow-hidden border-b border-white/5">
        <div class="absolute inset-0 bg-gradient-to-br from-emerald-600/10 via-transparent to-blue-600/10 opacity-50"></div>
        <div class="absolute inset-0 opacity-[0.03]" style="background-image: radial-gradient(#fff 1px, transparent 1px); background-size: 30px 30px;"></div>

        <div class="max-w-4xl mx-auto px-6 relative z-10 text-center">
            <div class="w-20 h-20 bg-emerald-500 rounded-[2.5rem] flex items-center justify-center text-white text-4xl mx-auto mb-8 shadow-[0_20px_50px_rgba(16,185,129,0.3)] animate-bounce-slow">
                <i class="fa-solid fa-users-rays"></i>
            </div>
            <h1 class="text-4xl lg:text-6xl font-black text-white mb-6 tracking-tighter leading-tight">
                ميثاق <span class="text-transparent bg-clip-text bg-gradient-to-r from-emerald-400 to-teal-300">مجتمعنا الرقمي</span>
            </h1>
            <p class="text-slate-400 text-lg md:text-xl font-medium leading-relaxed max-w-2xl mx-auto">
                في ونوراي، نبني أكثر من مجرد كود؛ نحن نبني ثقافة ابتكار تحترم الجميع وتدفع بحدود المستحيل.
            </p>
        </div>
    </div>

    {{-- 2. Guidelines Grid: توزيع بصري ذكي --}}
    <div class="bg-[#F8FAFC] py-20 px-6">
        <div class="max-w-4xl mx-auto">

            <div class="grid grid-cols-1 gap-12">

                {{-- قسم المسموحات (The Green Zone) --}}
                <div class="group relative bg-white border border-slate-200/60 rounded-[3rem] p-10 shadow-[0_20px_50px_rgba(0,0,0,0.02)] transition-all duration-500 hover:shadow-[0_20px_50px_rgba(16,185,129,0.05)] overflow-hidden">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-emerald-50 rounded-bl-[5rem] -mr-10 -mt-10 transition-colors group-hover:bg-emerald-100"></div>

                    <div class="relative z-10">
                        <div class="flex items-center gap-4 mb-10">
                            <div class="w-12 h-12 bg-emerald-500 text-white rounded-2xl flex items-center justify-center text-xl shadow-lg shadow-emerald-200">
                                <i class="fa-solid fa-heart-circle-check"></i>
                            </div>
                            <div>
                                <h3 class="text-2xl font-black text-slate-900 tracking-tight">قيمنا الأساسية</h3>
                                <p class="text-[10px] font-black text-emerald-600 uppercase tracking-[0.2em] mt-0.5">What we encourage</p>
                            </div>
                        </div>

                        <div class="grid gap-8">
                            <div class="flex gap-5 group/item">
                                <div class="w-8 h-8 rounded-full bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0 font-black text-xs transition-transform group-hover/item:scale-110">01</div>
                                <div class="space-y-1">
                                    <h4 class="font-black text-slate-800 text-base">سخاء المعرفة</h4>
                                    <p class="text-slate-500 text-sm leading-relaxed font-medium">شارك خبراتك البرمجية؛ فالرد البسيط على مبتدئ قد يكون شرارة لمشروع سعودي عظيم.</p>
                                </div>
                            </div>
                            <div class="flex gap-5 group/item">
                                <div class="w-8 h-8 rounded-full bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0 font-black text-xs transition-transform group-hover/item:scale-110">02</div>
                                <div class="space-y-1">
                                    <h4 class="font-black text-slate-800 text-base">النقد الذي يبني</h4>
                                    <p class="text-slate-500 text-sm leading-relaxed font-medium">انقد الخوارزمية لا الشخص. اجعل هدفك دائماً رفع جودة الكود العربي.</p>
                                </div>
                            </div>
                            <div class="flex gap-5 group/item">
                                <div class="w-8 h-8 rounded-full bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0 font-black text-xs transition-transform group-hover/item:scale-110">03</div>
                                <div class="space-y-1">
                                    <h4 class="font-black text-slate-800 text-base">الأمانة الرقمية</h4>
                                    <p class="text-slate-500 text-sm leading-relaxed font-medium">احترم تراخيص المصادر المفتوحة. انسب الفضل لأصحابه لتبقى عجلة الابتكار مستمرة.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- قسم الممنوعات (The Danger Zone) --}}
                <div class="group relative bg-white border border-slate-200/60 rounded-[3rem] p-10 shadow-[0_20px_50px_rgba(0,0,0,0.02)] transition-all duration-500 hover:shadow-[0_20px_50px_rgba(239,68,68,0.05)] overflow-hidden">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-red-50 rounded-bl-[5rem] -mr-10 -mt-10 transition-colors group-hover:bg-red-100/50"></div>

                    <div class="relative z-10">
                        <div class="flex items-center gap-4 mb-10">
                            <div class="w-12 h-12 bg-red-500 text-white rounded-2xl flex items-center justify-center text-xl shadow-lg shadow-red-200">
                                <i class="fa-solid fa-circle-xmark"></i>
                            </div>
                            <div>
                                <h3 class="text-2xl font-black text-slate-900 tracking-tight">الخطوط الحمراء</h3>
                                <p class="text-[10px] font-black text-red-600 uppercase tracking-[0.2em] mt-0.5">What we reject</p>
                            </div>
                        </div>

                        <div class="grid gap-8">
                            <div class="flex gap-5 group/item">
                                <div class="w-2 h-2 rounded-full bg-red-500 mt-2.5 group-hover/item:scale-150 transition-transform"></div>
                                <div class="space-y-1">
                                    <h4 class="font-black text-slate-800 text-base">السلوك العدائي</h4>
                                    <p class="text-slate-500 text-sm leading-relaxed font-medium">لا تسامح مطلقاً مع العنصرية، التنمر، أو خطاب الكراهية بأي شكل من الأشكال.</p>
                                </div>
                            </div>
                            <div class="flex gap-5 group/item">
                                <div class="w-2 h-2 rounded-full bg-red-500 mt-2.5 group-hover/item:scale-150 transition-transform"></div>
                                <div class="space-y-1">
                                    <h4 class="font-black text-slate-800 text-base">التلويث البرمجي</h4>
                                    <p class="text-slate-500 text-sm leading-relaxed font-medium">يمنع منعاً باتاً استغلال المنصة لنشر فيروسات أو أكواد خبيثة تهدف للضرر.</p>
                                </div>
                            </div>
                            <div class="flex gap-5 group/item">
                                <div class="w-2 h-2 rounded-full bg-red-500 mt-2.5 group-hover/item:scale-150 transition-transform"></div>
                                <div class="space-y-1">
                                    <h4 class="font-black text-slate-800 text-base">الإغراق والترويج</h4>
                                    <p class="text-slate-500 text-sm leading-relaxed font-medium">الـ Spam والإعلانات غير المرغوب فيها تفسد بيئة المطورين، لنكن مهنيين.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- الفوتر التحذيري --}}
                <div class="bg-slate-900 rounded-[2.5rem] p-10 text-center relative overflow-hidden group">
                    <div class="absolute inset-0 bg-gradient-to-r from-emerald-500/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-700"></div>
                    <div class="relative z-10">
                        <i class="fa-solid fa-gavel text-emerald-500 text-3xl mb-6"></i>
                        <h4 class="text-white font-black text-xl mb-4 tracking-tight">نحن هنا لحمايتك</h4>
                        <p class="text-slate-400 text-sm leading-relaxed max-w-xl mx-auto font-medium">
                            مخالفة هذه القواعد قد تؤدي لتعليق الحساب. هدفنا ليس العقاب، بل الحفاظ على جودة المجتمع. للإبلاغ عن أي سلوك، راسلنا فوراً:
                        </p>
                        <a href="mailto:safety@oneurai.sa" class="inline-block mt-8 text-emerald-400 font-black text-lg hover:text-emerald-300 transition-all underline decoration-slate-700 underline-offset-8">safety@oneurai.sa</a>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <style>
        @keyframes bounce-slow {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }
        .animate-bounce-slow { animation: bounce-slow 4s ease-in-out infinite; }
    </style>
</x-layouts.app>
