<!DOCTYPE html>
<html lang="ar" dir="rtl" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'ونوراي | المنصة السعودية الأولى للذكاء الاصطناعي ومشاركة الكود' }}</title>
    <meta name="description" content="ونوراي (Oneurai) هي المنصة السعودية الرائدة للمطورين، تهدف لتمكين مجتمع الذكاء الاصطناعي من مشاركة الكود، المستودعات، والنماذج البرمجية لدعم الابتكار في المملكة.">
    <meta name="keywords" content="ونوراي, Oneurai, ذكاء اصطناعي سعودي, مشاركة الكود, مطورين سعوديين, رؤية 2030, برمجة, مستودعات برمجية, نماذج AI">
    <meta name="author" content="Oneurai Team">
    <meta name="robots" content="index, follow">
    <link rel="canonical" href="{{ url()->current() }}">

    <meta name="theme-color" content="#059669">

    {{-- Open Graph / Facebook --}}
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="ونوراي | ملتقى المطورين وخبراء الذكاء الاصطناعي في السعودية">
    <meta property="og:description" content="انضم إلى مجتمع ونوراي، ابدأ بمشاركة مشاريعك البرمجية واستكشف أحدث نماذج الذكاء الاصطناعي المطورة محلياً.">
    <meta property="og:image" content="{{ asset('images/og-oneurai.png') }}">

    {{-- Twitter --}}
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="ونوراي - Oneurai">
    <meta name="twitter:description" content="المنصة السعودية الأولى لتبادل الخبرات البرمجية ونماذج الذكاء الاصطناعي.">
    <meta name="twitter:image" content="{{ asset('images/og-oneurai.png') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;600;700;800&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

    <script src="https://cdn.tailwindcss.com"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Cairo', 'sans-serif'],
                        english: ['Inter', 'sans-serif'],
                    },
                    colors: {
                        emerald: { 50: '#ecfdf5', 600: '#059669', 700: '#047857', 900: '#064e3b' },
                        amber: { 400: '#fbbf24', 500: '#f59e0b' }
                    }
                }
            }
        }
    </script>

    <style>
        [x-cloak] { display: none !important; }
        .code-scroll::-webkit-scrollbar { height: 6px; }
        .code-scroll::-webkit-scrollbar-track { background: #1e293b; }
        .code-scroll::-webkit-scrollbar-thumb { background: #475569; border-radius: 3px; }
        .glass-panel {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(226, 232, 240, 0.6);
        }
    </style>

    {{-- Structured Data (JSON-LD) --}}
    @verbatim
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "Organization",
      "name": "ونوراي - Oneurai",
      "url": "https://oneurai.com",
      "logo": "/images/logo.png",
      "description": "منصة سعودية لتبادل الأكواد ونماذج الذكاء الاصطناعي للمطورين.",
      "address": {
        "@type": "PostalAddress",
        "addressCountry": "SA"
      }
    }
    </script>
    @endverbatim

    @livewireStyles
</head>
<body class="bg-slate-50 text-slate-900 font-sans antialiased selection:bg-emerald-100 selection:text-emerald-900">

    {{-- القائمة العلوية --}}
    @include('components.navbar')

    {{-- المحتوى الرئيسي --}}
    <main>
        {{ $slot }}
    </main>

    {{-- الفوتر --}}
    @include('components.footer')

    @livewireScripts

</body>
</html>