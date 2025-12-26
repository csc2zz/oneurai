<div wire:poll.1s>
    @if($this->unreadCount > 0)
        <span class="bg-emerald-500 text-white text-[10px] font-bold px-1.5 rounded-full mr-auto shadow-sm shadow-emerald-500/20 min-w-[18px] text-center animate-pulse">
            {{ $this->unreadCount > 99 ? '+99' : $this->unreadCount }}
        </span>
    @endif
</div>
