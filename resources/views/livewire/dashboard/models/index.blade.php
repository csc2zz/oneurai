<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 animate-fade-in space-y-8">

    {{-- 1. الهيدر المطور (Hero Section) --}}
    <div class="relative bg-white border border-slate-200 rounded-2xl p-8 overflow-hidden shadow-sm group">
        {{-- خلفية جمالية --}}
        <div class="absolute top-0 right-0 w-64 h-64 bg-emerald-50 rounded-full blur-3xl opacity-50 -mr-16 -mt-16 group-hover:scale-110 transition-transform duration-1000"></div>
        <div class="absolute bottom-0 left-0 w-40 h-40 bg-indigo-50 rounded-full blur-2xl opacity-50 -ml-10 -mb-10"></div>

        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div>
                <div class="flex items-center gap-2 mb-2">
                    <span class="px-2 py-1 rounded-md bg-emerald-100 text-emerald-700 text-[10px] font-bold uppercase tracking-wider">AI Hub</span>
                    <span class="h-1 w-1 rounded-full bg-slate-300"></span>
                    <span class="text-xs text-slate-500 font-mono">{{ $models->count() }} Models Available</span>
                </div>
                <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight mb-2">
                    مكتبة النماذج الذكية
                </h1>
                <p class="text-slate-500 max-w-xl text-sm leading-relaxed">
                    استكشف، شارك، وقم بنشر أحدث نماذج الذكاء الاصطناعي. مكانك المفضل لإدارة خوارزميات التعلم العميق ومشاركة المعرفة.
                </p>
            </div>

            <a href="{{ route('dashboard.models.upload') }}" class="group bg-slate-900 hover:bg-emerald-600 text-white px-6 py-3 rounded-xl text-sm font-bold transition-all shadow-lg hover:shadow-emerald-500/30 flex items-center gap-3 whitespace-nowrap">
                <div class="bg-white/10 group-hover:bg-white/20 p-1.5 rounded-lg transition">
                    <i class="fa-solid fa-cloud-arrow-up text-xs"></i>
                </div>
                <span>رفع نموذج جديد</span>
            </a>
        </div>
    </div>

    {{-- 2. تنبيه إخلاء المسؤولية (بتصميم أنيق) --}}
    <div class="bg-amber-50/50 border border-amber-100 rounded-xl p-4 flex items-start gap-3">
        <i class="fa-solid fa-circle-info text-amber-500 mt-0.5"></i>
        <div class="text-xs text-amber-800 leading-relaxed">
            <span class="font-bold block mb-0.5">تنويه هام:</span>
            النماذج المتاحة هنا قد تكون قيد التطوير (Beta). استخدامك لها يعني تحملك المسؤولية الكاملة عن النتائج.
        </div>
    </div>

    {{-- 3. شريط التحكم (Search & Filters) --}}
    <div class="bg-white border border-slate-200 rounded-2xl p-2 shadow-sm flex flex-col lg:flex-row gap-2 sticky top-4 z-20">
        {{-- البحث --}}
        <div class="relative flex-grow">
            <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none text-slate-400">
                <i class="fa-solid fa-magnifying-glass"></i>
            </div>
            <input wire:model.live="search" type="text" placeholder="ابحث باسم النموذج، المهمة، أو المكتبة..."
                class="w-full bg-slate-50 hover:bg-white focus:bg-white border border-transparent focus:border-emerald-500 rounded-xl py-2.5 pr-11 pl-4 text-sm outline-none transition-all placeholder:text-slate-400">
        </div>

        {{-- الفلاتر --}}
        <div class="flex flex-col sm:flex-row gap-2">
            {{-- فلتر المهام --}}
            <div class="relative min-w-[180px]">
                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-slate-400">
                    <i class="fa-solid fa-filter text-xs"></i>
                </div>
                <select class="w-full appearance-none bg-slate-50 hover:bg-white focus:bg-white border border-transparent focus:border-emerald-500 rounded-xl py-2.5 pr-9 pl-8 text-sm text-slate-600 font-medium outline-none transition-all cursor-pointer">
                    <option>جميع المهام</option>
                    <option>Text Generation</option>
                    <option>Translation</option>
                    <option>Image Classification</option>
                    <option>Object Detection</option>
                </select>
            </div>

            {{-- فلتر المكتبة --}}
            <div class="relative min-w-[160px]">
                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-slate-400">
                    <i class="fa-solid fa-layer-group text-xs"></i>
                </div>
                <select class="w-full appearance-none bg-slate-50 hover:bg-white focus:bg-white border border-transparent focus:border-emerald-500 rounded-xl py-2.5 pr-9 pl-8 text-sm text-slate-600 font-medium outline-none transition-all cursor-pointer">
                    <option>المكتبة (All)</option>
                    <option>PyTorch</option>
                    <option>TensorFlow</option>
                    <option>Keras</option>
                    <option>Scikit-learn</option>
                </select>
            </div>
        </div>
    </div>

    {{-- 4. شبكة النماذج (Model Grid) --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($models as $model)
            <div class="group bg-white border border-slate-200 rounded-2xl p-5 hover:border-emerald-500/40 hover:shadow-[0_8px_30px_rgb(0,0,0,0.06)] hover:-translate-y-1 transition-all duration-300 relative overflow-hidden flex flex-col">

                {{-- شارة الحالة العلوية --}}
                <div class="flex justify-between items-start mb-4">
                    {{-- الأيقونة حسب المكتبة (افتراضي أو مخصص) --}}
                    <div class="w-12 h-12 rounded-xl flex items-center justify-center text-2xl shadow-sm transition-colors duration-300
                        {{ $model->library == 'PyTorch' ? 'bg-orange-50 text-orange-600 group-hover:bg-orange-100' :
                          ($model->library == 'TensorFlow' ? 'bg-yellow-50 text-yellow-600 group-hover:bg-yellow-100' :
                          'bg-indigo-50 text-indigo-600 group-hover:bg-indigo-100') }}">
                        @if($model->library == 'PyTorch') <i class="fa-solid fa-fire"></i>
                        @elseif($model->library == 'TensorFlow') <i class="fa-solid fa-cube"></i>
                        @else <i class="fa-solid fa-brain"></i>
                        @endif
                    </div>

                    {{-- حالة الخصوصية --}}
                    <span class="px-2 py-1 rounded-md text-[10px] font-bold uppercase tracking-wide border
                        {{ $model->is_public ? 'bg-emerald-50 text-emerald-700 border-emerald-100' : 'bg-slate-100 text-slate-600 border-slate-200' }}">
                        {{ $model->is_public ? 'Public' : 'Private' }}
                    </span>
                </div>

                {{-- العنوان والوصف --}}
                <div class="mb-4 flex-1">
                    <a href="{{ route('dashboard.models.view', ['username' => $model->user->username, 'slug' => $model->slug]) }}"
                       class="block text-lg font-extrabold text-slate-900 group-hover:text-emerald-600 transition-colors font-sans mb-1 line-clamp-1" dir="ltr">
                        {{ $model->title }}
                    </a>
                    <div class="flex flex-wrap gap-2 mb-3">
                         <span class="text-[10px] bg-slate-100 text-slate-500 px-2 py-0.5 rounded border border-slate-200">
                             {{ $model->task ?? 'General' }}
                         </span>
                         @if($model->language)
                            <span class="text-[10px] bg-blue-50 text-blue-600 px-2 py-0.5 rounded border border-blue-100">
                                {{ $model->language }}
                            </span>
                         @endif
                    </div>
                    <p class="text-slate-500 text-sm line-clamp-2 leading-relaxed h-10">
                        {{ $model->description ?? 'لا يوجد وصف متاح لهذا النموذج.' }}
                    </p>
                </div>

                {{-- الفوتر: إحصائيات --}}
                <div class="pt-4 border-t border-dashed border-slate-100 flex items-center justify-between text-xs text-slate-400 font-medium">
                    <div class="flex items-center gap-4">
                        <div class="flex items-center gap-1.5 hover:text-emerald-600 transition" title="التحميلات">
                            <i class="fa-solid fa-cloud-arrow-down"></i>
                            <span class="font-sans font-bold text-slate-600">{{ $model->downloads_count ?? 0 }}</span>
                        </div>
                        <div class="flex items-center gap-1.5 hover:text-amber-500 transition" title="الإعجابات">
                            <i class="fa-solid fa-star text-amber-400"></i>
                            <span class="font-sans font-bold text-slate-600">{{ $model->stars_count ?? 0 }}</span>
                        </div>
                    </div>

                    <div class="flex items-center gap-1.5" title="تاريخ التحديث">
                        <i class="fa-regular fa-clock"></i>
                        <span>{{ $model->updated_at->diffForHumans(null, true) }}</span>
                    </div>
                </div>

            </div>
        @empty
            {{-- حالة الفراغ --}}
            <div class="col-span-full py-16 flex flex-col items-center justify-center bg-white rounded-2xl border border-dashed border-slate-300">
                <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mb-4 text-slate-300 shadow-sm animate-pulse-slow">
                    <i class="fa-solid fa-microchip text-4xl"></i>
                </div>
                <h3 class="text-lg font-bold text-slate-900 mb-1">لا توجد نماذج حتى الآن</h3>
                <p class="text-slate-500 text-sm mb-6 max-w-xs text-center">لم تقم برفع أي نماذج ذكاء اصطناعي. ابدأ الآن وشارك ابتكارك.</p>
                <a href="{{ route('dashboard.models.upload') }}" class="text-emerald-600 font-bold text-sm hover:underline flex items-center gap-2">
                    <i class="fa-solid fa-plus"></i> إضافة نموذج جديد
                </a>
            </div>
        @endforelse
    </div>
</div>
