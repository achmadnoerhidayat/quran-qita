<script>
    const sidebar = document.getElementById('sidebar');
    const mainContent = document.getElementById('main-content');
    const isMobile = () => window.innerWidth < 768;

    // === FUNGSI ACCORDION SIDEBAR (Menu Naik/Turun) ===
    const dashboardToggle = document.getElementById('dashboard-toggle');
    const dashboardSubmenu = document.getElementById('dashboard-submenu');
    const dashboardArrow = document.getElementById('dashboard-arrow');

    dashboardToggle.addEventListener('click', () => {
        // Pastikan accordion hanya berfungsi di mode FULL (non-mini)
        if (sidebar.classList.contains('sidebar-mini')) {
            // Di mode mini, klik pada menu utama mungkin memicu navigasi, bukan accordion.
            return;
        }

        if (dashboardSubmenu.style.maxHeight && dashboardSubmenu.style.maxHeight !== '0px') {
            // Tutup menu
            dashboardSubmenu.style.maxHeight = '0px';
            dashboardArrow.classList.remove('rotate-180');
        } else {
            // Buka menu
            dashboardSubmenu.style.maxHeight = dashboardSubmenu.scrollHeight + 'px';
            dashboardArrow.classList.add('rotate-180');
        }
    });

    const toggles = document.querySelectorAll('.menu-toggle');

    toggles.forEach(toggle => {
        toggle.addEventListener('click', () => {
            const targetId = toggle.getAttribute('data-target');
            const submenu = document.getElementById(targetId);
            const arrow = toggle.querySelector('.menu-arrow');

            const isOpen = submenu.style.maxHeight && submenu.style.maxHeight !== '0px';

            if (isOpen) {
                submenu.style.maxHeight = '0px';
                arrow.classList.remove('rotate-180');
            } else {
                submenu.style.maxHeight = submenu.scrollHeight + 'px';
                arrow.classList.add('rotate-180');
            }
        });
    });

    // Atur agar menu tertutup saat dimuat (initial state)
    {{--  dashboardSubmenu.style.maxHeight = '0px';  --}}

    // === FUNGSI MINIMIZE/MAXIMIZE SIDEBAR (Desktop) ===
    const toggleSidebarModeBtn = document.getElementById('toggle-sidebar-mode');

    const updateSidebarState = (isMini) => {
        const logoText = document.querySelector('.logo-text');
        const logoIcon = document.querySelector('.logo-icon');
        const navTexts = document.querySelectorAll('.nav-text');
        const tooltips = document.querySelectorAll('.sidebar-tooltip');

        if (isMini) {
            // Mode MINI
            sidebar.classList.remove('sidebar-full');
            sidebar.classList.add('sidebar-mini');
            mainContent.classList.add('main-content-mini');
            logoText.classList.add('hidden');
            logoIcon.classList.remove('hidden');
            navTexts.forEach(el => el.classList.add('hidden'));
            tooltips.forEach(el => el.classList.remove('md:hidden')); // Tampilkan tooltip
            // dashboardSubmenu.style.maxHeight = '0px'; // Tutup semua accordion
        } else {
            // Mode FULL
            sidebar.classList.remove('sidebar-mini');
            sidebar.classList.add('sidebar-full');
            mainContent.classList.remove('main-content-mini');
            logoText.classList.remove('hidden');
            logoIcon.classList.add('hidden');
            navTexts.forEach(el => el.classList.remove('hidden'));
            tooltips.forEach(el => el.classList.add('md:hidden')); // Sembunyikan tooltip
        }
    };

    toggleSidebarModeBtn.addEventListener('click', () => {
        if (isMobile()) {
            // Di Mobile: Tombol ini TIDAK berfungsi, hanya tombol mobile yang berfungsi
            return;
        }
        // Toggle state: Jika sedang full, jadikan mini. Jika mini, jadikan full.
        const isMini = sidebar.classList.contains('sidebar-full');
        updateSidebarState(isMini);
    });


    // === FUNGSI TOGGLE SIDEBAR MOBILE (Untuk perangkat kecil) ===
    const mobileToggleBtn = document.getElementById('sidebar-toggle-mobile');
    mobileToggleBtn.addEventListener('click', () => {
        sidebar.classList.toggle('-translate-x-full');
        // Logic overlay untuk mobile bisa ditambahkan di sini
    });

    // === INITIAL/RESIZE HANDLER ===
    const handleResize = () => {
        if (!isMobile()) {
            // Saat di desktop, pastikan sidebar selalu dalam mode FULL secara default
            updateSidebarState(false);
            sidebar.classList.remove('-translate-x-full'); // Pastikan terlihat
        } else {
            // Saat di mobile, pastikan sidebar tersembunyi
            sidebar.classList.add('-translate-x-full');
        }
    };

    window.addEventListener('resize', handleResize);
    window.addEventListener('load', handleResize); // Jalankan saat pertama kali dimuat

    // === FUNGSI AKSI NOTIFIKASI & PROFIL (Revisi 2 & 3) ===
    const notificationBtn = document.getElementById('notification-btn');
    const profileBtn = document.getElementById('profile-btn');
    notificationBtn.addEventListener('click', () => {
        alert('Notifikasi diklik!');
    });
    profileBtn.addEventListener('click', () => {
        alert('Profil diklik!');
    });
</script>
