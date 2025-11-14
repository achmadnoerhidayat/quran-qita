@extends('partial.index')

@push('head')
    <link href="https://cdn.jsdelivr.net/npm/daisyui@5" rel="stylesheet" type="text/css" />
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
@endpush

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
                <div class="flex justify-between">
                    <p class="font-bold">
                        Paket
                    </p>
                    <button type="button" onclick="showModal()"
                        class="w-1/4 border border-gray-300 text-black bg-white from-purple-600 to-blue-500 hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center mb-2 cursor-pointe">
                        Tambah Paket
                    </button>
                </div>
                <div class="grid grid-cols-2 sm:grid-cols-4 md:grid-cols-4 lg:grid-cols-4 gap-4 my-2">
                    @foreach ($data as $index => $quran)
                        <div
                            class="w-full max-w-sm bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700">

                            <div class="flex justify-between px-4 pt-4 relative">
                                @if ($quran->bonus_coin > 0)
                                    <div class="badge badge-warning" title="Bonus Koin">
                                        +{{ $quran->bonus_coin }}
                                    </div>
                                @else
                                    <div></div>
                                @endif
                                <button class="dropdown-toggle" data-index="{{ $index }}" type="button">
                                    <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" xmlns="http://www.w3.org/2000/svg"
                                        fill="currentColor" viewBox="0 0 16 3">
                                        <path
                                            d="M2 0a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3Zm6.041 0a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM14 0a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3Z" />
                                    </svg>
                                </button>

                                <!-- Dropdown -->
                                <div class="dropdown-menu hidden absolute right-0 top-full mt-2 z-50 bg-white divide-y divide-gray-100 rounded-lg shadow-sm w-44 dark:bg-gray-700"
                                    data-index="{{ $index }}">
                                    <ul class="py-2 text-sm text-gray-700 dark:text-gray-200">
                                        <li><a href="/paket/{{ $quran->id }}"
                                                class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600">Edit</a>
                                        </li>
                                        <li><a href="javascript:void(0)"
                                                class="block px-4 py-2 text-red-600 hover:bg-gray-100 dark:hover:bg-gray-600 delete"
                                                data-id="{{ $quran->id }}">Delete</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <div class="p-5">
                                <p class="mb-3 font-normal text-5xl text-center">
                                    <i class="ri-coin-line" style="color: #fbbf24 !important;"></i><span
                                        class="text-white">{{ $quran->coin_amount }}</span>
                                </p>
                                <p class="mb-3 font-normal text-2xl text-white text-center">
                                    Rp {{ number_format($quran->price, 0, ',', '.') }}
                                </p>

                            </div>

                        </div>
                    @endforeach
                </div>
                <div class="mt-2">
                    {{ $data->links() }}
                </div>


            </main>
        </div>

        <x-modal>
            <h2 class="text-lg font-bold mb-4 text-red-600">Tambah Paket</h2>
            <form class="space-y-4 md:space-y-6 mt-3" method="POST" action="{{ route('store-paket') }}">
                @csrf
                <div>
                    <label for="coin_amount" class="block mb-2 text-sm font-medium text-black-100 dark:text-black">Jumlah
                        Koin</label>
                    <input type="text" name="coin_amount" id="coin_amount"
                        class="bg-gray-50 border @error('coin_amount') border-red-500 @else border-gray-300 focus:border-primary-600 dark:border-gray-600 dark:focus:border-blue-500 @enderror text-gray-900 rounded-lg focus:ring-primary-600 block w-full p-2.5 dark:bg-white-100 dark:placeholder-gray-400 dark:text-gray dark:focus:ring-blue-500"
                        value="{{ old('coin_amount') }}" placeholder="Masukan Jumlah Koin ...." />
                    @error('coin_amount')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="price"
                        class="block mb-2 text-sm font-medium text-black-100 dark:text-black">Harga</label>
                    <input type="text" name="price" id="price"
                        class="bg-gray-50 border @error('price') border-red-500 @else border-gray-300 focus:border-primary-600 dark:border-gray-600 dark:focus:border-blue-500 @enderror text-gray-900 rounded-lg focus:ring-primary-600 block w-full p-2.5 dark:bg-white-100 dark:placeholder-gray-400 dark:text-gray dark:focus:ring-blue-500"
                        value="{{ old('price') }}" placeholder="Masukan Harga ...." />
                    @error('price')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="bonus_coin" class="block mb-2 text-sm font-medium text-black-100 dark:text-black">Bonus
                        Koin</label>
                    <input type="text" name="bonus_coin" id="bonus_coin"
                        class="bg-gray-50 border @error('bonus_coin') border-red-500 @else border-gray-300 focus:border-primary-600 dark:border-gray-600 dark:focus:border-blue-500 @enderror text-gray-900 rounded-lg focus:ring-primary-600 block w-full p-2.5 dark:bg-white-100 dark:placeholder-gray-400 dark:text-gray dark:focus:ring-blue-500"
                        value="{{ old('bonus_coin') }}" placeholder="Masukan Bonus Koin ...." />
                    @error('bonus_coin')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <button type="submit"
                    class="w-full border border-gray-300 text-black bg-white from-purple-600 to-blue-500 hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center mb-2 cursor-pointe">
                    Simpan
                </button>
            </form>
        </x-modal>

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

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $(document).on('click', '.delete', function() {
                const id = $(this).data('id');
                Swal.fire({
                    title: 'Yakin hapus Paket?',
                    text: 'Menghapus Paket akan menghapus semua data Paket yang terkait secara permanen.Anda tidak dapat membatalkan tindakan ini.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '/paket/' + id,
                            method: 'POST',
                            data: {
                                _method: 'DELETE',
                            },
                            success: function(response) {
                                Swal.fire('Berhasil!', response.message, 'success')
                                    .then(() => location.reload());
                            },
                            error: function(xhr) {
                                Swal.fire('Gagal!', response.message, 'error');
                            }
                        });
                    }
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
