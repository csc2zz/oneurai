@props([
    'id',
    'title' => 'تأكيد العملية',
    'message' => 'هل أنت متأكد من المتابعة؟',
    'confirmText' => 'تأكيد',      // النص الافتراضي للزر
    'cancelText' => 'إلغاء',       // نص زر الإلغاء
    'type' => 'danger'             // نوع المودال: danger, success, warning, info
])

@php
    // إعدادات التصميم بناءً على نوع المودال
    $styles = [
        'danger' => [
            'icon_bg' => 'bg-red-100',
            'icon_text' => 'text-red-600',
            'icon' => 'fa-triangle-exclamation',
            'button' => 'bg-red-600 hover:bg-red-500 focus:ring-red-500',
        ],
        'success' => [
            'icon_bg' => 'bg-emerald-100',
            'icon_text' => 'text-emerald-600',
            'icon' => 'fa-check',
            'button' => 'bg-emerald-600 hover:bg-emerald-500 focus:ring-emerald-500',
        ],
        'warning' => [
            'icon_bg' => 'bg-amber-100',
            'icon_text' => 'text-amber-600',
            'icon' => 'fa-circle-exclamation',
            'button' => 'bg-amber-600 hover:bg-amber-500 focus:ring-amber-500',
        ],
        'info' => [
            'icon_bg' => 'bg-blue-100',
            'icon_text' => 'text-blue-600',
            'icon' => 'fa-info',
            'button' => 'bg-blue-600 hover:bg-blue-500 focus:ring-blue-500',
        ],
    ];

    // اختيار الستايل المناسب أو العودة للـ danger كافتراضي
    $currentStyle = $styles[$type] ?? $styles['danger'];
@endphp

<div x-data="{ open: false }"
     x-on:open-delete-modal-{{ $id }}.window="open = true"
     x-on:close-delete-modal-{{ $id }}.window="open = false"
     x-show="open"
     style="display: none;"
     class="relative z-50"
     aria-labelledby="modal-title"
     role="dialog"
     aria-modal="true">

    {{-- الخلفية المظللة --}}
    <div x-show="open"
         x-transition:enter="ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm transition-opacity"></div>

    <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
        <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">

            {{-- صندوق المودال --}}
            <div x-show="open"
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 @click.outside="open = false"
                 class="relative transform overflow-hidden rounded-2xl bg-white text-right shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg border border-slate-200">

                <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start gap-4">
                        {{-- الأيقونة الديناميكية --}}
                        <div class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full {{ $currentStyle['icon_bg'] }} sm:mx-0 sm:h-10 sm:w-10">
                            <i class="fa-solid {{ $currentStyle['icon'] }} {{ $currentStyle['icon_text'] }} text-lg"></i>
                        </div>

                        <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-right flex-1">
                            <h3 class="text-lg font-bold leading-6 text-slate-900" id="modal-title">{{ $title }}</h3>
                            <div class="mt-2">
                                <p class="text-sm text-slate-500">{{ $message }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- الأزرار --}}
                <div class="bg-slate-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6 gap-2">
                    <button type="button"
                            wire:click="{{ $attributes->get('wire:click') }}"
                            @click="open = false"
                            class="inline-flex w-full justify-center rounded-lg {{ $currentStyle['button'] }} px-3 py-2 text-sm font-bold text-white shadow-sm sm:w-auto transition">
                        {{ $confirmText }}
                    </button>
                    <button type="button"
                            @click="open = false"
                            class="mt-3 inline-flex w-full justify-center rounded-lg bg-white px-3 py-2 text-sm font-bold text-slate-900 shadow-sm ring-1 ring-inset ring-slate-300 hover:bg-slate-50 sm:mt-0 sm:w-auto transition">
                        الغاء الامر
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
