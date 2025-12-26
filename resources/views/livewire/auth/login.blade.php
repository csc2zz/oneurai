<x-layouts.auth>
    <div class="flex flex-col gap-6">
        <x-auth-header :title="__('Log in to your account')" :description="__('Enter your email and password below to log in')" />

        <!-- Session Status -->
        <x-auth-session-status class="text-center" :status="session('status')" />

        <form method="POST" action="{{ route('login.store') }}" class="flex flex-col gap-6">
            @csrf

            <!-- Email Address -->
            <flux:input
                name="email"
                :label="__('Email address')"
                :value="old('email')"
                type="email"
                required
                autofocus
                autocomplete="email"
                placeholder="email@example.com"
            />

            <!-- Password -->
            <div class="relative">
                <flux:input
                    name="password"
                    :label="__('Password')"
                    type="password"
                    required
                    autocomplete="current-password"
                    :placeholder="__('Password')"
                    viewable
                />

                @if (Route::has('password.request'))
                    <flux:link class="absolute top-0 text-sm end-0" :href="route('password.request')" wire:navigate>
                        {{ __('Forgot your password?') }}
                    </flux:link>
                @endif
            </div>

            <!-- Remember Me -->
            <flux:checkbox name="remember" :label="__('Remember me')" :checked="old('remember')" />

            <div class="flex items-center justify-end">
                <flux:button variant="primary" type="submit" class="w-full" data-test="login-button">
                    {{ __('Log in') }}
                </flux:button>
            </div>
        </form>

        @if (Route::has('register'))
            <div class="space-x-1 text-sm text-center rtl:space-x-reverse text-zinc-600 dark:text-zinc-400">
                <span>{{ __('Don\'t have an account?') }}</span>
                <flux:link :href="route('register')" wire:navigate>{{ __('Sign up') }}</flux:link>
            </div>
        @endif
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
</x-layouts.auth>
