<aside id="sidebar"
    class="fixed inset-y-0 left-0 z-50 transform -translate-x-full
                  md:relative md:translate-x-0 bg-gray-900 text-white
                  shadow-2xl transition-all duration-300 ease-in-out sidebar-full">

    <div class="p-6 border-b border-gray-700 flex justify-center md:justify-start">
        <h1 class="text-[20px] font-extrabold text-primary-indigo logo-text">
            QuranQita Admin</h1>
        <svg class="w-8 h-8 text-primary-indigo logo-icon hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
        </svg>
    </div>

    <nav class="mt-8 space-y-2 p-4 h-[80vh] overflow-y-scroll [scrollbar-width:none] [-ms-overflow-style:none]">

        <a href="/" @class([
            'flex items-center p-3 rounded-lg hover:bg-gray-800 hover:text-white font-medium transition duration-200 group relative',
            $class => $title === 'Dashboard Quranqita',
        ])>
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 flex-shrink-0" viewBox="0 0 24 24"
                fill="currentColor">
                <path
                    d="M3 12C3 12.5523 3.44772 13 4 13H10C10.5523 13 11 12.5523 11 12V4C11 3.44772 10.5523 3 10 3H4C3.44772 3 3 3.44772 3 4V12ZM3 20C3 20.5523 3.44772 21 4 21H10C10.5523 21 11 20.5523 11 20V16C11 15.4477 10.5523 15 10 15H4C3.44772 15 3 15.4477 3 16V20ZM13 20C13 20.5523 13.4477 21 14 21H20C20.5523 21 21 20.5523 21 20V12C21 11.4477 20.5523 11 20 11H14C13.4477 11 13 11.4477 13 12V20ZM14 3C13.4477 3 13 3.44772 13 4V8C13 8.55228 13.4477 9 14 9H20C20.5523 9 21 8.55228 21 8V4C21 3.44772 20.5523 3 20 3H14Z">
                </path>
            </svg>
            <span class="nav-text ml-3 whitespace-nowrap">Overview</span>
            <span
                class="absolute left-full ml-3 px-3 py-1 bg-gray-700 text-xs rounded-md whitespace-nowrap opacity-0 group-hover:opacity-100 transition-opacity duration-200 z-50 md:hidden sidebar-tooltip">Dashboard</span>
        </a>

        <a href="/quran" @class([
            'flex items-center p-3 rounded-lg hover:bg-gray-800 hover:text-white font-medium transition duration-200 group relative',
            $class => $title === 'Dashboard quran',
        ])>
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 flex-shrink-0" viewBox="0 0 24 24"
                fill="currentColor">
                <path
                    d="M21 21H13V6C13 4.34315 14.3431 3 16 3H21C21.5523 3 22 3.44772 22 4V20C22 20.5523 21.5523 21 21 21ZM11 21H3C2.44772 21 2 20.5523 2 20V4C2 3.44772 2.44772 3 3 3H8C9.65685 3 11 4.34315 11 6V21ZM11 21H13V23H11V21Z">
                </path>
            </svg>
            <span class="nav-text ml-3 whitespace-nowrap">Quran</span>
            <span
                class="absolute left-full ml-3 px-3 py-1 bg-gray-700 text-xs rounded-md whitespace-nowrap opacity-0 group-hover:opacity-100 transition-opacity duration-200 z-50 md:hidden sidebar-tooltip">Dashboard</span>
        </a>

        <div class="relative group menu-group">
            <button @class([
                'menu-toggle flex items-center w-full p-3 rounded-lg text-white font-semibold transition duration-200 hover:bg-gray-800 focus:outline-none',
                $class => $title === 'Dashboard Learning',
            ]) data-target="submenu-learning">
                <span class="flex items-center flex-1 justify-start">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 flex-shrink-0" viewBox="0 0 24 24"
                        fill="currentColor">
                        <path
                            d="M20 22H6.5C4.567 22 3 20.433 3 18.5V5C3 3.34315 4.34315 2 6 2H20C20.5523 2 21 2.44772 21 3V21C21 21.5523 20.5523 22 20 22ZM19 20V17H6.5C5.67157 17 5 17.6716 5 18.5C5 19.3284 5.67157 20 6.5 20H19Z">
                        </path>
                    </svg>
                    <span class="nav-text ml-3 whitespace-nowrap">Belajar</span>
                </span>
                <svg id="dashboard-arrow"
                    class="menu-arrow w-5 h-5 transition-transform duration-300 transform nav-arrow" fill="none"
                    stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
                <span
                    class="absolute left-full ml-3 px-3 py-1 bg-gray-700 text-xs rounded-md whitespace-nowrap opacity-0 group-hover:opacity-100 transition-opacity duration-200 z-50 md:hidden sidebar-tooltip">Belajar</span>
            </button>

            <div id="submenu-learning" class="submenu-container mt-1" style="max-height: 0px;">
                <a href="/course"
                    class="block py-2 pl-12 text-gray-400 hover:bg-gray-800 hover:text-white transition duration-200 rounded-lg">Kursus</a>
                <a href="/lesson"
                    class="block py-2 pl-12 text-gray-400 hover:bg-gray-800 hover:text-white transition duration-200 rounded-lg">Materi</a>
                <a href="/kuis"
                    class="block py-2 pl-12 text-gray-400 hover:bg-gray-800 hover:text-white transition duration-200 rounded-lg">Kuis</a>
            </div>
        </div>

        <a href="/haji-umroh" @class([
            'flex items-center p-3 rounded-lg hover:bg-gray-800 hover:text-white font-medium transition duration-200 group relative',
            $class => $title === 'Dashboard Haji Umroh',
        ])>
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="w-6 h-6 flex-shrink-0"
                fill="currentColor">
                <path
                    d="M3 3C2.44772 3 2 3.44772 2 4V20C2 20.5523 2.44772 21 3 21H21C21.5523 21 22 20.5523 22 20V4C22 3.44772 21.5523 3 21 3H3ZM6 7H12V13H6V7ZM8 9V11H10V9H8ZM18 9H14V7H18V9ZM14 13V11H18V13H14ZM6 17V15L18 15V17L6 17Z">
                </path>
            </svg>
            <span class="nav-text ml-3 whitespace-nowrap">Berita Haji Umroh</span>
            <span
                class="absolute left-full ml-3 px-3 py-1 bg-gray-700 text-xs rounded-md whitespace-nowrap opacity-0 group-hover:opacity-100 transition-opacity duration-200 z-50 md:hidden sidebar-tooltip">Haji
                Umroh</span>
        </a>

        <a href="/plan" @class([
            'flex items-center p-3 rounded-lg hover:bg-gray-800 hover:text-white font-medium transition duration-200 group relative',
            $class => $title === 'Dashboard Plan',
        ])>
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="w-6 h-6 flex-shrink-0"
                fill="currentColor">
                <path
                    d="M7 5V2C7 1.44772 7.44772 1 8 1H16C16.5523 1 17 1.44772 17 2V5H21C21.5523 5 22 5.44772 22 6V20C22 20.5523 21.5523 21 21 21H3C2.44772 21 2 20.5523 2 20V6C2 5.44772 2.44772 5 3 5H7ZM4 15V19H20V15H4ZM11 11V13H13V11H11ZM9 3V5H15V3H9Z">
                </path>
            </svg>
            <span class="nav-text ml-3 whitespace-nowrap">Plan</span>
            <span
                class="absolute left-full ml-3 px-3 py-1 bg-gray-700 text-xs rounded-md whitespace-nowrap opacity-0 group-hover:opacity-100 transition-opacity duration-200 z-50 md:hidden sidebar-tooltip">Haji
                Plan</span>
        </a>

        <a href="/langganan" @class([
            'flex items-center p-3 rounded-lg hover:bg-gray-800 hover:text-white font-medium transition duration-200 group relative',
            $class => $title === 'Dashboard Langganan',
        ])>
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 flex-shrink-0" viewBox="0 0 24 24"
                fill="currentColor">
                <path
                    d="M22.0049 9.99979V19.9998C22.0049 20.5521 21.5572 20.9998 21.0049 20.9998H3.00488C2.4526 20.9998 2.00488 20.5521 2.00488 19.9998V9.99979H22.0049ZM22.0049 7.99979H2.00488V3.99979C2.00488 3.4475 2.4526 2.99979 3.00488 2.99979H21.0049C21.5572 2.99979 22.0049 3.4475 22.0049 3.99979V7.99979ZM15.0049 15.9998V17.9998H19.0049V15.9998H15.0049Z">
                </path>
            </svg>
            <span class="nav-text ml-3 whitespace-nowrap">Langganan</span>
            <span
                class="absolute left-full ml-3 px-3 py-1 bg-gray-700 text-xs rounded-md whitespace-nowrap opacity-0 group-hover:opacity-100 transition-opacity duration-200 z-50 md:hidden sidebar-tooltip">Haji
                Langganan</span>
        </a>

        <a href="/donasi" @class([
            'flex items-center p-3 rounded-lg hover:bg-gray-800 hover:text-white font-medium transition duration-200 group relative',
            $class => $title === 'Dashboard Donasi',
        ])>
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 flex-shrink-0" viewBox="0 0 24 24"
                fill="currentColor">
                <path
                    d="M9.3349 11.5023L11.5049 11.5028C13.9902 11.5028 16.0049 13.5175 16.0049 16.0028H9.00388L9.00488 17.0028L17.0049 17.002V16.0028C17.0049 14.9204 16.6867 13.8997 16.1188 13.002L19.0049 13.0028C20.9972 13.0028 22.7173 14.1681 23.521 15.8542C21.1562 18.9748 17.3268 21.0028 13.0049 21.0028C10.2436 21.0028 7.90445 20.4122 6.00456 19.378L6.00592 10.0738C7.25147 10.2522 8.39122 10.7585 9.3349 11.5023ZM5.00488 19.0028C5.00488 19.5551 4.55717 20.0028 4.00488 20.0028H2.00488C1.4526 20.0028 1.00488 19.5551 1.00488 19.0028V10.0028C1.00488 9.45052 1.4526 9.00281 2.00488 9.00281H4.00488C4.55717 9.00281 5.00488 9.45052 5.00488 10.0028V19.0028ZM18.0049 5.00281C19.6617 5.00281 21.0049 6.34595 21.0049 8.00281C21.0049 9.65966 19.6617 11.0028 18.0049 11.0028C16.348 11.0028 15.0049 9.65966 15.0049 8.00281C15.0049 6.34595 16.348 5.00281 18.0049 5.00281ZM11.0049 2.00281C12.6617 2.00281 14.0049 3.34595 14.0049 5.00281C14.0049 6.65966 12.6617 8.00281 11.0049 8.00281C9.34803 8.00281 8.00488 6.65966 8.00488 5.00281C8.00488 3.34595 9.34803 2.00281 11.0049 2.00281Z">
                </path>
            </svg>
            <span class="nav-text ml-3 whitespace-nowrap">Donasi</span>
            <span
                class="absolute left-full ml-3 px-3 py-1 bg-gray-700 text-xs rounded-md whitespace-nowrap opacity-0 group-hover:opacity-100 transition-opacity duration-200 z-50 md:hidden sidebar-tooltip">Haji
                Donasi</span>
        </a>

        <a href="/ask-uztadz" @class([
            'flex items-center p-3 rounded-lg hover:bg-gray-800 hover:text-white font-medium transition duration-200 group relative',
            $class => $title === 'Dashboard Tanya Ustadz',
        ])>
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 flex-shrink-0" viewBox="0 0 24 24"
                fill="currentColor">
                <path
                    d="M9.3349 11.5023L11.5049 11.5028C13.9902 11.5028 16.0049 13.5175 16.0049 16.0028H9.00388L9.00488 17.0028L17.0049 17.002V16.0028C17.0049 14.9204 16.6867 13.8997 16.1188 13.002L19.0049 13.0028C20.9972 13.0028 22.7173 14.1681 23.521 15.8542C21.1562 18.9748 17.3268 21.0028 13.0049 21.0028C10.2436 21.0028 7.90445 20.4122 6.00456 19.378L6.00592 10.0738C7.25147 10.2522 8.39122 10.7585 9.3349 11.5023ZM5.00488 19.0028C5.00488 19.5551 4.55717 20.0028 4.00488 20.0028H2.00488C1.4526 20.0028 1.00488 19.5551 1.00488 19.0028V10.0028C1.00488 9.45052 1.4526 9.00281 2.00488 9.00281H4.00488C4.55717 9.00281 5.00488 9.45052 5.00488 10.0028V19.0028ZM18.0049 5.00281C19.6617 5.00281 21.0049 6.34595 21.0049 8.00281C21.0049 9.65966 19.6617 11.0028 18.0049 11.0028C16.348 11.0028 15.0049 9.65966 15.0049 8.00281C15.0049 6.34595 16.348 5.00281 18.0049 5.00281ZM11.0049 2.00281C12.6617 2.00281 14.0049 3.34595 14.0049 5.00281C14.0049 6.65966 12.6617 8.00281 11.0049 8.00281C9.34803 8.00281 8.00488 6.65966 8.00488 5.00281C8.00488 3.34595 9.34803 2.00281 11.0049 2.00281Z">
                </path>
            </svg>
            <span class="nav-text ml-3 whitespace-nowrap">Tanya Ustadz</span>
            <span
                class="absolute left-full ml-3 px-3 py-1 bg-gray-700 text-xs rounded-md whitespace-nowrap opacity-0 group-hover:opacity-100 transition-opacity duration-200 z-50 md:hidden sidebar-tooltip">Haji
                Tanya Ustadz</span>
        </a>

        <a href="/dzikir" @class([
            'flex items-center p-3 rounded-lg hover:bg-gray-800 hover:text-white font-medium transition duration-200 group relative',
            $class => $title === 'Dashboard Dzikir',
        ])>
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 flex-shrink-0" viewBox="0 0 24 24"
                fill="currentColor">
                <path
                    d="M12 19C12.8284 19 13.5 19.6716 13.5 20.5C13.5 21.3284 12.8284 22 12 22C11.1716 22 10.5 21.3284 10.5 20.5C10.5 19.6716 11.1716 19 12 19ZM12 2C15.3137 2 18 4.68629 18 8C18 10.1646 17.2474 11.2907 15.3259 12.9231C13.3986 14.5604 13 15.2969 13 17H11C11 14.526 11.787 13.3052 14.031 11.3989C15.5479 10.1102 16 9.43374 16 8C16 5.79086 14.2091 4 12 4C9.79086 4 8 5.79086 8 8V9H6V8C6 4.68629 8.68629 2 12 2Z">
                </path>
            </svg>
            <span class="nav-text ml-3 whitespace-nowrap">Dzikir</span>
            <span
                class="absolute left-full ml-3 px-3 py-1 bg-gray-700 text-xs rounded-md whitespace-nowrap opacity-0 group-hover:opacity-100 transition-opacity duration-200 z-50 md:hidden sidebar-tooltip">Haji
                Dzikir</span>
        </a>

        <a href="/user" @class([
            'flex items-center p-3 rounded-lg hover:bg-gray-800 hover:text-white font-medium transition duration-200 group relative',
            $class => $title === 'Dashboard Pengguna',
        ])>
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 flex-shrink-0" viewBox="0 0 24 24"
                fill="currentColor">
                <path
                    d="M2 22C2 17.5817 5.58172 14 10 14C14.4183 14 18 17.5817 18 22H2ZM10 13C6.685 13 4 10.315 4 7C4 3.685 6.685 1 10 1C13.315 1 16 3.685 16 7C16 10.315 13.315 13 10 13ZM17.3628 15.2332C20.4482 16.0217 22.7679 18.7235 22.9836 22H20C20 19.3902 19.0002 17.0139 17.3628 15.2332ZM15.3401 12.9569C16.9728 11.4922 18 9.36607 18 7C18 5.58266 17.6314 4.25141 16.9849 3.09687C19.2753 3.55397 21 5.57465 21 8C21 10.7625 18.7625 13 16 13C15.7763 13 15.556 12.9853 15.3401 12.9569Z">
                </path>
            </svg>
            <span class="nav-text ml-3 whitespace-nowrap">Pengguna</span>
            <span
                class="absolute left-full ml-3 px-3 py-1 bg-gray-700 text-xs rounded-md whitespace-nowrap opacity-0 group-hover:opacity-100 transition-opacity duration-200 z-50 md:hidden sidebar-tooltip">Pengguna</span>
        </a>
        <div class="relative group menu-group">
            <button id="dashboard-toggle" @class([
                'menu-toggle flex items-center w-full p-3 rounded-lg text-gray-400 font-semibold transition duration-200 hover:bg-gray-800 focus:outline-none',
                $class => $title === 'Dashboard Setting',
            ]) data-target="submenu-setting">
                <span class="flex items-center flex-1 justify-start">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 flex-shrink-0" viewBox="0 0 24 24"
                        fill="currentColor">
                        <path
                            d="M8.68637 4.00008L11.293 1.39348C11.6835 1.00295 12.3167 1.00295 12.7072 1.39348L15.3138 4.00008H19.0001C19.5524 4.00008 20.0001 4.4478 20.0001 5.00008V8.68637L22.6067 11.293C22.9972 11.6835 22.9972 12.3167 22.6067 12.7072L20.0001 15.3138V19.0001C20.0001 19.5524 19.5524 20.0001 19.0001 20.0001H15.3138L12.7072 22.6067C12.3167 22.9972 11.6835 22.9972 11.293 22.6067L8.68637 20.0001H5.00008C4.4478 20.0001 4.00008 19.5524 4.00008 19.0001V15.3138L1.39348 12.7072C1.00295 12.3167 1.00295 11.6835 1.39348 11.293L4.00008 8.68637V5.00008C4.00008 4.4478 4.4478 4.00008 5.00008 4.00008H8.68637ZM12.0001 15.0001C13.6569 15.0001 15.0001 13.6569 15.0001 12.0001C15.0001 10.3432 13.6569 9.00008 12.0001 9.00008C10.3432 9.00008 9.00008 10.3432 9.00008 12.0001C9.00008 13.6569 10.3432 15.0001 12.0001 15.0001Z">
                        </path>
                    </svg>
                    <span class="nav-text ml-3 whitespace-nowrap">Pengaturan</span>
                </span>
                <svg class="menu-arrow w-5 h-5 transition-transform duration-300 transform nav-arrow" fill="none"
                    stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
                <span
                    class="absolute left-full ml-3 px-3 py-1 bg-gray-700 text-xs rounded-md whitespace-nowrap opacity-0 group-hover:opacity-100 transition-opacity duration-200 z-50 md:hidden sidebar-tooltip">Dashboard</span>
            </button>

            <div id="submenu-setting" class="submenu-container mt-1" style="max-height: 0px;">
                <a href="/logout"
                    class="block py-2 pl-12 text-gray-400 hover:bg-gray-800 hover:text-white transition duration-200 rounded-lg">Logout</a>
            </div>
        </div>
    </nav>
</aside>
