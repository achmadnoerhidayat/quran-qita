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
                        Langganan
                    </p>
                </div>


                <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                    <table class="w-full text-sm text-left rtl:text-right text-gray-700">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-100">
                            <tr>
                                <th scope="col" class="px-6 py-3">
                                    Mulai
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Berakhir
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Status Pembayaran
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Status
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Bukti Transfer
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Keterangan
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Aksi
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $news)
                                <tr class="bg-white border-b border-gray-200">
                                    <td class="px-6 py-4">
                                        {{ !empty($news->starts_at) ? $news->starts_at->format('d M Y H:i') : '' }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ !empty($news->end_at) ? $news->end_at->format('d M Y H:i') : '' }}
                                    </td>
                                    <td class="px-6 py-4">
                                        @if ($news->payment_status === 'paid')
                                            <span
                                                class="bg-green-100 text-green-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded-full dark:bg-green-900 dark:text-green-300">{{ $news->payment_status }}</span>
                                        @else
                                            <span
                                                class="bg-yellow-100 text-yellow-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded-full dark:bg-yellow-900 dark:text-yellow-300">{{ $news->payment_status }}</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        @if ($news->status === 'expired')
                                            <span
                                                class="bg-red-100 text-red-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded-full dark:bg-red-900 dark:text-red-300">{{ $news->status }}</span>
                                        @elseif ($news->status === 'cancelled')
                                            <span
                                                class="bg-red-100 text-red-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded-full dark:bg-red-900 dark:text-red-300">{{ $news->status }}</span>
                                        @elseif ($news->status === 'active')
                                            <span
                                                class="bg-green-100 text-green-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded-full dark:bg-green-900 dark:text-green-300">{{ $news->status }}</span>
                                        @elseif ($news->status === 'pending')
                                            <span
                                                class="bg-yellow-100 text-yellow-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded-full dark:bg-yellow-900 dark:text-yellow-300">{{ $news->status }}</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        <img class="w-16 md:w-32 max-w-full max-h-full cursor-pointer show-img"
                                            data-url="{{ asset('storage/' . $news->bukti_transfer) }}"
                                            src="{{ asset('storage/' . $news->bukti_transfer) }}">
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $news->keterangan_admin }}
                                    </td>
                                    <td class="px-6 py-4">
                                        @if ($news->status === 'pending')
                                            <div class="flex justify-content-center">
                                                <a href="javascript:void(0)" class="text-[18px] mx-2 approve"
                                                    title="Setujui" data-id="{{ $news->id }}"
                                                    data-plan="{{ $news->plan->id }}">
                                                    <i class="ri-check-fill"></i>
                                                </a>
                                                <a href="javascript:void(0)" class="text-[18px] mx-2 tolak"
                                                    data-id="{{ $news->id }}" data-plan="{{ $news->plan->id }}"
                                                    title="Tolak">
                                                    <i class="ri-close-fill"></i>
                                                </a>
                                            </div>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <x-modal>
                    <div class="content">

                    </div>
                </x-modal>

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
            $(document).on('click', '.approve', function() {
                const id = $(this).data('id');
                const plan = $(this).data('plan');
                Swal.fire({
                    title: "Masukan Keterangan Admin",
                    input: "text",
                    inputAttributes: {
                        autocapitalize: "off"
                    },
                    showCancelButton: true,
                    confirmButtonText: "Simpan",
                    showLoaderOnConfirm: true,
                    preConfirm: async (keterangan) => {
                        $.ajax({
                            url: '/langganan/' + id,
                            method: 'POST',
                            data: {
                                _method: 'PUT',
                                plan_id: plan,
                                payment_status: 'paid',
                                keterangan_admin: keterangan
                            },
                            success: function(response) {
                                Swal.fire('Berhasil!', response.message, 'success')
                                    .then(() => location.reload());
                            },
                            error: function(xhr) {
                                Swal.fire('Gagal!', response.message, 'error');
                            }
                        });
                    },
                    allowOutsideClick: () => !Swal.isLoading()
                }).then((result) => {});
            });
            $(document).on('click', '.tolak', function() {
                const id = $(this).data('id');
                const plan = $(this).data('plan');
                Swal.fire({
                    title: "Masukan Keterangan Admin",
                    input: "text",
                    inputAttributes: {
                        autocapitalize: "off"
                    },
                    showCancelButton: true,
                    confirmButtonText: "Simpan",
                    showLoaderOnConfirm: true,
                    preConfirm: async (keterangan) => {
                        $.ajax({
                            url: '/langganan/' + id,
                            method: 'POST',
                            data: {
                                _method: 'PUT',
                                plan_id: plan,
                                payment_status: 'failed',
                                keterangan_admin: keterangan
                            },
                            success: function(response) {
                                Swal.fire('Berhasil!', response.message, 'success')
                                    .then(() => location.reload());
                            },
                            error: function(xhr) {
                                Swal.fire('Gagal!', response.message, 'error');
                            }
                        });
                    },
                    allowOutsideClick: () => !Swal.isLoading()
                }).then((result) => {});
            });
            $(document).on('click', '.show-img', function() {
                $('.content').empty();
                $("#errorModal").removeClass('hidden');
                const url = $(this).data('url');
                const html = `<img class="w-full h-auto max-w-xl rounded-lg cursor-pointer show-img"
                                            src="${url}">`;
                $('.content').append(html);
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
