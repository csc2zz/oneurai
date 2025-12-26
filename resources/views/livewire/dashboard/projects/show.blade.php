<div class="flex flex-col h-full bg-[#f8fafc] min-h-screen animate-fade-in">

    {{-- ================================================= --}}
    {{--             1. ASSETS & GLOBAL STYLES             --}}
    {{-- ================================================= --}}
    @assets
        {{-- Markdown Engine --}}
        <script src="https://cdn.jsdelivr.net/npm/markdown-it@13.0.1/dist/markdown-it.min.js"></script>
        {{-- Math Support (LaTeX) --}}
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/katex@0.16.8/dist/katex.min.css">
        <script src="https://cdn.jsdelivr.net/npm/markdown-it-katex@2.0.3/dist/markdown-it-katex.js"></script>
        {{-- Syntax Highlighting --}}
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/styles/github-dark.min.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/highlight.min.js"></script>

        <style>
            /* تخصيص منطقة عرض الـ README لتشبه GitHub */
            .markdown-body { font-family: 'Inter', -apple-system,BlinkMacSystemFont,"Segoe UI",Helvetica,Arial,sans-serif; color: #334155; line-height: 1.7; }
            .markdown-body h1, .markdown-body h2, .markdown-body h3 { margin-top: 24px; margin-bottom: 16px; font-weight: 700; line-height: 1.25; color: #0f172a; }
            .markdown-body h1 { font-size: 2em; border-bottom: 1px solid #e2e8f0; padding-bottom: .3em; }
            .markdown-body h2 { font-size: 1.5em; border-bottom: 1px solid #e2e8f0; padding-bottom: .3em; }
            .markdown-body a { color: #059669; text-decoration: none; font-weight: 500; }
            .markdown-body a:hover { text-decoration: underline; }
            .markdown-body blockquote { border-right: 4px solid #cbd5e1; padding-right: 1em; color: #64748b; background-color: #f8fafc; font-style: italic; }
            .markdown-body pre { background-color: #0f172a; border-radius: 12px; padding: 20px; overflow: auto; line-height: 1.45; border: 1px solid #1e293b; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1); }
            .markdown-body code { background-color: #f1f5f9; padding: .2em .4em; border-radius: 6px; font-family: ui-monospace,SFMono-Regular,Menlo,monospace; font-size: 85%; color: #ef4444; }
            .markdown-body pre code { background-color: transparent; padding: 0; color: inherit; font-size: 100%; }
            .markdown-body img { max-width: 100%; box-sizing: content-box; background-color: #fff; border-radius: 8px; border: 1px solid #e2e8f0; box-shadow: 0 2px 4px rgba(0,0,0,0.05); }
            .markdown-body table { border-spacing: 0; border-collapse: collapse; margin-bottom: 16px; width: 100%; overflow: auto; border-radius: 8px; overflow: hidden; border: 1px solid #e2e8f0; }
            .markdown-body table th, .markdown-body table td { padding: 10px 13px; border: 1px solid #e2e8f0; }
            .markdown-body table th { background-color: #f8fafc; font-weight: 600; }
            .markdown-body table tr:nth-child(2n) { background-color: #f8fafc; }
        </style>
    @endassets

    {{-- ================================================= --}}
    {{--             2. JAVASCRIPT LOGIC                   --}}
    {{-- ================================================= --}}
    @script
    <script>
        function initMarkdownViewer() {
            const container = document.getElementById('readme-content');
            if (!container) return;
            const rawContent = container.getAttribute('data-content');

            if (!rawContent) {
                container.innerHTML = '<div class="flex flex-col items-center justify-center py-10 text-slate-400"><i class="fa-regular fa-file-lines text-3xl mb-2 opacity-50"></i><p>لا يوجد محتوى لعرضه.</p></div>';
                return;
            }

            const md = window.markdownit({
                html: true, linkify: true, typographer: true,
                highlight: function (str, lang) {
                    if (lang && hljs.getLanguage(lang)) {
                        try { return `<pre class="hljs"><code>${hljs.highlight(str, { language: lang, ignoreIllegals: true }).value}</code></pre>`; } catch (__) {}
                    }
                    return `<pre class="hljs"><code>${md.utils.escapeHtml(str)}</code></pre>`;
                }
            });

            if (window.markdownitKatex) {
                md.use(window.markdownitKatex, { throwOnError: false, errorColor: '#cc0000' });
            }

            container.innerHTML = md.render(rawContent);
        }

        initMarkdownViewer();
        document.addEventListener('livewire:navigated', initMarkdownViewer);
        Livewire.on('readme-updated', () => { setTimeout(() => { initMarkdownViewer(); }, 50); });
    </script>
    @endscript

    {{-- ================================================= --}}
    {{--             3. MAIN CONTENT AREA                  --}}
    {{-- ================================================= --}}

    {{-- Header --}}
{{-- بداية الهيدر الثابت --}}
{{-- نهاية الهيدر الثابت --}}

    {{-- Content --}}
    <div class="flex-1 max-w-7xl mx-auto w-full px-4 sm:px-6 lg:px-8 py-8">

        {{-- Alerts --}}
        @if (session('success'))
            <div x-data="{ show: true }" x-show="show" x-transition class="mb-6 p-4 bg-emerald-50 border border-emerald-100 text-emerald-800 rounded-xl shadow-sm flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <i class="fa-solid fa-circle-check text-xl text-emerald-500"></i>
                    <span class="font-bold">{{ session('success') }}</span>
                </div>
                <button @click="show = false" class="text-emerald-400 hover:text-emerald-700"><i class="fa-solid fa-xmark"></i></button>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8 items-start">

            {{-- SIDEBAR --}}
            <div class="lg:col-span-1 space-y-6">
                <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm relative overflow-hidden group">
                    {{-- شريط ملون علوي --}}
                    <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-emerald-400 to-teal-500"></div>

                    {{-- الأيقونة والعنوان --}}
                    <div class="flex items-start gap-4 mb-4">
                        <div class="w-14 h-14 rounded-xl bg-gradient-to-br from-emerald-50 to-teal-50 border border-emerald-100 flex items-center justify-center text-emerald-600 shadow-sm shrink-0">
                            <i class="fa-solid fa-layer-group text-2xl"></i>
                        </div>
                        <div>
                            <h1 class="text-lg font-bold text-slate-900 font-sans tracking-tight break-all leading-tight">
                                {{ $project->title }}
                            </h1>
                            <span class="inline-block mt-2 px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider border
                                {{ $project->is_public ? 'bg-emerald-50 text-emerald-700 border-emerald-100' : 'bg-amber-50 text-amber-700 border-amber-100' }}">
                                {{ $project->is_public ? 'Public' : 'Private' }}
                            </span>
                        </div>
                    </div>

                    {{-- الوصف --}}
                    <p class="text-slate-500 text-sm mb-6 leading-relaxed">
                        {{ $project->description ?? 'لا يوجد وصف للمشروع.' }}
                    </p>

                    {{-- أزرار الإجراءات (عرض كامل) --}}
                    <div class="space-y-3">
                        <button wire:click="downloadAll" wire:loading.attr="disabled"
                            class="w-full bg-slate-900 text-white hover:bg-emerald-600 border border-transparent px-4 py-2.5 rounded-xl text-sm font-bold transition-all shadow-md hover:shadow-emerald-500/30 flex items-center justify-center gap-2 disabled:opacity-50">
                            <span wire:loading.remove wire:target="downloadAll"><i class="fa-solid fa-cloud-arrow-down"></i> تحميل المشروع</span>
                            <span wire:loading wire:target="downloadAll"><i class="fa-solid fa-spinner animate-spin"></i> جاري التجهيز...</span>
                        </button>
                    </div>
                </div>
                <nav class="space-y-2">
                    <button wire:click="$set('activeTab', 'code')"
                        class="w-full flex items-center gap-3 px-4 py-3 rounded-xl font-bold text-sm transition-all duration-300 group relative overflow-hidden
                        {{ $activeTab === 'code' ? 'bg-emerald-600 text-white shadow-lg shadow-emerald-500/30' : 'bg-white text-slate-600 hover:bg-slate-50 border border-slate-200' }}">
                        <i class="fa-solid fa-code w-5 text-center {{ $activeTab === 'code' ? 'text-emerald-200' : 'text-slate-400 group-hover:text-emerald-600' }}"></i>
                        <span>الملفات والكود</span>
                    </button>

                    @if ($project->user_id === auth()->id())
                        <button wire:click="$set('activeTab', 'team')"
                            class="w-full flex items-center gap-3 px-4 py-3 rounded-xl font-bold text-sm transition-all duration-300 group
                            {{ $activeTab === 'team' ? 'bg-emerald-600 text-white shadow-lg shadow-emerald-500/30' : 'bg-white text-slate-600 hover:bg-slate-50 border border-slate-200' }}">
                            <i class="fa-solid fa-users w-5 text-center {{ $activeTab === 'team' ? 'text-emerald-200' : 'text-slate-400 group-hover:text-emerald-600' }}"></i>
                            <span>فريق العمل</span>
                        </button>
                    @endif

                    @if (in_array($this->currentRole ?? 'owner', ['owner', 'admin']))
                        <button wire:click="$set('activeTab', 'settings')"
                            class="w-full flex items-center gap-3 px-4 py-3 rounded-xl font-bold text-sm transition-all duration-300 group
                            {{ $activeTab === 'settings' ? 'bg-emerald-600 text-white shadow-lg shadow-emerald-500/30' : 'bg-white text-slate-600 hover:bg-slate-50 border border-slate-200' }}">
                            <i class="fa-solid fa-gear w-5 text-center {{ $activeTab === 'settings' ? 'text-emerald-200' : 'text-slate-400 group-hover:text-emerald-600' }}"></i>
                            <span>الإعدادات</span>
                        </button>
                    @endif
                </nav>

                {{-- Mini Stats --}}
                <div class="bg-white rounded-xl border border-slate-200 p-5 shadow-sm">
                    <h3 class="font-bold text-slate-900 text-xs uppercase tracking-wider mb-4 border-b border-slate-100 pb-2">نظرة سريعة</h3>
                    <div class="space-y-3">
                         <div class="flex justify-between items-center text-sm">
                            <span class="text-slate-500 flex items-center gap-2"><i class="fa-regular fa-star text-amber-400"></i> النجوم</span>
                            <span class="font-bold text-slate-900 font-sans">{{ $project->stars_count ?? 0 }}</span>
                        </div>
                        <div class="flex justify-between items-center text-sm">
                            <span class="text-slate-500 flex items-center gap-2"><i class="fa-solid fa-code-branch text-blue-400"></i> التفرعات</span>
                            <span class="font-bold text-slate-900 font-sans">{{ $project->forks_count ?? 0 }}</span>
                        </div>
                        <div class="flex justify-between items-center text-sm">
                            <span class="text-slate-500 flex items-center gap-2"><i class="fa-regular fa-clock text-slate-400"></i> التحديث</span>
                            <span class="font-bold text-slate-900 text-xs">{{ $project->updated_at->diffForHumans(null, true) }}</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- MAIN CONTENT --}}
            <div class="lg:col-span-3 space-y-8">

                {{-- TAB 1: CODE --}}
                @if ($activeTab === 'code')

{{-- File Upload Section (Collapsible or Card) --}}
@if ($project->user_id === auth()->id())
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden mb-8 transition-all duration-300 hover:shadow-md"
         x-data="{ isUploading: false, progress: 0, isDragging: false }"
         x-on:livewire-upload-start="isUploading = true; progress = 0"
         x-on:livewire-upload-finish="isUploading = false"
         x-on:livewire-upload-error="isUploading = false"
         x-on:livewire-upload-progress="progress = $event.detail.progress">

        <div class="relative min-h-[250px] flex flex-col items-center justify-center p-8 transition-colors duration-300"
             :class="isDragging ? 'bg-emerald-50/50 border-2 border-emerald-400 border-dashed' : 'bg-white hover:bg-slate-50 border-2 border-transparent'"
             @dragover.prevent="isDragging = true"
             @dragleave.prevent="isDragging = false"
             @drop.prevent="isDragging = false">

            {{-- 1. حالة الرفع (Progress State) --}}
            <div x-show="isUploading" style="display: none;" class="w-full max-w-md mx-auto text-center z-20 animate-fade-in">
                <div class="mb-4 relative">
                    {{-- أيقونة متحركة --}}
                    <div class="w-20 h-20 mx-auto bg-emerald-50 rounded-full flex items-center justify-center relative">
                        <svg class="w-full h-full text-emerald-100 absolute top-0 left-0 animate-spin-slow" viewBox="0 0 100 100">
                            <circle cx="50" cy="50" r="45" stroke="currentColor" stroke-width="2" fill="none" stroke-dasharray="10 10"/>
                        </svg>
                        <i class="fa-solid fa-cloud-arrow-up text-3xl text-emerald-600 animate-bounce"></i>
                    </div>
                </div>

                <h3 class="text-slate-900 font-bold text-lg mb-1">جاري رفع الملفات...</h3>
                <p class="text-slate-400 text-sm mb-6 font-mono" x-text="progress + '%'"></p>

                {{-- شريط التقدم الاحترافي --}}
                <div class="w-full bg-slate-100 rounded-full h-3 overflow-hidden shadow-inner border border-slate-200">
                    <div class="h-full bg-gradient-to-r from-emerald-400 to-emerald-600 rounded-full transition-all duration-300 ease-out shadow-[0_0_10px_rgba(16,185,129,0.5)]"
                         :style="'width: ' + progress + '%'">
                        <div class="w-full h-full opacity-30 bg-[length:10px_10px] bg-[linear-gradient(45deg,rgba(255,255,255,.15)_25%,transparent_25%,transparent_50%,rgba(255,255,255,.15)_50%,rgba(255,255,255,.15)_75%,transparent_75%,transparent)] animate-stripes"></div>
                    </div>
                </div>
                <p class="text-xs text-slate-400 mt-3">يرجى الانتظار وعدم إغلاق الصفحة.</p>
            </div>

            {{-- 2. حالة السكون (Drop Zone) --}}
            <div x-show="!isUploading" class="w-full text-center z-10 transition-opacity duration-300" :class="isUploading ? 'opacity-0' : 'opacity-100'">
                <form wire:submit="uploadFiles">
                    {{-- Input مخفي يغطي كامل المنطقة --}}
                    <input wire:model="newFiles" type="file" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10" multiple title="">

                    {{-- الأيقونة الرئيسية --}}
                    <div class="w-20 h-20 bg-slate-100 rounded-[2rem] flex items-center justify-center mx-auto mb-6 transition-transform duration-300 group-hover:scale-110 shadow-sm"
                         :class="isDragging ? 'bg-emerald-100 text-emerald-600 scale-110 rotate-3' : 'text-slate-400 group-hover:bg-white group-hover:shadow-md'">
                        <i class="fa-solid fa-cloud-arrow-up text-4xl"></i>
                    </div>

                    <h3 class="text-xl font-bold text-slate-900 mb-2">اضغط أو اسحب الملفات هنا</h3>
                    <p class="text-slate-500 text-sm mb-8 max-w-sm mx-auto leading-relaxed">
                        ندعم الملفات البرمجية، الصور، والمجلدات المضغوطة.
                        <br>
                        <span class="text-xs text-slate-400">(Max: 50MB per file)</span>
                    </p>

                    {{-- أزرار التحكم --}}
                    <div class="flex items-center justify-center gap-4 relative z-20 pointer-events-none">
                        {{-- زر رفع ZIP (وهمي للتصميم، الحقيقي فوقه Input) --}}
                        <div class="pointer-events-auto relative">
                            <input type="file" wire:model="projectZip" accept=".zip" class="hidden" id="zip-upload-btn">
                            <label for="zip-upload-btn" class="cursor-pointer bg-white border border-slate-200 text-slate-700 px-5 py-2.5 rounded-xl text-sm font-bold hover:border-emerald-500 hover:text-emerald-600 hover:shadow-md transition flex items-center gap-2 shadow-sm">
                                <i class="fa-solid fa-file-zipper text-lg"></i>
                                <span>رفع ZIP كامل</span>
                            </label>
                        </div>

                        {{-- زر الحفظ النهائي (يظهر فقط بعد اختيار الملفات) --}}
                        @if ($projectZip)
                            <button type="button"
                                    wire:click="uploadZipProject"
                                    class="pointer-events-auto bg-emerald-600 text-white px-8 py-2.5 rounded-xl text-sm font-bold hover:bg-emerald-700 transition shadow-lg shadow-emerald-500/30 flex items-center gap-2 animate-fade-in-up"
                                    wire:loading.attr="disabled"
                                    wire:target="uploadZipProject">

                                <span wire:loading.remove wire:target="uploadZipProject" class="flex items-center gap-2">
                                    <i class="fa-solid fa-box-open"></i> فك الضغط والحفظ
                                </span>

                                <span wire:loading wire:target="uploadZipProject" class="flex items-center gap-2">
                                    <i class="fa-solid fa-spinner animate-spin"></i> جاري المعالجة...
                                </span>
                            </button>
                        @endif
                        @if ($newFiles)
                            <button type="submit"
                                    class="pointer-events-auto bg-slate-900 text-white px-8 py-2.5 rounded-xl text-sm font-bold hover:bg-emerald-600 transition shadow-lg hover:shadow-emerald-500/30 flex items-center gap-3 disabled:opacity-70 disabled:cursor-not-allowed"
                                    wire:loading.attr="disabled"
                                    wire:target="uploadFiles">

                                {{-- النص العادي --}}
                                <span wire:loading.remove wire:target="uploadFiles" class="flex items-center gap-2">
                                    <i class="fa-solid fa-check"></i> حفظ {{ count($newFiles) }} ملف
                                </span>

                                {{-- النص أثناء المعالجة (Busy State) --}}
                                <span wire:loading wire:target="uploadFiles" class="flex items-center gap-2">
                                    <i class="fa-solid fa-circle-notch animate-spin"></i> جاري المعالجة...
                                </span>
                            </button>
                        @endif
                    </div>

                    {{-- رسائل الخطأ --}}
                    @error('newFiles.*')
                        <div class="mt-6 p-3 bg-red-50 border border-red-100 rounded-lg text-red-600 text-xs font-bold inline-block animate-fade-in-up">
                            <i class="fa-solid fa-circle-exclamation mr-1"></i> {{ $message }}
                        </div>
                    @enderror
                    @error('projectZip')
                        <div class="mt-6 p-3 bg-red-50 border border-red-100 rounded-lg text-red-600 text-xs font-bold inline-block animate-fade-in-up">
                            <i class="fa-solid fa-circle-exclamation mr-1"></i> {{ $message }}
                        </div>
                    @enderror
                </form>
            </div>
        </div>
    </div>
@endif

                    {{-- File Browser --}}
                    <div class="bg-white rounded-2xl border border-slate-200 shadow-[0_2px_10px_rgb(0,0,0,0.02)] overflow-hidden">

                        {{-- Breadcrumb Bar --}}
                        <div class="bg-slate-50/50 px-5 py-3 border-b border-slate-200 flex items-center justify-between backdrop-blur-sm">
                            <div class="flex items-center flex-wrap gap-2 text-sm font-medium">
                                <button wire:click="navigateTo('')" class="flex items-center gap-1.5 px-2 py-1 rounded hover:bg-white hover:shadow-sm transition text-slate-700 hover:text-emerald-600">
                                    <i class="fa-solid fa-house text-xs opacity-70"></i>
                                    <span class="font-mono font-bold">{{ $project->slug }}</span>
                                </button>

                                @if($currentPath)
                                    @foreach(explode('/', $currentPath) as $index => $folder)
                                        <span class="text-slate-300">/</span>
                                        @php $pathSoFar = implode('/', array_slice(explode('/', $currentPath), 0, $index + 1)); @endphp
                                        <button wire:click="navigateTo('{{ $pathSoFar }}')" class="px-2 py-1 rounded hover:bg-white hover:shadow-sm transition text-slate-600 hover:text-emerald-600">
                                            {{ $folder }}
                                        </button>
                                    @endforeach
                                @endif
                            </div>

                            @if ($project->user_id === auth()->id() && $project->files->count() > 0 && !$currentPath)
                                <button wire:click="confirmDeleteAll" class="text-xs text-red-500 hover:text-red-700 hover:bg-red-50 px-3 py-1.5 rounded-lg transition font-bold">
                                    <i class="fa-solid fa-trash-can mr-1"></i> حذف الكل
                                </button>
                            @endif
                        </div>

                        {{-- Back Button --}}
                        @if($currentPath)
                            <div class="px-2 py-1 bg-slate-50/30 border-b border-slate-100">
                                <button wire:click="navigateUp" class="w-full text-right px-3 py-2 text-sm text-slate-500 hover:text-emerald-600 hover:bg-white rounded-lg transition flex items-center gap-2">
                                    <i class="fa-solid fa-turn-up text-xs"></i> عودة للمجلد السابق
                                </button>
                            </div>
                        @endif

                        {{-- Files List --}}
                        <div class="divide-y divide-slate-100">
                            @forelse($this->browserItems as $item)
                                <div class="flex items-center justify-between px-5 py-3.5 hover:bg-slate-50 transition-colors group cursor-default">
                                    <div class="flex items-center gap-4 min-w-0">
                                        {{-- Icon --}}
                                        <div class="text-xl shrink-0">
                                            @if($item['type'] == 'folder')
                                                <i class="fa-solid fa-folder text-blue-400 drop-shadow-sm"></i>
                                            @else
                                                <i class="fa-regular fa-file-code text-slate-400 group-hover:text-emerald-500 transition-colors"></i>
                                            @endif
                                        </div>

                                        {{-- Name & Meta --}}
                                        <div class="min-w-0">
                                            @if($item['type'] == 'folder')
                                                <button wire:click="navigateTo('{{ $item['path'] }}')" class="text-sm font-bold text-slate-800 hover:text-blue-600 hover:underline truncate block text-left font-mono" dir="ltr">
                                                    {{ $item['name'] }}
                                                </button>
                                            @else
                                                <a href="{{ route('dashboard.files.view', ['project' => $project->slug, 'file' => $item['file_id']]) }}" class="text-sm font-semibold text-slate-700 hover:text-emerald-600 hover:underline truncate block text-left font-mono" dir="ltr">
                                                    {{ $item['name'] }}
                                                </a>
                                            @endif

                                            <div class="text-[10px] text-slate-400 mt-1 flex items-center gap-2">
                                                <span>{{ $item['last_modified']->diffForHumans() }}</span>
                                                @if($item['type'] == 'file')
                                                    <span class="w-0.5 h-2.5 bg-slate-200"></span>
                                                    <span>{{ $item['size'] }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Actions --}}
                                    <div class="flex items-center gap-1 opacity-0 group-hover:opacity-100 transition-all transform translate-x-2 group-hover:translate-x-0">
                                        @if($item['type'] == 'file')
                                            <button wire:click="downloadFile({{ $item['file_id'] }})" class="w-8 h-8 flex items-center justify-center rounded-lg text-slate-400 hover:text-emerald-600 hover:bg-emerald-50 transition" title="تحميل">
                                                <i class="fa-solid fa-download"></i>
                                            </button>
                                            @if ($project->user_id === auth()->id())
                                                <button wire:click="confirmDeleteFile({{ $item['file_id'] }})" class="w-8 h-8 flex items-center justify-center rounded-lg text-slate-400 hover:text-red-600 hover:bg-red-50 transition" title="حذف">
                                                    <i class="fa-regular fa-trash-can"></i>
                                                </button>
                                            @endif
                                        @endif
                                    </div>
                                </div>
                            @empty
                                <div class="py-12 flex flex-col items-center justify-center text-center">
                                    <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mb-3">
                                        <i class="fa-regular fa-folder-open text-3xl text-slate-300"></i>
                                    </div>
                                    <p class="text-slate-500 font-medium">المجلد فارغ</p>
                                </div>
                            @endforelse
                        </div>
                    </div>

                    {{-- README Viewer --}}
                    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden mt-8" id="readme-section">
                        <div class="bg-slate-50/80 backdrop-blur-sm px-5 py-3 border-b border-slate-200 flex items-center justify-between sticky top-0 z-10">
                            <div class="flex items-center gap-2 font-bold text-slate-700 text-sm">
                                <i class="fa-solid fa-book-open text-emerald-500"></i>
                                <span class="font-mono">README.md</span>
                            </div>
                            @if($project->user_id === auth()->id())
                                <div>
                                    @if($isEditingReadme)
                                        <div class="flex gap-2">
                                            <button wire:click="cancelEditReadme" class="px-3 py-1.5 text-xs font-bold text-slate-600 hover:bg-slate-200 rounded-lg transition">إلغاء</button>
                                            <button wire:click="saveReadme" class="px-3 py-1.5 text-xs font-bold bg-emerald-600 text-white hover:bg-emerald-700 rounded-lg shadow-sm transition">حفظ</button>
                                        </div>
                                    @else
                                        <button wire:click="editReadme" class="text-xs font-bold text-slate-500 hover:text-emerald-600 hover:bg-white border border-transparent hover:border-slate-200 px-3 py-1.5 rounded-lg transition flex items-center gap-1">
                                            <i class="fa-solid fa-pencil"></i> تعديل
                                        </button>
                                    @endif
                                </div>
                            @endif
                        </div>

                        <div class="relative min-h-[150px]">
                            @if($isEditingReadme)
                                <div class="flex flex-col h-full">
                                    <div class="bg-yellow-50 px-4 py-2 text-xs text-yellow-800 border-b border-yellow-100 flex items-center gap-2">
                                        <i class="fa-solid fa-lightbulb"></i>
                                        <span>نصيحة: يمكنك استخدام <b>Markdown</b> للتنسيق و <b>LaTeX</b> للمعادلات.</span>
                                    </div>
                                    <textarea wire:model="readmeContent" class="w-full p-6 focus:outline-none font-mono text-sm text-slate-800 bg-white resize-y min-h-[400px] leading-relaxed" placeholder="# اكتب وثائق مشروعك هنا..."></textarea>
                                </div>
                            @else
                                @if($project->readme_content)
                                    <div wire:ignore.self
                                         wire:key="readme-viewer-{{ now()->timestamp }}"
                                         class="markdown-body p-8 bg-white text-left dir-ltr"
                                         x-data="{
                                             rawContent: @js($project->readme_content),
                                             render() {
                                                 const md = window.markdownit({ html: true, linkify: true, typographer: true,
                                                     highlight: (str, lang) => {
                                                         if (lang && hljs.getLanguage(lang)) { return `<pre class='hljs'><code>${hljs.highlight(str, { language: lang }).value}</code></pre>`; }
                                                         return '';
                                                     }
                                                 });
                                                 if (window.markdownitKatex) { md.use(window.markdownitKatex, { throwOnError: false, errorColor: '#cc0000' }); }
                                                 $el.innerHTML = md.render(this.rawContent);
                                             }
                                         }"
                                         x-init="render()">
                                        <div class="flex items-center gap-2 text-slate-400 py-10 justify-center">
                                            <i class="fa-solid fa-spinner animate-spin"></i> جاري التحميل...
                                        </div>
                                    </div>
                                @else
                                    <div class="py-16 text-center">
                                        <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4 border border-slate-100 shadow-sm">
                                            <i class="fa-solid fa-file-circle-plus text-3xl text-slate-300"></i>
                                        </div>
                                        <h3 class="text-slate-900 font-bold mb-1">مشروعك يستحق التوثيق</h3>
                                        <p class="text-slate-500 text-sm mb-4">أضف ملف README لمساعدة الآخرين على فهم مشروعك.</p>
                                        @if($project->user_id === auth()->id())
                                            <button wire:click="editReadme" class="bg-emerald-600 text-white px-5 py-2 rounded-xl text-sm font-bold hover:bg-emerald-700 transition shadow-lg shadow-emerald-500/20">
                                                إنشاء ملف README
                                            </button>
                                        @endif
                                    </div>
                                @endif
                            @endif
                        </div>
                    </div>

                {{-- TAB 2: SETTINGS --}}
                @elseif ($activeTab === 'settings')
                    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-8">
                        <div class="border-b border-slate-100 pb-6 mb-6">
                            <h2 class="font-bold text-slate-900 text-xl">إعدادات المشروع</h2>
                            <p class="text-slate-500 text-sm mt-1">تحكم في هوية المشروع وخصوصيته.</p>
                        </div>

                        <form wire:submit="updateProject" class="space-y-6 max-w-2xl">
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2">اسم المشروع</label>
                                <input wire:model="edit_title" type="text" class="w-full bg-slate-50 border border-slate-200 rounded-xl py-3 px-4 focus:ring-2 focus:ring-emerald-500 focus:bg-white outline-none transition font-medium dir-ltr placeholder:text-slate-400">
                                @error('edit_title') <span class="text-red-500 text-xs mt-1 block font-bold">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2">الوصف</label>
                                <textarea wire:model="edit_description" rows="4" class="w-full bg-slate-50 border border-slate-200 rounded-xl py-3 px-4 focus:ring-2 focus:ring-emerald-500 focus:bg-white outline-none transition resize-none placeholder:text-slate-400"></textarea>
                            </div>

                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-3">الخصوصية (Visibility)</label>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <label class="relative flex items-start p-4 border rounded-xl cursor-pointer transition-all duration-200 group
                                        {{ $edit_visibility === 'public' ? 'border-emerald-500 ring-1 ring-emerald-500 bg-emerald-50/50' : 'border-slate-200 hover:bg-slate-50' }}">
                                        <div class="flex items-center h-5">
                                            <input type="radio" wire:model="edit_visibility" value="public" class="w-4 h-4 text-emerald-600 border-gray-300 focus:ring-emerald-500">
                                        </div>
                                        <div class="mr-3">
                                            <span class="font-bold text-slate-900 block text-sm">عام (Public)</span>
                                            <span class="text-slate-500 text-xs mt-0.5 block">متاح للجميع للاطلاع والاستنساخ.</span>
                                        </div>
                                    </label>

                                    <label class="relative flex items-start p-4 border rounded-xl cursor-pointer transition-all duration-200 group
                                        {{ $edit_visibility === 'private' ? 'border-emerald-500 ring-1 ring-emerald-500 bg-emerald-50/50' : 'border-slate-200 hover:bg-slate-50' }}">
                                        <div class="flex items-center h-5">
                                            <input type="radio" wire:model="edit_visibility" value="private" class="w-4 h-4 text-emerald-600 border-gray-300 focus:ring-emerald-500">
                                        </div>
                                        <div class="mr-3">
                                            <span class="font-bold text-slate-900 block text-sm">خاص (Private)</span>
                                            <span class="text-slate-500 text-xs mt-0.5 block">سري ومتاح لك وللفريق فقط.</span>
                                        </div>
                                    </label>
                                </div>
                            </div>

                            <div class="pt-4">
                                <button type="submit" class="bg-slate-900 text-white px-8 py-3 rounded-xl text-sm font-bold hover:bg-emerald-600 transition shadow-lg hover:shadow-emerald-500/30 flex items-center gap-2">
                                    <span wire:loading.remove wire:target="updateProject">حفظ التغييرات</span>
                                    <span wire:loading wire:target="updateProject"><i class="fa-solid fa-spinner animate-spin"></i> جاري الحفظ...</span>
                                </button>
                            </div>
                        </form>
                    </div>

                    {{-- Danger Zone --}}
                    @if ($this->currentRole ?? 'owner' === 'owner')
                        <div class="mt-8 border border-red-200 rounded-2xl overflow-hidden bg-white">
                            <div class="bg-red-50/50 px-8 py-4 border-b border-red-100 flex items-center gap-2">
                                <i class="fa-solid fa-triangle-exclamation text-red-500"></i>
                                <h3 class="font-bold text-red-800 text-sm">منطقة الخطر</h3>
                            </div>
                            <div class="p-8 flex flex-col sm:flex-row sm:items-center justify-between gap-6">
                                <div>
                                    <h4 class="font-bold text-slate-900 text-sm">حذف المستودع نهائياً</h4>
                                    <p class="text-slate-500 text-xs mt-1 max-w-sm">سيتم حذف الكود، الملفات، وتاريخ الإصدارات بالكامل. لا يمكن التراجع عن هذا الإجراء.</p>
                                </div>
                                <button onclick="confirm('هل أنت متأكد تماماً؟ هذا الإجراء لا يمكن التراجع عنه.') || event.stopImmediatePropagation()"
                                        wire:click="deleteProject"
                                        class="bg-white text-red-600 border border-red-200 px-5 py-2.5 rounded-xl text-xs font-bold hover:bg-red-600 hover:text-white hover:border-red-600 transition shadow-sm whitespace-nowrap">
                                    حذف المشروع
                                </button>
                            </div>
                        </div>
                    @endif

                {{-- TAB 3: TEAM --}}
                @elseif ($activeTab === 'team')
                    <livewire:dashboard.projects.team :project="$project" />
                @endif

            </div>
        </div>
    </div>

    {{-- Delete Modal --}}
    <x-modals.confirm-delete
        id="file"
        title="تأكيد حذف الملف"
        :message="$deleteModalMessage"
        confirm-text="نعم، احذف"
        type="danger"
        wire:click="deleteFileConfirmed"
    />
</div>
