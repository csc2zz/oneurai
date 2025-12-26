<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') | Oneurai</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;600;700;800&family=Fira+Code:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Cairo', 'sans-serif'], mono: ['Fira Code', 'monospace'] },
                    colors: {
                        emerald: { 500: '#10b981', 600: '#059669' },
                        amber: { 400: '#fbbf24', 500: '#f59e0b', 600: '#d97706' },
                        red: { 500: '#ef4444', 900: '#7f1d1d' },
                        slate: { 850: '#1e293b', 900: '#0f172a', 950: '#020617' }
                    },
                    animation: {
                        'cursor': 'cursor .75s step-end infinite',
                        'refuse': 'refuse 0.5s cubic-bezier(.36,.07,.19,.97) both',
                        'spin-slow': 'spin 8s linear infinite',
                        'fade-up': 'fadeUp 0.8s ease-out forwards',
                        'shake': 'shake 0.82s cubic-bezier(.36,.07,.19,.97) both infinite',
                        'pulse-fast': 'pulse 1.5s cubic-bezier(0.4, 0, 0.6, 1) infinite',
                        'float': 'float 6s ease-in-out infinite',
                        'scan': 'scan 2s linear infinite',
                        'wiggle': 'wiggle 0.5s ease-in-out infinite',
                        'pulse-slow': 'pulse 3s cubic-bezier(0.4, 0, 0.6, 1) infinite',
                    },
                    keyframes: {
                        cursor: { '0%, 100%': { opacity: '1' }, '50%': { opacity: '0' } },
                        refuse: { '10%, 90%': { transform: 'translate3d(-1px, 0, 0)' }, '20%, 80%': { transform: 'translate3d(2px, 0, 0)' }, '30%, 50%, 70%': { transform: 'translate3d(-4px, 0, 0)' }, '40%, 60%': { transform: 'translate3d(4px, 0, 0)' } },
                        fadeUp: { '0%': { opacity: '0', transform: 'translateY(20px)' }, '100%': { opacity: '1', transform: 'translateY(0)' } },
                        shake: { '10%, 90%': { transform: 'translate3d(-1px, 0, 0)' }, '20%, 80%': { transform: 'translate3d(2px, 0, 0)' }, '30%, 50%, 70%': { transform: 'translate3d(-4px, 0, 0)' }, '40%, 60%': { transform: 'translate3d(4px, 0, 0)' } },
                        float: { '0%, 100%': { transform: 'translateY(0)' }, '50%': { transform: 'translateY(-10px)' } },
                        scan: { '0%': { top: '0%', opacity: '0' }, '25%': { opacity: '1' }, '50%': { top: '100%', opacity: '0' }, '100%': { top: '100%', opacity: '0' } },
                        wiggle: { '0%, 100%': { transform: 'rotate(-3deg)' }, '50%': { transform: 'rotate(3deg)' } }
                    }
                }
            }
        }
    </script>
    <style>
        body { font-family: 'Cairo', sans-serif; }
        .glass-card { background: rgba(255, 255, 255, 0.03); backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, 0.05); }
        .noise { position: fixed; top: 0; left: 0; width: 100%; height: 100%; pointer-events: none; z-index: 50; opacity: 0.03; background: url('data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADIAAAAyBAMAAADsEZWCAAAAGFBMVEUAAAA5OTkAAABMTExERERmZmYzMzNmZmYwMz4QAAAACHRSTlMAM8D/NmSEkw1+8OIAAAABYktHRACIBR1IAAAAJ0lEQVQ4y2NgQQIw2DAwMDCwM5CBAQYYBwcH4wDDEI4B/0A4Bv4AAK36A85+7L+FAAAAAElFTkSuQmCC'); }
    </style>
    @yield('styles')
</head>
<body class="bg-slate-950 text-white h-screen flex flex-col items-center justify-center relative overflow-hidden selection:bg-emerald-500 selection:text-white">
    <div class="noise"></div>
    @yield('content')
</body>
</html>
