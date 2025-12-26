<div class="max-w-3xl mx-auto py-8 px-4">
    {{-- هيدر الصفحة --}}
    <div class="mb-8">
        <h2 class="text-2xl font-bold text-slate-800 tracking-tight">فتح تذكرة دعم جديدة</h2>
        <p class="text-slate-500 text-sm mt-1">أخبرنا بمشكلتك وسيقوم فريق Oneurai بالرد عليك في أقرب وقت.</p>
    </div>

    <form wire:submit.prevent="save" class="space-y-6">
        <div class="bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="p-6 md:p-8 space-y-5">
                
                {{-- الموضوع --}}
                <div class="space-y-2">
                    <label class="text-sm font-bold text-slate-700 px-1">عنوان التذكرة</label>
                    <input type="text" wire:model="subject" placeholder="مثلاً: مشكلة في رفع المستودع"
                        class="w-full bg-slate-50 border-slate-200 rounded-2xl py-3 px-4 text-sm focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 transition-all outline-none">
                    @error('subject') <span class="text-red-500 text-xs px-1">{{ $message }}</span> @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    {{-- القسم --}}
                    <div class="space-y-2">
                        <label class="text-sm font-bold text-slate-700 px-1">القسم</label>
                        <select wire:model="category" class="w-full bg-slate-50 border-slate-200 rounded-2xl py-3 px-4 text-sm focus:ring-4 focus:ring-emerald-500/10 outline-none appearance-none cursor-pointer">
                            <option value="technical">دعم فني</option>
                            <option value="billing">الفواتير</option>
                            <option value="feature">اقتراح ميزة</option>
                        </select>
                    </div>

                    {{-- الأولوية --}}
                    <div class="space-y-2">
                        <label class="text-sm font-bold text-slate-700 px-1">الأولوية</label>
                        <div class="flex p-1 bg-slate-100 rounded-2xl">
                            <label class="flex-1 cursor-pointer">
                                <input type="radio" wire:model="priority" value="low" class="hidden peer">
                                <span class="block text-center py-2 text-xs font-bold rounded-xl peer-checked:bg-white peer-checked:text-emerald-600 peer-checked:shadow-sm text-slate-500 transition-all">عادية</span>
                            </label>
                            <label class="flex-1 cursor-pointer">
                                <input type="radio" wire:model="priority" value="high" class="hidden peer">
                                <span class="block text-center py-2 text-xs font-bold rounded-xl peer-checked:bg-red-500 peer-checked:text-white peer-checked:shadow-sm text-slate-500 transition-all">عاجلة</span>
                            </label>
                        </div>
                    </div>
                </div>

                {{-- نص الرسالة --}}
                <div class="space-y-2">
                    <label class="text-sm font-bold text-slate-700 px-1">تفاصيل المشكلة</label>
                    <textarea wire:model="message" rows="5" placeholder="اشرح لنا ما حدث معك..."
                        class="w-full bg-slate-50 border-slate-200 rounded-2xl py-3 px-4 text-sm focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 transition-all outline-none resize-none"></textarea>
                    @error('message') <span class="text-red-500 text-xs px-1">{{ $message }}</span> @enderror
                </div>

                {{-- المرفقات --}}
                <div class="space-y-2">
                    <label class="text-sm font-bold text-slate-700 px-1">المرفقات (صور)</label>
                    <div class="relative group border-2 border-dashed border-slate-200 rounded-2xl p-8 transition-colors hover:border-emerald-400 flex flex-col items-center justify-center">
                        <input type="file" wire:model="attachments" class="absolute inset-0 opacity-0 cursor-pointer" multiple>
                        <i class="fa-solid fa-cloud-arrow-up text-3xl text-slate-300 group-hover:text-emerald-500 transition-colors mb-2"></i>
                        <span class="text-xs text-slate-400 group-hover:text-emerald-600 transition-colors">اسحب الصور هنا أو اضغط للاختيار</span>
                    </div>
                    {{-- حالة الرفع --}}
                    <div wire:loading wire:target="attachments" class="text-xs text-emerald-600 font-bold animate-pulse">
                        <i class="fa-solid fa-spinner fa-spin mr-1"></i> جاري معالجة الملفات...
                    </div>
                </div>
            </div>

            {{-- تذييل الكرت --}}
            <div class="px-8 py-4 bg-slate-50 border-t border-slate-200 flex items-center justify-between">
                <a href="{{ route('dashboard.tickets') }}" class="text-sm font-bold text-slate-500 hover:text-slate-800 transition">إلغاء</a>
                <button type="submit" 
                    class="bg-emerald-600 hover:bg-emerald-700 text-white px-8 py-3 rounded-xl font-bold text-sm shadow-lg shadow-emerald-500/20 transition-all active:scale-95 flex items-center gap-2">
                    <i class="fa-solid fa-paper-plane text-xs"></i>
                    إرسال التذكرة
                </button>
            </div>
        </div>
    </form>
</div>