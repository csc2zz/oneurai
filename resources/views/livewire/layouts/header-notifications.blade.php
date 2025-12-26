<div class="relative" x-data="{ open: false }" @click.outside="open = false" wire:poll.5s>

    {{-- زر الجرس مضبوط للجوال --}}
    <button @click="open = !open"
            class="relative p-2 sm:p-3 text-slate-600 hover:text-emerald-600 rounded-xl sm:rounded-2xl transition-all duration-300 bg-white hover:bg-emerald-50 active:scale-95 border border-slate-200 hover:border-emerald-300 shadow-sm hover:shadow-md">
        
        <div class="relative">
            {{-- أيقونة الجرس --}}
            <div class="relative transform transition-transform duration-300 group-hover:scale-110">
                <i class="fa-regular fa-bell text-lg sm:text-xl {{ $this->unreadCount > 0 ? 'text-emerald-600' : '' }}"></i>
            </div>

            {{-- شارة التنبيه مضبوطة للجوال --}}
            @if($this->unreadCount > 0)
                <span class="absolute -top-1.5 -right-1.5 flex h-4 w-4 sm:h-5 sm:w-5">
                    {{-- تأثير نبض --}}
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                    
                    {{-- الشارة الرئيسية --}}
                    <span class="relative inline-flex rounded-full h-4 w-4 sm:h-5 sm:w-5 bg-gradient-to-br from-emerald-500 to-emerald-600 border border-white sm:border-2 border-white shadow-md items-center justify-center text-[8px] sm:text-[9px] text-white font-bold">
                        {{ $this->unreadCount > 9 ? '9+' : $this->unreadCount }}
                    </span>
                </span>
            @endif
        </div>
    </button>

    {{-- القائمة المنسدلة مضبوطة للجوال --}}
    <div x-show="open"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 translate-y-4 scale-95"
         x-transition:enter-end="opacity-100 translate-y-0 scale-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 translate-y-0 scale-100"
         x-transition:leave-end="opacity-0 translate-y-4 scale-95"
         style="display: none;"
         class="absolute left-0 mt-3 w-[calc(100vw-2rem)] max-w-[380px] sm:w-[380px] md:w-[420px] bg-white rounded-2xl shadow-xl border border-slate-200 overflow-hidden z-50 origin-top-left"
         :style="window.innerWidth < 640 ? 'right: 0; left: auto;' : ''">

        {{-- الهيدر مضبوط للجوال --}}
        <div class="px-4 sm:px-6 py-4 border-b border-slate-200 bg-white flex justify-between items-center">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 sm:w-10 sm:h-10 rounded-xl bg-emerald-100 border border-emerald-200 flex items-center justify-center">
                    <i class="fa-regular fa-bell text-emerald-600 text-sm sm:text-base"></i>
                </div>
                <div>
                    <h3 class="font-bold sm:font-black text-slate-900 text-base sm:text-lg">الإشعارات</h3>
                    <p class="text-[10px] sm:text-[11px] text-slate-500 font-medium mt-0.5 flex items-center gap-2">
                        <span class="w-1.5 h-1.5 sm:w-2 sm:h-2 bg-emerald-400 rounded-full"></span>
                        {{ $this->unreadCount > 0 ? $this->unreadCount . ' جديد' : 'جميع الإشعارات مقروءة' }}
                    </p>
                </div>
            </div>
            
            @if($this->unreadCount > 0)
                <button wire:click="markAllAsRead"
                        class="text-xs font-bold text-emerald-600 hover:text-emerald-700 bg-emerald-100 hover:bg-emerald-200 px-3 py-1.5 sm:px-4 sm:py-2.5 rounded-lg sm:rounded-xl border border-emerald-200 transition-all duration-300">
                    <span class="hidden sm:inline">تحديد الكل كمقروء</span>
                    <span class="sm:hidden text-[10px]">تحديد الكل</span>
                </button>
            @endif
        </div>

        <div class="max-h-[65vh] sm:max-h-[520px] overflow-y-auto bg-white custom-scrollbar-mobile">

            {{-- قسم الدعوات مضبوط للجوال --}}
            @if($this->invitations->count() > 0)
                <div class="px-4 sm:px-6 py-3 bg-emerald-50 border-y border-emerald-200">
                    <div class="flex items-center gap-2 sm:gap-3">
                        <div class="w-7 h-7 sm:w-8 sm:h-8 rounded-lg sm:rounded-xl bg-emerald-200 border border-emerald-300 flex items-center justify-center">
                            <i class="fa-solid fa-handshake text-emerald-700 text-xs sm:text-sm"></i>
                        </div>
                        <div>
                            <span class="text-xs font-bold text-emerald-800">طلبات الانضمام</span>
                            <p class="text-[10px] text-emerald-600">{{ $this->invitations->count() }} دعوة جديدة</p>
                        </div>
                    </div>
                </div>
                
                @foreach($this->invitations as $invite)
                    <div class="p-4 sm:p-6 border-b border-slate-100 hover:bg-emerald-50 transition-all duration-300 bg-white">
                        <div class="flex gap-3 sm:gap-4">
                            {{-- صورة المرسل --}}
                            <div class="relative shrink-0">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($invite->project->user->name) }}&background=10b981&color=fff&bold=true&size=64"
                                     class="w-10 h-10 sm:w-12 sm:h-12 rounded-xl sm:rounded-2xl border-2 border-white shadow-sm">
                                <div class="absolute -bottom-1 -right-1 w-5 h-5 sm:w-6 sm:h-6 bg-emerald-500 rounded-lg flex items-center justify-center text-[9px] text-white border border-white shadow-sm">
                                    <i class="fa-solid fa-plus"></i>
                                </div>
                            </div>
                            
                            {{-- محتوى الدعوة --}}
                            <div class="flex-1 min-w-0">
                                <p class="text-sm text-slate-700 leading-relaxed">
                                    <span class="font-bold text-slate-900">{{ $invite->project->user->name }}</span> يدعوك للانضمام
                                </p>
                                <h4 class="font-bold text-emerald-700 text-sm sm:text-base mt-1 mb-0.5 truncate">{{ $invite->project->title }}</h4>
                                <p class="text-xs text-slate-500 mb-3 sm:mb-4 line-clamp-2">{{ Str::limit($invite->project->description, 80) }}</p>
                                
                                {{-- أزرار القبول والرفض مضبوطة للجوال --}}
                                <div class="flex flex-col sm:flex-row gap-2">
                                    <button wire:click="accept({{ $invite->id }})"
                                            class="flex-1 bg-emerald-600 hover:bg-emerald-500 text-white text-xs sm:text-sm font-bold py-2 sm:py-3 px-3 sm:px-4 rounded-lg sm:rounded-xl transition-all shadow-sm hover:shadow-md">
                                        قبول الدعوة
                                    </button>
                                    
                                    <button wire:click="reject({{ $invite->id }})"
                                            class="flex-1 bg-white border border-slate-200 hover:border-red-200 hover:bg-red-50 text-slate-600 hover:text-red-600 text-xs sm:text-sm font-bold py-2 sm:py-3 px-3 sm:px-4 rounded-lg sm:rounded-xl transition-all duration-300">
                                        رفض
                                    </button>
                                </div>
                            </div>
                        </div>
                        
                        {{-- مؤشر الوقت --}}
                        <div class="mt-3 sm:absolute sm:top-4 sm:right-4">
                            <span class="text-[10px] font-medium text-slate-500 bg-slate-100 px-2 py-1 rounded-full flex items-center gap-1 w-fit">
                                <i class="fa-regular fa-clock text-[8px]"></i>
                                {{ $invite->created_at->diffForHumans() }}
                            </span>
                        </div>
                    </div>
                @endforeach
            @endif

            {{-- قسم الإشعارات العامة مضبوط للجوال --}}
            @if($this->notifications->count() > 0)
                <div class="px-4 sm:px-6 py-3 bg-slate-50 border-y border-slate-200">
                    <div class="flex items-center gap-2 sm:gap-3">
                        <div class="w-7 h-7 sm:w-8 sm:h-8 rounded-lg sm:rounded-xl bg-slate-200 border border-slate-300 flex items-center justify-center">
                            <i class="fa-solid fa-bolt text-slate-700 text-xs sm:text-sm"></i>
                        </div>
                        <div>
                            <span class="text-xs font-bold text-slate-800">النشاط الأخير</span>
                            <p class="text-[10px] text-slate-600">آخر تحديثات النظام</p>
                        </div>
                    </div>
                </div>
                
                @foreach($this->notifications as $notify)
                    <div class="relative p-4 sm:p-6 border-b border-slate-100 hover:bg-slate-50 transition-all duration-300 bg-white cursor-pointer"
                         wire:click="markAsRead('{{ $notify->id }}')">
                         
                        {{-- مؤشر القراءة --}}
                        @if(!$notify->read_at)
                            <div class="absolute right-0 top-0 bottom-0 w-1 bg-emerald-400 rounded-l-full"></div>
                        @endif
                        
                        <a href="{{ $notify->data['url'] }}" class="flex gap-3 sm:gap-4">
                            {{-- أيقونة الإشعار --}}
                            <div class="shrink-0 mt-0.5">
                                <div class="w-9 h-9 sm:w-10 sm:h-10 rounded-lg sm:rounded-xl bg-slate-100 border border-slate-200 flex items-center justify-center shadow-sm">
                                    <i class="fa-solid {{ $notify->data['icon'] }} text-sm {{ $notify->data['color'] }}"></i>
                                </div>
                            </div>
                            
                            {{-- محتوى الإشعار --}}
                            <div class="flex-1 min-w-0">
                                <div class="flex flex-col sm:flex-row sm:items-start justify-between gap-1 sm:gap-4 mb-1 sm:mb-2">
                                    <h4 class="text-sm font-bold text-slate-900 truncate">{{ $notify->data['title'] }}</h4>
                                    <span class="text-[10px] font-medium text-slate-500 bg-slate-100 px-2 py-0.5 sm:py-1 rounded-full shrink-0 w-fit">
                                        {{ $notify->created_at->diffForHumans() }}
                                    </span>
                                </div>
                                <p class="text-xs text-slate-600 leading-relaxed line-clamp-2 sm:line-clamp-3 mb-3">{{ $notify->data['message'] }}</p>
                                
                                {{-- نوع الإشعار --}}
                                <div class="flex items-center gap-1.5">
                                    <span class="text-[10px] font-medium px-2 py-0.5 rounded-full bg-slate-200 text-slate-700 border border-slate-300 flex items-center gap-1">
                                        <i class="fa-solid fa-tag text-[8px]"></i>
                                        {{ $notify->data['type'] ?? 'عام' }}
                                    </span>
                                    @if(!$notify->read_at)
                                    <span class="text-[10px] font-bold px-2 py-0.5 rounded-full bg-emerald-200 text-emerald-800 border border-emerald-300">
                                        جديد
                                    </span>
                                    @endif
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            @endif

            {{-- حالة عدم وجود إشعارات مضبوطة للجوال --}}
            @if($this->invitations->count() == 0 && $this->notifications->count() == 0)
                <div class="py-16 sm:py-24 text-center bg-white">
                    <div class="relative mb-6 sm:mb-8">
                        <div class="w-16 h-16 sm:w-20 sm:h-20 bg-slate-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                            <i class="fa-regular fa-bell-slash text-2xl sm:text-3xl text-slate-400"></i>
                        </div>
                    </div>
                    
                    <h4 class="text-slate-900 font-bold text-lg sm:text-xl mb-2">👋 لا توجد إشعارات</h4>
                    <p class="text-slate-600 text-sm max-w-xs mx-auto leading-relaxed px-4">
                        لا توجد تنبيهات جديدة في الوقت الحالي
                    </p>
                </div>
            @endif

        </div>

        {{-- الفوتر مضبوط للجوال --}}
        <div class="p-4 bg-slate-50 border-t border-slate-200 text-center">
            <a href="#" 
               class="text-xs font-bold text-slate-700 hover:text-emerald-700 transition-colors inline-flex items-center gap-1.5">
                <span>عرض جميع الإشعارات</span>
                <i class="fa-solid fa-arrow-left text-[10px]"></i>
            </a>
        </div>
    </div>
    <style>
    /* تحسينات للجوال */
    @media (max-width: 640px) {
        .max-h-\[65vh\] {
            max-height: 65vh !important;
        }
        
        .w-\[calc\(100vw-2rem\)\] {
            width: calc(100vw - 2rem) !important;
            max-width: 100% !important;
        }
    }
    
    /* تحسينات scrollbar للجوال */
    .custom-scrollbar-mobile::-webkit-scrollbar {
        width: 4px;
    }
    
    .custom-scrollbar-mobile::-webkit-scrollbar-track {
        background: #f1f5f9;
        border-radius: 10px;
    }
    
    .custom-scrollbar-mobile::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 10px;
    }
    
    .custom-scrollbar-mobile::-webkit-scrollbar-thumb:hover {
        background: #94a3b8;
    }
    
    /* تحسينات للنصوص في الجوال */
    @media (max-width: 480px) {
        .text-sm {
            font-size: 0.875rem;
        }
        
        .text-xs {
            font-size: 0.75rem;
        }
        
        .text-\[10px\] {
            font-size: 0.625rem;
        }
    }
    
    /* تحسينات للظلال في الجوال */
    @media (max-width: 640px) {
        .shadow-xl {
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
        }
    }
    
    /* تحسينات للحدود في الجوال */
    .border {
        border-width: 1px;
    }
    
    /* تحسينات للتباعد في الجوال */
    @media (max-width: 640px) {
        .p-4 {
            padding: 1rem;
        }
        
        .px-4 {
            padding-left: 1rem;
            padding-right: 1rem;
        }
        
        .py-3 {
            padding-top: 0.75rem;
            padding-bottom: 0.75rem;
        }
    }
    
    /* تحسينات للأزرار في الجوال */
    @media (max-width: 640px) {
        button, a {
            min-height: 44px; /* الحد الأدنى للمس في الجوال */
        }
        
        .py-2 {
            padding-top: 0.5rem;
            padding-bottom: 0.5rem;
        }
    }
    
    /* تحسينات للصور في الجوال */
    @media (max-width: 640px) {
        .w-10, .h-10 {
            width: 2.5rem;
            height: 2.5rem;
        }
        
        .w-9, .h-9 {
            width: 2.25rem;
            height: 2.25rem;
        }
    }
    
    /* تحسينات للخطوط */
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    .line-clamp-3 {
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    /* تأثيرات النبض */
    @keyframes ping {
        0%, 100% { transform: scale(1); opacity: 0.7; }
        50% { transform: scale(1.5); opacity: 0; }
    }
    
    .animate-ping {
        animation: ping 1.5s cubic-bezier(0, 0, 0.2, 1) infinite;
    }
</style>
</div>