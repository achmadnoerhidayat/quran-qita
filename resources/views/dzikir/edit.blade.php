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
                <h2 class="text-lg font-bold mb-4 text-red-600">Edit Dzikir</h2>
                <form class="space-y-4 md:space-y-6 mt-3" method="POST" enctype="multipart/form-data"
                    action="{{ route('update-dzikir', $data->id) }}">
                    @csrf
                    @method('PUT')
                    <div>
                        <label for="role"
                            class="block mb-2 text-sm font-medium text-black-100 dark:text-black">Type</label>
                        <select name="type" id="role"
                            class="bg-gray-50 border border-gray-300 focus:border-primary-600 dark:border-gray-600 dark:focus:border-blue-500 text-gray-900 rounded-lg focus:ring-primary-600 block w-full p-2.5 dark:bg-white-100 dark:placeholder-gray-400 dark:text-gray dark:focus:ring-blue-500">
                            <option value="">Pilih Type</option>
                            @foreach ($type as $dzikir)
                                <option value="{{ $dzikir->name }}"
                                    {{ ($data->type ?? '') == $dzikir->name ? 'selected' : '' }}>
                                    {{ $dzikir->name }}</option>
                            @endforeach
                        </select>
                        @error('type')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="arab"
                            class="block mb-2 text-sm font-medium text-black-100 dark:text-black">Arab</label>
                        <textarea name="arab" id="arab" cols="30" rows="10"
                            class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-white-100 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray dark:focus:ring-blue-500 dark:focus:border-blue-500 editor">
                    {{ $data->arab }}</textarea>
                        @error('arab')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="indo"
                            class="block mb-2 text-sm font-medium text-black-100 dark:text-black">Indo</label>
                        <textarea name="indo" id="indo" cols="30" rows="10"
                            class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-white-100 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray dark:focus:ring-blue-500 dark:focus:border-blue-500 editor">
                    {{ $data->indo }}</textarea>
                        @error('indo')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="ulang"
                            class="block mb-2 text-sm font-medium text-black-100 dark:text-black">Ulang</label>
                        <input type="text" name="ulang" id="ulang"
                            class="bg-gray-50 border @error('ulang') border-red-500 @else border-gray-300 focus:border-primary-600 dark:border-gray-600 dark:focus:border-blue-500 @enderror text-gray-900 rounded-lg focus:ring-primary-600 block w-full p-2.5 dark:bg-white-100 dark:placeholder-gray-400 dark:text-gray dark:focus:ring-blue-500"
                            value="{{ $data->ulang }}" placeholder="Masukan Ulang 1x ...." />
                        @error('ulang')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    @if ($data->url_audio)
                        <div>
                            <media-theme-tailwind-audio style="width:100%">
                                <video slot="media" src="/storage/{{ $data->url_audio }}" playsinline
                                    crossorigin="anonymous"></video>
                            </media-theme-tailwind-audio>
                        </div>
                    @endif
                    <div>
                        <label for="audio" class="block mb-2 text-sm font-medium text-black-100 dark:text-black">Upload
                            Audio</label>
                        <input type="file" accept="audio/mp3" name="audio" id="audio"
                            class="bg-gray-50 border @error('audio') border-red-500 @else border-gray-300 focus:border-primary-600 dark:border-gray-600 dark:focus:border-blue-500 @enderror text-gray-900 rounded-lg focus:ring-primary-600 block w-full p-2.5 dark:bg-white-100 dark:placeholder-gray-400 dark:text-gray dark:focus:ring-blue-500"
                            placeholder="Masukan audio ...." />
                        @error('audio')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <button type="submit"
                        class="w-full border border-gray-300 text-black bg-white from-purple-600 to-blue-500 hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center mb-2 cursor-pointe">
                        Simpan
                    </button>
                </form>
            </main>
        </div>

        @include('partial.script')
        <script type="module" src="https://cdn.jsdelivr.net/npm/player.style/tailwind-audio/+esm"></script>
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

            function showModal() {
                document.getElementById('errorModal').classList.remove('hidden');
            }

            function closeErrorModal() {
                document.getElementById('errorModal').classList.add('hidden');
            }
        </script>
    </body>
@endsection
