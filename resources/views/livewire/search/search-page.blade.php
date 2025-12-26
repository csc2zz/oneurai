<div class="min-h-screen bg-slate-50 pt-32 pb-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        {{-- هيدر البحث --}}
        <div class="mb-12 space-y-8">
            <nav class="flex items-center gap-2 text-xs font-bold text-slate-400 uppercase tracking-widest">
                <a href="/" class="hover:text-emerald-600 transition">الرئيسية</a>
                <i class="fa-solid fa-chevron-left text-[8px]"></i>
                <span class="text-slate-900">محرك البحث الشامل</span>
            </nav>

            <div class="flex flex-col md:flex-row justify-between items-start md:items-end gap-6">
                <div>
                    <h1 class="text-4xl font-black text-slate-900">نتائج البحث عن <span class="text-emerald-600">"{{ $q }}"</span></h1>
                    <p class="text-slate-500 mt-2 font-medium">استكشف كل ما يتعلق بـ {{ $q }} في منصة Oneurai</p>
                </div>
                
                {{-- أزرار التبديل (Tabs) --}}
                <div class="flex bg-slate-200/50 p-1.5 rounded-2xl overflow-x-auto w-full md:w-auto no-scrollbar border border-slate-200/50">
                    @foreach(['all' => 'الكل', 'projects' => 'المشاريع', 'models' => 'النماذج', 'datasets' => 'البيانات', 'users' => 'المطورين'] as $key => $label)
                        <button wire:click="$set('type', '{{ $key }}')"
                                class="px-6 py-2.5 rounded-xl text-sm font-black transition-all whitespace-nowrap
                                {{ $type === $key ? 'bg-white text-emerald-600 shadow-lg shadow-slate-200' : 'text-slate-500 hover:text-slate-800' }}">
                            {{ $label }}
                        </button>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="space-y-16">
            
            {{-- 1. نتائج نماذج AI --}}
            @if($results['models']->count() > 0)
            <section>
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-xl font-black text-slate-800 flex items-center gap-3">
                        <span class="w-2 h-6 bg-emerald-500 rounded-full"></span> نماذج الذكاء الاصطناعي
                    </h2>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($results['models'] as $model)
                        <a href="{{ route('models.show', [$model->user->username, $model->slug]) }}" class="bg-white border border-slate-200 rounded-[2rem] p-6 hover:border-emerald-500 hover:shadow-xl transition-all group">
                            <div class="w-14 h-14 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-2xl mb-4 group-hover:scale-110 transition-transform">
                                <i class="fa-solid fa-brain"></i>
                            </div>
                            <h3 class="text-lg font-black text-slate-800 mb-2">{{ $model->title }}</h3>
                            <p class="text-xs text-slate-400 font-bold uppercase">@ {{ $model->user->username }}</p>
                        </a>
                    @endforeach
                </div>
            </section>
            @endif

            {{-- 2. نتائج الداتا سيت (الجديد) --}}
            @if($results['datasets']->count() > 0)
            <section>
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-xl font-black text-slate-800 flex items-center gap-3">
                        <span class="w-2 h-6 bg-cyan-500 rounded-full"></span> مجموعات البيانات 
                    </h2>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @foreach($results['datasets'] as $dataset)
                        <a href="{{ route('datasets.public.show', [$dataset->user->username, $dataset->slug]) }}" class="flex items-center gap-6 bg-white p-6 rounded-[2rem] border border-slate-100 hover:shadow-2xl hover:shadow-cyan-500/5 transition-all group">
                            <div class="w-16 h-16 rounded-2xl bg-cyan-50 text-cyan-600 flex items-center justify-center text-3xl group-hover:bg-cyan-600 group-hover:text-white transition-all">
                                <i class="fa-solid fa-database"></i>
                            </div>
                            <div class="flex-1">
                                <h3 class="text-lg font-black text-slate-800 mb-1">{{ $dataset->title }}</h3>
                                <p class="text-xs text-slate-500 line-clamp-1 mb-3">{{ $dataset->description ?? 'لا يوجد وصف.' }}</p>
                                <div class="flex items-center gap-3">
                                    <span class="text-[10px] font-black text-cyan-600 bg-cyan-50 px-2 py-0.5 rounded-md uppercase">Data Hub</span>
                                    <span class="text-[10px] font-bold text-slate-400 italic">بواسطة {{ $dataset->user->name }}</span>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
                <div class="mt-6">{{ $results['datasets']->links() }}</div>
            </section>
            @endif

            {{-- 3. نتائج المشاريع --}}
            @if($results['projects']->count() > 0)
            <section>
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-xl font-black text-slate-800 flex items-center gap-3">
                        <span class="w-2 h-6 bg-blue-500 rounded-full"></span> المستودعات البرمجية
                    </h2>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @foreach($results['projects'] as $project)
                        <a href="{{ route('projects.show', [$project->user->username, $project->slug]) }}" class="bg-white p-8 rounded-[2.5rem] border border-slate-200 hover:border-blue-500 hover:shadow-xl transition-all">
                            <div class="flex justify-between items-start mb-6">
                                <i class="fa-solid fa-code text-3xl text-slate-200"></i>
                                <span class="px-3 py-1 bg-slate-100 rounded-lg text-[10px] font-black text-slate-500 uppercase tracking-tighter">{{ $project->language ?? 'Source' }}</span>
                            </div>
                            <h3 class="text-xl font-black text-slate-900 mb-2">{{ $project->title }}</h3>
                            <p class="text-sm text-slate-500 leading-relaxed line-clamp-2">{{ $project->description }}</p>
                        </a>
                    @endforeach
                </div>
                <div class="mt-6">{{ $results['projects']->links() }}</div>
            </section>
            @endif

            {{-- حالة عدم وجود نتائج --}}
            @if(collect($results)->flatten()->isEmpty())
                <div class="py-32 text-center bg-white rounded-[3rem] border border-dashed border-slate-200">
                    <div class="w-24 h-24 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-6 text-slate-200 text-4xl">
                        <i class="fa-solid fa-magnifying-glass-chart"></i>
                    </div>
                    <h3 class="text-2xl font-black text-slate-900 mb-2">لم نجد أي نتائج لـ "{{ $q }}"</h3>
                    <p class="text-slate-500 max-w-sm mx-auto">تأكد من كتابة الكلمات بشكل صحيح أو جرب البحث بتصنيفات أخرى.</p>
                </div>
            @endif

        </div>
    </div>
</div>