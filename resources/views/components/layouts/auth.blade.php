<!DOCTYPE html>
<html lang="ar" dir="rtl" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Oneurai' }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;600;700;800&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                        arabic: ['Cairo', 'sans-serif'], // الخط الأساسي
                    },
                    colors: {
                        emerald: {
                            50: '#ecfdf5',
                            100: '#d1fae5',
                            600: '#059669', // Saudi Green
                            700: '#047857',
                            800: '#065f46',
                            900: '#064e3b',
                        },
                        amber: {
                            400: '#fbbf24',
                            500: '#f59e0b', // Gold
                        }
                    }
                }
            }
        }
    </script>

    <style>
        body {
            font-family: 'Cairo', sans-serif;
        }
        /* Pattern background for the decorative side */
        .bg-grid-pattern {
            background-image: radial-gradient(#ffffff 1px, transparent 1px);
            background-size: 30px 30px;
            opacity: 0.1;
        }
        .glass-card {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        .form-fade-in {
            animation: fadeIn 0.5s ease-out forwards;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>
    {{ $slot }}

    <script>
        let isLogin = true;

        function toggleAuth() {
            const loginForm = document.getElementById('login-form');
            const registerForm = document.getElementById('register-form');
            const title = document.getElementById('page-title');
            const subtitle = document.getElementById('page-subtitle');
            const toggleText = document.getElementById('toggle-text');
            const container = document.getElementById('auth-container');

            // Add fade effect
            container.classList.remove('form-fade-in');
            void container.offsetWidth; // Trigger reflow
            container.classList.add('form-fade-in');

            if (isLogin) {
                // Switch to Register
                loginForm.classList.add('hidden');
                registerForm.classList.remove('hidden');
                title.innerText = "انضم إلى Oneurai 🚀";
                subtitle.innerText = "أنشئ حسابك المجاني وابدأ رحلتك معنا.";
                toggleText.innerHTML = 'لديك حساب بالفعل؟ <button onclick="toggleAuth()" class="text-emerald-600 font-bold hover:text-emerald-700 transition mr-1">سجل دخولك</button>';
            } else {
                // Switch to Login
                registerForm.classList.add('hidden');
                loginForm.classList.remove('hidden');
                title.innerText = "أهلاً بعودتك 👋";
                subtitle.innerText = "أدخل بياناتك للدخول إلى مساحة العمل الخاصة بك.";
                toggleText.innerHTML = 'ليس لديك حساب؟ <button onclick="toggleAuth()" class="text-emerald-600 font-bold hover:text-emerald-700 transition mr-1">أنشئ حساباً الآن</button>';
            }
            isLogin = !isLogin;
        }
    </script>
</body>
</html>
