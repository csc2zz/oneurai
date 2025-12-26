<div class="min-h-screen bg-slate-50/50 pb-20" x-data="{ tab: 'profile' }">

    {{-- 1. الخلفية الجمالية (متجاوبة الارتفاع) --}}
    <div class="h-48 sm:h-64 bg-slate-900 w-full absolute top-0 left-0 z-0 overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-br from-emerald-900/40 via-slate-900 to-slate-900"></div>
        <div class="absolute top-0 left-0 w-full h-full opacity-10" style="background-image: radial-gradient(#fff 1px, transparent 1px); background-size: 20px 20px;"></div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 pt-6 sm:pt-10">

        {{-- 2. ترويسة الصفحة --}}
        <div class="flex flex-col sm:flex-row sm:items-end justify-between mb-8 pb-6 border-b border-white/10 gap-4 text-right" dir="rtl">
            <div class="text-white">
                <h1 class="text-2xl sm:text-3xl font-black tracking-tight">إعدادات الحساب</h1>
                <p class="text-slate-400 text-xs sm:text-sm mt-1 font-medium opacity-80">مختبر ونوراي للذكاء الاصطناعي - الإصدار 2.0</p>
            </div>

<div class="flex items-center gap-3 px-5 py-4 bg-white rounded-3xl border border-slate-200 shadow-sm mb-6">
    {{-- الأيقونة تتغير ديناميكياً مع اللون --}}
    <div class="w-10 h-10 rounded-xl bg-{{ Auth::user()->status->color() }}-50 flex items-center justify-center text-{{ Auth::user()->status->color() }}-600">
        <i class="fa-solid {{ Auth::user()->status->icon() }} text-lg"></i>
    </div>
    
    <div class="text-right">
        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">حالة الحساب الحالية</p>
        <div class="flex items-center gap-2">
            <span class="text-sm font-black text-slate-900">{{ Auth::user()->status->label() }}</span>
            
            {{-- نقطة النبض (Pulse) تتلون أيضاً حسب الحالة --}}
            <span class="relative flex h-2 w-2">
                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-{{ Auth::user()->status->color() }}-400 opacity-75"></span>
                <span class="relative inline-flex rounded-full h-2 w-2 bg-{{ Auth::user()->status->color() }}-500"></span>
            </span>
        </div>
    </div>
</div>
        </div>

        <div class="flex flex-col lg:flex-row gap-8 items-start" dir="rtl">

            {{-- 3. القائمة الجانبية الذكية (للجوال: شريط أفقي | للكمبيوتر: قائمة جانبية) --}}
            <aside class="w-full lg:w-72 flex-shrink-0 lg:sticky lg:top-8 z-20">
                <nav class="flex lg:flex-col overflow-x-auto lg:overflow-visible no-scrollbar bg-white rounded-[2rem] shadow-sm border border-slate-100 p-2 gap-2">
                    
                    <button @click="tab = 'profile'"
                        :class="tab === 'profile' ? 'bg-slate-900 text-white shadow-xl' : 'text-slate-500 hover:bg-slate-50'"
                        class="flex-1 lg:flex-none flex items-center justify-center lg:justify-start gap-3 px-5 py-3.5 text-xs sm:text-sm font-black rounded-2xl transition-all duration-300 whitespace-nowrap">
                        <i class="fa-regular fa-id-card text-lg"></i>
                        <span>الملف الشخصي</span>
                    </button>

                    <button @click="tab = 'security'"
                        :class="tab === 'security' ? 'bg-slate-900 text-white shadow-xl' : 'text-slate-500 hover:bg-slate-50'"
                        class="flex-1 lg:flex-none flex items-center justify-center lg:justify-start gap-3 px-5 py-3.5 text-xs sm:text-sm font-black rounded-2xl transition-all duration-300 whitespace-nowrap">
                        <i class="fa-solid fa-shield-halved text-lg"></i>
                        <span>الأمان والدخول</span>
                    </button>

                    <button @click="tab = 'notifications'"
                        :class="tab === 'notifications' ? 'bg-slate-900 text-white shadow-xl' : 'text-slate-500 hover:bg-slate-50'"
                        class="flex-1 lg:flex-none flex items-center justify-center lg:justify-start gap-3 px-5 py-3.5 text-xs sm:text-sm font-black rounded-2xl transition-all duration-300 whitespace-nowrap">
                        <i class="fa-regular fa-bell text-lg"></i>
                        <span>التنبيهات</span>
                    </button>

                    <div class="hidden lg:block my-2 border-t border-slate-100 mx-4"></div>

                    <button @click="tab = 'api'"
                        :class="tab === 'api' ? 'bg-emerald-50 text-emerald-800 border-emerald-100' : 'text-slate-500 hover:bg-slate-50'"
                        class="flex-1 lg:flex-none flex items-center justify-center lg:justify-start gap-3 px-5 py-3.5 text-xs sm:text-sm font-black rounded-2xl transition-all duration-300 whitespace-nowrap">
                        <i class="fa-solid fa-code text-lg"></i>
                        <span>منطقة المطورين</span>
                    </button>
                </nav>
            </aside>

            {{-- 4. منطقة المحتوى الرئيسي --}}
            <div class="flex-1 w-full space-y-6">

                {{-- أ: الملف الشخصي --}}
                <div x-show="tab === 'profile'" x-transition:enter="transition ease-out duration-300" class="space-y-6 text-right">
                    
                    {{-- بطاقة الصورة والتعريف --}}
                    <div class="bg-white rounded-[2.5rem] p-6 sm:p-10 border border-slate-200 shadow-sm relative overflow-hidden group">
                        <div class="absolute top-0 right-0 w-full h-24 bg-gradient-to-l from-slate-50 to-white"></div>
                        <div class="relative flex flex-col sm:flex-row items-center sm:items-end gap-6">
                            <div class="relative">
                                <div class="w-32 h-32 sm:w-40 sm:h-40 rounded-[2.5rem] p-1.5 bg-white shadow-2xl relative z-10 border border-slate-100">
                                    @if ($avatar)
                                        <img src="{{ $avatar->temporaryUrl() }}" class="w-full h-full rounded-[2rem] object-cover">
                                    @elseif($existingAvatar)
                                        <img src="{{ asset('storage/'.$existingAvatar) }}" class="w-full h-full rounded-[2rem] object-cover">
                                    @else
                                        <img src="https://ui-avatars.com/api/?name={{ urlencode($name) }}&background=0f172a&color=fff&size=256&bold=true" class="w-full h-full rounded-[2rem]">
                                    @endif
                                </div>
                                <label for="avatar-upload" class="absolute -bottom-2 -right-2 bg-emerald-600 text-white w-12 h-12 rounded-2xl flex items-center justify-center cursor-pointer hover:bg-emerald-500 transition shadow-xl z-20 border-4 border-white">
                                    <i class="fa-solid fa-camera"></i>
                                </label>
                                <input wire:model="avatar" type="file" id="avatar-upload" class="hidden" accept="image/*">
                            </div>
                            <div class="text-center sm:text-right flex-1 mb-2">
                                <h3 class="text-2xl font-black text-slate-900">{{ $name }}</h3>
                                <p class="text-emerald-600 text-sm font-mono font-bold mt-1" dir="ltr">@ {{ $username }}</p>
                                @error('avatar') <span class="text-red-500 text-[10px] font-bold mt-2 block">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>

                    {{-- بطاقة المعلومات الشخصية --}}
                    <div class="bg-white rounded-[2.5rem] p-6 sm:p-10 border border-slate-200 shadow-sm space-y-8">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-2">
                                <label class="text-[11px] font-black text-slate-400 uppercase tracking-widest mr-1">الاسم الكامل</label>
                                <input wire:model="name" type="text" class="w-full bg-slate-50 border-slate-100 rounded-2xl px-5 py-4 text-sm font-bold focus:bg-white focus:ring-4 focus:ring-emerald-500/5 focus:border-emerald-500 transition-all outline-none" placeholder="أدخل اسمك الحقيقي">
                            </div>
                            <div class="space-y-2">
                                <label class="text-[11px] font-black text-slate-400 uppercase tracking-widest mr-1">البريد الإلكتروني</label>
                                <input wire:model="email" type="email" dir="ltr" class="w-full bg-slate-50 border-slate-100 rounded-2xl px-5 py-4 text-sm font-bold focus:bg-white focus:ring-4 focus:ring-emerald-500/5 focus:border-emerald-500 transition-all outline-none">
                            </div>
                            <div class="md:col-span-2 space-y-2">
                                <label class="text-[11px] font-black text-slate-400 uppercase tracking-widest mr-1">نبذة تعريفية (Bio)</label>
                                <textarea wire:model="bio" rows="4" class="w-full bg-slate-50 border-slate-100 rounded-2xl px-5 py-4 text-sm font-medium focus:bg-white focus:ring-4 focus:ring-emerald-500/5 focus:border-emerald-500 transition-all outline-none resize-none" placeholder="أخبر مجتمع المطورين عن مهاراتك ومشاريعك..."></textarea>
                            </div>
                        </div>

                        {{-- روابط التواصل --}}
                        <div class="pt-6 border-t border-slate-50 grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div class="relative group">
                                <i class="fa-brands fa-x-twitter absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-emerald-500 transition-colors"></i>
                                <input wire:model="social_twitter" type="text" placeholder="اسم المستخدم في X" dir="ltr" class="w-full bg-slate-50 border-slate-100 rounded-xl py-3 pr-10 pl-4 text-xs font-bold outline-none focus:border-emerald-500 transition-all">
                            </div>
                            <div class="relative group">
                                <i class="fa-brands fa-github absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-slate-900 transition-colors"></i>
                                <input wire:model="social_github" type="text" placeholder="اسم المستخدم في GitHub" dir="ltr" class="w-full bg-slate-50 border-slate-100 rounded-xl py-3 pr-10 pl-4 text-xs font-bold outline-none focus:border-emerald-500 transition-all">
                            </div>
                            <div class="relative group">
                                <i class="fa-solid fa-globe absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-blue-500 transition-colors"></i>
                                <input wire:model="website" type="text" placeholder="رابط موقعك الشخصي" dir="ltr" class="w-full bg-slate-50 border-slate-100 rounded-xl py-3 pr-10 pl-4 text-xs font-bold outline-none focus:border-emerald-500 transition-all">
                            </div>
                        </div>

                        <div class="flex justify-end pt-4">
                            <button wire:click="updateProfile" wire:loading.attr="disabled" class="w-full sm:w-auto bg-slate-900 text-white px-10 py-4 rounded-2xl font-black text-sm hover:bg-emerald-600 transition-all shadow-xl shadow-slate-200 active:scale-95 flex items-center justify-center gap-3">
                                <span wire:loading.remove wire:target="updateProfile">حفظ التغييرات</span>
                                <span wire:loading wire:target="updateProfile"><i class="fa-solid fa-circle-notch fa-spin"></i> جاري الحفظ...</span>
                            </button>
                        </div>
                    </div>
                </div>

                {{-- ب: الأمان والدخول --}}
                <div x-show="tab === 'security'" x-transition class="space-y-6 text-right" style="display: none;">
                    
                    <div class="bg-white rounded-[2.5rem] p-6 sm:p-10 border border-slate-200 shadow-sm">
                        <h3 class="text-xl font-black text-slate-900 mb-8 flex items-center gap-3">
                            <i class="fa-solid fa-lock text-emerald-500"></i> إدارة كلمة المرور
                        </h3>
                        <div class="grid grid-cols-1 gap-5 max-w-xl">
                            <div class="space-y-2">
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest">كلمة المرور الحالية</label>
                                <input type="password" wire:model="current_password" class="w-full bg-slate-50 border-slate-100 rounded-2xl p-4 text-sm font-bold outline-none focus:border-emerald-500 transition">
                            </div>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div class="space-y-2">
                                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest">الجديدة</label>
                                    <input type="password" wire:model="new_password" class="w-full bg-slate-50 border-slate-100 rounded-2xl p-4 text-sm font-bold outline-none focus:border-emerald-500 transition">
                                </div>
                                <div class="space-y-2">
                                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest">تأكيد الجديدة</label>
                                    <input type="password" wire:model="new_password_confirmation" class="w-full bg-slate-50 border-slate-100 rounded-2xl p-4 text-sm font-bold outline-none focus:border-emerald-500 transition">
                                </div>
                            </div>
                            <button wire:click="updatePassword" class="w-fit bg-slate-100 text-slate-700 px-8 py-3 rounded-xl font-bold text-xs hover:bg-emerald-500 hover:text-white transition-all">تحديث كلمة المرور</button>
                        </div>
                    </div>

                    {{-- الجلسات النشطة --}}
                    <div class="bg-white rounded-[2.5rem] border border-slate-200 shadow-sm overflow-hidden">
                        <div class="p-8 bg-slate-50/50 border-b border-slate-100 flex justify-between items-center">
                            <h3 class="font-black text-slate-900 flex items-center gap-2 text-lg">
                                <i class="fa-solid fa-desktop text-emerald-500"></i> الجلسات النشطة
                            </h3>
                            <button wire:click="logoutOtherSessions" class="text-[10px] font-black text-red-500 hover:underline uppercase tracking-widest">تسجيل الخروج من بقية الأجهزة</button>
                        </div>
                        <div class="divide-y divide-slate-50">
                            @foreach($this->sessions as $session)
                                <div class="p-6 flex items-center justify-between group hover:bg-slate-50 transition-colors">
                                    <div class="flex items-center gap-5">
                                        <div class="w-12 h-12 rounded-2xl bg-white border border-slate-100 flex items-center justify-center text-slate-400 shadow-sm group-hover:text-emerald-500 transition-colors">
                                            <i class="fa-solid {{ in_array($session->agent->platform, ['iOS', 'Android']) ? 'fa-mobile-button' : 'fa-laptop' }} text-xl"></i>
                                        </div>
                                        <div>
                                            <div class="text-sm font-black text-slate-800 flex items-center gap-2">
                                                {{ $session->agent->platform }} • {{ $session->agent->browser }}
                                                @if($session->is_current_device)
                                                    <span class="text-[9px] font-black text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-full border border-emerald-100">الجهاز الحالي</span>
                                                @endif
                                            </div>
                                            <div class="text-[11px] text-slate-400 mt-1 font-medium font-mono" dir="ltr">{{ $session->ip_address }} • {{ $session->last_active }}</div>
                                        </div>
                                    </div>
                                    @if(!$session->is_current_device)
                                        <button wire:click="deleteSession('{{ $session->id }}')" class="w-9 h-9 rounded-xl flex items-center justify-center text-slate-300 hover:bg-red-50 hover:text-red-500 transition-all border border-transparent hover:border-red-100">
                                            <i class="fa-solid fa-trash-can text-sm"></i>
                                        </button>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                
                {{-- تذكر أن هذا الكود يوضع داخل <div x-show="tab === 'notifications'"> --}}
<div x-show="tab === 'notifications'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" class="space-y-6 text-right" dir="rtl">

    {{-- 1. بطاقة تفضيلات البريد الإلكتروني --}}
    <div class="bg-white rounded-[2.5rem] border border-slate-200 shadow-sm overflow-hidden">
        <div class="p-8 sm:p-10 border-b border-slate-100 bg-slate-50/50">
            <h3 class="text-xl font-black text-slate-900 flex items-center gap-3">
                <i class="fa-regular fa-envelope text-emerald-500"></i> إشعارات البريد الإلكتروني
            </h3>
            <p class="text-slate-500 text-sm mt-1 font-medium">اختر متى نرسل لك رسائل بريدية إلى {{ Auth::user()->email }}</p>
        </div>

        <div class="divide-y divide-slate-50">
            {{-- خيار: تحديثات المنصة --}}
            <div class="p-6 sm:p-8 flex items-center justify-between hover:bg-slate-50/80 transition-colors group">
                <div class="flex items-start gap-4">
                    <div class="w-10 h-10 rounded-xl bg-white border border-slate-100 flex items-center justify-center text-slate-400 group-hover:text-emerald-500 transition-colors shadow-sm">
                        <i class="fa-solid fa-bullhorn text-sm"></i>
                    </div>
                    <div>
                        <p class="text-sm font-black text-slate-800">أخبار وتحديثات المنصة</p>
                        <p class="text-xs text-slate-400 mt-1">تصلك رسائل دورية حول ميزات Oneurai الجديدة والتحسينات.</p>
                    </div>
                </div>
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" wire:model="notify_platform_updates" class="sr-only peer">
                    <div class="w-12 h-6 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-[-1.5rem] peer-checked:after:border-white after:content-[''] after:absolute after:top-[4px] after:right-[4px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-emerald-500"></div>
                </label>
            </div>

            {{-- خيار: نشاط المستودع --}}
            <div class="p-6 sm:p-8 flex items-center justify-between hover:bg-slate-50/80 transition-colors group">
                <div class="flex items-start gap-4">
                    <div class="w-10 h-10 rounded-xl bg-white border border-slate-100 flex items-center justify-center text-slate-400 group-hover:text-blue-500 transition-colors shadow-sm">
                        <i class="fa-solid fa-code-branch text-sm"></i>
                    </div>
                    <div>
                        <p class="text-sm font-black text-slate-800">تفاعلات مشاريعك</p>
                        <p class="text-xs text-slate-400 mt-1">عندما يقوم شخص ما بوضع نجمة (Star) أو تعليق على مستودعاتك.</p>
                    </div>
                </div>
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" wire:model="notify_repo_activity" class="sr-only peer">
                    <div class="w-12 h-6 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-[-1.5rem] peer-checked:after:border-white after:content-[''] after:absolute after:top-[4px] after:right-[4px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-emerald-500"></div>
                </label>
            </div>

            {{-- خيار: الأمان --}}
            <div class="p-6 sm:p-8 flex items-center justify-between hover:bg-slate-50/80 transition-colors group">
                <div class="flex items-start gap-4">
                    <div class="w-10 h-10 rounded-xl bg-white border border-slate-100 flex items-center justify-center text-slate-400 group-hover:text-red-500 transition-colors shadow-sm">
                        <i class="fa-solid fa-shield-circle-exclamation text-sm"></i>
                    </div>
                    <div>
                        <p class="text-sm font-black text-slate-800">تنبيهات الأمان</p>
                        <p class="text-xs text-slate-400 mt-1">رسائل عاجلة عند تسجيل دخول من متصفح جديد أو تغيير كلمة المرور.</p>
                    </div>
                </div>
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" wire:model="notify_security" class="sr-only peer" checked disabled>
                    <div class="w-12 h-6 bg-emerald-100 rounded-full opacity-50 cursor-not-allowed">
                        <div class="absolute top-[4px] left-[4px] bg-emerald-500 h-4 w-4 rounded-full"></div>
                    </div>
                </label>
            </div>
        </div>
    </div>

    {{-- 2. بطاقة تنبيهات المتصفح --}}
    <div class="bg-white rounded-[2.5rem] p-8 sm:p-10 border border-slate-200 shadow-sm">
        <div class="flex flex-col sm:flex-row items-center justify-between gap-6">
            <div class="text-center sm:text-right">
                <h3 class="text-lg font-black text-slate-900 flex items-center justify-center sm:justify-start gap-3">
                    <i class="fa-solid fa-desktop text-emerald-500"></i> إشعارات المتصفح (Web Push)
                </h3>
                <p class="text-slate-500 text-xs mt-2 font-medium">احصل على تنبيهات لحظية مباشرة على سطح المكتب أو الجوال.</p>
            </div>
            <button class="w-full sm:w-auto px-8 py-3 bg-slate-900 text-white rounded-2xl text-xs font-black hover:bg-emerald-600 transition-all shadow-lg active:scale-95">
                تفعيل الإشعارات اللحظية
            </button>
        </div>
    </div>

    {{-- 3. زر الحفظ النهائي --}}
    <div class="flex justify-end pt-4">
        <button wire:click="updateNotificationSettings" class="bg-emerald-600 hover:bg-emerald-700 text-white px-10 py-4 rounded-2xl font-black text-sm transition-all shadow-xl shadow-emerald-200 active:scale-95 flex items-center gap-3">
            <span>حفظ تفضيلات التنبيهات</span>
            <i class="fa-solid fa-check"></i>
        </button>
    </div>
</div>

                {{-- ج: منطقة المطورين (API) --}}
                <div x-show="tab === 'api'" x-transition class="space-y-6 text-right" dir="rtl">
    <div class="bg-slate-900 rounded-[2.5rem] p-8 sm:p-12 text-white relative overflow-hidden shadow-2xl">
        {{-- تأثير خلفية ضوئي --}}
        <div class="absolute top-0 left-0 w-80 h-80 bg-emerald-500/10 rounded-full blur-[100px] -ml-40 -mt-40 pointer-events-none"></div>
        
        <div class="relative z-10 space-y-8">
            {{-- الترويسة --}}
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 rounded-[1.5rem] bg-emerald-500/20 border border-emerald-500/30 flex items-center justify-center text-emerald-400 text-2xl shadow-inner">
                    <i class="fa-solid fa-terminal"></i>
                </div>
                <div>
                    <h3 class="text-xl font-black italic tracking-tight">بوابة المطورين</h3>
                    <p class="text-slate-400 text-sm font-medium">إدارة مفاتيح الوصول البرمجية لخدمات ونوراي.</p>
                </div>
            </div>

            {{-- 1. عرض الرمز المولد حديثاً (يظهر فقط عند التوليد أو إعادة التوليد) --}}
            @if ($plainTextToken)
                <div class="bg-emerald-500/10 border border-emerald-500/30 rounded-[2rem] p-8 animate-pulse-once shadow-2xl shadow-emerald-500/5" x-data="{ copied: false }">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-2 h-2 rounded-full bg-emerald-500 animate-ping"></div>
                        <p class="text-emerald-400 text-xs font-black uppercase tracking-widest">تم إصدار المفتاح بنجاح</p>
                    </div>
                    
                    <p class="text-slate-300 text-sm mb-6 leading-relaxed font-medium">انسخ الرمز الآن واحفظه في مكان آمن، فلن تتمكن من رؤيته مرة أخرى بعد إغلاق هذه النافذة.</p>
                    
                    <div class="flex flex-col sm:flex-row gap-3 bg-slate-950/50 p-2 rounded-2xl border border-white/5 shadow-inner">
                        <input type="text" readonly value="{{ $plainTextToken }}" 
                               class="flex-1 bg-transparent border-0 px-4 py-3 font-mono text-sm text-emerald-400 outline-none focus:ring-0 text-left" dir="ltr">
                        <button @click="navigator.clipboard.writeText('{{ $plainTextToken }}'); copied = true; setTimeout(() => copied = false, 2000)" 
                                class="bg-emerald-500 hover:bg-emerald-400 text-white px-8 py-3 rounded-xl font-black text-xs transition active:scale-95 shadow-lg shadow-emerald-500/20 whitespace-nowrap">
                            <span x-show="!copied">نسخ الرمز</span>
                            <span x-show="copied" class="flex items-center gap-2"><i class="fa-solid fa-check"></i> تم النسخ!</span>
                        </button>
                    </div>
                    
                    <button wire:click="closeTokenDisplay" 
                            class="mt-6 text-[10px] font-black text-slate-500 hover:text-white transition-colors uppercase underline underline-offset-8">
                        لقد قمت بحفظ الرمز، إغلاق هذه النافذة
                    </button>
                </div>
            @endif

            {{-- 2. نموذج إنشاء مفتاح جديد (يختفي عند عرض الرمز المولد لزيادة التركيز) --}}
            @if (!$plainTextToken)
                <div class="bg-white/5 border border-white/10 rounded-[2rem] p-6 sm:p-8">
                    <h4 class="text-xs font-black text-emerald-400 uppercase tracking-[0.2em] mb-6">إنشاء مفتاح وصول جديد</h4>
                    <form wire:submit.prevent="createNewToken" class="flex flex-col sm:flex-row gap-4 items-end">
                        <div class="flex-1 w-full space-y-2">
                            <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest mr-2">اسم المفتاح</label>
                            <input wire:model="tokenName" type="text" placeholder="مثال: تطبيق الجوال أو خادم الإنتاج" 
                                   class="w-full bg-slate-800/50 border-0 rounded-2xl px-5 py-4 text-sm font-bold text-white focus:ring-2 focus:ring-emerald-500 transition-all outline-none placeholder:text-slate-600">
                            @error('tokenName') <span class="text-red-400 text-[10px] font-bold block mt-1">{{ $message }}</span> @enderror
                        </div>
                        <button type="submit" class="w-full sm:w-auto bg-white text-slate-900 px-8 py-4 rounded-2xl font-black text-sm hover:bg-emerald-400 transition-all active:scale-95 shadow-xl">
                            إصدار المفتاح
                        </button>
                    </form>
                </div>
            @endif

            {{-- 3. قائمة المفاتيح النشطة --}}
            <div class="space-y-4 pt-6">
                <div class="flex items-center justify-between px-2">
                    <h4 class="text-[10px] font-black text-slate-500 uppercase tracking-[0.3em]">المفاتيح النشطة حالياً</h4>
                    <span class="text-[9px] font-black text-emerald-500/50 uppercase tracking-tighter">{{ count($this->tokens) }} مفتاح</span>
                </div>
                
                <div class="space-y-3">
                    @forelse($this->tokens as $token)
                        <div class="flex items-center justify-between bg-white/5 border border-white/5 rounded-2xl p-5 hover:bg-white/10 transition-all group border-r-4 border-r-transparent hover:border-r-emerald-500">
                            <div class="flex items-center gap-4 text-right">
                                <div class="w-12 h-12 rounded-xl bg-slate-800 border border-slate-700 flex items-center justify-center text-slate-500 group-hover:text-emerald-400 group-hover:border-emerald-500/30 transition-all shadow-inner">
                                    <i class="fa-solid fa-key text-sm"></i>
                                </div>
                                <div>
                                    <p class="font-black text-sm text-white group-hover:text-emerald-400 transition-colors">{{ $token->name }}</p>
                                    <p class="text-[10px] text-slate-500 mt-1 font-bold">
                                        آخر استخدام: <span class="text-slate-400">{{ $token->last_used_at ? $token->last_used_at->diffForHumans() : 'لم يستخدم بعد' }}</span>
                                    </p>
                                </div>
                            </div>

                            <div class="flex items-center gap-2">
                                {{-- زر إعادة التوليد --}}
                                <button wire:click="regenerateToken({{ $token->id }})" 
                                        wire:confirm="تنبيه: سيتم إبطال المفتاح الحالي فوراً وإصدار مفتاح جديد بنفس الاسم. هل أنت متأكد؟"
                                        class="w-10 h-10 rounded-xl flex items-center justify-center text-slate-500 hover:bg-emerald-500/20 hover:text-emerald-400 transition-all"
                                        title="إعادة توليد المفتاح">
                                    <i class="fa-solid fa-arrows-rotate text-sm" wire:loading.class="animate-spin" wire:target="regenerateToken({{ $token->id }})"></i>
                                </button>

                                {{-- زر الحذف --}}
                                <button wire:click="deleteToken({{ $token->id }})" 
                                        wire:confirm="هل تريد فعلاً حذف هذا المفتاح؟ التطبيقات التي تستخدمه ستتوقف عن العمل فوراً."
                                        class="w-10 h-10 rounded-xl flex items-center justify-center text-slate-500 hover:bg-red-500/20 hover:text-red-400 transition-all"
                                        title="حذف المفتاح">
                                    <i class="fa-solid fa-trash-can text-sm"></i>
                                </button>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-12 bg-white/5 rounded-3xl border border-dashed border-white/10">
                            <i class="fa-solid fa-key-skeleton text-slate-700 text-3xl mb-3 block"></i>
                            <p class="text-slate-500 text-sm font-bold">لا توجد مفاتيح نشطة حالياً.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

            </div>
        </div>
    </div><style>
    /* تحسينات التمرير للجوال */
    .no-scrollbar::-webkit-scrollbar { display: none; }
    .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    
    @keyframes pulse-once {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.02); }
    }
    .animate-pulse-once { animation: pulse-once 0.5s ease-in-out 1; }

    /* تحسينات حقول الإدخال */
    input:focus, textarea:focus, select:focus {
        box-shadow: 0 10px 15px -3px rgba(16, 185, 129, 0.05);
    }
    
    [x-cloak] { display: none !important; }
</style>
</div>

