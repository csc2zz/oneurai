<div class="px-4 py-8 sm:px-0">
    @include('partials.settings-heading', [
        'title' => 'رموز API',
        'description' => 'إدارة الرموز التي تسمح للأنظمة الخارجية بالوصول إلى حسابك ونماذجك.'
    ])

    <div class="mt-6 bg-white shadow-xl rounded-lg overflow-hidden">

        <div class="p-4 bg-slate-50 border-b border-slate-200 flex justify-end">
            <button wire:click="$set('showCreateTokenModal', true)" class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-2 px-4 rounded transition">
                <i class="fa-solid fa-plus ml-2"></i> إنشاء رمز جديد
            </button>
        </div>

        <div class="divide-y divide-slate-200">
            @forelse($this->tokens as $token)
                <div class="p-4 flex items-center justify-between hover:bg-slate-50 transition group">
                    <div>
                        <div class="font-bold text-slate-800 text-sm mb-1">{{ $token->name }}</div>
                        <div class="text-xs text-slate-500 font-mono" dir="ltr">
                            {{ Str::substr($token->token, 0, 8) . '...' . Str::substr($token->token, -4) }}
                        </div>
                    </div>
                    <div class="text-right ml-4">
                        <div class="text-xs text-slate-500 mb-1">
                            آخر استخدام:
                            @if($token->last_used_at)
                                {{ $token->last_used_at->diffForHumans() }}
                            @else
                                لم يستخدم بعد
                            @endif
                        </div>
                        <div class="text-[10px] text-slate-400">أنشئ: {{ $token->created_at->diffForHumans() }}</div>
                    </div>
                    <button wire:click="deleteToken({{ $token->id }})" class="text-slate-400 hover:text-red-600 p-2 transition" title="حذف الرمز">
                        <i class="fa-regular fa-trash-can"></i>
                    </button>
                </div>
            @empty
                <div class="p-4 text-center text-slate-500">
                    لا يوجد رموز API نشطة حالياً.
                </div>
            @endforelse
        </div>
    </div>

    @if($showCreateTokenModal)
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div @click.away="$set('showCreateTokenModal', false)" class="bg-white rounded-lg shadow-xl w-full max-w-md p-6" dir="rtl">
                <h3 class="text-lg font-bold mb-4">إنشاء رمز API جديد</h3>

                @if($plainTextToken)
                    <div class="bg-emerald-50 border border-emerald-200 p-4 rounded-lg mb-4">
                        <p class="font-bold text-emerald-700 mb-2">تم إنشاء الرمز بنجاح!</p>
                        <p class="text-sm text-emerald-900 break-all" dir="ltr">{{ $plainTextToken }}</p>
                        <p class="text-xs mt-2 text-red-600">**هام:** هذا هو الظهور الوحيد للرمز. تأكد من نسخه الآن.</p>
                    </div>
                    <button wire:click="$set('showCreateTokenModal', false)" class="bg-slate-600 hover:bg-slate-700 text-white font-bold py-2 px-4 rounded transition w-full">إغلاق</button>
                @else
                    <form wire:submit.prevent="createNewToken">
                        <div class="mb-4">
                            <label for="tokenName" class="block text-sm font-medium text-slate-700 mb-1">اسم الرمز</label>
                            <input type="text" id="tokenName" wire:model.defer="tokenName" class="w-full border border-slate-300 p-2 rounded-lg" placeholder="مثال: API للمشروع التجريبي">
                            @error('tokenName') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="flex justify-end space-x-2 space-x-reverse">
                            <button type="button" wire:click="$set('showCreateTokenModal', false)" class="bg-slate-200 hover:bg-slate-300 text-slate-800 font-bold py-2 px-4 rounded transition">إلغاء</button>
                            <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-2 px-4 rounded transition" wire:loading.attr="disabled">
                                <span wire:loading.remove>إنشاء الرمز</span>
                                <span wire:loading>جاري الإنشاء...</span>
                            </button>
                        </div>
                    </form>
                @endif

            </div>
        </div>
    @endif
</div>
