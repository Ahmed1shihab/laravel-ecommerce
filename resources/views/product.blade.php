@extends('layouts.main')

@section('title', $product->name)

@section('content')
    <div class="mx-16">
        <div class="flex flex-col md:flex-row mt-10">
            <div class="bg-white shadow-lg flex-shrink-0 flex justify-center items-center">
                <img src="{{ asset('images/' . $product->image) }}" alt="product" width="390" class="object-contain p-1.5" style="max-height: 400px">
            </div>

            <div class="flex-grow-0 text-dblue mt-10 md:ml-20 md:block flex flex-col items-center">
                <p class="text-2xl text-center md:text-left md:text-3xl font-semibold">{!! $product->name !!}</p>
                <div class="flex items-center mt-1">
                    @for ($i = 0; $i < 5; $i++)
                        <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-5 w-5 text-yellow-400"
                        viewBox="0 0 20 20"
                        fill="currentColor"
                        >
                            <path
                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"
                            />
                        </svg>
                    @endfor

                    <span class="text-xs ml-1">72 preview</span>
                </div>
                <div class="mt-2 font-semibold text-base">
                    <span>{{ presentPrice($product->price) }}</span>
                </div>

                <p class="font-light md:font-normal mt-4 text-lg md:text-base md:w-3/5 text-center md:text-left">
                    {!! $product->description !!}
                </p>

                

                <div class="flex items-center mt-4">
                    <div class="bg-dblue rounded-full shadow-lg transform  hover:-translate-y-0.5 transition-transform text-white font-semibold inline-block px-2 py-2 text-sm w-28 text-center cursor-pointer">
                        <form action="{{ route('cart.store') }}" method="POST">
                            {{ csrf_field() }}
                            <input type="hidden" name="id" value="{{ $product->id }}">
                            <input type="hidden" name="name" value="{{ $product->name }}">
                            <input type="hidden" name="price" value="{{ $product->price }}">
                            <button type="submit">Add To Cart</button>
                        </form>
                    </div>
                    <div>
                        <form action="{{ route('saveForLater.index') }}" method="POST" class="flex">
                            {{ csrf_field() }}

                            <input type="hidden" name="id" value="{{ $product->id }}">
                            <input type="hidden" name="name" value="{{ $product->name }}">
                            <input type="hidden" name="price" value="{{ $product->price }}">

                            <button type="submit" class="tooltip-container relative">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-9 w-9 hover:bg-gray-400 hover:bg-opacity-20 transition duration-300 rounded-full p-1.5 ml-4 cursor-pointer" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z" />
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        @include('partials.might-also-like')

    </div>
@endsection