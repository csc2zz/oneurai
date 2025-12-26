<div class="min-h-screen bg-slate-50 py-12">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 animate-fade-in">

        <div class="mb-8">
            <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">إطلاق مشروع جديد</h1>
            <p class="text-slate-500 text-sm">اختر نوع التجربة التي تريد تقديمها للاعبين.</p>
        </div>

        <form wire:submit="save" class="space-y-8">

            {{-- 1. اختيار النوع --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                {{-- خيار 1: تحميل عادي --}}
                <label class="cursor-pointer group relative">
                    <input type="radio" wire:model.live="type" value="upload" class="peer sr-only">
                    <div class="h-full bg-white p-6 rounded-2xl border-2 border-slate-200 hover:border-emerald-400 peer-checked:border-emerald-500 peer-checked:bg-emerald-50/20 transition-all text-center flex flex-col items-center justify-center gap-3 shadow-sm">
                        <div class="w-12 h-12 bg-slate-100 rounded-full flex items-center justify-center text-slate-500 peer-checked:bg-emerald-500 peer-checked:text-white transition">
                            <i class="fa-solid fa-download text-xl"></i>
                        </div>
                        <div>
                            <span class="block font-bold text-slate-900 text-sm">لعبة للتحميل</span>
                            <span class="block text-xs text-slate-400 mt-1">ملفات EXE, DMG, APK</span>
                        </div>
                    </div>
                    <div class="absolute top-3 right-3 opacity-0 peer-checked:opacity-100 transition text-emerald-500"><i class="fa-solid fa-circle-check"></i></div>
                </label>

                {{-- خيار 2: محرك ألعاب (ويب) --}}
                <label class="cursor-pointer group relative">
                    <input type="radio" wire:model.live="type" value="html5" class="peer sr-only">
                    <div class="h-full bg-white p-6 rounded-2xl border-2 border-slate-200 hover:border-indigo-400 peer-checked:border-indigo-500 peer-checked:bg-indigo-50/20 transition-all text-center flex flex-col items-center justify-center gap-3 shadow-sm">
                        <div class="w-12 h-12 bg-slate-100 rounded-full flex items-center justify-center text-slate-500 peer-checked:bg-indigo-500 peer-checked:text-white transition">
                            <i class="fa-brands fa-html5 text-2xl"></i>
                        </div>
                        <div>
                            <span class="block font-bold text-slate-900 text-sm">لعبة متصفح</span>
                            <span class="block text-xs text-slate-400 mt-1">WebGL (ZIP)</span>
                        </div>
                    </div>
                    <div class="absolute top-3 right-3 opacity-0 peer-checked:opacity-100 transition text-indigo-500"><i class="fa-solid fa-circle-check"></i></div>
                </label>

                {{-- خيار 3: مسابقة --}}
                <label class="cursor-pointer group relative">
                    <input type="radio" wire:model.live="type" value="quiz" class="peer sr-only">
                    <div class="h-full bg-white p-6 rounded-2xl border-2 border-slate-200 hover:border-amber-400 peer-checked:border-amber-500 peer-checked:bg-amber-50/20 transition-all text-center flex flex-col items-center justify-center gap-3 shadow-sm">
                        <div class="w-12 h-12 bg-slate-100 rounded-full flex items-center justify-center text-slate-500 peer-checked:bg-amber-500 peer-checked:text-white transition">
                            <i class="fa-solid fa-list-check text-xl"></i>
                        </div>
                        <div>
                            <span class="block font-bold text-slate-900 text-sm">مسابقة تفاعلية</span>
                            <span class="block text-xs text-slate-400 mt-1">أسئلة وأجوبة (Quiz)</span>
                        </div>
                    </div>
                    <div class="absolute top-3 right-3 opacity-0 peer-checked:opacity-100 transition text-amber-500"><i class="fa-solid fa-circle-check"></i></div>
                </label>
            </div>

            {{-- 2. المعلومات الأساسية --}}
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-8">
                <div class="space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">العنوان</label>
                            <input wire:model.live.debounce.500ms="title" wire:keyup="generateSlug" type="text" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm font-bold focus:border-slate-400 outline-none transition">
                            @error('title') <span class="text-red-500 text-xs font-bold mt-1 block">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Slug</label>
                            <input wire:model="slug" type="text" dir="ltr" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm font-mono focus:border-slate-400 outline-none transition">
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">الوصف</label>
                        <textarea wire:model="description" rows="3" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:border-slate-400 outline-none resize-none"></textarea>
                    </div>
                </div>
            </div>

            {{-- 3. المحتوى المتغير (Dynamic Content) --}}

            {{-- A. حالة التحميل العادي --}}
            @if($type === 'upload')
                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-8 animate-fade-in">
                    <h3 class="font-bold text-slate-900 mb-4 flex items-center gap-2">
                        <i class="fa-solid fa-download text-emerald-500"></i> ملفات اللعبة (للتحميل)
                    </h3>
                    
                    <div class="mb-6">
                        <label class="flex flex-col items-center justify-center w-full h-32 border-2 border-dashed border-slate-300 rounded-xl cursor-pointer bg-slate-50 hover:bg-emerald-50/30 hover:border-emerald-400 transition">
                            <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                <i class="fa-solid fa-file-zipper text-2xl text-slate-400 mb-2"></i>
                                <p class="text-sm text-slate-500">ارفع ملف EXE, APK أو ZIP</p>
                                @if($game_file) <p class="text-emerald-600 font-bold text-xs mt-1">{{ $game_file->getClientOriginalName() }}</p> @endif
                            </div>
                            <input wire:model="game_file" type="file" class="hidden" accept=".zip,.rar,.exe,.apk" />
                        </label>
                        @error('game_file') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-3">أنظمة التشغيل المدعومة</label>
                        <div class="flex flex-wrap gap-3">
                            @foreach(['windows' => 'Windows', 'mac' => 'Mac', 'android' => 'Android', 'ios' => 'iOS'] as $key => $label)
                                <label class="cursor-pointer">
                                    <input type="checkbox" wire:model="platforms" value="{{ $key }}" class="peer sr-only">
                                    <span class="px-4 py-2 rounded-lg bg-slate-100 text-slate-500 text-sm font-bold border border-transparent peer-checked:bg-slate-800 peer-checked:text-white transition select-none">
                                        {{ $label }}
                                    </span>
                                </label>
                            @endforeach
                        </div>
                        @error('platforms') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>
                </div>
            @endif

            {{-- B. حالة محرك الألعاب (ويب) --}}
            @if($type === 'html5')
                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-8 animate-fade-in relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-20 h-20 bg-indigo-50 rounded-bl-full -mr-10 -mt-10"></div>
                    
                    <h3 class="font-bold text-slate-900 mb-2 flex items-center gap-2">
                        <i class="fa-brands fa-html5 text-indigo-500"></i> ملفات اللعبة (للمتصفح)
                    </h3>
                    <p class="text-sm text-slate-500 mb-6 max-w-2xl">
                        ارفع ملف <b>ZIP</b> يحتوي على ملف <b>index.html</b> في المجلد الرئيسي.
                    </p>

                    <div class="border-2 border-dashed border-indigo-200 bg-indigo-50/30 rounded-xl p-8 text-center hover:bg-indigo-50 hover:border-indigo-400 transition cursor-pointer relative">
                        <input wire:model="game_file" type="file" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" accept=".zip">
                        <i class="fa-solid fa-cube text-3xl text-indigo-300 mb-3"></i>
                        <p class="text-sm font-bold text-slate-700">اضغط لرفع ملف Build (ZIP فقط)</p>
                        @if($game_file) <p class="text-indigo-600 font-bold text-xs mt-2">{{ $game_file->getClientOriginalName() }}</p> @endif
                    </div>
                    @error('game_file') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>
            @endif

            {{-- C. حالة المسابقة --}}
            @if($type === 'quiz')
                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-8 animate-fade-in">
                    
                    {{-- 1. إعدادات الوقت (المؤقت) --}}
                    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8 bg-amber-50/50 p-4 rounded-xl border border-amber-100">
                        <div>
                            <h3 class="font-bold text-slate-900 flex items-center gap-2">
                                <i class="fa-solid fa-stopwatch text-amber-500"></i> إعدادات الوقت
                            </h3>
                            <p class="text-xs text-slate-500 mt-1">حدد المدة الزمنية المتاحة للإجابة على كل سؤال.</p>
                        </div>
                        
                        <div class="flex items-center gap-3">
                            <label class="text-sm font-bold text-amber-800">الثواني:</label>
                            <div class="relative">
                                <input wire:model="time_limit" type="number" min="0" max="300" class="w-24 bg-white border border-amber-200 rounded-lg py-2 text-center font-bold text-lg focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20 outline-none transition">
                                <div class="absolute right-0 top-0 h-full flex items-center pr-2 pointer-events-none">
                                    <i class="fa-solid fa-clock text-amber-300 text-xs"></i>
                                </div>
                            </div>
                            <span class="text-xs font-bold text-amber-600 bg-amber-100 px-2 py-1 rounded">0 = مفتوح</span>
                        </div>
                    </div>

                    {{-- 2. الهيدر وزر الإضافة --}}
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="font-bold text-slate-900 flex items-center gap-2">
                            <i class="fa-solid fa-clipboard-question text-amber-500"></i> الأسئلة والأجوبة
                        </h3>
                        <button type="button" wire:click="addQuestion" class="text-xs bg-slate-100 text-slate-700 px-3 py-1.5 rounded-lg font-bold hover:bg-slate-200 transition">
                            + سؤال يدوي
                        </button>
                    </div>

                    {{-- 3. رفع ملف JSON --}}
                    <div class="mb-8 p-4 bg-amber-50 border border-amber-200 rounded-xl flex items-center justify-between gap-4">
                        <div class="flex-1">
                            <h4 class="text-sm font-bold text-amber-800 mb-1">استيراد الأسئلة (JSON)</h4>
                            <p class="text-xs text-amber-700/70">ارفع ملف JSON يحتوي على الأسئلة لتعبئتها تلقائياً.</p>
                            @if (session()->has('success_file'))
                                <div class="mt-2 text-xs font-bold text-emerald-600">{{ session('success_file') }}</div>
                            @endif
                            @error('quiz_file') <span class="text-red-500 text-xs font-bold block mt-1">{{ $message }}</span> @enderror
                        </div>
                        <label class="cursor-pointer bg-white text-amber-600 border border-amber-200 px-4 py-2 rounded-lg text-xs font-bold hover:bg-amber-100 transition shadow-sm flex items-center gap-2">
                            <i class="fa-solid fa-file-import"></i>
                            <span wire:loading.remove wire:target="quiz_file">اختر الملف</span>
                            <span wire:loading wire:target="quiz_file">جاري المعالجة...</span>
                            <input type="file" wire:model="quiz_file" class="hidden" accept=".json">
                        </label>
                    </div>

                    {{-- 4. قائمة الأسئلة --}}
                    <div class="space-y-4">
                        @foreach($questions as $index => $question)
                            <div class="bg-slate-50 border border-slate-200 p-4 rounded-xl relative group" wire:key="q-{{ $index }}">
                                <button type="button" wire:click="removeQuestion({{ $index }})" class="absolute top-2 left-2 text-slate-300 hover:text-red-500"><i class="fa-solid fa-xmark"></i></button>
                                
                                <input type="text" wire:model="questions.{{ $index }}.question" placeholder="نص السؤال..." class="w-full bg-transparent border-b border-slate-200 pb-2 mb-3 text-sm font-bold focus:border-amber-500 outline-none">
                                
                                <div class="grid grid-cols-2 gap-2">
                                    @foreach($question['options'] as $optIndex => $option)
                                        <div class="flex items-center gap-2">
                                            <input type="radio" wire:model="questions.{{ $index }}.correct" value="{{ $optIndex }}" class="text-amber-500 focus:ring-amber-500">
                                            <input type="text" wire:model="questions.{{ $index }}.options.{{ $optIndex }}" placeholder="خيار {{ $optIndex+1 }}" class="flex-1 bg-white border border-slate-200 rounded-lg px-2 py-1 text-xs">
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                    @error('questions') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>
            @endif

            {{-- 4. الصور والزر النهائي --}}
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 flex flex-col md:flex-row items-center gap-6">
                <div class="flex-1 w-full">
                    <label class="block text-sm font-bold text-slate-700 mb-2">الغلاف (Thumbnail)</label>
                    <input type="file" wire:model="thumbnail" class="block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-slate-100 file:text-slate-700 hover:file:bg-slate-200"/>
                    @error('thumbnail') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>
                
                <button type="submit" class="w-full md:w-auto bg-slate-900 hover:bg-emerald-600 text-white px-8 py-3 rounded-xl text-sm font-bold transition shadow-lg whitespace-nowrap">
                    <span wire:loading.remove>نشر المشروع</span>
                    <span wire:loading>جاري الرفع...</span>
                </button>
            </div>

        </form>
    </div>
</div>