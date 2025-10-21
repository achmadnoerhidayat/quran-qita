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
                    class="w-full bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700 my-3 p-5">
                    <p class="text-gray-900 dark:text-white font-bold text-1/2 mb-3">
                        Detail Bank Penampung
                    </p>
                    <div class="flex justify-between mb-2">
                        <p class="text-gray-900 dark:text-white ">
                            Nama Bank
                        </p>
                        <p class="text-gray-900 dark:text-white ">
                            {{ $data->rekeningBank->nama_bank }}
                        </p>
                    </div>
                    <div class="flex justify-between mb-2">
                        <p class="text-gray-900 dark:text-white ">
                            No Rekening
                        </p>
                        <p class="text-gray-900 dark:text-white ">
                            {{ $data->rekeningBank->nomor_rekening }}
                        </p>
                    </div>
                    <div class="flex justify-between mb-2">
                        <p class="text-gray-900 dark:text-white ">
                            Atas Nama
                        </p>
                        <p class="text-gray-900 dark:text-white ">
                            {{ $data->rekeningBank->nama_pemilik }}
                        </p>
                    </div>
                </div>
                <div
                    class="w-full bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700 my-3 p-5">
                    <p class="text-gray-900 dark:text-white font-bold text-1/2 mb-3">
                        Detail Pengguna
                    </p>
                    <div class="flex justify-between mb-2">
                        <p class="text-gray-900 dark:text-white ">
                            Nama
                        </p>
                        <p class="text-gray-900 dark:text-white ">
                            {{ $data->user->name }}
                        </p>
                    </div>
                    <div class="flex justify-between mb-2">
                        <p class="text-gray-900 dark:text-white ">
                            Email
                        </p>
                        <p class="text-gray-900 dark:text-white ">
                            {{ $data->user->email }}
                        </p>
                    </div>
                </div>
                <div
                    class="w-full bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700 my-3 p-5">
                    <p class="text-gray-900 dark:text-white font-bold text-1/2 mb-3">
                        Detail Donasi
                    </p>
                    <div class="flex justify-between mb-2">
                        <p class="text-gray-900 dark:text-white ">
                            Jumlah
                        </p>
                        <p class="text-gray-900 dark:text-white ">
                            {{ $data->jumlah_donasi }}
                        </p>
                    </div>
                    <div class="flex justify-between mb-2">
                        <p class="text-gray-900 dark:text-white ">
                            Methode Pembayaran
                        </p>
                        <p class="text-gray-900 dark:text-white ">
                            {{ $data->metode_pembayaran }}
                        </p>
                    </div>
                    <div class="flex justify-between mb-2">
                        <p class="text-gray-900 dark:text-white ">
                            Nama Rekening
                        </p>
                        <p class="text-gray-900 dark:text-white ">
                            {{ $data->nama_rekening }}
                        </p>
                    </div>
                    <div class="flex justify-between mb-2">
                        <p class="text-gray-900 dark:text-white ">
                            No Rekening
                        </p>
                        <p class="text-gray-900 dark:text-white ">
                            {{ $data->nomer_rekening }}
                        </p>
                    </div>
                    <div class="flex justify-between mb-2">
                        <p class="text-gray-900 dark:text-white ">
                            Status
                        </p>
                        <p class="text-gray-900 dark:text-white ">
                            @if ($data->status === 'Ditolak')
                                <span
                                    class="bg-red-100 text-red-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded-full dark:bg-red-900 dark:text-red-300">{{ $data->status }}</span>
                            @elseif ($data->status === 'Dikonfirmasi')
                                <span
                                    class="bg-green-100 text-green-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded-full dark:bg-green-900 dark:text-green-300">{{ $data->status }}</span>
                            @elseif ($data->status === 'Menunggu Konfirmasi')
                                <span
                                    class="bg-yellow-100 text-yellow-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded-full dark:bg-yellow-900 dark:text-yellow-300">{{ $data->status }}</span>
                            @endif
                        </p>
                    </div>
                    <div class="flex justify-between mb-2">
                        <p class="text-gray-900 dark:text-white ">
                            Keterangan
                        </p>
                        <p class="text-gray-900 dark:text-white ">
                            {{ $data->keterangan_admin }}
                        </p>
                    </div>
                    <div class="flex justify-between mb-2">
                        <p class="text-gray-900 dark:text-white ">
                            Bukti Transfer
                        </p>
                        <img class="w-full h-auto max-w-xl rounded-lg cursor-pointer show-img"
                            src="{{ asset('storage/' . $data->bukti_transfer) }}">
                    </div>
                </div>

            </main>
        </div>

        @include('partial.script')
        @if ($errors->any())
            <script>
                document.getElementById('errorModal').classList.remove('hidden');
            </script>
        @endif
        <script></script>
    </body>
@endsection
