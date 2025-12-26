@extends('errors.layout')

@section('title', '404 - لم يتم العثور على الصفحة')

@section('content')
    {{-- نافذة التيرمينال --}}
    <div class="bg-slate-900 rounded-xl border border-slate-800 shadow-2xl overflow-hidden transform hover:scale-[1.01] transition duration-500">

        <div class="bg-slate-800 px-4 py-3 flex items-center gap-2 border-b border-slate-700">
            <div class="flex gap-2">
                <div class="w-3 h-3 rounded-full bg-red-500"></div>
                <div class="w-3 h-3 rounded-full bg-amber-500"></div>
                <div class="w-3 h-3 rounded-full bg-emerald-500"></div>
            </div>
            <div class="ml-auto text-xs text-slate-400 font-mono">root@oneurai:~</div>
        </div>

        <div class="p-6 sm:p-8 font-mono text-sm sm:text-base leading-relaxed dir-ltr text-left">
            <div class="mb-4">
                <span class="text-emerald-500">➜</span> <span class="text-blue-400">~</span> <span class="text-slate-300">python3 navigate.py</span>
            </div>

            <div class="text-slate-300 mb-6">
                Traceback (most recent call last):<br>
                &nbsp;&nbsp;File "navigate.py", line 404, in &lt;module&gt;<br>
                &nbsp;&nbsp;&nbsp;&nbsp;raise <span class="text-red-400 font-bold">PageNotFoundError</span>("URL not found on server.")<br>
                <span class="text-red-500 font-bold">Error 404: Page Not Found</span>
            </div>

            <div class="flex items-center gap-2">
                <span class="text-emerald-500">➜</span> <span class="text-blue-400">~</span>
                <span class="text-slate-300">try:</span>
                <span class="bg-emerald-500 w-2.5 h-5 inline-block animate-cursor"></span>
            </div>
        </div>
    </div>

    {{-- النصوص والأزرار --}}
    <div class="text-center mt-10 space-y-4">
        <h1 class="text-2xl font-bold text-white">عفواً.. ضللت الطريق في الكود!</h1>
        <p class="text-slate-400 text-sm max-w-md mx-auto">الصفحة التي تبحث عنها قد تكون حذفت أو غير متاحة.</p>

        <div class="flex justify-center gap-4 mt-6">
            <a href="{{ url('/') }}" class="px-6 py-3 rounded-lg bg-emerald-600 hover:bg-emerald-500 text-white font-bold text-sm transition flex items-center gap-2 shadow-lg shadow-emerald-900/50">
                <i class="fa-solid fa-house"></i> العودة للرئيسية
            </a>
            <a href="#" class="px-6 py-3 rounded-lg border border-slate-700 text-slate-300 hover:text-white hover:bg-slate-800 font-bold text-sm transition opacity-50 cursor-not-allowed">
                <i class="fa-solid fa-life-ring"></i> المساعدة
            </a>
        </div>
    </div>
@endsection
