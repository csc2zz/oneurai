<div class="min-h-screen w-full bg-[#f4f4f0] font-sans text-slate-900 p-6 lg:p-12 relative overflow-hidden" style="
    border-radius: 20px;
" dir="rtl">

    <div class="absolute inset-0 opacity-[0.4] z-0" style="background-image: radial-gradient(#cbd5e1 2px, transparent 2px); background-size: 24px 24px;"></div>

    <div class="max-w-5xl mx-auto relative z-10 grid lg:grid-cols-12 gap-8 items-start">

        <div class="lg:col-span-4 lg:sticky lg:top-12">
            <div class="bg-[#10b981] border-4 border-black shadow-[8px_8px_0px_0px_rgba(0,0,0,1)] rounded-xl p-8 mb-6 transform hover:-translate-y-1 transition-transform duration-300">
                <h1 class="text-4xl font-black text-white mb-2 leading-tight">
                    UPLOAD<br>DATASET
                </h1>
                <p class="text-black font-bold text-lg opacity-80">شارك بياناتك مع العالم.</p>
            </div>

            <div class="bg-white border-4 border-black shadow-[8px_8px_0px_0px_rgba(0,0,0,1)] rounded-xl p-6 hidden lg:block">
                <h3 class="font-black text-xl mb-4 flex items-center gap-2">
                    <i class="fa-solid fa-lightbulb text-yellow-500"></i> نصائح سريعة
                </h3>
                <ul class="space-y-3 font-medium text-slate-700">
                    <li class="flex items-start gap-2">
                        <i class="fa-solid fa-check mt-1 text-emerald-600"></i>
                        <span>اختر عنواناً واضحاً يصف المحتوى بدقة.</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <i class="fa-solid fa-check mt-1 text-emerald-600"></i>
                        <span>ملفات CSV و JSONL هي الأفضل للمعالجة.</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <i class="fa-solid fa-check mt-1 text-emerald-600"></i>
                        <span>أضف وصفاً طويلاً في Readme لزيادة التحميلات.</span>
                    </li>
                </ul>
            </div>
        </div>

        <div class="lg:col-span-8">
            <form wire:submit="save" class="space-y-8">

                <div class="bg-white border-4 border-black shadow-[8px_8px_0px_0px_rgba(0,0,0,1)] rounded-xl overflow-hidden group hover:shadow-[12px_12px_0px_0px_rgba(0,0,0,1)] transition-all duration-300">
                    <div class="bg-black text-white p-4 font-black text-lg flex justify-between items-center">
                        <span>01. المعلومات الأساسية</span>
                        <i class="fa-solid fa-pen-nib"></i>
                    </div>

                    <div class="p-8 space-y-6">
                        <div>
                            <label class="block font-bold text-black mb-2 text-lg">اسم المجموعة</label>
                            <input type="text" wire:model.live="title" placeholder="مثال: تغريدات الأسهم السعودية"
                                class="w-full bg-[#f4f4f0] border-2 border-black rounded-lg p-4 font-bold text-slate-800 placeholder-slate-400 focus:outline-none focus:bg-yellow-50 focus:shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] transition-all">
                            @error('title') <span class="text-red-600 font-bold text-sm mt-2 block"><i class="fa-solid fa-triangle-exclamation"></i> {{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block font-bold text-black mb-2 text-lg">الرابط (Slug)</label>
                            <div class="flex border-2 border-black rounded-lg bg-[#f4f4f0] overflow-hidden focus-within:shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] transition-all">
                                <span class="bg-black text-white px-4 py-3 font-mono font-bold text-sm flex items-center" dir="ltr">oneurai.sa/d/</span>
                                <input type="text" wire:model="slug" class="flex-1 bg-transparent border-none p-3 font-mono font-bold text-slate-800 focus:ring-0" placeholder="my-dataset-2025" dir="ltr">
                            </div>
                            @error('slug') <span class="text-red-600 font-bold text-sm mt-2 block">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

                <div class="bg-white border-4 border-black shadow-[8px_8px_0px_0px_rgba(0,0,0,1)] rounded-xl overflow-hidden group hover:shadow-[12px_12px_0px_0px_rgba(0,0,0,1)] transition-all duration-300">
                    <div class="bg-black text-white p-4 font-black text-lg flex justify-between items-center">
                        <span>02. الملفات</span>
                        <i class="fa-solid fa-file-import"></i>
                    </div>

                    <div class="p-8">
                        <div class="relative w-full">
                            <input type="file" wire:model="datasetFile" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-20">

                            <div class="border-4 border-dashed border-black bg-[#f4f4f0] rounded-xl p-10 text-center transition-all group-hover:bg-emerald-50 relative overflow-hidden">

                                <div wire:loading.remove wire:target="datasetFile">
                                    <div class="w-20 h-20 bg-white border-4 border-black rounded-full flex items-center justify-center mx-auto mb-4 shadow-[4px_4px_0px_0px_rgba(0,0,0,1)]">
                                        <i class="fa-solid fa-upload text-3xl text-black"></i>
                                    </div>
                                    <h3 class="text-2xl font-black text-black uppercase">اسحب الملفات هنا</h3>
                                    <p class="font-bold text-slate-500 mt-2">CSV, JSONL, Parquet (Max 10MB)</p>
                                </div>

                                <div wire:loading wire:target="datasetFile" class="flex flex-col items-center justify-center">
                                    <i class="fa-solid fa-cog fa-spin text-5xl text-black mb-4"></i>
                                    <p class="text-xl font-black text-black">جاري المعالجة...</p>
                                </div>
                            </div>
                        </div>

                        @if($datasetFile)
                        <div class="mt-6 bg-[#dcfce7] border-4 border-black rounded-xl p-4 flex items-center justify-between shadow-[4px_4px_0px_0px_rgba(0,0,0,1)]">
                            <div class="flex items-center gap-4">
                                <div class="bg-white border-2 border-black p-2 rounded text-xl">
                                    <i class="fa-solid fa-database"></i>
                                </div>
                                <div>
                                    <p class="font-black text-black text-lg" dir="ltr">{{ $datasetFile->getClientOriginalName() }}</p>
                                    <p class="text-xs font-bold text-emerald-800 uppercase tracking-wider">Ready to Launch</p>
                                </div>
                            </div>
                            <button type="button" wire:click="$set('datasetFile', null)" class="w-10 h-10 bg-red-500 border-2 border-black rounded flex items-center justify-center text-white hover:bg-red-600 transition">
                                <i class="fa-solid fa-times text-xl"></i>
                            </button>
                        </div>
                        @endif
                        @error('datasetFile') <span class="text-red-600 font-bold text-sm mt-4 block text-center bg-red-100 border-2 border-red-500 p-2 rounded">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="bg-white border-4 border-black shadow-[8px_8px_0px_0px_rgba(0,0,0,1)] rounded-xl overflow-hidden group hover:shadow-[12px_12px_0px_0px_rgba(0,0,0,1)] transition-all duration-300">
                    <div class="bg-black text-white p-4 font-black text-lg flex justify-between items-center">
                        <span>03. التفاصيل الدقيقة</span>
                        <i class="fa-solid fa-sliders"></i>
                    </div>

                    <div class="p-8 grid md:grid-cols-2 gap-6">
                        <div>
                            <label class="block font-bold text-black mb-2">نوع المهمة</label>
                            <div class="relative">
                                <select wire:model="task_type" class="w-full bg-[#f4f4f0] border-2 border-black rounded-lg p-3 font-bold appearance-none cursor-pointer hover:bg-yellow-50 transition">
                                    <option>Text Classification</option>
                                    <option>Sentiment Analysis</option>
                                    <option>Translation</option>
                                </select>
                                <i class="fa-solid fa-caret-down absolute left-4 top-4 pointer-events-none text-black"></i>
                            </div>
                        </div>

                        <div>
                            <label class="block font-bold text-black mb-2">اللغة</label>
                            <div class="relative">
                                <select wire:model="language" class="w-full bg-[#f4f4f0] border-2 border-black rounded-lg p-3 font-bold appearance-none cursor-pointer hover:bg-yellow-50 transition">
                                    <option>العربية (Arabic)</option>
                                    <option>English</option>
                                    <option>Mixed</option>
                                </select>
                                <i class="fa-solid fa-caret-down absolute left-4 top-4 pointer-events-none text-black"></i>
                            </div>
                        </div>

                        <div class="md:col-span-2">
                            <label class="block font-bold text-black mb-2">الخصوصية</label>
                            <div class="flex gap-4">
                                <label class="flex-1 cursor-pointer group">
                                    <input type="radio" wire:model="visibility" value="public" class="peer sr-only">
                                    <div class="border-2 border-black rounded-lg p-4 text-center peer-checked:bg-black peer-checked:text-white transition group-hover:shadow-[4px_4px_0px_0px_rgba(0,0,0,1)]">
                                        <i class="fa-solid fa-globe text-xl mb-1 block"></i>
                                        <span class="font-black">عام (Public)</span>
                                    </div>
                                </label>
                                <label class="flex-1 cursor-pointer group">
                                    <input type="radio" wire:model="visibility" value="private" class="peer sr-only">
                                    <div class="border-2 border-black rounded-lg p-4 text-center peer-checked:bg-black peer-checked:text-white transition group-hover:shadow-[4px_4px_0px_0px_rgba(0,0,0,1)]">
                                        <i class="fa-solid fa-lock text-xl mb-1 block"></i>
                                        <span class="font-black">خاص (Private)</span>
                                    </div>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white border-4 border-black shadow-[8px_8px_0px_0px_rgba(0,0,0,1)] rounded-xl overflow-hidden group hover:shadow-[12px_12px_0px_0px_rgba(0,0,0,1)] transition-all duration-300">
                    <div class="bg-black text-white p-4 font-black text-lg flex justify-between items-center">
                        <span>04. الوصف (README)</span>
                        <i class="fa-brands fa-markdown"></i>
                    </div>
                    <div class="p-0">
                         <textarea wire:model="description" class="w-full h-64 p-6 bg-[#f4f4f0] text-slate-800 font-mono text-sm border-none outline-none resize-none focus:bg-white transition" placeholder="# اكتب وصف مشروعك هنا..."></textarea>
                    </div>
                </div>

                <div class="flex justify-end pt-4">
                    <button type="submit" wire:loading.attr="disabled" class="bg-[#10b981] text-white text-xl font-black py-4 px-12 border-4 border-black rounded-xl shadow-[8px_8px_0px_0px_rgba(0,0,0,1)] hover:shadow-[12px_12px_0px_0px_rgba(0,0,0,1)] hover:-translate-y-1 active:translate-y-0 active:shadow-none transition-all flex items-center gap-3">
                        <span wire:loading.remove>نشر البيانات <i class="fa-solid fa-rocket mr-2"></i></span>
                        <span wire:loading>جاري النشر... <i class="fa-solid fa-spinner fa-spin mr-2"></i></span>
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>
