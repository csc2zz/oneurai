<div class="bg-slate-50 text-slate-900 h-screen overflow-hidden flex selection:bg-emerald-100 selection:text-emerald-900">
    <div class="w-full lg:w-1/2 h-full bg-white flex flex-col justify-center px-8 sm:px-12 lg:px-20 relative overflow-y-auto">

        <div class="absolute top-8 right-8 sm:right-12 lg:right-20">
            <a href="{{ route('home') }}" class="flex items-center gap-2 cursor-pointer group">
                <div class="w-8 h-8 bg-emerald-600 rounded-lg flex items-center justify-center text-white group-hover:bg-emerald-700 transition">
                    <i class="fa-solid fa-code-branch"></i>
                </div>
                <span class="font-bold text-2xl tracking-tight text-slate-900 font-sans">Oneurai</span>
            </a>
        </div>

        <div class="max-w-md w-full mx-auto pt-20 lg:pt-0">
            <div class="mb-10">
                <h1 class="text-3xl font-bold text-slate-900 mb-2">أهلاً بعودتك 👋</h1>
                <p class="text-slate-500">أدخل بياناتك للدخول إلى مساحة العمل الخاصة بك.</p>
            </div>

            <div class="grid grid-cols-2 gap-4 mb-8">
                <button class="flex items-center justify-center gap-2 py-2.5 border border-slate-200 rounded-xl hover:bg-slate-50 transition text-slate-700 font-medium">
                    <i class="fa-brands fa-github text-lg"></i> <span>GitHub</span>
                </button>
                <a href="{{ route('auth.google') }}" class="flex items-center justify-center gap-2 py-2.5 border border-slate-200 rounded-xl hover:bg-slate-50 transition text-slate-700 font-medium">
                    <i class="fa-brands fa-google text-lg text-red-500"></i> <span>Google</span>
                </a>
            </div>

            @if (session('error'))
    <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-lg shadow-sm" role="alert">
        <p class="font-bold">تنبيه</p>
        <p>{{ session('error') }}</p>
    </div>
@endif

@if ($errors->any())
    <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-lg shadow-sm">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

            <div class="relative mb-8">
                <div class="absolute inset-0 flex items-center"><div class="w-full border-t border-slate-200"></div></div>
                <div class="relative flex justify-center text-sm"><span class="px-2 bg-white text-slate-500">أو المتابعة عبر البريد</span></div>
            </div>

<form wire:submit="login" class="space-y-5">
    <div>
        <label for="email" class="block text-sm font-medium text-slate-700 mb-1">البريد الإلكتروني</label>
        <input type="email" wire:model="email" name="email" id="email" class="w-full px-4 py-3 rounded-xl border @error('email') border-red-500 @else border-slate-300 @enderror focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 outline-none transition text-left" placeholder="name@example.com" dir="ltr">
        @error('email') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
    </div>

    <div>
        <div class="flex justify-between items-center mb-1">
            <label for="password" class="block text-sm font-medium text-slate-700">كلمة المرور</label>
            <a href="#" class="text-sm text-emerald-600 hover:text-emerald-700 font-medium">نسيت كلمة المرور؟</a>
        </div>
        <input type="password" wire:model="password" name="password" id="password" class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 outline-none transition text-left" placeholder="••••••••" dir="ltr">
        @error('password') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
    </div>

    <div class="flex items-center">
        <input id="remember-me" wire:model="remember" type="checkbox" class="h-4 w-4 text-emerald-600 focus:ring-emerald-500 border-slate-300 rounded">
        <label for="remember-me" class="mr-2 block text-sm text-slate-600">تذكرني على هذا الجهاز</label>
    </div>

    <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-3.5 rounded-xl shadow-lg shadow-emerald-600/20 transition duration-200 flex items-center justify-center gap-2 disabled:opacity-50">
        <span wire:loading.remove>تسجيل الدخول</span>
        <span wire:loading>جاري التحقق...</span>
        <i wire:loading.remove class="fa-solid fa-arrow-left text-sm"></i>
    </button>
</form>

            <div class="mt-8 text-center">
                <p class="text-slate-600">
                    ليس لديك حساب؟
                    <a href="{{ route('register') }}" class="text-emerald-600 font-bold hover:text-emerald-700 transition mr-1">أنشئ حساباً الآن</a>
                </p>
            </div>
        </div>

        <div class="absolute bottom-6 w-full text-center right-0 px-8 pointer-events-none">
            <p class="text-xs text-slate-400">© 2024 Oneurai. جميع الحقوق محفوظة.</p>
        </div>
    </div>

     <div class="hidden lg:flex w-1/2 h-full bg-slate-900 relative items-center justify-center overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-br from-slate-900 via-emerald-900 to-slate-900"></div>
            <div class="absolute top-0 right-0 w-96 h-96 bg-emerald-600 rounded-full blur-3xl opacity-20 -mr-20 -mt-20 animate-pulse"></div>
            <div class="absolute bottom-0 left-0 w-80 h-80 bg-amber-500 rounded-full blur-3xl opacity-10 -ml-20 -mb-20"></div>

            <div class="absolute inset-0 bg-grid-pattern"></div>

            <div class="relative z-10 max-w-lg mx-auto px-8">
                <div class="glass-card rounded-2xl p-6 mb-10 transform rotate-1 shadow-2xl border-l-4 border-l-amber-500">
                    <div class="flex gap-2 mb-4">
                        <div class="w-3 h-3 rounded-full bg-red-500"></div>
                        <div class="w-3 h-3 rounded-full bg-amber-500"></div>
                        <div class="w-3 h-3 rounded-full bg-green-500"></div>
                    </div>
                    <div class="font-mono text-sm space-y-2" dir="ltr">
                        <div class="text-slate-400"># Authenticate User</div>
                        <div>
                            <span class="text-purple-400">if</span>
                            <span class="text-white">Auth::attempt([</span>
                        </div>
                        <div class="pl-4">
                            <span class="text-emerald-400">'email'</span> <span class="text-white">=></span> <span class="text-amber-400">$email</span><span class="text-white">,</span>
                        </div>
                        <div class="pl-4">
                            <span class="text-emerald-400">'password'</span> <span class="text-white">=></span> <span class="text-amber-400">$password</span>
                        </div>
                        <div><span class="text-white">])) {</span></div>
                        <div class="pl-4">
                            <span class="text-blue-400">return</span> <span class="text-white">redirect()->to(</span><span class="text-emerald-400">'/dashboard'</span><span class="text-white">);</span>
                        </div>
                        <div><span class="text-white">}</span></div>
                    </div>
                </div>

                <h2 class="text-4xl font-bold text-white mb-6 leading-tight">
                    مجتمع المطورين والذكاء الاصطناعي <span class="text-emerald-400">الأول</span> في المملكة.
                </h2>
                <p class="text-slate-300 text-lg leading-relaxed mb-8">
                    انضم إلى الآلاف من المطورين وعلماء البيانات. شارك نماذجك، ساهم في المشاريع مفتوحة المصدر، وابنِ مستقبل التقنية العربية.
                </p>

                <div class="flex gap-8 pt-8 border-t border-white/10">
                    <div>
                        <div class="text-2xl font-bold text-white">5k+</div>
                        <div class="text-sm text-emerald-400">مطور نشط</div>
                    </div>
                    <div>
                        <div class="text-2xl font-bold text-white">850+</div>
                        <div class="text-sm text-amber-400">نموذج AI</div>
                    </div>
                    <div>
                        <div class="text-2xl font-bold text-white">100%</div>
                        <div class="text-sm text-slate-400">مفتوح المصدر</div>
                    </div>
                </div>
            </div>
        </div>
</div>
