<x-layouts.app>
    <x-slot:title>قصة ونوراي | Oneurai</x-slot:title>

    <style>
        .pattern-dots {
            background-image: radial-gradient(#10b981 1px, transparent 1px);
            background-size: 32px 32px;
        }
        .luxury-shadow {
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.03);
        }
    </style>

    {{-- 1. Hero Section: ترويسة الطموح --}}
    <section class="relative pt-32 pb-24 lg:pt-48 lg:pb-36 overflow-hidden bg-white">
        <div class="absolute inset-0 pattern-dots opacity-[0.03]"></div>
        {{-- هالات ضوئية خلفية --}}
        <div class="absolute top-0 right-0 w-[600px] h-[600px] bg-emerald-50 rounded-full blur-[120px] -mr-40 -mt-40"></div>

        <div class="max-w-7xl mx-auto px-6 relative z-10 text-center animate-fade-in-up">
            <div class="inline-flex items-center gap-2 px-4 py-2 rounded-2xl bg-emerald-500/10 border border-emerald-500/20 text-emerald-600 text-[11px] font-black uppercase tracking-[0.2em] mb-8">
                <i class="fa-solid fa-rocket animate-bounce-short"></i> قصتنا وبدايتنا
            </div>

            <h1 class="text-5xl lg:text-8xl font-black text-slate-900 mb-8 tracking-tighter leading-[1.05]">
                نحن المعمار الرقمي <br>
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-emerald-600 via-emerald-500 to-teal-400 drop-shadow-sm">للمستقبل السعودي.</span>
            </h1>

            <p class="text-lg lg:text-2xl text-slate-500 max-w-4xl mx-auto leading-relaxed font-medium">
                ونوراي ليست مجرد منصة؛ بل هي القلب النابض لمجتمع المطورين العربي، حيث يلتقي الذكاء الاصطناعي بالهوية الوطنية لبناء بنية تحتية تقنية مستدامة.
            </p>
        </div>
    </section>

    {{-- 2. الرؤية والإحصائيات: تصميم البطاقة المتداخلة --}}
    <section class="py-24 bg-[#F8FAFC]">
        <div class="max-w-7xl mx-auto px-6">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-20 items-center">
                <div class="animate-fade-in-up">
                    <div class="w-14 h-14 bg-slate-900 text-white rounded-[1.2rem] flex items-center justify-center text-2xl mb-8 shadow-xl">
                        <i class="fa-solid fa-seedling"></i>
                    </div>
                    <h2 class="text-4xl font-black text-slate-900 mb-6 tracking-tight">رؤية تتجاوز الحدود</h2>
                    <div class="space-y-6 text-slate-600 text-lg font-medium leading-loose">
                        <p>تأسست **Oneurai** لتكون الجسر الذي يعبر عليه المبدعون نحو توطين المعرفة. نؤمن بأن لغتنا العربية وثقافتنا المحلية تستحق تمثيلاً رقمياً أدق وأكثر ذكاءً.</p>
                        <p class="p-6 bg-white rounded-3xl border-r-4 border-emerald-500 shadow-sm italic">
                            "هدفنا أن نجعل من المملكة العربية السعودية مركزاً عالمياً لتطوير النماذج مفتوحة المصدر، لخدمة الإنسان والوطن."
                        </p>
                    </div>
                </div>

                {{-- الكروت التفاعلية --}}
                <div class="relative group">
                    <div class="absolute -inset-4 bg-emerald-500/5 blur-3xl rounded-full opacity-50 group-hover:opacity-100 transition-opacity"></div>
                    <div class="relative grid grid-cols-1 gap-6">
                        @php
                            $stats = [
                                ['label' => 'نماذج مفتوحة', 'val' => '100%', 'icon' => 'fa-brain', 'color' => 'text-emerald-600', 'bg' => 'bg-emerald-50', 'rotate' => '-rotate-2'],
                                ['label' => 'مجتمع نشط', 'val' => '5,000+', 'icon' => 'fa-users', 'color' => 'text-blue-600', 'bg' => 'bg-blue-50', 'rotate' => 'rotate-2'],
                                ['label' => 'بيانات عربية', 'val' => '10TB+', 'icon' => 'fa-database', 'color' => 'text-amber-600', 'bg' => 'bg-amber-50', 'rotate' => '-rotate-1'],
                            ];
                        @endphp
                        @foreach($stats as $stat)
                            <div class="bg-white p-6 rounded-[2rem] border border-slate-100 shadow-xl flex items-center gap-6 transform transition-all duration-500 hover:scale-105 hover:z-10 {{ $stat['rotate'] }} hover:rotate-0">
                                <div class="w-16 h-16 rounded-2xl {{ $stat['bg'] }} {{ $stat['color'] }} flex items-center justify-center text-2xl shadow-inner">
                                    <i class="fa-solid {{ $stat['icon'] }}"></i>
                                </div>
                                <div>
                                    <div class="text-[10px] font-black text-slate-400 uppercase tracking-widest">{{ $stat['label'] }}</div>
                                    <div class="text-3xl font-black text-slate-900 tracking-tighter">{{ $stat['val'] }}</div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- 3. القيم الجوهرية: تصميم الكبسولة --}}
    <section class="py-32 bg-white relative overflow-hidden">
        <div class="max-w-7xl mx-auto px-6 relative z-10">
            <div class="text-center mb-24">
                <span class="text-emerald-600 font-black uppercase tracking-[0.3em] text-xs">Philosophy</span>
                <h2 class="text-4xl lg:text-5xl font-black text-slate-900 mt-4 tracking-tighter">المبادئ التي تقودنا</h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
                @php
                    $values = [
                        ['icon' => 'fa-lock-open', 'title' => 'المصدر المفتوح', 'desc' => 'نؤمن بأن المعرفة حق للجميع. جميع أدواتنا الأساسية مبنية لتعزيز الشفافية والتعاون الجماعي.', 'color' => 'emerald'],
                        ['icon' => 'fa-language', 'title' => 'اللغة العربية أولاً', 'desc' => 'تطويع الذكاء الاصطناعي لفهم اللهجات والأنماط اللغوية العربية لضمان سيادة البيانات.', 'color' => 'blue'],
                        ['icon' => 'fa-handshake-angle', 'title' => 'تمكين المبدعين', 'desc' => 'نوفر الأدوات، التعليم والدعم اللازم ليتحول المطور من مستخدم للتقنية إلى صانع لها.', 'color' => 'amber'],
                    ];
                @endphp
                @foreach($values as $v)
                    <div class="group p-10 rounded-[3rem] bg-slate-50 border border-slate-100 hover:bg-white hover:border-{{ $v['color'] }}-200 transition-all duration-500 hover:shadow-2xl hover:-translate-y-2">
                        <div class="w-20 h-20 rounded-3xl bg-{{ $v['color'] }}-500/10 text-{{ $v['color'] }}-600 flex items-center justify-center text-4xl mb-8 group-hover:scale-110 group-hover:rotate-6 transition-all">
                            <i class="fa-solid {{ $v['icon'] }}"></i>
                        </div>
                        <h3 class="text-2xl font-black text-slate-900 mb-4 tracking-tight">{{ $v['title'] }}</h3>
                        <p class="text-slate-500 leading-[1.8] font-medium">{{ $v['desc'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- 4. الفريق: تصميم الوجوه المضيئة --}}
<section class="py-40 bg-[#020617] overflow-hidden relative">
    {{-- تأثيرات Mesh Gradient في الخلفية لإعطاء عمق فخم --}}
    <div class="absolute top-0 left-1/4 w-[500px] h-[500px] bg-emerald-500/10 rounded-full blur-[120px] -z-0 animate-pulse"></div>
    <div class="absolute bottom-0 right-1/4 w-[500px] h-[500px] bg-blue-500/10 rounded-full blur-[120px] -z-0 animate-pulse" style="animation-delay: 2s"></div>

    <div class="max-w-7xl mx-auto px-6 text-center relative z-10">
        {{-- عنوان فخم مع خط متدرج --}}
        <div class="mb-24">
            <h2 class="text-5xl lg:text-7xl font-black text-white mb-6 tracking-tighter leading-none">
                العقول وراء <span class="bg-gradient-to-r from-emerald-400 to-cyan-400 bg-clip-text text-transparent">ونوراي</span>
            </h2>
            <div class="h-1.5 w-32 bg-gradient-to-r from-emerald-500 to-cyan-500 mx-auto rounded-full"></div>
        </div>
        
        <div class="flex flex-wrap justify-center gap-12 lg:gap-24" dir="rtl">
    @php
        // جلب محمد (1)، وأبو متعب (3)، والعضو الأسطوري (7)
        $teamMembers = \App\Models\User::whereIn('id', [1, 3, 7])->orderBy('id', 'asc')->get();
        
        $roles = [
            1 => ['titleen' => '', 'title' => 'المؤسس والمهندس الرئيسي', 'color' => 'emerald', 'sign' => 'Lead dev'],
            3 => ['titleen' => '', 'title' => 'المؤسس والمدير التقني', 'color' => 'blue', 'sign' => 'CTO'],
            7 => ['titleen' => '', 'title' => 'الفريق الأسطوري', 'color' => 'purple', 'sign' => 'Legendary']
        ];
    @endphp

    @foreach($teamMembers as $user)
        @php
            $userRole = $roles[$user->id]['title'] ?? 'عضو فريق';
            $userRoleen = $roles[$user->id]['titleen'] ?? 'عضو فريق';
            $userColor = $roles[$user->id]['color'] ?? 'slate';
            $userSign = $roles[$user->id]['sign'] ?? 'Core';
            
            // تحديد الاسم: ثابت لـ 1 و 3، وديناميكي لـ 7
            $displayName = match($user->id) {
                1 => 'Mohammed Alanazi',
                3 => 'Mohammed Alanazi',
                7 => $user->name,
                default => $user->name
            };

            $avatarUrl = $user->avatar 
                ? asset('storage/' . $user->avatar) 
                : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=0f172a&color=fff&size=256&bold=true';
        @endphp

<div class="group relative w-full sm:w-80 h-[520px]">
    
    {{-- خلفية البطاقة الزجاجية --}}
    <div class="absolute inset-0 bg-gradient-to-br from-white/5 to-white/2 backdrop-blur-2xl rounded-[3.5rem] border border-white/10 shadow-2xl shadow-black/20 transition-all duration-500 group-hover:scale-[1.02] group-hover:border-{{ $userColor }}-500/30 group-hover:shadow-{{ $userColor }}-500/10"></div>
    
    <div class="relative p-8 flex flex-col items-center h-full">
        
        {{-- 1. قسم الصورة --}}
<div class="relative mb-10">
            {{-- تأثير الهالة المضيئة --}}
            <div class="absolute -inset-6 bg-gradient-to-tr from-{{ $userColor }}-500/30 to-transparent rounded-full blur-2xl opacity-0 group-hover:opacity-100 transition duration-700"></div>
            
            {{-- الإطار الخارجي المتدرج --}}
            <div class="relative p-1.5 bg-gradient-to-tr from-{{ $userColor }}-500 to-white/20 rounded-[3rem] shadow-2xl">
                <a href="{{ route('profile.show', $user->username) }}" class="block overflow-hidden rounded-[2.8rem]">
                    <img src="{{ $avatarUrl }}"
                         alt="{{ $displayName }}"
                         class="w-44 h-44 lg:w-52 lg:h-52 object-cover transition-all duration-700 group-hover:scale-110 group-hover:rotate-2">
                </a>
                
                {{-- شارة البصمة الرقمية --}}
                <div class="absolute -top-3 -right-3 bg-{{ $userColor }}-500 text-white w-10 h-10 rounded-2xl flex items-center justify-center shadow-xl border-4 border-[#020617] transform group-hover:rotate-12 transition-all">
                    <i class="fa-solid {{ $user->id == 7 ? 'fa-bolt' : 'fa-fingerprint' }} text-lg"></i>
                </div>
            </div>
        </div>

        {{-- 2. قسم النصوص والروابط --}}
        <div class="text-center space-y-4 flex-1 pb-20 w-full">
            {{-- الاسم --}}
            <div class="space-y-3">
                <h3 class="text-2xl font-black text-white tracking-tight mb-2 italic bg-gradient-to-r from-white to-white/80 bg-clip-text text-transparent">
                    {{ $displayName }}
                </h3>
                
                {{-- البادج --}}
                <div class="inline-flex items-center px-5 py-2 bg-gradient-to-r from-{{ $userColor }}-500/15 to-{{ $userColor }}-500/5 border border-{{ $userColor }}-500/30 rounded-xl backdrop-blur-sm">
                    <span class="text-xs font-bold text-{{ $userColor }}-300 uppercase tracking-widest">{{ $userRole }}</span>
                </div>
            </div>

            {{-- الروابط الاجتماعية --}}
            <!--<div class="flex justify-center gap-3 pt-6">-->
            <!--    @if($user->social_twitter)-->
            <!--        <a -->
            <!--            href="https://x.com/{{ $user->social_twitter }}" -->
            <!--            target="_blank" -->
            <!--            rel="noopener noreferrer"-->
            <!--            class="w-12 h-12 rounded-xl bg-gradient-to-br from-white/5 to-white/2 flex items-center justify-center text-slate-300 hover:text-{{ $userColor }}-300 hover:from-{{ $userColor }}-500/20 hover:to-{{ $userColor }}-500/5 border border-white/10 hover:border-{{ $userColor }}-500/30 transition-all duration-300 hover:scale-110 hover:shadow-lg hover:shadow-{{ $userColor }}-500/20"-->
            <!--        >-->
            <!--            <i class="fa-brands fa-x-twitter text-lg"></i>-->
            <!--        </a>-->
            <!--    @endif-->
                
            <!--    <a -->
            <!--        href="{{ route('profile.show', $user->username) }}"-->
            <!--        class="w-12 h-12 rounded-xl bg-gradient-to-br from-white/5 to-white/2 flex items-center justify-center text-slate-300 hover:text-white hover:from-{{ $userColor }}-600/20 hover:to-{{ $userColor }}-500/10 border border-white/10 hover:border-{{ $userColor }}-500/40 transition-all duration-300 hover:scale-110 hover:shadow-lg hover:shadow-{{ $userColor }}-500/20"-->
            <!--    >-->
            <!--        <i class="fa-solid fa-arrow-up-right-from-square text-sm"></i>-->
            <!--    </a>-->
            <!--</div>-->
        </div>

        {{-- 3. شريط الكود --}}
        <div class="absolute bottom-8 left-0 w-full px-8 opacity-40 group-hover:opacity-100 transition-all duration-500">
            {{-- فاصل تقني --}}
            <div class="flex items-center gap-4 mb-4">
                <div class="h-px flex-1 bg-gradient-to-l from-{{ $userColor }}-500/30 via-{{ $userColor }}-500/10 to-transparent"></div>
                <div class="flex items-center gap-2">
                    <div class="w-2 h-2 rounded-full bg-{{ $userColor }}-500 animate-pulse shadow-lg shadow-{{ $userColor }}-500/50"></div>
                    <span class="text-[9px] font-mono text-{{ $userColor }}-400 font-bold tracking-[0.3em] uppercase">Live.Status</span>
                </div>
                <div class="h-px flex-1 bg-gradient-to-r from-{{ $userColor }}-500/30 via-{{ $userColor }}-500/10 to-transparent"></div>
            </div>
            
            {{-- سطر الكود البرمجي --}}
            <div class="bg-gradient-to-r from-white/3 to-white/1 rounded-xl py-3 px-4 backdrop-blur-sm border border-white/10 shadow-inner">
                <p class="text-center font-mono text-xs text-slate-300/80 group-hover:text-{{ $userColor }}-200 transition-colors duration-300 leading-relaxed select-none">
                    <span class="text-{{ $userColor }}-400 font-bold">This</span>
                    <span class="text-slate-400">class</span> 
                    <span class="text-{{ $userColor }}-300">Developer</span> 
                    <span class="text-slate-400">{</span>
                    <span class="text-slate-300">execute("<span class="text-{{ $userColor }}-400">Hello World!</span>")</span>
                    <span class="text-slate-400">}</span>
                </p>
            </div>
        </div>
    </div>
</div>
@endforeach
</div>
    </div>
</section>
    {{-- 5. Final CTA: الانضمام للمستقبل --}}
    <section class="relative py-24 bg-[#0B1120] overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-br from-emerald-600/20 to-slate-900"></div>
        <div class="max-w-4xl mx-auto px-6 text-center relative z-10 animate-fade-in-up">
            <h2 class="text-3xl lg:text-5xl font-black text-white mb-8 tracking-tighter">كن جزءاً من القصة.</h2>
            <p class="text-slate-400 text-lg mb-12 font-medium">
                رحلتنا في تمكين الذكاء الاصطناعي العربي قد بدأت للتو، وبابنا مفتوح لكل من يملك الطموح.
            </p>
            <div class="flex flex-col sm:flex-row justify-center gap-6">
                <a href="{{ route('register') }}" class="px-10 py-4 bg-emerald-600 text-white rounded-2xl font-black text-sm shadow-xl shadow-emerald-500/20 hover:bg-emerald-500 transition-all transform active:scale-95">ابدأ مجاناً الآن</a>
                <a href="{{ route('pages.contact') }}" class="px-10 py-4 bg-white/5 backdrop-blur-md text-white border border-white/10 rounded-2xl font-black text-sm hover:bg-white/10 transition-all">تواصل مع الفريق</a>
            </div>
        </div>
    </section>

    <style>
        .animate-fade-in-up {
            animation: fadeInUp 1s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes bounce-short {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-5px); }
        }
        .animate-bounce-short { animation: bounce-short 3s ease-in-out infinite; }
    </style>
</x-layouts.app>
