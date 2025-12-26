{{-- بداية كود التنبيهات في ملف Layout --}}
<div x-data="{
    toasts: [],
    add(type, title, message) {
        // تحسين: إضافة رقم عشوائي لمنع تكرار الـ ID في حال ظهور إشعارين في نفس اللحظة
        const id = Date.now() + Math.floor(Math.random() * 1000);

        const toast = { id, type, title, message, show: true };
        this.toasts.push(toast);

        // إزالة تلقائية بعد 6 ثواني
        setTimeout(() => {
            this.remove(id);
        }, 6000);
    },
    remove(id) {
        const index = this.toasts.findIndex(t => t.id === id);
        if (index > -1) {
            this.toasts[index].show = false;
            // انتظار الانيميشن ثم الحذف الفعلي
            setTimeout(() => {
                this.toasts = this.toasts.filter(t => t.id !== id);
            }, 500);
        }
    },
    getTheme(type) {
        const themes = {
            success: { bg: 'bg-white', iconBg: 'bg-emerald-50', iconText: 'text-emerald-600', border: 'border-emerald-100', progress: 'bg-emerald-500', icon: 'fa-circle-check' },
            error:   { bg: 'bg-white', iconBg: 'bg-red-50', iconText: 'text-red-500', border: 'border-red-100', progress: 'bg-red-500', icon: 'fa-circle-xmark' },
            warning: { bg: 'bg-white', iconBg: 'bg-amber-50', iconText: 'text-amber-500', border: 'border-amber-100', progress: 'bg-amber-500', icon: 'fa-triangle-exclamation' },
            info:    { bg: 'bg-white', iconBg: 'bg-blue-50', iconText: 'text-blue-500', border: 'border-blue-100', progress: 'bg-blue-500', icon: 'fa-circle-info' }
        };
        return themes[type] || themes.info;
    }
}"
@notify.window="add($event.detail.type, $event.detail.title, $event.detail.message)"
class="fixed top-5 right-5 z-[9999] flex flex-col gap-3 w-full max-w-md pointer-events-none"
dir="rtl">

    <style>
        @keyframes slideIn {
            0% { transform: translateX(110%); opacity: 0; }
            100% { transform: translateX(0); opacity: 1; }
        }
        .animate-slide-in {
            animation: slideIn 0.4s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .toast-progress {
            animation: progress 6s linear forwards;
        }
        @keyframes progress {
            to { width: 0%; }
        }
        .toast-card:hover .toast-progress {
            animation-play-state: paused;
        }
    </style>

    <template x-for="toast in toasts" :key="toast.id">
        <div x-show="toast.show"
             class="animate-slide-in"
             x-transition:leave="transition ease-in duration-300"
             x-transition:leave-start="translate-x-0 opacity-100 scale-100"
             x-transition:leave-end="translate-x-full opacity-0 scale-90">

            <div :class="`toast-card pointer-events-auto relative overflow-hidden w-full rounded-xl border shadow-lg shadow-slate-200/50 p-4 flex items-start gap-3 hover:translate-x-[-5px] hover:shadow-xl transition-all ${getTheme(toast.type).bg} ${getTheme(toast.type).border}`">

                {{-- Icon --}}
                <div :class="`flex-shrink-0 w-10 h-10 rounded-full flex items-center justify-center text-xl ${getTheme(toast.type).iconBg} ${getTheme(toast.type).iconText}`">
                    <i :class="`fa-solid ${getTheme(toast.type).icon}`"></i>
                </div>

                {{-- Content --}}
                <div class="flex-1 pt-0.5">
                    <h4 class="text-sm font-bold text-slate-800 leading-tight" x-text="toast.title"></h4>

                    {{-- استخدام x-html لظهور القوائم بشكل صحيح --}}
                    <div x-show="toast.message"
                         class="text-xs text-slate-500 mt-1 leading-relaxed"
                         x-html="toast.message">
                    </div>
                </div>

                {{-- Close Button --}}
                <button @click="remove(toast.id)" class="text-slate-400 hover:text-slate-600 transition p-1">
                    <i class="fa-solid fa-xmark text-sm"></i>
                </button>

                {{-- Progress Bar --}}
                <div :class="`toast-progress absolute bottom-0 right-0 h-[3px] w-full ${getTheme(toast.type).progress}`"></div>
            </div>
        </div>
    </template>
</div>
{{-- نهاية كود التنبيهات --}}
