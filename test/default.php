<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>قريباً | Oneurai</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;600;700;800&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                        arabic: ['Cairo', 'sans-serif'],
                    },
                    colors: {
                        emerald: { 500: '#10b981', 600: '#059669' },
                        slate: { 850: '#1e293b', 900: '#0f172a' }
                    },
                    animation: {
                        'pulse-slow': 'pulse 4s cubic-bezier(0.4, 0, 0.6, 1) infinite',
                    }
                }
            }
        }
    </script>
    <style>
        body { font-family: 'Cairo', sans-serif; }
        
        .bg-grid {
            background-image: linear-gradient(to right, #1e293b 1px, transparent 1px),
                              linear-gradient(to bottom, #1e293b 1px, transparent 1px);
            background-size: 30px 30px; /* تصغير المربعات للجوال */
            mask-image: radial-gradient(circle at center, black 40%, transparent 100%);
        }

        .glass-box {
            background: rgba(255, 255, 255, 0.03);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.05);
            box-shadow: 0 4px 20px 0 rgba(0, 0, 0, 0.3);
        }
    </style>
</head>
<body class="bg-slate-900 text-white h-screen flex flex-col overflow-hidden relative selection:bg-emerald-500 selection:text-white">

    <div class="absolute inset-0 bg-grid z-0 opacity-20"></div>
    <div class="absolute top-0 left-1/2 -translate-x-1/2 w-full max-w-[800px] h-[500px] bg-emerald-600/20 rounded-full blur-[100px] -mt-40 z-0 animate-pulse-slow"></div>

    <nav class="relative z-10 w-full p-6 flex justify-between items-center">
        <div class="flex items-center gap-2">
            <div class="w-8 h-8 bg-emerald-600 rounded-lg flex items-center justify-center text-white text-sm shadow-lg shadow-emerald-600/20">
                <i class="fa-solid fa-code-branch"></i>
            </div>
            <span class="font-bold text-xl tracking-wide font-sans">Oneurai</span>
        </div>
        <div class="hidden sm:flex gap-4 text-slate-400 text-sm font-medium">
            <a href="mailto:info@oneurai.sa" class="text-emerald-400 hover:text-emerald-300 transition">info@oneurai.sa</a>
        </div>
    </nav>

    <main class="flex-1 flex flex-col items-center justify-center px-4 text-center relative z-10 pb-10 w-full max-w-4xl mx-auto">
        
        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 text-xs font-bold mb-6 animate-bounce">
            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
            العد التنازلي للإطلاق
        </div>

        <h1 class="text-3xl sm:text-5xl md:text-6xl font-bold mb-4 leading-tight">
            نحن نجهز شيئاً <br>
            <span class="text-transparent bg-clip-text bg-gradient-to-r from-emerald-400 to-blue-400">استثنائياً للمطورين.</span>
        </h1>

        <p class="text-slate-400 text-sm sm:text-lg max-w-xl mb-10 leading-relaxed px-4">
            المنصة السعودية المتكاملة للذكاء الاصطناعي. نعمل ليل نهار لنقدم لكم تجربة لا تُنسى.
        </p>

        <div class="grid grid-cols-4 gap-2 sm:gap-6 mb-12 w-full max-w-2xl px-2" id="countdown">
            
            <div class="glass-box aspect-square rounded-xl flex flex-col items-center justify-center">
                <span id="days" class="text-2xl sm:text-5xl font-bold font-sans text-white">00</span>
                <span class="text-[10px] sm:text-sm text-slate-400 mt-1 uppercase tracking-wider">يوم</span>
            </div>

            <div class="glass-box aspect-square rounded-xl flex flex-col items-center justify-center">
                <span id="hours" class="text-2xl sm:text-5xl font-bold font-sans text-white">00</span>
                <span class="text-[10px] sm:text-sm text-slate-400 mt-1 uppercase tracking-wider">ساعة</span>
            </div>

            <div class="glass-box aspect-square rounded-xl flex flex-col items-center justify-center">
                <span id="minutes" class="text-2xl sm:text-5xl font-bold font-sans text-white">00</span>
                <span class="text-[10px] sm:text-sm text-slate-400 mt-1 uppercase tracking-wider">دقيقة</span>
            </div>

            <div class="glass-box aspect-square rounded-xl flex flex-col items-center justify-center border-emerald-500/20">
                <span id="seconds" class="text-2xl sm:text-5xl font-bold font-sans text-emerald-500">00</span>
                <span class="text-[10px] sm:text-sm text-slate-400 mt-1 uppercase tracking-wider">ثانية</span>
            </div>

        </div>

        <div class="w-full max-w-md px-4 relative group">
            <div class="absolute -inset-0.5 bg-gradient-to-r from-emerald-600 to-blue-600 rounded-full blur opacity-20 group-hover:opacity-40 transition duration-1000"></div>
            <form class="relative flex items-center bg-slate-900 border border-slate-700 rounded-full p-1 shadow-2xl">
                <input type="email" placeholder="بريدك الإلكتروني..." class="flex-1 bg-transparent border-none text-white px-4 py-2 outline-none placeholder:text-slate-500 text-sm h-10 w-full rounded-full">
                <button class="bg-emerald-600 hover:bg-emerald-500 text-white px-5 py-2 rounded-full font-bold text-xs sm:text-sm transition flex-shrink-0 h-10">
                    أبلغني
                </button>
            </form>
        </div>

    </main>

    <footer class="relative z-10 p-4 text-center text-slate-600 text-[10px] sm:text-xs">
        © 2025 Oneurai. جميع الحقوق محفوظة.
    </footer>

    <script>
        // ============================================================
        // إعدادات التاريخ الثابت (موحد لجميع الأجهزة)
        // ============================================================
        
        // ⚠️ هام: قم بتغيير هذا التاريخ إلى موعد إطلاقك الفعلي
        // الصيغة: Month Day, Year Hour:Minute:Second
        // مثال: وضعنا تاريخ تقريبي بعد شهر من الآن (ديسمبر 2025)
        
        const launchDateString = "Dec 25, 2025 00:00:00"; 
        const countDownDate = new Date(launchDateString).getTime();

        const x = setInterval(function() {

            // الحصول على الوقت الحالي
            const now = new Date().getTime();
            
            // حساب الفرق بين وقت الإطلاق والوقت الحالي
            const distance = countDownDate - now;

            // حساب الوحدات الزمنية
            const days = Math.floor(distance / (1000 * 60 * 60 * 24));
            const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((distance % (1000 * 60)) / 1000);

            // تحديث العناصر في الصفحة
            // نستخدم شرط (distance > 0) لمنع ظهور أرقام سالبة إذا انتهى الوقت
            if (distance > 0) {
                document.getElementById("days").innerText = days < 10 ? "0" + days : days;
                document.getElementById("hours").innerText = hours < 10 ? "0" + hours : hours;
                document.getElementById("minutes").innerText = minutes < 10 ? "0" + minutes : minutes;
                document.getElementById("seconds").innerText = seconds < 10 ? "0" + seconds : seconds;
            } else {
                clearInterval(x);
                // ماذا يحدث عند انتهاء الوقت؟
                document.getElementById("countdown").innerHTML = "<div class='col-span-4 text-2xl sm:text-4xl font-bold text-emerald-500 animate-bounce'>🚀 انطلقنا!</div>";
            }
        }, 1000);
    </script>

</body>
</html>