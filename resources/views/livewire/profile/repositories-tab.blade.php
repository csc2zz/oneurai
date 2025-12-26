<x-layouts.profile :user="$user" active-tab="repositories">
    <div class="animate-fade-in space-y-8">

        {{-- رأس القسم وشريط البحث --}}
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <h2 class="text-2xl font-bold text-emerald-500 tracking-tight">
                المستودعات <span class="text-slate-400 text-lg font-normal">({{ $projects->count() }})</span>
            </h2>

            <div class="relative w-full md:w-96 group">
                <input
                    wire:model.live.debounce.300ms="search"
                    type="text"
                    placeholder="ابحث عن مشروع..."
                    class="w-full bg-slate-50 border border-slate-200 text-slate-900 text-sm rounded-xl py-3 px-4 pr-11 focus:bg-white focus:outline-none focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10 transition-all duration-300 shadow-sm group-hover:bg-white"
                >
                <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                    <i class="fa-solid fa-magnifying-glass text-slate-400 group-focus-within:text-emerald-500 transition-colors duration-300"></i>
                </div>
            </div>
        </div>

        {{-- قائمة المشاريع --}}
        <div class="grid grid-cols-1 gap-5">
            @forelse($projects as $project)
                <div class="relative bg-white border border-slate-100 rounded-2xl p-6 shadow-[0_2px_8px_rgba(0,0,0,0.04)] hover:shadow-[0_8px_24px_rgba(0,0,0,0.08)] hover:border-emerald-500/30 hover:-translate-y-1 transition-all duration-300 group">

                    <div class="flex flex-col md:flex-row md:items-start justify-between gap-4 mb-3">
                        {{-- العنوان والأيقونة --}}
                        <div class="flex items-start gap-4">
                            <div class="w-10 h-10 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0 group-hover:bg-emerald-600 group-hover:text-white transition-colors duration-300">
                                <i class="fa-solid fa-book-bookmark text-lg"></i>
                            </div>

                            <div>
                                <div class="flex items-center flex-wrap gap-3">
                                    <a href="{{ route('project.showing', [$user->username, $project->slug]) }}"
                                       class="text-xl font-bold text-slate-800 hover:text-emerald-600 transition-colors font-sans tracking-tight flex items-center gap-2" dir="ltr">
                                        {{ $project->title }}
                                        <i class="fa-solid fa-arrow-up-right-from-square text-xs opacity-0 group-hover:opacity-100 -translate-x-2 group-hover:translate-x-0 transition-all duration-300 text-emerald-500"></i>
                                    </a>

                                    {{-- حالة المستودع --}}
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-medium border {{ $project->is_public ? 'bg-emerald-50 text-emerald-700 border-emerald-100' : 'bg-slate-100 text-slate-600 border-slate-200' }}">
                                        @if($project->is_public)
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span> Public
                                        @else
                                            <i class="fa-solid fa-lock text-[10px]"></i> Private
                                        @endif
                                    </span>
                                </div>
                                <div class="text-xs text-slate-400 mt-1 font-medium">
                                    تم التحديث {{ $project->updated_at->diffForHumans() }}
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- الوصف --}}
                    <p class="text-slate-600 mb-6 leading-relaxed text-sm md:text-base pr-14 max-w-3xl">
                        {{ $project->description ?? 'لا يوجد وصف متاح لهذا المستودع حالياً.' }}
                    </p>

                    {{-- الفوتر: اللغة والإحصائيات --}}
                    <div class="flex items-center justify-between border-t border-slate-50 pt-4 mt-auto">
                        <div class="flex items-center gap-6">
                            {{-- اللغة --}}
                            <div class="flex items-center gap-2 text-sm font-medium text-slate-700">
                                <span class="w-3 h-3 rounded-full shadow-sm" style="background-color: {{ $project->language_color ?? '#10b981' }}"></span>
                                {{ $project->language ?? 'PHP' }}
                            </div>

                            {{-- النجوم --}}
                            <div class="flex items-center gap-1.5 text-sm text-slate-500 hover:text-amber-500 transition-colors cursor-help" title="عدد النجوم">
                                <i class="fa-regular fa-star text-base mb-0.5"></i>
                                <span>{{ $project->stars_count ?? 0 }}</span>
                            </div>

                            {{-- (اختياري) أيقونة برانش أو فورك --}}
                            <div class="hidden sm:flex items-center gap-1.5 text-sm text-slate-500">
                                <i class="fa-solid fa-code-branch text-xs"></i>
                                <span>Main</span>
                            </div>
                        </div>

                        {{-- زر الإجراء السريع (اختياري) --}}
                        <a href="{{ route('project.showing', [$user->username, $project->slug]) }}" class="text-xs font-bold text-slate-400 hover:text-emerald-600 flex items-center gap-1 transition-colors">
                            عرض التفاصيل <i class="fa-solid fa-chevron-left text-[10px]"></i>
                        </a>
                    </div>
                </div>
            @empty
                {{-- حالة الفراغ بتصميم أجمل --}}
                <div class="flex flex-col items-center justify-center py-16 bg-slate-50 rounded-2xl border-2 border-dashed border-slate-200 group">
                    <div class="w-20 h-20 bg-white rounded-full flex items-center justify-center shadow-sm mb-4 group-hover:scale-110 transition-transform duration-300">
                        <i class="fa-solid fa-box-open text-4xl text-slate-300 group-hover:text-emerald-400 transition-colors"></i>
                    </div>
                    <h3 class="text-lg font-bold text-slate-800 mb-1">لا توجد مستودعات</h3>
                    <p class="text-slate-500 text-sm">لم نتمكن من العثور على أي مشاريع تطابق بحثك.</p>
                    @if($search)
                        <button wire:click="$set('search', '')" class="mt-4 text-sm text-emerald-600 font-bold hover:underline">
                            مسح البحث وعرض الكل
                        </button>
                    @endif
                </div>
            @endforelse
        </div>

        {{-- الترقيم الصفحات (Pagination) --}}
@if($projects->hasPages())
            <div class="mt-8" dir="ltr">
                {{ $projects->links('vendor.livewire.oneurai-pagination') }}
            </div>
        @endif
    </div>
</x-layouts.profile>
