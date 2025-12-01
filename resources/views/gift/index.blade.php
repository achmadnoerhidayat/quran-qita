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

                    <h2 class="text-xl font-bold text-gray-800 ml-4 hidden sm:block">Dashboard Produk</h2>
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
                        Gift
                    </p>
                    <button type="button" onclick="showModal()"
                        class="w-1/4 border border-gray-300 text-black bg-white from-purple-600 to-blue-500 hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center mb-2 cursor-pointe">
                        Tambah Gift
                    </button>
                </div>

                <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                    <table class="w-full text-sm text-left rtl:text-right text-gray-700">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-100">
                            <tr>
                                <th scope="col" class="px-6 py-3">
                                    Nama
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Icon
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Animasi
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Harga / Koin
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    deskripsi
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
                                        {{ $news->name }}
                                    </td>
                                    <td class="px-6 py-4">
                                        @if ($news->icon)
                                            <div class="avatar">
                                                <div class="w-24 rounded-xl">
                                                    <img src="/storage/{{ $news->icon }}" />
                                                </div>
                                            </div>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        @if ($news->animation_url)
                                            <div class="avatar">
                                                <div class="w-24 rounded-xl">
                                                    <img src="/storage/{{ $news->animation_url }}" />
                                                </div>
                                            </div>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $news->coin_cost }} Koin
                                    </td>
                                    <td>
                                        {{ \Illuminate\Support\Str::limit(strip_tags($news->deskripsi), 50) }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex justify-content-center">
                                            <a href="/gift/{{ $news->id }}" class="text-[18px] mx-2">
                                                <i class="ri-edit-fill"></i>
                                            </a>
                                            <a href="javascript:void(0)" class="text-[18px] mx-2 delete-materi"
                                                data-id="{{ $news->id }}" title="Delete Gift">
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

            </main>
        </div>

        <x-modal>
            <h2 class="text-lg font-bold mb-4 text-red-600">Tambah Gift</h2>
            <form class="space-y-4 md:space-y-6 mt-3" method="POST" enctype="multipart/form-data"
                action="{{ route('store-gift') }}">
                @csrf
                <div>
                    <label for="body" class="block mb-2 text-sm font-medium text-black-100 dark:text-black">Nama</label>
                    <input type="text" name="name" id="title"
                        class="bg-gray-50 border @error('name') border-red-500 @else border-gray-300 focus:border-primary-600 dark:border-gray-600 dark:focus:border-blue-500 @enderror text-gray-900 rounded-lg focus:ring-primary-600 block w-full p-2.5 dark:bg-white-100 dark:placeholder-gray-400 dark:text-gray dark:focus:ring-blue-500"
                        value="{{ old('name') }}" placeholder="Masukan name..." />
                    @error('name')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="icon" class="block mb-2 text-sm font-medium text-black-100 dark:text-black">Upload
                        Icon</label>
                    <input type="file" name="icon" id="title"
                        class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-white-100 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray dark:focus:ring-blue-500 dark:focus:border-blue-500" />
                    @error('icon')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="icon" class="block mb-2 text-sm font-medium text-black-100 dark:text-black">Upload
                        Animasi</label>
                    <input type="file" name="animation_url" id="title"
                        class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-white-100 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray dark:focus:ring-blue-500 dark:focus:border-blue-500" />
                    @error('animation_url')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="body" class="block mb-2 text-sm font-medium text-black-100 dark:text-black">Harga /
                        Koin</label>
                    <input type="text" name="coin_cost" id="price"
                        class="bg-gray-50 border @error('coin_cost') border-red-500 @else border-gray-300 focus:border-primary-600 dark:border-gray-600 dark:focus:border-blue-500 @enderror text-gray-900 rounded-lg focus:ring-primary-600 block w-full p-2.5 dark:bg-white-100 dark:placeholder-gray-400 dark:text-gray dark:focus:ring-blue-500"
                        value="{{ old('coin_cost') }}" placeholder="Masukan Harga..." />
                    @error('coin_cost')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="body"
                        class="block mb-2 text-sm font-medium text-black-100 dark:text-black">Deskripsi</label>
                    <textarea name="deskripsi" id="editor" cols="30" rows="10"
                        class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-white-100 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    {{ old('deskripsi') }}</textarea>
                    @error('deskripsi')
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

            $(document).on('click', '.delete-materi', function() {
                const id = $(this).data('id');
                Swal.fire({
                    title: 'Yakin hapus Gift?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '/gift/' + id,
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

            $(document).on("change", ".free", function() {
                var checked = $(this).is(":checked");
                if (checked) {
                    $("#price").addClass('hidden');
                    $("#price").val("0");
                } else {
                    $("#price").removeClass('hidden');
                    $("#price").val("");
                }
            });

            $(document).on("change", ".permanen", function() {
                var checked = $(this).is(":checked");
                if (checked) {
                    $("#duration").addClass('hidden');
                    $("#duration").val("0");
                } else {
                    $("#duration").removeClass('hidden');
                    $("#duration").val("");
                }
            });

            ClassicEditor
                .create(document.querySelector('#editor'))
                .catch(error => {
                    console.error(error);
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
