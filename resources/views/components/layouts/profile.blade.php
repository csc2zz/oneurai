@props(['user', 'activeTab' => 'overview'])

<div class="bg-[#F8FAFC] min-h-screen pb-12 font-sans selection:bg-emerald-500 selection:text-white" dir="rtl">

    {{-- خلفية جمالية علوية (Banner) تعطي فخامة للملف الشخصي --}}
    <div class="h-48 lg:h-64 bg-slate-900 relative overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-br from-emerald-900/40 to-slate-900"></div>
        <div class="absolute inset-0 opacity-10 animate-[pan-pattern_60s_linear_infinite]"
             style="background-image: url('https://www.transparenttextures.com/patterns/carbon-fibre.png');"></div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative -mt-24 lg:-mt-32 z-10">

        <div class="grid grid-cols-1 lg:grid-cols-4 gap-10">

            {{-- 1. Sidebar: معلومات المستخدم بتصميم البطاقة العائمة --}}
            <div class="lg:col-span-1">
                <div class="lg:sticky lg:top-8 space-y-6">

                    {{-- البطاقة الرئيسية للمستخدم --}}
                    <div class="bg-white rounded-[2.5rem] p-6 shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-slate-100 text-center lg:text-right relative overflow-hidden">
                        {{-- Avatar Section --}}
                        <div class="relative group inline-block lg:block mb-6">
                            <div class="absolute -inset-1 bg-gradient-to-tr from-emerald-500 to-blue-500 rounded-full blur opacity-25 group-hover:opacity-50 transition duration-500"></div>
                            @if($user->avatar)
                                <img src="{{ asset('storage/'.$user->avatar) }}"
                                     class="relative w-32 h-32 lg:w-full lg:h-auto aspect-square rounded-[2rem] border-4 border-white shadow-xl object-cover transition-transform duration-500 group-hover:scale-[1.02]">
                            @else
                                <div class="relative w-32 h-32 lg:w-full lg:h-auto aspect-square bg-gradient-to-br from-emerald-500 to-emerald-700 rounded-[2rem] flex items-center justify-center text-white text-4xl lg:text-6xl font-black border-4 border-white shadow-lg">
                                    {{ substr($user->name, 0, 1) }}
                                </div>
                            @endif
                        </div>

                        {{-- Identity --}}
                        <div class="space-y-1">
                            <h1 class="text-2xl font-black text-slate-900 tracking-tight flex items-center justify-center lg:justify-start gap-2">
                                {{ $user->name }}
                                <x-admin-badge :user="$user" />
                            </h1>
                            <p class="text-emerald-600 font-mono text-sm font-bold tracking-tighter" dir="ltr">{{ '@' . $user->username }}</p>
                        </div>

                        {{-- إحصائيات المتابعة الفخمة --}}
                        <div class="grid grid-cols-2 gap-4 mt-6 py-4 border-y border-slate-50" x-data>
                            <div class="cursor-pointer group/stat transition" @click="$dispatch('open-follow-modal', { userId: {{ $user->id }}, type: 'followers' })">
                                <span class="block text-xl font-black text-slate-900 group-hover/stat:text-emerald-600">{{ $user->followers()->count() }}</span>
                                <span class="text-[10px] uppercase font-black text-slate-400 tracking-widest">متابع</span>
                            </div>
                            <div class="cursor-pointer group/stat transition" @click="$dispatch('open-follow-modal', { userId: {{ $user->id }}, type: 'following' })">
                                <span class="block text-xl font-black text-slate-900 group-hover/stat:text-emerald-600">{{ $user->followings()->count() }}</span>
                                <span class="text-[10px] uppercase font-black text-slate-400 tracking-widest">يتابع</span>
                            </div>
                        </div>

                        {{-- Bio --}}
                        <div class="mt-6">
                            <p class="text-sm text-slate-500 leading-relaxed font-medium">
                                {{ $user->bio ?? 'لا توجد نبذة تعريفية لهؤلاء المبدعين.' }}
                            </p>
                        </div>

                        {{-- الأزرار --}}
                        <div class="mt-8 space-y-3">
                            @if(auth()->id() !== $user->id)
                                <div class="flex flex-col gap-2">
                                    <livewire:profile.follow-button :user="$user" />
                                    <livewire:chat.send-invitation :user="$user" class="w-full" />
                                </div>
                            @else
                                <a href="{{ route('dashboard.profile') }}" class="flex items-center justify-center gap-2 w-full bg-slate-900 text-white font-black py-3 rounded-2xl hover:bg-emerald-600 transition-all shadow-lg shadow-slate-200 transform active:scale-95 text-sm">
                                    <i class="fa-solid fa-pen-nib text-xs"></i> تعديل البروفايل
                                </a>
                            @endif
                        </div>
                    </div>

                    {{-- بطاقة المعلومات الإضافية --}}
                    <div class="bg-white rounded-[2rem] p-6 shadow-sm border border-slate-100 space-y-4">
                        <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-4">تفاصيل التواصل</h3>

                        @if($user->company)
                            <div class="flex items-center gap-3 text-sm font-bold text-slate-600 group">
                                <div class="w-8 h-8 rounded-lg bg-slate-50 flex items-center justify-center text-slate-400 group-hover:text-emerald-500 transition shadow-inner">
                                    <i class="fa-solid fa-building text-[10px]"></i>
                                </div>
                                <span>{{ $user->company }}</span>
                            </div>
                        @endif

                        @if($user->location)
                            <div class="flex items-center gap-3 text-sm font-bold text-slate-600 group">
                                <div class="w-8 h-8 rounded-lg bg-slate-50 flex items-center justify-center text-slate-400 group-hover:text-red-500 transition shadow-inner">
                                    <i class="fa-solid fa-location-dot text-[10px]"></i>
                                </div>
                                <span>{{ $user->location }}</span>
                            </div>
                        @endif

                        <div class="flex items-center gap-3 text-sm font-bold text-slate-600 group overflow-hidden">
                            <div class="w-8 h-8 rounded-lg bg-slate-50 flex items-center justify-center text-slate-400 group-hover:text-blue-500 transition shadow-inner">
                                <i class="fa-solid fa-envelope text-[10px]"></i>
                            </div>
                            <a href="mailto:{{ $user->email }}" class="hover:text-emerald-600 truncate transition underline decoration-slate-200 underline-offset-4">{{ $user->email }}</a>
                        </div>

                        @if($user->social_twitter)
                            <div class="flex items-center gap-3 text-sm font-bold text-slate-600 group">
                                <div class="w-8 h-8 rounded-lg bg-slate-50 flex items-center justify-center text-slate-400 group-hover:text-black transition shadow-inner">
                                    <i class="fa-brands fa-x-twitter text-[10px]"></i>
                                </div>
                                <a href="https://x.com/{{ $user->social_twitter }}" target="_blank" class="hover:text-emerald-600 font-mono tracking-tighter" dir="ltr">{{ '@' . $user->social_twitter }}</a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- 2. Main Content: التبويبات والمحتوى الديناميكي --}}
            <div class="lg:col-span-3 space-y-6">

                {{-- التبويبات (Tabs) بتصميم "الكبسولة الزجاجية" --}}
                <div class="sticky top-20 z-20">
                    <nav class="flex p-1.5 bg-white/80 backdrop-blur-xl border border-slate-200/60 rounded-[1.5rem] shadow-sm overflow-x-auto no-scrollbar" aria-label="Tabs" dir="rtl">
                        @php
                            $tabs = [
                                ['id' => 'overview', 'label' => 'نظرة عامة', 'icon' => 'fa-book-open', 'route' => route('profile.show', $user->username)],
                                ['id' => 'repositories', 'label' => 'المستودعات', 'icon' => 'fa-laptop-code', 'route' => route('profile.repositories', $user->username), 'count' => $user->projects()->where('is_public', true)->count()],
                                ['id' => 'models', 'label' => 'النماذج', 'icon' => 'fa-brain', 'route' => route('profile.models', $user->username), 'count' => $user->aiModels()->where('is_public', true)->count()],
                                ['id' => 'datasets', 'label' => 'البيانات', 'icon' => 'fa-database', 'route' => route('profile.datasets', $user->username), 'count' => $user->datasets()->where('visibility', 'public')->count()],
                            ];
                        @endphp

                        @foreach($tabs as $t)
                            <a href="{{ $t['route'] }}" wire:navigate
                               class="whitespace-nowrap flex-1 flex items-center justify-center gap-2 px-6 py-3 rounded-2xl text-xs font-black transition-all duration-300
                               {{ $activeTab === $t['id'] ? 'bg-slate-900 text-white shadow-lg shadow-slate-900/20' : 'text-slate-500 hover:text-slate-900 hover:bg-slate-50' }}">
                                <i class="fa-solid {{ $t['icon'] }} {{ $activeTab === $t['id'] ? 'text-emerald-400' : 'text-slate-400' }}"></i>
                                {{ $t['label'] }}
                                @isset($t['count'])
                                    <span class="inline-flex items-center justify-center w-5 h-5 rounded-lg text-[9px] font-black {{ $activeTab === $t['id'] ? 'bg-white/20 text-white' : 'bg-slate-100 text-slate-500' }}">
                                        {{ $t['count'] }}
                                    </span>
                                @endisset
                            </a>
                        @endforeach
                    </nav>
                </div>

                {{-- منطقة المحتوى --}}
                <div class="animate-fade-in-up">
                    <div class="min-h-[500px]">
                        {{ $slot }}
                    </div>
                </div>

            </div>

        </div>
    </div>

    <livewire:profile.follow-list />
    <style>
    .no-scrollbar::-webkit-scrollbar { display: none; }
    @keyframes pan-pattern { from { background-position: 0 0; } to { background-position: 1000px 1000px; } }
    .animate-fade-in-up {
        animation: fadeInUp 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards;
    }
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>
</div>

