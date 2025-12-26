<x-layouts.app>
    <x-slot:title>شروط الاستخدام والمسؤولية القانونية | Oneurai</x-slot:title>

    <style>
        html { scroll-behavior: smooth; scroll-padding-top: 120px; }
        
        /* Typography & Layout */
        .terms-content h2 { @apply text-2xl font-black text-slate-900 mb-6 mt-12 tracking-tight flex items-center gap-3 border-b border-slate-100 pb-4; }
        .terms-content p { @apply text-slate-600 leading-[1.9] mb-6 font-medium text-base text-justify; }
        .terms-content ul { @apply space-y-4 mb-8 mr-2 bg-slate-50 p-6 rounded-2xl border border-slate-100; }
        .terms-content li { @apply flex gap-3 text-slate-700 font-bold text-sm leading-relaxed; }
        .terms-content li::before { content: "•"; @apply text-emerald-500 text-xl font-black flex-shrink-0 -mt-2; }
        
        /* Zones Styling */
        .danger-zone { @apply bg-red-50 border border-red-200 !important; }
        .danger-zone h2 { @apply text-red-900 border-red-200; }
        .danger-zone p { @apply text-red-800; }
        .danger-zone ul { @apply bg-white/50 border-red-200; }
        .danger-zone li { @apply text-red-900; }
        .danger-zone li::before { @apply text-red-600; }

        .warning-zone { @apply bg-amber-50 border border-amber-200 !important; }
        .warning-zone h2 { @apply text-amber-900 border-amber-200; }
        .warning-zone ul { @apply bg-white/50 border-amber-200; }
        .warning-zone li { @apply text-amber-900; }
        .warning-zone li::before { @apply text-amber-600; }
    </style>

    {{-- 1. Hero Section --}}
    <div class="relative bg-[#0B1120] py-24 lg:py-32 overflow-hidden border-b border-white/5">
        <div class="absolute inset-0 bg-[url('https://grainy-gradients.vercel.app/noise.svg')] opacity-20"></div>
        <div class="absolute top-0 left-1/2 -translate-x-1/2 w-full h-full max-w-7xl pointer-events-none">
            <div class="absolute top-20 left-20 w-96 h-96 bg-emerald-500/20 rounded-full blur-[100px]"></div>
            <div class="absolute bottom-20 right-20 w-96 h-96 bg-blue-600/20 rounded-full blur-[100px]"></div>
        </div>

        <div class="max-w-4xl mx-auto px-6 relative z-10 text-center animate-fade-in-up">
            <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/5 border border-white/10 text-emerald-400 text-xs font-black uppercase tracking-widest mb-8 backdrop-blur-md">
                <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                وثيقة قانونية ملزمة
            </div>
            <h1 class="text-4xl lg:text-6xl font-black text-white mb-6 tracking-tighter leading-tight">
                شروط الاستخدام <br>
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-emerald-400 via-teal-300 to-blue-400">وإخلاء المسؤولية</span>
            </h1>
            <p class="text-slate-400 max-w-2xl mx-auto text-sm leading-relaxed font-medium">
                يرجى قراءة هذه الوثيقة بعناية فائقة. استخدامك للمنصة يعني موافقتك غير المشروطة على جميع البنود الواردة أدناه، بما في ذلك التنازل عن حقك في المقاضاة في حالات محددة.
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
                            {{-- خط التوصيل --}}
                            <div class="absolute right-[19px] top-4 bottom-4 w-0.5 bg-slate-100"></div>
                            
                            @php
                                $sections = [
                                    'acceptance' => ['icon' => 'fa-check', 'text' => '1. القبول والإقرار'],
                                    'competence' => ['icon' => 'fa-brain', 'text' => '2. الأهلية التقنية (هام)'],
                                    'sensitive_data' => ['icon' => 'fa-shield-virus', 'text' => '3. أمن البيانات والمحتوى'],
                                    'ai_risks' => ['icon' => 'fa-robot', 'text' => '4. مخاطر الذكاء الاصطناعي'],
                                    'conduct' => ['icon' => 'fa-ban', 'text' => '5. المحظوبات الصارمة'],
                                    'third_party' => ['icon' => 'fa-link', 'text' => '6. خدمات الطرف الثالث'],
                                    'disclaimer' => ['icon' => 'fa-triangle-exclamation', 'text' => '7. إخلاء المسؤولية'],
                                    'liability' => ['icon' => 'fa-hand-holding-dollar', 'text' => '8. حدود المسؤولية'],
                                    'law' => ['icon' => 'fa-scale-balanced', 'text' => '9. القانون والاختصاص']
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

            {{-- Main Content --}}
            <div class="flex-1 terms-content animate-fade-in-up" style="animation-delay: 0.2s">
                
                {{-- تنبيه أحمر عريض --}}
                <div class="bg-red-50 border border-red-100 rounded-3xl p-6 mb-12 flex gap-4 items-start">
                    <i class="fa-solid fa-triangle-exclamation text-red-500 mt-1"></i>
                    <div>
                        <h4 class="font-black text-red-900 text-sm mb-1">تنبيه للمستخدمين غير التقنيين</h4>
                        <p class="!text-red-800 !text-xs !mb-0 !leading-relaxed">
                            هذه المنصة مخصصة للمطورين والباحثين. إذا لم تكن تفهم كيفية التعامل مع الأكواد البرمجية أو مخاطر رفع البيانات على السحابة، فإنك تستخدم المنصة على مسؤوليتك الكاملة.
                        </p>
                    </div>
                </div>

                <div class="bg-white p-8 md:p-14 rounded-[2.5rem] border border-slate-200 shadow-sm">

                    {{-- 1. Acceptance --}}
                    <section id="acceptance">
                        <h2>1. القبول والإقرار الملزم</h2>
                        <p>
                            تعد منصة <strong>Oneurai</strong> بيئة تطويرية متقدمة. بمجرد تسجيلك أو استخدامك لأي من خدماتنا، فإنك تبرم عقداً قانونياً ملزماً وتقر بأنك قرأت هذه الشروط وفهمتها بالكامل. إذا كنت لا توافق على أي بند، يجب عليك التوقف فوراً عن استخدام المنصة.
                        </p>
                    </section>

                    {{-- 2. Competence (جديد: حماية من الغشيم) --}}
                    <section id="competence">
                        <h2>2. الأهلية التقنية والمسؤولية الذاتية</h2>
                        <p>
                            أنت تقر بأنك تمتلك المعرفة التقنية الكافية لاستخدام أدوات الذكاء الاصطناعي وتشغيل الأكواد البرمجية.
                        </p>
                        <ul>
                            <li><strong>مسؤولية التشغيل:</strong> أنت المسؤول الوحيد عن أي كود تقوم بتشغيله (Code Execution)، وعن فهم نتائجه وآثاره على بيئة العمل أو البيانات.</li>
                            <li><strong>الأخطاء البشرية:</strong> نحن لا نتحمل مسؤولية أي ضرر ناتج عن "خطأ مستخدم" (User Error)، بما في ذلك حذف الملفات بالخطأ، أو الكتابة فوق البيانات، أو تهيئة (Format) بيئة العمل.</li>
                        </ul>
                    </section>

                    {{-- 3. Data Security (الأقوى للحماية) --}}
                    <section id="sensitive_data" class="warning-zone p-8 rounded-3xl my-12 border">
                        <div class="flex items-center gap-3 mb-6">
                            <i class="fa-solid fa-file-shield text-amber-500 text-2xl"></i>
                            <h2 class="!mt-0 !mb-0 !border-none !pb-0">3. أمن البيانات والمحتوى الحساس</h2>
                        </div>
                        <p class="font-bold">
                            هذا البند بالغ الخطورة. يرجى قراءته بعناية:
                        </p>
                        <ul>
                            <li><strong>حظر رفع البيانات الخاصة:</strong> يُحظر تماماً رفع أو معالجة أي بيانات شخصية حساسة (صور عائلية، هويات، بيانات مالية، أرقام سرية) باستخدام أدوات المنصة أو النماذج المتاحة عليها.</li>
                            <li><strong>علنية النماذج:</strong> يجب أن تفترض دائماً أن أي بيانات تدخلها في نماذج الذكاء الاصطناعي (LLMs) قد تصبح جزءاً من البيانات العامة أو يتم استخدامها لتدريب النماذج مستقبلاً.</li>
                            <li><strong>إخلاء المسؤولية عن التسريب:</strong> في حال قمت برفع بيانات خاصة وتم تسريبها، أو ظهرت في مخرجات مستخدمين آخرين، فإنك تتحمل وحدك كافة التبعات القانونية والأخلاقية، وتخلي مسؤولية Oneurai وملاكها تماماً.</li>
                        </ul>
                    </section>

                    {{-- 4. AI Risks --}}
                    <section id="ai_risks">
                        <h2>4. طبيعة ومخاطر الذكاء الاصطناعي</h2>
                        <p>
                            أنت تدرك أن تقنيات الذكاء الاصطناعي هي تقنيات تجريبية وتطورية:
                        </p>
                        <ul>
                            <li><strong>الهلوسة (Hallucinations):</strong> قد تقدم النماذج معلومات خاطئة، مضللة، أو مسيئة بثقة تامة. الاعتماد على هذه المخرجات يكون على مسؤوليتك الشخصية.</li>
                            <li><strong>حقوق الملكية للمخرجات:</strong> أنت المسؤول عن التأكد من أن الصور أو النصوص التي تولدها لا تنتهك حقوق ملكية فكرية لطرف ثالث.</li>
                        </ul>
                    </section>

                    {{-- 5. Conduct --}}
                    <section id="conduct">
                        <h2>5. المحظورات الصارمة (Zero Tolerance)</h2>
                        <p>
                            نطبق سياسة عدم التسامح المطلق، ويحق لنا إيقاف حسابك وإبلاغ السلطات المختصة فوراً في الحالات التالية:
                        </p>
                        <ul>
                            <li><strong>المحتوى غير القانوني:</strong> توليد أو رفع محتوى إباحي، سياسي متطرف، يحرض على الكراهية، أو ينتهك القوانين السعودية.</li>
                            <li><strong>التزييف العميق (Deepfakes):</strong> يمنع منعاً باتاً استخدام المنصة لتوليد صور أو فيديوهات واقعية لأشخاص دون موافقتهم الصريحة.</li>
                            <li><strong>الاستغلال التقني:</strong> استخدام المنصة لتعدين العملات الرقمية (Mining)، أو شن هجمات سيبرانية (DDoS)، أو نشر برمجيات خبيثة.</li>
                        </ul>
                    </section>

                    {{-- 6. Third Party --}}
                    <section id="third_party">
                        <h2>6. خدمات الطرف الثالث</h2>
                        <p>
                            قد تتيح المنصة الوصول لأدوات خارجية (مثل: Google Colab, Hugging Face, OpenAI APIs).
                        </p>
                        <ul>
                            <li>نحن لا نتحكم في هذه الخدمات ولا نضمن استمراريتها.</li>
                            <li>أي تغيير في سياسات تلك الشركات أو توقف لخدماتها لا يقع تحت مسؤوليتنا، حتى لو أثر ذلك على عمل مشاريعك في Oneurai.</li>
                        </ul>
                    </section>

                    {{-- 7. Disclaimer (الدرع النووي) --}}
                    <section id="disclaimer" class="danger-zone p-8 rounded-3xl my-12 border">
                        <div class="flex items-center gap-3 mb-6">
                            <i class="fa-solid fa-skull-crossbones text-red-500 text-2xl"></i>
                            <h2 class="!mt-0 !mb-0 !border-none !pb-0">7. إخلاء المسؤولية الشامل</h2>
                        </div>
                        <p class="font-black text-lg">
                            يتم تقديم الخدمة "كما هي" (AS IS) و"كما هي متوفرة".
                        </p>
                        <ul>
                            <li><strong>لا ضمانات:</strong> لا تقدم Oneurai أي تعهدات أو ضمانات، صريحة أو ضمنية، بخصوص موثوقية الخدمة، خلوها من الأخطاء، أو عدم انتهاكها لحقوق الغير.</li>
                            <li><strong>فقدان البيانات:</strong> نحن غير مسؤولين إطلاقاً عن أي تلف أو فقدان لبياناتك أو مشاريعك لأي سبب كان (خلل تقني، اختراق، خطأ بشري). يجب عليك الاحتفاظ بنسخ احتياطية خارجية دائماً.</li>
                            <li><strong>أجهزة المستخدم:</strong> لا نتحمل مسؤولية أي ضرر يلحق بجهازك الحاسب أو شبكتك نتيجة تحميل أو تشغيل أكواد من المنصة.</li>
                        </ul>
                    </section>

                    {{-- 8. Limitation of Liability --}}
                    <section id="liability">
                        <h2>8. حدود المسؤولية والتعويض</h2>
                        <ul>
                            <li><strong>السقف المالي:</strong> إلى أقصى حد يسمح به القانون، لن تتجاوز مسؤولية Oneurai المالية تجاهك (إن وجدت) مبلغ الاشتراك الذي دفعته في الشهر الأخير، أو 100 ريال سعودي أيهما أقل.</li>
                            <li><strong>التعويض (Indemnification):</strong> تتعهد بتعويضنا والدفاع عنا وحمايتنا من أي مطالبات قانونية، خسائر، أضرار، أو تكاليف محاماة تنشأ بسبب انتهاكك لهذه الشروط أو إساءة استخدامك للمنصة.</li>
                        </ul>
                    </section>

                    {{-- 9. Law --}}
                    <section id="law">
                        <h2>9. القانون الواجب التطبيق</h2>
                        <p>
                            تخضع هذه الشروط وتفسر وفقاً لأنظمة المملكة العربية السعودية. في حال نشوء أي نزاع، يكون الاختصاص الحصري للمحاكم المختصة في مدينة الرياض.
                        </p>
                    </section>

                    {{-- Footer Notice --}}
                    <div class="mt-16 pt-8 border-t border-slate-100 text-center">
                        <p class="text-sm text-slate-400">
                            آخر تحديث: يناير 2025. تحتفظ Oneurai بالحق في تعديل هذه الشروط في أي وقت، وتقع عليك مسؤولية مراجعتها دورياً.
                        </p>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-layouts.app>