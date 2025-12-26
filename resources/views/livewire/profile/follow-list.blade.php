<div>
    @if($isOpen)
        {{-- خلفية المودال (Backdrop) --}}
        <div class="fixed inset-0 z-[100] bg-slate-900/50 backdrop-blur-sm flex items-center justify-center p-4 transition-opacity"
             wire:click="closeModal">

            {{-- محتوى المودال --}}
            <div class="bg-white rounded-xl shadow-2xl w-full max-w-md overflow-hidden animate-fade-in-up"
                 wire:click.stop> {{-- منع إغلاق المودال عند الضغط داخله --}}

                {{-- الهيدر --}}
                <div class="flex items-center justify-between px-5 py-4 border-b border-slate-100">
                    <h3 class="font-bold text-lg text-slate-800">{{ $title }}</h3>
                    <button wire:click="closeModal" class="text-slate-400 hover:text-red-500 transition">
                        <i class="fa-solid fa-xmark text-xl"></i>
                    </button>
                </div>

                {{-- القائمة --}}
                <div class="max-h-[60vh] overflow-y-auto p-2 custom-scrollbar">
                    @forelse($users as $person)
                        <div class="flex items-center justify-between p-3 hover:bg-slate-50 rounded-lg transition group">
                            <a href="{{ route('profile.show', $person->username) }}" class="flex items-center gap-3">
                                {{-- الصورة الرمزية --}}
                                @if($person->avatar)
                                    <img src="{{ asset('storage/' . $person->avatar) }}" class="w-10 h-10 rounded-full object-cover border border-slate-200">
                                @else
                                    <div class="w-10 h-10 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-700 font-bold">
                                        {{ substr($person->name, 0, 1) }}
                                    </div>
                                @endif

                                <div>
                                    <p class="text-sm font-bold text-slate-800 group-hover:text-emerald-600 transition">{{ $person->name }}</p>
                                    <p class="text-xs text-slate-500" dir="ltr">{{ '@' . $person->username }}</p>
                                </div>
                            </a>

                            {{-- زر زيارة البروفايل --}}
                            <a href="{{ route('profile.show', $person->username) }}" class="text-xs font-semibold text-slate-500 bg-white border border-slate-200 px-3 py-1.5 rounded-full hover:border-emerald-500 hover:text-emerald-600 transition">
                                عرض
                            </a>
                        </div>
                    @empty
                        <div class="text-center py-8 text-slate-500">
                            <i class="fa-regular fa-face-meh text-3xl mb-2 opacity-50"></i>
                            <p>لا يوجد مستخدمين في هذه القائمة.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    @endif
</div>
