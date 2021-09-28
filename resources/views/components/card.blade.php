@props(['margin', 'cardItems'])

<div class="grid grid-cols-1 gap-10 md:grid-cols-2 lg:grid-cols-3 lg:gap-x-2.5 2xl:gap-x-0 2xl:grid-cols-4 justify-items-center {{$margin}}">
    @forelse ($cardItems as $product)
        <div class="flex flex-col justify-between content-center bg-white rounded shadow hover:shadow-lg transition-shadow p-5" style="max-width: 20rem">
            <div class="flex justify-center">
                <a href="{{ route('shop.show', ['slug' => $product->slug]) }}">
                    <img
                        src="{{ asset('storage/' . $product->image) }}"
                        alt="{{ $product->name }}"
                        width="250"
                        class="object-contain"
                        style="height: 200px;"
                    />
                </a>
            </div>

            <!-- Product Name And Description -->
            <div class="text-center">
                <a href="{{ route('shop.show', ['slug' => $product->slug]) }}">
                    <p class="text-lg mt-2.5 hover:underline">
                        {{ $product->name }}
                    </p>
                </a>
                <p class="font-light mt-1 text-sm leading-6 text-dblue px-2">
                    {{ \Illuminate\Support\Str::limit($product->details, 75) }}
                </p>
            </div>

            <!-- STARS -->
            <div class="mt-6 flex items-center justify-center">
                {{-- <div class="flex">
                    @for ($i = 0; $i < 5; $i++)
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="h-6 w-6 text-yellow-400"
                            viewBox="0 0 20 20"
                            fill="currentColor"
                        >
                            <path
                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"
                            />
                        </svg>
                    @endfor
                </div> --}}
                {{-- <a href="{{ route('cart.store', $product->slug) }}" class="bg-dblue text-white text-sm font-light rounded-md p-2 hover:bg-gray-800 transition duration-300">More Details 🧾</a> --}}

                {{-- <form action="{{ route('cart.store') }}" method="POST" id="add-to-cart">
                    @csrf

                    <input type="hidden" name="id" value="{{ $product->id }}">
                    <input type="hidden" name="name" value="{{ $product->name }}">
                    <input type="hidden" name="price" value="{{ $product->price }}">
                    <button type="submit" class="bg-dblue text-white text-sm font-light rounded-md p-2 hover:bg-gray-800 transition duration-300">Add To Cart 🛒</button>
                </form> --}}
                <p class="font-light text-right text-dblue">{{ presentPrice($product->price) }}</p>
            </div>
        </div>

    @empty
        <p class="text-dblue font-semibold text-lg">No Items Found 😓</p>
    @endforelse
</div>