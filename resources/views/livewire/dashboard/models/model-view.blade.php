<div class="flex flex-col h-full bg-[#f8fafc] min-h-screen animate-fade-in">

    {{-- ================================================= --}}
    {{--             1. ASSETS & GLOBAL STYLES             --}}
    {{-- ================================================= --}}
    @assets
        <script src="https://cdn.jsdelivr.net/npm/markdown-it@13.0.1/dist/markdown-it.min.js"></script>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/katex@0.16.8/dist/katex.min.css">
        <script src="https://cdn.jsdelivr.net/npm/markdown-it-katex@2.0.3/dist/markdown-it-katex.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/styles/github-dark.min.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/highlight.min.js"></script>
        <style>
            .markdown-body { font-family: 'Inter', sans-serif; color: #334155; line-height: 1.7; }
            .markdown-body h1, .markdown-body h2 { margin-top: 24px; margin-bottom: 16px; font-weight: 700; color: #0f172a; }
            .markdown-body h1 { font-size: 1.8em; border-bottom: 1px solid #e2e8f0; padding-bottom: .3em; }
            .markdown-body a { color: #059669; text-decoration: none; font-weight: 500; }
            .markdown-body a:hover { text-decoration: underline; }
            .markdown-body pre { background-color: #0f172a; border-radius: 12px; padding: 20px; overflow: auto; border: 1px solid #1e293b; direction: ltr; text-align: left; }
            .markdown-body code { background-color: #f1f5f9; padding: .2em .4em; border-radius: 6px; font-size: 85%; color: #ef4444; font-family: monospace; }
            .markdown-body img { max-width: 100%; border-radius: 8px; border: 1px solid #e2e8f0; }
        </style>
    @endassets

    {{-- ================================================= --}}
    {{--             2. MAIN CONTENT AREA                  --}}
    {{-- ================================================= --}}

    {{-- Sticky Header --}}
    <div class="sticky top-0 z-40 bg-white/95 backdrop-blur-md border-b border-slate-200 shadow-sm w-full transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row md:items-center justify-between py-4 gap-4">

                {{-- Title & Meta --}}
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-indigo-50 to-purple-50 border border-indigo-100 flex items-center justify-center text-indigo-600 shadow-sm shrink-0">
                        <i class="fa-solid fa-brain text-2xl"></i>
                    </div>
                    <div>
                        <h1 class="text-xl md:text-2xl font-bold text-slate-900 flex items-center gap-3">
                            <span class="tracking-tight font-sans">{{ $model->title }}</span>
                            <span class="px-2.5 py-0.5 rounded-full text-[10px] md:text-xs font-bold uppercase tracking-wider border
                                {{ $model->is_public ? 'bg-emerald-50 text-emerald-700 border-emerald-100' : 'bg-amber-50 text-amber-700 border-amber-100' }}">
                                {{ $model->is_public ? 'Public' : 'Private' }}
                            </span>
                        </h1>
                        <div class="flex items-center gap-3 text-xs text-slate-500 mt-1 font-medium">
                            <span class="flex items-center gap-1"><i class="fa-solid fa-layer-group text-slate-400"></i> {{ $model->framework }}</span>
                            <span class="w-1 h-1 rounded-full bg-slate-300"></span>
                            <span class="flex items-center gap-1"><i class="fa-solid fa-code-branch text-slate-400"></i> {{ $model->task }}</span>
                        </div>
                    </div>
                </div>

                {{-- Actions --}}
                <div class="flex items-center gap-3">
                    <button wire:click="downloadAll" wire:loading.attr="disabled" class="bg-white border border-slate-200 text-slate-700 hover:text-indigo-700 hover:border-indigo-200 px-4 py-2 rounded-xl text-xs font-bold transition-all shadow-sm hover:shadow-md flex items-center gap-2">
                        <span wire:loading.remove wire:target="downloadAll"><i class="fa-solid fa-download"></i></span>
                        <span wire:loading wire:target="downloadAll"><i class="fa-solid fa-spinner animate-spin"></i></span>
                        <span>تحميل الكل</span>
                    </button>

                     @if(Auth::id() === $model->user_id)
                        <button wire:click="$set('activeTab', 'settings')" class="bg-slate-900 text-white px-4 py-2 rounded-xl text-xs font-bold hover:bg-indigo-600 transition-all shadow-lg hover:shadow-indigo-500/30 flex items-center gap-2">
                            <i class="fa-solid fa-pen-to-square"></i> <span>تعديل</span>
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- Main Content --}}
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
            <div class="lg:col-span-1 space-y-6 sticky top-28">
                <nav class="space-y-2">
                    <button wire:click="$set('activeTab', 'readme')"
                        class="w-full flex items-center gap-3 px-4 py-3 rounded-xl font-bold text-sm transition-all duration-300 group relative overflow-hidden
                        {{ $activeTab === 'readme' ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-500/30' : 'bg-white text-slate-600 hover:bg-slate-50 border border-slate-200' }}">
                        <i class="fa-regular fa-file-lines w-5 text-center {{ $activeTab === 'readme' ? 'text-indigo-200' : 'text-slate-400 group-hover:text-indigo-600' }}"></i>
                        <span>بطاقة النموذج</span>
                    </button>

                    <button wire:click="$set('activeTab', 'files')"
                        class="w-full flex items-center gap-3 px-4 py-3 rounded-xl font-bold text-sm transition-all duration-300 group
                        {{ $activeTab === 'files' ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-500/30' : 'bg-white text-slate-600 hover:bg-slate-50 border border-slate-200' }}">
                        <i class="fa-solid fa-folder-open w-5 text-center {{ $activeTab === 'files' ? 'text-indigo-200' : 'text-slate-400 group-hover:text-indigo-600' }}"></i>
                        <span>ملفات النموذج</span>
                    </button>

                    @if (Auth::id() === $model->user_id)
                        <button wire:click="$set('activeTab', 'settings')"
                            class="w-full flex items-center gap-3 px-4 py-3 rounded-xl font-bold text-sm transition-all duration-300 group
                            {{ $activeTab === 'settings' ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-500/30' : 'bg-white text-slate-600 hover:bg-slate-50 border border-slate-200' }}">
                            <i class="fa-solid fa-gear w-5 text-center {{ $activeTab === 'settings' ? 'text-indigo-200' : 'text-slate-400 group-hover:text-indigo-600' }}"></i>
                            <span>الإعدادات</span>
                        </button>
                    @endif
                </nav>

                <div class="bg-white rounded-xl border border-slate-200 p-5 shadow-sm">
                    <h3 class="font-bold text-slate-900 text-xs uppercase tracking-wider mb-4 border-b border-slate-100 pb-2">معلومات تقنية</h3>
                    <div class="space-y-4">
                        <div>
                            <span class="block text-xs text-slate-400 mb-1">الترخيص (License)</span>
                            <span class="inline-flex items-center gap-1 bg-slate-100 text-slate-700 px-2 py-1 rounded text-xs font-bold font-mono">
                                <i class="fa-solid fa-scale-balanced text-slate-400"></i> {{ $model->license ?? 'MIT' }}
                            </span>
                        </div>
                        <div>
                            <span class="block text-xs text-slate-400 mb-1">اللغة</span>
                            <span class="text-sm font-bold text-slate-800">{{ $model->language }}</span>
                        </div>
                        <div class="flex justify-between items-center pt-2 border-t border-slate-50">
                            <span class="text-xs text-slate-500">التنزيلات</span>
                            <span class="font-bold text-slate-900 font-sans text-sm">{{ number_format($model->downloads_count ?? 0) }}</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- MAIN CONTENT --}}
            <div class="lg:col-span-3 space-y-8">

                {{-- TAB 1: MODEL CARD (README) --}}
                @if ($activeTab === 'readme')
                    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                        <div class="bg-slate-50/80 backdrop-blur-sm px-6 py-4 border-b border-slate-200 flex items-center justify-between sticky top-0 z-10">
                            <div class="flex items-center gap-2 font-bold text-slate-800 text-sm">
                                <i class="fa-solid fa-book-open text-indigo-500"></i>
                                <span class="font-mono">Model Card</span>
                            </div>
                            @if(Auth::id() === $model->user_id)
                                <div>
                                    @if($isEditingReadme)
                                        <div class="flex gap-2">
                                            <button wire:click="cancelEditReadme" class="px-3 py-1.5 text-xs font-bold text-slate-600 hover:bg-slate-200 rounded-lg transition">إلغاء</button>
                                            <button wire:click="saveReadme" class="px-3 py-1.5 text-xs font-bold bg-indigo-600 text-white hover:bg-indigo-700 rounded-lg shadow-sm transition">حفظ</button>
                                        </div>
                                    @else
                                        <button wire:click="editReadme" class="text-xs font-bold text-slate-500 hover:text-indigo-600 hover:bg-white border border-transparent hover:border-slate-200 px-3 py-1.5 rounded-lg transition flex items-center gap-1">
                                            <i class="fa-solid fa-pencil"></i> تعديل
                                        </button>
                                    @endif
                                </div>
                            @endif
                        </div>

                        <div class="relative min-h-[300px]">
                            @if($isEditingReadme)
                                <div class="flex flex-col h-full">
                                    <div class="bg-amber-50 px-4 py-2 text-xs text-amber-800 border-b border-amber-100 flex items-center gap-2">
                                        <i class="fa-solid fa-lightbulb"></i>
                                        <span>نصيحة: استخدم <b>Markdown</b> للتنسيق.</span>
                                    </div>
                                    <textarea wire:model="readmeContent" class="w-full p-6 focus:outline-none font-mono text-sm text-slate-800 bg-white resize-y min-h-[500px] leading-relaxed" placeholder="# Model Card..."></textarea>
                                </div>
                            @else
                                @if($model->readme_content)
                                    {{--
                                        🔥 الإصلاح هنا:
                                        1. فصلنا الـ x-data عن الـ div الذي يتم تعديل الـ innerHTML له.
                                        2. استخدمنا wire:ignore على الحاوية التي يعرض فيها الماركداون.
                                    --}}
                                    <div x-data="{
                                            rawContent: @js($model->readme_content),
                                            render() {
                                                const md = window.markdownit({
                                                    html: true, linkify: true, typographer: true,
                                                    highlight: (str, lang) => {
                                                        if (lang && hljs.getLanguage(lang)) { return `<pre class='hljs'><code>${hljs.highlight(str, { language: lang }).value}</code></pre>`; }
                                                        return '';
                                                    }
                                                });
                                                if (window.markdownitKatex) { md.use(window.markdownitKatex, { throwOnError: false, errorColor: '#cc0000' }); }

                                                // نكتب النتيجة في العنصر المنفصل
                                                $refs.output.innerHTML = md.render(this.rawContent);
                                            }
                                         }"
                                         x-init="render(); Livewire.on('readme-updated', () => render())"
                                         class="bg-white text-left dir-ltr">

                                        {{-- هذا الديف هو الذي سيحتوي على HTML الماركداون، وعليه wire:ignore --}}
                                        <div x-ref="output" wire:ignore class="markdown-body p-8">
                                            <div class="flex items-center justify-center py-12 text-slate-300">
                                                <i class="fa-solid fa-circle-notch animate-spin text-2xl"></i>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <div class="py-16 text-center">
                                        <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4 border border-slate-100 shadow-sm">
                                            <i class="fa-solid fa-file-circle-plus text-3xl text-slate-300"></i>
                                        </div>
                                        <h3 class="text-slate-900 font-bold mb-1">مشروعك يستحق التوثيق</h3>
                                        <p class="text-slate-500 text-sm mb-4">أضف ملف README لمساعدة الآخرين على فهم مشروعك.</p>
                                        @if($model->user_id === auth()->id())
                                            <button wire:click="editReadme" class="bg-indigo-600 text-white px-5 py-2 rounded-xl text-sm font-bold hover:bg-indigo-700 transition shadow-lg shadow-indigo-500/20">
                                                إنشاء ملف README
                                            </button>
                                        @endif
                                    </div>
                                @endif
                            @endif
                        </div>
                    </div>

                {{-- TAB 2: FILES --}}
                @elseif ($activeTab === 'files')
                    <div class="space-y-6">
                        @if (Auth::id() === $model->user_id)
                            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6"
                                 x-data="{ isUploading: false, progress: 0, isDragging: false }"
                                 x-on:livewire-upload-start="isUploading = true; progress = 0"
                                 x-on:livewire-upload-finish="isUploading = false"
                                 x-on:livewire-upload-error="isUploading = false"
                                 x-on:livewire-upload-progress="progress = $event.detail.progress">

                                <div class="relative border-2 border-dashed rounded-xl p-8 text-center cursor-pointer transition-all duration-300 group"
                                     :class="isDragging ? 'border-indigo-500 bg-indigo-50' : 'border-slate-300 hover:border-indigo-400 hover:bg-slate-50'"
                                     @dragover.prevent="isDragging = true" @dragleave.prevent="isDragging = false" @drop.prevent="isDragging = false">

                                    <form wire:submit="uploadFiles">
                                        <input wire:model="newFiles" type="file" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10" multiple>

                                        <div class="w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-4 transition-transform group-hover:scale-110" :class="isDragging ? 'bg-indigo-100 text-indigo-600' : 'text-slate-400'">
                                            <i class="fa-solid fa-cloud-arrow-up text-3xl"></i>
                                        </div>

                                        <div x-show="!isUploading">
                                            <h3 class="font-bold text-slate-800 text-lg mb-1">اضغط أو اسحب الملفات هنا</h3>
                                            <p class="text-slate-500 text-sm">ندعم ملفات .h5, .pt, .onnx, .json وغيرها.</p>
                                        </div>

                                        <div x-show="isUploading" style="display: none;" class="mt-4 max-w-xs mx-auto">
                                            <div class="flex justify-between text-xs font-bold text-slate-500 mb-1">
                                                <span>جاري الرفع...</span>
                                                <span x-text="progress + '%'"></span>
                                            </div>
                                            <div class="h-1.5 w-full bg-slate-200 rounded-full overflow-hidden">
                                                <div class="h-full bg-indigo-600 transition-all duration-300 rounded-full" :style="'width: ' + progress + '%'"></div>
                                            </div>
                                        </div>

                                        @if ($newFiles)
                                            <div class="mt-6 relative z-20" x-show="!isUploading">
                                                <button type="submit" wire:loading.attr="disabled" class="bg-indigo-600 text-white px-8 py-2.5 rounded-xl font-bold hover:bg-indigo-700 transition shadow-lg shadow-indigo-500/30 flex items-center gap-2 mx-auto">
                                                    <i class="fa-solid fa-check"></i> رفع {{ count($newFiles) }} ملف
                                                </button>
                                            </div>
                                        @endif
                                    </form>
                                </div>
                            </div>
                        @endif

                        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                            <div class="bg-slate-50/50 px-6 py-4 border-b border-slate-200 flex justify-between items-center">
                                <h3 class="font-bold text-slate-800 text-sm flex items-center gap-2">
                                    <i class="fa-solid fa-folder-tree text-slate-400"></i> ملفات النموذج
                                </h3>
                                <span class="text-xs font-bold bg-slate-200 text-slate-600 px-2 py-1 rounded-md">{{ $model->files->count() }} ملفات</span>
                            </div>
                            <div class="divide-y divide-slate-100">
                                @forelse($model->files as $file)
                                    <div class="flex items-center justify-between px-6 py-4 hover:bg-slate-50 transition-colors group">
                                        <div class="flex items-center gap-4 min-w-0">
                                            <div class="w-10 h-10 rounded-lg bg-slate-100 flex items-center justify-center text-slate-500 shrink-0">
                                                <i class="fa-regular fa-file-code text-xl"></i>
                                            </div>
                                            <div class="min-w-0">
                                                <span class="block text-sm font-bold text-slate-900 truncate" dir="ltr">{{ $file->filename }}</span>
                                                <div class="flex items-center gap-3 text-xs text-slate-400 mt-0.5 font-medium">
                                                    <span>{{ number_format($file->size / 1024, 2) }} KB</span>
                                                    <span class="w-1 h-1 rounded-full bg-slate-300"></span>
                                                    <span>{{ $file->created_at->diffForHumans() }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="flex items-center gap-1 opacity-0 group-hover:opacity-100 transition-all transform translate-x-2 group-hover:translate-x-0">
                                            <button wire:click="downloadFile({{ $file->id }})" class="w-8 h-8 flex items-center justify-center rounded-lg text-slate-400 hover:text-indigo-600 hover:bg-indigo-50 transition" title="تحميل"><i class="fa-solid fa-download"></i></button>
                                            @if (Auth::id() === $model->user_id)
                                                <button wire:click="deleteFile({{ $file->id }})" wire:confirm="حذف الملف؟" class="w-8 h-8 flex items-center justify-center rounded-lg text-slate-400 hover:text-red-600 hover:bg-red-50 transition" title="حذف"><i class="fa-regular fa-trash-can"></i></button>
                                            @endif
                                        </div>
                                    </div>
                                @empty
                                    <div class="py-12 flex flex-col items-center justify-center text-center">
                                        <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mb-3"><i class="fa-regular fa-folder-open text-3xl text-slate-300"></i></div>
                                        <p class="text-slate-500 font-medium text-sm">المجلد فارغ</p>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>

                {{-- TAB 3: SETTINGS --}}
                @elseif ($activeTab === 'settings')
                    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-8">
                        <div class="border-b border-slate-100 pb-6 mb-6">
                            <h2 class="font-bold text-slate-900 text-xl">إعدادات النموذج</h2>
                            <p class="text-slate-500 text-sm mt-1">تعديل البيانات الأساسية والتحكم في الوصول.</p>
                        </div>
                        <form wire:submit="updateModelSettings" class="space-y-6 max-w-2xl">
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2">اسم النموذج</label>
                                <input wire:model="edit_title" type="text" class="w-full bg-slate-50 border border-slate-200 rounded-xl py-3 px-4 focus:ring-2 focus:ring-indigo-500 focus:bg-white outline-none transition font-medium dir-ltr placeholder:text-slate-400">
                                @error('edit_title') <span class="text-red-500 text-xs mt-1 block font-bold">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2">الوصف المختصر</label>
                                <textarea wire:model="edit_description" rows="3" class="w-full bg-slate-50 border border-slate-200 rounded-xl py-3 px-4 focus:ring-2 focus:ring-indigo-500 focus:bg-white outline-none transition resize-none placeholder:text-slate-400"></textarea>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-bold text-slate-700 mb-2">المهمة (Task)</label>
                                    <div class="relative">
                                        <select wire:model="edit_task" class="w-full appearance-none bg-slate-50 border border-slate-200 rounded-xl py-3 px-4 pr-10 focus:ring-2 focus:ring-indigo-500 focus:bg-white outline-none transition cursor-pointer font-medium text-slate-700">
                                            <option value="" disabled>اختر...</option>
                                            <option value="Text Generation">Text Generation</option>
                                            <option value="Image Generation">Image Generation</option>
                                            <option value="Translation">Translation</option>
                                            <option value="Speech Recognition">Speech Recognition</option>
                                            <option value="Object Detection">Object Detection</option>
                                        </select>
                                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-slate-500"><i class="fa-solid fa-chevron-down text-xs"></i></div>
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-sm font-bold text-slate-700 mb-2">الترخيص (License)</label>
                                    <input wire:model="edit_license" type="text" placeholder="e.g. MIT, Apache 2.0" class="w-full bg-slate-50 border border-slate-200 rounded-xl py-3 px-4 focus:ring-2 focus:ring-indigo-500 focus:bg-white outline-none transition dir-ltr">
                                </div>
                            </div>
                            <hr class="border-slate-100 my-6">
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-4">الخصوصية (Visibility)</label>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <label class="relative flex items-start p-4 border rounded-xl cursor-pointer transition-all duration-200 group {{ $edit_visibility === 'public' ? 'border-indigo-500 ring-1 ring-indigo-500 bg-indigo-50/50' : 'border-slate-200 hover:bg-slate-50' }}">
                                        <div class="flex items-center h-5"><input type="radio" wire:model="edit_visibility" value="public" class="w-4 h-4 text-indigo-600 border-gray-300 focus:ring-indigo-500"></div>
                                        <div class="mr-3"><span class="font-bold text-slate-900 block text-sm group-hover:text-indigo-700 transition">عام (Public)</span><span class="text-slate-500 text-xs mt-0.5 block">متاح للجميع للاطلاع والاستخدام.</span></div>
                                    </label>
                                    <label class="relative flex items-start p-4 border rounded-xl cursor-pointer transition-all duration-200 group {{ $edit_visibility === 'private' ? 'border-indigo-500 ring-1 ring-indigo-500 bg-indigo-50/50' : 'border-slate-200 hover:bg-slate-50' }}">
                                        <div class="flex items-center h-5"><input type="radio" wire:model="edit_visibility" value="private" class="w-4 h-4 text-indigo-600 border-gray-300 focus:ring-indigo-500"></div>
                                        <div class="mr-3"><span class="font-bold text-slate-900 block text-sm group-hover:text-indigo-700 transition">خاص (Private)</span><span class="text-slate-500 text-xs mt-0.5 block">سري ومتاح لك وللمصرح لهم فقط.</span></div>
                                    </label>
                                </div>
                            </div>
                            <div class="pt-6 flex justify-end">
                                <button type="submit" class="bg-slate-900 text-white px-8 py-3 rounded-xl text-sm font-bold hover:bg-indigo-600 transition shadow-lg shadow-indigo-500/20 flex items-center gap-2">
                                    <span wire:loading.remove wire:target="updateModelSettings">حفظ التغييرات</span>
                                    <span wire:loading wire:target="updateModelSettings"><i class="fa-solid fa-spinner animate-spin"></i> جاري الحفظ...</span>
                                </button>
                            </div>
                        </form>
                    </div>
                    @if (Auth::id() === $model->user_id)
                        <div class="mt-8 border border-red-200 rounded-2xl overflow-hidden bg-white shadow-sm">
                            <div class="bg-red-50/50 px-8 py-4 border-b border-red-100 flex items-center gap-2"><i class="fa-solid fa-triangle-exclamation text-red-500"></i><h3 class="font-bold text-red-800 text-sm">منطقة الخطر</h3></div>
                            <div class="p-8 flex flex-col sm:flex-row sm:items-center justify-between gap-6">
                                <div><h4 class="font-bold text-slate-900 text-sm">حذف النموذج نهائياً</h4><p class="text-slate-500 text-xs mt-1 max-w-sm">سيتم حذف جميع الإصدارات والملفات المرتبطة بهذا النموذج. لا يمكن التراجع عن هذا الإجراء.</p></div>
                                <button wire:click="deleteModel" wire:confirm="تحذير نهائي: هل أنت متأكد تماماً من حذف هذا النموذج؟ سيتم حذف جميع الملفات فوراً." class="bg-white text-red-600 border border-red-200 px-5 py-2.5 rounded-xl text-xs font-bold hover:bg-red-600 hover:text-white hover:border-red-600 transition shadow-sm whitespace-nowrap">حذف النموذج</button>
                            </div>
                        </div>
                    @endif
                @endif

            </div>
        </div>
    </div>
</div>
