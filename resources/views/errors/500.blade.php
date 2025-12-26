@extends('errors.layout')
@section('title', '500 - خطأ في الخادم')
@section('styles')
<style>
    .crt::before {
        content: " "; display: block; position: absolute; top: 0; left: 0; bottom: 0; right: 0;
        background: linear-gradient(rgba(18, 16, 16, 0) 50%, rgba(0, 0, 0, 0.25) 50%), linear-gradient(90deg, rgba(255, 0, 0, 0.06), rgba(0, 255, 0, 0.02), rgba(0, 0, 255, 0.06));
        z-index: 2; background-size: 100% 2px, 3px 100%; pointer-events: none;
    }
</style>
@endsection

@section('content')
    <div class="absolute top-0 w-full h-full overflow-hidden pointer-events-none">
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[800px] h-[500px] bg-red-900/20 rounded-full blur-[120px]"></div>
    </div>

    <div class="relative z-10 w-full max-w-3xl px-6 text-center">
        <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-red-900/30 border border-red-500/30 text-red-400 text-xs font-bold mb-6">
            <span class="w-2 h-2 rounded-full bg-red-500 animate-pulse-fast"></span>
            SYSTEM FAILURE
        </div>

        <h1 class="text-7xl md:text-9xl font-bold text-white mb-2 font-mono tracking-tighter opacity-90 relative inline-block hover:animate-shake cursor-help" title="Internal Server Error">
            5<span class="text-red-500">0</span>0
        </h1>

        <h2 class="text-2xl font-bold text-slate-200 mb-8 mt-4">حدث خطأ غير متوقع في الخادم</h2>

        <div class="bg-slate-900 border border-slate-800 rounded-xl text-left overflow-hidden shadow-2xl max-w-2xl mx-auto relative crt">
            <div class="bg-slate-950 px-4 py-2 flex items-center justify-between border-b border-slate-800">
                <div class="flex gap-1.5">
                    <div class="w-2.5 h-2.5 rounded-full bg-red-500/50"></div>
                    <div class="w-2.5 h-2.5 rounded-full bg-slate-700"></div>
                    <div class="w-2.5 h-2.5 rounded-full bg-slate-700"></div>
                </div>
                <span class="text-[10px] text-slate-500 font-mono">server_logs.log</span>
            </div>
            <div class="p-6 font-mono text-xs md:text-sm leading-relaxed opacity-90" dir="ltr">
                <div class="text-slate-500 mb-2"># System Diagnostic Report</div>
                <div class="text-slate-400">Status: <span class="text-red-500 font-bold">CRITICAL</span></div>
                <br>
                <div class="text-red-400"><span class="text-slate-500">[Error]</span> Connection refused</div>
                <div class="mt-2 animate-pulse text-emerald-500">_</div>
            </div>
        </div>

        <div class="mt-10 flex flex-col sm:flex-row items-center justify-center gap-4">
            <button onclick="location.reload()" class="w-full sm:w-auto px-8 py-3 rounded-lg bg-white text-slate-900 font-bold hover:bg-slate-200 transition flex items-center justify-center gap-2">
                <i class="fa-solid fa-rotate-right"></i> تحديث الصفحة
            </button>
            <a href="{{ url('/') }}" class="w-full sm:w-auto px-8 py-3 rounded-lg border border-slate-700 text-slate-300 hover:text-white hover:bg-slate-800 transition flex items-center justify-center gap-2">
                العودة للرئيسية
            </a>
        </div>
    </div>
@endsection
