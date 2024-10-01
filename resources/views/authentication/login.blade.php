<x-authentication.layout>
    <section class="bg-gray-50">
        <div class="flex flex-col items-center justify-center px-6 py-8 mx-auto md:h-screen lg:py-0">
            <a href="#" class="flex items-center mb-6 text-2xl lg:text-3xl font-semibold text-gray-900 ">
                <img class="w-8 h-8 mr-2" src="{{ asset('img/logo.png') }}" alt="logo">
                HiStore!
            </a>
            <div class="w-full bg-white rounded-lg shadow md:mt-0 sm:max-w-md xl:p-0 ">
                <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
                    <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl ">
                        Sign in to your account
                    </h1>
                    <form class="space-y-4 md:space-y-6" action="/authentication" method="POST">
                        @csrf

                        <div>
                            <x-label for="nik" input-name="nik">
                                NIK
                            </x-label>
                            <x-input type="text" name="nik" id="nik" placeholder="administrator"
                                value="{{ request()->old('nik') }}" autofocus />
                        </div>

                        <div>
                            <x-label for="password" input-name="password">
                                Password
                            </x-label>
                            <x-input type="password" name="password" id="password" placeholder="••••••••" />
                        </div>
                        <div class="flex items-center justify-between">
                            <a href="#" class="text-sm font-medium text-blue-600 hover:underline ">Forgot
                                password?</a>
                        </div>
                        <button type="submit"
                            class="w-full text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center ">Sign
                            in</button>
                    </form>
                </div>
            </div>
        </div>
    </section>
</x-authentication.layout>
