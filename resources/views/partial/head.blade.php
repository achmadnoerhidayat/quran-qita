<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title> {{ isset($title) ? $title : 'Quranqita.pro' }} </title>
<script src="https://cdn.tailwindcss.com"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.6.0/remixicon.min.css" rel="stylesheet">
<script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
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
