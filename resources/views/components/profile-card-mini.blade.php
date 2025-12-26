@props(['user'])

<div class="bg-white border border-slate-200 rounded-xl p-5 shadow-sm group hover:shadow-md transition-all duration-300">
    <h3 class="font-bold text-slate-900 text-sm mb-4 border-b border-slate-100 pb-2 flex justify-between items-center">
        <span>مطور النموذج</span>
        <i class="fa-solid fa-code text-emerald-500 bg-emerald-50 p-1.5 rounded-md text-xs"></i>
    </h3>

    <div class="flex items-center gap-3 mb-4">
        {{-- الصورة الرمزية --}}
        <a href="{{ route('profile.show', $user->username) }}" class="shrink-0 relative">
            @if($user->avatar)
                 <img src="{{ asset('storage/'.$user->avatar) }}" class="w-12 h-12 rounded-full border-2 border-white shadow-sm object-cover group-hover:scale-105 transition-transform duration-300">
            @else
                 <img src="https://ui-avatars.com/api/?name={{ $user->name }}&background=random&color=fff" class="w-12 h-12 rounded-full border-2 border-white shadow-sm group-hover:scale-105 transition-transform duration-300">
            @endif
            {{-- نقطة الحالة (أونلاين/أوفلاين) اختيارية --}}
            <span class="absolute bottom-0 right-0 w-3 h-3 border-2 border-white rounded-full {{ $user->isOnline() ? 'bg-emerald-500' : 'bg-slate-300' }}"
      title="{{ $user->isOnline() ? 'متصل الآن' : 'غير متصل' }}">
</span>
        </a>

        {{-- الاسم واليوزر --}}
        <div class="overflow-hidden">
            <div class="flex items-center gap-1">
                <a href="{{ route('profile.show', $user->username) }}" class="text-sm font-bold text-slate-800 hover:text-emerald-600 truncate transition max-w-[120px]">
                    {{ $user->name }}
                </a>
                {{-- استدعاء الشارة هنا --}}
                <x-admin-badge :user="$user" />
            </div>
            <span class="text-xs text-right text-slate-400 block font-mono" dir="ltr">{{ '@' . $user->username }}</span>
        </div>
    </div>

    {{-- إحصائيات سريعة --}}
    <div class="grid grid-cols-3 gap-2 border-t border-slate-50 pt-3 mb-4">
        <div class="text-center">
             <span class="block font-bold text-slate-800 text-sm">{{ $user->aiModels()->count() }}</span>
             <span class="text-[10px] text-slate-400">نماذج</span>
        </div>
        <div class="text-center border-r border-l border-slate-50">
             <span class="block font-bold text-slate-800 text-sm">{{ $user->projects()->count() }}</span>
             <span class="text-[10px] text-slate-400">مشاريع</span>
        </div>
         <div class="text-center">
             <span class="block font-bold text-slate-800 text-sm">{{ $user->followers()->count() }}</span>
             <span class="text-[10px] text-slate-400">متابعين</span>
        </div>
    </div>

    {{-- زر الزيارة --}}
    <a href="{{ route('profile.show', $user->username) }}" class="block w-full bg-slate-900 hover:bg-emerald-600 text-white text-xs font-bold py-2.5 rounded-lg text-center transition shadow-lg hover:shadow-emerald-500/20">
        زيارة الملف الشخصي <i class="fa-solid fa-arrow-left mr-1 text-[10px]"></i>
    </a>
</div>
