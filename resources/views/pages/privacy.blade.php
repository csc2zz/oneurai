<x-layouts.app>
    <x-slot:title>سياسة الخصوصية ومعالجة البيانات | Oneurai</x-slot:title>

    <style>
        html { scroll-behavior: smooth; scroll-padding-top: 120px; }
        
        /* Typography */
        .privacy-content h2 { @apply text-2xl font-black text-slate-900 mb-6 mt-12 tracking-tight flex items-center gap-3 border-b border-slate-100 pb-4; }
        .privacy-content p { @apply text-slate-600 leading-[1.9] mb-6 font-medium text-base text-justify; }
        .privacy-content ul { @apply space-y-4 mb-8 mr-2 bg-slate-50 p-6 rounded-2xl border border-slate-100; }
        .privacy-content li { @apply flex gap-3 text-slate-700 font-bold text-sm leading-relaxed; }
        .privacy-content li::before { content: "•"; @apply text-emerald-500 text-xl font-black flex-shrink-0 -mt-2; }

        /* Warning Zones */
        .warning-zone { @apply bg-amber-50 border border-amber-200 !important; }
        .warning-zone h2 { @apply text-amber-900 border-amber-200; }
        .warning-zone li { @apply text-amber-900; }
        .warning-zone li::before { @apply text-amber-500; }
    </style>

    {{-- 1. Hero Section --}}
    <div class="relative bg-[#0B1120] py-28 lg:py-36 overflow-hidden border-b border-white/5">
        <div class="absolute inset-0 bg-[url('https://grainy-gradients.vercel.app/noise.svg')] opacity-20"></div>
        
        {{-- Animated Globs --}}
        <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-emerald-600/10 rounded-full blur-[120px] -mr-40 -mt-40 animate-pulse"></div>
        <div class="absolute bottom-0 left-0 w-[400px] h-[400px] bg-blue-600/10 rounded-full blur-[100px] -ml-40 -mb-40"></div>

        <div class="max-w-4xl mx-auto px-6 relative z-10 text-center animate-fade-in-up">
            <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/5 border border-white/10 text-emerald-400 text-xs font-black uppercase tracking-widest mb-8 backdrop-blur-md">
                <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                نظام حماية البيانات الشخصية
            </div>
            <h1 class="text-4xl lg:text-6xl font-black text-white mb-6 tracking-tighter leading-tight">
                سياسة <span class="text-transparent bg-clip-text bg-gradient-to-r from-emerald-400 to-teal-300">الخصوصية</span>
            </h1>
            <p class="text-slate-400 max-w-2xl mx-auto text-sm leading-relaxed font-medium">
                نحن نتعامل بجدية تامة مع "بصمتك الرقمية". هذه السياسة توضح بشفافية كيف نتعامل مع مدخلات الذكاء الاصطناعي وبياناتك الشخصية وفقاً للأنظمة السعودية.
            </p>
        </div>
    </div>

    {{-- 2. Main Layout --}}
    <div class="max-w-7xl mx-auto px-6 py-20">
        <div class="flex flex-col lg:flex-row gap-16">

            {{-- Sidebar Navigation --}}
            <aside class="lg:w-80 flex-shrink-0 hidden lg:block">
                <div class="sticky top-32">
                    <div class="bg-white border border-slate-200/60 rounded-[2rem] p-8 shadow-xl shadow-slate-200/50 backdrop-blur-xl">
                        <h3 class="font-black text-slate-900 mb-6 text-[11px] uppercase tracking-[0.2em] opacity-50">فهرس المحتويات</h3>
                        <nav class="space-y-1 relative">
                            <div class="absolute right-[19px] top-4 bottom-4 w-0.5 bg-slate-100"></div>
                            @php
                                $sections = [
                                    'intro' => ['icon' => 'fa-info-circle', 'text' => '1. مقدمة والتزام'],
                                    'collection' => ['icon' => 'fa-database', 'text' => '2. البيانات المجمعة'],
                                    'ai_processing' => ['icon' => 'fa-microchip', 'text' => '3. معالجة الذكاء الاصطناعي'],
                                    'sharing' => ['icon' => 'fa-share-nodes', 'text' => '4. مشاركة البيانات'],
                                    'security' => ['icon' => 'fa-lock', 'text' => '5. الأمن السيبراني'],
                                    'rights' => ['icon' => 'fa-user-check', 'text' => '6. حقوقك النظامية'],
                                    'contact' => ['icon' => 'fa-envelope', 'text' => '7. تواصل معنا']
                                ];
                            @endphp
                            @foreach($sections as $id => $item)
                                <a href="#{{ $id }}" class="group flex items-center gap-4 py-3 relative z-10 hover:translate-x-[-4px] transition-all">
                                    <div class="w-10 h-10 rounded-xl bg-white border border-slate-100 flex items-center justify-center text-slate-400 group-hover:bg-emerald-500 group-hover:text-white group-hover:border-emerald-500 transition-all shadow-sm">
                                        <i class="fa-solid {{ $item['icon'] }} text-xs"></i>
                                    </div>
                                    <span class="text-xs font-black text-slate-500 group-hover:text-emerald-900">{{ $item['text'] }}</span>
                                </a>
                            @endforeach
                        </nav>
                    </div>
                </div>
            </aside>

            {{-- Privacy Content --}}
            <div class="flex-1 privacy-content animate-fade-in-up" style="animation-delay: 0.2s">

                <div class="bg-white p-8 md:p-14 rounded-[2.5rem] border border-slate-200 shadow-sm">

                    {{-- 1. Intro --}}
                    <section id="intro">
                        <h2>1. مقدمة والتزام قانوني</h2>
                        <p>
                            تلتزم منصة **Oneurai** بحماية خصوصيتك وضمان أمن بياناتك وفقاً لأحكام **نظام حماية البيانات الشخصية** المعمول به في المملكة العربية السعودية. هذه السياسة ليست مجرد وثيقة قانونية، بل هي عهد بيننا وبينك لتوضيح كيفية تعاملنا مع "النفط الجديد" (بياناتك).
                        </p>
                    </section>

                    {{-- 2. Data Collection --}}
                    <section id="collection">
                        <h2>2. البيانات التي نجمعها</h2>
                        <p>نقوم بجمع نوعين من البيانات، ويجب عليك التمييز بينهما:</p>
                        <ul>
                            <li><strong>بيانات الحساب (الشخصية):</strong> الاسم، البريد الإلكتروني، كلمة المرور (مشفرة)، ومعلومات الدفع. هذه البيانات سرية للغاية وتستخدم لإدارة حسابك فقط.</li>
                            <li><strong>بيانات الاستخدام (التقنية):</strong> عنوان IP، نوع الجهاز، سجلات التصفح (Logs)، والأخطاء البرمجية للمساعدة في تحسين الاستقرار.</li>
                            <li><strong>مدخلات الذكاء الاصطناعي (Prompts & Code):</strong> النصوص والأكواد والصور التي تدخلها في النماذج. (يرجى مراجعة القسم التالي للأهمية).</li>
                        </ul>
                    </section>

                    {{-- 3. AI Processing (القسم الأهم للحماية) --}}
                    <section id="ai_processing" class="warning-zone p-8 rounded-3xl my-12 border">
                        <div class="flex items-center gap-3 mb-6">
                            <i class="fa-solid fa-robot text-amber-500 text-2xl"></i>
                            <h2 class="!mt-0 !mb-0 !border-none !pb-0">3. معالجة بيانات الذكاء الاصطناعي</h2>
                        </div>
                        <p class="font-bold text-amber-900">
                            كيف نتعامل مع ما تكتبه للنماذج؟
                        </p>
                        <ul>
                            <li><strong>النماذج العامة:</strong> إذا استخدمت "النماذج العامة" أو شاركت مشروعك في المجتمع، فإن مدخلاتك ونتائجك تُعامل كبيانات غير سرية، وقد نستخدمها لتحسين جودة النماذج أو تدريبها (Fine-tuning).</li>
                            <li><strong>تحذير البيانات الحساسة:</strong> لا تقم أبداً بإدخال أسرار تجارية، بيانات طبية، أو معلومات شخصية دقيقة في حقول المحادثة مع الذكاء الاصطناعي. نحن لا نتحمل مسؤولية تخزين النموذج لهذه المعلومات أو ظهورها في مخرجات مستقبلية.</li>
                            <li><strong>المعالجة الآلية:</strong> يتم معالجة مدخلاتك بواسطة خوارزميات معقدة، ولا يطلع عليها الموظفون البشريون إلا في حالات الضرورة القصوى (مثل تصحيح الأخطاء أو التحقق من الانتهاكات الأمنية).</li>
                        </ul>
                    </section>

                    {{-- 4. Sharing --}}
                    <section id="sharing">
                        <h2>4. مشاركة البيانات مع أطراف ثالثة</h2>
                        <p>
                            نحن لا نبيع بياناتك أبداً للمعلنين. لكن، لتقديم الخدمة، قد نحتاج لمشاركة بعض البيانات المشفرة مع:
                        </p>
                        <ul>
                            <li><strong>مزودي نماذج الذكاء الاصطناعي:</strong> عند استخدامك لنماذج (مثل GPT-4, Llama) عبر منصتنا، يتم إرسال "البرومبت" الخاص بك إلى مزود الخدمة (مثل OpenAI أو Hugging Face) للمعالجة. تخضع هذه البيانات لسياسة خصوصية المزود الأصلي أيضاً.</li>
                            <li><strong>مستضيفي السحابة:</strong> يتم تخزين بياناتك المشفرة على خوادم آمنة (مثل AWS أو Google Cloud).</li>
                            <li><strong>الجهات القانونية:</strong> في حال وجود طلب رسمي من الجهات الأمنية السعودية، نحن ملزمون بالتعاون وفق الأنظمة.</li>
                        </ul>
                    </section>

                    {{-- 5. Security --}}
                    <section id="security">
                        <h2>5. الأمن السيبراني</h2>
                        <p>
                            نستخدم أحدث تقنيات التشفير (SSL/TLS) لحماية البيانات أثناء النقل، وتشفير AES للبيانات المخزنة. ومع ذلك، نذكرك دائماً:
                        </p>
                        <ul>
                            <li>لا يوجد نظام آمن بنسبة 100%.</li>
                            <li>أنت مسؤول عن حماية جهازك من البرمجيات الخبيثة التي قد تسرق جلسة دخولك (Session Hijacking).</li>
                        </ul>
                    </section>

                    {{-- 6. Rights --}}
                    <section id="rights">
                        <h2>6. حقوقك النظامية</h2>
                        <p>
                            بموجب النظام، يحق لك في أي وقت:
                        </p>
                        <ul>
                            <li>طلب نسخة من جميع بياناتك المخزنة لدينا.</li>
                            <li>طلب حذف حسابك وبياناتك نهائياً (الحق في النسيان).</li>
                            <li>تصحيح أي معلومات غير دقيقة.</li>
                        </ul>
                    </section>

                    {{-- 7. Contact --}}
                    <section id="contact" class="pt-8 border-t border-slate-100 mt-16">
                        <h2 class="!border-none">7. للتواصل ومسؤول حماية البيانات</h2>
                        <div class="grid sm:grid-cols-2 gap-6 mt-8">
                            <a href="mailto:privacy@oneurai.sa" class="group relative p-6 bg-slate-50 border border-slate-100 rounded-3xl hover:bg-emerald-600 transition-all duration-500 overflow-hidden">
                                <div class="relative z-10">
                                    <div class="w-10 h-10 bg-white rounded-xl flex items-center justify-center text-emerald-600 shadow-sm mb-4 group-hover:scale-110 transition-transform">
                                        <i class="fa-regular fa-envelope"></i>
                                    </div>
                                    <h4 class="text-slate-900 font-black text-sm group-hover:text-white transition-colors">مسؤول الخصوصية</h4>
                                    <p class="text-slate-500 text-xs mt-1 group-hover:text-emerald-50 transition-colors">privacy@oneurai.sa</p>
                                </div>
                            </a>

                            <a href="#" class="group relative p-6 bg-slate-50 border border-slate-100 rounded-3xl hover:bg-slate-900 transition-all duration-500 overflow-hidden">
                                <div class="relative z-10">
                                    <div class="w-10 h-10 bg-white rounded-xl flex items-center justify-center text-slate-900 shadow-sm mb-4 group-hover:scale-110 transition-transform">
                                        <i class="fa-solid fa-headset"></i>
                                    </div>
                                    <h4 class="text-slate-900 font-black text-sm group-hover:text-white transition-colors">الدعم الفني</h4>
                                    <p class="text-slate-500 text-xs mt-1 group-hover:text-slate-300 transition-colors">لطلبات حذف البيانات</p>
                                </div>
                            </a>
                        </div>
                    </section>

                </div>
            </div>
        </div>
    </div>
</x-layouts.app>