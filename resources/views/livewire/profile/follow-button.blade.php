<div class="flex flex-col items-center lg:items-start w-full">

    {{-- لا نظهر الزر إذا كان الشخص يزور بروفايله بنفسه --}}
    @if(auth()->id() !== $user->id)
        <button wire:click="toggleFollow"
                wire:loading.attr="disabled"
                class="w-full mb-4 px-6 py-2 rounded-lg font-bold text-sm transition shadow-sm flex items-center justify-center gap-2
                {{ $isFollowing
                    ? 'bg-white text-slate-700 hover:text-red-600 border border-slate-300 hover:bg-red-50'
                    : 'bg-slate-900 text-white hover:bg-slate-800 border border-transparent'
                }}">

            <span wire:loading.remove>
                @if($isFollowing)
                    <i class="fa-solid fa-check ml-1"></i> متابع
                @else
                    <i class="fa-solid fa-plus ml-1"></i> متابعة
                @endif
            </span>

            {{-- أيقونة التحميل --}}
            <span wire:loading>
                <i class="fa-solid fa-spinner animate-spin"></i> جاري...
            </span>
        </button>
    @endif
</div>
