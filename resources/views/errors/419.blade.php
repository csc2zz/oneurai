@extends('errors.layout')
@section('title', '419 - انتهت الجلسة')
@section('styles')
<style>
    .glass-box { background: rgba(255, 255, 255, 0.03); backdrop-filter: blur(5px); border: 1px solid rgba(255, 255, 255, 0.05); }
</style>
@endsection

@section('content')
    <div class="absolute inset-0 overflow-hidden pointer-events-none opacity-5">
        <i class="fa-regular fa-clock text-9xl absolute top-20 left-20 animate-spin-slow"></i>
        <i class="fa-solid fa-hourglass-half text-8xl absolute bottom-20 right-20 rotate-12"></i>
    </div>

    <div class="relative z-10 w-full max-w-lg px-6 text-center animate-fade-up">
        <div class="relative w-32 h-32 mx-auto mb-8 flex items-center justify-center">
            <div class="absolute inset-0 bg-amber-500/10 rounded-full blur-2xl"></div>
            <div class="relative text-amber-500 text-6xl animate-pulse">
                <i class="fa-solid fa-hourglass-end"></i>
            </div>
        </div>

        <h1 class="text-6xl font-bold text-white mb-2 font-mono tracking-tighter">419</h1>
        <h2 class="text-2xl font-bold text-slate-200 mb-4">عذراً.. انتهت صلاحية الصفحة</h2>
        <p class="text-slate-400 text-sm mb-10 leading-relaxed max-w-sm mx-auto">
            توقفت الجلسة بسبب عدم النشاط لفترة طويلة. يرجى التحديث للمتابعة.
        </p>

        <button onclick="location.reload()" class="group relative w-full sm:w-auto px-8 py-3.5 rounded-full bg-amber-500 hover:bg-amber-400 text-slate-900 font-bold text-sm transition shadow-lg shadow-amber-500/20 flex items-center justify-center gap-3 mx-auto">
            <span>تحديث الصفحة والمتابعة</span>
            <i class="fa-solid fa-rotate-right group-hover:rotate-180 transition duration-500"></i>
        </button>

        <div class="mt-12 pt-6 border-t border-white/5">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-md bg-slate-900 border border-slate-800 text-[10px] text-slate-500 font-mono">
                <i class="fa-brands fa-laravel text-red-900"></i>
                <span>CSRF Token Mismatch</span>
            </div>
        </div>
    </div>
@endsection
