@php
    $errors = $errors ?? new \Illuminate\Support\ViewErrorBag;
@endphp
<!DOCTYPE html>
<html lang="id" class="h-full">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Masuk - Portal Admin Quran'Qita</title>
    <link href="/image/quran'qita.jpg" rel="shortcut icon">
    <meta name="description" content="Halaman masuk portal manajemen administrasi Quran'Qita.">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Amiri:ital,wght@0,400;0,700;1,400&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">

    <!-- RemixIcon -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.6.0/remixicon.min.css" rel="stylesheet">

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                        arabic: ['"Amiri"', 'serif'],
                    },
                    colors: {
                        emerald: {
                            50: '#ecfdf5',
                            100: '#d1fae5',
                            200: '#a7f3d0',
                            300: '#6ee7b7',
                            400: '#34d399',
                            500: '#10b981',
                            600: '#059669',
                            700: '#047857',
                            800: '#065f46',
                            900: '#064e3b',
                            950: '#022c22',
                        },
                        gold: {
                            400: '#fbbf24',
                            500: '#f59e0b',
                            600: '#d97706',
                        }
                    }
                }
            }
        }
    </script>

    <style>
        * {
            -webkit-tap-highlight-color: transparent;
        }

        .touch-btn {
            touch-action: manipulation;
            user-select: none;
            -webkit-user-select: none;
        }

        .arabic-text {
            font-family: 'Amiri', serif;
            direction: rtl;
        }

        .gold-gradient-text {
            background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 50%, #d97706 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .bg-mesh {
            background-color: #022c22;
            background-image: 
                radial-gradient(at 10% 10%, rgba(16, 185, 129, 0.25) 0px, transparent 50%),
                radial-gradient(at 90% 90%, rgba(245, 158, 11, 0.15) 0px, transparent 50%),
                radial-gradient(at 50% 50%, rgba(5, 150, 105, 0.2) 0px, transparent 60%);
        }
    </style>
</head>

<body class="bg-slate-50 text-slate-800 font-sans antialiased min-h-screen flex flex-col justify-between selection:bg-emerald-500 selection:text-white">

    <!-- FLOATING TOP BAR (BACK TO HOME & BRAND) -->
    <header class="w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-4 sm:pt-6 flex items-center justify-between z-20">
        <a href="/" class="inline-flex items-center space-x-2 text-xs sm:text-sm font-semibold text-slate-600 hover:text-emerald-700 bg-white/90 hover:bg-white px-3.5 py-2 rounded-xl shadow-xs border border-slate-200/80 transition duration-200 touch-btn">
            <i class="ri-arrow-left-line text-base"></i>
            <span>Kembali ke Beranda</span>
        </a>

        <div class="flex items-center space-x-1.5 text-xs text-slate-500">
            <i class="ri-shield-keyhole-line text-emerald-600"></i>
            <span class="hidden sm:inline">Portal Administrasi Terenkripsi</span>
        </div>
    </header>

    <!-- MAIN CONTAINER -->
    <main class="flex-1 flex items-center justify-center px-4 sm:px-6 lg:px-8 py-8 sm:py-12">
        <div class="w-full max-w-5xl bg-white rounded-3xl sm:rounded-4xl shadow-2xl shadow-emerald-950/10 border border-slate-200/80 overflow-hidden grid grid-cols-1 lg:grid-cols-12 min-h-[580px]">
            
            <!-- LEFT PANEL: ISLAMIC SHOWCASE (DESKTOP ONLY) -->
            <div class="hidden lg:flex lg:col-span-5 bg-mesh relative p-10 flex-col justify-between text-white overflow-hidden">
                <!-- Background Geometric Glow -->
                <div class="absolute -top-24 -left-24 w-72 h-72 bg-emerald-500/20 rounded-full blur-3xl pointer-events-none"></div>
                <div class="absolute -bottom-24 -right-24 w-72 h-72 bg-gold-500/15 rounded-full blur-3xl pointer-events-none"></div>

                <!-- Brand Top -->
                <div class="relative z-10">
                    <a href="/" class="inline-flex items-center space-x-3 group">
                        <div class="w-12 h-12 rounded-2xl bg-gradient-to-tr from-emerald-600 to-teal-400 p-0.5 shadow-lg shadow-emerald-950/40">
                            <div class="w-full h-full bg-slate-950 rounded-[14px] flex items-center justify-center overflow-hidden">
                                <img src="/image/quran'qita.jpg" alt="Logo QuranQita" class="w-full h-full object-cover">
                            </div>
                        </div>
                        <div>
                            <div class="flex items-center space-x-2">
                                <span class="text-2xl font-extrabold tracking-tight text-white">Quran'<span class="text-emerald-400">Qita</span></span>
                                <span class="text-[10px] font-bold uppercase tracking-wider bg-emerald-800/80 text-emerald-200 px-2 py-0.5 rounded-md border border-emerald-500/30">Admin</span>
                            </div>
                            <p class="text-xs text-emerald-200/70 font-medium">Sistem Tata Kelola Konten Islami</p>
                        </div>
                    </a>
                </div>

                <!-- Center: Ayat Calligraphy & Quotes -->
                <div class="relative z-10 my-8 space-y-5 bg-white/5 backdrop-blur-md rounded-2xl p-6 border border-white/10">
                    <div class="text-center space-y-2">
                        <p class="arabic-text text-2xl text-emerald-300 font-normal leading-loose">
                            بِسْمِ اللَّهِ الرَّحْمَٰنِ الرَّحِيمِ
                        </p>
                        <p class="arabic-text text-xl text-white font-normal leading-relaxed">
                            وَقُلْ رَبِّ زِدْنِي عِلْمًا
                        </p>
                        <p class="text-xs text-slate-300 italic pt-1 leading-relaxed">
                            "Dan katakanlah: 'Ya Tuhanku, tambahkanlah kepadaku ilmu pengetahuan.'"
                        </p>
                        <span class="inline-block text-[11px] font-semibold text-gold-400 uppercase tracking-wider">QS. Thaha: 114</span>
                    </div>

                    <div class="pt-4 border-t border-white/10 space-y-2.5 text-xs text-emerald-100/90">
                        <div class="flex items-center space-x-2">
                            <i class="ri-checkbox-circle-fill text-emerald-400 text-sm"></i>
                            <span>Kelola 114 Surat & 6.236 Ayat Al-Qur'an</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <i class="ri-checkbox-circle-fill text-emerald-400 text-sm"></i>
                            <span>Manajemen Kuis, Modul & Tanya Asatidz</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <i class="ri-checkbox-circle-fill text-emerald-400 text-sm"></i>
                            <span>Integrasi Donasi, Transaksi & Duitku</span>
                        </div>
                    </div>
                </div>

                <!-- Bottom Footer Info -->
                <div class="relative z-10 flex items-center justify-between text-xs text-emerald-200/60 pt-4 border-t border-white/10">
                    <span>Versi Portal v2.4</span>
                    <span class="flex items-center space-x-1">
                        <i class="ri-lock-2-line text-emerald-400"></i>
                        <span>256-Bit SSL Secured</span>
                    </span>
                </div>
            </div>

            <!-- RIGHT PANEL: LOGIN FORM (RESPONSIVE) -->
            <div class="lg:col-span-7 p-6 sm:p-10 lg:p-12 flex flex-col justify-center bg-white">
                
                <!-- MOBILE LOGO HEADER (ONLY VISIBLE ON < lg) -->
                <div class="lg:hidden flex items-center space-x-3 mb-6 pb-6 border-b border-slate-100">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-emerald-700 to-teal-400 p-0.5 shadow-md">
                        <div class="w-full h-full bg-slate-900 rounded-[10px] flex items-center justify-center overflow-hidden">
                            <img src="/image/quran'qita.jpg" alt="Logo QuranQita" class="w-full h-full object-cover">
                        </div>
                    </div>
                    <div>
                        <div class="flex items-center space-x-1.5">
                            <span class="text-xl font-extrabold tracking-tight text-slate-900">Quran'<span class="text-emerald-600">Qita</span></span>
                            <span class="text-[9px] font-bold uppercase tracking-wider bg-emerald-100 text-emerald-800 px-1.5 py-0.5 rounded-md border border-emerald-200">Admin</span>
                        </div>
                        <p class="text-[11px] text-slate-500 font-medium">Portal Masuk Pengelola</p>
                    </div>
                </div>

                <div class="space-y-2 mb-6">
                    <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">
                        Selamat Datang Kembali 👋
                    </h1>
                    <p class="text-xs sm:text-sm text-slate-500 leading-relaxed">
                        Masuk dengan akun administrator terdaftar untuk mengakses seluruh fitur dashboard Quran'Qita.
                    </p>
                </div>

                <!-- ALERT ERROR -->
                @if ($errors->any())
                    <div id="alert-error" class="mb-6 p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-800 flex items-start space-x-3 animate-fade-in">
                        <i class="ri-error-warning-fill text-xl text-rose-500 flex-shrink-0 mt-0.5"></i>
                        <div class="flex-1 text-xs sm:text-sm">
                            <p class="font-bold text-rose-900">Gagal Masuk</p>
                            <ul class="mt-1 list-disc list-inside space-y-0.5 text-rose-700">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        <button type="button" onclick="document.getElementById('alert-error').remove()" class="text-rose-400 hover:text-rose-700 p-1">
                            <i class="ri-close-line text-lg"></i>
                        </button>
                    </div>
                @endif

                <!-- FORM LOGIN -->
                <form id="login-form" class="space-y-5" method="POST" action="{{ route('login') }}">
                    @csrf

                    <!-- EMAIL INPUT -->
                    <div>
                        <label for="email" class="block text-xs sm:text-sm font-bold text-slate-700 mb-1.5">
                            Alamat Email
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                <i class="ri-mail-line text-lg"></i>
                            </div>
                            <input 
                                type="email" 
                                name="email" 
                                id="email" 
                                value="{{ old('email') }}"
                                required 
                                autofocus 
                                autocomplete="email"
                                placeholder="nama@quranqita.pro"
                                class="w-full pl-10 pr-4 py-3 sm:py-3.5 bg-slate-50/70 border @error('email') border-rose-300 bg-rose-50/30 @else border-slate-200 @enderror rounded-xl sm:rounded-2xl text-xs sm:text-sm font-medium text-slate-800 placeholder-slate-400 focus:bg-white focus:outline-none focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10 transition duration-200 shadow-2xs"
                            >
                        </div>
                        @error('email')
                            <p class="mt-1.5 text-xs text-rose-600 font-medium flex items-center space-x-1">
                                <i class="ri-information-line"></i>
                                <span>{{ $message }}</span>
                            </p>
                        @enderror
                    </div>

                    <!-- PASSWORD INPUT -->
                    <div>
                        <div class="flex items-center justify-between mb-1.5">
                            <label for="password" class="block text-xs sm:text-sm font-bold text-slate-700">
                                Kata Sandi
                            </label>
                            <a href="mailto:support@quranqita.pro?subject=Reset%20Password%20Admin%20QuranQita" class="text-xs font-semibold text-emerald-600 hover:text-emerald-700 hover:underline">
                                Lupa sandi?
                            </a>
                        </div>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                <i class="ri-lock-password-line text-lg"></i>
                            </div>
                            <input 
                                type="password" 
                                name="password" 
                                id="password" 
                                required 
                                autocomplete="current-password"
                                placeholder="Masukkan kata sandi akun"
                                class="w-full pl-10 pr-12 py-3 sm:py-3.5 bg-slate-50/70 border @error('password') border-rose-300 bg-rose-50/30 @else border-slate-200 @enderror rounded-xl sm:rounded-2xl text-xs sm:text-sm font-medium text-slate-800 placeholder-slate-400 focus:bg-white focus:outline-none focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10 transition duration-200 shadow-2xs"
                            >
                            <!-- TOGGLE SHOW PASSWORD -->
                            <button 
                                type="button" 
                                id="toggle-password" 
                                class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 hover:text-slate-600 focus:outline-none touch-btn"
                                aria-label="Lihat kata sandi"
                            >
                                <i class="ri-eye-line text-lg" id="password-icon"></i>
                            </button>
                        </div>
                        @error('password')
                            <p class="mt-1.5 text-xs text-rose-600 font-medium flex items-center space-x-1">
                                <i class="ri-information-line"></i>
                                <span>{{ $message }}</span>
                            </p>
                        @enderror
                    </div>

                    <!-- REMEMBER ME CHECKBOX -->
                    <div class="flex items-center justify-between pt-1">
                        <label class="flex items-center space-x-2.5 cursor-pointer select-none">
                            <input 
                                type="checkbox" 
                                name="remember" 
                                id="remember"
                                class="w-4 h-4 rounded text-emerald-600 border-slate-300 focus:ring-emerald-500 focus:ring-2 focus:ring-offset-1 transition"
                            >
                            <span class="text-xs sm:text-sm text-slate-600 font-medium">Ingat perangkat ini</span>
                        </label>
                    </div>

                    <!-- SUBMIT BUTTON -->
                    <div class="pt-2">
                        <button 
                            type="submit" 
                            id="btn-submit"
                            class="w-full py-3.5 sm:py-4 px-6 rounded-xl sm:rounded-2xl bg-gradient-to-r from-emerald-600 via-emerald-500 to-teal-500 hover:from-emerald-700 hover:to-teal-600 text-white font-bold text-sm sm:text-base shadow-lg shadow-emerald-600/25 active:scale-[0.98] transition duration-200 flex items-center justify-center space-x-2 touch-btn cursor-pointer"
                        >
                            <span id="btn-text">Masuk ke Dashboard</span>
                            <i class="ri-arrow-right-line text-lg" id="btn-icon"></i>
                        </button>
                    </div>

                    <!-- FOOTER HINT -->
                    <div class="pt-4 text-center">
                        <p class="text-xs text-slate-500">
                            Pengguna aplikasi Android? 
                            <a href="https://play.google.com/store/apps/details?id=com.bsndev.quranqita&hl=id" target="_blank" rel="noopener noreferrer" class="font-bold text-emerald-600 hover:text-emerald-700 hover:underline">
                                Buka Aplikasi di Google Play
                            </a>
                        </p>
                    </div>
                </form>

            </div>
        </div>
    </main>

    <!-- FOOTER COPYRIGHT -->
    <footer class="w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 sm:py-6 text-center text-xs text-slate-400">
        <p>&copy; {{ date('Y') }} Quran'Qita. All rights reserved. Nawaitu Digital.</p>
    </footer>

    <!-- INTERACTIVE JAVASCRIPT -->
    <script>
        // Password Visibility Toggle
        const togglePassword = document.getElementById('toggle-password');
        const passwordInput = document.getElementById('password');
        const passwordIcon = document.getElementById('password-icon');

        if (togglePassword && passwordInput && passwordIcon) {
            togglePassword.addEventListener('click', function () {
                const isPassword = passwordInput.getAttribute('type') === 'password';
                if (isPassword) {
                    passwordInput.setAttribute('type', 'text');
                    passwordIcon.classList.replace('ri-eye-line', 'ri-eye-off-line');
                } else {
                    passwordInput.setAttribute('type', 'password');
                    passwordIcon.classList.replace('ri-eye-off-line', 'ri-eye-line');
                }
            });
        }

        // Submit Button Loading Feedback
        const loginForm = document.getElementById('login-form');
        const btnSubmit = document.getElementById('btn-submit');
        const btnText = document.getElementById('btn-text');
        const btnIcon = document.getElementById('btn-icon');

        if (loginForm && btnSubmit) {
            loginForm.addEventListener('submit', function () {
                btnSubmit.disabled = true;
                btnSubmit.classList.add('opacity-85', 'cursor-not-allowed');
                btnText.textContent = 'Memverifikasi...';
                btnIcon.className = 'ri-loader-4-line animate-spin text-lg';
            });
        }
    </script>
</body>

</html>
