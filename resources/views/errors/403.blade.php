@extends('errors.layout')
@section('title', '403 - دخول ممنوع')
@section('styles')
<style>
    .glass-panel { background: rgba(30, 41, 59, 0.7); backdrop-filter: blur(12px); border: 1px solid rgba(255, 255, 255, 0.05); }
</style>
@endsection

@section('content')
    <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(#f59e0b 1px, transparent 1px); background-size: 40px 40px;"></div>

    <div class="relative z-10 w-full max-w-2xl px-6 text-center">
        <div class="relative w-24 h-24 mx-auto mb-8">
            <div class="absolute inset-0 bg-amber-500/20 rounded-2xl blur-xl animate-pulse"></div>
            <div class="relative bg-slate-900 border border-slate-700 w-full h-full rounded-2xl flex items-center justify-center overflow-hidden shadow-2xl">
                <i class="fa-solid fa-shield-halved text-5xl text-amber-500"></i>
                <div class="absolute left-0 w-full h-1 bg-amber-400 shadow-[0_0_15px_rgba(245,158,11,1)] animate-scan opacity-80"></div>
            </div>
            <div class="absolute -bottom-3 -right-3 bg-slate-800 border border-slate-600 p-2 rounded-full shadow-lg">
                <i class="fa-solid fa-lock text-white text-sm"></i>
            </div>
        </div>

        <h1 class="text-6xl md:text-8xl font-bold text-white mb-2 font-mono tracking-tighter">403</h1>
        <h2 class="text-2xl font-bold text-slate-200 mb-4">عذراً.. لا تملك صلاحية الوصول</h2>
        <p class="text-slate-400 text-sm mb-10 max-w-md mx-auto leading-relaxed">
            هذه المنطقة محظورة. قد يتطلب الأمر تسجيل الدخول بحساب مختلف أو الحصول على صلاحيات "Admin".
        </p>

        <div class="glass-panel rounded-xl p-5 text-left mb-10 mx-auto max-w-lg shadow-2xl transform rotate-1 hover:rotate-0 transition duration-500">
            <div class="flex gap-1.5 mb-3 border-b border-white/5 pb-2">
                <div class="w-2.5 h-2.5 rounded-full bg-red-500"></div>
                <div class="w-2.5 h-2.5 rounded-full bg-amber-500"></div>
                <div class="w-2.5 h-2.5 rounded-full bg-emerald-500"></div>
                <span class="ml-auto text-[10px] text-slate-500 font-mono">Middleware/CheckRole.php</span>
            </div>
            <code class="font-mono text-xs md:text-sm text-slate-300 block leading-relaxed" dir="ltr">
                <span class="text-emerald-400">if</span> (! $user->hasPermission(<span class="text-amber-400">'view_page'</span>)) {<br>
                &nbsp;&nbsp;<span class="text-slate-500">// Security Protocol Initiated</span><br>
                &nbsp;&nbsp;<span class="text-purple-400">abort</span>(403, <span class="text-amber-400">'Access Denied'</span>);<br>
                }
            </code>
        </div>

        <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
            <a href="{{ url('/') }}" class="w-full sm:w-auto px-8 py-3 rounded-lg bg-amber-500 hover:bg-amber-600 text-slate-900 font-bold text-sm transition flex items-center justify-center gap-2 shadow-lg shadow-amber-500/20">
                <i class="fa-solid fa-arrow-right"></i> العودة للخلف
            </a>
        </div>
    </div>
@endsection
