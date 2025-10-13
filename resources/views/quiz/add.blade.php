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
                <form class="space-y-4 md:space-y-6 mt-3" method="POST" enctype="multipart/form-data"
                    action="{{ route('add-soal-quiz', $data->id) }}">
                    <div class="flex justify-between">
                        <p class="font-bold">
                            Tambah Soal
                        </p>
                        <button type="submit"
                            class="w-1/4 border border-gray-300 text-black bg-white from-purple-600 to-blue-500 hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center mb-2 cursor-pointe">
                            Simpan
                        </button>
                    </div>
                    @csrf
                    <div class="list-question">
                        @foreach ($data->question as $key => $question)
                            <div
                                class="w-full bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700 my-3 soal-item">
                                <div class="flex justify-between text-right p-5">
                                    <p class="text-gray-900 dark:text-white ayat-arab">
                                        Pertanyaan {{ $key + 1 }}
                                    </p>
                                    <div class="flex w-[10%] justify-end">
                                        <button type="button" data-id="{{ $question->id }}"
                                            class="text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-full text-sm p-2.5 text-center inline-flex items-center me-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800 my-auto remove-audio">
                                            <i class="ri-delete-bin-6-fill"></i>
                                            <span class="sr-only">Icon description</span>
                                        </button>
                                    </div>
                                </div>
                                <input type="hidden" name="question[{{ $key }}][id]" value="{{ $question->id }}">
                                <div class="my-4 mx-4">
                                    <label for="title"
                                        class="block mb-2 text-sm font-medium text-white-100 dark:text-white">Url
                                        Pembelajaran</label>
                                    <input type="title" name="question[{{ $key }}][question_url]" id="title"
                                        class="bg-gray-50 border border-gray-300 focus:border-primary-600 dark:border-gray-600 dark:focus:border-blue-500 text-gray-900 rounded-lg focus:ring-primary-600 block w-full p-2.5 dark:bg-white-100 dark:placeholder-gray-400 dark:text-gray dark:focus:ring-blue-500"
                                        value="{{ $question->question_url }}" placeholder="https://www.youtube.com" />
                                </div>
                                <div class="my-4 mx-4">
                                    <textarea name="question[{{ $key }}][question_text]" cols="30" rows="10"
                                        class="editor bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-white-100 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray dark:focus:ring-blue-500 dark:focus:border-blue-500">{{ trim($question->question_text) }}</textarea>
                                    @error('question_text')
                                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                @foreach ($question->answer as $index => $answer)
                                    <input type="hidden"
                                        name="question[{{ $key }}][answer][{{ $index }}][id]"
                                        value="{{ $answer->id }}">
                                    <div class="flex justify-between my-2 mx-4 audio-item">
                                        <span
                                            class="inline-flex items-center justify-center w-6 h-6 me-2 text-sm font-semibold text-gray-800 bg-gray-100 rounded-full dark:bg-gray-700 dark:text-gray-300 my-auto">
                                            <p class="text-gray-900 dark:text-white">
                                                @switch($index)
                                                    @case(0)
                                                        A
                                                    @break

                                                    @case(1)
                                                        B
                                                    @break

                                                    @case(2)
                                                        C
                                                    @break

                                                    @case(3)
                                                        D
                                                    @break

                                                    @default
                                                        E
                                                @endswitch
                                            </p>
                                            <span class="sr-only">Icon description</span>
                                        </span>
                                        <input type="text"
                                            name="question[{{ $key }}][answer][{{ $index }}][answer_text]"
                                            id="arti_english"
                                            class="bg-gray-50 border @error('arti_english') border-red-500 @else border-gray-300 focus:border-primary-600 dark:border-gray-600 dark:focus:border-blue-500 @enderror text-gray-900 rounded-lg focus:ring-primary-600 block w-full p-2.5 dark:bg-white-100 dark:placeholder-gray-400 dark:text-gray dark:focus:ring-blue-500 w-[80%]"
                                            value="{{ $answer->answer_text }}" placeholder="Pengertian Haji Umroh" />
                                        <div class="flex w-[10%]">
                                            <div class="my-auto mx-auto">
                                                <input type="hidden"
                                                    name="question[{{ $key }}][answer][{{ $index }}][is_correct]"
                                                    value="false">
                                                <input @if ($answer->is_correct === 'true') checked @endif id="default-radio-1"
                                                    type="checkbox" value="{{ $answer->is_correct }}"
                                                    name="question[{{ $key }}][answer][{{ $index }}][is_correct]"
                                                    class="only-one w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endforeach

                    </div>
                    <button type="button"
                        class="w-full border border-gray-300 text-black bg-white from-purple-600 to-blue-500 hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center mb-2 cursor-pointe"
                        id="add-pertanyaan" data-count="{{ count($data->question) }}">
                        Tambah Pertanyaan
                    </button>
                </form>
            </main>
            @if ($errors->any())
                <x-modal-error>
                    <h2 class="text-lg font-bold mb-4 text-red-600">Login Gagal</h2>
                    <ul class="list-disc list-inside text-sm text-red-700">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </x-modal-error>
            @endif
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

            function showModal() {
                document.getElementById('errorModal').classList.remove('hidden');
            }

            function closeErrorModal() {
                document.getElementById('errorModal').classList.add('hidden');
            }

            $(document).on('click', '#add-pertanyaan', function() {
                let count = $(this).data('count');
                count++;
                $(this).data('count', count).attr('data-count', count);
                var answer = ``;
                for (let i = 0; i < 4; i++) {
                    var abjad = "";
                    switch (i) {
                        case 0:
                            abjad = 'A';
                            break;
                        case 1:
                            abjad = 'B';
                            break;
                        case 2:
                            abjad = 'C';
                            break;
                        default:
                            abjad = 'D';
                    }
                    answer += `<input type="hidden"
                                        name="question[${count-1}][answer][${i}][id]"
                                        value="0">
                                        <div class="flex justify-between my-2 mx-4 audio-item">
                                        <span
                                            class="inline-flex items-center justify-center w-6 h-6 me-2 text-sm font-semibold text-gray-800 bg-gray-100 rounded-full dark:bg-gray-700 dark:text-gray-300 my-auto">
                                            <p class="text-gray-900 dark:text-white">
                                                ${abjad}
                                            </p>
                                            <span class="sr-only">Icon description</span>
                                        </span>

                                        <input type="text" name="question[${count-1}][answer][${i}][answer_text]" id="arti_english"
                                            class="bg-gray-50 border @error('arti_english') border-red-500 @else border-gray-300 focus:border-primary-600 dark:border-gray-600 dark:focus:border-blue-500 @enderror text-gray-900 rounded-lg focus:ring-primary-600 block w-full p-2.5 dark:bg-white-100 dark:placeholder-gray-400 dark:text-gray dark:focus:ring-blue-500 w-[80%]"
                                            value="" placeholder="Masukan Jawaban" />
                                        <div class="flex w-[10%]">
                                            <div class="my-auto mx-auto">
                                                <input type="hidden"
                                                    name="question[${count-1}][answer][${i}][is_correct]"
                                                    value="false">
                                                <input id="default-radio-1"
                                                    type="checkbox" value="${i}"
                                                    name="question[${count-1}][answer][${i}][is_correct]"
                                                    class="only-one w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                            </div>
                                        </div>
                                    </div>`;
                }
                var html = `<div
                                class="w-full bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700 my-3 soal-item">
                                <div class="flex justify-between text-right p-5">
                                    <p class="text-gray-900 dark:text-white ayat-arab">
                                        Pertanyaan ${count}
                                    </p>
                                    <div class="flex w-[10%] justify-end">
                                        <button type="button" data-id="0"
                                            class="text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-full text-sm p-2.5 text-center inline-flex items-center me-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800 my-auto remove-audio">
                                            <i class="ri-delete-bin-6-fill"></i>
                                            <span class="sr-only">Icon description</span>
                                        </button>
                                    </div>
                                </div>
                                <input type="hidden" name="question[${count-1}][id]" value="0">
                                <div class="my-4 mx-4">
                                    <label for="title"
                                        class="block mb-2 text-sm font-medium text-white-100 dark:text-white">Url
                                        Pembelajaran</label>
                                    <input type="text" name="question[${count-1}][question_url]" id="title"
                                        class="bg-gray-50 border border-gray-300 focus:border-primary-600 dark:border-gray-600 dark:focus:border-blue-500 text-gray-900 rounded-lg focus:ring-primary-600 block w-full p-2.5 dark:bg-white-100 dark:placeholder-gray-400 dark:text-gray dark:focus:ring-blue-500"
                                        value="" placeholder="https://www.youtube.com" />
                                </div>
                                <div class="my-4 mx-4">
                                    <textarea name="question[${count-1}][question_text]" cols="30" rows="10"
                                        class="editor bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-white-100 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray dark:focus:ring-blue-500 dark:focus:border-blue-500"></textarea>
                                </div>
                                ${answer}
                            </div>`;

                $('.list-question').append(html);
                const singleSelectCheckboxes = document.querySelectorAll('.only-one');

                singleSelectCheckboxes.forEach(checkbox => {
                    checkbox.addEventListener('click', function() {
                        if (!this.checked) {
                            return;
                        }
                        const nameParts = this.name.split('][');
                        if (nameParts.length < 2) return;
                        const questionKeyPart = nameParts[0] + ']';
                        singleSelectCheckboxes.forEach(otherCheckbox => {
                            if (otherCheckbox !== this && otherCheckbox.name.startsWith(
                                    questionKeyPart)) {
                                otherCheckbox.checked = false;
                            }
                        });
                    });
                });
            });
            $(document).on('change', '.only-one', function() {
                const $currentCheckbox = $(this);
                const isChecked = $currentCheckbox.prop('checked');
                const nameAttr = $currentCheckbox.attr('name');
                const questionKeyMatch = nameAttr.match(/question\[\d+\]/);
                if (!questionKeyMatch) return;

                const questionGroupPrefix = questionKeyMatch[0];
                if (isChecked) {
                    $currentCheckbox.val('true');
                    $('.only-one').each(function() {
                        const $otherCheckbox = $(this);
                        const otherNameAttr = $otherCheckbox.attr('name');
                        if (otherNameAttr.startsWith(questionGroupPrefix) && this !== $currentCheckbox[0]) {
                            $otherCheckbox.prop('checked', false);
                            $otherCheckbox.val('false');
                        }
                    });

                } else {
                    $currentCheckbox.val('false');
                }
            });
            document.addEventListener('DOMContentLoaded', function() {
                const singleSelectCheckboxes = document.querySelectorAll('.only-one');

                singleSelectCheckboxes.forEach(checkbox => {
                    checkbox.addEventListener('click', function() {
                        if (!this.checked) {
                            return;
                        }
                        const nameParts = this.name.split('][');
                        if (nameParts.length < 2) return;
                        const questionKeyPart = nameParts[0] + ']';
                        singleSelectCheckboxes.forEach(otherCheckbox => {
                            if (otherCheckbox !== this && otherCheckbox.name.startsWith(
                                    questionKeyPart)) {
                                otherCheckbox.checked = false;
                            }
                        });
                    });
                });
            });
            $(document).on('click', '.remove-audio', function() {
                const id = $(this).data('id');
                let count = $('#add-pertanyaan').data('count');
                count = count - 1;
                $('#add-pertanyaan').data('count', count).attr('data-count', count);
                if (id === 0) {
                    $(this).closest('.soal-item').remove();
                    return;
                }
                Swal.fire({
                    title: 'Yakin hapus Soal?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '/kuis/delete-soal/' + id,
                            method: 'POST',
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
        </script>
    </body>
@endsection
