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
                <div class="flex justify-between">
                    <p class="font-bold">
                        Content
                    </p>
                </div>
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-3 lg:grid-cols-3 gap-4 my-2">
                    @foreach ($data as $index => $quran)
                        <div
                            class="w-full max-w-sm bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700">

                            <div class="flex justify-end px-4 pt-4 relative">
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
                            <a href="#" class="mt-4">
                                @if ($quran->content_type === 'image')
                                    <img class="rounded-t-lg" src="/storage/{{ $quran->file[0]->url }}" alt="" />
                                @else
                                    <video
                                        class="w-full h-auto max-w-full border border-gray-200 rounded-lg dark:border-gray-700"
                                        controls>
                                        <source src="/storage/{{ $quran->file[0]->url }}" type="video/mp4">
                                        Your browser does not support the video tag.
                                    </video>
                                @endif
                            </a>
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
