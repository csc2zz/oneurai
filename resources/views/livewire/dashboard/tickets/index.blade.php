<div class="py-8 px-4 max-w-6xl mx-auto">
    <div class="flex items-center justify-between mb-8">
        <div>
            <h2 class="text-2xl font-bold text-slate-800">تذاكر الدعم الفني</h2>
            <p class="text-slate-500 text-sm">تابع حالة طلباتك واستفساراتك هنا.</p>
        </div>
        <a href="{{ route('dashboard.tickets.create') }}" 
           class="bg-emerald-600 hover:bg-emerald-700 text-white px-6 py-3 rounded-2xl font-bold text-sm transition-all shadow-lg shadow-emerald-500/20 flex items-center gap-2">
            <i class="fa-solid fa-plus"></i> تذكرة جديدة
        </a>
    </div>

    <div class="grid grid-cols-1 gap-4">
        @forelse($tickets as $ticket)
            <div class="bg-white p-5 rounded-3xl border border-slate-200 flex items-center justify-between hover:shadow-md transition-shadow">
                <div class="flex items-center gap-4 min-w-0">
                    <div class="w-12 h-12 rounded-2xl bg-slate-50 flex items-center justify-center text-emerald-600 shrink-0">
                        <i class="fa-solid fa-ticket-simple text-xl"></i>
                    </div>
                    <div class="min-w-0">
                        <h4 class="font-bold text-slate-800 truncate">{{ $ticket->subject }}</h4>
                        <div class="flex items-center gap-3 mt-1 text-[11px] font-medium">
                            <span class="text-slate-400">#{{ $ticket->id }}</span>
                            <span class="text-slate-400"><i class="fa-regular fa-clock ml-1"></i>{{ $ticket->created_at->format('Y/m/d') }}</span>
                            <span class="px-2 py-0.5 rounded-md bg-slate-100 text-slate-600 uppercase">{{ $ticket->category }}</span>
                        </div>
                    </div>
                </div>
                
                <div class="flex items-center gap-4">
                    {{-- الحالة --}}
                    @if($ticket->status == 'open')
                        <span class="px-3 py-1 bg-emerald-100 text-emerald-700 rounded-full text-[10px] font-bold">مفتوحة</span>
                    @else
                        <span class="px-3 py-1 bg-slate-100 text-slate-500 rounded-full text-[10px] font-bold">مغلقة</span>
                    @endif
                    
                    <a href="{{ route('dashboard.tickets.show', $ticket->id) }}" class="w-10 h-10 rounded-xl bg-slate-50 flex items-center justify-center text-slate-400 hover:bg-slate-900 hover:text-white transition-all">
                        <i class="fa-solid fa-chevron-left"></i>
                    </a>
                </div>
            </div>
        @empty
            <div class="text-center py-20 bg-white rounded-3xl border border-dashed border-slate-200">
                <i class="fa-solid fa-inbox text-5xl text-slate-200 mb-4"></i>
                <p class="text-slate-400 font-medium">لا توجد تذاكر حالياً</p>
            </div>
        @endforelse
    </div>
</div>