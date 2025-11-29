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
                <div class="card w-full bg-base-100 card-xl shadow-sm">
                    <div class="card-body">
                        <div class="flex justify-between">
                            <p class="font-bold">
                                Transaksi
                            </p>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="table">
                                <!-- head -->
                                <thead>
                                    <tr>
                                        <th>Pengguna</th>
                                        <th>Paket</th>
                                        <th>Order Id</th>
                                        <th>Jumlah Koin</th>
                                        <th>Harga</th>
                                        <th>Tanggal</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $trans)
                                        <tr>
                                            <td>
                                                <div class="flex items-center gap-3">
                                                    <div class="avatar">
                                                        <div class="mask mask-squircle h-12 w-12">
                                                            @if (!$trans->user->image)
                                                                <img src="https://img.daisyui.com/images/profile/demo/2@94.webp"
                                                                    alt="Avatar Tailwind CSS Component" />
                                                            @else
                                                                <img src="/storage/{{ $trans->user->image }}" />
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <div class="font-bold">
                                                            {{ $trans->user->name }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                {{ $trans->package->coin_amount }} Koin
                                            </td>
                                            <td>
                                                {{ $trans->order_id }}
                                            </td>
                                            <td>
                                                {{ $trans->amount_coin }} Koin
                                            </td>
                                            <td>
                                                {{ number_format($trans->price, 0, ',', '.') }}
                                            </td>
                                            <td>
                                                {{ $trans->created_at->translatedFormat('d F Y') }}
                                            </td>
                                            <td>
                                                @if ($trans->status === 'pending')
                                                    <div class="badge badge-warning">
                                                        <svg class="size-[1em]" xmlns="http://www.w3.org/2000/svg"
                                                            viewBox="0 0 18 18">
                                                            <g fill="currentColor">
                                                                <path
                                                                    d="M7.638,3.495L2.213,12.891c-.605,1.048,.151,2.359,1.362,2.359H14.425c1.211,0,1.967-1.31,1.362-2.359L10.362,3.495c-.605-1.048-2.119-1.048-2.724,0Z"
                                                                    fill="none" stroke="currentColor"
                                                                    stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="1.5"></path>
                                                                <line x1="9" y1="6.5" x2="9"
                                                                    y2="10" fill="none" stroke="currentColor"
                                                                    stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="1.5"></line>
                                                                <path
                                                                    d="M9,13.569c-.552,0-1-.449-1-1s.448-1,1-1,1,.449,1,1-.448,1-1,1Z"
                                                                    fill="currentColor" data-stroke="none" stroke="none">
                                                                </path>
                                                            </g>
                                                        </svg>
                                                        Pending
                                                    </div>
                                                @elseif($trans->status === 'success')
                                                    <div class="badge badge-success">
                                                        <svg class="size-[1em]" xmlns="http://www.w3.org/2000/svg"
                                                            viewBox="0 0 24 24">
                                                            <g fill="currentColor" stroke-linejoin="miter"
                                                                stroke-linecap="butt">
                                                                <circle cx="12" cy="12" r="10" fill="none"
                                                                    stroke="currentColor" stroke-linecap="square"
                                                                    stroke-miterlimit="10" stroke-width="2"></circle>
                                                                <polyline points="7 13 10 16 17 8" fill="none"
                                                                    stroke="currentColor" stroke-linecap="square"
                                                                    stroke-miterlimit="10" stroke-width="2"></polyline>
                                                            </g>
                                                        </svg>
                                                        Success
                                                    </div>
                                                @else
                                                    <div class="badge badge-error">
                                                        <svg class="size-[1em]" xmlns="http://www.w3.org/2000/svg"
                                                            viewBox="0 0 24 24">
                                                            <g fill="currentColor">
                                                                <rect x="1.972" y="11" width="20.056" height="2"
                                                                    transform="translate(-4.971 12) rotate(-45)"
                                                                    fill="currentColor" stroke-width="0"></rect>
                                                                <path
                                                                    d="m12,23c-6.065,0-11-4.935-11-11S5.935,1,12,1s11,4.935,11,11-4.935,11-11,11Zm0-20C7.038,3,3,7.037,3,12s4.038,9,9,9,9-4.037,9-9S16.962,3,12,3Z"
                                                                    stroke-width="0" fill="currentColor"></path>
                                                            </g>
                                                        </svg>
                                                        $trans->status
                                                    </div>
                                                @endif
                                            </td>
                                            {{--  <th>
                                        <button class="btn btn-ghost btn-xs">details</button>
                                    </th>  --}}
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-2">
                            {{ $data->links() }}
                        </div>
                    </div>
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
                                status: 'cancelled',
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

            $(document).on('click', '.edit-status', function() {
                $(".content").html('');
                const url = $(this).data('url');
                const status = $(this).data('status');
                let html = `<form action="${url}" method="post">
                            <input type="hidden" name="_token" value="${$('meta[name="csrf-token"]').attr('content')}">
                            <label for="role"
                                class="block mb-2 text-sm font-medium text-black-100 dark:text-black">Status</label>
                            <select name="status" id="role"
                                class="bg-gray-50 border border-gray-300 focus:border-primary-600 dark:border-gray-600 dark:focus:border-blue-500 text-gray-900 rounded-lg focus:ring-primary-600 block w-full p-2.5 dark:bg-white-100 dark:placeholder-gray-400 dark:text-gray dark:focus:ring-blue-500">
                                <option value="">Pilih Status</option>
                                <option value="pending">Pending</option>
                                <option value="active">Active</option>
                                <option value="expired">Expired</option>
                                <option value="cancelled">cancelled</option>
                            </select>
                            <button type="submit"
                    class="w-full my-2 border border-gray-300 text-black bg-white from-purple-600 to-blue-500 hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center mb-2 cursor-pointe">
                    Simpan
                </button>
                        </form>`;
                $(".content").append(html);
                $('select[name="status"]').val(status);
                $("#errorModal").removeClass('hidden');
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
