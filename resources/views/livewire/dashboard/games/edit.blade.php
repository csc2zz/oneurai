<div class="min-h-screen bg-slate-50 py-12">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 animate-fade-in">

        {{-- Header --}}
        <div class="mb-8 flex items-center justify-between">
            <div class="flex items-center gap-4">
                <a href="{{ route('dashboard.games') }}" class="w-10 h-10 rounded-xl bg-white border border-slate-200 flex items-center justify-center text-slate-400 hover:text-emerald-600 hover:border-emerald-200 transition shadow-sm">
                    <i class="fa-solid fa-arrow-right"></i>
                </a>
                <div>
                    <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">تعديل المشروع: {{ $game->title }}</h1>
                    <p class="text-slate-500 text-sm">قم بتحديث البيانات، رفع ملفات جديدة، أو تعديل الأسئلة.</p>
                </div>
            </div>
            
            {{-- زر معاينة (اختياري) --}}
            {{-- <a href="#" target="_blank" class="text-sm font-bold text-emerald-600 hover:underline">معاينة اللعبة <i class="fa-solid fa-external-link-alt text-xs"></i></a> --}}
        </div>

        <form wire:submit="save" class="space-y-8">

            {{-- 1. بطاقة نوع المشروع (Read Only) --}}
            <div class="bg-indigo-50 border border-indigo-100 rounded-2xl p-4 flex items-center gap-4">
                <div class="w-10 h-10 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600">
                    @if($type === 'upload') <i class="fa-solid fa-download"></i>
                    @elseif($type === 'html5') <i class="fa-brands fa-html5"></i>
                    @else <i class="fa-solid fa-list-check"></i>
                    @endif
                </div>
                <div>
                    <h3 class="font-bold text-indigo-900 text-sm">نوع المشروع: 
                        @if($type === 'upload') تحميل (Upload)
                        @elseif($type === 'html5') متصفح (HTML5)
                        @else مسابقة (Quiz)
                        @endif
                    </h3>
                    <p class="text-xs text-indigo-600/80">لا يمكن تغيير نوع المشروع بعد إنشائه.</p>
                </div>
            </div>

            {{-- 2. المعلومات الأساسية --}}
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-8 relative overflow-hidden">
                <div class="space-y-6 relative z-10">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">العنوان</label>
                            <input wire:model.live.debounce.500ms="title" wire:keyup="generateSlug" type="text" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm font-bold focus:border-emerald-500 outline-none transition">
                            @error('title') <span class="text-red-500 text-xs font-bold mt-1 block">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Slug</label>
                            <input wire:model="slug" type="text" dir="ltr" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm font-mono focus:border-emerald-500 outline-none transition">
                            @error('slug') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">الوصف</label>
                            <textarea wire:model="description" rows="4" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:border-emerald-500 outline-none resize-none"></textarea>
                            @error('description') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>
                        
                        <div class="space-y-4">
                             <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2">رقم الإصدار</label>
                                <input wire:model="version" type="text" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:border-emerald-500 outline-none">
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2">السعر (SAR)</label>
                                <input wire:model="price" type="number" step="0.01" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:border-emerald-500 outline-none">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- 3. المحتوى المتغير (Dynamic Content) --}}

            {{-- A. حالة التحميل العادي --}}
            @if($type === 'upload')
                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-8">
                    <h3 class="font-bold text-slate-900 mb-4 flex items-center gap-2">
                        <i class="fa-solid fa-download text-emerald-500"></i> ملفات اللعبة
                    </h3>
                    
                    <div class="mb-6 bg-slate-50 rounded-xl p-4 border border-slate-200">
                        <div class="flex items-center gap-4 mb-4">
                            <div class="w-10 h-10 bg-emerald-100 text-emerald-600 rounded-lg flex items-center justify-center">
                                <i class="fa-solid fa-file-zipper"></i>
                            </div>
                            <div class="flex-1">
                                <h4 class="text-sm font-bold text-slate-900">الملف الحالي</h4>
                                <p class="text-xs text-slate-500 truncate dir-ltr">{{ basename($game->game_file) }}</p>
                            </div>
                            <span class="text-xs bg-emerald-100 text-emerald-700 px-2 py-1 rounded">مرفوع</span>
                        </div>
                        
                        <label class="block text-sm font-bold text-slate-700 mb-2">تحديث الملف (اختياري)</label>
                        <input wire:model="new_game_file" type="file" class="block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-slate-200 file:text-slate-700 hover:file:bg-slate-300 transition" accept=".zip,.rar,.exe,.apk"/>
                        <p class="text-[10px] text-slate-400 mt-1">ارفع ملفاً جديداً فقط إذا أردت استبدال الملف الحالي.</p>
                        @error('new_game_file') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    {{-- Platforms --}}
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-3">أنظمة التشغيل</label>
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
                    </div>
                </div>
            @endif

            {{-- B. حالة محرك الألعاب (ويب) --}}
            @if($type === 'html5')
                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-8">
                    <h3 class="font-bold text-slate-900 mb-2 flex items-center gap-2">
                        <i class="fa-brands fa-html5 text-indigo-500"></i> ملفات اللعبة (Web Build)
                    </h3>
                    
                    <div class="bg-indigo-50/50 border border-indigo-100 p-4 rounded-xl mb-4 flex items-center gap-3">
                         <i class="fa-solid fa-cube text-indigo-400"></i>
                         <div class="text-xs text-indigo-900">
                             الملف الحالي: <span class="font-mono font-bold">{{ basename($game->game_file) }}</span>
                         </div>
                    </div>

                    <label class="block text-sm font-bold text-slate-700 mb-2">رفع تحديث جديد (ZIP)</label>
                    <input wire:model="new_game_file" type="file" class="block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 transition" accept=".zip"/>
                    @error('new_game_file') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>
            @endif

            {{-- C. حالة المسابقة --}}
            @if($type === 'quiz')
                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-8">
                    
                    {{-- 1. إعدادات الوقت (جديد في التعديل) --}}
                    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8 bg-amber-50/50 p-4 rounded-xl border border-amber-100">
                        <div>
                            <h3 class="font-bold text-slate-900 flex items-center gap-2">
                                <i class="fa-solid fa-stopwatch text-amber-500"></i> إعدادات الوقت
                            </h3>
                            <p class="text-xs text-slate-500 mt-1">تعديل المدة الزمنية لكل سؤال.</p>
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
                            <i class="fa-solid fa-clipboard-question text-amber-500"></i> تعديل الأسئلة
                        </h3>
                        <div class="flex gap-2">
                             <button type="button" wire:click="addQuestion" class="text-xs bg-amber-100 text-amber-700 px-3 py-1.5 rounded-lg font-bold hover:bg-amber-200 transition">
                                + سؤال جديد
                            </button>
                        </div>
                    </div>

                    {{-- 3. استيراد ملف JSON (جديد في التعديل) --}}
                    <div class="mb-8 p-4 bg-amber-50 border border-amber-200 rounded-xl flex items-center justify-between gap-4">
                        <div class="flex-1">
                            <h4 class="text-sm font-bold text-amber-800 mb-1">استبدال الأسئلة (JSON)</h4>
                            <p class="text-xs text-amber-700/70">تنبيه: رفع ملف جديد سيستبدل الأسئلة الحالية.</p>
                            @if (session()->has('success_file'))
                                <div class="mt-2 text-xs font-bold text-emerald-600">{{ session('success_file') }}</div>
                            @endif
                            @error('quiz_file') <span class="text-red-500 text-xs font-bold block mt-1">{{ $message }}</span> @enderror
                        </div>
                        <label class="cursor-pointer bg-white text-amber-600 border border-amber-200 px-4 py-2 rounded-lg text-xs font-bold hover:bg-amber-100 transition shadow-sm flex items-center gap-2">
                            <i class="fa-solid fa-file-import"></i>
                            <span wire:loading.remove wire:target="quiz_file">استيراد ملف</span>
                            <span wire:loading wire:target="quiz_file">جاري...</span>
                            <input type="file" wire:model="quiz_file" class="hidden" accept=".json">
                        </label>
                    </div>

                    {{-- 4. الأسئلة --}}
                    <div class="space-y-4">
                        @foreach($quiz_data as $index => $question)
                            <div class="bg-slate-50 border border-slate-200 p-4 rounded-xl relative group" wire:key="q-{{ $index }}">
                                <button type="button" wire:click="removeQuestion({{ $index }})" class="absolute top-2 left-2 text-slate-300 hover:text-red-500"><i class="fa-solid fa-xmark"></i></button>
                                
                                <input type="text" wire:model="quiz_data.{{ $index }}.question" placeholder="نص السؤال..." class="w-full bg-transparent border-b border-slate-200 pb-2 mb-3 text-sm font-bold focus:border-amber-500 outline-none">
                                
                                <div class="grid grid-cols-2 gap-2">
                                    @foreach($question['options'] as $optIndex => $option)
                                        <div class="flex items-center gap-2">
                                            <input type="radio" wire:model="quiz_data.{{ $index }}.correct" value="{{ $optIndex }}" class="text-amber-500 focus:ring-amber-500">
                                            <input type="text" wire:model="quiz_data.{{ $index }}.options.{{ $optIndex }}" placeholder="خيار {{ $optIndex+1 }}" class="flex-1 bg-white border border-slate-200 rounded-lg px-2 py-1 text-xs">
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                    @error('quiz_data') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>
            @endif

            {{-- 4. الصور والزر النهائي --}}
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-6">
                    
                    {{-- Thumbnail --}}
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">الغلاف (Thumbnail)</label>
                        <div class="flex items-start gap-4">
                            <div class="w-24 h-24 rounded-xl overflow-hidden border border-slate-200 shadow-sm shrink-0 bg-slate-50">
                                @if($new_thumbnail)
                                    <img src="{{ $new_thumbnail->temporaryUrl() }}" class="w-full h-full object-cover">
                                @elseif($game->thumbnail)
                                    <img src="{{ Storage::url($game->thumbnail) }}" class="w-full h-full object-cover">
                                @else
                                    <div class="flex items-center justify-center h-full text-slate-300"><i class="fa-regular fa-image"></i></div>
                                @endif
                            </div>
                            <div class="flex-1">
                                <input type="file" wire:model="new_thumbnail" class="block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-slate-100 file:text-slate-700 hover:file:bg-slate-200 transition"/>
                                <p class="text-[10px] text-slate-400 mt-2">اختر صورة جديدة لتغيير الحالية.</p>
                            </div>
                        </div>
                        @error('new_thumbnail') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    {{-- Screenshots --}}
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">لقطات الشاشة (إضافة)</label>
                        <input type="file" wire:model="new_screenshots" multiple class="block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-slate-100 file:text-slate-700 hover:file:bg-slate-200 transition"/>
                        
                        {{-- عرض الصور القديمة --}}
                        @if(!empty($game->screenshots))
                            <div class="flex gap-2 mt-4 overflow-x-auto pb-2">
                                @foreach($game->screenshots as $screen)
                                    <img src="{{ Storage::url($screen) }}" class="h-16 rounded-lg border border-slate-200">
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
                
                <div class="flex justify-end border-t border-slate-100 pt-6">
                    <button type="submit" class="bg-slate-900 hover:bg-emerald-600 text-white px-8 py-3 rounded-xl text-sm font-bold transition shadow-lg flex items-center gap-2">
                        <span wire:loading.remove>حفظ التعديلات</span>
                        <span wire:loading>جاري الحفظ...</span>
                        <i class="fa-solid fa-check"></i>
                    </button>
                </div>
            </div>

        </form>
    </div>
</div>