@push('styles')
<style>
    @import url('https://fonts.googleapis.com/css2?family=IBM+Plex+Sans+Arabic:wght@300;400;500;600;700&display=swap');

    body { font-family: 'IBM Plex Sans Arabic', sans-serif; }

    /* Custom Scrollbar */
    .custom-scrollbar::-webkit-scrollbar { width: 5px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background-color: #e2e8f0; border-radius: 20px; }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover { background-color: #cbd5e1; }

    /* Animations */
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(10px); }
        to   { opacity: 1; transform: translateY(0); }
    }
    .animate-fade-in-up { animation: fadeInUp .4s cubic-bezier(0.4, 0, 0.2, 1) both; }

    @keyframes shimmer {
        0%   { transform: translateX(-150%); }
        100% { transform: translateX(150%); }
    }
    .group:hover .group-hover\:animate-shimmer { animation: shimmer 1.5s infinite; }

    @keyframes float {
        0%, 100% { transform: translateY(0); }
        50%      { transform: translateY(-5px); }
    }
    .animate-float { animation: float 3s ease-in-out infinite; }
</style>
@endpush

<div class="bg-white h-screen flex overflow-hidden selection:bg-emerald-500 selection:text-white" dir="rtl">

    {{-- LEFT SECTION (Form) --}}
    <div class="w-full lg:w-1/2 h-full flex flex-col relative overflow-y-auto custom-scrollbar bg-white z-10">
        
        <div class="absolute inset-0 bg-[url('https://grainy-gradients.vercel.app/noise.svg')] opacity-[0.03] pointer-events-none"></div>

        <div class="w-full px-8 py-8 flex justify-between items-center relative z-20">
            <a href="{{ route('home') }}" class="flex items-center gap-3 group">
                <div class="relative w-11 h-11 flex items-center justify-center">
                    <div class="absolute inset-0 bg-emerald-100/50 rounded-2xl transform rotate-6 group-hover:rotate-12 transition-transform duration-300"></div>
                    <div class="relative w-full h-full bg-gradient-to-br from-emerald-500 to-emerald-700 rounded-2xl flex items-center justify-center text-white shadow-lg shadow-emerald-500/20">
                        <i class="fa-solid fa-code-branch text-lg"></i>
                    </div>
                </div>
                <span class="font-bold text-2xl tracking-tighter text-slate-900 font-sans group-hover:text-emerald-700 transition duration-300">Oneurai</span>
            </a>

            <a href="{{ route('login') }}" class="group flex items-center gap-2 text-sm font-bold text-slate-500 hover:text-emerald-600 transition-all duration-300 py-2.5 px-5 rounded-full hover:bg-emerald-50/80">
                تسجيل الدخول
                <i class="fa-solid fa-arrow-left group-hover:-translate-x-1 transition-transform duration-300 text-xs"></i>
            </a>
        </div>

        <div class="flex-grow flex items-center justify-center px-6 sm:px-12 lg:px-20 pb-10 relative z-20">
            <div class="max-w-[460px] w-full animate-fade-in-up">

                <div class="mb-10 text-center sm:text-right">
                    <h1 class="text-3xl sm:text-4xl font-bold text-slate-900 mb-4 leading-tight">
                        ابدأ رحلتك في <br>
                        <span class="text-transparent bg-clip-text bg-gradient-to-r from-emerald-600 to-teal-500 relative inline-block pb-1">
                            عالم الذكاء الاصطناعي
                            <svg class="absolute w-full h-3 -bottom-1 left-0 text-emerald-200/50 -z-10" viewBox="0 0 100 10" preserveAspectRatio="none">
                                <path d="M0 5 Q 50 10 100 5" stroke="currentColor" stroke-width="8" fill="none" />
                            </svg>
                        </span> 🚀
                    </h1>
                    <p class="text-slate-500 text-lg font-medium">بوابتك الأولى لمجتمع المطورين السعودي.</p>
                </div>

                <div class="mb-8">
                    <a href="{{ route('auth.google') }}" class="flex items-center justify-center gap-3 py-4 border border-slate-200 rounded-2xl hover:bg-slate-50/80 hover:border-slate-300 hover:shadow-md transition-all duration-300 text-slate-700 font-bold bg-white shadow-sm group">
                        <i class="fa-brands fa-google text-xl text-slate-600 group-hover:scale-110 transition-transform duration-300"></i>
                        <span>الاستمرار باستخدام Google</span>
                    </a>
                </div>

                @if (session('error'))
                    <div class="bg-red-50 border border-red-100 text-red-600 p-4 mb-8 rounded-2xl flex items-start gap-3 shadow-sm">
                        <i class="fa-solid fa-circle-exclamation mt-1"></i>
                        <div>
                            <p class="font-bold text-sm">تنبيه</p>
                            <p class="text-sm opacity-90">{{ session('error') }}</p>
                        </div>
                    </div>
                @endif

                <div class="relative mb-8">
                    <div class="absolute inset-0 flex items-center"><div class="w-full border-t border-slate-200"></div></div>
                    <div class="relative flex justify-center text-sm"><span class="px-4 bg-white text-slate-400 font-bold text-xs uppercase tracking-wider">أو التسجيل بالبريد</span></div>
                </div>

                <form wire:submit.prevent="register" class="space-y-6">

                    {{-- Grid for Name & Username --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                        {{-- Full Name --}}
                        <div class="group">
                            <label class="block text-sm font-bold text-slate-700 mb-2 mr-1">الاسم الكامل</label>
                            <div class="relative">
                                <input type="text"
                                       wire:model="name"
                                       placeholder="مثال: محمد العنزي"
                                       class="w-full pr-4 pl-12 py-3.5 rounded-2xl bg-white border border-slate-200 shadow-sm
                                              focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10
                                              outline-none transition-all duration-300 placeholder:text-slate-300 text-slate-800 font-semibold text-sm">

                                <div class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-300 group-focus-within:text-emerald-500 transition-colors">
                                    <i class="fa-regular fa-user"></i>
                                </div>
                            </div>
                            @error('name') <span class="text-red-500 text-xs mt-1 mr-1 font-bold block">{{ $message }}</span> @enderror
                        </div>

                        {{-- Username --}}
                        <div class="group space-y-2">
                            <label class="block text-sm font-bold text-slate-700 mr-1">
                                اسم المستخدم <span class="text-slate-400 text-[10px] font-normal"></span>
                            </label>

                            <div class="relative">
                                <div class="relative rounded-2xl border transition-all duration-300 bg-white shadow-sm
                                            focus-within:ring-4 focus-within:ring-emerald-500/10 focus-within:border-emerald-500
                                            @error('username') border-red-200 bg-red-50/10
                                            @else border-slate-200
                                            @enderror
                                            @if($usernameStatus === 'available') !border-emerald-500 !ring-4 !ring-emerald-500/10
                                            @elseif($usernameStatus === 'taken') !border-red-500 !bg-red-50/10
                                            @elseif($usernameStatus === 'invalid') !border-amber-400
                                            @endif">

                                    <div class="absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none z-10">
                                        <span class="text-slate-400 font-bold font-mono text-sm">@</span>
                                    </div>

                                    <input 
                                        type="text" 
                                        dir="ltr" 
                                        placeholder="mohammed_dev"
                                        wire:model.live.debounce.500ms="username"
                                        x-data
                                        x-on:input.capture="$el.value = $el.value.toLowerCase().replace(/[^a-z0-9_]/g, '')"
                                        class="w-full pl-12 pr-10 py-3.5 rounded-2xl outline-none bg-transparent 
                                               font-mono text-sm font-bold text-slate-800 
                                               placeholder:text-slate-300 placeholder:font-sans"
                                    />

                                    <div class="absolute left-3 top-1/2 -translate-y-1/2 flex items-center">
                                        <span wire:loading.flex wire:target="username" class="text-emerald-500 p-2">
                                            <i class="fa-solid fa-circle-notch fa-spin"></i>
                                        </span>
                                        
                                        <span wire:loading.remove wire:target="username" class="p-1">
                                            @if($usernameStatus === 'available')
                                                <i class="fa-solid fa-circle-check text-emerald-500 text-lg animate-bounce-short"></i>
                                            @elseif($usernameStatus === 'taken')
                                                <i class="fa-solid fa-circle-xmark text-red-500 text-lg"></i>
                                            @elseif($usernameStatus === 'invalid')
                                                <i class="fa-solid fa-triangle-exclamation text-amber-500 text-lg"></i>
                                            @endif
                                        </span>
                                    </div>
                                </div>
                                @error('username') <span class="text-red-500 text-xs mt-1 block mr-1">{{ $message }}</span> @enderror
                            </div>

                            {{-- Status Message --}}
                            <div class="h-4 flex items-center text-[10px] font-bold px-1 mt-1 transition-all duration-300">
                                @if($usernameStatus === 'available')
                                    <span class="text-emerald-600 flex items-center gap-1 animate-fade-in-up">
                                        <i class="fa-solid fa-check"></i> متاح للاستخدام
                                    </span>
                                @elseif($usernameStatus === 'taken')
                                    <span class="text-red-600 flex items-center gap-1 animate-fade-in-up">
                                        <i class="fa-solid fa-xmark"></i> محجوز مسبقاً
                                    </span>
                                @elseif($usernameStatus === 'invalid')
                                    <span class="text-amber-600 flex items-center gap-1 animate-fade-in-up">
                                        <i class="fa-solid fa-triangle-exclamation"></i> أحرف إنجليزية وأرقام فقط (3-20)
                                    </span>
                                @else
                                    <span class="text-slate-400 font-medium">أحرف إنجليزية صغيرة، أرقام، و _</span>
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- Email --}}
<div class="group space-y-2">
    <label class="block text-sm font-semibold text-slate-700 mb-1 mr-1">البريد الإلكتروني</label>

    <div class="relative">
        <div class="relative rounded-2xl border-2 transition-all duration-300
                    focus-within:shadow-lg focus-within:shadow-emerald-100/50
                    @error('email') border-red-200 bg-red-50/30 @else border-slate-200 bg-slate-50/50 @enderror
                    @if($emailStatus === 'available') !border-emerald-500 !bg-white
                    @elseif($emailStatus === 'taken') !border-red-500 !bg-white
                    @elseif($emailStatus === 'invalid') !border-amber-400 !bg-white
                    @endif">

            {{-- أيقونة يمين --}}
            <div class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-300 group-focus-within:text-emerald-500 transition-colors pointer-events-none">
                <i class="fa-regular fa-envelope"></i>
            </div>

            <input
                type="email"
                dir="ltr"
                autocomplete="email"
                placeholder="name@example.com"

                wire:model.live.debounce.600ms="email"

                class="w-full pl-12 pr-12 py-3.5 rounded-2xl outline-none bg-transparent
                       text-left font-medium text-slate-800 placeholder:text-slate-300"
            />

            {{-- حالة يسار --}}
            <div class="absolute left-3 top-1/2 -translate-y-1/2 flex items-center">

                {{-- Loading --}}
                <span wire:loading.flex wire:target="email"
                      class="inline-flex items-center justify-center w-9 h-9 rounded-xl bg-emerald-50 border border-emerald-100">
                    <i class="fa-solid fa-circle-notch fa-spin text-emerald-500"></i>
                </span>

                {{-- Result --}}
                <span wire:loading.remove wire:target="email"
                      class="inline-flex items-center justify-center w-9 h-9 rounded-xl
                      @if($emailStatus === 'available') bg-emerald-50 border border-emerald-100
                      @elseif($emailStatus === 'taken') bg-red-50 border border-red-100
                      @elseif($emailStatus === 'invalid') bg-amber-50 border border-amber-100
                      @else bg-slate-50 border border-slate-100 @endif">

                    @if($emailStatus === 'available')
                        <i class="fa-solid fa-circle-check text-emerald-500 text-lg"></i>
                    @elseif($emailStatus === 'taken')
                        <i class="fa-solid fa-circle-xmark text-red-500 text-lg"></i>
                    @elseif($emailStatus === 'invalid')
                        <i class="fa-solid fa-triangle-exclamation text-amber-500 text-lg"></i>
                    @else
                        <i class="fa-regular fa-envelope text-slate-400 text-sm"></i>
                    @endif
                </span>
            </div>
        </div>

        {{-- سطر الحالة --}}

        {{-- خطأ فاليديشن مرة وحدة --}}
        @error('email') <span class="text-red-500 text-xs mt-1 mr-1 font-medium block">{{ $message }}</span> @enderror
    </div>
</div>


                    {{-- Password --}}
                    <div x-data="{
                            password: @entangle('password').live,
                            show: false,
                            get okLength() { return String(this.password || '').length >= 8 },
                            get okMixed() { let p = String(this.password || ''); return /[a-z]/.test(p) && /[A-Z]/.test(p) && /[0-9]/.test(p) },
                            get okSymbols() { let p = String(this.password || ''); return /[!@#$%^&*(),.?:{}|<>]/.test(p) },
                            get allOk() { return this.okLength && this.okMixed && this.okSymbols }
                        }">
                        <label class="block text-sm font-bold text-slate-700 mb-2 mr-1">كلمة المرور</label>

                        <div class="relative group">
                            <input :type="show ? 'text' : 'password'"
                                   x-model="password"
                                   dir="ltr"
                                   placeholder="••••••••"
                                   class="w-full pl-12 pr-12 py-3.5 rounded-2xl bg-white border border-slate-200 shadow-sm
                                          outline-none transition-all duration-300 text-left font-semibold text-sm text-slate-800 placeholder:text-slate-300
                                          focus:ring-4 focus:ring-emerald-500/10"
                                   :class="{
                                        'focus:border-emerald-500': !password,
                                        '!border-emerald-500 ring-4 ring-emerald-500/10': allOk,
                                        '!border-red-300 bg-red-50/10 focus:!border-red-500 focus:!ring-red-500/10': password && !allOk
                                   }"
                            >

                            <div class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-300 group-focus-within:text-emerald-500 transition-colors">
                                <i class="fa-solid fa-lock"></i>
                            </div>

                            <button type="button" @click="show = !show"
                                    class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 hover:text-emerald-600 transition p-1">
                                <i class="fa-regular" :class="show ? 'fa-eye-slash' : 'fa-eye'"></i>
                            </button>
                        </div>

                        {{-- Password Rules --}}
                        <div class="mt-3 grid grid-cols-1 sm:grid-cols-3 gap-2" x-show="password" x-transition.opacity.duration.300ms>
                            <div class="flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-[10px] font-bold border transition-colors duration-300"
                                 :class="okLength ? 'bg-emerald-50 text-emerald-700 border-emerald-100' : 'bg-red-50 text-red-700 border-red-100'">
                                <i class="fa-solid" :class="okLength ? 'fa-check' : 'fa-xmark'"></i> 8+ خانات
                            </div>

                            <div class="flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-[10px] font-bold border transition-colors duration-300"
                                 :class="okMixed ? 'bg-emerald-50 text-emerald-700 border-emerald-100' : 'bg-red-50 text-red-700 border-red-100'">
                                <i class="fa-solid" :class="okMixed ? 'fa-check' : 'fa-xmark'"></i> Aa + 123
                            </div>

                            <div class="flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-[10px] font-bold border transition-colors duration-300"
                                 :class="okSymbols ? 'bg-emerald-50 text-emerald-700 border-emerald-100' : 'bg-red-50 text-red-700 border-red-100'">
                                <i class="fa-solid" :class="okSymbols ? 'fa-check' : 'fa-xmark'"></i> رمز خاص
                            </div>
                        </div>
                        @error('password') <span class="text-red-500 text-xs mt-1 block mr-1 font-bold">{{ $message }}</span> @enderror
                    </div>

                    {{-- Terms --}}
                    <div class="pt-2">
                        <label class="flex items-start gap-3 group cursor-pointer">
                            <div class="relative flex items-center mt-0.5">
                                <input wire:model="terms" type="checkbox"
                                       class="peer appearance-none w-5 h-5 border-2 border-slate-300 rounded-md bg-white checked:bg-emerald-600 checked:border-emerald-600 focus:ring-2 focus:ring-emerald-200 transition-all duration-200 cursor-pointer">
                                <i class="fa-solid fa-check text-white text-[10px] absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 opacity-0 peer-checked:opacity-100 pointer-events-none transition-opacity"></i>
                            </div>
<span class="text-sm text-slate-500 leading-snug select-none group-hover:text-slate-800 transition-colors font-medium">
    أوافق على
    <a href="{{ route('pages.terms') }}"
       class="text-emerald-600 font-bold hover:underline decoration-2 underline-offset-2">
        الشروط والأحكام
    </a>
    و
    <a href="{{ route('pages.privacy') }}"
       class="text-emerald-600 font-bold hover:underline decoration-2 underline-offset-2">
        سياسة الخصوصية
    </a>
    لمنصة Oneurai.
</span>

                        </label>
                        @error('terms') <span class="text-red-500 text-xs block mt-1 font-bold">{{ $message }}</span> @enderror
                    </div>

                    {{-- Submit Button (The Legend) --}}
                    <button type="submit"
                            class="w-full relative group overflow-hidden bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-500 hover:to-teal-500 text-white font-bold py-4 rounded-2xl shadow-lg shadow-emerald-500/30 hover:shadow-emerald-500/50 transition-all duration-300 transform hover:-translate-y-0.5 disabled:opacity-70 disabled:cursor-not-allowed disabled:transform-none disabled:shadow-none">

                        <div class="absolute inset-0 w-full h-full bg-gradient-to-r from-transparent via-white/20 to-transparent -translate-x-full group-hover:animate-shimmer"></div>

                        <div class="flex items-center justify-center gap-3 relative z-10">
                            <span wire:loading.remove class="text-lg tracking-wide">إنشاء حساب جديد</span>
                            <span wire:loading class="flex items-center gap-2">
                                <i class="fa-solid fa-circle-notch fa-spin"></i> جاري بناء البروفايل...
                            </span>
                            <i wire:loading.remove class="fa-solid fa-rocket group-hover:translate-x-1 group-hover:-translate-y-1 transition-transform duration-300"></i>
                        </div>
                    </button>
                </form>
            </div>
        </div>
    </div>

    {{-- RIGHT SECTION (Art) --}}
    <div class="hidden lg:flex w-1/2 h-full bg-[#0f172a] relative flex-col justify-between p-16 overflow-hidden">

        {{-- Cinematic Background --}}
        <div class="absolute top-0 right-0 w-full h-full bg-[url('https://grainy-gradients.vercel.app/noise.svg')] opacity-[0.15] mix-blend-soft-light"></div>
        <div class="absolute top-[-20%] right-[-10%] w-[600px] h-[600px] bg-emerald-500/20 rounded-full blur-[130px] mix-blend-screen animate-pulse"></div>
        <div class="absolute bottom-[-20%] left-[-10%] w-[700px] h-[700px] bg-blue-600/10 rounded-full blur-[130px] mix-blend-screen"></div>

        <div class="relative z-10 mt-12 animate-fade-in-up">
            <div class="inline-flex items-center px-4 py-2 rounded-full bg-white/5 border border-white/10 text-emerald-300 text-xs font-bold mb-8 backdrop-blur-md shadow-lg shadow-black/10 hover:bg-white/10 transition cursor-default">
                <span class="flex h-2 w-2 relative ml-3">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                </span>
                مجتمع تقني متنامي بسرعة ⚡
            </div>

            <h2 class="text-6xl font-bold text-white leading-tight mb-6 tracking-tight">
                المكان الأمثل <br>
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-emerald-400 via-teal-300 to-emerald-200">
                    للمطورين العرب.
                </span>
            </h2>
            <p class="text-slate-400 text-lg max-w-lg leading-relaxed font-light">
                Oneurai ليست مجرد منصة، بل هي بنية تحتية متكاملة للذكاء الاصطناعي، مصممة بأيدي سعودية لتخدم طموحك البرمجي.
            </p>
        </div>

        <div class="relative z-10 space-y-5 pr-8 border-r border-white/5">
            {{-- Card 1 --}}
            <div class="group flex items-center gap-5 p-5 rounded-2xl bg-white/5 border border-white/5 hover:bg-white/10 hover:border-emerald-500/30 hover:shadow-xl hover:shadow-emerald-900/20 backdrop-blur-sm transition-all duration-300 cursor-default transform hover:translate-x-2">
                <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-emerald-500/20 to-emerald-900/20 flex items-center justify-center text-emerald-400 text-2xl border border-emerald-500/20 group-hover:scale-110 transition-transform duration-300 shadow-inner shadow-emerald-500/10">
                    <i class="fa-solid fa-microchip"></i>
                </div>
                <div>
                    <h3 class="text-white font-bold text-lg mb-1 group-hover:text-emerald-300 transition-colors">استضافة نماذج AI</h3>
                    <p class="text-slate-400 text-sm font-light">مساحة سحابية (Cloud) عالية الأداء لتدريب نماذجك.</p>
                </div>
            </div>

            {{-- Card 2 --}}
            <div class="group flex items-center gap-5 p-5 rounded-2xl bg-white/5 border border-white/5 hover:bg-white/10 hover:border-blue-500/30 hover:shadow-xl hover:shadow-blue-900/20 backdrop-blur-sm transition-all duration-300 cursor-default transform hover:translate-x-2">
                <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-blue-500/20 to-blue-900/20 flex items-center justify-center text-blue-400 text-2xl border border-blue-500/20 group-hover:scale-110 transition-transform duration-300 shadow-inner shadow-blue-500/10">
                    <i class="fa-solid fa-database"></i>
                </div>
                <div>
                    <h3 class="text-white font-bold text-lg mb-1 group-hover:text-blue-300 transition-colors">بيانات عربية ضخمة</h3>
                    <p class="text-slate-400 text-sm font-light">وصول حصري لـ Datasets سعودية وعربية نادرة.</p>
                </div>
            </div>
        </div>

        <div class="relative z-10 pt-8 border-t border-white/10 flex items-center justify-between">
            <div class="flex items-center gap-4">
                <div class="flex -space-x-4 space-x-reverse">
                    <img class="w-12 h-12 rounded-full border-4 border-[#0f172a] shadow-md" src="https://i.pravatar.cc/100?img=33" alt="User">
                    <img class="w-12 h-12 rounded-full border-4 border-[#0f172a] shadow-md" src="https://i.pravatar.cc/100?img=47" alt="User">
                    <img class="w-12 h-12 rounded-full border-4 border-[#0f172a] shadow-md" src="https://i.pravatar.cc/100?img=12" alt="User">
                    <div class="w-12 h-12 rounded-full border-4 border-[#0f172a] bg-emerald-600 text-white text-xs font-bold flex items-center justify-center shadow-md">
                        +2k
                    </div>
                </div>
                <div>
                    <div class="flex text-amber-400 text-[10px] gap-0.5 mb-1">
                        <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i>
                    </div>
                    <p class="text-slate-300 text-sm font-medium">مطورين يثقون في Oneurai</p>
                </div>
            </div>

            <div class="text-white/10 text-5xl animate-float">
                <i class="fa-brands fa-laravel"></i>
            </div>
        </div>
    </div>

</div>