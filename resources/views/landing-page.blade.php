@extends('layouts.main')

@section('title', 'Home')

@section('content')
    <!-- Hero Image -->
    <div>
        <div class="relative">
            <img
                src="{{ asset('images/laptop.jpg') }}"
                alt="product"
                class="hero-img active"
                loading="lazy"
            />
            <img
                src="{{ asset('images/watch.jpg') }}"
                alt="product"
                class="hero-img"
                loading="lazy"
            />
            <img
                src="{{ asset('images/camera.jpg') }}"
                alt="product"
                class="hero-img"
                loading="lazy"
            />
            <div class="w-full absolute top-1/2 transform -translate-y-1/2 flex items-center justify-between px-6">
                <div class="bg-dblue text-white shadow-md rounded-full cursor-pointer p-2 text-center" id="previous-btn">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" /></svg>
                </div>
                <div class="bg-dblue text-white shadow-md rounded-full cursor-pointer p-2 text-center" id="next-btn">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                </div>
            </div>
        </div>

        <!-- Image Navigation -->
        <div
            class="flex justify-center flex-row mt-4"
            id="image-pagination"
        >
            <span
                class="w-6 h-0.5 inline-block cursor-pointer active"
                data-index="1"
            ></span>
            <span
                class="w-6 h-0.5 inline-block mx-2 cursor-pointer"
                data-index="2"
            ></span>
            <span
                class="w-6 h-0.5 inline-block cursor-pointer"
                data-index="3"
            ></span>
        </div>
    </div>

    <!-- Most Popular Products Section -->
    <div class="mt-20 mx-4 flex flex-col items-center md:block">
        <h1 class="text-3xl md:text-left md:ml-10">Featured Products</h1>
        <!-- Card -->
        <x-card :cardItems="$products" margin="mt-10 mx-10"></x-card>
    </div>

@endsection

@section('js')
    <script>
        const images = Array.from(document.querySelectorAll(".hero-img"));
        const imagePagination = Array.from(document.querySelectorAll("#image-pagination span"));
        const nextButton = document.getElementById('next-btn');
        const previousButton = document.getElementById('previous-btn');
        let currentImage = 1;

        function removeActiveClasses() {
            images.forEach((image) => {
                image.classList.remove("active");
            });

            imagePagination.forEach((span) => {
                span.classList.remove("active");
            });
        }

        setInterval(() => {
            currentImage++;
            cheacker();
        }, 5000);

        nextButton.addEventListener('click', () => {
            currentImage++;
            cheacker();
        });

        previousButton.addEventListener('click', () => {
            currentImage--;
            cheacker();
        });

        imagePagination.forEach((el) => {
            el.addEventListener("click", () => {
                const index = el.getAttribute("data-index");
                currentImage = index;
                cheacker();
            });
        });

        function cheacker() {
            removeActiveClasses();

            currentImage > 3 ? (currentImage = 1) : (currentImage = currentImage);
            currentImage <= 0 ? (currentImage = 3) : (currentImage = currentImage);
            images[currentImage - 1].classList.add("active");
            imagePagination[currentImage - 1].classList.add("active");
        }
    </script>
@endsection