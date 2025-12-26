<div class="flex-1 overflow-y-auto bg-slate-50 min-h-screen">
    <div class="max-w-5xl mx-auto px-6 py-12 animate-fade-in">

        {{-- Hero Header --}}
        <div class="mb-10 text-center max-w-2xl mx-auto">
            <div class="w-16 h-16 bg-gradient-to-br from-emerald-400 to-teal-500 rounded-2xl flex items-center justify-center mx-auto mb-6 shadow-lg shadow-emerald-500/20 transform hover:scale-110 transition-transform duration-300">
                <i class="fa-solid fa-brain text-white text-3xl"></i>
            </div>
            <h1 class="text-3xl font-extrabold text-slate-900 mb-3 tracking-tight">نشر نموذج ذكاء اصطناعي</h1>
            <p class="text-slate-500 text-base leading-relaxed">
                شارك ابتكارك مع العالم. قم برفع الأوزان، ملفات التكوين، والوثائق لبناء مجتمع معرفي متكامل.
            </p>
        </div>

        <form wire:submit="save" class="space-y-8">

            {{-- 1. البيانات الأساسية --}}
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden group hover:shadow-md transition-shadow duration-300">
                <div class="bg-slate-50/50 px-8 py-4 border-b border-slate-100 flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg bg-indigo-100 text-indigo-600 flex items-center justify-center text-sm font-bold">1</div>
                    <h3 class="font-bold text-slate-800">هوية النموذج</h3>
                </div>

                <div class="p-8">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">اسم النموذج (Model ID) <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <input wire:model="model_id" type="text" placeholder="username/model-name" dir="ltr"
                                    class="w-full bg-slate-50 border border-slate-300 rounded-xl py-3 px-4 pl-10 text-sm font-mono text-slate-800 focus:ring-2 focus:ring-indigo-500 focus:bg-white outline-none transition placeholder:text-slate-400">
                                <i class="fa-solid fa-fingerprint absolute left-3.5 top-3.5 text-slate-400"></i>
                            </div>
                            <p class="text-xs text-slate-400 mt-1.5">يجب أن يكون الاسم فريداً باللغة الإنجليزية (مثال: my-awesome-model)</p>
                            @error('model_id') <span class="text-red-500 text-xs font-bold mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">الترخيص (License) <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <select wire:model="license" class="w-full appearance-none bg-slate-50 border border-slate-300 rounded-xl py-3 px-4 pr-10 text-sm text-slate-700 focus:ring-2 focus:ring-indigo-500 focus:bg-white outline-none transition cursor-pointer">
                                    <option value="" disabled selected>اختر نوع الترخيص...</option>
                                    <option value="apache-2.0">Apache 2.0</option>
                                    <option value="mit">MIT</option>
                                    <option value="openrail">OpenRAIL</option>
                                    <option value="other">Other</option>
                                </select>
                                <div class="absolute inset-y-0 right-0 flex items-center px-3 pointer-events-none text-slate-500">
                                    <i class="fa-solid fa-chevron-down text-xs"></i>
                                </div>
                            </div>
                            @error('license') <span class="text-red-500 text-xs font-bold mt-1 block">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <label class="cursor-pointer group/option">
                            <input type="radio" wire:model="visibility" value="public" class="peer sr-only">
                            <div class="p-4 rounded-xl border-2 border-slate-200 hover:border-emerald-400 peer-checked:border-emerald-500 peer-checked:bg-emerald-50/30 transition-all">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center shrink-0 peer-checked:bg-emerald-600 peer-checked:text-white transition">
                                        <i class="fa-solid fa-globe"></i>
                                    </div>
                                    <div>
                                        <span class="block font-bold text-slate-900">عام (Public)</span>
                                        <span class="text-xs text-slate-500">متاح للجميع للاطلاع والاستخدام.</span>
                                    </div>
                                </div>
                            </div>
                        </label>

                        <label class="cursor-pointer group/option">
                            <input type="radio" wire:model="visibility" value="private" class="peer sr-only">
                            <div class="p-4 rounded-xl border-2 border-slate-200 hover:border-emerald-400 peer-checked:border-emerald-500 peer-checked:bg-emerald-50/30 transition-all">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-full bg-slate-100 text-slate-600 flex items-center justify-center shrink-0 peer-checked:bg-slate-800 peer-checked:text-white transition">
                                        <i class="fa-solid fa-lock"></i>
                                    </div>
                                    <div>
                                        <span class="block font-bold text-slate-900">خاص (Private)</span>
                                        <span class="text-xs text-slate-500">سري ومحمي، لك وللفريق فقط.</span>
                                    </div>
                                </div>
                            </div>
                        </label>
                    </div>
                </div>
            </div>

            {{-- 2. المواصفات التقنية --}}
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden group hover:shadow-md transition-shadow duration-300">
                <div class="bg-slate-50/50 px-8 py-4 border-b border-slate-100 flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg bg-amber-100 text-amber-600 flex items-center justify-center text-sm font-bold">2</div>
                    <h3 class="font-bold text-slate-800">التفاصيل التقنية</h3>
                </div>

                <div class="p-8">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">نوع المهمة (Task)</label>
                            <div class="relative">
                                <select wire:model="task" class="w-full appearance-none bg-slate-50 border border-slate-300 rounded-xl py-3 px-4 pr-10 text-sm text-slate-700 focus:ring-2 focus:ring-amber-500 focus:bg-white outline-none transition cursor-pointer">
                                    <option value="" disabled selected>اختر المهمة...</option>
                                    <option value="text-generation">Text Generation</option>
                                    <option value="translation">Translation</option>
                                    <option value="image-classification">Image Classification</option>
                                    <option value="object-detection">Object Detection</option>
                                    <option value="speech-recognition">Speech Recognition</option>
                                </select>
                                <div class="absolute inset-y-0 right-0 flex items-center px-3 pointer-events-none text-slate-500">
                                    <i class="fa-solid fa-chevron-down text-xs"></i>
                                </div>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">اللغة الأساسية</label>
                            <div class="relative">
                                <select wire:model="language" class="w-full appearance-none bg-slate-50 border border-slate-300 rounded-xl py-3 px-4 pr-10 text-sm text-slate-700 focus:ring-2 focus:ring-amber-500 focus:bg-white outline-none transition cursor-pointer">
                                    <option value="" disabled selected>اختر اللغة...</option>
                                    <option value="ar">العربية (Arabic)</option>
                                    <option value="en">English</option>
                                    <option value="multi">Multilingual</option>
                                </select>
                                <div class="absolute inset-y-0 right-0 flex items-center px-3 pointer-events-none text-slate-500">
                                    <i class="fa-solid fa-globe text-xs"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <label class="block text-sm font-bold text-slate-700 mb-4">المكتبة البرمجية (Framework)</label>
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                        @foreach(['PyTorch', 'TensorFlow', 'JAX', 'ONNX'] as $fw)
                            <label class="cursor-pointer group/fw">
                                <input type="radio" wire:model="framework" value="{{ $fw }}" class="peer sr-only">
                                <div class="flex flex-col items-center justify-center p-4 rounded-xl border border-slate-200 bg-white hover:bg-slate-50 peer-checked:border-amber-500 peer-checked:bg-amber-50 peer-checked:text-amber-700 transition h-full">
                                    <span class="font-bold text-sm">{{ $fw }}</span>
                                </div>
                            </label>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- 3. رفع الملفات --}}
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden group hover:shadow-md transition-shadow duration-300">
                <div class="bg-slate-50/50 px-8 py-4 border-b border-slate-100 flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg bg-emerald-100 text-emerald-600 flex items-center justify-center text-sm font-bold">3</div>
                    <h3 class="font-bold text-slate-800">الملفات والأوزان</h3>
                </div>

                <div class="p-8">
                    <div x-data="{ isUploading: false, progress: 0 }"
                         x-on:livewire-upload-start="isUploading = true"
                         x-on:livewire-upload-finish="isUploading = false"
                         x-on:livewire-upload-error="isUploading = false"
                         x-on:livewire-upload-progress="progress = $event.detail.progress">

                        <label class="relative border-2 border-dashed border-slate-300 rounded-2xl p-10 text-center cursor-pointer transition-all duration-300 hover:bg-emerald-50/30 hover:border-emerald-400 group/upload block">
                            <input type="file" wire:model="modelFiles" multiple class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">

                            <div x-show="!isUploading" class="transition-transform duration-300 group-hover/upload:scale-105">
                                <div class="w-16 h-16 bg-emerald-50 text-emerald-600 rounded-full flex items-center justify-center mx-auto mb-4 shadow-sm group-hover/upload:shadow-md transition-shadow">
                                    <i class="fa-solid fa-cloud-arrow-up text-2xl"></i>
                                </div>
                                <h4 class="text-lg font-bold text-slate-900 mb-1">اضغط أو اسحب الملفات هنا</h4>
                                <p class="text-sm text-slate-500 max-w-sm mx-auto">
                                    ندعم ملفات .bin, .pt, .h5, .json, .txt (الحد الأقصى للملف الواحد 1GB)
                                </p>
                            </div>

                            {{-- حالة الرفع --}}
                            <div x-show="isUploading" style="display: none;" class="max-w-md mx-auto">
                                <div class="flex justify-between mb-2">
                                    <span class="text-xs font-bold text-emerald-700 animate-pulse">جاري الرفع...</span>
                                    <span class="text-xs font-bold text-emerald-700 font-mono" x-text="progress + '%'"></span>
                                </div>
                                <div class="w-full bg-slate-100 rounded-full h-2.5 overflow-hidden">
                                    <div class="bg-gradient-to-r from-emerald-400 to-emerald-600 h-2.5 rounded-full transition-all duration-300 ease-out shadow-[0_0_10px_rgba(16,185,129,0.5)]"
                                         :style="'width: ' + progress + '%'">
                                    </div>
                                </div>
                                <p class="text-[10px] text-slate-400 mt-2">يرجى عدم إغلاق الصفحة.</p>
                            </div>
                        </label>
                    </div>

                    {{-- قائمة الملفات المرفوعة --}}
                    @if($modelFiles)
                        <div class="mt-6 border border-slate-100 rounded-xl overflow-hidden bg-slate-50/50">
                            <div class="px-4 py-2 bg-slate-100 border-b border-slate-200 text-xs font-bold text-slate-500 uppercase tracking-wider">
                                الملفات الجاهزة ({{ count($modelFiles) }})
                            </div>
                            <div class="divide-y divide-slate-200 max-h-60 overflow-y-auto custom-scrollbar">
                                @foreach($modelFiles as $index => $file)
                                    <div class="flex justify-between items-center p-3 hover:bg-white transition-colors">
                                        <div class="flex items-center gap-3 overflow-hidden">
                                            <i class="fa-regular fa-file-code text-slate-400"></i>
                                            <div class="flex flex-col min-w-0">
                                                <span class="text-sm font-bold text-slate-700 truncate font-mono dir-ltr">{{ $file->getClientOriginalName() }}</span>
                                                <span class="text-[10px] text-slate-400">{{ round($file->getSize() / 1024, 2) }} KB</span>
                                            </div>
                                        </div>
                                        <button type="button" wire:click="removeFile({{ $index }})" class="w-7 h-7 flex items-center justify-center rounded-lg text-slate-400 hover:text-red-500 hover:bg-red-50 transition">
                                            <i class="fa-solid fa-xmark"></i>
                                        </button>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    @error('modelFiles') <span class="text-red-500 text-xs font-bold mt-3 block bg-red-50 p-2 rounded-lg border border-red-100"><i class="fa-solid fa-circle-exclamation mr-1"></i> {{ $message }}</span> @enderror
                    @error('modelFiles.*') <span class="text-red-500 text-xs font-bold mt-2 block"><i class="fa-solid fa-circle-exclamation mr-1"></i> ملف تالف أو حجمه كبير جداً.</span> @enderror
                </div>
            </div>

            {{-- أزرار التحكم --}}
            <div class="flex items-center justify-end gap-4 pt-6 border-t border-slate-200 mt-8">
                <a href="{{ route('dashboard.models') }}" class="px-6 py-3 rounded-xl text-sm font-bold text-slate-600 hover:bg-slate-100 transition">إلغاء</a>
                <button type="submit"
                        class="bg-slate-900 hover:bg-emerald-600 text-white px-8 py-3 rounded-xl text-sm font-bold transition-all shadow-lg hover:shadow-emerald-500/30 flex items-center gap-2 disabled:opacity-50 disabled:cursor-not-allowed"
                        wire:loading.attr="disabled">
                    <span wire:loading.remove>نشر النموذج <i class="fa-solid fa-rocket mr-1"></i></span>
                    <span wire:loading>جاري المعالجة... <i class="fa-solid fa-spinner animate-spin"></i></span>
                </button>
            </div>

        </form>
    </div>
</div>
