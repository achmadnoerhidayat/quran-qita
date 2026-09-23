<!DOCTYPE html>
<html lang="id" class="scroll-smooth overflow-x-hidden">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Quran'Qita - Al-Qur'an Digital Modern & Ekosistem Ibadah Muslim</title>
    <link href="/image/quran'qita.jpg" rel="shortcut icon">
    <meta name="description"
        content="Aplikasi Al-Qur'an digital modern terlengkap dengan audio murottal, tafsir Kemenag, chat AI Islami, jadwal sholat, masjid terdekat, kuis, kelas belajar, dan komunitas Muslim.">

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
                            50: '#fffbeb',
                            100: '#fef3c7',
                            200: '#fde68a',
                            300: '#fcd34d',
                            400: '#fbbf24',
                            500: '#f59e0b',
                            600: '#d97706',
                            700: '#b45309',
                        }
                    }
                }
            }
        }
    </script>

    <style>
        /* Mobile Touch Optimization for Android */
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

        .glass-panel {
            background: rgba(255, 255, 255, 0.94);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
        }

        .glass-dark {
            background: rgba(15, 23, 42, 0.85);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
        }

        .gold-gradient-text {
            background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 50%, #d97706 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        /* Smooth scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
        }
        ::-webkit-scrollbar-track {
            background: #f8fafc;
        }
        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 9999px;
        }
    </style>
</head>

<body class="bg-[#fafcfa] text-slate-800 font-sans antialiased selection:bg-emerald-500 selection:text-white overflow-x-hidden">

    <!-- NAVBAR (RESPONSIVE ON ANDROID & DESKTOP) -->
    <header class="fixed top-0 left-0 right-0 z-50 transition-all duration-300 glass-panel border-b border-slate-200/80 shadow-xs" id="navbar">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16 sm:h-20">
                
                <!-- LOGO BRANDING -->
                <a href="/" class="flex items-center space-x-2.5 sm:space-x-3 group">
                    <div class="w-10 h-10 sm:w-11 sm:h-11 rounded-xl sm:rounded-2xl bg-gradient-to-tr from-emerald-700 via-emerald-600 to-teal-400 p-0.5 shadow-md shadow-emerald-900/15 group-hover:scale-105 transition-transform">
                        <div class="w-full h-full bg-slate-900 rounded-[10px] sm:rounded-[14px] flex items-center justify-center overflow-hidden">
                            <img src="/image/quran'qita.jpg" alt="Logo QuranQita" class="w-full h-full object-cover">
                        </div>
                    </div>
                    <div>
                        <div class="flex items-center space-x-1.5">
                            <span class="text-xl sm:text-2xl font-extrabold tracking-tight text-slate-900">Quran'<span class="text-emerald-600">Qita</span></span>
                            <span class="text-[9px] sm:text-[10px] font-bold uppercase tracking-wider bg-emerald-100 text-emerald-800 px-1.5 py-0.5 rounded-md border border-emerald-200">Pro</span>
                        </div>
                        <p class="text-[10px] sm:text-xs text-slate-500 font-medium hidden sm:block">Ekosistem Al-Qur'an & Ibadah Digital</p>
                    </div>
                </a>

                <!-- DESKTOP NAVIGATION -->
                <nav class="hidden lg:flex items-center space-x-7">
                    <a href="#beranda" class="text-sm font-semibold text-slate-600 hover:text-emerald-600 transition">Beranda</a>
                    <a href="#fitur" class="text-sm font-semibold text-slate-600 hover:text-emerald-600 transition">Fitur</a>
                    <a href="#surat" class="text-sm font-semibold text-slate-600 hover:text-emerald-600 transition">Al-Qur'an</a>
                    <a href="#tasbih" class="text-sm font-semibold text-slate-600 hover:text-emerald-600 transition">Tasbih</a>
                    <a href="#sholat" class="text-sm font-semibold text-slate-600 hover:text-emerald-600 transition">Jadwal Sholat</a>
                    <a href="#paket" class="text-sm font-semibold text-slate-600 hover:text-emerald-600 transition">Paket Pro</a>
                </nav>

                <!-- ACTION BUTTON (HANYA LOGIN / DASHBOARD) -->
                <div class="flex items-center space-x-2">
                    @auth
                        <a href="/dashboard" class="inline-flex items-center space-x-1.5 bg-emerald-600 hover:bg-emerald-700 text-white text-xs sm:text-sm font-bold px-3.5 py-2 sm:px-5 sm:py-2.5 rounded-xl shadow-sm hover:shadow-md transition touch-btn">
                            <i class="ri-dashboard-3-line text-sm sm:text-base"></i>
                            <span>Dashboard</span>
                        </a>
                    @else
                        <a href="/login" class="inline-flex items-center space-x-1.5 bg-emerald-600 hover:bg-emerald-700 text-white text-xs sm:text-sm font-bold px-3.5 py-2 sm:px-5 sm:py-2.5 rounded-xl shadow-sm hover:shadow-md transition touch-btn">
                            <i class="ri-login-box-line text-sm sm:text-base"></i>
                            <span>Login</span>
                        </a>
                    @endauth

                    <!-- MOBILE MENU TOGGLE (ANDROID TOUCH FRIENDLY) -->
                    <button id="mobile-menu-btn" class="p-2 rounded-xl text-slate-700 hover:text-emerald-600 hover:bg-emerald-50 focus:outline-none lg:hidden touch-btn" aria-label="Buka Menu">
                        <i class="ri-menu-4-line text-2xl" id="menu-icon"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- MOBILE MENU DROPDOWN (FULL WIDTH ON ANDROID) -->
        <div id="mobile-menu" class="hidden lg:hidden border-b border-slate-200 bg-white/98 backdrop-blur-md px-5 pt-3 pb-6 space-y-3">
            <a href="#beranda" class="block py-2 text-sm font-semibold text-slate-800 hover:text-emerald-600">Beranda</a>
            <a href="#fitur" class="block py-2 text-sm font-semibold text-slate-800 hover:text-emerald-600">Fitur</a>
            <a href="#surat" class="block py-2 text-sm font-semibold text-slate-800 hover:text-emerald-600">Al-Qur'an</a>
            <a href="#tasbih" class="block py-2 text-sm font-semibold text-slate-800 hover:text-emerald-600">Tasbih</a>
            <a href="#sholat" class="block py-2 text-sm font-semibold text-slate-800 hover:text-emerald-600">Jadwal Sholat</a>
            <a href="#paket" class="block py-2 text-sm font-semibold text-slate-800 hover:text-emerald-600">Paket Pro</a>
            <div class="pt-3 border-t border-slate-100 flex flex-col space-y-2.5">
                @auth
                    <a href="/dashboard" class="w-full text-center py-2.5 px-4 bg-emerald-600 text-white text-sm font-bold rounded-xl shadow-md">Buka Dashboard</a>
                @else
                    <a href="/login" class="w-full text-center py-2.5 px-4 bg-emerald-600 text-white text-sm font-bold rounded-xl shadow-md">Login</a>
                @endauth
            </div>
        </div>
    </header>

    <!-- HERO SECTION (RESPONSIVE & TOUCH OPTIMIZED) -->
    <section id="beranda" class="relative pt-24 pb-16 sm:pt-36 sm:pb-24 lg:pt-40 lg:pb-32 overflow-hidden bg-gradient-to-b from-emerald-950 via-emerald-900 to-slate-950 text-white">
        <!-- Glow Orbs Background -->
        <div class="absolute top-10 left-1/2 -translate-x-1/2 w-[320px] sm:w-[600px] h-[350px] bg-emerald-500/15 blur-[100px] rounded-full pointer-events-none"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-center">
                
                <!-- HERO LEFT: COPYWRITING & CTAs -->
                <div class="lg:col-span-7 text-center lg:text-left space-y-5 sm:space-y-6">
                    <!-- BADGE -->
                    <div class="inline-flex items-center space-x-2 px-3 sm:px-4 py-1.5 rounded-full bg-emerald-900/80 border border-emerald-500/30 text-emerald-300 text-xs sm:text-sm font-semibold">
                        <span class="flex h-2 w-2 rounded-full bg-emerald-400"></span>
                        <span>Al-Qur'an, AI Tadabbur & Komunitas Muslim</span>
                    </div>

                    <!-- HEADLINE -->
                    <h1 class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-extrabold tracking-tight leading-[1.2] text-white">
                        Dekatkan Diri dengan <br class="hidden sm:inline">
                        <span class="gold-gradient-text">Al-Qur'an Mulia</span> Setiap Waktu
                    </h1>

                    <!-- SUBTITLE -->
                    <p class="text-sm sm:text-base lg:text-lg text-slate-300 max-w-xl mx-auto lg:mx-0 font-normal leading-relaxed">
                        Aplikasi Al-Qur'an digital terlengkap: 30 Juz tajwid warna, audio murottal per ayat, konsultasi Chat AI Islami, tanya asatidz, kuis & kelas syar'i, jadwal sholat, hingga pencarian masjid terdekat.
                    </p>

                    <!-- BUTTONS (FULL WIDTH ON MOBILE, COMPACT TOUCH TARGETS) -->
                    <div class="pt-2 flex flex-col sm:flex-row items-center justify-center lg:justify-start gap-3 sm:gap-4">
                        <a href="https://play.google.com/store/apps/details?id=com.bsndev.quranqita&hl=id" target="_blank" rel="noopener noreferrer" class="w-full sm:w-auto inline-flex items-center justify-center space-x-2.5 bg-gradient-to-r from-emerald-500 via-emerald-600 to-teal-500 hover:from-emerald-400 hover:to-teal-400 text-slate-950 font-bold px-6 sm:px-8 py-3.5 sm:py-4 rounded-xl sm:rounded-2xl shadow-lg shadow-emerald-500/25 transition touch-btn active:scale-95 text-sm sm:text-base">
                            <i class="ri-google-play-fill text-xl text-slate-950"></i>
                            <span>Unduh di Google Play</span>
                        </a>

                        <a href="#surat" class="w-full sm:w-auto inline-flex items-center justify-center space-x-2 bg-slate-900/80 hover:bg-slate-800 text-white font-semibold px-6 sm:px-7 py-3.5 sm:py-4 rounded-xl sm:rounded-2xl border border-slate-700/80 backdrop-blur-md transition touch-btn text-sm sm:text-base">
                            <i class="ri-book-open-line text-lg text-emerald-400"></i>
                            <span>Baca Al-Qur'an</span>
                        </a>
                    </div>

                    <!-- STATS BERDASARKAN DATABASE RIIL -->
                    <div class="pt-4 sm:pt-6 border-t border-slate-800/80 grid grid-cols-4 gap-2 sm:gap-4 text-center lg:text-left max-w-md mx-auto lg:mx-0">
                        <div>
                            <p class="text-xl sm:text-2xl lg:text-3xl font-extrabold text-white">{{ $stats['surah'] }}</p>
                            <p class="text-[10px] sm:text-xs text-slate-400 uppercase font-semibold">Surat</p>
                        </div>
                        <div>
                            <p class="text-xl sm:text-2xl lg:text-3xl font-extrabold text-emerald-400">{{ $stats['dzikir'] }}+</p>
                            <p class="text-[10px] sm:text-xs text-slate-400 uppercase font-semibold">Dzikir & Doa</p>
                        </div>
                        <div>
                            <p class="text-xl sm:text-2xl lg:text-3xl font-extrabold text-amber-400">{{ $stats['course'] }}</p>
                            <p class="text-[10px] sm:text-xs text-slate-400 uppercase font-semibold">Kelas Syar'i</p>
                        </div>
                        <div>
                            <p class="text-xl sm:text-2xl lg:text-3xl font-extrabold text-teal-400">{{ $stats['quiz'] }}</p>
                            <p class="text-[10px] sm:text-xs text-slate-400 uppercase font-semibold">Kuis Islami</p>
                        </div>
                    </div>
                </div>

                <!-- HERO RIGHT: AYAT OF THE DAY (MOBILE ADAPTIVE) -->
                <div class="lg:col-span-5">
                    <div class="max-w-md mx-auto">
                        <div class="glass-dark border border-emerald-500/30 rounded-2xl sm:rounded-3xl p-5 sm:p-7 shadow-2xl space-y-4 sm:space-y-5">
                            
                            <!-- Card Header -->
                            <div class="flex items-center justify-between border-b border-emerald-500/20 pb-3">
                                <div class="flex items-center space-x-2">
                                    <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                                    <span class="text-[11px] font-bold uppercase tracking-wider text-emerald-300">Ayat Hari Ini</span>
                                </div>
                                <span class="text-[10px] sm:text-xs font-semibold bg-emerald-950/80 text-emerald-300 px-2.5 py-0.5 rounded-full border border-emerald-700/50">
                                    QS. Al-Baqarah: 186
                                </span>
                            </div>

                            <!-- Arabic Text (Break-words for Mobile Screen) -->
                            <div class="text-right py-2">
                                <p class="arabic-text text-xl sm:text-2xl lg:text-3xl leading-[2.1] text-emerald-100 font-bold break-words">
                                    وَإِذَا سَأَلَكَ عِبَادِي عَنِّي فَإِنِّي قَرِيبٌ ۖ أُجِيبُ دَعْوَةَ الدَّاعِ إِذَا دَعَانِ
                                </p>
                            </div>

                            <!-- Latin & Translation -->
                            <div class="bg-slate-900/70 p-3.5 sm:p-4 rounded-xl border border-slate-800 space-y-1.5">
                                <p class="text-[11px] sm:text-xs italic text-emerald-300 font-medium leading-relaxed">
                                    "Wa idzâ sa'alaka 'ibâdî 'annî fa innî qarîb, ujîbu da'watad-dâ'i idzâ da'ân..."
                                </p>
                                <p class="text-xs sm:text-sm text-slate-200 leading-relaxed">
                                    "Dan apabila hamba-hamba-Ku bertanya kepadamu tentang Aku, maka bahwasanya Aku adalah dekat..."
                                </p>
                            </div>

                            <!-- Audio Player Bar -->
                            <div class="pt-2 border-t border-slate-800 flex items-center justify-between">
                                <div class="flex items-center space-x-3">
                                    <button id="play-ayah-btn" onclick="toggleHeroAudio()" class="w-10 h-10 sm:w-11 sm:h-11 rounded-xl bg-emerald-500 hover:bg-emerald-400 text-slate-950 flex items-center justify-center shadow-md shadow-emerald-500/30 transition touch-btn active:scale-95" aria-label="Putar Murottal">
                                        <i class="ri-play-fill text-xl" id="play-ayah-icon"></i>
                                    </button>
                                    <div>
                                        <p class="text-xs sm:text-sm font-bold text-white">Misyari Rasyid Al-'Afasi</p>
                                        <p class="text-[10px] sm:text-xs text-slate-400" id="audio-status-text">Ketuk untuk dengar audio</p>
                                    </div>
                                </div>
                                <span class="text-[10px] sm:text-xs font-mono font-bold text-emerald-400 bg-emerald-950 px-2 py-1 rounded-md border border-emerald-800">
                                    00:18
                                </span>
                            </div>

                            <audio id="hero-audio" src="https://cdn.islamic.network/quran/audio/128/ar.alafasy/193.mp3" preload="none"></audio>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- 4 NILAI UTAMA (2 COLUMNS ON MOBILE, 4 ON DESKTOP) -->
    <section class="py-10 sm:py-14 bg-white border-b border-slate-200/80">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
                
                <div class="p-3 sm:p-4 rounded-2xl bg-slate-50 border border-slate-100 flex flex-col sm:flex-row items-start sm:items-center space-y-2 sm:space-y-0 sm:space-x-3">
                    <div class="w-10 h-10 rounded-xl bg-emerald-100 text-emerald-700 flex items-center justify-center text-xl flex-shrink-0">
                        <i class="ri-book-3-line"></i>
                    </div>
                    <div>
                        <h4 class="text-xs sm:text-sm font-bold text-slate-900">Mushaf & Tafsir</h4>
                        <p class="text-[11px] text-slate-500 hidden sm:block">Standar resmi Kemenag RI</p>
                    </div>
                </div>

                <div class="p-3 sm:p-4 rounded-2xl bg-slate-50 border border-slate-100 flex flex-col sm:flex-row items-start sm:items-center space-y-2 sm:space-y-0 sm:space-x-3">
                    <div class="w-10 h-10 rounded-xl bg-amber-100 text-amber-700 flex items-center justify-center text-xl flex-shrink-0">
                        <i class="ri-robot-2-line"></i>
                    </div>
                    <div>
                        <h4 class="text-xs sm:text-sm font-bold text-slate-900">AI & Tanya Ustadz</h4>
                        <p class="text-[11px] text-slate-500 hidden sm:block">Chat AI & asatidz terpercaya</p>
                    </div>
                </div>

                <div class="p-3 sm:p-4 rounded-2xl bg-slate-50 border border-slate-100 flex flex-col sm:flex-row items-start sm:items-center space-y-2 sm:space-y-0 sm:space-x-3">
                    <div class="w-10 h-10 rounded-xl bg-teal-100 text-teal-700 flex items-center justify-center text-xl flex-shrink-0">
                        <i class="ri-map-pin-user-line"></i>
                    </div>
                    <div>
                        <h4 class="text-xs sm:text-sm font-bold text-slate-900">Sholat & Masjid</h4>
                        <p class="text-[11px] text-slate-500 hidden sm:block">Cari masjid & waktu sholat</p>
                    </div>
                </div>

                <div class="p-3 sm:p-4 rounded-2xl bg-slate-50 border border-slate-100 flex flex-col sm:flex-row items-start sm:items-center space-y-2 sm:space-y-0 sm:space-x-3">
                    <div class="w-10 h-10 rounded-xl bg-indigo-100 text-indigo-700 flex items-center justify-center text-xl flex-shrink-0">
                        <i class="ri-trophy-line"></i>
                    </div>
                    <div>
                        <h4 class="text-xs sm:text-sm font-bold text-slate-900">Kuis & Kelas</h4>
                        <p class="text-[11px] text-slate-500 hidden sm:block">Gamifikasi & leaderboard</p>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- FITUR LENGKAP SESUAI API & DATABASE -->
    <section id="fitur" class="py-16 sm:py-24 bg-slate-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="text-center max-w-2xl mx-auto mb-12 sm:mb-16">
                <span class="text-xs font-extrabold uppercase tracking-wider text-emerald-700 bg-emerald-100/70 px-3.5 py-1.5 rounded-full border border-emerald-200">
                    Fitur Ekosistem Lengkap
                </span>
                <h2 class="mt-3 text-2xl sm:text-3xl lg:text-4xl font-extrabold text-slate-900 tracking-tight">
                    Semua Kebutuhan Ibadah dalam Satu Aplikasi
                </h2>
                <p class="mt-2 text-xs sm:text-sm text-slate-600">
                    Terintegrasi langsung dengan API backend kami untuk pengalaman ibadah digital yang mulus dan kaya faedah.
                </p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6">
                
                <!-- 1. Al-Qur'an, Tafsir & Catatan -->
                <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-xs hover:border-emerald-300 transition flex flex-col justify-between space-y-4">
                    <div>
                        <div class="w-11 h-11 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-2xl mb-4">
                            <i class="ri-book-open-line"></i>
                        </div>
                        <h3 class="text-base sm:text-lg font-bold text-slate-900">Al-Qur'an, Tafsir & Highlight</h3>
                        <p class="mt-2 text-xs sm:text-sm text-slate-600 leading-relaxed">
                            30 Juz lengkap dengan teks standar Kemenag, audio murottal per ayat, catatan pribadi (note), bookmark, dan penanda highlight warna ayat.
                        </p>
                    </div>
                    <div class="pt-3 border-t border-slate-100 flex flex-wrap gap-1.5">
                        <span class="text-[10px] font-semibold text-emerald-800 bg-emerald-50 px-2 py-0.5 rounded">Tafsir Kemenag</span>
                        <span class="text-[10px] font-semibold text-emerald-800 bg-emerald-50 px-2 py-0.5 rounded">Bookmark & Note</span>
                    </div>
                </div>

                <!-- 2. Chat AI Islami & Tanya Ustadz -->
                <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-xs hover:border-emerald-300 transition flex flex-col justify-between space-y-4">
                    <div>
                        <div class="w-11 h-11 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center text-2xl mb-4">
                            <i class="ri-chat-voice-line"></i>
                        </div>
                        <h3 class="text-base sm:text-lg font-bold text-slate-900">Chat AI Islami & Tanya Ustadz</h3>
                        <p class="mt-2 text-xs sm:text-sm text-slate-600 leading-relaxed">
                            Konsultasikan persoalan fikih dan tadabbur langsung via asisten pintar Chat AI kami atau ajukan pertanyaan khusus kepada asatidz terpercaya.
                        </p>
                    </div>
                    <div class="pt-3 border-t border-slate-100 flex flex-wrap gap-1.5">
                        <span class="text-[10px] font-semibold text-amber-800 bg-amber-50 px-2 py-0.5 rounded">Chat AI Aktif</span>
                        <span class="text-[10px] font-semibold text-amber-800 bg-amber-50 px-2 py-0.5 rounded">Asatidz Berpengalaman</span>
                    </div>
                </div>

                <!-- 3. Jadwal Sholat & Masjid Terdekat -->
                <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-xs hover:border-emerald-300 transition flex flex-col justify-between space-y-4">
                    <div>
                        <div class="w-11 h-11 rounded-xl bg-teal-50 text-teal-600 flex items-center justify-center text-2xl mb-4">
                            <i class="ri-map-pin-time-line"></i>
                        </div>
                        <h3 class="text-base sm:text-lg font-bold text-slate-900">Sholat & Cari Masjid Terdekat</h3>
                        <p class="mt-2 text-xs sm:text-sm text-slate-600 leading-relaxed">
                            Jadwal waktu sholat 5 waktu akurat, pengingat adzan otomatis, kompas arah kiblat, serta peta pencari masjid terdekat di sekitar lokasi Anda.
                        </p>
                    </div>
                    <div class="pt-3 border-t border-slate-100 flex flex-wrap gap-1.5">
                        <span class="text-[10px] font-semibold text-teal-800 bg-teal-50 px-2 py-0.5 rounded">Notifikasi Adzan</span>
                        <span class="text-[10px] font-semibold text-teal-800 bg-teal-50 px-2 py-0.5 rounded">API Masjid Terdekat</span>
                    </div>
                </div>

                <!-- 4. Kelas & Kursus Edukasi Islam -->
                <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-xs hover:border-emerald-300 transition flex flex-col justify-between space-y-4">
                    <div>
                        <div class="w-11 h-11 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center text-2xl mb-4">
                            <i class="ri-graduation-cap-line"></i>
                        </div>
                        <h3 class="text-base sm:text-lg font-bold text-slate-900">22+ Kelas & Modul Belajar</h3>
                        <p class="mt-2 text-xs sm:text-sm text-slate-600 leading-relaxed">
                            Materi pembelajaran terstruktur (course & lesson) seputar tahsin tajwid, fiqih ibadah, akhlak, dan ilmu syar'i bersama modul interaktif.
                        </p>
                    </div>
                    <div class="pt-3 border-t border-slate-100 flex flex-wrap gap-1.5">
                        <span class="text-[10px] font-semibold text-indigo-800 bg-indigo-50 px-2 py-0.5 rounded">22 Modul Kelas</span>
                        <span class="text-[10px] font-semibold text-indigo-800 bg-indigo-50 px-2 py-0.5 rounded">Video & Teks</span>
                    </div>
                </div>

                <!-- 5. Kuis Islami & Leaderboard -->
                <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-xs hover:border-emerald-300 transition flex flex-col justify-between space-y-4">
                    <div>
                        <div class="w-11 h-11 rounded-xl bg-rose-50 text-rose-600 flex items-center justify-center text-2xl mb-4">
                            <i class="ri-award-line"></i>
                        </div>
                        <h3 class="text-base sm:text-lg font-bold text-slate-900">Kuis Islami & Leaderboard</h3>
                        <p class="mt-2 text-xs sm:text-sm text-slate-600 leading-relaxed">
                            Uji wawasan agama Islam Anda melalui 48+ kuis berhadiah koin, pantau peringkat leaderboard nasional dan raih skor tertinggi.
                        </p>
                    </div>
                    <div class="pt-3 border-t border-slate-100 flex flex-wrap gap-1.5">
                        <span class="text-[10px] font-semibold text-rose-800 bg-rose-50 px-2 py-0.5 rounded">48 Paket Kuis</span>
                        <span class="text-[10px] font-semibold text-rose-800 bg-rose-50 px-2 py-0.5 rounded">Leaderboard Realtime</span>
                    </div>
                </div>

                <!-- 6. Komunitas Muslim & Forum -->
                <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-xs hover:border-emerald-300 transition flex flex-col justify-between space-y-4">
                    <div>
                        <div class="w-11 h-11 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center text-2xl mb-4">
                            <i class="ri-group-line"></i>
                        </div>
                        <h3 class="text-base sm:text-lg font-bold text-slate-900">Komunitas & Forum Diskusi</h3>
                        <p class="mt-2 text-xs sm:text-sm text-slate-600 leading-relaxed">
                            Bergabung dalam grup komunitas Muslim, buat kiriman forum, bagikan kutipan faedah, saling follow antar pengguna, dan jalin silaturahmi.
                        </p>
                    </div>
                    <div class="pt-3 border-t border-slate-100 flex flex-wrap gap-1.5">
                        <span class="text-[10px] font-semibold text-purple-800 bg-purple-50 px-2 py-0.5 rounded">Forum & Komentar</span>
                        <span class="text-[10px] font-semibold text-purple-800 bg-purple-50 px-2 py-0.5 rounded">Saling Follow</span>
                    </div>
                </div>

                <!-- 7. Dzikir & 99 Asmaul Husna -->
                <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-xs hover:border-emerald-300 transition flex flex-col justify-between space-y-4">
                    <div>
                        <div class="w-11 h-11 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-2xl mb-4">
                            <i class="ri-sparkling-line"></i>
                        </div>
                        <h3 class="text-base sm:text-lg font-bold text-slate-900">Dzikir, Doa & 99 Asmaul Husna</h3>
                        <p class="mt-2 text-xs sm:text-sm text-slate-600 leading-relaxed">
                            140+ Dzikir pagi-petang, doa harian shahih, 99 Asmaul Husna dengan arti dan audio, serta tasbih digital interaktif langsung di smartphone.
                        </p>
                    </div>
                    <div class="pt-3 border-t border-slate-100 flex flex-wrap gap-1.5">
                        <span class="text-[10px] font-semibold text-emerald-800 bg-emerald-50 px-2 py-0.5 rounded">140+ Dzikir</span>
                        <span class="text-[10px] font-semibold text-emerald-800 bg-emerald-50 px-2 py-0.5 rounded">Tasbih Sentuh</span>
                    </div>
                </div>

                <!-- 8. Jurnal Ibadah & Pengingat Rutin -->
                <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-xs hover:border-emerald-300 transition flex flex-col justify-between space-y-4">
                    <div>
                        <div class="w-11 h-11 rounded-xl bg-cyan-50 text-cyan-600 flex items-center justify-center text-2xl mb-4">
                            <i class="ri-calendar-check-line"></i>
                        </div>
                        <h3 class="text-base sm:text-lg font-bold text-slate-900">Jurnal Ibadah & Reminder</h3>
                        <p class="mt-2 text-xs sm:text-sm text-slate-600 leading-relaxed">
                            Catat amal ibadah harian Anda melalui fitur Jurnal Ibadah dan atur pengingat (reminder & schedule) untuk tilawah, sholat dhuha, dan tahajud.
                        </p>
                    </div>
                    <div class="pt-3 border-t border-slate-100 flex flex-wrap gap-1.5">
                        <span class="text-[10px] font-semibold text-cyan-800 bg-cyan-50 px-2 py-0.5 rounded">Jurnal Harian</span>
                        <span class="text-[10px] font-semibold text-cyan-800 bg-cyan-50 px-2 py-0.5 rounded">Notifikasi Reminder</span>
                    </div>
                </div>

                <!-- 9. Haji Umroh & Infaq Donasi -->
                <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-xs hover:border-emerald-300 transition flex flex-col justify-between space-y-4">
                    <div>
                        <div class="w-11 h-11 rounded-xl bg-orange-50 text-orange-600 flex items-center justify-center text-2xl mb-4">
                            <i class="ri-hand-heart-line"></i>
                        </div>
                        <h3 class="text-base sm:text-lg font-bold text-slate-900">Haji Umroh & Donasi Digital</h3>
                        <p class="mt-2 text-xs sm:text-sm text-slate-600 leading-relaxed">
                            Panduan manasik haji umroh, update berita tanah suci, dan fasilitas penyaluran infaq donasi aman terintegrasi payment gateway resmi Duitku.
                        </p>
                    </div>
                    <div class="pt-3 border-t border-slate-100 flex flex-wrap gap-1.5">
                        <span class="text-[10px] font-semibold text-orange-800 bg-orange-50 px-2 py-0.5 rounded">Panduan Manasik</span>
                        <span class="text-[10px] font-semibold text-orange-800 bg-orange-50 px-2 py-0.5 rounded">Payment Gateway Duitku</span>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- SURAT POPULER (RESPONSIVE GRID) -->
    <section id="surat" class="py-16 sm:py-24 bg-white border-y border-slate-200/80">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="flex flex-col sm:flex-row sm:items-end justify-between mb-8 sm:mb-12 gap-3">
                <div>
                    <span class="text-xs font-extrabold uppercase tracking-wider text-emerald-700 bg-emerald-100/70 px-3 py-1 rounded-full border border-emerald-200">
                        114 Surat Lengkap
                    </span>
                    <h2 class="mt-2 text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">
                        Surat Populer & Pilihan
                    </h2>
                </div>
                <div>
                    <a href="https://play.google.com/store/apps/details?id=com.bsndev.quranqita&hl=id" target="_blank" rel="noopener noreferrer" class="inline-flex items-center text-xs sm:text-sm font-bold text-emerald-700 hover:text-emerald-800">
                        Buka Seluruh Surat di Google Play <i class="ri-arrow-right-line ml-1"></i>
                    </a>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6">
                @foreach ($popularSurahs as $surah)
                    @php
                        $nomor = is_array($surah) ? $surah['nomor'] : $surah->nomor;
                        $nama = is_array($surah) ? $surah['nama'] : $surah->nama;
                        $nama_latin = is_array($surah) ? $surah['nama_latin'] : $surah->nama_latin;
                        $arti = is_array($surah) ? $surah['arti'] : $surah->arti;
                        $jumlah_ayat = is_array($surah) ? $surah['jumlah_ayat'] : $surah->jumlah_ayat;
                        $tempat_turun = is_array($surah) ? $surah['tempat_turun'] : $surah->tempat_turun;
                    @endphp
                    <div class="group bg-slate-50 hover:bg-emerald-950 rounded-2xl p-5 border border-slate-200 hover:border-emerald-700 shadow-xs transition-all duration-200 flex flex-col justify-between space-y-4">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 rounded-xl bg-white group-hover:bg-emerald-900 text-emerald-700 group-hover:text-emerald-300 font-extrabold flex items-center justify-center text-sm border border-slate-200 group-hover:border-emerald-700 shadow-xs">
                                    {{ $nomor }}
                                </div>
                                <div>
                                    <h4 class="text-base font-bold text-slate-900 group-hover:text-white transition">
                                        {{ $nama_latin }}
                                    </h4>
                                    <p class="text-xs text-slate-500 group-hover:text-emerald-300 transition">
                                        {{ $arti }} • <span class="capitalize">{{ $tempat_turun }}</span>
                                    </p>
                                </div>
                            </div>
                            <div class="text-right">
                                <span class="arabic-text text-xl sm:text-2xl font-bold text-emerald-700 group-hover:text-amber-400 transition">
                                    {{ $nama }}
                                </span>
                                <p class="text-[10px] text-slate-400 group-hover:text-emerald-300 font-medium">
                                    {{ $jumlah_ayat }} Ayat
                                </p>
                            </div>
                        </div>

                        <div class="pt-3 border-t border-slate-200 group-hover:border-emerald-800 flex items-center justify-between text-xs">
                            <span class="text-slate-500 group-hover:text-emerald-300 flex items-center">
                                <i class="ri-volume-up-line mr-1 text-emerald-600 group-hover:text-emerald-400"></i> Audio Tersedia
                            </span>
                            <a href="https://play.google.com/store/apps/details?id=com.bsndev.quranqita&hl=id" target="_blank" rel="noopener noreferrer" class="font-bold text-emerald-600 group-hover:text-amber-300">
                                Baca di App <i class="ri-arrow-right-s-line"></i>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- TASBIH DIGITAL INTERAKTIF (ANDROID THUMB OPTIMIZED) -->
    <section id="tasbih" class="py-16 sm:py-24 bg-gradient-to-b from-slate-900 via-emerald-950 to-slate-950 text-white relative overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-center">
                
                <!-- Kiri: Penjelasan Dzikir -->
                <div class="lg:col-span-6 space-y-4 text-center lg:text-left">
                    <span class="text-xs font-extrabold uppercase tracking-wider text-emerald-400 bg-emerald-900/80 px-3.5 py-1.5 rounded-full border border-emerald-500/40">
                        Tasbih Digital Interaktif
                    </span>
                    <h2 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold tracking-tight text-white leading-tight">
                        Basahi Lisan dengan Dzikir, <br>
                        <span class="gold-gradient-text">Ketenangan Hati Setiap Hari</span>
                    </h2>
                    <p class="text-xs sm:text-sm text-slate-300 leading-relaxed max-w-lg mx-auto lg:mx-0">
                        Coba langsung fitur tasbih digital Quran'Qita. Ketuk tombol lingkaran di bawah menggunakan jari Anda untuk menghitung putaran dzikir secara otomatis.
                    </p>

                    <div class="pt-2 grid grid-cols-2 gap-3 text-left max-w-md mx-auto lg:mx-0">
                        <div class="bg-slate-900/60 p-3 rounded-xl border border-slate-800">
                            <i class="ri-vibration-line text-emerald-400 text-lg"></i>
                            <h5 class="text-xs font-bold text-white mt-1">Getar Responsif</h5>
                            <p class="text-[11px] text-slate-400">Efek getar haptic pada smartphone.</p>
                        </div>
                        <div class="bg-slate-900/60 p-3 rounded-xl border border-slate-800">
                            <i class="ri-cloud-line text-emerald-400 text-lg"></i>
                            <h5 class="text-xs font-bold text-white mt-1">Simpan Otomatis</h5>
                            <p class="text-[11px] text-slate-400">Tersinkron dengan akun aplikasi.</p>
                        </div>
                    </div>
                </div>

                <!-- Kanan: Tasbih Card Widget (Optimized for Android Screen) -->
                <div class="lg:col-span-6">
                    <div class="max-w-sm mx-auto glass-dark border border-emerald-500/30 rounded-3xl p-5 sm:p-7 shadow-2xl space-y-5">
                        
                        <!-- Pilihan Dzikir Header -->
                        <div class="flex items-center justify-between border-b border-emerald-500/20 pb-3">
                            <div class="flex-1 mr-3">
                                <span class="text-[10px] uppercase tracking-wider text-slate-400 font-semibold">Pilih Lafadz</span>
                                <select id="dzikir-select" onchange="changeDzikir()" class="mt-1 block w-full bg-slate-800 text-emerald-300 text-xs sm:text-sm font-bold rounded-xl border border-emerald-500/40 px-2.5 py-2 focus:outline-none">
                                    <option value="Subhanallah" data-arabic="سُبْحَانَ اللَّهِ" data-target="33">Subhanallah (33x)</option>
                                    <option value="Alhamdulillah" data-arabic="الْحَمْدُ لِلَّهِ" data-target="33">Alhamdulillah (33x)</option>
                                    <option value="Allahu Akbar" data-arabic="اللَّهُ أَكْبَرُ" data-target="33">Allahu Akbar (33x)</option>
                                    <option value="Astaghfirullah" data-arabic="أَسْتَغْفِرُ اللَّهَ" data-target="100">Astaghfirullah (100x)</option>
                                    <option value="La ilaha illallah" data-arabic="لَا إِلَهَ إِلَّا اللَّهُ" data-target="100">La ilaha illallah (100x)</option>
                                </select>
                            </div>
                            <div class="text-right">
                                <span class="text-[10px] text-slate-400 uppercase tracking-wider font-semibold">Target</span>
                                <p class="text-base sm:text-lg font-mono font-bold text-amber-400" id="target-display">33</p>
                            </div>
                        </div>

                        <!-- Lafadz Arab Display -->
                        <div class="text-center py-4 bg-slate-900/80 rounded-2xl border border-slate-800">
                            <p class="arabic-text text-2xl sm:text-3xl font-bold text-emerald-300" id="dzikir-arabic">
                                سُبْحَانَ اللَّهِ
                            </p>
                            <p class="text-[11px] text-slate-400 font-medium mt-1" id="dzikir-latin">
                                "Maha Suci Allah"
                            </p>
                        </div>

                        <!-- Big Clicker Counter Button (Touch Friendly on Android) -->
                        <div class="text-center py-1">
                            <button id="tasbih-btn" onclick="incrementTasbih()" class="touch-btn relative mx-auto w-36 h-36 sm:w-44 sm:h-44 rounded-full bg-gradient-to-tr from-emerald-700 via-emerald-600 to-teal-400 text-white shadow-2xl shadow-emerald-500/40 flex flex-col items-center justify-center transition active:scale-90 border-4 border-emerald-400/50 focus:outline-none">
                                <span class="text-[10px] font-semibold uppercase tracking-wider text-emerald-100">Sentuh</span>
                                <span class="text-4xl sm:text-5xl font-extrabold font-mono tracking-tight text-white" id="counter-display">
                                    0
                                </span>
                                <span class="text-[10px] text-emerald-200 uppercase font-semibold">Ketuk Jari</span>
                            </button>
                        </div>

                        <!-- Progress Bar & Reset -->
                        <div class="space-y-2 pt-1">
                            <div class="w-full bg-slate-800 rounded-full h-2 overflow-hidden">
                                <div id="tasbih-progress" class="bg-gradient-to-r from-emerald-400 to-amber-400 h-2 rounded-full transition-all duration-200" style="width: 0%"></div>
                            </div>
                            <div class="flex items-center justify-between text-[11px] text-slate-400 pt-1">
                                <span id="round-count">Putaran ke-1</span>
                                <button onclick="resetTasbih()" class="text-rose-400 hover:text-rose-300 font-semibold flex items-center space-x-1 touch-btn">
                                    <i class="ri-refresh-line"></i>
                                    <span>Reset</span>
                                </button>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- JADWAL SHOLAT (3 COLUMNS ON MOBILE, FITS 2 CLEAN ROWS) -->
    <section id="sholat" class="py-16 sm:py-24 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="text-center max-w-xl mx-auto mb-8 sm:mb-12 space-y-2">
                <span class="text-xs font-extrabold uppercase tracking-wider text-emerald-700 bg-emerald-100/70 px-3 py-1 rounded-full border border-emerald-200">
                    Waktu Sholat Hari Ini
                </span>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">
                    Jadwal Sholat & Adzan
                </h2>
                <div class="inline-flex items-center space-x-2 text-xs font-bold text-slate-700 bg-slate-100 px-3.5 py-1.5 rounded-full mt-2">
                    <i class="ri-map-pin-2-fill text-emerald-600"></i>
                    <span>DKI Jakarta (WIB)</span>
                </div>
            </div>

            <!-- Prayer Grid (3 columns on mobile fits 2 rows of 3 perfectly!) -->
            <div class="grid grid-cols-3 lg:grid-cols-6 gap-2.5 sm:gap-4">
                <!-- Subuh -->
                <div class="bg-slate-50 rounded-2xl p-3 sm:p-4 border border-slate-200 text-center">
                    <p class="text-[10px] sm:text-xs font-bold uppercase text-slate-500">Subuh</p>
                    <p class="text-lg sm:text-2xl font-extrabold text-slate-900 font-mono mt-1">04:36</p>
                </div>

                <!-- Terbit -->
                <div class="bg-slate-50 rounded-2xl p-3 sm:p-4 border border-slate-200 text-center">
                    <p class="text-[10px] sm:text-xs font-bold uppercase text-slate-500">Terbit</p>
                    <p class="text-lg sm:text-2xl font-extrabold text-slate-900 font-mono mt-1">05:49</p>
                </div>

                <!-- Dzuhur (Aktif) -->
                <div class="bg-gradient-to-b from-emerald-600 to-teal-700 text-white rounded-2xl p-3 sm:p-4 border-2 border-emerald-400 text-center shadow-md relative">
                    <span class="absolute -top-2.5 left-1/2 -translate-x-1/2 bg-amber-400 text-slate-950 text-[9px] font-extrabold uppercase px-2 py-0.2 rounded-full">
                        Aktif
                    </span>
                    <p class="text-[10px] sm:text-xs font-bold uppercase text-emerald-100">Dzuhur</p>
                    <p class="text-lg sm:text-2xl font-extrabold text-white font-mono mt-1">11:58</p>
                </div>

                <!-- Ashar -->
                <div class="bg-slate-50 rounded-2xl p-3 sm:p-4 border border-slate-200 text-center">
                    <p class="text-[10px] sm:text-xs font-bold uppercase text-slate-500">Ashar</p>
                    <p class="text-lg sm:text-2xl font-extrabold text-slate-900 font-mono mt-1">15:10</p>
                </div>

                <!-- Maghrib -->
                <div class="bg-slate-50 rounded-2xl p-3 sm:p-4 border border-slate-200 text-center">
                    <p class="text-[10px] sm:text-xs font-bold uppercase text-slate-500">Maghrib</p>
                    <p class="text-lg sm:text-2xl font-extrabold text-slate-900 font-mono mt-1">18:02</p>
                </div>

                <!-- Isya -->
                <div class="bg-slate-50 rounded-2xl p-3 sm:p-4 border border-slate-200 text-center">
                    <p class="text-[10px] sm:text-xs font-bold uppercase text-slate-500">Isya</p>
                    <p class="text-lg sm:text-2xl font-extrabold text-slate-900 font-mono mt-1">19:11</p>
                </div>
            </div>
        </div>
    </section>

    <!-- PAKET BERLANGGANAN & DONASI (PRICING) -->
    <section id="paket" class="py-16 sm:py-24 bg-slate-50 border-t border-slate-200/80">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="text-center max-w-2xl mx-auto mb-12 sm:mb-16 space-y-2">
                <span class="text-xs font-extrabold uppercase tracking-wider text-emerald-700 bg-emerald-100/70 px-3.5 py-1.5 rounded-full border border-emerald-200">
                    Paket Berlangganan
                </span>
                <h2 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-slate-900 tracking-tight">
                    Pilihan Paket Quran'Qita
                </h2>
                <p class="text-xs sm:text-sm text-slate-600">
                    Nikmati fitur gratis selamanya atau upgrade ke Pro untuk akses fitur bimbingan dan bebas iklan.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 sm:gap-8 items-stretch">
                @foreach ($plans as $plan)
                    @php
                        $name = is_array($plan) ? $plan['name'] : $plan->name;
                        $price = is_array($plan) ? $plan['price'] : $plan->price;
                        $duration = is_array($plan) ? ($plan['duration'] ?? 'Bulan') : ($plan->duration ?? 'Bulan');
                        $description = is_array($plan) ? ($plan['description'] ?? '') : ($plan->description ?? '');
                        $features = is_array($plan) ? ($plan['features'] ?? []) : ($plan->features ?? []);
                        $is_featured = is_array($plan) ? ($plan['is_featured'] ?? false) : false;
                    @endphp

                    <div class="relative bg-white rounded-2xl sm:rounded-3xl p-6 sm:p-8 border {{ $is_featured ? 'border-2 border-emerald-500 shadow-xl' : 'border border-slate-200 shadow-xs' }} flex flex-col justify-between">
                        @if ($is_featured)
                            <div class="absolute -top-3.5 left-1/2 -translate-x-1/2 bg-gradient-to-r from-emerald-600 to-teal-500 text-white text-[10px] font-extrabold uppercase tracking-wider px-3.5 py-1 rounded-full shadow-md">
                                Pilihan Terfavorit
                            </div>
                        @endif

                        <div>
                            <h3 class="text-lg font-bold text-slate-900">{{ $name }}</h3>
                            <p class="mt-1.5 text-xs text-slate-500">{{ $description }}</p>

                            <div class="mt-4 pb-4 border-b border-slate-100">
                                <div class="flex items-baseline">
                                    <span class="text-2xl sm:text-3xl font-extrabold tracking-tight text-slate-900">
                                        {{ $price == 0 ? 'Gratis' : 'Rp ' . number_format($price, 0, ',', '.') }}
                                    </span>
                                    @if ($price > 0)
                                        <span class="ml-1.5 text-xs font-semibold text-slate-500">/ {{ $duration }}</span>
                                    @endif
                                </div>
                            </div>

                            <ul class="mt-5 space-y-2.5 text-xs text-slate-700">
                                @if (is_array($features))
                                    @foreach ($features as $f)
                                        <li class="flex items-start">
                                            <i class="ri-checkbox-circle-fill text-emerald-600 text-sm mr-2 flex-shrink-0 mt-0.5"></i>
                                            <span>{{ $f }}</span>
                                        </li>
                                    @endforeach
                                @endif
                            </ul>
                        </div>

                        <div class="mt-6 pt-3">
                            <a href="/login" class="w-full inline-flex items-center justify-center space-x-1.5 {{ $is_featured ? 'bg-emerald-600 hover:bg-emerald-700 text-white shadow-md' : 'bg-slate-100 hover:bg-slate-200 text-slate-900' }} font-bold py-3 px-4 rounded-xl text-xs sm:text-sm transition touch-btn active:scale-95">
                                <span>{{ $is_featured ? 'Pilih Paket Pro' : 'Mulai Sekarang' }}</span>
                                <i class="ri-arrow-right-line"></i>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Infaq & Wakaf Banner (Mobile Optimized) -->
            <div class="mt-10 sm:mt-12 bg-gradient-to-r from-emerald-950 via-emerald-900 to-slate-950 rounded-2xl sm:rounded-3xl p-6 sm:p-8 text-white flex flex-col md:flex-row items-center justify-between gap-6 shadow-xl">
                <div class="text-center md:text-left space-y-2">
                    <span class="text-[10px] font-bold uppercase tracking-wider text-amber-300 bg-amber-400/20 px-2.5 py-0.5 rounded-full border border-amber-300/30">
                        Infaq Jariyah Dakwah
                    </span>
                    <h3 class="text-lg sm:text-2xl font-bold">Dukung Pengembangan Al-Qur'an Digital</h3>
                    <p class="text-xs sm:text-sm text-slate-300 leading-relaxed max-w-xl">
                        Salurkan donasi Anda untuk pemeliharaan server, perluasan dakwah Al-Qur'an, dan beasiswa santri tahfidz melalui rekening bank & payment gateway resmi Duitku.
                    </p>
                </div>
                <div class="w-full md:w-auto">
                    <a href="/login" class="w-full md:w-auto inline-flex items-center justify-center space-x-2 bg-amber-400 hover:bg-amber-300 text-slate-950 font-bold px-6 py-3 rounded-xl shadow-md transition touch-btn active:scale-95 text-xs sm:text-sm">
                        <i class="ri-heart-hand-fill text-lg text-emerald-950"></i>
                        <span>Salurkan Donasi</span>
                    </a>
                </div>
            </div>

        </div>
    </section>

    <!-- FAQ SECTION -->
    <section class="py-16 sm:py-24 bg-white">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="text-center mb-10 space-y-2">
                <span class="text-xs font-extrabold uppercase tracking-wider text-emerald-700 bg-emerald-100/70 px-3 py-1 rounded-full border border-emerald-200">
                    Bantuan & FAQ
                </span>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">
                    Frequently Asked Questions
                </h2>
            </div>

            <div class="space-y-3">
                <div class="bg-slate-50 rounded-xl border border-slate-200 p-4 sm:p-5">
                    <h4 class="text-sm sm:text-base font-bold text-slate-900 flex items-center justify-between cursor-pointer" onclick="toggleFaq(this)">
                        <span>Apakah aplikasi Quran'Qita bisa digunakan gratis?</span>
                        <i class="ri-arrow-down-s-line text-emerald-600 text-lg transition-transform"></i>
                    </h4>
                    <p class="mt-2 text-xs sm:text-sm text-slate-600 leading-relaxed">
                        Ya, membaca 30 Juz Al-Qur'an, jadwal sholat, dzikir harian, dan tasbih digital dapat diakses secara gratis.
                    </p>
                </div>

                <div class="bg-slate-50 rounded-xl border border-slate-200 p-4 sm:p-5">
                    <h4 class="text-sm sm:text-base font-bold text-slate-900 flex items-center justify-between cursor-pointer" onclick="toggleFaq(this)">
                        <span>Apa keunggulan fitur Chat AI dan Tanya Ustadz?</span>
                        <i class="ri-arrow-down-s-line text-emerald-600 text-lg transition-transform"></i>
                    </h4>
                    <p class="mt-2 text-xs sm:text-sm text-slate-600 leading-relaxed">
                        Anda dapat berkonsultasi seputar pemahaman ayat dan fikih praktis baik melalui kecerdasan buatan (Chat AI) yang responsif maupun asatidz terpercaya.
                    </p>
                </div>

                <div class="bg-slate-50 rounded-xl border border-slate-200 p-4 sm:p-5">
                    <h4 class="text-sm sm:text-base font-bold text-slate-900 flex items-center justify-between cursor-pointer" onclick="toggleFaq(this)">
                        <span>Bagaimana cara admin masuk ke panel pengelolaan?</span>
                        <i class="ri-arrow-down-s-line text-emerald-600 text-lg transition-transform"></i>
                    </h4>
                    <p class="mt-2 text-xs sm:text-sm text-slate-600 leading-relaxed">
                        Admin dapat mengklik menu <strong>Masuk Admin</strong> di pojok kanan atas atau membuka URL <code>/login</code> untuk diarahkan ke <code>/dashboard</code>.
                    </p>
                </div>
            </div>

        </div>
    </section>

    <!-- DOWNLOAD BANNER (ANDROID READY) -->
    <section id="download" class="py-16 sm:py-20 bg-gradient-to-tr from-emerald-950 via-emerald-900 to-slate-950 text-white relative overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center space-y-4 sm:space-y-5">
            <span class="text-xs font-extrabold uppercase tracking-wider text-amber-300 bg-amber-400/20 px-3 py-1 rounded-full border border-amber-300/30">
                Unduh Gratis
            </span>
            <h2 class="text-2xl sm:text-4xl font-extrabold tracking-tight max-w-2xl mx-auto">
                Mulai Hari Ini, Jadikan Al-Qur'an Sahabat Istiqomah Anda
            </h2>
            <p class="text-xs sm:text-sm text-slate-300 max-w-xl mx-auto leading-relaxed">
                Tersedia untuk perangkat smartphone Android dan browser desktop Anda.
            </p>

            <div class="pt-4 flex flex-col sm:flex-row items-center justify-center gap-3 sm:gap-4 max-w-md mx-auto">
                <a href="https://play.google.com/store/apps/details?id=com.bsndev.quranqita&hl=id" target="_blank" rel="noopener noreferrer" class="w-full sm:w-auto inline-flex items-center justify-center space-x-3 bg-slate-900 hover:bg-slate-800 text-white px-6 py-3.5 rounded-2xl border border-emerald-500/40 shadow-xl transition touch-btn active:scale-95 group">
                    <i class="ri-google-play-fill text-3xl text-emerald-400 group-hover:scale-110 transition"></i>
                    <div class="text-left">
                        <p class="text-[9px] uppercase font-bold text-slate-400 leading-tight">Unduh Sekarang di</p>
                        <p class="text-xs sm:text-sm font-bold text-white leading-tight">Google Play Store</p>
                    </div>
                </a>

                <a href="/login" class="w-full sm:w-auto inline-flex items-center justify-center space-x-2 bg-emerald-500 hover:bg-emerald-400 text-slate-950 px-6 py-3.5 rounded-2xl font-bold shadow-md transition touch-btn active:scale-95 text-xs sm:text-sm">
                    <i class="ri-computer-line text-lg"></i>
                    <span>Masuk Panel Web</span>
                </a>
            </div>
        </div>
    </section>

    <!-- FOOTER -->
    <footer class="bg-slate-950 text-slate-400 py-12 sm:py-16 border-t border-slate-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-12 gap-8">
                
                <!-- Branding -->
                <div class="md:col-span-4 space-y-3">
                    <div class="flex items-center space-x-2.5">
                        <div class="w-8 h-8 rounded-lg bg-emerald-600 flex items-center justify-center text-white overflow-hidden">
                            <img src="/image/quran'qita.jpg" alt="Logo" class="w-full h-full object-cover">
                        </div>
                        <span class="text-xl font-extrabold text-white tracking-tight">Quran'<span class="text-emerald-500">Qita</span></span>
                    </div>
                    <p class="text-xs text-slate-400 leading-relaxed">
                        Aplikasi Al-Qur'an digital modern persembahan Nawaitu Digital untuk mendampingi umat Muslim membaca, menghafal, dan mentadabburi firman Ilahi.
                    </p>
                </div>

                <!-- Navigasi -->
                <div class="md:col-span-2">
                    <h5 class="text-xs font-bold uppercase tracking-wider text-white">Menu Utama</h5>
                    <ul class="mt-3 space-y-2 text-xs">
                        <li><a href="#beranda" class="hover:text-emerald-400">Beranda</a></li>
                        <li><a href="#fitur" class="hover:text-emerald-400">Fitur</a></li>
                        <li><a href="#surat" class="hover:text-emerald-400">Al-Qur'an</a></li>
                        <li><a href="#tasbih" class="hover:text-emerald-400">Tasbih Digital</a></li>
                        <li><a href="#sholat" class="hover:text-emerald-400">Jadwal Sholat</a></li>
                        <li><a href="#paket" class="hover:text-emerald-400">Paket Pro</a></li>
                    </ul>
                </div>

                <!-- Legalitas -->
                <div class="md:col-span-3">
                    <h5 class="text-xs font-bold uppercase tracking-wider text-white">Informasi & Bantuan</h5>
                    <ul class="mt-3 space-y-2 text-xs">
                        <li><a href="/about" class="hover:text-emerald-400">Tentang Kami</a></li>
                        <li><a href="https://play.google.com/store/apps/details?id=com.bsndev.quranqita&hl=id" target="_blank" rel="noopener noreferrer" class="text-emerald-400 hover:text-emerald-300 font-semibold flex items-center"><i class="ri-google-play-fill mr-1 text-sm"></i> Download di Google Play</a></li>
                        <li><a href="/terms-user" class="hover:text-emerald-400">Ketentuan Pengguna</a></li>
                        <li><a href="/privacy" class="hover:text-emerald-400">Kebijakan Privasi</a></li>
                        <li><a href="/terms" class="hover:text-emerald-400">Syarat & Ketentuan</a></li>
                        <li><a href="/login" class="hover:text-emerald-400">Portal Admin</a></li>
                    </ul>
                </div>

                <!-- Kontak -->
                <div class="md:col-span-3">
                    <h5 class="text-xs font-bold uppercase tracking-wider text-white">Hubungi Kami</h5>
                    <div class="mt-3 text-xs text-slate-400 leading-relaxed space-y-2.5">
                        <p class="flex items-start space-x-2">
                            <i class="ri-map-pin-2-fill text-emerald-500 mt-0.5 flex-shrink-0 text-sm"></i>
                            <a href="https://maps.google.com/?q=Jl.+Hasanudin+No.81,+Krajan+I,+Kembiritan,+Kec.+Genteng,+Kabupaten+Banyuwangi,+Jawa+Timur+68465" target="_blank" rel="noopener noreferrer" class="hover:text-emerald-300 transition" title="Buka di Google Maps">
                                Jl. Hasanudin No.81, Krajan I, Kembiritan, Kec. Genteng, Kabupaten Banyuwangi, Jawa Timur 68465
                            </a>
                        </p>
                        <p class="flex items-center space-x-2 pt-0.5">
                            <i class="ri-mail-line text-emerald-500 flex-shrink-0 text-sm"></i>
                            <a href="mailto:support@quranqita.pro" class="hover:text-emerald-400 transition">support@quranqita.pro</a>
                        </p>
                        <p class="flex items-center space-x-2 pt-0.5">
                            <i class="ri-phone-line text-emerald-500 flex-shrink-0 text-sm"></i>
                            <a href="tel:08561098098" class="hover:text-emerald-400 transition">08561098098</a>
                        </p>
                    </div>
                </div>
            </div>

            <div class="mt-10 pt-6 border-t border-slate-900 text-center text-xs text-slate-500">
                <p>&copy; {{ date('Y') }} Quran'Qita. All rights reserved. Nawaitu Digital.</p>
            </div>
        </div>
    </footer>

    <!-- INTERACTIVE SCRIPTS -->
    <script>
        // Mobile Menu Toggle
        const menuBtn = document.getElementById('mobile-menu-btn');
        const mobileMenu = document.getElementById('mobile-menu');
        const menuIcon = document.getElementById('menu-icon');

        if (menuBtn && mobileMenu) {
            menuBtn.addEventListener('click', () => {
                const isOpen = !mobileMenu.classList.contains('hidden');
                if (isOpen) {
                    mobileMenu.classList.add('hidden');
                    menuIcon.classList.replace('ri-close-line', 'ri-menu-4-line');
                } else {
                    mobileMenu.classList.remove('hidden');
                    menuIcon.classList.replace('ri-menu-4-line', 'ri-close-line');
                }
            });

            // Close mobile menu when a nav link is clicked
            mobileMenu.querySelectorAll('a').forEach(link => {
                link.addEventListener('click', () => {
                    mobileMenu.classList.add('hidden');
                    menuIcon.classList.replace('ri-close-line', 'ri-menu-4-line');
                });
            });
        }

        // Hero Audio Player
        let isPlaying = false;
        const heroAudio = document.getElementById('hero-audio');
        const playAyahBtn = document.getElementById('play-ayah-btn');
        const playAyahIcon = document.getElementById('play-ayah-icon');
        const audioStatusText = document.getElementById('audio-status-text');

        function toggleHeroAudio() {
            if (!heroAudio) return;
            if (isPlaying) {
                heroAudio.pause();
                isPlaying = false;
                playAyahIcon.classList.replace('ri-pause-fill', 'ri-play-fill');
                audioStatusText.textContent = 'Ketuk untuk dengar audio';
            } else {
                heroAudio.play().then(() => {
                    isPlaying = true;
                    playAyahIcon.classList.replace('ri-play-fill', 'ri-pause-fill');
                    audioStatusText.textContent = 'Memutar murottal...';
                }).catch(e => {
                    console.log('Audio autoplay prevented:', e);
                });
            }
        }

        if (heroAudio) {
            heroAudio.addEventListener('ended', () => {
                isPlaying = false;
                playAyahIcon.classList.replace('ri-pause-fill', 'ri-play-fill');
                audioStatusText.textContent = 'Ketuk untuk putar lagi';
            });
        }

        // Interactive Tasbih Digital (Touch Optimized for Android)
        let tasbihCount = 0;
        let roundCount = 1;
        const dzikirSelect = document.getElementById('dzikir-select');
        const counterDisplay = document.getElementById('counter-display');
        const targetDisplay = document.getElementById('target-display');
        const dzikirArabic = document.getElementById('dzikir-arabic');
        const dzikirLatin = document.getElementById('dzikir-latin');
        const tasbihProgress = document.getElementById('tasbih-progress');
        const roundCountText = document.getElementById('round-count');

        const dzikirMeanings = {
            'Subhanallah': '"Maha Suci Allah"',
            'Alhamdulillah': '"Segala puji bagi Allah"',
            'Allahu Akbar': '"Allah Maha Besar"',
            'Astaghfirullah': '"Aku memohon ampun kepada Allah"',
            'La ilaha illallah': '"Tiada Tuhan selain Allah"'
        };

        function changeDzikir() {
            const selectedOpt = dzikirSelect.options[dzikirSelect.selectedIndex];
            const target = parseInt(selectedOpt.getAttribute('data-target')) || 33;
            const arabic = selectedOpt.getAttribute('data-arabic') || '';
            const value = selectedOpt.value;

            targetDisplay.textContent = target;
            dzikirArabic.textContent = arabic;
            dzikirLatin.textContent = dzikirMeanings[value] || '';
            resetTasbih();
        }

        function incrementTasbih() {
            const selectedOpt = dzikirSelect.options[dzikirSelect.selectedIndex];
            const target = parseInt(selectedOpt.getAttribute('data-target')) || 33;

            tasbihCount++;
            counterDisplay.textContent = tasbihCount;

            // Update Progress Bar
            const percent = Math.min((tasbihCount / target) * 100, 100);
            tasbihProgress.style.width = percent + '%';

            // Vibration on Android smartphone
            if (navigator.vibrate) {
                navigator.vibrate(35);
            }

            // Target reached notification
            if (tasbihCount >= target) {
                tasbihCount = 0;
                roundCount++;
                roundCountText.textContent = 'Putaran ke-' + roundCount + ' (Selesai ' + target + 'x)';
                setTimeout(() => {
                    counterDisplay.textContent = 0;
                    tasbihProgress.style.width = '0%';
                }, 250);
            }
        }

        function resetTasbih() {
            tasbihCount = 0;
            roundCount = 1;
            counterDisplay.textContent = 0;
            tasbihProgress.style.width = '0%';
            roundCountText.textContent = 'Putaran ke-1';
        }

        // Toggle FAQ Accordion
        function toggleFaq(el) {
            const content = el.nextElementSibling;
            const icon = el.querySelector('i');
            if (content.classList.contains('hidden')) {
                content.classList.remove('hidden');
                icon.style.transform = 'rotate(180deg)';
            } else {
                content.classList.add('hidden');
                icon.style.transform = 'rotate(0deg)';
            }
        }
    </script>
</body>

</html>
