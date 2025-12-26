<div class="space-y-8" wire:poll.1s>

    {{-- رسائل النجاح --}}
    @if (session('success'))
        <div class="p-4 bg-emerald-50 border-l-4 border-emerald-500 text-emerald-700 rounded shadow-sm flex items-center gap-2">
            <i class="fa-solid fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif

    {{-- فورم الدعوة --}}
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6">
        <h3 class="font-bold text-slate-900 mb-4">دعوة عضو جديد</h3>
        <form wire:submit="inviteMember" class="flex flex-col sm:flex-row gap-3">
            <div class="flex-1 relative">
                <input wire:model="email" type="email" placeholder="البريد الإلكتروني للعضو"
                       class="w-full bg-slate-50 border border-slate-300 rounded-lg py-2.5 pr-10 pl-4 focus:ring-2 focus:ring-emerald-500 outline-none transition text-sm">
                <span class="absolute right-3 top-2.5 text-slate-400"><i class="fa-solid fa-envelope"></i></span>
                @error('email') <span class="text-red-500 text-xs absolute -bottom-5 right-0">{{ $message }}</span> @enderror
            </div>

            <div class="sm:w-40">
                <select wire:model="role" class="w-full bg-white border border-slate-300 rounded-lg py-2.5 px-3 text-sm text-slate-700 focus:ring-2 focus:ring-emerald-500 outline-none cursor-pointer">
                    <option value="read">مشاهد (Read)</option>
                    <option value="write">محرر (Write)</option>
                    <option value="admin">مدير (Admin)</option>
                </select>
            </div>

            <button type="submit" class="bg-emerald-600 text-white px-6 py-2.5 rounded-lg text-sm font-bold hover:bg-emerald-700 transition shadow-sm flex items-center gap-2 justify-center">
                <span wire:loading.remove wire:target="inviteMember">إرسال الدعوة</span>
                <span wire:loading wire:target="inviteMember"><i class="fa-solid fa-spinner animate-spin"></i></span>
            </button>
        </form>
    </div>

    {{-- قائمة الأعضاء --}}
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="bg-slate-50 px-6 py-4 border-b border-slate-100 flex justify-between items-center">
            <h3 class="font-bold text-slate-900">الأعضاء الحاليين <span class="bg-slate-200 text-slate-600 text-xs px-2 py-0.5 rounded-full mr-2">{{ $members->count() }}</span></h3>
        </div>

        <div class="divide-y divide-slate-100">
            @foreach($members as $member)
                <div class="p-4 flex items-center justify-between hover:bg-slate-50 transition">
                    <div class="flex items-center gap-3">
                        <img src="https://ui-avatars.com/api/?name={{ $member->name }}&background=random&color=fff" class="w-10 h-10 rounded-full">
                        <div>
                            <div class="flex items-center gap-2">
                                <span class="font-bold text-slate-900 text-sm block">{{ $member->username }}</span><x-admin-badge :user="$member" />
                                @if($project->user_id === $member->id)
                                    <span class="bg-emerald-100 text-emerald-700 text-[10px] font-bold px-2 py-0.5 rounded border border-emerald-200">المالك</span>
                                @endif
                            </div>
                            <span class="text-xs text-slate-500">{{ $member->email }}</span>
                        </div>
                    </div>

                    <div class="flex items-center gap-4">
                        @if($project->user_id !== $member->id)
                            {{-- تغيير الصلاحية --}}
                            <select wire:change="updateRole({{ $member->id }}, $event.target.value)"
                                    class="bg-white border border-slate-200 text-slate-700 text-xs rounded-lg py-1.5 px-2 focus:ring-emerald-500 cursor-pointer outline-none">
                                <option value="admin" {{ $member->pivot->role === 'admin' ? 'selected' : '' }}>مدير (Admin)</option>
                                <option value="write" {{ $member->pivot->role === 'write' ? 'selected' : '' }}>محرر (Write)</option>
                                <option value="read" {{ $member->pivot->role === 'read' ? 'selected' : '' }}>مشاهد (Read)</option>
                            </select>

                            {{-- زر الحذف --}}
                            <button wire:click="removeMember({{ $member->id }})" wire:confirm="هل أنت متأكد من إزالة هذا العضو؟"
                                    class="text-slate-400 hover:text-red-600 transition" title="إزالة العضو">
                                <i class="fa-solid fa-trash-can"></i>
                            </button>
                        @else
                            <div class="text-sm text-slate-400 font-medium px-3">صلاحية كاملة</div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    {{-- الدعوات المعلقة --}}
    @if($invitations->count() > 0)
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="bg-slate-50 px-6 py-4 border-b border-slate-100">
                <h3 class="font-bold text-slate-900 text-sm">الدعوات المعلقة</h3>
            </div>
            <div class="p-4 space-y-3">
                @foreach($invitations as $invite)
                    <div class="flex items-center justify-between p-3 border border-slate-100 rounded-lg bg-slate-50/50">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-slate-200 flex items-center justify-center text-slate-400">
                                <i class="fa-regular fa-envelope"></i>
                            </div>
                            <div>
                                <span class="font-bold text-slate-900 text-sm block">{{ $invite->email }}</span>
                                <span class="text-xs text-slate-500">
                                    الصلاحية: <span class="font-bold">{{ $invite->role }}</span> •
                                    <span class="text-amber-600">بانتظار القبول</span>
                                </span>
                            </div>
                        </div>
                        <div class="flex gap-2">
                            <button wire:click="cancelInvitation({{ $invite->id }})"
                                    class="text-xs text-red-500 hover:bg-red-50 px-3 py-1.5 rounded border border-red-200 transition">
                                إلغاء
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

</div>
