<x-layouts.profile :user="$user" active-tab="models">

    <div class="animate-fade-in">
        {{-- عنوان الشريط --}}
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-bold text-emerald-500">النماذج المنشورة</h2>

            {{-- زر إضافة نموذج (يظهر للمالك فقط) --}}
            @if(auth()->id() === $user->id)
                <a href="{{ route('dashboard.models.upload') }}" class="bg-emerald-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-emerald-700 transition">
                    <i class="fa-solid fa-plus ml-2"></i> إضافة نموذج
                </a>
            @endif
        </div>

        {{-- قائمة النماذج --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @forelse($models as $model)
                <div class="border border-slate-200 rounded-xl p-5 bg-white hover:border-emerald-400 transition group flex flex-col h-full">
                    <div class="flex items-start justify-between mb-3">
                    <div class="flex items-center gap-3 mb-3">
                        <div class="w-10 h-10 rounded-lg bg-emerald-50 flex items-center justify-center text-emerald-600 shrink-0">
                            <i class="fa-solid fa-cube text-lg"></i>
                        </div>
                        <div class="overflow-hidden">
                            {{-- استخدام title بدلاً من name --}}
                            <a href="{{ route('models.show', [$user->username, $model->slug]) }}" class="block font-bold text-slate-900 group-hover:text-emerald-600 transition truncate" title="{{ $model->title }}">
                                {{ $model->title }}
                            </a>
                            <p class="text-xs text-slate-500">تم التحديث {{ $model->updated_at->diffForHumans() }}</p>
                        </div>
                        </div>
                        @if($model->visibility === 'private')
    <span class="bg-amber-50 text-amber-600 text-xs px-2 py-1 rounded-md border border-amber-100 flex items-center gap-1">
        <i class="fa-solid fa-lock text-[10px]"></i> خاص
    </span>
@else
     <span class="bg-emerald-50 text-emerald-600 text-xs px-2 py-1 rounded-md border border-emerald-100 flex items-center gap-1">
        <i class="fa-solid fa-globe text-[10px]"></i> عام
    </span>
@endif
                    </div>

                    <p class="text-sm text-slate-600 mb-4 line-clamp-2 flex-grow">
                        {{ $model->description ?? 'لا يوجد وصف لهذا النموذج.' }}
                    </p>

                    <div class="flex items-center justify-between text-xs text-slate-500 border-t border-slate-100 pt-3 mt-auto">
                        <div class="flex items-center gap-3">
                            <span title="عدد التحميلات"><i class="fa-solid fa-download mr-1"></i> {{ $model->downloads_count }}</span>
                            <span title="عدد الإعجابات"><i class="fa-solid fa-heart mr-1"></i> {{ $model->likes_count }}</span>
                        </div>
                        {{-- استخدام task لعرض نوع المهمة --}}
                        <span class="bg-slate-100 px-2 py-1 rounded text-slate-600 truncate max-w-[100px]">
                            {{ $model->task ?? 'Model' }}
                        </span>
                    </div>
                </div>
            @empty
                {{-- حالة عدم وجود بيانات --}}
                <div class="col-span-full py-16 text-center border border-dashed border-slate-300 rounded-xl bg-slate-50/50">
                    <div class="w-16 h-16 bg-slate-100 text-slate-400 rounded-full flex items-center justify-center mx-auto mb-4 text-2xl">
                        <i class="fa-solid fa-cubes-stacked"></i>
                    </div>
                    <h3 class="text-slate-900 font-bold mb-1">لا توجد نماذج بعد</h3>
                    <p class="text-slate-500 text-sm">لم يقم هذا المستخدم بنشر أي نماذج ذكاء اصطناعي حتى الآن.</p>
                </div>
            @endforelse
        </div>
    </div>

</x-layouts.profile>
