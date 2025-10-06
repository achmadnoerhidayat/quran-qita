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

    <nav class="mt-8 space-y-2 p-4">

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
        <div class="relative group">
            <button id="dashboard-toggle" @class([
                'flex items-center w-full p-3 rounded-lg text-gray-400 font-semibold transition duration-200 hover:bg-gray-800 focus:outline-none',
                $class => $title === 'Dashboard Setting',
            ])>
                <span class="flex items-center flex-1 justify-start">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 flex-shrink-0" viewBox="0 0 24 24"
                        fill="currentColor">
                        <path
                            d="M8.68637 4.00008L11.293 1.39348C11.6835 1.00295 12.3167 1.00295 12.7072 1.39348L15.3138 4.00008H19.0001C19.5524 4.00008 20.0001 4.4478 20.0001 5.00008V8.68637L22.6067 11.293C22.9972 11.6835 22.9972 12.3167 22.6067 12.7072L20.0001 15.3138V19.0001C20.0001 19.5524 19.5524 20.0001 19.0001 20.0001H15.3138L12.7072 22.6067C12.3167 22.9972 11.6835 22.9972 11.293 22.6067L8.68637 20.0001H5.00008C4.4478 20.0001 4.00008 19.5524 4.00008 19.0001V15.3138L1.39348 12.7072C1.00295 12.3167 1.00295 11.6835 1.39348 11.293L4.00008 8.68637V5.00008C4.00008 4.4478 4.4478 4.00008 5.00008 4.00008H8.68637ZM12.0001 15.0001C13.6569 15.0001 15.0001 13.6569 15.0001 12.0001C15.0001 10.3432 13.6569 9.00008 12.0001 9.00008C10.3432 9.00008 9.00008 10.3432 9.00008 12.0001C9.00008 13.6569 10.3432 15.0001 12.0001 15.0001Z">
                        </path>
                    </svg>
                    <span class="nav-text ml-3 whitespace-nowrap">Pengaturan</span>
                </span>
                <svg id="dashboard-arrow" class="w-5 h-5 transition-transform duration-300 transform nav-arrow"
                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
                <span
                    class="absolute left-full ml-3 px-3 py-1 bg-gray-700 text-xs rounded-md whitespace-nowrap opacity-0 group-hover:opacity-100 transition-opacity duration-200 z-50 md:hidden sidebar-tooltip">Dashboard</span>
            </button>

            <div id="dashboard-submenu" class="submenu-container mt-1" style="max-height: 0px;">
                <a href="/logout"
                    class="block py-2 pl-12 text-gray-400 hover:bg-gray-800 hover:text-white transition duration-200 rounded-lg">Logout</a>
            </div>
        </div>
    </nav>
</aside>
