<div class="flex flex-col h-full overflow-hidden bg-slate-50">

    {{-- ================================================= --}}
    {{--             ASSETS & STYLES                       --}}
    {{-- ================================================= --}}
    @assets
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/styles/github.min.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/highlight.min.js"></script>

        <style>
            /* Scrollbars */
            .code-scroll::-webkit-scrollbar { height: 8px; width: 8px; }
            .code-scroll::-webkit-scrollbar-track { background: #f1f5f9; }
            .code-scroll::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 4px; }
            .code-scroll::-webkit-scrollbar-thumb:hover { background: #94a3b8; }

            /* UX Helpers */
            .line-numbers { user-select: none; }
            .font-mono { font-family: 'Fira Code', monospace; }
        </style>
    @endassets

    {{-- Re-init Highlight.js on Livewire updates --}}
    @script
    <script>
        Livewire.hook('morph.updated', ({ el, component }) => {
            hljs.highlightAll();
        });
        hljs.highlightAll();
    </script>
    @endscript

    {{-- ================================================= --}}
    {{--                 HEADER & NAVIGATION               --}}
    {{-- ================================================= --}}
    <header class="h-16 bg-white border-b border-slate-200 flex items-center justify-between px-8 sticky top-0 z-10 shadow-sm">
        <div class="flex items-center gap-2 text-sm font-medium">
            <a href="{{ route('projects.show', ['username' => $project->user->username, 'slug' => $project->slug]) }}" class="text-slate-500 hover:text-emerald-600 transition">
                {{ $project->user->username }}
            </a>
            <span class="text-slate-300">/</span>
            <a href="{{ route('projects.show', ['username' => $project->user->username, 'slug' => $project->slug]) }}" class="text-slate-900 font-bold font-sans hover:underline">
                {{ $project->title }}
            </a>
        </div>

        <div class="flex gap-1 bg-slate-100 p-1 rounded-lg border border-slate-200">
            {{-- زر History متاح للجميع --}}
            <button wire:click="setMode('blame')"
                class="px-3 py-1.5 text-xs font-bold rounded-md transition flex items-center gap-1 {{ $mode === 'blame' ? 'bg-white text-emerald-700 shadow-sm' : 'text-slate-500 hover:text-slate-700 hover:bg-slate-200/50' }}">
                <i class="fa-solid fa-clock-rotate-left"></i> History
            </button>

            {{-- أزرار الكود والتغييرات تظهر فقط للملفات النصية --}}
            @if($fileType === 'text')
                <button wire:click="setMode('diff')"
                    class="px-3 py-1.5 text-xs font-bold rounded-md transition flex items-center gap-1 {{ $mode === 'diff' ? 'bg-white text-emerald-700 shadow-sm' : 'text-slate-500 hover:text-slate-700 hover:bg-slate-200/50' }}">
                    <i class="fa-solid fa-code-compare"></i> Changes
                </button>

                <button wire:click="setMode('code')"
                    class="px-3 py-1.5 text-xs font-bold rounded-md transition flex items-center gap-1 {{ $mode === 'code' ? 'bg-white text-emerald-700 shadow-sm' : 'text-slate-500 hover:text-slate-700 hover:bg-slate-200/50' }}">
                    <i class="fa-solid fa-code"></i> Code
                </button>
            @else
                {{-- زر المعاينة للملفات الأخرى --}}
                <button wire:click="setMode('preview')"
                    class="px-3 py-1.5 text-xs font-bold rounded-md transition flex items-center gap-1 {{ $mode === 'preview' ? 'bg-white text-emerald-700 shadow-sm' : 'text-slate-500 hover:text-slate-700 hover:bg-slate-200/50' }}">
                    <i class="fa-solid fa-eye"></i> Preview
                </button>
            @endif
        </div>
    </header>

    {{-- ================================================= --}}
    {{--                 MAIN CONTENT AREA                 --}}
    {{-- ================================================= --}}
    <div class="flex-1 overflow-y-auto p-6 bg-slate-50">
        <div class="max-w-7xl mx-auto space-y-6">

            {{-- Breadcrumbs --}}
            <div class="flex items-center gap-2 text-sm font-sans font-medium text-slate-600" dir="ltr">
                <span class="font-bold text-emerald-700">{{ $project->title }}</span>
                <span class="text-slate-300">/</span>
                <span class="font-bold text-slate-900 bg-white px-2 py-0.5 rounded border border-slate-200 shadow-sm">{{ $file->filename }}</span>
            </div>

            {{-- ################################################# --}}
            {{--             MODE: PREVIEW (MEDIA FILES)           --}}
            {{-- ################################################# --}}
            @if($mode === 'preview' && $fileType !== 'text')
                <div class="bg-white border border-slate-200 rounded-xl overflow-hidden shadow-sm flex flex-col items-center justify-center p-8 min-h-[400px]">

                    @if($fileType === 'image')
                        <div class="border border-slate-200 p-2 bg-slate-50 rounded-lg">
                            <img src="{{ $fileUrl }}" class="max-w-full max-h-[600px] rounded" alt="{{ $file->filename }}">
                        </div>

                    @elseif($fileType === 'video')
                        <video controls class="max-w-full max-h-[600px] rounded-lg shadow-lg bg-black">
                            <source src="{{ $fileUrl }}" type="{{ Storage::disk('wasabi')->mimeType($file->path) }}">
                            المتصفح لا يدعم تشغيل الفيديو.
                        </video>

                    @elseif($fileType === 'audio')
                        <div class="bg-slate-50 p-12 rounded-full mb-6">
                            <i class="fa-solid fa-music text-6xl text-slate-300"></i>
                        </div>
                        <audio controls class="w-full max-w-md">
                            <source src="{{ $fileUrl }}" type="{{ Storage::disk('wasabi')->mimeType($file->path) }}">
                            المتصفح لا يدعم تشغيل الصوت.
                        </audio>

                    @elseif($fileType === 'pdf')
                         <iframe src="{{ $fileUrl }}" class="w-full h-[800px] rounded-lg border border-slate-200"></iframe>

                    @else
                        {{-- ملفات أخرى (Binary/Zip/Exe) --}}
                        <div class="text-center">
                            <div class="bg-slate-100 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-4">
                                <i class="fa-solid fa-file-arrow-down text-3xl text-slate-400"></i>
                            </div>
                            <h3 class="text-lg font-bold text-slate-800 mb-2">لا يمكن معاينة هذا الملف</h3>
                            <p class="text-slate-500 text-sm mb-6">هذا النوع من الملفات غير مدعوم للعرض المباشر.</p>
                            <a href="{{ $fileUrl }}" download class="bg-emerald-600 text-white px-6 py-2 rounded-lg text-sm font-bold hover:bg-emerald-700 transition">
                                <i class="fa-solid fa-download mr-2"></i> تحميل الملف ({{ $file->size_for_humans }})
                            </a>
                        </div>
                    @endif
                </div>
            @endif

            {{-- ################################################# --}}
            {{--                  MODE: CODE VIEW                  --}}
            {{-- ################################################# --}}
            @if($mode === 'code' && $fileType === 'text')
                <div class="bg-white border border-slate-200 rounded-xl overflow-hidden shadow-sm">

                    {{-- Toolbar --}}
                    <div class="bg-slate-50 border-b border-slate-200 px-4 py-3 flex flex-col sm:flex-row justify-between items-center gap-3">
                        <div class="flex items-center gap-3">
                            <div class="flex items-center gap-2 text-xs text-slate-500 font-mono">
                                <span class="font-bold text-slate-700">{{ count($lines) }}</span> lines
                                <span class="w-1 h-1 rounded-full bg-slate-300"></span>
                                <span>{{ $file->size_for_humans ?? '0 KB' }}</span>
                            </div>
                            @if($isEditing)
                                <span class="bg-amber-100 text-amber-700 text-[10px] font-bold px-2 py-0.5 rounded border border-amber-200 animate-pulse">
                                    وضع التعديل
                                </span>
                            @endif
                        </div>

                        <div class="flex items-center gap-1">
                            @if(!$isEditing)
                                <button class="px-3 py-1.5 text-xs font-medium text-slate-600 hover:text-slate-900 hover:bg-slate-200 rounded transition border border-slate-200 bg-white flex items-center gap-2">
                                    <i class="fa-regular fa-copy"></i> Copy
                                </button>

                                @if(auth()->id() === $project->user_id)
                                    <button wire:click="editMode" class="px-3 py-1.5 text-xs font-medium text-emerald-600 hover:text-emerald-700 hover:bg-emerald-50 rounded transition border border-emerald-200 bg-white flex items-center gap-2">
                                        <i class="fa-solid fa-pen"></i> تعديل
                                    </button>
                                @endif
                            @else
                                <button wire:click="cancelEdit" class="px-3 py-1.5 text-xs font-medium text-slate-500 hover:text-red-600 hover:bg-red-50 rounded transition">
                                    إلغاء
                                </button>
                                <button wire:click="save" class="px-4 py-1.5 text-xs font-bold text-white bg-emerald-600 hover:bg-emerald-700 rounded transition flex items-center gap-2 shadow-sm">
                                    <i class="fa-solid fa-save"></i> حفظ التغييرات
                                </button>
                            @endif
                        </div>
                    </div>

                    {{-- Code Editor / Viewer --}}
                    <div class="flex text-sm font-mono overflow-x-auto code-scroll bg-white" dir="ltr">
                        <div class="line-numbers bg-slate-50 text-slate-400 text-right py-4 px-3 border-r border-slate-100 select-none min-w-[50px]">
                            @foreach($lines as $index => $line)
                                {{ $index + 1 }}<br>
                            @endforeach
                        </div>

                        <div class="w-full relative">
                            @if($isEditing)
                                <textarea wire:model="editingContent" class="w-full h-full min-h-[500px] p-4 font-mono text-sm text-slate-800 bg-white focus:outline-none resize-none leading-6 whitespace-pre" spellcheck="false"></textarea>
                            @else
                                <pre class="m-0 p-4 bg-white text-slate-800 leading-6 min-h-[200px]"><code class="language-{{ $file->extension }}">{{ $content }}</code></pre>
                            @endif
                        </div>
                    </div>
                </div>
            @endif

            {{-- ################################################# --}}
            {{--                  MODE: DIFF VIEW                  --}}
            {{-- ################################################# --}}
            @if($mode === 'diff' && $fileType === 'text')
                <div class="bg-white border border-slate-200 rounded-xl overflow-hidden shadow-sm">
                    <div class="bg-slate-50 border-b border-slate-200 px-4 py-3 flex justify-between items-center">
                        <div class="text-sm font-bold text-slate-700">مقارنة مع آخر نسخة محفوظة</div>
                        <div class="text-xs text-slate-500 flex gap-3">
                            <span class="flex items-center gap-1"><span class="w-2 h-2 bg-emerald-500 rounded-full"></span> إضافة</span>
                            <span class="flex items-center gap-1"><span class="w-2 h-2 bg-red-500 rounded-full"></span> حذف</span>
                        </div>
                    </div>

                    <div class="font-mono text-xs leading-6 bg-white overflow-x-auto" dir="ltr">
                        @forelse($diffLines as $diff)
                            @if($diff['type'] === 'same')
                                <div class="flex text-slate-500 opacity-70">
                                    <div class="w-10 text-right pr-3 select-none border-r border-slate-100 bg-slate-50">{{ $diff['line_n'] }}</div>
                                    <div class="flex-1 pl-4 whitespace-pre">{{ $diff['content'] }}</div>
                                </div>
                            @elseif($diff['type'] === 'add')
                                <div class="flex bg-emerald-50/60 text-emerald-900">
                                    <div class="w-10 text-right pr-3 select-none border-r border-emerald-200 bg-emerald-100 text-emerald-700 font-bold">+</div>
                                    <div class="flex-1 pl-4 whitespace-pre font-bold">{{ $diff['content'] }}</div>
                                </div>
                            @elseif($diff['type'] === 'remove')
                                <div class="flex bg-red-50/60 text-red-900 line-through decoration-red-300 opacity-80">
                                    <div class="w-10 text-right pr-3 select-none border-r border-red-200 bg-red-100 text-red-700 font-bold">-</div>
                                    <div class="flex-1 pl-4 whitespace-pre">{{ $diff['content'] }}</div>
                                </div>
                            @endif
                        @empty
                            <div class="p-12 text-center text-slate-400">
                                <i class="fa-solid fa-check-circle text-4xl text-emerald-500 mb-2 opacity-50"></i>
                                <p>الملف متطابق تماماً مع النسخة السابقة.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            @endif

            {{-- ################################################# --}}
            {{--                  MODE: BLAME / HISTORY            --}}
            {{-- ################################################# --}}
            @if($mode === 'blame')
                <div class="space-y-6">

                    {{-- Part A: Versions Archive Table --}}
                    <div class="bg-white border border-slate-200 rounded-xl overflow-hidden shadow-sm">
                        <div class="bg-slate-50 border-b border-slate-200 px-4 py-3 flex justify-between items-center">
                            <h3 class="font-bold text-slate-700 text-sm flex items-center gap-2">
                                <i class="fa-solid fa-box-archive text-emerald-600"></i> أرشيف النسخ
                            </h3>
                            <span class="text-xs text-slate-400 bg-white px-2 py-1 rounded border border-slate-200">
                                عدد النسخ المحفوظة: {{ $file->history()->count() }}
                            </span>
                        </div>

                        <div class="max-h-60 overflow-y-auto">
                            <table class="w-full text-sm text-left">
                                <thead class="text-xs text-slate-500 uppercase bg-slate-50 sticky top-0 z-10 border-b border-slate-200">
                                    <tr>
                                        <th class="px-4 py-2 font-medium">المستخدم</th>
                                        <th class="px-4 py-2 font-medium">رسالة التعديل</th>
                                        <th class="px-4 py-2 font-medium">الوقت / المكان</th>
                                        <th class="px-4 py-2 text-right">إجراء</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100">
                                    @forelse($file->history()->latest()->get() as $history)
                                        <tr class="hover:bg-slate-50 transition group">
                                            <td class="px-4 py-3 font-medium text-slate-900 flex items-center gap-2">
                                                <img src="https://ui-avatars.com/api/?name={{ $history->user->name }}&size=24&background=random" class="rounded-full w-6 h-6 border border-white shadow-sm">
                                                {{ $history->user->name }} <x-admin-badge :user="$history->user" />
                                            </td>
                                            <td class="px-4 py-3 text-slate-600 truncate max-w-xs" title="{{ $history->commit_message }}">
                                                {{ $history->commit_message ?? 'تحديث بدون رسالة' }}
                                            </td>
                                            <td class="px-4 py-3 text-slate-500 text-xs">
                                                <div class="flex flex-col">
                                                    <span class="font-mono text-slate-700">{{ $history->created_at->format('Y-m-d H:i') }}</span>
                                                    <span class="text-[10px] text-slate-400">IP: {{ $history->ip_address }}</span>
                                                </div>
                                            </td>
                                            <td class="px-4 py-3 text-right">
                                                @if(auth()->id() === $project->user_id)
                                                    {{-- زر يفتح مودال الاستعادة --}}
                                                    <button
                                                        wire:click="confirmRestore({{ $history->id }})"
                                                        class="opacity-0 group-hover:opacity-100 text-xs bg-white border border-slate-300 text-slate-600 hover:text-emerald-600 hover:border-emerald-500 px-2 py-1.5 rounded transition shadow-sm items-center gap-1 ml-auto inline-flex"
                                                        title="استعادة هذه النسخة">
                                                        <i class="fa-solid fa-rotate-left"></i> استعادة
                                                    </button>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="px-4 py-8 text-center text-slate-400 italic">
                                                لا يوجد سجل تعديلات سابق لهذا الملف.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    {{-- Part B: Line-by-Line Blame (Only for text) --}}
                    @if($fileType === 'text')
                        <div class="bg-white border border-slate-200 rounded-xl overflow-hidden shadow-sm text-sm">

                            <div class="bg-slate-50 border-b border-slate-200 px-4 py-2 text-xs text-slate-500 flex font-bold">
                                <div class="w-[300px] flex-shrink-0">تفاصيل التعديل الحالي</div>
                                <div class="flex-1 font-mono px-4">محتوى الملف</div>
                            </div>

                            <div class="font-sans">
                                @php
                                    $lastHistory = $file->history()->latest()->first();
                                    $displayUser = $lastHistory ? $lastHistory->user : $file->user;
                                    $displayDate = $lastHistory ? $lastHistory->created_at : $file->created_at;
                                    $displayMsg  = $lastHistory ? $lastHistory->commit_message : 'Initial upload';
                                    $displayIP   = $lastHistory ? $lastHistory->ip_address : 'Original';
                                @endphp

                                @foreach($lines as $index => $line)
                                    <div class="flex blame-row group border-b border-slate-50 last:border-0 hover:bg-yellow-50/50 transition duration-150">

                                        {{-- Left Column: User & Metadata --}}
                                        <div class="w-[300px] flex-shrink-0 bg-slate-50/30 p-3 text-xs border-l border-slate-100 relative">

                                            @if($index === 0)
                                                <div class="flex items-center gap-2 mb-2">
                                                    <img src="https://ui-avatars.com/api/?name={{ $displayUser->name }}&background=random" class="w-6 h-6 rounded-full shadow-sm ring-2 ring-white">
                                                    <div>
                                                        <div class="font-bold text-slate-800">{{ Str::limit($displayUser->name, 15) }}</div>
                                                    </div>
                                                </div>

                                                <div class="text-slate-500 mb-3 leading-relaxed italic" title="{{ $displayMsg }}">
                                                    "{{ Str::limit($displayMsg, 40) }}"
                                                </div>

                                                <div class="flex items-center gap-2 flex-wrap">
                                                    <span class="flex items-center gap-1 bg-slate-100 text-slate-500 px-1.5 py-0.5 rounded border border-slate-200 text-[10px]">
                                                        <i class="fa-regular fa-clock"></i>
                                                        {{ $displayDate->diffForHumans(null, true) }}
                                                    </span>

                                                    <span class="flex items-center gap-1 bg-emerald-50 text-emerald-600 px-1.5 py-0.5 rounded border border-emerald-100 text-[10px] font-mono shadow-sm" title="Server IP">
                                                        <i class="fa-solid fa-server"></i>
                                                        {{ $displayIP }}
                                                    </span>
                                                </div>
                                            @else
                                                <div class="h-full border-r-2 border-slate-200/50 absolute top-0 right-5 group-hover:border-emerald-300 transition-colors duration-300"></div>
                                            @endif
                                        </div>

                                        {{-- Right Column: Source Code --}}
                                        <div class="flex-1 font-mono text-xs leading-6 bg-white py-1 pl-2" dir="ltr">
                                            <div class="flex">
                                                <span class="w-8 text-slate-300 text-right pr-3 select-none text-[10px] pt-1 border-r border-transparent group-hover:border-slate-100">{{ $index + 1 }}</span>
                                                <span class="text-slate-800 pl-2 whitespace-pre group-hover:text-black transition">{{ $line }}</span>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            @endif

        </div>
    </div>

    {{-- مودال تأكيد الاستعادة --}}
    <x-modals.confirm-delete
        id="restore"
        title="تأكيد الاستعادة"
        :message="$restoreModalMessage"
        confirm-text="نعم، استعادة"
        type="success"
        wire:click="restoreVersionConfirmed"
    />

</div>
