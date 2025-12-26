<x-layouts.profile :user="$user" active-tab="overview">
    <div class="space-y-10 animate-fade-in-up">

        {{-- 1. المشاريع المثبتة: تصميم البطاقات العائمة --}}
        <div class="relative">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-sm font-black text-emerald-500 uppercase tracking-widest flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                    المشاريع المثبتة
                </h2>
                <button class="text-[10px] font-bold text-slate-400 hover:text-emerald-600 transition">تخصيص القائمة</button>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @forelse($pinnedProjects as $project)
                    <div class="group relative bg-white rounded-[2rem] p-6 border border-slate-200/60 shadow-sm hover:shadow-[0_15px_40px_rgba(0,0,0,0.04)] hover:border-emerald-500/30 transition-all duration-500 overflow-hidden">
                        {{-- تأثير خلفية عند الهوفر --}}
                        <div class="absolute -top-10 -left-10 w-24 h-24 bg-emerald-500/5 rounded-full blur-2xl group-hover:bg-emerald-500/10 transition-colors"></div>

                        <div class="relative z-10">
                            <div class="flex items-start justify-between mb-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-xl bg-slate-50 border border-slate-100 flex items-center justify-center text-slate-400 group-hover:text-emerald-500 transition-all duration-500 group-hover:scale-110">
                                        <i class="fa-solid fa-book-bookmark"></i>
                                    </div>
                                    <div>
                                        <a href="{{ route('project.showing', [$user->username, $project->slug]) }}"
                                           class="text-base font-black text-slate-900 hover:text-emerald-600 transition-colors tracking-tight font-sans" dir="ltr">
                                            {{ $project->title }}
                                        </a>
                                        <div class="flex items-center gap-2 mt-0.5">
                                            <span class="text-[9px] font-black uppercase tracking-tighter text-slate-400">{{ $project->is_public ? 'Public' : 'Private' }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-slate-300 group-hover:text-amber-400 transition-colors">
                                    <i class="fa-solid fa-thumbtack text-xs rotate-45"></i>
                                </div>
                            </div>

                            <p class="text-xs text-slate-500 leading-relaxed font-medium mb-6 line-clamp-2 h-8">
                                {{ $project->description ?? 'لا يوجد وصف متاح لهذا المشروع المتميز.' }}
                            </p>

                            <div class="flex items-center justify-between pt-4 border-t border-slate-50 text-[10px] font-black uppercase tracking-widest text-slate-400">
                                <div class="flex items-center gap-4">
                                    <span class="flex items-center gap-1.5">
                                        <span class="w-2 h-2 rounded-full bg-emerald-500 shadow-[0_0_8px_rgba(16,185,129,0.4)]"></span>
                                        {{ $project->language ?? 'Python' }}
                                    </span>
                                    <span class="flex items-center gap-1.5 group-hover:text-amber-500 transition-colors">
                                        <i class="fa-regular fa-star"></i> {{ number_format($project->stars_count) }}
                                    </span>
                                </div>
                                <i class="fa-solid fa-chevron-left opacity-0 group-hover:opacity-100 group-hover:-translate-x-1 transition-all"></i>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full py-16 text-center bg-white rounded-[2.5rem] border-2 border-dashed border-slate-200">
                        <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fa-solid fa-layer-group text-slate-300 text-xl"></i>
                        </div>
                        <p class="text-slate-400 font-bold">لا توجد مشاريع مثبتة لعرضها.</p>
                    </div>
                @endforelse
            </div>
        </div>

        {{-- 2. شبكة المساهمات (Premium Activity Graph) --}}
{{-- 2. شبكة المساهمات (Premium Activity Graph) --}}
<div class="bg-white rounded-[2.5rem] p-8 border border-slate-200/60 shadow-sm relative overflow-hidden">
    {{-- تدرج خلفي خفيف --}}
    <div class="absolute top-0 right-0 w-64 h-64 bg-emerald-500/5 rounded-full blur-[100px] -z-0"></div>

    <div class="relative z-10">
        <div class="flex flex-col sm:flex-row sm:items-end justify-between mb-8 gap-4">
            <div>
                <h2 class="text-sm font-black text-slate-800 uppercase tracking-[0.2em] mb-1 text-right">سجل النشاط الرقمي</h2>
                <div class="text-2xl font-black text-emerald-600 font-mono text-right">
                    {{ $user->contributions()->where('created_at', '>=', now()->subYear())->count() }}
                    <span class="text-slate-400 text-xs font-bold font-sans tracking-normal uppercase mr-1">عملية في العام الأخير</span>
                </div>
            </div>
            <div class="flex items-center gap-2 bg-slate-50 p-1 rounded-xl border border-slate-100 w-fit self-end">
                <button class="px-3 py-1.5 rounded-lg bg-white shadow-sm text-[10px] font-black text-slate-900 uppercase tracking-tighter transition">2025</button>
                <button class="px-3 py-1.5 rounded-lg text-[10px] font-bold text-slate-400 hover:text-slate-600 transition uppercase tracking-tighter">2024</button>
            </div>
        </div>

        {{-- الجراف المطور مع سكرول بار مخفي --}}
        <div class="overflow-x-auto custom-scrollbar-hidden pb-4 select-none" id="contribution-graph-container" dir="ltr">
            <div class="inline-block min-w-full">
                {{-- شبكة الأيام (7 صفوف) --}}
                <div class="grid grid-rows-7 grid-flow-col gap-1.5">
                    @php
                        // نبدأ من يوم الأحد قبل 52 أسبوعاً لضمان اكتمال الأعمدة
                        $startDate = now()->subWeeks(52)->startOfWeek(\Carbon\Carbon::SUNDAY);
                        $daysToDisplay = $startDate->diffInDays(now()) + 1;
                        $contributions = $contributionList;
                    @endphp

                    @for($i = 0; $i < $daysToDisplay; $i++)
                        @php
                            $date = $startDate->copy()->addDays($i);
                            $dateString = $date->format('Y-m-d');
                            $count = $contributions[$dateString] ?? 0;

                            $cls = match(true) {
                                $count === 0 => 'bg-slate-100 hover:bg-slate-200',
                                $count <= 2  => 'bg-emerald-200 hover:bg-emerald-300',
                                $count <= 5  => 'bg-emerald-400 hover:bg-emerald-500',
                                $count <= 10 => 'bg-emerald-600 hover:bg-emerald-700',
                                default      => 'bg-emerald-800 hover:bg-emerald-900',
                            };
                        @endphp

                        <div class="w-[11px] h-[11px] md:w-[13px] md:h-[13px] rounded-[2px] {{ $cls }} transition-all duration-300 cursor-pointer relative group/tip shadow-sm"
                             title="{{ $count }} مساهمة في {{ $date->translatedFormat('d M Y') }}">

                            {{-- Tooltip المخصص --}}
                            <div class="absolute bottom-full left-1/2 -translate-x-1/2 mb-2 px-2 py-1 bg-slate-900 text-white text-[9px] rounded-md opacity-0 group-hover/tip:opacity-100 pointer-events-none transition-all z-50 whitespace-nowrap shadow-xl">
                                {{ $count }} contributions on {{ $date->format('M d, Y') }}
                                <div class="absolute top-full left-1/2 -translate-x-1/2 border-4 border-transparent border-t-slate-900"></div>
                            </div>
                        </div>
                    @endfor
                </div>

                {{-- تسميات الشهور --}}
                <div class="flex mt-3 text-[9px] font-black text-slate-300 uppercase tracking-[0.3em] gap-[30px] md:gap-[42px] px-1">
                    <span>Jan</span><span>Feb</span><span>Mar</span><span>Apr</span><span>May</span><span>Jun</span><span>Jul</span><span>Aug</span><span>Sep</span><span>Oct</span><span>Nov</span><span>Dec</span>
                </div>
            </div>
        </div>

        {{-- Legend --}}
        <div class="flex flex-col sm:flex-row items-center justify-between mt-6 pt-6 border-t border-slate-50 gap-4">
            <p class="text-[10px] font-bold text-slate-400 flex items-center gap-2 text-right">
                <i class="fa-solid fa-circle-info text-emerald-500"></i>
                مرر لليسار لمشاهدة كامل نشاط السنة
            </p>
            <div class="flex items-center gap-2 text-[10px] font-black text-slate-300 uppercase tracking-widest" dir="ltr">
                <span>Less</span>
                <div class="flex gap-1">
                    <div class="w-2.5 h-2.5 bg-slate-100 rounded-[2px]"></div>
                    <div class="w-2.5 h-2.5 bg-emerald-200 rounded-[2px]"></div>
                    <div class="w-2.5 h-2.5 bg-emerald-400 rounded-[2px]"></div>
                    <div class="w-2.5 h-2.5 bg-emerald-600 rounded-[2px]"></div>
                    <div class="w-2.5 h-2.5 bg-emerald-800 rounded-[2px]"></div>
                </div>
                <span>More</span>
            </div>
        </div>
    </div>
</div>

<style>
    /* إخفاء السكرول بار مع السماح بالتمرير */
    .custom-scrollbar-hidden::-webkit-scrollbar {
        display: none;
    }
    .custom-scrollbar-hidden {
        -ms-overflow-style: none;
        scrollbar-width: none;
    }
</style>

<script>
    // كود إضافي لجعل السكرول يبدأ من اليمين (نهاية السنة) تلقائياً
    document.addEventListener('DOMContentLoaded', function() {
        const container = document.getElementById('contribution-graph-container');
        if (container) {
            container.scrollLeft = container.scrollWidth;
        }
    });
</script>
    </div>
    <style>
    .no-scrollbar::-webkit-scrollbar { display: none; }
    #contribution-graph-container {
        scrollbar-width: none;
        -ms-overflow-style: none;
    }
</style>
</x-layouts.profile>

