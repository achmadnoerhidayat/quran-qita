@extends('partial.index')

@push('head')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" />
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
    <style>
        /* Perbaiki posisi tombol */
        .owl-nav {
            position: absolute;
            top: 50%;
            width: 100%;
            display: flex;
            justify-content: space-between;
            /* kiri-kanan */
            transform: translateY(-50%);
            pointer-events: none;
            /* biar tombol bisa klik */
        }

        .owl-nav button {
            pointer-events: auto;
            /* aktifkan klik tombol */
        }
    </style>
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
                        Content
                    </p>
                </div>
                <div class="grid grid-cols-2 sm:grid-cols-4 md:grid-cols-4 lg:grid-cols-4 gap-4 my-2">
                    @foreach ($data as $index => $quran)
                        <div
                            class="w-full max-w-sm bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700">

                            <div class="flex justify-between px-4 pt-4 relative">
                                @if ($quran->status === 'pending')
                                    <span
                                        class="inline-flex items-center justify-center w-6 h-6 me-2 text-sm font-semibold text-white-800 bg-yellow-100 rounded-full dark:bg-yellow-700 dark:text-white-300"
                                        title="{{ $quran->status }}">
                                        <svg class="w-2.5 h-2.5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                            fill="currentColor">
                                            <path
                                                d="M12 6C12.8284 6 13.5 5.32843 13.5 4.5C13.5 3.67157 12.8284 3 12 3C11.1716 3 10.5 3.67157 10.5 4.5C10.5 5.32843 11.1716 6 12 6ZM9 10H11V18H9V20H15V18H13V8H9V10Z">
                                            </path>
                                        </svg>
                                        <span class="sr-only">Icon description</span>
                                    </span>
                                @elseif ($quran->status === 'approved')
                                    <span
                                        class="inline-flex items-center justify-center w-6 h-6 me-2 text-sm font-semibold text-gray-800 bg-green-100 rounded-full dark:bg-green-700 dark:text-gray-300"
                                        title="{{ $quran->status }}">

                                        <svg class="w-2.5 h-2.5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                            fill="currentColor">
                                            <path
                                                d="M9.9997 15.1709L19.1921 5.97852L20.6063 7.39273L9.9997 17.9993L3.63574 11.6354L5.04996 10.2212L9.9997 15.1709Z">
                                            </path>
                                        </svg>
                                        <span class="sr-only">Icon description</span>
                                    </span>
                                @else
                                    <span
                                        class="inline-flex items-center justify-center w-6 h-6 me-2 text-sm font-semibold text-gray-800 bg-red-100 rounded-full dark:bg-red-700 dark:text-gray-300"
                                        title="{{ $quran->status }}">

                                        <svg class="w-2.5 h-2.5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                            fill="currentColor">
                                            <path
                                                d="M11.9997 10.5865L16.9495 5.63672L18.3637 7.05093L13.4139 12.0007L18.3637 16.9504L16.9495 18.3646L11.9997 13.4149L7.04996 18.3646L5.63574 16.9504L10.5855 12.0007L5.63574 7.05093L7.04996 5.63672L11.9997 10.5865Z">
                                            </path>
                                        </svg>
                                        <span class="sr-only">Icon description</span>
                                    </span>
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
                                        @if ($quran->status !== 'approved')
                                            <li><a href="javascript:void(0)" data-id="{{ $quran->id }}"
                                                    data-status="approved"
                                                    class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 update">Approved</a>
                                            </li>
                                            <li><a href="javascript:void(0)"
                                                    class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 update"
                                                    data-id="{{ $quran->id }}" data-status="reject">Reject</a>
                                            </li>
                                        @endif
                                        <li><a href="javascript:void(0)"
                                                class="block px-4 py-2 text-red-600 hover:bg-gray-100 dark:hover:bg-gray-600 delete"
                                                data-id="{{ $quran->id }}">Delete</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <div class="p-5">
                                <p class="mb-3 font-normal text-white">
                                    {!! $quran->deskripsi !!}
                                </p>

                            </div>

                            <div class="owl-carousel owl-theme min-h-[350px] quranCarousel relative">
                                @foreach ($quran->file as $item)
                                    <div class="item">
                                        @if ($quran->content_type === 'image')
                                            <img src="{{ asset('storage/' . $item->url) }}" alt=""
                                                class="w-full h-[350px] object-cover rounded-t-lg">
                                        @else
                                            <video controls class="w-full h-[350px] object-cover rounded-t-lg">
                                                <source src="{{ asset('storage/' . $item->url) }}" type="video/mp4">
                                                Your browser does not support the video tag.
                                            </video>
                                        @endif
                                    </div>
                                @endforeach
                            </div>

                        </div>
                    @endforeach
                </div>
                <div class="mt-2">
                    {{ $data->links() }}
                </div>


            </main>
        </div>

        @include('partial.script')
        @if ($errors->any())
            <script>
                document.getElementById('errorModal').classList.remove('hidden');
            </script>
        @endif

        <script>
            $(window).on('load', function() {
                $('.quranCarousel').each(function() {
                    const $carousel = $(this);

                    $carousel.owlCarousel({
                        items: 1,
                        loop: false, // ⬅️ nonaktifkan loop
                        nav: true, // ⬅️ aktifkan tombol navigasi
                        dots: false,
                        margin: 10,
                        autoHeight: true,
                        autoplay: false, // ⬅️ jangan autoplay
                        navText: ['<button class="btn btn-circle">❮</button>',
                            '<button class="btn btn-circle">❯</button>'
                        ] // tombol custom
                    });
                });
            });

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
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

            $(document).on('click', '.update', function() {
                const id = $(this).data('id');
                const status = $(this).data('status');
                $.ajax({
                    url: '/konten/' + id,
                    method: 'POST',
                    data: {
                        status: status,
                        _method: 'PUT',
                    },
                    success: function(response) {
                        Swal.fire('Berhasil!', response.message, 'success')
                            .then(() => location.reload());
                    },
                    error: function(xhr) {
                        Swal.fire('Gagal!', response.message, 'error');
                    }
                });
            });

            $(document).on('click', '.delete', function() {
                const id = $(this).data('id');
                Swal.fire({
                    title: 'Yakin hapus Konten?',
                    text: 'Menghapus Konten akan menghapus semua data Konten yang terkait secara permanen.Anda tidak dapat membatalkan tindakan ini.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '/konten/' + id,
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
