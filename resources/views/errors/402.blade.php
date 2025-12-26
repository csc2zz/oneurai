@extends('errors.layout')
@section('title', '402 - الدفع مطلوب')
@section('styles')
<style>
    .receipt { position: relative; background: #fff; }
    .receipt::after {
        content: ""; position: absolute; bottom: -10px; left: 0; width: 100%; height: 10px;
        background: linear-gradient(45deg, transparent 33.333%, #fff 33.333%, #fff 66.667%, transparent 66.667%),
                    linear-gradient(-45deg, transparent 33.333%, #fff 33.333%, #fff 66.667%, transparent 66.667%);
        background-size: 20px 40px;
    }
</style>
@endsection

@section('content')
    <div class="absolute inset-0 overflow-hidden pointer-events-none opacity-5">
        <i class="fa-solid fa-coins text-9xl absolute top-10 left-20 animate-float"></i>
        <i class="fa-solid fa-credit-card text-8xl absolute bottom-20 right-20 animate-float" style="animation-delay: 2s;"></i>
        <i class="fa-solid fa-file-invoice-dollar text-9xl absolute top-1/2 right-1/4 animate-float" style="animation-delay: 1s;"></i>
    </div>

    <div class="relative z-10 w-full max-w-4xl px-6 flex flex-col md:flex-row items-center gap-12">
        <div class="text-center md:text-right flex-1">
            <div class="inline-block bg-emerald-900/30 border border-emerald-500/30 text-emerald-400 px-3 py-1 rounded-full text-xs font-bold mb-4">الدفع مطلوب</div>
            <h1 class="text-6xl md:text-8xl font-bold text-white mb-2 font-mono tracking-tighter">402</h1>
            <h2 class="text-2xl font-bold text-slate-200 mb-4">عفواً.. الخدمة متوقفة مؤقتاً</h2>
            <p class="text-slate-400 text-sm mb-8 leading-relaxed max-w-md">يبدو أن هناك مشكلة في عملية الدفع الأخيرة أو أن اشتراكك قد انتهى.</p>
            <div class="bg-slate-900 rounded-lg p-4 border border-slate-800 font-mono text-xs text-left dir-ltr shadow-inner max-w-md mx-auto md:mx-0">
                <div class="flex gap-1.5 mb-2">
                    <div class="w-2 h-2 rounded-full bg-red-500"></div>
                    <div class="w-2 h-2 rounded-full bg-amber-500"></div>
                    <div class="w-2 h-2 rounded-full bg-emerald-500"></div>
                </div>
                <span class="text-purple-400">const</span> subscription = <span class="text-blue-400">await</span> User.<span class="text-yellow-400">checkStatus</span>();<br>
                <span class="text-emerald-400">if</span> (subscription.status === <span class="text-red-400">'past_due'</span>) {<br>
                &nbsp;&nbsp;<span class="text-white">throw new PaymentError(402);</span><br>
                }
            </div>
        </div>

        <div class="relative w-full max-w-xs animate-float" style="animation-delay: 0.5s;">
            <div class="absolute inset-0 bg-emerald-500/20 blur-3xl rounded-full"></div>
            <div class="receipt p-6 text-slate-900 shadow-2xl transform rotate-3 hover:rotate-0 transition duration-500">
                <div class="text-center border-b-2 border-dashed border-slate-200 pb-4 mb-4">
                    <i class="fa-solid fa-code-branch text-3xl text-emerald-600 mb-2"></i>
                    <h3 class="font-bold text-lg">Oneurai Inc.</h3>
                    <p class="text-xs text-slate-500">فاتورة مستحقة</p>
                </div>
                <a href="#" class="block w-full bg-slate-900 text-white text-center py-3 rounded-lg font-bold hover:bg-emerald-600 transition shadow-lg">
                    ادفع الآن <i class="fa-solid fa-arrow-left mr-1"></i>
                </a>
            </div>
        </div>
    </div>
@endsection
