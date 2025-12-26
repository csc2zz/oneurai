<!DOCTYPE html>
<html lang="ar" dir="rtl" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'لوحة التحكم | Oneurai' }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;600;700&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    @livewireStyles

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Inter', 'sans-serif'], arabic: ['Cairo', 'sans-serif'] },
                    colors: {
                        emerald: { 50: '#ecfdf5', 100: '#d1fae5', 600: '#059669', 700: '#047857', 900: '#064e3b' },
                    }
                }
            }
        }
    </script>
    <style>
        * { font-family: 'Cairo', sans-serif; }
        [x-cloak] { display: none !important; }
        .custom-scrollbar::-webkit-scrollbar { width: 4px; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #059669; border-radius: 10px; }
    </style>
</head>
<body class="bg-slate-50 text-slate-900 selection:bg-emerald-100 overflow-hidden">

    <div class="flex h-screen overflow-hidden" x-data="{ sidebarOpen: false }">
        
        <div 
            x-show="sidebarOpen" 
            @click="sidebarOpen = false" 
            x-cloak
            x-transition:enter="transition-opacity ease-linear duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition-opacity ease-linear duration-300"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 z-40 bg-slate-900/60 backdrop-blur-sm lg:hidden">
        </div>

        <x-layouts.dashboard.sidebar />

        <div class="flex flex-col flex-1 min-w-0 overflow-hidden">
            
            <header class="flex-shrink-0 z-30" @open-menu.window="sidebarOpen = true">
                <x-layouts.dashboard.header />
            </header>

            <main class="flex-1 overflow-y-auto custom-scrollbar p-4 md:p-6 lg:p-8">
                <div class="max-w-7xl mx-auto">
                    {{ $slot }}
                </div>
            </main>
        </div>
    </div>

    <x-toast />
@if (session()->has('success'))
    <script>
        document.addEventListener('livewire:initialized', () => {
            window.dispatchEvent(new CustomEvent('notify', {
                detail: {
                    type: 'success',
                    title: 'عملية ناجحة',
                    message: '{{ session('success') }}'
                }
            }));
        });
    </script>
@endif
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('livewire:initialized', () => {
        Livewire.on('notify', (data) => {
            // Livewire 3 يرسل البيانات داخل مصفوفة
            const notification = data[0];

            // 1. إذا كان الإشعار يحتوي على HTML (للأخطاء الكبيرة)
            if (notification.html) {
                Swal.fire({
                    icon: notification.type, // warning, error, success
                    title: notification.title,
                    html: notification.message, // نستخدم html هنا لعرض التنسيق
                    confirmButtonText: 'حسناً',
                    confirmButtonColor: '#3085d6',
                    width: '600px',
                    padding: '1.5em',
                    background: '#fff',
                    customClass: {
                        htmlContainer: 'text-left' // لضمان ظهور الأكواد من اليسار
                    }
                });
            }
            // 2. للإشعارات العادية السريعة (Toast)
            else {
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end', // أو top-left حسب لغة الموقع
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.onmouseenter = Swal.stopTimer;
                        toast.onmouseleave = Swal.resumeTimer;
                    }
                });

                Toast.fire({
                    icon: notification.type,
                    title: notification.message // الرسالة القصيرة
                });
            }
        });
    });
</script>

    {{-- 2. هذا هو أهم سطر! بدونه لن يعمل التوست ولا أي شيء ديناميكي --}}
    @livewireScripts
</body>
</html>
