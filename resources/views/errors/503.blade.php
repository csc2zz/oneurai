@extends('errors.layout')
@section('title', '503 - تحت الصيانة')
@section('content')
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <i class="fa-solid fa-wrench text-8xl text-slate-800 absolute top-20 left-10 opacity-20 rotate-12"></i>
        <i class="fa-solid fa-gear text-9xl text-slate-800 absolute bottom-10 right-10 opacity-20 animate-spin-slow"></i>
    </div>

    <div class="relative z-10 w-full max-w-2xl px-6 text-center">
        <div class="w-24 h-24 bg-amber-500 rounded-2xl mx-auto mb-8 flex items-center justify-center shadow-[0_0_30px_rgba(245,158,11,0.4)] animate-pulse">
            <i class="fa-solid fa-person-digging text-5xl text-slate-900"></i>
        </div>

        <h1 class="text-5xl font-bold text-white mb-2">نعود قريباً!</h1>
        <h2 class="text-xl text-slate-400 mb-8">الموقع تحت الصيانة الدورية حالياً</h2>

        <p class="text-slate-500 text-sm mb-8 leading-relaxed max-w-md mx-auto">
            نقوم ببعض التحسينات لجعل تجربتك أفضل. لن يستغرق الأمر طويلاً. شكراً لصبرك!
        </p>

        <div class="inline-flex items-center gap-2 px-4 py-2 bg-slate-900 rounded-lg border border-slate-800 text-xs text-slate-400 font-mono">
            <span class="w-2 h-2 bg-emerald-500 rounded-full animate-pulse"></span>
            System Update in Progress...
        </div>
    </div>
@endsection
