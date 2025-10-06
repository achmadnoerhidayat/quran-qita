@extends('partial.index')

@section('content')

    <body>
        <div class="relative">
            <section class="bg-white-50 dark:bg-gray-100 h-screen">
                <div class="flex flex-col lg:flex-row my-2 mx-2">
                    <div class="w-full lg:w-1/2 flex flex-col items-center justify-center lg:h-screen lg:py-0">
                        <img src="/image/logo-login.svg" class="w-3/4 md:w-[350px]" />
                    </div>
                    <div class="w-full lg:w-1/2 flex flex-col justify-center lg:h-screen lg:py-0">
                        <div
                            class="bg-white rounded-lg shadow dark:border md:mt-0 xl:p-0 dark:bg-white-100 dark:border-gray-700">
                            <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
                                <h1
                                    class="text-xl font-bold leading-tight tracking-tight text-black-100 md:text-2xl dark:text-black mb-1">
                                    Masuk
                                </h1>
                                <span
                                    class="text-sm leading-tight tracking-tight text-black-100 md:text-sm dark:text-black">
                                    Masuk dengan akun yang telah Kamu daftarkan.
                                </span>
                                <form class="space-y-4 md:space-y-6 mt-3" method="POST" action="{{ route('login') }}">
                                    @csrf
                                    <div>
                                        <label for="email"
                                            class="block mb-2 text-sm font-medium text-black-100 dark:text-black">Email</label>
                                        <input type="email" name="email" id="email"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-white-100 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                            placeholder="name@company.com" />
                                    </div>
                                    <div>
                                        <label for="password"
                                            class="block mb-2 text-sm font-medium text-black-100 dark:text-black">Password</label>
                                        <input type="password" name="password"\ id="password" placeholder="••••••••"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-white-100 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray dark:focus:ring-blue-500 dark:focus:border-blue-500" />
                                    </div>
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-start">
                                            <div class="flex items-center h-5">
                                                <input id="remember" aria-describedby="remember" type="checkbox"
                                                    class="w-4 h-4 border border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-primary-300 dark:bg-gray-700 dark:border-gray-600 dark:focus:ring-primary-600 dark:ring-offset-gray-800" />
                                            </div>
                                            <div class="ml-3 text-sm">
                                                <label for="remember" class="text-gray-500 dark:text-gray-300">Remember
                                                    me</label>
                                            </div>
                                        </div>
                                        <a href="#"
                                            class="text-sm font-medium text-primary-600 hover:underline dark:text-primary-500">Forgot
                                            password?</a>
                                    </div>
                                    <button type="submit"
                                        class="w-full border border-gray-300 text-black bg-white from-purple-600 to-blue-500 hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center mb-2 cursor-pointe">
                                        Login
                                    </button>
                                    <div class="flex justify-center text-black-100 md:text-sm dark:text-black">
                                        <span>Belum memiliki akun? </span>
                                        <nuxt-link class="pl-1" to="/register">Daftar</nuxt-link>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
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
        <script>
            function closeErrorModal() {
                document.getElementById('errorModal').classList.add('hidden');
            }
        </script>
    </body>
@endsection
