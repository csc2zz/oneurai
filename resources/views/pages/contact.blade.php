<x-layouts.app>
    <x-slot:title>تواصل معنا | Oneurai</x-slot:title>

    {{-- 1. Hero Section --}}
<div class="relative bg-[#0B1120] py-24 lg:py-32 overflow-hidden border-b border-white/5">
        
        <div class="absolute inset-0 opacity-[0.03]" style="background-image: radial-gradient(#fff 1px, transparent 1px); background-size: 30px 30px;"></div>
        <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-emerald-600/10 rounded-full blur-[120px] -mr-40 -mt-40 animate-pulse"></div>

        <div class="max-w-4xl mx-auto px-6 relative z-10 text-center animate-fade-in-up">
            
            <div class="inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-2xl bg-white/5 border border-white/10 text-emerald-400 text-[11px] font-black uppercase tracking-[0.2em] mb-8 backdrop-blur-xl">
                <i class="fa-solid fa-headset text-sm relative -top-[1px]"></i> 
                <span class="leading-none">نحن هنا للاستماع</span>
            </div>
            
            <h1 class="text-4xl lg:text-6xl font-black text-white mb-6 tracking-tighter leading-tight">
                لنبني <span class="text-transparent bg-clip-text bg-gradient-to-r from-emerald-400 to-teal-300">جسور التواصل</span>
            </h1>
            <p class="text-slate-400 text-lg md:text-xl font-medium leading-relaxed max-w-2xl mx-auto">
                سواء كنت مطوراً يواجه تحدياً، أو شريكاً يطمح للتعاون، فريقنا التقني في انتظار رسالتك.
            </p>
        </div>
    </div>

    {{-- 2. Main Layout --}}
    <div class="bg-[#F8FAFC] relative pb-24">
        <div class="max-w-7xl mt-8 mx-auto px-6 relative -mt-24 z-20">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
                
                {{-- نموذج المراسلة (العرض الأكبر - 8 أعمدة) --}}
                <div class="lg:col-span-8 order-2 lg:order-1">
                    @livewire('contact-form')
                </div>

                {{-- البطاقات الجانبية (4 أعمدة) --}}
                <div class="lg:col-span-4 space-y-6 order-1 lg:order-2">
                    {{-- بطاقة الدعم الفني --}}
                    <div class="bg-white p-10 rounded-[2.5rem] shadow-sm border border-slate-100 flex flex-col items-center text-center group hover:border-emerald-500/20 transition-all">
                        <div class="w-16 h-16 bg-emerald-50 text-emerald-600 rounded-2xl flex items-center justify-center text-2xl mb-6 shadow-inner group-hover:bg-emerald-600 group-hover:text-white transition-all">
                            <i class="fa-solid fa-microchip"></i>
                        </div>
                        <h3 class="text-2xl font-black text-slate-900 mb-3">الدعم الفني</h3>
                        <p class="text-slate-500 text-sm font-medium mb-8 leading-relaxed">للمشاكل المتعلقة بالحساب، رفع النماذج، أو الأخطاء البرمجية.</p>
                        <a href="mailto:support@oneurai.sa" class="text-emerald-600 font-black text-sm underline underline-offset-8">support@oneurai.sa</a>
                    </div>

                    {{-- بطاقة الشراكات --}}
                    <div class="bg-white p-10 rounded-[2.5rem] shadow-sm border border-slate-100 flex flex-col items-center text-center group hover:border-blue-500/20 transition-all">
                        <div class="w-16 h-16 bg-blue-50 text-blue-600 rounded-2xl flex items-center justify-center text-2xl mb-6 shadow-inner group-hover:bg-blue-600 group-hover:text-white transition-all">
                            <i class="fa-solid fa-handshake-angle"></i>
                        </div>
                        <h3 class="text-2xl font-black text-slate-900 mb-3">الشراكات</h3>
                        <p class="text-slate-500 text-sm font-medium mb-8 leading-relaxed">للجهات الحكومية والشركات الراغبة في التكامل مع منظومة ونوراي.</p>
                        <a href="mailto:business@oneurai.sa" class="text-blue-600 font-black text-sm underline underline-offset-8">business@oneurai.sa</a>
                    </div>

                    {{-- بطاقة المقر --}}
                    <div class="bg-[#0B1120] rounded-[2.5rem] p-10 text-white relative overflow-hidden group">
                        <div class="relative z-10 flex flex-col items-center text-center">
                            <div class="flex items-center gap-2 mb-6 text-emerald-400">
                                <i class="fa-solid fa-location-dot"></i>
                                <span class="text-[10px] font-black uppercase tracking-widest leading-none">Riyadh HQ</span>
                            </div>
                            <h4 class="font-black text-2xl mb-4">مقرنا الرئيسي</h4>
                            <p class="text-slate-400 text-sm leading-relaxed font-medium">
                                واجهة الرياض، طريق المطار<br>
                                الرياض 13412، المملكة العربية السعودية 🇸🇦
                            </p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-layouts.app>