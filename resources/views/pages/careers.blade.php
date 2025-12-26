<x-layouts.app>
    <x-slot:title>الوظائف | Oneurai</x-slot:title>

    <div class="bg-slate-900  py-20 relative overflow-hidden">
        <div class="absolute top-0 left-0 w-full h-full bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjAiIGhlaWdodD0iMjAiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PGNpcmNsZSBjeD0iMSIgY3k9IjEiIHI9IjEiIGZpbGw9InJnYmEoMjU1LDI1NSwyNTUsMC4wNSkiLz48L3N2Zz4=')] opacity-20"></div>
        <div class="absolute bottom-0 right-0 w-96 h-96 bg-emerald-600/20 rounded-full blur-3xl translate-y-1/2 translate-x-1/2"></div>

        <div class="max-w-7xl mt-8 mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
            <span class="text-emerald-400 font-bold tracking-wider uppercase text-sm mb-4 block">انضم إلينا</span>
            <h1 class="text-4xl md:text-6xl font-bold text-white mb-6 leading-tight">
                ساهم في بناء <br>
                <span class="text-emerald-500">مستقبل الذكاء الاصطناعي.</span>
            </h1>
            <p class="text-slate-300 text-lg max-w-2xl mx-auto mb-10 leading-relaxed">
                نحن نبحث عن المبدعين، المهندسين، والحالمين الذين يرغبون في ترك بصمة في عالم التقنية المفتوحة المصدر وتمكين المطورين العرب.
            </p>
            <div class="flex justify-center gap-4">
                <a href="#open-positions" class="bg-white text-slate-900 hover:bg-slate-100 px-8 py-3.5 rounded-full font-bold transition shadow-lg">
                    تصفح الوظائف
                </a>
            </div>
        </div>
    </div>

    <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-bold text-slate-900">لماذا العمل في Oneurai؟</h2>
                <p class="text-slate-500 mt-2">نحن نهتم بفريقنا بقدر اهتمامنا بمنتجاتنا.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="p-6 rounded-2xl bg-slate-50 border border-slate-100 hover:border-emerald-200 transition duration-300">
                    <div class="w-12 h-12 bg-emerald-100 text-emerald-600 rounded-xl flex items-center justify-center text-xl mb-4">
                        <i class="fa-solid fa-laptop-house"></i>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 mb-2">العمل عن بعد</h3>
                    <p class="text-slate-600 text-sm leading-relaxed">
                        نؤمن بالإنتاجية لا بالحضور. اعمل من الرياض، جدة، أو أي مكان تفضله في العالم.
                    </p>
                </div>

                <div class="p-6 rounded-2xl bg-slate-50 border border-slate-100 hover:border-emerald-200 transition duration-300">
                    <div class="w-12 h-12 bg-blue-100 text-blue-600 rounded-xl flex items-center justify-center text-xl mb-4">
                        <i class="fa-solid fa-heart-pulse"></i>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 mb-2">تأمين شامل</h3>
                    <p class="text-slate-600 text-sm leading-relaxed">
                        تأمين طبي VIP لك ولعائلتك، يشمل العيادات والأسنان والنظر، لأن صحتك أولويتنا.
                    </p>
                </div>

                <div class="p-6 rounded-2xl bg-slate-50 border border-slate-100 hover:border-emerald-200 transition duration-300">
                    <div class="w-12 h-12 bg-amber-100 text-amber-600 rounded-xl flex items-center justify-center text-xl mb-4">
                        <i class="fa-solid fa-chart-line"></i>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 mb-2">تطوير مستمر</h3>
                    <p class="text-slate-600 text-sm leading-relaxed">
                        ميزانية سنوية للدورات التدريبية، المؤتمرات، والكتب لمساعدتك على البقاء في قمة مجالك.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <section id="open-positions" class="py-20 bg-slate-50 border-y border-slate-200">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row justify-between items-end mb-10 gap-4">
                <div>
                    <h2 class="text-3xl font-bold text-slate-900">الوظائف المتاحة</h2>
                    <p class="text-slate-500 mt-2">قمنا بتحليل ملفك الشخصي ووجدنا هذه الفرص المناسبة لك.</p>
                </div>

                <div class="flex gap-2 overflow-x-auto pb-1">
                    <button class="px-4 py-2 bg-slate-900 text-white rounded-full text-sm font-bold transition">الكل</button>
                    <button class="px-4 py-2 bg-white border border-slate-200 text-slate-600 hover:border-emerald-500 hover:text-emerald-600 rounded-full text-sm transition">هندسة</button>
                    <button class="px-4 py-2 bg-white border border-slate-200 text-slate-600 hover:border-emerald-500 hover:text-emerald-600 rounded-full text-sm transition">ذكاء اصطناعي</button>
                </div>
            </div>

            <div class="space-y-6">
                {{-- وظيفة 1 --}}
                <div class="bg-white rounded-xl p-6 border border-slate-200 hover:border-emerald-500 hover:shadow-lg transition group cursor-pointer relative overflow-hidden">
                    <div class="absolute top-0 left-0 bg-emerald-500 text-white text-[10px] px-3 py-1 rounded-br-lg font-bold">تطابق عالي</div>

                    <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
                        <div>
                            <h3 class="text-lg font-bold text-slate-900 group-hover:text-emerald-600 transition">AI Research Scientist (NLP)</h3>
                            <div class="flex flex-wrap items-center gap-4 mt-2 text-sm text-slate-500">
                                <span class="flex items-center gap-1"><i class="fa-solid fa-brain"></i> الذكاء الاصطناعي</span>
                                <span class="flex items-center gap-1"><i class="fa-solid fa-location-dot"></i> الرياض</span>
                            </div>
                        </div>
                        <button class="text-emerald-600 font-bold text-sm group-hover:translate-x-[-5px] transition flex items-center gap-2">
                            قدم الآن <i class="fa-solid fa-arrow-left"></i>
                        </button>
                    </div>

                    <div class="mt-5 pt-4 border-t border-slate-100">
                        <div class="flex justify-between items-end mb-2">
                            <div>
                                <span class="text-xs font-bold text-slate-700 block mb-1">مدى تطابق مهاراتك</span>
                                <div class="flex gap-2 text-[10px] text-slate-500">
                                    <span class="flex items-center gap-1 text-emerald-600 bg-emerald-50 px-1.5 py-0.5 rounded"><i class="fa-solid fa-check"></i> Python</span>
                                    <span class="flex items-center gap-1 text-emerald-600 bg-emerald-50 px-1.5 py-0.5 rounded"><i class="fa-solid fa-check"></i> TensorFlow</span>
                                    <span class="flex items-center gap-1 text-emerald-600 bg-emerald-50 px-1.5 py-0.5 rounded"><i class="fa-solid fa-check"></i> NLP</span>
                                </div>
                            </div>
                            <span class="text-sm font-bold text-emerald-600 font-sans">98%</span>
                        </div>
                        <div class="w-full bg-slate-100 rounded-full h-2">
                            <div class="bg-emerald-500 h-2 rounded-full transition-all duration-1000" style="width: 98%"></div>
                        </div>
                    </div>
                </div>

                {{-- وظيفة 2 --}}
                <div class="bg-white rounded-xl p-6 border border-slate-200 hover:border-emerald-400 hover:shadow-md transition group cursor-pointer">
                    <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
                        <div>
                            <h3 class="text-lg font-bold text-slate-900 group-hover:text-emerald-600 transition">Senior Full Stack Engineer (Laravel/Vue)</h3>
                            <div class="flex flex-wrap items-center gap-4 mt-2 text-sm text-slate-500">
                                <span class="flex items-center gap-1"><i class="fa-solid fa-code"></i> الهندسة</span>
                                <span class="flex items-center gap-1"><i class="fa-solid fa-location-dot"></i> الرياض / عن بعد</span>
                            </div>
                        </div>
                        <button class="text-emerald-600 font-bold text-sm group-hover:translate-x-[-5px] transition flex items-center gap-2">
                            قدم الآن <i class="fa-solid fa-arrow-left"></i>
                        </button>
                    </div>

                    <div class="mt-5 pt-4 border-t border-slate-100">
                        <div class="flex justify-between items-end mb-2">
                            <div>
                                <span class="text-xs font-bold text-slate-700 block mb-1">مدى تطابق مهاراتك</span>
                                <div class="flex gap-2 text-[10px] text-slate-500">
                                    <span class="flex items-center gap-1 text-emerald-600 bg-emerald-50 px-1.5 py-0.5 rounded"><i class="fa-solid fa-check"></i> Laravel</span>
                                    <span class="flex items-center gap-1 text-slate-400 bg-slate-50 px-1.5 py-0.5 rounded opacity-60"><i class="fa-solid fa-xmark"></i> Vue.js</span>
                                </div>
                            </div>
                            <span class="text-sm font-bold text-amber-500 font-sans">65%</span>
                        </div>
                        <div class="w-full bg-slate-100 rounded-full h-2">
                            <div class="bg-amber-400 h-2 rounded-full transition-all duration-1000" style="width: 65%"></div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <section class="py-16 bg-white">
        <div class="max-w-3xl mx-auto px-4 text-center">
            <h3 class="text-2xl font-bold text-slate-900 mb-4">لم تجد الوظيفة المناسبة؟</h3>
            <p class="text-slate-600 mb-8">
                نحن نبحث دائماً عن المواهب الاستثنائية. أرسل لنا سيرتك الذاتية وسنتواصل معك عندما تتوفر فرصة تناسب مهاراتك.
            </p>
            <a href="mailto:careers@oneurai.sa" class="inline-flex items-center justify-center px-8 py-3 border border-slate-300 rounded-full text-slate-700 font-bold hover:border-emerald-500 hover:text-emerald-600 transition">
                أرسل سيرة ذاتية عامة
            </a>
        </div>
    </section>
</x-layouts.app>
