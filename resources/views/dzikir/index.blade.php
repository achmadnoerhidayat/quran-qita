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
                <ul
                    class="hidden text-sm font-medium text-center text-gray-500 rounded-lg shadow-sm sm:flex dark:divide-gray-700 dark:text-gray-400">
                    <li class="w-full focus-within:z-10">
                        <a href="/dzikir"
                            class="inline-block w-full p-4 text-gray-900 bg-gray-100 border-r border-gray-200 dark:border-gray-700 rounded-s-lg focus:ring-4 focus:ring-blue-300 active focus:outline-none dark:bg-gray-700 dark:text-white"
                            aria-current="page">Dzikir</a>
                    </li>
                    <li class="w-full focus-within:z-10">
                        <a href="/type-dzikir"
                            class="inline-block w-full p-4 bg-white border-r border-gray-200 dark:border-gray-700 rounded-e-lg hover:text-gray-700 hover:bg-gray-50 focus:ring-4 focus:ring-blue-300 focus:outline-none dark:hover:text-white dark:bg-gray-800 dark:hover:bg-gray-700">Type</a>
                    </li>
                </ul>

                <div class="flex justify-between mt-4">
                    <p class="font-bold">
                        Dzikir
                    </p>
                    <button type="button" onclick="showModal()"
                        class="w-1/4 border border-gray-300 text-black bg-white from-purple-600 to-blue-500 hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center mb-2 cursor-pointe">
                        Tambah Dzikir
                    </button>
                </div>


                <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                    <table class="w-full text-sm text-left rtl:text-right text-gray-700">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-100">
                            <tr>
                                <th scope="col" class="px-6 py-3">
                                    Type
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Arab
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Indo
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Ulang
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
                                        {{ $news->type }}
                                    </td>
                                    <td class="px-6 py-4 ayat-arab">
                                        {!! $news->arab !!}
                                    </td>
                                    <td class="px-6 py-4">
                                        {!! $news->indo !!}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $news->ulang }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex justify-content-center">
                                            <a href="/dzikir/{{ $news->id }}" class="text-[18px] mx-2">
                                                <i class="ri-edit-fill"></i>
                                            </a>
                                            <a href="javascript:void(0)" class="text-[18px] mx-2 delete-zikir"
                                                data-id="{{ $news->id }}" title="Delete Dzikir">
                                                <i class="ri-delete-bin-6-fill"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="mt-2">
                        {{ $data->links() }}
                    </div>
                </div>


            </main>
        </div>

        <x-modal>
            <h2 class="text-lg font-bold mb-4 text-red-600">Tambah Dzikir</h2>
            <form class="space-y-4 md:space-y-6 mt-3" method="POST" action="{{ route('store-dzikir') }}">
                @csrf
                <div>
                    <label for="role" class="block mb-2 text-sm font-medium text-black-100 dark:text-black">Type</label>
                    <select name="type" id="role"
                        class="bg-gray-50 border border-gray-300 focus:border-primary-600 dark:border-gray-600 dark:focus:border-blue-500 text-gray-900 rounded-lg focus:ring-primary-600 block w-full p-2.5 dark:bg-white-100 dark:placeholder-gray-400 dark:text-gray dark:focus:ring-blue-500">
                        <option value="">Pilih Type</option>
                        @foreach ($type as $dzikir)
                            <option value="{{ $dzikir->name }}">{{ $dzikir->name }}</option>
                        @endforeach
                    </select>
                    @error('type')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="arab" class="block mb-2 text-sm font-medium text-black-100 dark:text-black">Arab</label>
                    <textarea name="arab" id="arab" cols="30" rows="10"
                        class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-white-100 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray dark:focus:ring-blue-500 dark:focus:border-blue-500 editor">
                    {{ old('arab') }}</textarea>
                    @error('arab')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="indo" class="block mb-2 text-sm font-medium text-black-100 dark:text-black">Indo</label>
                    <textarea name="indo" id="indo" cols="30" rows="10"
                        class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-white-100 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray dark:focus:ring-blue-500 dark:focus:border-blue-500 editor">
                    {{ old('indo') }}</textarea>
                    @error('indo')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="ulang"
                        class="block mb-2 text-sm font-medium text-black-100 dark:text-black">Ulang</label>
                    <input type="text" name="ulang" id="ulang"
                        class="bg-gray-50 border @error('ulang') border-red-500 @else border-gray-300 focus:border-primary-600 dark:border-gray-600 dark:focus:border-blue-500 @enderror text-gray-900 rounded-lg focus:ring-primary-600 block w-full p-2.5 dark:bg-white-100 dark:placeholder-gray-400 dark:text-gray dark:focus:ring-blue-500"
                        value="{{ old('ulang') }}" placeholder="Masukan Ulang 1x ...." />
                    @error('ulang')
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
            document.querySelectorAll('.editor').forEach((el) => {
                ClassicEditor
                    .create(el)
                    .catch(error => {
                        console.error(error);
                    });
            });
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $(document).on('click', '.delete-zikir', function() {
                const id = $(this).data('id');
                Swal.fire({
                    title: 'Yakin hapus Dzikir?',
                    text: 'Menghapus Dzikir akan menghapus semua data Dzikir yang terkait secara permanen.Anda tidak dapat membatalkan tindakan ini.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '/dzikir/' + id,
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
