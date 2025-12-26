@extends('errors.layout')
@section('title', '401 - مطلوب تسجيل الدخول')
@section('content')
    <div class="absolute top-0 left-0 w-full h-full overflow-hidden z-0 pointer-events-none">
        <div class="absolute bottom-0 right-0 w-96 h-96 bg-slate-800/50 rounded-full blur-[100px]"></div>
        <div class="absolute top-0 left-0 w-96 h-96 bg-slate-800/50 rounded-full blur-[100px]"></div>
    </div>

    <div class="relative z-10 w-full max-w-xl px-6 text-center">
        <div class="relative w-28 h-40 mx-auto mb-8 animate-refuse group cursor-pointer">
            <div class="absolute inset-0 bg-slate-800 rounded-xl border-2 border-slate-600 shadow-2xl flex flex-col items-center justify-center overflow-hidden group-hover:border-red-500/50 transition duration-300">
                <div class="w-12 h-12 bg-slate-700 rounded-full mb-3 flex items-center justify-center">
                    <i class="fa-solid fa-user text-slate-500 text-xl"></i>
                </div>
                <div class="w-16 h-2 bg-slate-700 rounded mb-1"></div>
                <div class="w-10 h-2 bg-slate-700 rounded"></div>
                <div class="absolute inset-0 bg-red-500/10 flex items-center justify-center opacity-0 group-hover:opacity-100 transition duration-300">
                    <i class="fa-solid fa-xmark text-red-500 text-4xl"></i>
                </div>
            </div>
            <div class="absolute -top-6 left-1/2 -translate-x-1/2 w-1 h-6 bg-slate-500"></div>
            <div class="absolute -top-8 left-1/2 -translate-x-1/2 w-12 h-4 bg-slate-600 rounded-full border border-slate-500"></div>
        </div>

        <h1 class="text-5xl md:text-7xl font-bold text-white mb-2 font-mono tracking-tight">401</h1>
        <h2 class="text-xl font-bold text-slate-300 mb-4">التحقق من الهوية مطلوب</h2>
        <p class="text-slate-400 text-sm mb-10 leading-relaxed">
            لم نتمكن من التعرف عليك. ربما انتهت صلاحية جلستك أو أنك لم تقم بتسجيل الدخول بعد.
        </p>

        <div class="glass-card rounded-lg p-4 text-left mb-10 mx-auto max-w-md shadow-lg relative overflow-hidden group">
            <div class="absolute top-0 left-0 w-1 h-full bg-red-500"></div>
            <div class="flex justify-between items-center mb-2 border-b border-white/5 pb-2">
                <span class="text-[10px] text-slate-500 font-mono">Response Header</span>
                <span class="text-[10px] text-red-400 font-bold bg-red-500/10 px-2 py-0.5 rounded">401 Unauthorized</span>
            </div>
            <pre class="font-mono text-xs md:text-sm text-slate-300 block leading-relaxed" dir="ltr">{
  <span class="text-emerald-400">"error"</span>: <span class="text-amber-400">"unauthenticated"</span>,
  <span class="text-emerald-400">"message"</span>: <span class="text-white">"Invalid API token or session expired."</span>
}</pre>
        </div>

        <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
            <a href="{{ route('login') }}" class="w-full sm:w-auto px-8 py-3 rounded-lg bg-white text-slate-900 font-bold text-sm hover:bg-slate-200 transition flex items-center justify-center gap-2 shadow-lg shadow-white/10">
                <i class="fa-solid fa-right-to-bracket"></i> تسجيل الدخول
            </a>
            <a href="{{ url('/') }}" class="w-full sm:w-auto px-8 py-3 rounded-lg border border-slate-700 text-slate-300 hover:text-white hover:bg-slate-800 transition flex items-center justify-center gap-2 text-sm font-medium">
                الرئيسية
            </a>
        </div>
    </div>
@endsection
