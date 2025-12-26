<div x-data="{
        otp: @entangle('otp'),
        isSuccess: false,
        isError: false,
        timer: @entangle('resendTimer')
    }"
    @otp-success.window="isSuccess = true; setTimeout(() => { window.location.href = '{{ route('home') }}' }, 2000)"
    @otp-error.window="isError = true; setTimeout(() => { isError = false; otp = '' }, 1000)"
    {{-- تم تغيير font-sans إلى font-arabic هنا --}}
    class="min-h-screen flex bg-white font-arabic overflow-hidden" dir="rtl">

    {{-- القسم الأيمن: واجهة الإدخال --}}
    <div class="w-full lg:w-1/2 flex flex-col justify-between p-8 lg:p-16 relative z-10 bg-white">

        {{-- الشعار --}}
        <div class="flex justify-start">
            <a href="/" class="group flex items-center gap-3">
                <div class="w-11 h-11 bg-gradient-to-br from-emerald-600 to-emerald-800 rounded-2xl flex items-center justify-center text-white shadow-xl shadow-emerald-500/20 group-hover:rotate-12 transition-all duration-500">
                    <i class="fa-solid fa-code-branch text-xl"></i>
                </div>
                <div class="flex flex-col">
                    <span class="font-black text-2xl tracking-tighter text-slate-900">Oneurai</span>
                    <span class="text-[10px] font-bold text-emerald-600 uppercase tracking-[0.2em] -mt-1">Intelligence Lab</span>
                </div>
            </a>
        </div>

        <div class="max-w-md w-full mx-auto relative min-h-[500px] flex flex-col justify-center">

            {{-- واجهة النجاح --}}
            <div x-show="isSuccess" x-cloak
                 x-transition:enter="transition ease-out duration-500"
                 x-transition:enter-start="opacity-0 translate-y-8"
                 x-transition:enter-end="opacity-100 translate-y-0"
                 class="absolute inset-0 flex flex-col items-center justify-center bg-white z-50 text-center">
                <div class="w-24 h-24 bg-emerald-50 rounded-full flex items-center justify-center mb-6 shadow-inner">
                    <i class="fa-solid fa-circle-check text-6xl text-emerald-500 animate-bounce"></i>
                </div>
                <h2 class="text-3xl font-extrabold text-slate-900 mb-2">مرحباً بك مجدداً</h2>
                <p class="text-slate-500 font-medium italic">جاري تحضير مساحة العمل...</p>
            </div>

            <div x-show="!isSuccess" class="form-fade-in">
                <div class="text-right mb-12">
                    <h1 class="text-4xl font-extrabold text-slate-900 mb-4 tracking-tight leading-tight">تأكيد الهوية 🛡️</h1>
                    <p class="text-slate-500 text-lg font-medium leading-relaxed">أدخل الرمز المكون من <span class="text-emerald-600 font-bold">6 أرقام</span> الذي وصلك الآن.</p>
                </div>

                <form wire:submit.prevent="verify" class="space-y-10">
                    <div class="relative flex justify-center gap-3" dir="ltr" :class="{ 'animate-shake': isError }">
                        <input type="text" x-model="otp" maxlength="6" autofocus
                               @input="if(otp.length === 6) $wire.verify()"
                               class="absolute inset-0 opacity-0 cursor-default z-20">

                        <template x-for="i in 6">
                            <div :class="otp.length >= i ? 'border-emerald-500 ring-4 ring-emerald-500/10 bg-white' : 'border-slate-100 bg-slate-50/50'"
                                 class="w-14 h-20 border-2 rounded-[22px] text-center text-3xl font-black flex items-center justify-center transition-all duration-500 shadow-sm">
                                <span x-text="otp[i-1] || ''" class="text-slate-900 font-sans"></span> {{-- الأرقام بخط Inter --}}
                                <div x-show="otp.length === i-1" class="w-1 h-8 bg-emerald-500 rounded-full animate-pulse"></div>
                            </div>
                        </template>
                    </div>

                    <div class="space-y-6">
                        <button type="submit"
                                class="w-full bg-slate-900 text-white font-bold py-5 rounded-[22px] hover:bg-emerald-600 shadow-2xl shadow-slate-900/20 hover:shadow-emerald-500/30 transition-all duration-300 transform active:scale-95 flex items-center justify-center gap-3">
                            <span class="text-lg">دخول للمنصة</span>
                            <i class="fa-solid fa-arrow-left-long text-sm"></i>
                        </button>

                        <div class="text-center">
                            <button type="button" wire:click="resendOtp" x-show="timer <= 0"
                                    class="text-sm font-bold text-slate-400 hover:text-emerald-600 transition-all border-b-2 border-transparent hover:border-emerald-200 pb-1">
                                لم يصلك شيء؟ <span class="text-emerald-600 underline">إعادة الإرسال</span>
                            </button>
                            <span x-show="timer > 0" class="text-xs font-bold text-slate-300 tracking-[0.2em]">
                                طلب جديد خلال <span x-text="timer" class="text-emerald-500"></span> ثانية
                            </span>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="flex justify-between items-center text-[10px] font-bold text-slate-400 uppercase tracking-[0.3em] border-t border-slate-50 pt-8">
            <span>{{ date('Y') }} &copy; ONEURAI CORP</span>
            <div class="flex gap-6">
                <a href="#" class="hover:text-emerald-600 transition">Security</a>
                <a href="#" class="hover:text-emerald-600 transition">Legal</a>
            </div>
        </div>
    </div>

    {{-- القسم الأيسر --}}
    <div class="hidden lg:flex w-1/2 bg-[#0f172a] relative overflow-hidden flex-col justify-center items-center p-12">
        <div class="absolute inset-0 bg-grid-pattern"></div>

        <div class="relative z-10 text-center space-y-8">
            <div class="glass-card w-24 h-24 rounded-[2.5rem] flex items-center justify-center mx-auto shadow-2xl rotate-3 border-emerald-500/20">
                <i class="fa-solid fa-fingerprint text-5xl text-emerald-400"></i>
            </div>
            <div class="space-y-4">
                <h2 class="text-4xl font-black text-white leading-tight">نظام التحقق <br><span class="text-emerald-500">الذكي</span></h2>
                <p class="text-slate-400 font-medium max-w-xs mx-auto leading-relaxed">أنت الآن على بعد ثوانٍ من الدخول لأقوى مختبر ذكاء اصطناعي سعودي.</p>
            </div>
        </div>
    </div>
</div>
