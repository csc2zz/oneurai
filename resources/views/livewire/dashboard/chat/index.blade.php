<div class="flex flex-col h-[calc(100vh-theme(spacing.16))] w-full bg-[#f8fafc] overflow-hidden relative" 
     dir="rtl"
     x-data="{ showSidebar: true }" 
     {{-- تقليل زمن الاستجابة إلى 2000ms لالتقاط الكتابة بسرعة --}}
     wire:poll.2000ms>

    {{-- ================= ستايلات خاصة (Luxury CSS) ================= --}}
    <style>
        /* خلفية ناعمة جداً */
        .chat-pattern {
            background-color: #f1f5f9;
            background-image: 
                linear-gradient(rgba(255, 255, 255, 0.8) 2px, transparent 2px),
                linear-gradient(90deg, rgba(255, 255, 255, 0.8) 2px, transparent 2px),
                linear-gradient(rgba(255, 255, 255, 0.6) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255, 255, 255, 0.6) 1px, transparent 1px);
            background-size: 50px 50px, 50px 50px, 10px 10px, 10px 10px;
            background-position: -2px -2px, -2px -2px, -1px -1px, -1px -1px;
        }

        /* سكرول بار مخفي وأنيق */
        .glass-scroll::-webkit-scrollbar { width: 4px; }
        .glass-scroll::-webkit-scrollbar-track { background: transparent; }
        .glass-scroll::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 20px; }
        .glass-scroll:hover::-webkit-scrollbar-thumb { background: #94a3b8; }

        /* أنميشن الكتابة (Bouncing Dots) */
        @keyframes bounce {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-4px); }
        }
        .typing-dot { animation: bounce 1s infinite ease-in-out; }
        .typing-dot:nth-child(1) { animation-delay: 0s; }
        .typing-dot:nth-child(2) { animation-delay: 0.2s; }
        .typing-dot:nth-child(3) { animation-delay: 0.4s; }

        /* أنميشن ظهور الرسائل */
        @keyframes slideIn {
            from { opacity: 0; transform: translateY(10px) scale(0.98); }
            to { opacity: 1; transform: translateY(0) scale(1); }
        }
        .msg-enter { animation: slideIn 0.3s cubic-bezier(0.2, 0.8, 0.2, 1) forwards; }
    </style>

    <div class="flex flex-1 h-full overflow-hidden relative m-0 md:m-4 rounded-3xl border border-white/60 shadow-[0_30px_60px_-10px_rgba(0,0,0,0.08)] bg-white z-10">

        {{-- ================= القائمة الجانبية ================= --}}
        <div class="w-full md:w-80 lg:w-96 border-l border-slate-100 flex flex-col shrink-0 transition-all duration-500 absolute md:relative z-30 h-full bg-white/90 backdrop-blur-md"
             :class="showSidebar ? 'translate-x-0' : 'translate-x-full md:translate-x-0'">
            
            {{-- رأس القائمة --}}
            <div class="p-6 pb-4">
                <div class="flex items-center justify-between mb-6">
                    <h1 class="text-2xl font-black text-slate-800 tracking-tight flex items-center gap-2">
                        الرسائل <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                    </h1>
                    <button class="w-8 h-8 rounded-full bg-slate-50 hover:bg-slate-100 flex items-center justify-center text-slate-400 transition">
                        <i class="fa-solid fa-pen-to-square"></i>
                    </button>
                </div>
                
                <div class="relative group">
                    <input type="text" wire:model.live.debounce.300ms="search" 
                           placeholder="بحث عن محادثة..."
                           class="w-full bg-slate-50 border-none text-slate-700 text-sm rounded-2xl py-3.5 pl-4 pr-10 focus:ring-2 focus:ring-emerald-500/20 focus:bg-white transition-all shadow-sm group-hover:shadow-md">
                    <span class="absolute right-4 top-3.5 text-slate-400 group-focus-within:text-emerald-500 transition-colors">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </span>
                </div>
            </div>

            {{-- قائمة المحادثات --}}
            <div class="flex-1 overflow-y-auto px-3 pb-3 space-y-1 glass-scroll">
                @forelse($this->conversations as $conversation)
                    @php 
                        $otherUser = $conversation->otherUser(auth()->id()); 
                        $isActive = $selectedConversationId == $conversation->id;
                    @endphp
                    
                    <div wire:click="selectConversation({{ $conversation->id }}); showSidebar = false"
                         class="group relative p-3.5 rounded-2xl cursor-pointer transition-all duration-300 border border-transparent
                         {{ $isActive ? 'bg-emerald-50/80 shadow-sm ring-1 ring-emerald-100' : 'hover:bg-slate-50' }}">
                        
                        <div class="flex items-center gap-4">
                            <div class="relative shrink-0">
                                <img src="{{ $otherUser->avatar ? asset('storage/'.$otherUser->avatar) : 'https://ui-avatars.com/api/?name='.$otherUser->name }}" 
                                     class="w-12 h-12 rounded-full object-cover ring-2 ring-white shadow-sm">
                                @if($this->isUserOnline($otherUser->id))
                                    <span class="absolute bottom-0 right-0 w-3.5 h-3.5 bg-emerald-500 border-2 border-white rounded-full"></span>
                                @endif
                            </div>

                            <div class="flex-1 min-w-0">
                                <div class="flex justify-between items-baseline mb-1">
                                    <h4 class="text-sm font-extrabold {{ $isActive ? 'text-emerald-900' : 'text-slate-700' }} truncate">
                                        {{ $otherUser->name }}
                                    </h4>
                                    <span class="text-[10px] font-medium {{ $isActive ? 'text-emerald-600' : 'text-slate-400' }}">
                                        {{ $conversation->last_message_at ? $conversation->last_message_at->shortAbsoluteDiffForHumans() : '' }}
                                    </span>
                                </div>
                                <p class="text-xs truncate font-medium {{ $isActive ? 'text-emerald-700/70' : 'text-slate-500' }}">
                                    @if($conversation->messages()->latest()->first()?->user_id == auth()->id())
                                        <i class="fa-solid fa-check-double text-[10px] mr-1 {{ $conversation->messages()->latest()->first()?->is_read ? 'text-blue-500' : 'text-slate-400' }}"></i>
                                    @endif
                                    {{ $conversation->messages()->latest()->first()?->body ?? 'ابدأ المحادثة ✨' }}
                                </p>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-20 opacity-50">
                        <p class="text-sm text-slate-500">لا توجد محادثات</p>
                    </div>
                @endforelse
            </div>
        </div>

        {{-- ================= منطقة الدردشة ================= --}}
        <div class="flex-1 flex flex-col bg-slate-50/50 relative w-full h-full chat-pattern"
             :class="!showSidebar ? 'block' : 'hidden md:flex'">

            @if($this->selectedConversation)
                @php 
                    $chatUser = $this->selectedConversation->otherUser(auth()->id());
                    $status = $this->selectedConversation->status;
                    $isPending = $status === 'pending';
                    $lastSeen = $this->getUserLastSeen($chatUser->id);
                @endphp

                {{-- الهيدر --}}
                <div class="h-[76px] shrink-0 bg-white/80 backdrop-blur-xl border-b border-slate-100 flex items-center justify-between px-6 z-20 shadow-sm/50">
                    <div class="flex items-center gap-4">
                        <button class="md:hidden w-9 h-9 rounded-full bg-white border border-slate-200 text-slate-500 hover:text-slate-800 transition flex items-center justify-center shadow-sm" 
                                @click="showSidebar = true">
                            <i class="fa-solid fa-arrow-right"></i>
                        </button>
                        
                        <div class="flex items-center gap-3">
                            <div class="relative">
                                <img src="{{ $chatUser->avatar ? asset('storage/'.$chatUser->avatar) : 'https://ui-avatars.com/api/?name='.$chatUser->name }}" 
                                     class="w-10 h-10 rounded-full object-cover ring-2 ring-white shadow-md">
                                @if($this->isUserOnline($chatUser->id))
                                    <span class="absolute bottom-0 right-0 w-3 h-3 bg-emerald-500 border-2 border-white rounded-full"></span>
                                @endif
                            </div>
                            <div>
                                <h2 class="font-bold text-slate-800 text-sm md:text-base">{{ $chatUser->name }}</h2>
                                <span class="flex items-center gap-1.5 text-[10px] font-bold tracking-wide {{ $this->isUserOnline($chatUser->id) ? 'text-emerald-500' : 'text-slate-400' }}">
                                    @if($this->isUserOnline($chatUser->id))
                                        متاح الآن
                                    @else
                                        {{ $lastSeen ? 'كان هنا ' . $lastSeen->diffForHumans() : 'غير متصل' }}
                                    @endif
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="flex gap-3">
                        <button class="w-10 h-10 rounded-full bg-white text-slate-400 hover:text-emerald-600 hover:bg-emerald-50 border border-slate-100 transition flex items-center justify-center shadow-sm">
                            <i class="fa-solid fa-phone"></i>
                        </button>
                        <button class="w-10 h-10 rounded-full bg-white text-slate-400 hover:text-emerald-600 hover:bg-emerald-50 border border-slate-100 transition flex items-center justify-center shadow-sm">
                            <i class="fa-solid fa-video"></i>
                        </button>
                    </div>
                </div>

                {{-- منطقة الرسائل --}}
                <div id="messages-container" class="flex-1 overflow-y-auto p-4 md:p-8 space-y-6 glass-scroll relative">
                    
                    @foreach($this->selectedConversation->messages as $msg)
                        @php 
                            $isMe = $msg->user_id == auth()->id(); 
                            // تجميع الرياكشنات لعرضها بشكل جميل
                            $reactionsGrouped = $msg->reactions->groupBy('emoji');
                        @endphp
                        
                        <div class="flex {{ $isMe ? 'justify-end' : 'justify-start' }} group msg-enter relative items-end gap-2"
                             x-data="{ showReactionMenu: false }"
                             @click.away="showReactionMenu = false">

                            {{-- قائمة الرياكشنات (تصميم زجاجي عائم) --}}
                            <div x-show="showReactionMenu" 
                                 x-transition:enter="transition ease-out duration-200"
                                 x-transition:enter-start="opacity-0 translate-y-4 scale-90"
                                 x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                                 class="absolute bottom-full mb-3 {{ $isMe ? 'right-0' : 'left-0' }} z-50 bg-white/95 backdrop-blur-xl border border-white/20 shadow-[0_10px_40px_-10px_rgba(0,0,0,0.15)] rounded-full px-3 py-2 flex gap-2 items-center">
                                @foreach(['👍','❤️','😂','😮','😢','😡'] as $emoji)
                                    <button wire:click="toggleReaction({{ $msg->id }}, '{{ $emoji }}')" 
                                            @click="showReactionMenu = false"
                                            class="hover:scale-125 hover:-translate-y-1 transition-all duration-200 text-2xl p-1 cursor-pointer leading-none filter drop-shadow-sm">
                                        {{ $emoji }}
                                    </button>
                                @endforeach
                            </div>

                            {{-- أزرار التحكم (رد + رياكشن) - تظهر عند الهوفر --}}
                            @if(!$isMe)
                                <div class="opacity-0 group-hover:opacity-100 transition-opacity flex flex-col gap-2 pb-2">
                                    <button @click="showReactionMenu = !showReactionMenu" class="w-8 h-8 rounded-full bg-white text-slate-400 hover:text-amber-500 hover:bg-amber-50 shadow-sm flex items-center justify-center transition"><i class="fa-regular fa-face-smile"></i></button>
                                    <button wire:click="setReplyTo({{ $msg->id }})" class="w-8 h-8 rounded-full bg-white text-slate-400 hover:text-emerald-500 hover:bg-emerald-50 shadow-sm flex items-center justify-center transition"><i class="fa-solid fa-reply"></i></button>
                                </div>
                            @else
                                 <div class="opacity-0 group-hover:opacity-100 transition-opacity flex flex-col gap-2 pb-2 order-first">
                                    <button wire:click="setReplyTo({{ $msg->id }})" class="w-8 h-8 rounded-full bg-white text-slate-400 hover:text-emerald-500 hover:bg-emerald-50 shadow-sm flex items-center justify-center transition"><i class="fa-solid fa-reply"></i></button>
                                </div>
                            @endif

                            {{-- جسم الرسالة --}}
                            <div class="flex flex-col {{ $isMe ? 'items-end' : 'items-start' }} max-w-[85%] md:max-w-[65%] relative">
                                
                                {{-- المحتوى --}}
                                <div class="px-5 py-3 text-[13px] md:text-sm font-medium leading-relaxed shadow-sm relative min-w-[120px] transition-all
                                    {{ $isMe 
                                        ? 'bg-gradient-to-tr from-emerald-600 to-teal-500 text-white rounded-2xl rounded-tr-none shadow-emerald-200' 
                                        : 'bg-white text-slate-700 rounded-2xl rounded-tl-none border border-slate-100 shadow-slate-200' 
                                    }}">
                                    
                                    {{-- 1. عرض الرد المقتبس داخل الرسالة (تصميم محسن) --}}
                                    @if($msg->parent)
                                        <div class="mb-2 p-2 rounded-xl text-xs backdrop-blur-sm border-r-2
                                            {{ $isMe ? 'bg-black/10 border-white/40 text-white/90' : 'bg-slate-50 border-emerald-400 text-slate-600' }} flex flex-col cursor-pointer hover:opacity-80 transition">
                                            <span class="font-bold mb-0.5 flex items-center gap-1 opacity-90">
                                                <i class="fa-solid fa-reply fa-xs"></i> {{ $msg->parent->user->name }}
                                            </span>
                                            <span class="truncate line-clamp-1 opacity-80">{{ $msg->parent->body }}</span>
                                        </div>
                                    @endif

                                    {{-- نص الرسالة --}}
                                    {!! nl2br(e($msg->body)) !!}
                                </div>

                                {{-- 2. عرض الرياكشنات (تصميم الفقاعات) --}}
                                @if($msg->reactions->count() > 0)
                                    <div class="absolute -bottom-4 {{ $isMe ? 'right-2' : 'left-2' }} flex -space-x-1 space-x-reverse cursor-pointer z-10 filter drop-shadow-sm" 
                                         @click="showReactionMenu = !showReactionMenu">
                                        @foreach($reactionsGrouped as $emoji => $reactions)
                                            <div class="bg-white border border-slate-100 rounded-full px-2 py-0.5 text-xs flex items-center gap-1 hover:scale-110 transition shadow-sm">
                                                <span>{{ $emoji }}</span>
                                                @if($reactions->count() > 1)
                                                    <span class="font-bold text-slate-600 text-[10px]">{{ $reactions->count() }}</span>
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                @endif

                                {{-- الوقت وحالة القراءة --}}
                                <div class="flex items-center gap-1 mt-1.5 px-1 opacity-60 group-hover:opacity-100 transition-opacity duration-300">
                                    <span class="text-[9px] font-bold text-slate-400">{{ $msg->created_at->format('h:i A') }}</span>
                                    @if($isMe)
                                        <i class="fa-solid fa-check-double text-[9px] {{ $msg->is_read ? 'text-blue-500' : 'text-slate-300' }}"></i>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach

                    {{-- 🔥 3. مؤشر الكتابة (تمت إعادته) 🔥 --}}
                    @if($this->isOtherUserTyping)
                        <div class="flex justify-start msg-enter mb-4">
                            <div class="bg-white border border-slate-100 px-4 py-3 rounded-2xl rounded-tl-none shadow-sm flex items-center gap-1.5">
                                <div class="w-2 h-2 bg-slate-400 rounded-full typing-dot"></div>
                                <div class="w-2 h-2 bg-slate-400 rounded-full typing-dot" style="animation-delay: 0.2s"></div>
                                <div class="w-2 h-2 bg-slate-400 rounded-full typing-dot" style="animation-delay: 0.4s"></div>
                            </div>
                        </div>
                    @endif

                </div>

                {{-- منطقة الإدخال --}}
                <div class="p-4 md:p-6 bg-white/80 backdrop-blur-md border-t border-slate-50 relative z-30">
                    
                    {{-- شريط الرد العائم (تصميم حديث) --}}
                    @if($this->replyingTo)
                        <div class="absolute bottom-full left-0 w-full px-6 pb-2 msg-enter z-0">
                            <div class="bg-white/95 backdrop-blur-xl border border-emerald-100 rounded-t-2xl border-b-0 p-3 flex items-center justify-between shadow-[0_-10px_20px_-5px_rgba(0,0,0,0.05)]">
                                <div class="flex items-center gap-3 overflow-hidden">
                                    <div class="w-1 h-10 bg-gradient-to-b from-emerald-500 to-teal-400 rounded-full shrink-0"></div>
                                    <div class="flex flex-col">
                                        <span class="text-emerald-600 text-xs font-bold mb-0.5">الرد على {{ $this->replyingTo->user->name }}</span>
                                        <span class="text-slate-500 text-xs truncate max-w-xs opacity-80">{{ $this->replyingTo->body }}</span>
                                    </div>
                                </div>
                                <button wire:click="cancelReply" class="w-7 h-7 rounded-full bg-slate-100 hover:bg-red-50 hover:text-red-500 text-slate-400 flex items-center justify-center transition">
                                    <i class="fa-solid fa-xmark text-sm"></i>
                                </button>
                            </div>
                        </div>
                    @endif

                    @if(!$isPending)
                        <form wire:submit.prevent="sendMessage" 
                              class="relative flex items-end gap-2 bg-slate-50 p-1.5 {{ $this->replyingTo ? 'rounded-b-[24px] rounded-t-none' : 'rounded-[24px]' }} border border-slate-200 focus-within:border-emerald-300 focus-within:bg-white focus-within:ring-4 focus-within:ring-emerald-50 transition-all duration-300 z-10">
                            
                            {{-- زر الإيموجي --}}
                            <button type="button" class="w-10 h-10 mb-0.5 rounded-full text-slate-400 hover:text-amber-500 hover:bg-amber-50 transition flex items-center justify-center">
                                <i class="fa-regular fa-face-smile text-lg"></i>
                            </button>

                            {{-- حقل الكتابة --}}
                            <textarea wire:model.live="body" 
                                      wire:keydown.enter.prevent="sendMessage"
                                      x-data="{ resize() { $el.style.height = '46px'; $el.style.height = $el.scrollHeight + 'px' } }"
                                      x-init="$wire.on('focus-input', () => $el.focus())"
                                      @input="resize()"
                                      rows="1" 
                                      placeholder="اكتب رسالة..." 
                                      class="flex-1 bg-transparent border-none focus:ring-0 text-slate-700 text-sm py-3 px-2 min-h-[46px] max-h-32 resize-none glass-scroll placeholder:text-slate-400 font-medium"></textarea>
                            
                            {{-- زر الإرسال --}}
                            <button type="submit" 
                                    class="w-11 h-11 shrink-0 mb-0.5 rounded-full flex items-center justify-center transition-all duration-300 group
                                    {{ empty($body) ? 'bg-slate-200 text-slate-400 cursor-not-allowed' : 'bg-gradient-to-r from-emerald-500 to-teal-500 text-white shadow-lg shadow-emerald-200 hover:scale-105 active:scale-95' }}"
                                    {{ empty($body) ? 'disabled' : '' }}>
                                <i class="fa-solid fa-paper-plane text-sm group-hover:translate-x-0.5 group-hover:-translate-y-0.5 transition-transform"></i>
                            </button>
                        </form>
                    @endif
                </div>

                {{-- سكريبت التمرير --}}
                <script>
                    document.addEventListener('livewire:initialized', () => {
                        const container = document.getElementById('messages-container');
                        const scrollToBottom = () => { 
                            if(container) container.scrollTo({ top: container.scrollHeight, behavior: 'smooth' });
                        }
                        
                        setTimeout(scrollToBottom, 100);
                        Livewire.on('scrollToBottom', scrollToBottom);
                    });
                </script>

            @else
                {{-- الشاشة الفارغة --}}
                <div class="flex-1 flex flex-col items-center justify-center z-20 text-center p-6 bg-slate-50/50">
                    <div class="w-40 h-40 bg-white rounded-full flex items-center justify-center mb-6 shadow-[0_20px_40px_-10px_rgba(0,0,0,0.1)] animate-float">
                        <img src="https://cdn-icons-png.flaticon.com/512/9602/9602235.png" class="w-24 opacity-80" alt="Chat">
                    </div>
                    <h3 class="text-2xl font-black text-slate-800 mb-3">Oneurai Chat</h3>
                    <p class="text-slate-500 text-sm max-w-xs leading-relaxed font-medium">
                        تواصل مع أصدقائك بخصوصية تامة وتصميم يليق بك.
                    </p>
                </div>
            @endif
        </div>
    </div>
</div>