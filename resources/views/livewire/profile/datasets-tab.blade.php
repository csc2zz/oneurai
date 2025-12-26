<x-layouts.profile :user="$user" activeTab="datasets">

    {{-- عنوان القسم --}}
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-xl font-bold text-emerald-500 flex items-center gap-2">
            <i class="fa-solid fa-database text-emerald-600"></i>
            مجموعات البيانات
            <span class="text-sm font-normal text-slate-500 bg-slate-100 px-2 py-0.5 rounded-full">
                {{ $datasets->count() }}
            </span>
        </h2>

        @if(auth()->id() === $user->id)
            <a href="{{ route('projects.create', ['type' => 'dataset']) }}" class="bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-bold py-2 px-4 rounded-lg transition shadow-sm flex items-center gap-2">
                <i class="fa-solid fa-plus"></i> رفع بيانات جديدة
            </a>
        @endif
    </div>

    {{-- شبكة عرض البيانات --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        @forelse($datasets as $dataset)
            <div class="bg-white border border-slate-200 rounded-xl p-5 hover:border-emerald-500 transition group relative flex flex-col h-full">

                {{-- الجزء العلوي: الأيقونة والعنوان --}}
                <div class="flex items-start justify-between mb-3">
                    <div class="flex items-start gap-3">
                        <div class="w-10 h-10 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center shrink-0">
                            <i class="fa-solid fa-table text-lg"></i>
                        </div>
                        <div>
                            <a href="{{ route('datasets.public.show', [$user->username, $dataset->slug]) }}" class="font-bold text-slate-900 hover:text-emerald-600 hover:underline line-clamp-1 text-lg">
                                {{ $dataset->title }}
                            </a>
                            <p class="text-xs text-slate-500 font-mono mt-0.5">{{ $dataset->slug }}</p>
                        </div>
                    </div>

                    {{-- حالة الخصوصية --}}
                   {{-- التحقق بناءً على قيمة visibility --}}
@if($dataset->visibility === 'private')
    <span class="bg-amber-50 text-amber-600 text-xs px-2 py-1 rounded-md border border-amber-100 flex items-center gap-1">
        <i class="fa-solid fa-lock text-[10px]"></i> خاص
    </span>
@else
     <span class="bg-emerald-50 text-emerald-600 text-xs px-2 py-1 rounded-md border border-emerald-100 flex items-center gap-1">
        <i class="fa-solid fa-globe text-[10px]"></i> عام
    </span>
@endif
                </div>

                {{-- الوصف --}}
                <p class="text-slate-600 text-sm mb-4 line-clamp-2 flex-grow">
                    {{ $dataset->description ?? 'لا يوجد وصف متاح لهذه البيانات.' }}
                </p>

                {{-- الفوتر: معلومات إضافية --}}
                <div class="flex items-center justify-between text-xs text-slate-400 pt-4 border-t border-slate-100 mt-auto">
                    <div class="flex items-center gap-4">
                        <span class="flex items-center gap-1" title="حجم البيانات">
                            <i class="fa-solid fa-hard-drive"></i>
                            {{ \Illuminate\Support\Number::fileSize($dataset->size_bytes ?? 0) }}
                        </span>
                        <span class="flex items-center gap-1" title="عدد الملفات">
                            <i class="fa-solid fa-file"></i>
                            {{ $dataset->files_count ?? 0 }}
                        </span>
                    </div>
                    <span title="تاريخ التحديث">
                        {{ $dataset->updated_at->diffForHumans() }}
                    </span>
                </div>
            </div>
        @empty
            {{-- حالة عدم وجود بيانات --}}
            <div class="col-span-1 md:col-span-2 py-12 text-center bg-slate-50 rounded-xl border border-dashed border-slate-300">
                <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center mx-auto mb-4 shadow-sm text-slate-300">
                    <i class="fa-solid fa-database text-3xl"></i>
                </div>
                <h3 class="text-slate-900 font-bold text-lg mb-1">لا توجد مجموعات بيانات</h3>
                <p class="text-slate-500 text-sm mb-6">لم يقم هذا المستخدم برفع أي بيانات حتى الآن.</p>

                @if(auth()->id() === $user->id)
                    <a href="{{ route('projects.create', ['type' => 'dataset']) }}" class="text-emerald-600 hover:text-emerald-700 font-bold text-sm hover:underline">
                        + رفع أول مجموعة بيانات
                    </a>
                @endif
            </div>
        @endforelse
    </div>

</x-layouts.profile>
