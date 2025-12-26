<x-layouts.model-layout :model="$model" :author="$author" active-tab="card">
    <div class="space-y-8 font-arabic">

        {{-- ✅ 1. مركز تنفيذ الذكاء الاصطناعي (AI Execution Hub) --}}
        @if($this->downloadUrl)
            @php
                $downloadUrl = $this->downloadUrl;
                $colabNotebook = 'https://colab.research.google.com/gist/mtma1/7bea0fbda4b0cf032f6f246c45ba4658/loader.ipynb';
                $colabUrl = $colabNotebook . '?model_url=' . urlencode($downloadUrl);
            @endphp

            <div class="relative group">
                {{-- تأثير التوهج الخلفي المحسن --}}
                <div class="absolute -inset-0.5 bg-gradient-to-r from-emerald-500 via-blue-500 to-indigo-600 rounded-[2rem] blur opacity-15 group-hover:opacity-30 transition duration-1000"></div>

                <div class="relative bg-[#0B1120] border border-white/10 rounded-[2rem] p-6 lg:p-8 shadow-2xl overflow-hidden">
                    {{-- خلفيات جمالية --}}
                    <div class="absolute top-0 right-0 w-64 h-64 bg-emerald-500/5 blur-[80px] rounded-full pointer-events-none"></div>
                    <div class="absolute bottom-0 left-0 w-64 h-64 bg-indigo-500/5 blur-[80px] rounded-full pointer-events-none"></div>

                    <div class="flex flex-col xl:flex-row items-center justify-between gap-8">
                        
                        {{-- معلومات التشغيل --}}
                        <div class="flex items-center gap-6 w-full xl:w-auto">
                            <div class="relative shrink-0">
                                <div class="absolute inset-0 bg-emerald-500 blur-lg opacity-20 animate-pulse"></div>
                                <div class="relative w-20 h-20 bg-gradient-to-br from-white/10 to-white/5 rounded-2xl flex items-center justify-center border border-white/10 backdrop-blur-sm">
                                    <span class="text-4xl filter drop-shadow-[0_0_10px_rgba(16,185,129,0.5)]">🚀</span>
                                </div>
                            </div>
                            <div class="text-right">
                                <h3 class="text-2xl font-[900] text-white italic tracking-tighter mb-1">بيئة التشغيل السحابية</h3>
                                <p class="text-slate-400 text-xs lg:text-sm font-bold leading-relaxed">
                                    جاهز للتنفيذ الفوري، الفحص الأمني، والنسخ المباشر
                                </p>
                            </div>
                        </div>

                        {{-- الأزرار التفاعلية --}}
                        <div class="flex flex-wrap lg:flex-nowrap items-stretch gap-3 w-full xl:w-auto" x-data="{ copied: false }">

                            {{-- 1. زر النسخ (Copy Link) --}}
                            <button 
                                @click="navigator.clipboard.writeText(@js($downloadUrl)); copied = true; setTimeout(() => copied = false, 2000)"
                                class="flex-1 xl:flex-none py-4 px-6 bg-white/5 border border-white/10 text-slate-300 rounded-xl hover:bg-white/10 active:scale-95 transition-all duration-300 group flex flex-col items-center justify-center min-w-[100px]"
                                title="نسخ رابط النموذج"
                            >
                                <div x-show="!copied" class="flex flex-col items-center gap-2">
                                    <i class="fa-regular fa-copy text-xl text-emerald-500 group-hover:scale-110 transition-transform"></i>
                                    <span class="font-bold text-[10px] uppercase tracking-wider">نسخ الرابط</span>
                                </div>
                                <div x-show="copied" class="flex flex-col items-center gap-2 text-emerald-400" style="display: none;">
                                    <i class="fa-solid fa-check-double text-xl animate-bounce"></i>
                                    <span class="font-bold text-[10px] uppercase">تم النسخ</span>
                                </div>
                            </button>

                            {{-- 2. زر الفحص (Scan Code) - مضاف جديد --}}
                            <a href="https://scan.oneurai.com/" 
                               target="_blank"
                               class="flex-1 xl:flex-none py-4 px-6 bg-indigo-500/10 border border-indigo-500/20 text-indigo-300 rounded-xl hover:bg-indigo-500/20 active:scale-95 transition-all duration-300 group flex flex-col items-center justify-center min-w-[100px]"
                            >
                                <i class="fa-solid fa-shield-virus text-xl mb-2 group-hover:rotate-12 transition-transform duration-300"></i>
                                <span class="font-bold text-[10px] uppercase tracking-wider">فحص الكود</span>
                            </a>

                            {{-- 3. زر تشغيل Colab (الملكي) - تم إصلاح الأيقونة --}}
                            <a href="{{ $colabUrl }}"
                               target="_blank"
                               wire:click="recordExecution" 
                               class="flex-grow xl:flex-grow-0 py-4 px-8 bg-gradient-to-r from-emerald-600 to-emerald-500 hover:from-emerald-500 hover:to-emerald-400 text-white rounded-xl shadow-[0_0_20px_rgba(16,185,129,0.2)] hover:shadow-[0_0_30px_rgba(16,185,129,0.4)] active:scale-95 transition-all duration-300 flex items-center justify-center gap-4 group"
                            >
                                {{-- SVG لأيقونة Colab لضمان ظهورها دائماً --}}
                                <svg class="w-8 h-8 drop-shadow-md group-hover:scale-110 transition-transform duration-300" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M16.9414 4.9757a7.033 7.033 0 0 0-4.9308 2.0646 7.033 7.033 0 0 0-.1232 9.8068l2.395-2.395a3.6455 3.6455 0 0 1 5.1497-5.1478l2.397-2.3989a7.0314 7.0314 0 0 0-4.8877-1.9297zM7.0707 6.9635a7.033 7.033 0 0 0-2.0366 4.9008 7.033 7.033 0 0 0 9.8143.0805l-2.3912-2.3913a3.6455 3.6455 0 0 1-5.1516 5.1516l-2.4316 2.4316a7.033 7.033 0 0 0 2.1967-10.1732z" fill="#E67E22" opacity="0.5"/>
                                    <path d="M11.9688 12.045a7.033 7.033 0 0 0-2.055 4.932 7.033 7.033 0 0 0 9.7708-.082l-2.3892-2.3892a3.6455 3.6455 0 0 1-5.146 5.148l-2.4042 2.4042a7.0314 7.0314 0 0 0 2.2236-10.013z" fill="#F1C40F"/>
                                    <path d="M12.045 11.9688a7.033 7.033 0 0 1 2.0568-4.9302 7.033 7.033 0 0 1 4.932-2.0568 7.033 7.033 0 0 1 .169 14.0048l-2.389-2.389a3.6455 3.6455 0 0 0-5.1499-5.1478l-2.4026-2.4026a7.0314 7.0314 0 0 1 2.7837-11.9218z" fill="#fff"/>
                                </svg>
                                <div class="text-right">
                                    <div class="font-[900] text-sm uppercase tracking-tighter italic">تشغيل في المختبر</div>
                                    <div class="text-[10px] text-emerald-100 font-medium">Google Colab Hub</div>
                                </div>
                            </a>
                        </div>
                    </div>

                    {{-- شريط المعلومات السفلي --}}
                    <div class="mt-8 pt-6 border-t border-white/5 flex flex-wrap items-center justify-between gap-4 text-[10px] font-bold text-slate-500">
                        <div class="flex items-center gap-2">
                            <i class="fa-solid fa-shield-halved text-emerald-500/50"></i>
                            <span>يتم توليد الروابط بشكل مشفر ومؤقت لضمان أمان النماذج</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <span class="px-2 py-1 rounded bg-white/5 text-slate-400">v1.0.0</span>
                            <span class="px-2 py-1 rounded bg-white/5 text-slate-400">Secure Environment</span>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        {{-- ✅ 2. قسم الإحصائيات --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            {{-- بطاقة الإحصائيات الحية --}}
            <div class="lg:col-span-1 h-full">
                <livewire:models.model-stats-card :model="$model" />
            </div>

            {{-- قسم الوصف (AI Specs) --}}
            <div class="lg:col-span-2 h-full">
                <div class="h-full bg-white border border-slate-100 rounded-[2rem] p-8 shadow-sm relative overflow-hidden group hover:shadow-md transition-shadow duration-300">
                    <div class="flex items-center gap-3 mb-6 border-b border-slate-50 pb-4">
                        <div class="w-8 h-8 rounded-full bg-slate-50 flex items-center justify-center">
                            <i class="fa-solid fa-file-lines text-slate-400"></i>
                        </div>
                        <h4 class="text-sm font-black text-slate-900 uppercase tracking-widest">وصف النموذج (Documentation)</h4>
                    </div>

                    <div class="prose max-w-none text-slate-600">
                        @if($model->description)
                            <div class="whitespace-pre-wrap leading-relaxed font-medium text-sm lg:text-base">{{ $model->description }}</div>
                        @else
                            <div class="flex flex-col items-center justify-center py-12 opacity-40">
                                <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mb-4">
                                    <i class="fa-solid fa-ghost text-2xl text-slate-300"></i>
                                </div>
                                <p class="text-sm font-bold text-slate-400">لا يوجد توثيق تقني متاح حالياً</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

    </div>
</x-layouts.model-layout>