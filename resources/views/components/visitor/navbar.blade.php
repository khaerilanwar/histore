<nav class="bg-blue-600 border-gray-200 ">
    <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">
        <a href="#" class="flex items-center space-x-3 rtl:space-x-reverse">
            <img src="{{ asset('img/logo.png') }}" class="h-8" alt="Flowbite Logo" />
            <span class="self-center text-white text-2xl font-semibold whitespace-nowrap ">HiStore!</span>
        </a>
        <div class="flex md:order-2 gap-2">
            <button type="button" data-collapse-toggle="navbar-search" aria-controls="navbar-search"
                aria-expanded="false" class="md:hidden text-gray-50 ">
                <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 20 20">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                </svg>
                <span class="sr-only">Search</span>
            </button>
            <form action="/{{ Request::is('/') ? 'products' : Request::path() }}" method="get">
                <div class="relative hidden md:block">
                    <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                        <svg class="w-4 h-4 text-gray-500 " aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                            fill="none" viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                        </svg>
                        <span class="sr-only">Search icon</span>
                    </div>
                    <input type="text" name="s" value="{{ Request::query('s') }}" id="search-navbar"
                        class="block w-full p-2 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 "
                        placeholder="Search...">
                </div>
            </form>
            <button data-collapse-toggle="navbar-search" type="button"
                class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-gray-50 rounded-lg md:hidden"
                aria-controls="navbar-search" aria-expanded="false">
                <span class="sr-only">Open main menu</span>
                <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 17 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M1 1h15M1 7h15M1 13h15" />
                </svg>
            </button>
        </div>
        <div class="items-center justify-between hidden w-full md:flex md:w-auto md:order-1" id="navbar-search">
            <form action="/{{ Request::is('/') ? 'products' : Request::path() }}" method="get">
                <div class="relative mt-3 md:hidden">
                    <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                        <svg class="w-4 h-4 text-gray-500 " aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                            fill="none" viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                        </svg>
                    </div>
                    <input type="text" name="s" value="{{ Request::query('s') }}" id="search-navbar"
                        class="block w-full p-2 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 "
                        placeholder="Search...">
                </div>
            </form>

            @php
                $activeClass = 'block py-2 px-3 text-white bg-blue-700 rounded md:bg-transparent md:text-white md:p-0';
                $inActiveClass =
                    'block py-2 px-3 text-gray-900 rounded hover:bg-gray-100 md:text-gray-300 md:hover:bg-transparent md:hover:text-white md:p-0';
            @endphp

            <ul
                class="flex flex-col p-4 md:p-0 mt-4 font-medium border border-gray-100 rounded-lg bg-gray-50 md:space-x-8 rtl:space-x-reverse md:flex-row md:mt-0 md:border-0 md:bg-blue-600">
                <li>
                    <a href="/" class="{{ Request::is('/') ? $activeClass : $inActiveClass }}"
                        aria-current="page">Home</a>
                </li>
                <li>
                    <a href="/products" class="{{ Request::is('products') ? $activeClass : $inActiveClass }}"
                        aria-current="page">All Products</a>
                </li>
                <li>
                    <button id="mega-menu-full-dropdown-button" data-collapse-toggle="mega-menu-full-dropdown"
                        class="flex items-center gap-1 justify-between w-full {{ Request::is('products/category/*') ? $activeClass : $inActiveClass }}">Categories
                        <ion-icon name="chevron-down" size="small"></ion-icon>
                    </button>
                </li>
                <li>
                    <a href="/branch" class="{{ Request::is('branch') ? $activeClass : $inActiveClass }}">Branch</a>
                </li>
                <li>
                    <a href="/about" class="{{ Request::is('about') ? $activeClass : $inActiveClass }}">About</a>
                </li>
            </ul>
        </div>
    </div>

    @php
        $countCategory = $categories->count();
        $perCategory = ceil($countCategory / 4);
    @endphp
    <div id="mega-menu-full-dropdown" class="hidden mt-1 border-gray-200 shadow-sm bg-gray-50 md:bg-white border-y">
        <div
            class="grid max-w-screen-xl px-4 py-5 mx-auto text-gray-900 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 md:px-6">

            @foreach ($categories as $category)
                @if ($loop->iteration % $perCategory == 1)
                    <ul>
                @endif
                <li>
                    <a href="/products/category/{{ $category->slug }}"
                        class="block p-3 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700">
                        <div class="font-semibold">{{ $category->name }}</div>
                        <span class="text-sm text-gray-500 dark:text-gray-400">{{ $category->slogan }}</span>
                    </a>
                </li>
                @if ($loop->iteration % $perCategory == 0 || $loop->last)
                    </ul>
                @endif
            @endforeach
        </div>
    </div>
</nav>
