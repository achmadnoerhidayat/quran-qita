<meta charset="UTF-8">
<link href="/image/quran'qita.jpg" rel="shortcut icon">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title> {{ isset($title) ? $title : 'Quranqita.pro' }} </title>
<script src="https://cdn.tailwindcss.com"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.6.0/remixicon.min.css" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/style.css') }}">
<script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"
    integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@stack('head')
<script>
    tailwind.config = {
        theme: {
            extend: {
                colors: {
                    'primary-indigo': '#4f46e5',
                }
            }
        }
    }
</script>
<style>
    /* 1. CSS Kustom untuk Sidebar Minimize/Maximize */
    .sidebar-full {
        width: 256px;
    }

    /* w-64 */
    .sidebar-mini {
        width: 80px;
    }

    /* w-20 */
    .sidebar-full .nav-text {
        display: block;
    }

    .sidebar-mini .nav-text {
        display: none;
    }

    .sidebar-mini .logo-text {
        display: none;
    }

    .sidebar-mini .logo-icon {
        display: block;
    }

    .sidebar-mini .nav-arrow {
        display: none;
    }

    /* Sembunyikan panah menu accordion di mode mini */
    .sidebar-full .nav-arrow {
        display: block;
    }

    /* Konten utama menyesuaikan saat sidebar di desktop berubah ukuran */
    #main-content {
        transition: margin-left 0.3s ease-in-out;
    }

    .main-content-mini {
        margin-left: 80px !important;
    }

    /* 2. CSS Kustom untuk Animasi Menu Accordion */
    .submenu-container {
        transition: max-height 0.3s ease-in-out;
        overflow: hidden;
    }
</style>
