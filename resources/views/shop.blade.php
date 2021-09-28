@extends('layouts.main')

@section('title', 'Shop')

@section('css')
<style>
    div[data-dropdown].active > div {
        opacity: 1;
        pointer-events: auto;
        transform: translateY(0);
    }
</style>
@endsection

@section('content')
    <div class="flex flex-col md:flex-row md:items-center justify-between mx-7 md:mx-16 mt-14 text-dblue">
        <div class="grid grid-cols-3 justify-items-center gap-y-2.5 md:block">
            <a href="{{ route('shop.index') }}" class="hover:bg-opacity-10 p-2 rounded transition duration-300 hover:bg-gray-400 {{ !request()->category ? 'underline bg-gray-400 bg-opacity-10' : '' }}">All Products</a>
            @foreach ($categories as $category)
                <a href="{{ route('shop.index', ['sort' => request()->sort, 'category' => $category->slug]) }}" class="hover:bg-opacity-10 p-2 rounded transition duration-300 hover:bg-gray-400 {{ setActiveCategory($category->slug) }}">{{ $category->name }}</a>
            @endforeach
        </div>

        {{-- Dropdown Container --}}
        <div class="relative ml-2.5 md:ml-0" data-dropdown>
            <button class="mt-5 md:mt-0 pl-2 md:pl-0" data-dropdown-button>
                <div class="inline-flex items-center bg-dblue text-white px-2 py-1.5 rounded cursor-pointer pointer-events-none" id="filter">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                    </svg>
    
                    <span>filter</span>
                </div>
            </button>

            {{-- Dropdown Menu --}}
            <div class="opacity-0 pointer-events-none absolute top-xfull border border-cgray -left-5 p-2.5 w-max leading-7 transform -translate-y-7 transition-all shadow-lg bg-white rounded-md">
                <span style="position: absolute; top: -20px; left: 50px; border-top: transparent; border-right: transparent; border-left: transparent; border-bottom: #B2B1B9;border-width: 10px; border-style: solid;"></span>
                <div>
                    <p class="font-semibold">Price</p>
                    <div class="mx-3">
                        <a href="{{ route('shop.index', ['category' => request()->category, 'sort' => 'high_low']) }}" class="hover:underline cursor-pointer">High To Low</a>
                        
                        <a href="{{ route('shop.index', ['category' => request()->category, 'sort' => 'low_high']) }}" class="block hover:underline cursor-pointer">Low To High</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <x-card :cardItems="$products" margin="mt-10 mx-7 md:mx-16"></x-card>
@endsection

@section('js')
    <script>
        document.addEventListener("click", e => {
            const isDropdownButton = e.target.matches("[data-dropdown-button]")
            if (!isDropdownButton && e.target.closest("[data-dropdown]") != null) return

            let currentDropdown
            if (isDropdownButton) {
                currentDropdown = e.target.closest("[data-dropdown]")
                currentDropdown.classList.toggle("active")
            }

            document.querySelectorAll("[data-dropdown].active").forEach(dropdown => {
                if (dropdown === currentDropdown) return
                dropdown.classList.remove("active")
            })
        })
    </script>
@endsection