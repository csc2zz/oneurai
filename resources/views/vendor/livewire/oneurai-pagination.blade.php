<div>
    @if ($paginator->hasPages())
        <div class="bg-white px-4 py-3 flex items-center justify-between border-t border-slate-200 sm:px-6 rounded-xl shadow-sm mt-8">

            {{-- عرض الموبايل --}}
            <div class="flex 1 flex-1 justify-between sm:hidden">
                @if ($paginator->onFirstPage())
                    <span class="relative inline-flex items-center rounded-lg border border-slate-300 bg-slate-100 px-4 py-2 text-sm font-medium text-slate-400 cursor-not-allowed">
                        السابق
                    </span>
                @else
                    <button wire:click="previousPage" wire:loading.attr="disabled" class="relative inline-flex items-center rounded-lg border border-slate-300 bg-white px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50 transition">
                        السابق
                    </button>
                @endif

                @if ($paginator->hasMorePages())
                    <button wire:click="nextPage" wire:loading.attr="disabled" class="relative ml-3 inline-flex items-center rounded-lg border border-slate-300 bg-white px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50 transition">
                        التالي
                    </button>
                @else
                    <span class="relative ml-3 inline-flex items-center rounded-lg border border-slate-300 bg-slate-100 px-4 py-2 text-sm font-medium text-slate-400 cursor-not-allowed">
                        التالي
                    </span>
                @endif
            </div>

            {{-- عرض سطح المكتب --}}
            <div class="hidden sm:flex sm:flex-1 sm:items-center sm:justify-between">

                {{-- معلومات العرض --}}
                <div>
                    <p class="text-sm text-slate-700">
                        عرض <span class="font-bold text-emerald-600 font-sans">{{ $paginator->firstItem() }}</span> إلى <span class="font-bold text-emerald-600 font-sans">{{ $paginator->lastItem() }}</span> من أصل <span class="font-bold text-emerald-600 font-sans">{{ $paginator->total() }}</span> نتيجة
                    </p>
                </div>

                {{-- أزرار التنقل --}}
                <div>
                    <nav class="isolate inline-flex -space-x-px rounded-md gap-1 shadow-sm dir-ltr" aria-label="Pagination">

                        {{-- زر التالي (في RTL السهم اليسار هو التالي منطقياً لكن حسب تصميمك الأسهم معكوسة للأيقونات) --}}
                        {{-- زر الصفحة التالية --}}
                        @if ($paginator->hasMorePages())
                            <button wire:click="nextPage" class="relative inline-flex items-center rounded-l-lg border border-slate-300 bg-white px-2 py-2 text-sm font-medium text-slate-500 hover:bg-slate-50 focus:z-20 transition">
                                <span class="sr-only">التالي</span>
                                <i class="fa-solid fa-chevron-left h-5 w-5 text-center leading-5"></i>
                            </button>
                        @else
                            <span class="relative inline-flex items-center rounded-l-lg border border-slate-300 bg-slate-50 px-2 py-2 text-sm font-medium text-slate-300 cursor-not-allowed">
                                <span class="sr-only">التالي</span>
                                <i class="fa-solid fa-chevron-left h-5 w-5 text-center leading-5"></i>
                            </span>
                        @endif

                        {{-- عناصر الترقيم --}}
                        @foreach ($elements as $element)
                            {{-- فاصل النقاط "..." --}}
                            @if (is_string($element))
                                <span class="relative inline-flex items-center border border-slate-300 bg-white px-4 py-2 text-sm font-medium text-slate-700">{{ $element }}</span>
                            @endif

                            {{-- مصفوفة الروابط --}}
                            @if (is_array($element))
                                @foreach ($element as $page => $url)
                                    @if ($page == $paginator->currentPage())
                                        <span aria-current="page" class="relative z-10 inline-flex items-center border border-emerald-600 bg-emerald-50 px-4 py-2 text-sm font-bold text-emerald-600 focus:z-20">{{ $page }}</span>
                                    @else
                                        <button wire:click="gotoPage({{ $page }})" class="relative inline-flex items-center border border-slate-300 bg-white px-4 py-2 text-sm font-medium text-slate-500 hover:bg-slate-50 focus:z-20 transition">{{ $page }}</button>
                                    @endif
                                @endforeach
                            @endif
                        @endforeach

                        {{-- زر السابق --}}
                        @if ($paginator->onFirstPage())
                            <span class="relative inline-flex items-center rounded-r-lg border border-slate-300 bg-slate-50 px-2 py-2 text-sm font-medium text-slate-300 cursor-not-allowed">
                                <span class="sr-only">السابق</span>
                                <i class="fa-solid fa-chevron-right h-5 w-5 text-center leading-5"></i>
                            </span>
                        @else
                            <button wire:click="previousPage" class="relative inline-flex items-center rounded-r-lg border border-slate-300 bg-white px-2 py-2 text-sm font-medium text-slate-500 hover:bg-slate-50 focus:z-20 transition">
                                <span class="sr-only">السابق</span>
                                <i class="fa-solid fa-chevron-right h-5 w-5 text-center leading-5"></i>
                            </button>
                        @endif

                    </nav>
                </div>
            </div>
        </div>
    @endif
</div>
