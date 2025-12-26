@extends('errors.layout')
@section('title', '429 - طلبات كثيرة جداً')
@section('styles')
<style>
    .glass-panel { background: rgba(30, 41, 59, 0.6); backdrop-filter: blur(12px); border: 1px solid rgba(255, 255, 255, 0.05); }
    .progress-bar { transition: width 1s linear; }
</style>
@endsection

@section('content')
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute top-1/4 left-0 w-full h-px bg-gradient-to-r from-transparent via-amber-500/20 to-transparent"></div>
        <div class="absolute bottom-1/4 left-0 w-full h-px bg-gradient-to-r from-transparent via-emerald-500/20 to-transparent"></div>
    </div>

    <div class="relative z-10 w-full max-w-lg px-6 text-center">
        <div class="relative w-32 h-32 mx-auto mb-6 flex items-center justify-center">
            <div class="absolute inset-0 bg-amber-500/10 rounded-full blur-2xl animate-pulse-slow"></div>
            <i class="fa-solid fa-gauge-high text-7xl text-amber-500 drop-shadow-[0_0_15px_rgba(245,158,11,0.5)]"></i>
            <div class="absolute bottom-8 left-1/2 origin-bottom w-1 h-10 bg-red-500 -ml-0.5 rounded-full animate-wiggle" style="transform-origin: bottom center;"></div>
        </div>

        <h1 class="text-5xl font-bold text-white mb-2 font-mono tracking-tighter">429</h1>
        <h2 class="text-2xl font-bold text-slate-200 mb-4">تمهل قليلاً.. السرعة زائدة!</h2>
        <p class="text-slate-400 text-sm mb-8 leading-relaxed">
            لقد أرسلت طلبات كثيرة جداً في وقت قصير. خوادمنا تحتاج لاستراحة قصيرة.
        </p>

        <div class="mb-8">
            <button id="retryBtn" disabled class="group relative w-full sm:w-auto px-10 py-3.5 rounded-xl bg-slate-800 text-slate-400 font-bold text-sm transition cursor-not-allowed overflow-hidden">
                <div id="progressBar" class="absolute top-0 left-0 h-full bg-slate-700 w-full progress-bar opacity-30"></div>
                <span id="btnText" class="relative z-10 flex items-center justify-center gap-2">
                    <i class="fa-regular fa-hourglass-half animate-spin-slow"></i>
                    يرجى الانتظار <span id="timer" class="font-mono text-amber-500">30</span> ثانية
                </span>
            </button>
        </div>

        <div class="glass-panel rounded-lg p-4 text-left mx-auto max-w-sm shadow-lg">
            <div class="flex justify-between items-center mb-2 border-b border-white/5 pb-2">
                <span class="text-[10px] text-slate-500 font-mono uppercase">Response Headers</span>
                <i class="fa-solid fa-server text-slate-600 text-xs"></i>
            </div>
            <div class="font-mono text-xs text-slate-400 space-y-1" dir="ltr">
                <div><span class="text-emerald-500">HTTP/1.1</span> <span class="text-amber-400">429 Too Many Requests</span></div>
                <div><span class="text-emerald-400">Retry-After:</span> 30</div>
            </div>
        </div>
    </div>

    <script>
        let timeLeft = 30;
        const timerElement = document.getElementById('timer');
        const btnTextElement = document.getElementById('btnText');
        const retryBtn = document.getElementById('retryBtn');
        const progressBar = document.getElementById('progressBar');
        progressBar.style.width = '100%';
        const countdown = setInterval(() => {
            timeLeft--;
            timerElement.textContent = timeLeft;
            const percentage = (timeLeft / 30) * 100;
            progressBar.style.width = percentage + '%';
            if (timeLeft <= 0) {
                clearInterval(countdown);
                retryBtn.disabled = false;
                retryBtn.classList.remove('bg-slate-800', 'text-slate-400', 'cursor-not-allowed');
                retryBtn.classList.add('bg-emerald-600', 'text-white', 'hover:bg-emerald-500', 'cursor-pointer');
                btnTextElement.innerHTML = '<i class="fa-solid fa-rotate-right"></i> تحديث الصفحة الآن';
                retryBtn.onclick = () => location.reload();
            }
        }, 1000);
    </script>
@endsection
