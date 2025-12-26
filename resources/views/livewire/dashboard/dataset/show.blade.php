<div class="flex h-screen overflow-hidden bg-[#F8FAFC] text-slate-900 font-sans" dir="rtl">

    <main class="flex-1 flex flex-col h-full overflow-hidden relative">

        {{-- خلفية جمالية علوية --}}
        <div class="absolute top-0 left-0 w-full h-80 bg-gradient-to-b from-white to-[#F8FAFC] -z-10"></div>

        {{-- 1. الهيدر (Hero Section) --}}
        <div class="pt-10 pb-6 px-6 lg:px-10 z-10">
            <div class="max-w-7xl mx-auto">
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6 mb-8">
                    <div>
                        {{-- مسار التنقل (Breadcrumbs) --}}
                        <div class="flex items-center gap-2 text-xs font-bold text-slate-400 mb-3 bg-white/60 backdrop-blur-sm w-fit px-3 py-1.5 rounded-full border border-slate-200/50" dir="ltr">
                            <span class="hover:text-emerald-600 transition cursor-pointer">{{ auth()->user()->username }}</span>
                            <i class="fa-solid fa-chevron-right text-[10px] text-slate-300"></i>
                            <span class="text-slate-800">{{ $dataset->title }}</span>
                        </div>

                        {{-- العنوان --}}
                        <div class="flex items-center gap-4">
                            <div class="w-14 h-14 bg-white rounded-2xl shadow-sm border border-slate-100 flex items-center justify-center text-3xl text-emerald-600">
                                <i class="fa-solid fa-database"></i>
                            </div>
                            <div>
                                <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight mb-1">{{ $dataset->title }}</h1>
                                <div class="flex items-center gap-3 text-sm">
                                    @if($dataset->visibility == 'private')
                                        <span class="bg-amber-50 text-amber-700 text-[10px] px-2.5 py-0.5 rounded-lg border border-amber-100 font-bold flex items-center gap-1">
                                            <i class="fa-solid fa-lock"></i> خاص
                                        </span>
                                    @else
                                        <span class="bg-emerald-50 text-emerald-700 text-[10px] px-2.5 py-0.5 rounded-lg border border-emerald-100 font-bold flex items-center gap-1">
                                            <i class="fa-solid fa-globe"></i> عام
                                        </span>
                                    @endif
                                    <span class="text-slate-400 text-xs">•</span>
                                    <span class="text-slate-500 text-xs">تم التحديث {{ $dataset->updated_at->diffForHumans() }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- أزرار إجراءات سريعة (اختياري) --}}
                    <div class="flex gap-2">
                        <button class="bg-white border border-slate-200 text-slate-600 w-10 h-10 rounded-xl hover:bg-slate-50 hover:text-emerald-600 transition shadow-sm flex items-center justify-center">
                            <i class="fa-regular fa-star"></i>
                        </button>
                        <button class="bg-white border border-slate-200 text-slate-600 w-10 h-10 rounded-xl hover:bg-slate-50 hover:text-emerald-600 transition shadow-sm flex items-center justify-center">
                            <i class="fa-solid fa-share-nodes"></i>
                        </button>
                    </div>
                </div>

                {{-- التبويبات (Modern Pills) --}}
                <div class="flex items-center gap-2 border-b border-slate-200 pb-1">
                    <button wire:click="$set('activeTab', 'overview')"
                            class="px-5 py-2.5 rounded-xl text-sm font-bold transition-all duration-200 flex items-center gap-2 relative
                            {{ $activeTab === 'overview' ? 'bg-slate-900 text-white shadow-lg shadow-slate-900/20 translate-y-[-2px]' : 'text-slate-500 hover:bg-white hover:text-slate-800' }}">
                        <i class="fa-regular fa-file-lines"></i> نظرة عامة
                    </button>

                    <button wire:click="$set('activeTab', 'files')"
                            class="px-5 py-2.5 rounded-xl text-sm font-bold transition-all duration-200 flex items-center gap-2 relative
                            {{ $activeTab === 'files' ? 'bg-slate-900 text-white shadow-lg shadow-slate-900/20 translate-y-[-2px]' : 'text-slate-500 hover:bg-white hover:text-slate-800' }}">
                        <i class="fa-solid fa-folder-open"></i> الملفات
                        <span class="bg-white/20 text-current px-1.5 py-0.5 rounded text-[10px] ml-1">{{ $dataset->files_count }}</span>
                    </button>

                    <button wire:click="$set('activeTab', 'settings')"
                            class="px-5 py-2.5 rounded-xl text-sm font-bold transition-all duration-200 flex items-center gap-2 relative
                            {{ $activeTab === 'settings' ? 'bg-slate-900 text-white shadow-lg shadow-slate-900/20 translate-y-[-2px]' : 'text-slate-500 hover:bg-white hover:text-slate-800' }}">
                        <i class="fa-solid fa-gear"></i> الإعدادات
                    </button>
                </div>
            </div>
        </div>

        {{-- 2. المحتوى الرئيسي --}}
        <div class="flex-1 overflow-y-auto px-6 lg:px-10 pb-10">
            <div class="max-w-7xl mx-auto mt-6 animate-fade-in-up">

                {{-- ================= TAB: OVERVIEW ================= --}}
                @if($activeTab === 'overview')
                    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">

                        {{-- المحتوى (يسار) --}}
                        <div class="lg:col-span-8">
                            <div class="bg-white rounded-3xl border border-slate-100 shadow-[0_4px_20px_rgb(0,0,0,0.03)] overflow-hidden">
                                <div class="px-8 py-6 border-b border-slate-50 flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center text-sm">
                                        <i class="fa-solid fa-book-open"></i>
                                    </div>
                                    <span class="font-bold text-slate-800">وصف البيانات (README)</span>
                                </div>
                                <div class="p-8 prose prose-slate max-w-none prose-p:text-slate-600 prose-headings:text-slate-800">
                                    {{ $dataset->description ?? 'لا يوجد وصف متاح لهذه المجموعة.' }}
                                </div>
                            </div>
                        </div>

                        {{-- الشريط الجانبي (يمين) --}}
                        <div class="lg:col-span-4 space-y-6">

                            {{-- بطاقة كود الاستخدام --}}
                            <div class="bg-[#1E293B] rounded-3xl p-6 shadow-xl relative overflow-hidden group border border-slate-700/50">
                                {{-- تأثير الإضاءة --}}
                                <div class="absolute -top-10 -right-10 w-32 h-32 bg-emerald-500/20 rounded-full blur-3xl group-hover:bg-emerald-500/30 transition duration-500"></div>

                                <div class="flex justify-between items-center mb-4 relative z-10">
                                    <h3 class="text-white font-bold text-sm flex items-center gap-2">
                                        <i class="fa-brands fa-python text-emerald-400"></i> الاستخدام
                                    </h3>
                                    <button class="text-xs text-slate-400 hover:text-white bg-slate-800 hover:bg-slate-700 px-2 py-1 rounded transition" title="نسخ">
                                        نسخ <i class="fa-regular fa-copy ml-1"></i>
                                    </button>
                                </div>
                                <div class="font-mono text-xs text-slate-300 bg-black/50 p-4 rounded-xl border border-white/5 relative z-10" dir="ltr">
                                    <span class="text-purple-400">from</span> datasets <span class="text-purple-400">import</span> load_dataset<br><br>
                                    ds = load_dataset(<span class="text-emerald-400">"oneurai/{{ $dataset->slug }}"</span>)
                                </div>
                            </div>

                            {{-- بطاقة المعلومات --}}
                            <div class="bg-white rounded-3xl border border-slate-100 shadow-[0_4px_20px_rgb(0,0,0,0.03)] p-6">
                                <h3 class="font-bold text-slate-800 mb-5 text-sm">بيانات وصفية</h3>
                                <div class="space-y-4">
                                    <div class="flex justify-between items-center pb-3 border-b border-slate-50 last:border-0 last:pb-0">
                                        <span class="text-slate-400 text-xs font-bold">الرخصة</span>
                                        <span class="bg-slate-100 px-2.5 py-1 rounded-md text-xs font-mono font-bold text-slate-600 border border-slate-200">{{ $dataset->license }}</span>
                                    </div>
                                    <div class="flex justify-between items-center pb-3 border-b border-slate-50 last:border-0 last:pb-0">
                                        <span class="text-slate-400 text-xs font-bold">المهمة</span>
                                        <span class="flex items-center gap-1.5 text-xs font-bold text-emerald-700 bg-emerald-50 px-2.5 py-1 rounded-full">
                                            <i class="fa-solid fa-tag text-[10px]"></i> {{ $dataset->task_type }}
                                        </span>
                                    </div>
                                    <div class="flex justify-between items-center pb-3 border-b border-slate-50 last:border-0 last:pb-0">
                                        <span class="text-slate-400 text-xs font-bold">الحجم</span>
                                        <span class="text-slate-800 font-bold text-sm" dir="ltr">{{ $dataset->formatted_size }}</span>
                                    </div>
                                    <div class="flex justify-between items-center pb-3 border-b border-slate-50 last:border-0 last:pb-0">
                                        <span class="text-slate-400 text-xs font-bold">التحميلات</span>
                                        <span class="text-slate-800 font-bold text-sm">{{ $dataset->formatted_downloads }}</span>
                                    </div>
                                </div>
                            </div>

                            {{-- بطاقة المالك --}}
                            <div class="bg-white rounded-3xl border border-slate-100 shadow-[0_4px_20px_rgb(0,0,0,0.03)] p-6 flex items-center gap-4">
                                <img src="https://ui-avatars.com/api/?name={{ $dataset->user->name }}&background=10b981&color=fff&bold=true" class="w-12 h-12 rounded-2xl shadow-sm">
                                <div>
                                    <div class="font-bold text-slate-900 text-sm flex items-center gap-1">
                                        {{ $dataset->user->name }}
                                        <x-admin-badge :user="$dataset->user" />
                                    </div>
                                    <div class="text-xs text-slate-500 font-medium">الناشر (المالك)</div>
                                </div>
                            </div>

                        </div>
                    </div>
                @endif

                {{-- ================= TAB: FILES ================= --}}
                @if($activeTab === 'files')
                    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
                        {{-- قائمة الملفات --}}
                        <div class="lg:col-span-8">
                            <div class="bg-white rounded-3xl border border-slate-100 shadow-[0_4px_20px_rgb(0,0,0,0.03)] overflow-hidden">
                                <div class="px-6 py-4 border-b border-slate-50 bg-slate-50/50 flex justify-between items-center">
                                    <h3 class="font-bold text-slate-800 text-sm">مستكشف الملفات</h3>
                                    <span class="bg-white border border-slate-200 px-2 py-1 rounded-lg text-xs font-mono text-slate-500">{{ $dataset->files->count() }} files</span>
                                </div>
                                <table class="w-full text-right">
                                    <thead class="bg-white text-slate-400 text-[10px] uppercase font-bold tracking-wider border-b border-slate-100">
                                        <tr>
                                            <th class="px-6 py-4 w-6/12">الاسم</th>
                                            <th class="px-6 py-4 w-3/12">الحجم</th>
                                            <th class="px-6 py-4 w-3/12 text-left">خيارات</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-slate-50 text-sm text-slate-700">
                                        @forelse($dataset->files as $file)
                                            <tr class="hover:bg-slate-50 transition group" wire:key="file-{{ $file->id }}">
                                                <td class="px-6 py-4">
                                                    <div class="flex items-center gap-3">
                                                        <div class="w-8 h-8 rounded-lg flex items-center justify-center bg-slate-100 text-slate-500 group-hover:scale-110 transition">
                                                            @if(in_array($file->extension, ['csv', 'xls', 'xlsx', 'json']))
                                                                <i class="fa-solid fa-file-csv text-emerald-600"></i>
                                                            @elseif(in_array($file->extension, ['zip', 'rar']))
                                                                <i class="fa-solid fa-file-zipper text-amber-500"></i>
                                                            @elseif(in_array($file->extension, ['png', 'jpg', 'jpeg']))
                                                                <i class="fa-regular fa-image text-purple-500"></i>
                                                            @else
                                                                <i class="fa-regular fa-file"></i>
                                                            @endif
                                                        </div>
                                                        <span class="font-mono text-slate-800 font-medium group-hover:text-emerald-700 transition" dir="ltr">{{ $file->filename }}</span>
                                                    </div>
                                                </td>
                                                <td class="px-6 py-4 font-mono text-xs text-slate-500">
                                                    {{ $file->formatted_size }}
                                                </td>
                                                <td class="px-6 py-4 text-left">
                                                    <div class="flex items-center justify-end gap-2 opacity-50 group-hover:opacity-100 transition">
                                                        <button wire:click="downloadFile({{ $file->id }})" class="w-8 h-8 rounded-lg flex items-center justify-center bg-white border border-slate-200 text-slate-500 hover:text-emerald-600 hover:border-emerald-200 transition shadow-sm">
                                                            <i class="fa-solid fa-download text-xs"></i>
                                                        </button>
                                                        <button wire:confirm="حذف الملف؟" wire:click="deleteFile({{ $file->id }})" class="w-8 h-8 rounded-lg flex items-center justify-center bg-white border border-slate-200 text-slate-500 hover:text-red-600 hover:border-red-200 transition shadow-sm">
                                                            <i class="fa-solid fa-trash text-xs"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="3" class="py-12 text-center">
                                                    <div class="flex flex-col items-center justify-center opacity-50">
                                                        <div class="w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center mb-3 text-2xl text-slate-400">
                                                            <i class="fa-solid fa-folder-open"></i>
                                                        </div>
                                                        <p class="text-sm text-slate-500 font-bold">المجلد فارغ</p>
                                                        <p class="text-xs text-slate-400">قم برفع ملفات لتبدأ العمل</p>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        {{-- منطقة الرفع --}}
<div class="lg:col-span-4">
    <div class="sticky top-6">
        <div class="bg-white rounded-3xl border border-slate-100 shadow-[0_4px_20px_rgb(0,0,0,0.03)] p-6"
             x-data="{ 
                isUploading: false, 
                progress: 0, 
                // متغيرات الحساب
                formatBytes(bytes, decimals = 2) {
                    if (!+bytes) return '0 Bytes';
                    const k = 1024;
                    const dm = decimals < 0 ? 0 : decimals;
                    const sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB'];
                    const i = Math.floor(Math.log(bytes) / Math.log(k));
                    return `${parseFloat((bytes / Math.pow(k, i)).toFixed(dm))} ${sizes[i]}`;
                }
             }"
             x-on:livewire-upload-start="isUploading = true; progress = 0"
             x-on:livewire-upload-finish="isUploading = false"
             x-on:livewire-upload-error="isUploading = false"
             x-on:livewire-upload-progress="progress = $event.detail.progress">
             
            <h3 class="font-bold text-slate-900 text-sm mb-4 flex items-center gap-2">
                <i class="fa-solid fa-cloud-arrow-up text-emerald-500"></i> رفع ملف (ZIP أو عادي)
            </h3>

            <form wire:submit="uploadFiles">
                
                {{-- منطقة الرفع --}}
                <div class="relative w-full aspect-[4/3] rounded-2xl border-2 border-dashed border-slate-300 hover:border-emerald-500 hover:bg-emerald-50/50 transition-all duration-300 group flex flex-col items-center justify-center text-center cursor-pointer overflow-hidden"
                     :class="isUploading ? 'bg-slate-50 border-emerald-500 cursor-wait opacity-80' : ''">

                    {{-- ⚠️ التعديل هنا: إزالة multiple وتغيير الاسم للمفرد --}}
                    <input type="file" 
                           wire:model="newFile" 
                           accept=".zip,.csv,.json,.png,.jpg,.jpeg"
                           class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-20"
                           :disabled="isUploading">

                    {{-- الحالة الافتراضية --}}
                    <div x-show="!isUploading" class="z-10 transition transform group-hover:-translate-y-1">
                        <div class="w-14 h-14 bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center mx-auto mb-3 shadow-sm relative">
                            <i class="fa-solid fa-file-zipper text-xl"></i>
                        </div>
                        <p class="text-sm font-bold text-slate-700">اضغط لرفع ملف ZIP</p>
                        <div class="text-[10px] text-slate-400 mt-2 px-4 leading-relaxed">
                            للملفات الكبيرة، اضغطها في ملف ZIP واحد
                            <br>
                            <span class="text-emerald-600 font-bold bg-emerald-50 px-2 py-0.5 rounded-full mt-1 inline-block">
                                سيتم فك الضغط تلقائياً
                            </span>
                        </div>
                    </div>

                    {{-- شريط التحميل --}}
                    <div x-show="isUploading" class="z-10 w-full px-8" style="display: none;">
                        <div class="flex justify-between text-xs font-bold text-slate-600 mb-2">
                            <span x-text="progress + '%'"></span>
                        </div>
                        <div class="w-full bg-slate-200 rounded-full h-2.5 overflow-hidden">
                            <div class="bg-gradient-to-r from-emerald-500 to-teal-400 h-2.5 rounded-full transition-all duration-200 relative"
                                 :style="'width: ' + progress + '%'">
                                 <div class="absolute inset-0 bg-white/30 animate-[shimmer_1s_infinite] w-full h-full"></div>
                            </div>
                        </div>
                        <p class="text-[10px] text-emerald-600 mt-2 font-bold animate-pulse">جاري الرفع...</p>
                    </div>
                </div>

                {{-- رسائل الخطأ --}}
                @error('newFile') <span class="text-red-500 text-xs font-bold mt-2 block">{{ $message }}</span> @enderror

                {{-- معاينة الملف المختار --}}
                @if($newFile)
                    <div x-show="!isUploading" class="mt-4 bg-slate-50 rounded-xl p-3 border border-slate-200 animate-fade-in-down">
                        <div class="flex items-center gap-2">
                            <i class="fa-solid fa-file-zipper text-amber-500 text-lg"></i>
                            <span class="text-xs text-slate-700 truncate flex-1 font-bold">{{ $newFile->getClientOriginalName() }}</span>
                            <button type="button" wire:click="$set('newFile', null)" class="text-xs text-red-500 hover:text-red-700 font-bold px-2">إلغاء</button>
                        </div>
                    </div>
                @endif

                <button type="submit"
                        x-show="!isUploading"
                        wire:loading.attr="disabled"
                        class="w-full mt-4 bg-slate-900 text-white py-3 rounded-xl text-sm font-bold hover:bg-emerald-600 transition-all shadow-lg hover:shadow-emerald-500/30 disabled:opacity-50 disabled:cursor-not-allowed group">
                    <span>
                        <i class="fa-solid fa-cloud-arrow-up ml-1 group-hover:animate-bounce"></i> رفع الملف الآن
                    </span>
                </button>
            </form>
        </div>
    </div>
</div>
                    </div>
                @endif

                {{-- ================= TAB: SETTINGS ================= --}}
                @if($activeTab === 'settings')
                    <div class="max-w-3xl mx-auto space-y-8">

                        {{-- فورم التعديل --}}
                        <div class="bg-white rounded-3xl border border-slate-100 shadow-[0_4px_20px_rgb(0,0,0,0.03)] p-8">
                            <div class="flex items-center gap-3 mb-6 border-b border-slate-50 pb-4">
                                <div class="w-10 h-10 rounded-xl bg-slate-100 flex items-center justify-center text-slate-600">
                                    <i class="fa-solid fa-sliders"></i>
                                </div>
                                <div>
                                    <h3 class="font-bold text-slate-900">الإعدادات العامة</h3>
                                    <p class="text-xs text-slate-500">تعديل المعلومات الأساسية للمشروع</p>
                                </div>
                            </div>

                            <div class="space-y-5">
                                <div>
                                    <label class="block text-sm font-bold text-slate-700 mb-2">عنوان المجموعة</label>
                                    <input type="text" wire:model="edit_title" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm font-bold text-slate-800 focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 outline-none transition">
                                    @error('edit_title') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-bold text-slate-700 mb-2">الوصف</label>
                                    <textarea wire:model="edit_description" rows="4" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-700 focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 outline-none transition resize-none"></textarea>
                                </div>

                                <div class="grid grid-cols-2 gap-6">
                                    <div>
                                        <label class="block text-sm font-bold text-slate-700 mb-2">الخصوصية</label>
                                        <div class="relative">
                                            <select wire:model="edit_visibility" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm font-bold text-slate-700 focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 outline-none appearance-none cursor-pointer">
                                                <option value="public">عام (Public)</option>
                                                <option value="private">خاص (Private)</option>
                                            </select>
                                            <i class="fa-solid fa-chevron-down absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-bold text-slate-700 mb-2">نوع المهمة</label>
                                        <div class="relative">
                                            <select wire:model="edit_task_type" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm font-bold text-slate-700 focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 outline-none appearance-none cursor-pointer">
                                                <option>Text Classification</option>
                                                <option>Sentiment Analysis</option>
                                                <option>ASR</option>
                                                <option>Object Detection</option>
                                            </select>
                                            <i class="fa-solid fa-chevron-down absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                                        </div>
                                    </div>
                                </div>

                                <div class="pt-4 flex justify-end">
                                    <button wire:click="updateDataset" class="bg-slate-900 hover:bg-emerald-600 text-white px-8 py-3 rounded-xl text-sm font-bold transition-all shadow-lg hover:shadow-emerald-500/30 transform active:scale-95">
                                        حفظ التغييرات
                                    </button>
                                </div>
                            </div>
                        </div>

                        {{-- منطقة الخطر --}}
                        <div class="bg-white rounded-3xl border border-red-100 shadow-[0_4px_20px_rgb(0,0,0,0.03)] p-8 relative overflow-hidden">
                            <div class="absolute top-0 left-0 w-1 h-full bg-red-500"></div>
                            <h3 class="font-bold text-red-600 mb-2 flex items-center gap-2">
                                <i class="fa-solid fa-triangle-exclamation"></i> منطقة الخطر
                            </h3>
                            <p class="text-sm text-slate-500 mb-6">حذف مجموعة البيانات سيؤدي إلى إزالة جميع الملفات والسجلات المرتبطة بها نهائياً. لا يمكن التراجع عن هذا الإجراء.</p>

                            <button wire:confirm="هل أنت متأكد تماماً؟ هذا الإجراء لا رجعة فيه."
                                    wire:click="deleteDataset"
                                    class="bg-red-50 text-red-600 border border-red-200 px-6 py-2.5 rounded-xl text-sm font-bold hover:bg-red-600 hover:text-white transition-colors">
                                حذف المشروع نهائياً
                            </button>
                        </div>
                    </div>
                @endif

            </div>
        </div>
    </main>
</div>
