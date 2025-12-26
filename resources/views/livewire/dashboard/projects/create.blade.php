<div class="flex-1 overflow-y-auto bg-slate-50 min-h-screen">
    <div class="max-w-4xl mx-auto px-6 py-12 animate-fade-in">

        {{-- Header --}}
        <div class="mb-10">
            <div class="flex items-center gap-4 mb-2">
                <div class="w-12 h-12 bg-slate-900 rounded-2xl flex items-center justify-center shadow-lg shadow-slate-900/20">
                    <i class="fa-solid fa-plus text-white text-xl"></i>
                </div>
                <div>
                    <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">إطلاق مشروع جديد</h1>
                    <p class="text-slate-500 text-sm">أنشئ مستودعاً جديداً للكود، النماذج، أو البيانات.</p>
                </div>
            </div>
        </div>

        <form wire:submit="create" class="space-y-6">

            {{-- 1. العنوان والمسار (الأساسيات) --}}
{{-- 1. المعلومات الأساسية (العنوان والرابط) --}}
<div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-8 relative overflow-hidden">
    {{-- زخرفة خلفية بسيطة --}}
    <div class="absolute top-0 left-0 w-32 h-32 bg-emerald-50 rounded-br-full -ml-10 -mt-10 opacity-50 pointer-events-none"></div>

    <div class="space-y-6 relative z-10">

        {{-- حقل عنوان المشروع (Title) --}}
        <div>
            <label class="block text-sm font-bold text-slate-700 mb-2">اسم المشروع (Title)</label>
            <div class="relative group">
                <input
                    wire:model.live.debounce.300ms="title"
                    {{-- دالة لتحديث الرابط تلقائياً عند الكتابة --}}
                    wire:keyup="generateSlug"
                    type="text"
                    placeholder="مثال: نظام إدارة المبيعات الذكي"
                    class="w-full h-12 bg-white border border-slate-200 rounded-xl px-4 pl-10 text-sm font-bold text-slate-800 outline-none transition focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10 placeholder:font-normal placeholder:text-slate-300"
                >
                <div class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-emerald-500 transition">
                    <i class="fa-solid fa-heading"></i>
                </div>
            </div>
            @error('title') <span class="text-red-500 text-xs font-bold mt-1 block">{{ $message }}</span> @enderror
        </div>

        {{-- حقل الرابط (Slug) --}}
        <div>
            <label class="block text-sm font-bold text-slate-700 mb-2">رابط المشروع (Slug)</label>
            <div class="flex flex-col md:flex-row items-stretch gap-2">
                {{-- النطاق واسم المستخدم --}}
                <div class="bg-slate-50 border border-slate-200 text-slate-500 font-bold text-sm rounded-xl flex items-center px-4 py-3 select-none whitespace-nowrap" dir="ltr">
                    oneurai.com/{{ Auth::user()->username }}/
                </div>

                {{-- حقل الـ Slug --}}
                <div class="flex-1 relative">
                    <input
                        wire:model.live.debounce.300ms="slug"
                        type="text"
                        dir="ltr"
                        class="w-full h-full bg-slate-50 border rounded-xl px-4 text-sm font-mono font-medium text-slate-600 outline-none transition focus:bg-white focus:border-emerald-500 focus:text-emerald-600
                        {{ $slug != '' ? ($isAvailable ? 'border-emerald-500' : 'border-red-500') : 'border-slate-200' }}"
                    >

                    {{-- أيقونة الحالة --}}
                    @if($slug != '')
                        <div class="absolute right-4 top-1/2 -translate-y-1/2">
                            @if($isAvailable)
                                <i class="fa-solid fa-circle-check text-emerald-500 animate-pulse-once"></i>
                            @else
                                <i class="fa-solid fa-circle-xmark text-red-500 animate-pulse-once"></i>
                            @endif
                        </div>
                    @endif
                </div>
            </div>

            {{-- رسالة توضيحية --}}
            <div class="mt-2 text-xs text-slate-400 flex items-center gap-1">
                <i class="fa-solid fa-circle-info"></i>
                <span>يستخدم الـ Slug في رابط المشروع (URL) ويجب أن يكون باللغة الإنجليزية وبدون مسافات.</span>
            </div>
            @error('slug') <span class="text-red-500 text-xs font-bold mt-1 block">{{ $message }}</span> @enderror
        </div>

    </div>
</div>

            {{-- 2. تفاصيل المشروع (القسم الجديد المكمل للناقص) --}}
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-8">
                <h3 class="text-slate-800 font-bold text-lg mb-6 flex items-center gap-2">
                    <i class="fa-regular fa-file-lines text-emerald-500"></i> تفاصيل المشروع
                </h3>

                <div class="space-y-6">
                    {{-- الوصف (Description) --}}
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">الوصف المختصر</label>
                        <textarea
                            wire:model="description"
                            rows="3"
                            class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-700 focus:bg-white focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 outline-none transition resize-none"
                            placeholder="اكتب وصفاً مختصراً يشرح هدف المشروع وما يقدمه..."
                        ></textarea>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- الإطار (Framework) --}}
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">الإطار البرمجي (Framework)</label>
                            <div class="relative">
                                <select wire:model="framework" class="w-full appearance-none bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-700 focus:bg-white focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 outline-none transition cursor-pointer">
                                    <option value="">غير محدد</option>
                                    <option value="Laravel">Laravel</option>
                                    <option value="React">React</option>
                                    <option value="Vue">Vue.js</option>
                                    <option value="Python">Python/Django</option>
                                    <option value="Flutter">Flutter</option>
                                    <option value="Nextjs">Next.js</option>
                                </select>
                                <div class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none">
                                    <i class="fa-solid fa-chevron-down text-xs"></i>
                                </div>
                            </div>
                        </div>

                        {{-- الرخصة (License) --}}
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">الرخصة (License)</label>
                            <div class="relative">
                                <select wire:model="license" class="w-full appearance-none bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-700 focus:bg-white focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 outline-none transition cursor-pointer">
                                    <option value="">بدون رخصة (No License)</option>
                                    <option value="MIT">MIT License</option>
                                    <option value="Apache-2.0">Apache 2.0</option>
                                    <option value="GPL-3.0">GNU GPL v3</option>
                                    <option value="BSD-3-Clause">BSD 3-Clause</option>
                                </select>
                                <div class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none">
                                    <i class="fa-solid fa-scale-balanced text-xs"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- الكلمات المفتاحية (Tags) --}}
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">الوسوم (Tags)</label>
                        <div class="relative">
                            <div class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400">
                                <i class="fa-solid fa-hashtag"></i>
                            </div>
                            <input
                                wire:model="tags"
                                type="text"
                                class="w-full bg-slate-50 border border-slate-200 rounded-xl pr-10 pl-4 py-3 text-sm text-slate-700 focus:bg-white focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 outline-none transition"
                                placeholder="مثال: ai, web-app, dashboard (افصل بفاصلة)"
                            >
                        </div>
                        <p class="text-xs text-slate-400 mt-2">تساعد الوسوم في تحسين ظهور مشروعك في نتائج البحث.</p>
                    </div>
                </div>
            </div>

            {{-- 3. نوع المشروع (Interactive Cards) --}}
            <div>
                <label class="block text-sm font-bold text-slate-700 mb-4 px-1">نوع المشروع</label>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">

                    {{-- Repo --}}
                    <label class="cursor-pointer group">
                        <input type="radio" wire:model.live="type" value="repo" class="peer sr-only">
                        <div class="h-full p-5 rounded-2xl border-2 border-slate-200 bg-white hover:border-emerald-400 peer-checked:border-emerald-500 peer-checked:bg-emerald-50/50 peer-checked:shadow-sm transition-all duration-200 text-center relative overflow-hidden">
                            <div class="w-10 h-10 mx-auto rounded-full bg-blue-50 text-blue-600 flex items-center justify-center mb-3 peer-checked:bg-emerald-100 peer-checked:text-emerald-600 transition">
                                <i class="fa-solid fa-code text-lg"></i>
                            </div>
                            <span class="block font-bold text-slate-800 text-sm">برمجي (Code)</span>
                            <span class="text-[10px] text-slate-400 mt-1 block group-hover:text-emerald-600/70 transition">مشاريع Laravel, Python, JS</span>
                        </div>
                    </label>

                    {{-- Model --}}
                    <label class="cursor-pointer group">
                        <input type="radio" wire:model.live="type" value="model" class="peer sr-only">
                        <div class="h-full p-5 rounded-2xl border-2 border-slate-200 bg-white hover:border-emerald-400 peer-checked:border-emerald-500 peer-checked:bg-emerald-50/50 peer-checked:shadow-sm transition-all duration-200 text-center">
                            <div class="w-10 h-10 mx-auto rounded-full bg-purple-50 text-purple-600 flex items-center justify-center mb-3 peer-checked:bg-emerald-100 peer-checked:text-emerald-600 transition">
                                <i class="fa-solid fa-brain text-lg"></i>
                            </div>
                            <span class="block font-bold text-slate-800 text-sm">نموذج (Model)</span>
                            <span class="text-[10px] text-slate-400 mt-1 block group-hover:text-emerald-600/70 transition">أوزان الذكاء الاصطناعي</span>
                        </div>
                    </label>

                    {{-- Dataset --}}
                    <label class="cursor-pointer group">
                        <input type="radio" wire:model.live="type" value="dataset" class="peer sr-only">
                        <div class="h-full p-5 rounded-2xl border-2 border-slate-200 bg-white hover:border-emerald-400 peer-checked:border-emerald-500 peer-checked:bg-emerald-50/50 peer-checked:shadow-sm transition-all duration-200 text-center">
                            <div class="w-10 h-10 mx-auto rounded-full bg-amber-50 text-amber-600 flex items-center justify-center mb-3 peer-checked:bg-emerald-100 peer-checked:text-emerald-600 transition">
                                <i class="fa-solid fa-database text-lg"></i>
                            </div>
                            <span class="block font-bold text-slate-800 text-sm">بيانات (Dataset)</span>
                            <span class="text-[10px] text-slate-400 mt-1 block group-hover:text-emerald-600/70 transition">مجموعات بيانات للتدريب</span>
                        </div>
                    </label>
                </div>
            </div>

            {{-- 4. الخصوصية والتهيئة --}}
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

                {{-- الخصوصية --}}
                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
                    <label class="block text-sm font-bold text-slate-700 mb-4">الخصوصية</label>
                    <div class="space-y-3">
                        <label class="relative block cursor-pointer group">
                            <input type="radio" wire:model="visibility" value="public" class="peer sr-only">
                            <div class="p-3 rounded-xl border border-slate-200 hover:border-emerald-400 transition flex items-center gap-3 peer-checked:border-emerald-600 peer-checked:ring-1 peer-checked:ring-emerald-600 peer-checked:bg-emerald-50/10">
                                <div class="text-slate-400 peer-checked:text-emerald-600">
                                    <i class="fa-solid fa-globe text-lg"></i>
                                </div>
                                <div class="flex-1">
                                    <div class="font-bold text-slate-900 text-sm">عام (Public)</div>
                                    <div class="text-[11px] text-slate-500">متاح للجميع للاطلاع والاستنساخ.</div>
                                </div>
                                <div class="w-4 h-4 rounded-full border border-slate-300 peer-checked:border-emerald-600 peer-checked:bg-emerald-600 flex items-center justify-center">
                                    <div class="w-1.5 h-1.5 bg-white rounded-full opacity-0 peer-checked:opacity-100"></div>
                                </div>
                            </div>
                        </label>

                        <label class="relative block cursor-pointer group">
                            <input type="radio" wire:model="visibility" value="private" class="peer sr-only">
                            <div class="p-3 rounded-xl border border-slate-200 hover:border-emerald-400 transition flex items-center gap-3 peer-checked:border-emerald-600 peer-checked:ring-1 peer-checked:ring-emerald-600 peer-checked:bg-emerald-50/10">
                                <div class="text-slate-400 peer-checked:text-emerald-600">
                                    <i class="fa-solid fa-lock text-lg"></i>
                                </div>
                                <div class="flex-1">
                                    <div class="font-bold text-slate-900 text-sm">خاص (Private)</div>
                                    <div class="text-[11px] text-slate-500">أنت تختار من يمكنه الوصول.</div>
                                </div>
                                <div class="w-4 h-4 rounded-full border border-slate-300 peer-checked:border-emerald-600 peer-checked:bg-emerald-600 flex items-center justify-center">
                                    <div class="w-1.5 h-1.5 bg-white rounded-full opacity-0 peer-checked:opacity-100"></div>
                                </div>
                            </div>
                        </label>
                    </div>
                </div>

                {{-- التهيئة --}}
                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
                    <label class="block text-sm font-bold text-slate-700 mb-4">تهيئة أولية للملفات</label>
                    <div class="space-y-4">
                        <label class="flex items-center justify-between cursor-pointer group">
                            <div class="flex items-center gap-3">
                                <i class="fa-brands fa-readme text-slate-400 text-lg"></i>
                                <span class="text-sm font-medium text-slate-700 group-hover:text-emerald-700 transition">ملف README.md</span>
                            </div>
                            <div class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" wire:model="add_readme" class="sr-only peer">
                                <div class="w-9 h-5 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-emerald-600"></div>
                            </div>
                        </label>

                        <hr class="border-slate-100">

                        <div>
                            <label class="flex items-center justify-between cursor-pointer group mb-2">
                                <div class="flex items-center gap-3">
                                    <i class="fa-brands fa-git-alt text-slate-400 text-lg"></i>
                                    <span class="text-sm font-medium text-slate-700 group-hover:text-emerald-700 transition">ملف .gitignore</span>
                                </div>
                                <div class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" wire:model.live="add_gitignore" class="sr-only peer">
                                    <div class="w-9 h-5 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-emerald-600"></div>
                                </div>
                            </label>

                            @if($add_gitignore)
                                <div class="animate-fade-in-down mt-3 pl-8">
                                    <select wire:model="gitignore_template" class="w-full bg-slate-50 border border-slate-200 text-slate-700 text-sm rounded-lg focus:ring-emerald-500 focus:border-emerald-500 block p-2 outline-none transition">
                                        <option value="" disabled>اختر القالب...</option>
                                        <option value="Laravel">Laravel</option>
                                        <option value="Python">Python</option>
                                        <option value="Node">Node</option>
                                        <option value="Unity">Unity</option>
                                    </select>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            {{-- Footer Actions --}}
            <div class="pt-6 border-t border-slate-200 flex items-center justify-end gap-4">
                <a href="{{ route('dashboard') }}" class="px-6 py-3 rounded-xl text-sm font-bold text-slate-500 hover:bg-slate-100 hover:text-slate-700 transition">
                    إلغاء
                </a>
                <button type="submit"
                        class="bg-slate-900 hover:bg-emerald-600 text-white px-8 py-3 rounded-xl text-sm font-bold transition-all shadow-lg hover:shadow-emerald-500/30 flex items-center gap-2 disabled:opacity-50 disabled:cursor-not-allowed transform active:scale-95"
                        wire:loading.attr="disabled">
                    <span wire:loading.remove>إنشاء المستودع <i class="fa-solid fa-arrow-left mr-1"></i></span>
                    <span wire:loading class="flex items-center gap-2">
                        <i class="fa-solid fa-spinner animate-spin"></i> جاري الإنشاء...
                    </span>
                </button>
            </div>

        </form>
    </div>
</div>
