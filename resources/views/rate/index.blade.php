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
                        Nilai Tukar
                    </p>
                    <button type="button" onclick="showModal()"
                        class="w-1/4 border border-gray-300 text-black bg-white from-purple-600 to-blue-500 hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center mb-2 cursor-pointe">
                        Tambah Nilai Tukar
                    </button>
                </div>


                <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                    <div class="overflow-x-auto">
                        <table class="table">
                            <!-- head -->
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Type</th>
                                    <th>Jumlah Koin</th>
                                    <th>Nilai Rupiah</th>
                                    <th>Active</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $key => $rate)
                                    <tr>
                                        <th>
                                            {{ $key + 1 }}
                                        </th>
                                        <td>
                                            {{ $rate->type }}
                                        </td>
                                        <td>
                                            {{ $rate->coin_unit }}
                                        </td>
                                        <td>
                                            Rp {{ number_format($rate->unit_value, 0, ',', '.') }}
                                        </td>
                                        <td>
                                            @if ($rate->active == 1)
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
                                                    Ya
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
                                                    Tidak
                                                </div>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="flex justify-content-center">
                                                <a href="/rate/{{ $rate->id }}" class="text-[18px] mx-2">
                                                    <i class="ri-edit-fill"></i>
                                                </a>
                                                <a href="javascript:void(0)" class="text-[18px] mx-2 delete-asma"
                                                    data-id="{{ $rate->id }}" title="Delete Asma Al Husna">
                                                    <i class="ri-delete-bin-6-fill"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-2">
                        {{ $data->links() }}
                    </div>
                </div>


            </main>
        </div>

        <x-modal>
            <h2 class="text-lg font-bold mb-4 text-red-600">Tambah Nilai Tukar</h2>
            <form class="space-y-4 md:space-y-6 mt-3" method="POST" action="{{ route('store-rate') }}">
                @csrf
                <div>
                    <label for="role" class="block mb-2 text-sm font-medium text-black-100 dark:text-black">Type</label>
                    <select name="type" id="type"
                        class="bg-gray-50 border @error('type') border-red-500 @else border-gray-300 focus:border-primary-600 dark:border-gray-600 dark:focus:border-blue-500 @enderror text-gray-900 rounded-lg focus:ring-primary-600 block w-full p-2.5 dark:bg-white-100 dark:placeholder-gray-400 dark:text-gray dark:focus:ring-blue-500">
                        <option value="purchase">Purchase</option>
                        <option value="withdraw">Withdraw</option>
                    </select>
                    @error('type')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="coin_unit" class="block mb-2 text-sm font-medium text-black-100 dark:text-black">Jumlah
                        Koin</label>
                    <input type="text" name="coin_unit" id="coin_unit"
                        class="bg-gray-50 border @error('coin_unit') border-red-500 @else border-gray-300 focus:border-primary-600 dark:border-gray-600 dark:focus:border-blue-500 @enderror text-gray-900 rounded-lg focus:ring-primary-600 block w-full p-2.5 dark:bg-white-100 dark:placeholder-gray-400 dark:text-gray dark:focus:ring-blue-500"
                        value="{{ old('coin_unit') }}" placeholder="Masukan Jumlah Koin ...." />
                    @error('coin_unit')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="unit_value" class="block mb-2 text-sm font-medium text-black-100 dark:text-black">Nilai
                        Rupiah</label>
                    <input type="text" name="unit_value" id="unit_value"
                        class="bg-gray-50 border @error('unit_value') border-red-500 @else border-gray-300 focus:border-primary-600 dark:border-gray-600 dark:focus:border-blue-500 @enderror text-gray-900 rounded-lg focus:ring-primary-600 block w-full p-2.5 dark:bg-white-100 dark:placeholder-gray-400 dark:text-gray dark:focus:ring-blue-500"
                        value="{{ old('unit_value') }}" placeholder="Masukan unit_value ...." />
                    @error('unit_value')
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
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $(document).on('click', '.delete-asma', function() {
                const id = $(this).data('id');
                Swal.fire({
                    title: 'Yakin hapus Rate?',
                    text: 'Menghapus Rate akan menghapus semua data Rate yang terkait secara permanen.Anda tidak dapat membatalkan tindakan ini.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '/rate/' + id,
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
