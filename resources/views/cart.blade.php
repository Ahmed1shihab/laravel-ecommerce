@extends('layouts.main')

@section('title', 'Cart 🛒')

@section('content')
    <div class="md:mx-16 mx-10">
        <p class="text-2xl font-semibold mt-12">Cart</p>
        
        <div class="mt-8">
            @if (Cart::instance('default')->count() > 0)
                <table class="w-full text-dblue">
                    <thead class="border-b-2 border-dblue text-sm font-normal md:font-bold md:text-lg">
                        <tr class="text-center">
                            <td>Product</td>
                            <td>Quantity</td>
                            <td>Price</td>
                            <td></td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach (Cart::instance('default')->content() as $item)
                            <tr class="border-b border-cgray">
                                <td class="flex md:flex-row flex-col mt-5 mb-3 pl-5">
                                    <div class="bg-white shadow-md md:w-auto w-36">
                                        <a href="{{ route('shop.show', ['slug' => $item->model->slug]) }}">
                                            <img src="{{ asset('images/' . $item->model->image) }}" alt="product" width="250" style="max-height: 300px; object-fit: contain; padding: 5px;" loading="lazy">
                                        </a>
                                    </div>
                                    <div class="flex flex-col md:text-xl text-base mt-7 md:ml-5">
                                        <a href="{{ route('shop.show', ['slug' => $item->model->slug]) }}" class="hover:underline">{{ $item->name }}</a>
                                        <span class="mt-3 text-base">{{ presentPrice($item->price) }}</span>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <select id="quantity" name="quantity" data-productQuantity="{{ $item->model->quantity }}" data-id="{{ $item->rowId }}">
                                        @for ($i = 1; $i <= 5; $i++)
                                            <option {{ $item->qty == $i ? "selected" : "" }}>{{ $i }}</option>
                                        @endfor
                                    </select>
                                </td>
                                <td class="text-center text-sm md:text-base">
                                    {{ presentPrice($item->subtotal) }}
                                </td>
                                <td>
                                    <!--Delete Item From Cart  -->
                                    <form action="{{ route('cart.destroy', $item->rowId) }}" method="POST">
                                        {{ csrf_field() }}
                                        {{ method_field('DELETE') }}

                                        <button type="submit">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="md:h-9 md:w-9 h-7 w-7 hover:bg-gray-400 hover:bg-opacity-20 transition duration-300 rounded-full p-1.5 ml-4 cursor-pointer" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </form>

                                    <form action="{{ route('cart.switchToSaveForLater', $item->rowId) }}" method="POST">
                                        {{ csrf_field() }}

                                        <button type="submit">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="md:h-9 md:w-9 h-7 w-7 mt-3 hover:bg-gray-400 hover:bg-opacity-20 transition duration-300 rounded-full p-1.5 ml-4 cursor-pointer" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z" />
                                            </svg>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="flex flex-col justify-between bg-white text-dblue rounded p-4 shadow-xl mt-5 mx-5">
                    <div class="flex justify-between items-center border-b border-cgray mb-3 pb-2">
                        <p>Subtotal</p>
                        <p>{{ presentPrice(Cart::subtotal()) }}</p>
                    </div>
                    @if (session()->has('coupon'))
                        <div class="flex justify-between items-center border-b border-cgray mb-3 pb-2">
                            <div class="flex justify-center items-center">
                                <form action="{{ route('coupon.destory') }}" method="post" class="inline-block">
                                    {{ csrf_field() }}
                                    {{ method_field('DELETE') }}
    
                                    <button type="submit" class="flex items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mb-1 hover:text-red-500 transition-colors cursor-pointer" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                    {{-- <button type="submit" class="bg-dblue text-white text-xs p-1 rounded">Remove Coupon</button> --}}
                                </form>
                                <p class="inline-block">Code ({{ session()->get('coupon')['code'] }})</p>
                            </div>
                            <p>-{{ presentPrice($discount) }}</p>
                        </div>
                        <div class="flex justify-between items-center border-b border-cgray mb-3 pb-2">
                            <p>New Subtotal</p>
                            <p>{{ presentPrice($newSubtotal) }}</p>
                        </div>
                    @endif
                    <div class="flex justify-between items-center border-b border-cgray mb-3 pb-2">
                        <p>Tax({{ config('cart.tax') }}%)</p>
                        <p>{{ presentPrice($newTax) }}</p>
                    </div>
                    <div class="flex justify-between items-center font-semibold text-lg">
                        <p>Total</p>
                        <p>{{ presentPrice($newTotal) }}</p>
                    </div>
                </div>

                <div class="flex flex-col gap-y-2.5 md:flex-row justify-between items-center mt-5 mx-5">
                    @if (! session()->has('coupon'))
                        <div class="mr-4">
                            <p>Add A Copoun 🤓</p>
                            <form action="{{ route('coupon.store') }}" method="POST" class="mt-1.5">
                                {{ csrf_field() }}
                                
                                <input type="text" name="code" class="rounded border-r-0 text-sm">
                                <button  style="height: 38px" class="transform -translate-x-2 bg-dblue text-white inline-flex items-center justify-center p-2 text-sm rounded-tr rounded-br">Apply</button>
                            </form>
                        </div>
                    
                    @else
                        <div></div>
                    @endif
                    <a href="{{ route('checkout.index') }}" class="bg-dblue text-white rounded text-sm md:text-base p-3 hover:scale-105 transform transition-transform">
                        Process To Checkout
                    </a>
                </div>
            @else
                <div class="text-dblue font-semibold ml-5">
                    <p>Cart Is Empty 🙁</p>

                    <a href="{{ route('shop.index') }}" class="mt-3 bg-gray-300 hover:bg-opacity-50 transition duration-300 p-2 rounded inline-block">Go To Shop Page</a>
                </div>
            @endif
        </div>

        <p class="text-2xl font-semibold mt-16">Saved For Later</p>

        <div class="mt-8">
            @if (Cart::instance('saveForLater')->count() > 0)
                <table class="w-full text-dblue">
                    <thead class="border-b-2 border-dblue text-lg">
                        <tr>
                            <td class="font-bold pl-16">Product</td>
                            <td></td>
                        </tr>
                    </thead>
                    <tbody class="border-b border-cgray">
                        @foreach (Cart::instance('saveForLater')->content() as $item)
                            <tr class="border-b border-cgray">
                                <td class="flex flex-row mt-5 mb-3 pl-5">
                                    <div class="bg-white shadow-md">
                                        <a href="{{ route('shop.show', $item->model->slug) }}">
                                            <img src="{{ asset('images/' . $item->model->image) }}" alt="product" width="250" style="max-height: 300px; object-fit: contain; padding: 5px" loading="lazy">
                                        </a>
                                    </div>
                                    <div class="flex flex-col text-xl mt-7 ml-5">
                                        <a href="{{ route('shop.show', $item->model->slug) }}" class="hover:underline">{{ $item->name }}</a>
                                        <span class="mt-3 text-base">{{ presentPrice($item->price) }}</span>
                                    </div>
                                </td>
                                <td>
                                    <form action="{{ route('saveForLater.destroy', $item->rowId) }}" method="POST">
                                        {{ csrf_field() }}
                                        {{ method_field('DELETE') }}
                                        
                                        <button type="submit">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-9 w-9 hover:bg-gray-400 hover:bg-opacity-20 transition duration-300 rounded-full p-1.5 ml-4 cursor-pointer" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </form>
                                    <form action="{{ route('saveForLater.switchToCart', $item->rowId) }}" method="POST">
                                        {{ csrf_field() }}

                                        <button type="submit">
                                            <img src="{{ asset('images/add-to-cart.svg') }}" alt="icon" class="h-10 w-10 mt-3 hover:bg-gray-400 hover:bg-opacity-20 transition duration-300 rounded-full p-1.5 ml-4 cursor-pointer">
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="text-dblue font-semibold ml-5">
                    <p>You have no items Saved for Later.</p>
                </div>
            @endif
        </div>

        @include('partials.might-also-like')
    </div>
@endsection

@section('js')
    <script src="{{ asset('js/app.js') }}"></script>
    <script>
        (function () {
            const quantity = Array.from(document.querySelectorAll("#quantity"));

            
            quantity.forEach((element) => {
                element.addEventListener("change", () => {
                    const id = element.getAttribute("data-id");
                    const productQuantity = element.getAttribute("data-productQuantity");

                    axios
                        .patch(`/cart/${id}`, {
                            quantity: element.value,
                            productQuantity: productQuantity,
                        })
                        .then(function (response) {
                            // console.log(response)
                            window.location.href = "{{ route('cart.index') }}";
                        })
                        .catch(function (error) {
                            window.location.href = "{{ route('cart.index') }}";
                        });
                    
                });
            });
        })();
    </script>
@endsection