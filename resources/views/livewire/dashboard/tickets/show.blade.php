<div class="flex flex-col h-full bg-slate-50 overflow-hidden">
    {{-- هيدر التذكرة --}}
    <div class="bg-white border-b border-slate-200 px-6 py-4 shrink-0 z-10">
        <div class="max-w-5xl mx-auto flex items-center justify-between">
            <div class="flex items-center gap-4">
                <a href="{{ route('dashboard.tickets') }}" class="text-slate-400 hover:text-slate-600 transition">
                    <i class="fa-solid fa-arrow-right"></i>
                </a>
                <div>
                    <h2 class="text-lg font-bold text-slate-800 flex items-center gap-2">
                        {{ $ticket->subject }}
                        <span class="text-[10px] bg-slate-100 text-slate-500 px-2 py-0.5 rounded-md font-mono">#{{ $ticket->id }}</span>
                    </h2>
                    <div class="flex items-center gap-3 mt-0.5">
                        <span class="flex items-center gap-1 text-[10px] font-bold {{ $ticket->status == 'open' ? 'text-emerald-600' : 'text-slate-400' }}">
                            <span class="w-1.5 h-1.5 rounded-full {{ $ticket->status == 'open' ? 'bg-emerald-500 animate-pulse' : 'bg-slate-300' }}"></span>
                            {{ $ticket->status == 'open' ? 'مفتوحة الآن' : 'مغلقة' }}
                        </span>
                        <span class="text-[10px] text-slate-400">بدأت في {{ $ticket->created_at->diffForHumans() }}</span>
                    </div>
                </div>
            </div>
            
            {{-- الأولوية --}}
            <span class="px-3 py-1 rounded-full text-[10px] font-bold 
                {{ $ticket->priority == 'high' ? 'bg-red-50 text-red-600 border border-red-100' : 'bg-slate-50 text-slate-500 border border-slate-100' }}">
                أولوية {{ $ticket->priority == 'high' ? 'عالية' : 'عادية' }}
            </span>
        </div>
    </div>

    {{-- منطقة الرسائل --}}
    <div class="flex-1 overflow-y-auto p-6 space-y-6 custom-scrollbar bg-[#F8FAFC]">
        <div class="max-w-4xl mx-auto space-y-6">
            
            {{-- الرسالة الأصلية للمستخدم --}}
            <div class="flex flex-col items-start">
                <div class="flex items-center gap-2 mb-2">
                    <img src="{{ asset('storage/'.auth()->user()->avatar) }}" class="w-6 h-6 rounded-full">
                    <span class="text-xs font-bold text-slate-700">أنت</span>
                    <span class="text-[9px] text-slate-400">{{ $ticket->created_at->format('h:i A') }}</span>
                </div>
                <div class="bg-white border border-slate-200 p-5 rounded-2xl rounded-tr-sm shadow-sm text-sm text-slate-700 leading-relaxed max-w-[90%]">
                    {{ $ticket->message }}
                </div>
            </div>

            {{-- مثال لرد الدعم الفني (يمكنك جعلها Loop للردود) --}}
            <div class="flex flex-col items-end">
                <div class="flex flex-row-reverse items-center gap-2 mb-2">
                    <div class="w-6 h-6 rounded-full bg-emerald-600 flex items-center justify-center text-[10px] text-white">AI</div>
                    <span class="text-xs font-bold text-slate-700">دعم Oneurai</span>
                </div>
                <div class="bg-emerald-600 text-white p-5 rounded-2xl rounded-tl-sm shadow-md shadow-emerald-500/10 text-sm leading-relaxed max-w-[90%]">
                    مرحباً بك يا {{ auth()->user()->name }}، شكراً لتواصلك معنا. نحن نعمل حالياً على حل المشكلة وسنقوم بإبلاغك فور الانتهاء.
                </div>
            </div>

        </div>
    </div>

    {{-- منطقة الرد (Input) --}}
    @if($ticket->status == 'open')
    <div class="bg-white border-t border-slate-200 p-4 shrink-0">
        <div class="max-w-4xl mx-auto">
            <form wire:submit.prevent="sendReply" class="relative">
                <textarea wire:model="reply" rows="2" placeholder="اكتب ردك هنا..."
                    class="w-full bg-slate-50 border-slate-200 rounded-2xl py-3 pr-4 pl-16 text-sm focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 transition-all outline-none resize-none"></textarea>
                
                <button type="submit" 
                    class="absolute left-3 bottom-3 w-10 h-10 bg-slate-900 hover:bg-emerald-600 text-white rounded-xl flex items-center justify-center transition-all active:scale-95 shadow-lg">
                    <i class="fa-solid fa-paper-plane text-xs"></i>
                </button>
            </form>
            <p class="text-[9px] text-slate-400 mt-2 px-1 text-center">بإرسالك لهذا الرد، ستصل رسالتك مباشرة لفريق الدعم الفني.</p>
        </div>
    </div>
    @else
    <div class="bg-slate-100 p-4 text-center text-xs font-bold text-slate-500 shrink-0">
        هذه التذكرة مغلقة، لا يمكنك إضافة ردود جديدة.
    </div>
    @endif
</div>