@props(['user'])

@if($user && $user->is_admin)
    @once
        <style>
            @keyframes royal-pulse {
                0%, 92% { transform: scale(1); filter: drop-shadow(0 0 0 rgba(16, 185, 129, 0)); }
                94% { transform: scale(1.25); filter: drop-shadow(0 0 4px rgba(52, 211, 153, 0.6)); }
                96% { transform: scale(0.95); }
                98% { transform: scale(1.2); filter: drop-shadow(0 0 8px rgba(52, 211, 153, 0.8)); }
                100% { transform: scale(1); filter: drop-shadow(0 0 0 rgba(16, 185, 129, 0)); }
            }
            .luxury-badge { animation: royal-pulse 15s infinite ease-in-out; transform-origin: center; }
        </style>
    @endonce

    {{-- التعديل هنا: استخدام inline-flex ومحاذاة self-center --}}
    <div class="inline-flex items-center justify-center align-middle self-center relative group/badge z-50 ltr:ml-1 rtl:mr-1">
        <i class="fa-solid fa-circle-check text-emerald-500 text-[12px] cursor-help luxury-badge"></i>

        <div class="absolute bottom-full mb-2 left-1/2 -translate-x-1/2 hidden group-hover/badge:block w-max bg-slate-900 border border-slate-700 text-white text-[10px] px-2 py-1 rounded shadow-xl">
            فريق Oneurai الرسمي
            <div class="absolute top-full left-1/2 -translate-x-1/2 border-4 border-transparent border-t-slate-900"></div>
        </div>
    </div>
@endif