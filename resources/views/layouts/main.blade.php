<!DOCTYPE html>
<html lang="en" class="box-border">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link rel="stylesheet" href="{{ asset('css/algolia.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/instantsearch.js@2.6.0/dist/instantsearch.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/instantsearch.js@2.6.0/dist/instantsearch-theme-algolia.min.css">
    <title>Ecommerce | @yield('title')</title>

    @yield('css')

    <style>
        @media (max-width: 768px) {
            #burger.open span:first-of-type {
                transform: rotate(45deg);
            }
            #burger.open span:nth-of-type(2) {
                display: none;
            }
            #burger.open span:last-of-type {
                transform: rotate(-45deg);
            }
            #mobile-stuff.open {
                display: flex;
                flex-direction: column;
                align-items: center;
                gap: 15px;
                z-index: 49;
                width: 100vh;
                background: white;
                left: 50%;
                transform: translateX(-50%);
                margin-top: 450px;
                padding: 1000px 0;
            }
            #mobile-stuff.open > div:first-of-type {
                display: block;
            }
            #mobile-stuff.open > div:last-of-type {
                display: block;
            }
        }
    </style>
</head>
<body class="font-body bg-sky overflow-x-hidden">
    <header
            class="
                text-dblue
                flex flex-row
                items-center
                justify-between
                md:px-3.5
                lg:px-16
                px-5
                sm:px-10
                py-5
            "
        >
        <!-- Logo -->
        <a href="/" class="md:w-56 relative z-50">
            <img
                src="{{ asset('images/logo.svg') }}"
                alt="Ecommerce Logo"
                class="w-36 sm:w-auto md:w-52 lg:w-auto"
            />
        </a>

        <div class="absolute md:static md:flex md:items-center" id="mobile-stuff">
            <!-- Navigation Links -->
            <div class="hidden md:block md:ml-0 lg-40">
                {{-- font-size: 16px; --}}
                <ul class="flex md:flex-row flex-col gap-y-2.5 md:gap-0 items-center text-lg">
                    <li>
                        {{-- margin-right: 15px; --}}
                        <a href="{{ route('landing-page') }}" class="hover:underline md:mr-5">Home</a>
                    </li>
                    <li><a href="{{ route('shop.index') }}" class="hover:underline">Shop</a></li>
                </ul>
            </div>
    
            <!-- Search With Algolia -->
            <div class="aa-input-container hidden md:inline-block relative md:ml-7 " id="aa-input-container">
                <input type="search" id="aa-search-input" class="aa-input-search ml-10 bg-white md:border-none rounded shadow-md focus:shadow-lg md:w-64 xl:w-96 lg:w-80 placeholder-dblue text-sm" placeholder="Search with algolia..." name="search"
                    autocomplete="off" />
                <div class="bg-dblue text-white absolute top-0 right-0 h-full rounded-tr rounded-br flex items-center justify-center w-8">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
            </div>
        </div>

        <div class="flex items-center gap-x-2.5 md:gap-x-0 text-base md:text-lg">
            @guest
                <a href="{{ route('login') }}" class="hover:underline ml-0 sm:ml-16 md:ml-0 ">
                    Log in
                </a>
            @else
                <a href="{{ route('dashboard') }}" class="hover:underline ml-0 xl:ml-20 sm:ml-16">
                    Dashboard
                </a>
            @endguest
    
            <!-- Cart -->
            {{-- margin-left: 30px; --}}
            <a href="{{ route('cart.index') }}" class="inline-block md:ml-0  xl:ml-16 relative">
                @if (Cart::instance('default')->count() > 0)
                    <span class="absolute -top-1 -right-2 bg-white text-dblue border border-dblue rounded-full text-sm text-center w-5 h-5">{{ Cart::instance('default')->count() }}</span>
                @endif
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-6 md:h-8 w-6 md:w-8"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"
                    />
                </svg>
            </a>
        </div>

        <!-- Mobile Burger -->
        <div class="cursor-pointer md:hidden relative z-50" id="burger">
            <span class="w-5 h-0.5 bg-dblue block transition-transform" style="transform-origin: 7px 1px;"></span>
            <span class="w-5 h-0.5 bg-dblue block my-1" style="transform-origin: 6px 1px;"></span>
            <span class="w-5 h-0.5 bg-dblue block transition-transform" style="transform-origin: 9px 3px;"></span>
        </div>

    </header>

    {{-- Errors and Success Messages --}}
    <div class="mt-3 mx-16">
        @if (session()->has('success_message'))
            <div class="flex bg-green-100 rounded-lg p-4 mb-4">
                <svg class="w-5 h-5 text-green-700" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
                <p class="ml-3 text-sm text-green-700">
                    {{ session()->get('success_message'); }}
                </p>
            </div>
        @endif


        @if(count($errors) > 0)
            <div class="flex flex-col bg-red-100 rounded-lg p-4 mb-4">
                @foreach ($errors->all() as $error)
                    <div class="flex items-center mt-1.5">
                        <svg class="w-5 h-5 text-red-700" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
                        <p class="ml-3 text-sm text-red-700">
                            {{ $error }}
                        </p>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    
    
    @yield('content')

    {{-- Footer --}}
    <footer class="mt-10">
        <div
            class="
                bg-dblue
                flex
                justify-center
                py-3
                text-white text-center text-sm
            "
        >
            made with
            <svg
                xmlns="http://www.w3.org/2000/svg"
                class="h-6 w-6 px-0.5 -mt-0.5"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"
                />
            </svg>
            <span class="whitespace-pre">By </span>
            <a
                href="https://instagram.com/7nv__"
                class="hover:text-blue-200 transition-colors"
                target="_blank"
            >
                Ahmed</a
            >
        </div>
    </footer>

    {{-- JavaScript --}}
    <script src="https://cdn.jsdelivr.net/algoliasearch/3/algoliasearch.min.js"></script>
    <script src="https://cdn.jsdelivr.net/autocomplete.js/0/autocomplete.min.js"></script>
    <script src="{{ asset('js/algolia.js') }}"></script>
    <script src="{{ asset('js/script.js') }}"></script>
    @yield('js')
</body>
</html>