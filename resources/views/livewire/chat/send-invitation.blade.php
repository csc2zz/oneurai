<div>
    {{-- الحالة 1: تم التواصل (مقبول) --}}
    @if($conversationStatus === 'accepted')
        <a href="{{ route('dashboard.chat', ['id' => $conversationId]) }}"
           class="flex items-center gap-2 px-4 py-2 bg-slate-800 hover:bg-slate-900 text-white rounded-lg text-sm font-bold transition shadow-sm">
            <i class="fa-solid fa-comments"></i>
            <span>مراسلة</span>
        </a>

    {{-- الحالة 2: الطلب معلق (بانتظار الموافقة) --}}
    @elseif($conversationStatus === 'pending')
        <button disabled
                class="flex items-center gap-2 px-4 py-2 bg-amber-50 text-amber-600 border border-amber-200 rounded-lg text-sm font-bold cursor-not-allowed opacity-80">
            <i class="fa-solid fa-clock"></i>
            <span>بانتظار الموافقة</span>
        </button>

    {{-- الحالة 3: لا يوجد تواصل (الوضع الافتراضي) --}}
    @else
        <button wire:click="openModal"
                class="flex items-center gap-2 px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg text-sm font-bold transition shadow-sm shadow-emerald-200" style="place-content: center;">
            <i class="fa-solid fa-paper-plane"></i>
            <span>طلب تواصل</span>
        </button>
    @endif

    {{-- المودال (يظهر فقط إذا لم يكن هناك تواصل) --}}
    @if($isOpen)
        @teleport('body')
            <div class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-slate-900/50 backdrop-blur-sm"
                 x-data
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0">

                <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md overflow-hidden border border-slate-100 transform transition-all"
                     @click.away="$wire.set('isOpen', false)">

                    <div class="p-4 border-b border-slate-100 flex justify-between items-center bg-slate-50">
                        <h3 class="font-bold text-slate-800 flex items-center gap-2">
                            <i class="fa-solid fa-handshake text-emerald-500"></i>
                            طلب تواصل مع {{ $receiver->name }}
                        </h3>
                        <button wire:click="$set('isOpen', false)" class="text-slate-400 hover:text-red-500 transition">
                            <i class="fa-solid fa-xmark text-xl"></i>
                        </button>
                    </div>

                    <div class="p-6">
                        <div class="flex items-start gap-4 mb-6">
                            <img src="{{ $receiver->avatar ? asset('storage/'.$receiver->avatar) : 'https://ui-avatars.com/api/?name='.$receiver->name.'&background=random' }}"
                                 class="w-12 h-12 rounded-full border border-slate-200">
                            <div class="text-sm text-slate-600 leading-relaxed">
                                للحفاظ على بيئة احترافية، يجب أن يوافق <strong>{{ $receiver->name }}</strong> على طلبك قبل بدء المحادثة.
                            </div>
                        </div>

                        <div class="space-y-2">
                            <label class="text-xs font-bold text-slate-700">رسالة التعارف (مطلوبة)</label>
                            <textarea wire:model="message"
                                      rows="4"
                                      class="w-full bg-slate-50 border border-slate-300 rounded-xl p-3 text-sm focus:ring-2 focus:ring-emerald-500 outline-none transition resize-none"
                                      placeholder="مرحباً، أود التواصل معك بخصوص..."></textarea>
                            @error('message') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="p-4 border-t border-slate-100 bg-slate-50 flex justify-end gap-3">
                        <button wire:click="$set('isOpen', false)" class="px-4 py-2 text-sm font-medium text-slate-500 hover:text-slate-700 transition">
                            إلغاء
                        </button>
                        <button wire:click="sendInvitation"
                                wire:loading.attr="disabled"
                                class="px-6 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg text-sm font-bold transition flex items-center gap-2">
                            <span wire:loading.remove wire:target="sendInvitation">إرسال الطلب</span>
                            <span wire:loading wire:target="sendInvitation"><i class="fa-solid fa-spinner fa-spin"></i> جاري الإرسال...</span>
                        </button>
                    </div>

                </div>
            </div>
        @endteleport
    @endif
</div>
