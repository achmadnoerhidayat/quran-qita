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
                <h2 class="text-lg font-bold mb-4 text-red-600">Edit Qur an</h2>
                <form class="space-y-4 md:space-y-6 mt-3" method="POST" enctype="multipart/form-data"
                    action="{{ route('edit-quran', $data->id) }}">
                    @csrf
                    @method('PUT')
                    <div>
                        <label for="nomor"
                            class="block mb-2 text-sm font-medium text-black-100 dark:text-black">Nomor</label>
                        <input type="text" name="nomor" id="nomor"
                            class="bg-gray-50 border @error('nomor') border-red-500 @else border-gray-300 focus:border-primary-600 dark:border-gray-600 dark:focus:border-blue-500 @enderror text-gray-900 rounded-lg focus:ring-primary-600 block w-full p-2.5 dark:bg-white-100 dark:placeholder-gray-400 dark:text-gray dark:focus:ring-blue-500"
                            value="{{ $data->nomor }}" placeholder="Pengertian Haji Umroh" />
                        @error('nomor')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="nama"
                            class="block mb-2 text-sm font-medium text-black-100 dark:text-black">Nama</label>
                        <input type="text" name="nama" id="nama"
                            class="bg-gray-50 border @error('nama') border-red-500 @else border-gray-300 focus:border-primary-600 dark:border-gray-600 dark:focus:border-blue-500 @enderror text-gray-900 rounded-lg focus:ring-primary-600 block w-full p-2.5 dark:bg-white-100 dark:placeholder-gray-400 dark:text-gray dark:focus:ring-blue-500"
                            value="{{ $data->nama }}" placeholder="Pengertian Haji Umroh" />
                        @error('nama')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="nama_latin" class="block mb-2 text-sm font-medium text-black-100 dark:text-black">Nama
                            Latin</label>
                        <input type="text" name="nama_latin" id="nama_latin"
                            class="bg-gray-50 border @error('nama_latin') border-red-500 @else border-gray-300 focus:border-primary-600 dark:border-gray-600 dark:focus:border-blue-500 @enderror text-gray-900 rounded-lg focus:ring-primary-600 block w-full p-2.5 dark:bg-white-100 dark:placeholder-gray-400 dark:text-gray dark:focus:ring-blue-500"
                            value="{{ $data->nama_latin }}" placeholder="Pengertian Haji Umroh" />
                        @error('nama_latin')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="jumlah_ayat"
                            class="block mb-2 text-sm font-medium text-black-100 dark:text-black">Jumlah Ayat</label>
                        <input type="text" name="jumlah_ayat" id="jumlah_ayat"
                            class="bg-gray-50 border @error('jumlah_ayat') border-red-500 @else border-gray-300 focus:border-primary-600 dark:border-gray-600 dark:focus:border-blue-500 @enderror text-gray-900 rounded-lg focus:ring-primary-600 block w-full p-2.5 dark:bg-white-100 dark:placeholder-gray-400 dark:text-gray dark:focus:ring-blue-500"
                            value="{{ $data->jumlah_ayat }}" placeholder="Pengertian Haji Umroh" />
                        @error('jumlah_ayat')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="tempat_turun"
                            class="block mb-2 text-sm font-medium text-black-100 dark:text-black">Tempat Turun</label>
                        <input type="text" name="tempat_turun" id="tempat_turun"
                            class="bg-gray-50 border @error('tempat_turun') border-red-500 @else border-gray-300 focus:border-primary-600 dark:border-gray-600 dark:focus:border-blue-500 @enderror text-gray-900 rounded-lg focus:ring-primary-600 block w-full p-2.5 dark:bg-white-100 dark:placeholder-gray-400 dark:text-gray dark:focus:ring-blue-500"
                            value="{{ $data->tempat_turun }}" placeholder="Pengertian Haji Umroh" />
                        @error('tempat_turun')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="arti"
                            class="block mb-2 text-sm font-medium text-black-100 dark:text-black">Arti</label>
                        <input type="text" name="arti" id="arti"
                            class="bg-gray-50 border @error('arti') border-red-500 @else border-gray-300 focus:border-primary-600 dark:border-gray-600 dark:focus:border-blue-500 @enderror text-gray-900 rounded-lg focus:ring-primary-600 block w-full p-2.5 dark:bg-white-100 dark:placeholder-gray-400 dark:text-gray dark:focus:ring-blue-500"
                            value="{{ $data->arti }}" placeholder="Pengertian Haji Umroh" />
                        @error('arti')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="arti_english" class="block mb-2 text-sm font-medium text-black-100 dark:text-black">Arti
                            Inggris</label>
                        <input type="text" name="arti_english" id="arti_english"
                            class="bg-gray-50 border @error('arti_english') border-red-500 @else border-gray-300 focus:border-primary-600 dark:border-gray-600 dark:focus:border-blue-500 @enderror text-gray-900 rounded-lg focus:ring-primary-600 block w-full p-2.5 dark:bg-white-100 dark:placeholder-gray-400 dark:text-gray dark:focus:ring-blue-500"
                            value="{{ $data->arti_english }}" placeholder="Pengertian Haji Umroh" />
                        @error('arti_english')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="deskripsi"
                            class="block mb-2 text-sm font-medium text-black-100 dark:text-black">Deskripsi</label>
                        <textarea name="deskripsi" id="editor" cols="30" rows="10"
                            class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-white-100 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    {{ $data->deskripsi }}</textarea>
                        @error('deskripsi')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <div class="flex justify-between">
                            <p class="font-bold">
                                Audio
                            </p>
                            <button type="button" id="addAudio"
                                class="w-1/4 border border-gray-300 text-black bg-white from-purple-600 to-blue-500 hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center mb-2 cursor-pointe">
                                Tambah Audio
                            </button>
                        </div>
                        <div id="audio-list">
                            @foreach ($data->audio_full as $audio)
                                <div class="flex justify-between my-2 audio-item">
                                    <input type="text" name="audio_full[]" id="arti_english"
                                        class="bg-gray-50 border @error('arti_english') border-red-500 @else border-gray-300 focus:border-primary-600 dark:border-gray-600 dark:focus:border-blue-500 @enderror text-gray-900 rounded-lg focus:ring-primary-600 block w-full p-2.5 dark:bg-white-100 dark:placeholder-gray-400 dark:text-gray dark:focus:ring-blue-500 w-[80%]"
                                        value="{{ $audio }}" placeholder="Pengertian Haji Umroh" />
                                    <div class="flex w-[10%] justify-end">
                                        <button type="button" data-id="{{ $data->id }}"
                                            data-url="{{ $audio }}"
                                            class="text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-full text-sm p-2.5 text-center inline-flex items-center me-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800 my-auto remove-audio">
                                            <i class="ri-delete-bin-6-fill"></i>
                                            <span class="sr-only">Icon description</span>
                                        </button>
                                    </div>
                                </div>
                            @endforeach

                        </div>
                    </div>
                    <button type="submit"
                        class="w-full border border-gray-300 text-black bg-white from-purple-600 to-blue-500 hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center mb-2 cursor-pointe">
                        Simpan
                    </button>
                </form>
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
            $(document).on('click', '.remove-audio', function() {
                const id = $(this).data('id');
                const url = $(this).data('url');
                if (id === null) {
                    $(this).closest('.audio-item').remove();
                    return;
                }
                Swal.fire({
                    title: 'Yakin hapus audio?',
                    text: url,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '/quran/delete-audio/' + id,
                            method: 'POST',
                            data: {
                                audio: url
                            },
                            success: function(response) {
                                Swal.fire('Berhasil!', response.message, 'success')
                                    .then(() => location.reload());
                            },
                            error: function(xhr) {
                                Swal.fire('Gagal!', 'Terjadi kesalahan.', 'error');
                            }
                        });
                    }
                });
            });
            $(document).on('click', '#addAudio', function() {
                Swal.fire({
                    title: 'Ingin Upload Audio ?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya',
                    cancelButtonText: 'Tidak'
                }).then((result) => {
                    if (result.isConfirmed) {
                        Swal.fire({
                            title: "Upload Audio",
                            input: "file",
                            inputAttributes: {
                                accept: "audio/mp3",
                                "aria-label": "Upload audio mp3"
                            },
                            showCancelButton: true,
                            confirmButtonText: "Simpan",
                            showLoaderOnConfirm: true,
                            preConfirm: async (file) => {
                                if (!file) {
                                    Swal.showValidationMessage('File tidak boleh kosong!');
                                    return;
                                }

                                const formData = new FormData();
                                formData.append('audio', file);

                                try {
                                    const response = await $.ajax({
                                        url: '/quran/upload-audio',
                                        method: 'POST',
                                        data: formData,
                                        processData: false,
                                        contentType: false
                                    });

                                    return response;
                                } catch (error) {
                                    Swal.showValidationMessage('Upload gagal!');
                                }
                            },
                            allowOutsideClick: () => !Swal.isLoading()
                        }).then((result) => {
                            if (result.isConfirmed && result.value && result.value.success) {
                                const audioUrl = result.value.url;

                                const html = `
                        <div class="flex justify-between my-2 audio-item">
                            <input type="text" name="audio_full[]" class="bg-gray-50 border border-gray-300 focus:border-primary-600 dark:border-gray-600 dark:focus:border-blue-500 text-gray-900 rounded-lg focus:ring-primary-600 block w-full p-2.5 w-[80%]" value="${audioUrl}" placeholder="Link audio" />
                            <div class="flex w-[10%] justify-end">
                                <button type="button" data-url="${audioUrl}" class="text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-full text-sm p-2.5 text-center inline-flex items-center me-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800 my-auto remove-audio">
                                    <i class="ri-delete-bin-6-fill"></i>
                                    <span class="sr-only">Hapus</span>
                                </button>
                            </div>
                        </div>`;

                                $('#audio-list').append(html);
                            }
                        });
                    } else {
                        // Jika user tidak mau upload file, tetap tambahkan input kosong
                        const html = `
                <div class="flex justify-between my-2 audio-item">
                    <input type="text" name="audio_full[]" class="bg-gray-50 border border-gray-300 focus:border-primary-600 dark:border-gray-600 dark:focus:border-blue-500 text-gray-900 rounded-lg focus:ring-primary-600 block w-full p-2.5 w-[80%]" value="" placeholder="Link audio manual" />
                    <div class="flex w-[10%] justify-end">
                        <button type="button" data-id="null" data-url="null" class="text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-full text-sm p-2.5 text-center inline-flex items-center me-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800 my-auto remove-audio">
                            <i class="ri-delete-bin-6-fill"></i>
                            <span class="sr-only">Hapus</span>
                        </button>
                    </div>
                </div>`;
                        $('#audio-list').append(html);
                    }
                });
            });

            ClassicEditor
                .create(document.querySelector('#editor'))
                .catch(error => {
                    console.error(error);
                });
        </script>
    </body>
@endsection
