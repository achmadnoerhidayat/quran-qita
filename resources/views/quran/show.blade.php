@extends('partial.index')

@section('content')

    <body class="bg-gray-50 flex h-screen overflow-hidden">

        @include('partial.aside')

        <div id="main-content" class="flex-1 flex flex-col overflow-y-auto overflow-x-hidden">

            <header class="sticky top-0 bg-white shadow-md p-4 md:p-6 flex justify-between items-center z-40">

                <div class="flex items-center">
                    <button id="sidebar-toggle-mobile" class="text-gray-600 md:hidden p-2 rounded-md hover:bg-gray-100 mr-4">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>

                    <button id="toggle-sidebar-mode" class="text-gray-600 hidden md:block p-2 rounded-md hover:bg-gray-100">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>

                    <h2 class="text-xl font-bold text-gray-800 ml-4 hidden sm:block">Dashboard Utama</h2>
                </div>

                <div class="flex items-center space-x-4">
                    <button id="notification-btn"
                        class="text-gray-600 hover:text-primary-indigo relative p-2 rounded-full hover:bg-gray-100">...</button>
                    <img id="profile-btn"
                        class="h-10 w-10 rounded-full object-cover cursor-pointer border-2 border-primary-indigo"
                        src="https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?auto=format&fit=crop&q=80&w=100"
                        alt="Profil">
                </div>
            </header>

            <main class="p-4 md:p-8 flex-1">
                <div
                    class="w-full bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700">
                    <div class="flex pb-2 justify-between p-5">
                        <div class="w-[5%] my-auto">
                            <span
                                class="inline-flex items-center justify-center w-6 h-6 me-2 text-sm font-semibold text-gray-800 bg-gray-100 rounded-full dark:bg-gray-700 dark:text-gray-300">
                                <p class="text-gray-900 dark:text-white">
                                    {{ $data->nomor }}
                                </p>
                                <span class="sr-only">Icon description</span>
                            </span>
                        </div>
                        <div class="flex w-[90%] justify-between">
                            <div class="">
                                <p class="text-gray-900 dark:text-white">
                                    {{ $data->nama_latin }}
                                </p>
                                <p class="text-gray-900 dark:text-white">
                                    {{ $data->arti }}
                                </p>
                            </div>
                            <div class="text-right">
                                <p class="text-gray-900 dark:text-white surah-arab">
                                    {{ $data->nama }}
                                </p>
                                <p class="text-gray-900 dark:text-white">
                                    {{ $data->jumlah_ayat }} Ayat
                                </p>
                            </div>
                        </div>

                    </div>
                    <div class="px-3">
                        <span class="text-gray-900 dark:text-white">
                            {!! $data->deskripsi !!}
                        </span>
                    </div>
                </div>
                <p class="mt-2 text-2xl font-bold text-gray-900 dark:text-black">
                    Ayat-ayat
                </p>
                @foreach ($data->ayat as $ayat)
                    <div
                        class="w-full bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700 my-3">
                        <div class="flex pb-2 justify-between p-5">
                            <div class="w-[5%] my-auto">
                                <span
                                    class="inline-flex items-center justify-center w-6 h-6 me-2 text-sm font-semibold text-gray-800 bg-gray-100 rounded-full dark:bg-gray-700 dark:text-gray-300">
                                    <p class="text-gray-900 dark:text-white">
                                        {{ $ayat->nomor_ayat }}
                                    </p>
                                    <span class="sr-only">Icon description</span>
                                </span>
                            </div>
                            <div class="flex w-[90%] justify-between">

                            </div>

                        </div>
                        <div class="flex justify-end text-right p-5">
                            <p class="text-gray-900 dark:text-white ayat-arab">
                                {{ $ayat->teks_arab }}
                            </p>
                        </div>
                        <p class="text-gray-900 dark:text-white p-5">
                            {{ $ayat->teks_indo }}
                        </p>
                    </div>
                @endforeach
            </main>
        </div>

        @include('partial.script')
        @if ($errors->any())
            <script>
                document.getElementById('errorModal').classList.remove('hidden');
            </script>
        @endif

        <script>
            document.addEventListener("DOMContentLoaded", function() {
                const toggles = document.querySelectorAll('.dropdown-toggle');

                toggles.forEach(button => {
                    button.addEventListener('click', function(e) {
                        e.stopPropagation();
                        const index = button.getAttribute('data-index');
                        const dropdown = document.querySelector(
                            `.dropdown-menu[data-index="${index}"]`);

                        // Tutup semua dropdown lainnya
                        document.querySelectorAll('.dropdown-menu').forEach(menu => {
                            if (menu !== dropdown) menu.classList.add('hidden');
                        });

                        // Toggle dropdown ini
                        dropdown.classList.toggle('hidden');
                    });
                });

                // Klik di luar: tutup semua
                document.addEventListener('click', function() {
                    document.querySelectorAll('.dropdown-menu').forEach(menu => {
                        menu.classList.add('hidden');
                    });
                });
            });

            function showModal() {
                document.getElementById('errorModal').classList.remove('hidden');
            }

            function closeErrorModal() {
                document.getElementById('errorModal').classList.add('hidden');
            }
        </script>
    </body>
@endsection
