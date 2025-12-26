<div class="min-h-screen bg-slate-50 pb-12" dir="rtl">
    
    {{-- ================= رأس الصفحة (Hero Section) ================= --}}
    <div class="bg-slate-900 text-white relative overflow-hidden">
        {{-- خلفية ضبابية ديناميكية --}}
        @if($game->thumbnail)
            <div class="absolute inset-0 opacity-20 bg-center bg-cover blur-2xl scale-110" 
                 style="background-image: url('{{ asset('storage/' . $game->thumbnail) }}')"></div>
        @endif
        <div class="absolute inset-0 bg-gradient-to-t from-slate-900 via-slate-900/60 to-transparent"></div>

        <div class="max-w-7xl mt-16 mx-auto px-4 sm:px-6 lg:px-8 py-16 relative z-10 flex flex-col md:flex-row gap-8 items-center md:items-end">
            {{-- صورة الغلاف --}}
            <div class="w-32 h-32 md:w-48 md:h-48 rounded-2xl overflow-hidden border-4 border-slate-800 shadow-2xl shrink-0 bg-slate-800 relative group">
                @if($game->thumbnail)
                    <img src="{{ asset('storage/' . $game->thumbnail) }}" class="w-full h-full object-cover transition duration-500 group-hover:scale-110">
                @else
                    <div class="w-full h-full flex items-center justify-center text-slate-600 text-4xl"><i class="fa-solid fa-gamepad"></i></div>
                @endif
            </div>

            {{-- معلومات اللعبة --}}
            <div class="flex-1 text-center md:text-right">
                <div class="flex items-center justify-center md:justify-start gap-2 mb-3">
                    <span class="px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider flex items-center gap-1
                        {{ $game->type === 'quiz' ? 'bg-amber-500/20 text-amber-300 border border-amber-500/30' : '' }}
                        {{ $game->type === 'html5' ? 'bg-indigo-500/20 text-indigo-300 border border-indigo-500/30' : '' }}
                        {{ $game->type === 'upload' ? 'bg-emerald-500/20 text-emerald-300 border border-emerald-500/30' : '' }}">
                        @if($game->type === 'quiz') <i class="fa-solid fa-brain"></i> مسابقة
                        @elseif($game->type === 'html5') <i class="fa-brands fa-html5"></i> لعبة ويب
                        @else <i class="fa-solid fa-download"></i> تحميل
                        @endif
                    </span>
                    <span class="bg-white/10 px-2 py-1 rounded text-slate-300 text-xs font-mono border border-white/5">v{{ $game->version }}</span>
                </div>
                
                <h1 class="text-3xl md:text-5xl font-extrabold tracking-tight mb-3 drop-shadow-lg">{{ $game->title }}</h1>
                <p class="text-slate-400 text-lg mb-6">
                    تطوير: <span class="text-white font-bold hover:text-emerald-400 transition cursor-pointer"><a href="{{ route('profile.show',  $game->developer->username ) }}">{{ $game->developer->name ?? 'مطور مجهول' }}</a></span>
                </p>
                
                {{-- إحصائيات سريعة --}}
                <div class="flex items-center justify-center md:justify-start gap-6 text-sm text-slate-300 font-medium">
                    <div class="flex items-center gap-2" title="المشاهدات">
                        <i class="fa-solid fa-eye text-emerald-400"></i> {{ number_format($game->views_count) }}
                    </div>
                    <div class="flex items-center gap-2" title="التحميلات/المرات الملعوبة">
                        <i class="fa-solid fa-gamepad text-amber-400"></i> {{ number_format($game->downloads_count) }}
                    </div>
                    <div class="flex items-center gap-2" title="تاريخ النشر">
                        <i class="fa-regular fa-clock text-blue-400"></i> {{ $game->created_at->diffForHumans() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ================= المحتوى الرئيسي ================= --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-8 relative z-20">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            {{-- العمود الأيمن (منطقة اللعب/التحميل) --}}
            <div class="lg:col-span-2 space-y-8">

                {{-- 1. واجهة المسابقة (Quiz Interface) --}}
                @if($game->type === 'quiz')
                    <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-slate-200 min-h-[450px] flex flex-col relative">
                        
                        {{-- A. شاشة البداية --}}
                        @if(!$quizStarted)
                            <div class="flex-1 flex flex-col items-center justify-center p-12 text-center bg-slate-50">
                                <div class="w-24 h-24 bg-amber-100 text-amber-600 rounded-full flex items-center justify-center text-5xl mb-6 shadow-lg shadow-amber-500/20 animate-bounce-slow">
                                    <i class="fa-solid fa-play ml-1"></i>
                                </div>
                                <h2 class="text-3xl font-extrabold text-slate-900 mb-2">جاهز للتحدي؟</h2>
                                <div class="flex gap-4 text-sm text-slate-500 mb-8">
                                    <span class="flex items-center gap-1"><i class="fa-solid fa-list-ol text-amber-500"></i> {{ count($game->quiz_data ?? []) }} سؤال</span>
                                    @if($game->time_limit > 0)
                                        <span class="flex items-center gap-1"><i class="fa-solid fa-stopwatch text-red-500"></i> {{ $game->time_limit }} ثانية/سؤال</span>
                                    @endif
                                </div>
                                <button wire:click="startQuiz" class="bg-slate-900 hover:bg-emerald-600 text-white px-10 py-4 rounded-xl font-bold text-lg shadow-xl hover:shadow-emerald-500/30 transition transform hover:-translate-y-1 active:scale-95">
                                    ابدأ المسابقة الآن
                                </button>
                            </div>

                        {{-- B. شاشة النتائج --}}
                        @elseif($quizFinished)
                            <div class="flex-1 flex flex-col items-center justify-center p-12 text-center bg-slate-50 animate-fade-in">
                                <div class="relative mb-6">
                                    <div class="w-28 h-28 rounded-full flex items-center justify-center text-6xl shadow-xl border-4 border-white
                                        {{ $score >= count($game->quiz_data)/2 ? 'bg-emerald-500 text-white' : 'bg-red-500 text-white' }}">
                                        @if($score >= count($game->quiz_data)/2) 🏆 @else 😢 @endif
                                    </div>
                                    @if($score >= count($game->quiz_data)/2)
                                        <div class="absolute -top-2 -right-2 text-4xl animate-bounce">✨</div>
                                    @endif
                                </div>
                                
                                <h2 class="text-3xl font-extrabold text-slate-900 mb-2">
                                    {{ $score >= count($game->quiz_data)/2 ? 'أداء رائع!' : 'حظاً أوفر!' }}
                                </h2>
                                <p class="text-lg text-slate-600 mb-8">
                                    لقد أجبت على <span class="font-black {{ $score >= count($game->quiz_data)/2 ? 'text-emerald-600' : 'text-red-600' }}">{{ $score }}</span> من أصل {{ count($game->quiz_data) }} أسئلة بشكل صحيح.
                                </p>
                                
                                <div class="flex gap-4">
                                    <button wire:click="restartQuiz" class="bg-slate-900 hover:bg-slate-800 text-white px-6 py-3 rounded-xl font-bold transition shadow-lg flex items-center gap-2">
                                        <i class="fa-solid fa-rotate-right"></i> إعادة المحاولة
                                    </button>
                                    <a href="{{ route('games') }}" class="px-6 py-3 rounded-xl font-bold text-slate-600 bg-white border border-slate-200 hover:bg-slate-50 transition shadow-sm">
                                        خروج
                                    </a>
                                </div>
                            </div>

                        {{-- C. شاشة الأسئلة (مع العداد المصلح) --}}
                        @else
                            {{-- wire:key مهم جداً هنا لإجبار Alpine على إعادة التهيئة عند كل سؤال --}}
                            <div class="p-8 relative h-full flex flex-col"
                                 wire:key="question-box-{{ $currentQuestionIndex }}"
                                 x-data="{ 
                                    timeLeft: {{ $game->time_limit }}, 
                                    limit: {{ $game->time_limit }},
                                    timerInterval: null,
                                    timerWidth: 100,
                                    
                                    startTimer() {
                                        if (this.timerInterval) clearInterval(this.timerInterval);
                                        this.timeLeft = this.limit;
                                        this.timerWidth = 100;
                                        
                                        if (this.limit > 0) {
                                            this.timerInterval = setInterval(() => {
                                                if (this.timeLeft > 0) {
                                                    this.timeLeft--;
                                                    this.timerWidth = (this.timeLeft / this.limit) * 100;
                                                } else {
                                                    clearInterval(this.timerInterval);
                                                    $wire.timeIsUp(); 
                                                }
                                            }, 1000);
                                        }
                                    }
                                 }"
                                 x-init="startTimer()" 
                                 x-on:click="$wire.selectedAnswer !== null ? clearInterval(timerInterval) : ''"
                            >
                                {{-- شريط الوقت --}}
                                @if($game->time_limit > 0)
                                    <div class="mb-8">
                                        <div class="flex justify-between items-end mb-2">
                                            <span class="text-xs font-bold text-slate-400 flex items-center gap-1">
                                                <i class="fa-regular fa-clock"></i> الوقت المتبقي
                                            </span>
                                            <div class="text-xl font-black font-mono tabular-nums tracking-widest transition-colors duration-300" 
                                                 :class="timeLeft <= 5 ? 'text-red-500 animate-pulse' : 'text-slate-700'"
                                                 x-text="timeLeft < 10 ? '0' + timeLeft : timeLeft">
                                                 {{ $game->time_limit }}
                                            </div>
                                        </div>
                                        <div class="w-full bg-slate-100 rounded-full h-3 overflow-hidden shadow-inner dir-ltr">
                                            <div class="h-full rounded-full transition-all duration-1000 ease-linear shadow-sm relative overflow-hidden"
                                                 :class="{
                                                    'bg-emerald-500': timeLeft > 10,
                                                    'bg-amber-500': timeLeft <= 10 && timeLeft > 5,
                                                    'bg-red-500': timeLeft <= 5
                                                 }"
                                                 :style="'width: ' + timerWidth + '%'">
                                                 <div class="absolute inset-0 bg-white/20 animate-[shimmer_2s_infinite]"></div>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                {{-- تفاصيل السؤال --}}
                                <div class="flex justify-between items-center text-xs font-bold text-slate-400 mb-4">
                                    <span class="bg-slate-100 px-3 py-1 rounded-full text-slate-600">
                                        سؤال <span class="text-slate-900">{{ $currentQuestionIndex + 1 }}</span> / {{ count($game->quiz_data) }}
                                    </span>
                                    <span class="bg-amber-50 text-amber-600 px-3 py-1 rounded-full border border-amber-100 flex items-center gap-1">
                                        <i class="fa-solid fa-gem"></i> {{ $score }}
                                    </span>
                                </div>

                                {{-- نص السؤال --}}
                                <h3 class="text-xl md:text-2xl font-bold text-slate-900 mb-8 leading-relaxed">
                                    {{ $game->quiz_data[$currentQuestionIndex]['question'] }}
                                </h3>

                                {{-- الخيارات --}}
                                <div class="grid gap-3 flex-1">
                                    @foreach($game->quiz_data[$currentQuestionIndex]['options'] as $idx => $option)
                                        <button 
                                            @click="$wire.selectAnswer({{ $idx }}, timeLeft)"
                                            @disabled($selectedAnswer !== null)
                                            class="w-full text-right px-6 py-4 rounded-xl border-2 font-medium transition-all duration-200 relative group flex items-center
                                            {{ $selectedAnswer === null 
                                                ? 'border-slate-100 bg-white hover:border-amber-400 hover:bg-amber-50 hover:shadow-md' 
                                                : '' }}
                                            {{ $selectedAnswer !== null && $idx == $game->quiz_data[$currentQuestionIndex]['correct']
                                                ? 'border-emerald-500 bg-emerald-50 text-emerald-700 shadow-md ring-2 ring-emerald-200' 
                                                : '' }}
                                            {{ $selectedAnswer === $idx && $idx != $game->quiz_data[$currentQuestionIndex]['correct']
                                                ? 'border-red-500 bg-red-50 text-red-700 shadow-md ring-2 ring-red-200' 
                                                : '' }}
                                            {{ $selectedAnswer !== null && $idx != $selectedAnswer && $idx != $game->quiz_data[$currentQuestionIndex]['correct']
                                                ? 'opacity-40 border-slate-100 bg-slate-50 grayscale'
                                                : '' }}
                                            ">
                                            
                                            <span class="inline-flex items-center justify-center w-8 h-8 ml-4 text-sm font-bold rounded-full border shrink-0
                                                {{ $selectedAnswer === null ? 'border-slate-200 bg-slate-50 text-slate-500 group-hover:border-amber-400 group-hover:text-amber-600' : 'border-current bg-white/50' }}">
                                                {{ ['أ', 'ب', 'ج', 'د'][$idx] ?? $loop->iteration }}
                                            </span>
                                            
                                            <span class="text-lg">{{ $option }}</span>
                                            
                                            {{-- أيقونات النتيجة --}}
                                            @if($selectedAnswer !== null)
                                                <div class="mr-auto">
                                                    @if($idx == $game->quiz_data[$currentQuestionIndex]['correct'])
                                                        <i class="fa-solid fa-check-circle text-emerald-500 text-2xl animate-bounce-short"></i>
                                                    @elseif($selectedAnswer === $idx)
                                                        <i class="fa-solid fa-circle-xmark text-red-500 text-2xl animate-shake"></i>
                                                    @endif
                                                </div>
                                            @endif
                                        </button>
                                    @endforeach
                                </div>

                                {{-- زر التالي --}}
                                @if($selectedAnswer !== null)
                                    <div class="mt-8 flex justify-end animate-fade-in-up">
                                        <button wire:click="nextQuestion" class="bg-slate-900 text-white px-8 py-3 rounded-xl font-bold hover:bg-emerald-600 transition shadow-lg flex items-center gap-2 transform hover:-translate-y-1">
                                            <span>{{ $currentQuestionIndex + 1 == count($game->quiz_data) ? 'عرض النتائج' : 'السؤال التالي' }}</span>
                                            <i class="fa-solid fa-arrow-left"></i>
                                        </button>
                                    </div>
                                @endif
                            </div>
                        @endif
                    </div>
                
                {{-- 2. واجهة التحميل (Download) --}}
                @elseif($game->type === 'upload')
                    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-8 flex flex-col items-center text-center">
                        <div class="w-24 h-24 bg-emerald-50 text-emerald-600 rounded-full flex items-center justify-center text-4xl mb-6 animate-pulse-slow">
                            <i class="fa-solid fa-cloud-arrow-down"></i>
                        </div>
                        <h2 class="text-2xl font-bold text-slate-900 mb-2">جاهز للتحميل؟</h2>
                        <p class="text-slate-500 mb-8 max-w-md">هذه اللعبة متوفرة للتحميل المباشر. تأكد من متطلبات التشغيل أدناه.</p>
                        
                        <div class="flex flex-wrap justify-center gap-3 mb-8">
                            @foreach($game->platforms ?? [] as $platform)
                                <span class="bg-slate-100 text-slate-600 px-4 py-2 rounded-xl text-sm font-bold flex items-center gap-2 border border-slate-200">
                                    @if($platform == 'windows') <i class="fa-brands fa-windows text-blue-500"></i>
                                    @elseif($platform == 'mac') <i class="fa-brands fa-apple text-slate-800"></i>
                                    @elseif($platform == 'android') <i class="fa-brands fa-android text-green-500"></i>
                                    @else <i class="fa-solid fa-desktop text-slate-500"></i>
                                    @endif
                                    {{ ucfirst($platform) }}
                                </span>
                            @endforeach
                        </div>

                        <button wire:click="downloadGame" class="w-full max-w-sm bg-emerald-600 hover:bg-emerald-700 text-white px-8 py-4 rounded-xl font-bold text-lg shadow-xl shadow-emerald-500/20 transition transform hover:-translate-y-1 flex items-center justify-center gap-3">
                            <i class="fa-solid fa-download"></i>
                            <span>تحميل اللعبة الآن</span>
                        </button>
                        
                        @if($game->price > 0)
                            <p class="mt-4 text-sm font-bold text-slate-700">السعر: {{ $game->price }} SAR</p>
                        @else
                            <p class="mt-4 text-sm font-bold text-emerald-600">مجانية بالكامل</p>
                        @endif
                    </div>

               {{-- 3. واجهة الويب (HTML5) - نسخة محسنة للجوال --}}
@elseif($game->type === 'html5')
    {{-- نستخدم Alpine.js للتحكم في وضع ملء الشاشة --}}
    <div x-data="{
            isFullscreen: false,
            toggleFullscreen() {
                let elem = this.$refs.gameContainer;
                if (!document.fullscreenElement) {
                    elem.requestFullscreen().then(() => {
                        this.isFullscreen = true;
                    }).catch(err => {
                        alert(`Error attempting to enable fullscreen: ${err.message}`);
                    });
                } else {
                    document.exitFullscreen().then(() => {
                        this.isFullscreen = false;
                    });
                }
            }
         }"
         class="relative w-full"
    >
        <div x-ref="gameContainer" 
             class="bg-black rounded-2xl shadow-2xl overflow-hidden border border-slate-800 relative group flex items-center justify-center
             {{-- في الجوال ارتفاع ثابت، في الديسكتوب نسبة فيديو --}}
             h-[500px] md:h-auto md:aspect-video w-full transition-all duration-300"
             :class="isFullscreen ? 'h-screen w-screen fixed inset-0 z-50 rounded-none border-0' : ''"
        >
            
            {{-- إذا تم تحميل الرابط --}}
            @if($gameUrl)
                <iframe src="{{ $gameUrl }}" 
                        class="w-full h-full border-0" 
                        allowfullscreen
                        sandbox="allow-scripts allow-same-origin allow-pointer-lock">
                </iframe>

                {{-- زر ملء الشاشة (يظهر عائماً عند اللعب) --}}
                <button @click="toggleFullscreen()" 
                        class="absolute bottom-4 left-4 bg-black/50 hover:bg-emerald-600 text-white p-2 rounded-lg backdrop-blur-sm transition z-20 border border-white/20"
                        title="ملء الشاشة">
                    <i class="fa-solid" :class="isFullscreen ? 'fa-compress' : 'fa-expand'"></i>
                </button>
            
            {{-- شاشة الانتظار (قبل التشغيل) --}}
            @else
                <div class="absolute inset-0 z-10 flex flex-col items-center justify-center bg-slate-900/90 backdrop-blur-sm p-6 text-center">
                    <div class="w-20 h-20 bg-white/10 rounded-full flex items-center justify-center mb-6 animate-pulse">
                        <i class="fa-brands fa-html5 text-5xl text-orange-500"></i>
                    </div>
                    <h3 class="text-xl md:text-2xl font-bold text-white mb-2">لعبة متصفح</h3>
                    <p class="text-slate-400 mb-8 max-w-xs mx-auto">اضغط على الزر أدناه لتشغيل اللعبة.</p>
                    
                    <button wire:click="playGame" class="bg-emerald-600 hover:bg-emerald-500 text-white px-8 py-3 rounded-full font-bold shadow-lg shadow-emerald-500/30 transition transform hover:-translate-y-1 flex items-center gap-3">
                        <span wire:loading.remove wire:target="playGame">
                            <i class="fa-solid fa-play"></i> تشغيل اللعبة
                        </span>
                        <span wire:loading wire:target="playGame" class="flex items-center gap-2">
                            <i class="fa-solid fa-circle-notch fa-spin"></i> جاري التجهيز...
                        </span>
                    </button>
                </div>

                {{-- صورة الخلفية --}}
                @if($game->thumbnail)
                    <div class="absolute inset-0 opacity-40 bg-center bg-cover" 
                         style="background-image: url('{{ asset('storage/' . $game->thumbnail) }}')"></div>
                @endif
            @endif
        </div>
    </div>
@endif

                {{-- قسم الوصف (مشترك) --}}
                <div class="bg-white rounded-2xl border border-slate-200 p-8 shadow-sm relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-24 h-24 bg-slate-50 rounded-bl-full -mr-12 -mt-12 opacity-50"></div>
                    <h3 class="font-bold text-xl text-slate-900 mb-6 flex items-center gap-2 relative z-10">
                        <i class="fa-solid fa-align-right text-slate-400"></i> قصة وتفاصيل اللعبة
                    </h3>
                    <div class="prose prose-slate prose-lg max-w-none text-slate-600 leading-relaxed relative z-10">
                        {{ $game->description }}
                    </div>
                </div>
            </div>

            {{-- العمود الأيسر (معلومات إضافية) --}}
            <div class="space-y-8">
                
                {{-- معرض الصور --}}
                @if(!empty($game->screenshots))
                    <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm">
                        <h3 class="font-bold text-slate-900 mb-4 flex items-center gap-2">
                            <i class="fa-solid fa-images text-slate-400"></i> لقطات الشاشة
                        </h3>
                        <div class="grid grid-cols-2 gap-3">
                            @foreach($game->screenshots as $screen)
                                <div class="aspect-video rounded-lg overflow-hidden border border-slate-100 cursor-pointer hover:opacity-80 transition shadow-sm group">
                                    <img src="{{ asset('storage/' . $screen) }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                {{-- بطاقة المطور --}}
                <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm flex items-center gap-4">
                    {{-- صورة المطور --}}
<div class="w-14 h-14 rounded-full overflow-hidden shadow-inner border border-white bg-slate-100">
    @if(!empty($game->developer->avatar))
        {{-- حالة 1: المطور لديه صورة --}}
        <img src="{{ asset('storage/'.$game->developer->avatar) }}" 
             alt="{{ $game->developer->name }}" 
             class="w-full h-full object-cover">
    @else
        {{-- حالة 2: المطور ليس لديه صورة (نعرض الأحرف) --}}
        <div class="w-full h-full bg-gradient-to-br from-slate-100 to-slate-200 flex items-center justify-center text-slate-500 font-bold text-2xl">
            {{ substr($game->developer->name ?? 'D', 0, 1) }}
        </div>
    @endif
</div>
                    <div>
                        <h4 class="font-bold text-slate-900">عن المطور</h4>
                        <p class="text-slate-500 text-sm mb-1"><a href="{{ route('profile.show',  $game->developer->username ) }}">{{ $game->developer->name ?? 'فاعل خير' }}</a></p>
                        <a href="{{ route('profile.show',  $game->developer->username ) }}" class="text-xs text-emerald-600 font-bold hover:underline">عرض كل الأعمال</a>
                    </div>
                </div>
                @if(in_array($game->type, ['quiz', 'html5']) && count($leaderboard) > 0)
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden animate-fade-in-up">
        <div class="bg-gradient-to-r from-slate-900 to-slate-800 p-4 flex items-center justify-between">
            <h3 class="font-bold text-white flex items-center gap-2">
                <i class="fa-solid fa-trophy text-yellow-400"></i> لوحة المتصدرين
            </h3>
            <span class="text-xs text-slate-300 bg-white/10 px-2 py-1 rounded">أفضل الأبطال</span>
        </div>
        
        <div class="divide-y divide-slate-100">
            @foreach($leaderboard as $index => $rank)
                <div class="p-4 flex items-center gap-4 hover:bg-slate-50 transition relative overflow-hidden group">
                    
                    {{-- الترتيب --}}
                    <div class="w-8 h-8 flex items-center justify-center rounded-full font-black text-sm shrink-0 z-10
                        {{ $index == 0 ? 'bg-yellow-100 text-yellow-600 ring-2 ring-yellow-400' : '' }}
                        {{ $index == 1 ? 'bg-slate-200 text-slate-600 ring-2 ring-slate-400' : '' }}
                        {{ $index == 2 ? 'bg-orange-100 text-orange-700 ring-2 ring-orange-400' : '' }}
                        {{ $index > 2 ? 'bg-slate-50 text-slate-400 font-bold' : '' }}">
                        {{ $index + 1 }}
                    </div>

                    {{-- معلومات اللاعب --}}
                    <div class="flex-1 z-10">
                        <a href="{{ route('profile.show',  $rank->user->username ) }}">
                        <h4 class="font-bold text-slate-900 text-sm truncate max-w-[120px]">
                            {{ $rank->user->name ?? 'مستخدم' }}
                        </h4>
                        </a>
                        @if($rank->user_id == Auth::id())
                            <span class="text-[10px] text-emerald-600 font-bold bg-emerald-50 px-1.5 rounded">أنت</span>
                        @endif
                    </div>

                    {{-- النقاط --}}
                    <div class="text-right z-10">
                        <span class="block font-black text-slate-900 text-lg leading-none">{{ $rank->score }}</span>
                        <span class="text-[10px] text-slate-400 font-bold">نقطة</span>
                    </div>

                    {{-- تأثير خلفية خفيف للمركز الأول --}}
                    @if($index == 0)
                        <div class="absolute inset-0 bg-yellow-50/30 opacity-0 group-hover:opacity-100 transition duration-500"></div>
                        <div class="absolute -top-2 -left-2 text-yellow-200 text-6xl opacity-20 rotate-12"><i class="fa-solid fa-crown"></i></div>
                    @endif
                </div>
            @endforeach
        </div>
        
        @if(!Auth::check())
            <div class="p-3 bg-slate-50 text-center border-t border-slate-100">
                <p class="text-xs text-slate-500">سجل دخولك لتنافس الأبطال!</p>
            </div>
        @endif
    </div>
@endif
            </div>

        </div>
    </div>
    <script>
        window.addEventListener('message', function(event) {
            // التحقق من أن الرسالة هي لتسليم النتيجة
            if (event.data && event.data.type === 'submit_score') {
                console.log('تم استلام النتيجة من اللعبة:', event.data.score);
                
                // استدعاء دالة Livewire
                // @this هو اختصار للوصول للكومبوننت الحالي
                @this.saveHtml5Score(event.data.score);
            }
        });

        // (اختياري) عرض تنبيه صغير عند الحفظ
        document.addEventListener('livewire:initialized', () => {
            @this.on('score-saved', () => {
                // يمكنك إضافة مكتبة توست هنا أو اكتفي بالكونسول
                console.log('Score Saved Successfully!');
            });
        });
    </script>
</div>