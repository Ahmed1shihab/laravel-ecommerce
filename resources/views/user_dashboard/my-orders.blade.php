<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('My Orders') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @forelse ($orders as $order)
                        <div class="flex items-center justify-between bg-sky p-7 mt-4">

                            <div class="flex items-center">
                                <div class="text-center">
                                    <div class="font-semibold">Order Placed</div>
                                    <div>{{ presentDate($order->created_at) }}</div>
                                </div>
                                <div class="mx-6 text-center">
                                    <div class="font-semibold">Order ID</div>
                                    <div>{{ $order->id }}</div>
                                </div>
                                <div class="text-center">
                                    <div class="font-semibold">Total</div>
                                    <div>{{ presentPrice($order->billing_total) }}</div>
                                </div>
                            </div>

                            <div>
                                <a href="{{ route('orders.show', $order->id) }}" class="hover:text-cgray transition-colors">Order Details</a>
                                <span> | </span>
                                <a href="" class="hover:text-cgray transition-colors">Invoice</a>
                            </div>

                        </div>

                        <div class="bg-white text-dblue shadow">
                            @foreach ($order->products as $product)
                                <div class="flex items-center border-b-2 border-gray-200">
                                    <div class="bg-white border-r-2 border-gray-200">
                                        <img src="{{ asset('storage/' . $product->image) }}" alt="" class="w-80 object-contain p-3" style="max-height: 320px">
                                    </div>
                                    <div class="ml-10 text-lg">
                                        <a href="{{ route('shop.show', $product->slug) }}" class="hover:underline font-semibold text-xl">{{ $product->name }}</a>
                                        <p class="text-base mt-1">{{ presentPrice($product->price) }}</p>
                                        <p class="text-base mt-1">Quantity: {{ $product->pivot->quantity }}</p>
                                    </div>
                                </div>
                                {{-- <div class="text-center mt-5 pb-5 text-lg font-light">
                                    <a href="{{ route('orders.show', $order->id) }}" class="bg-transparent border border-dblue hover:bg-dblue hover:text-white transition-all px-4 py-1 rounded-md">
                                        More Details 🔍
                                    </a>
                                </div> --}}
                            @endforeach
                        </div>

                    @empty

                    <div class="text-dblue font-semibold text-lg">There is no order on this account 😕</div>
                    <a href="{{ route('shop.index') }}" class="mt-3 bg-gray-300 hover:bg-opacity-50 transition duration-300 p-2 rounded inline-block">Go To Shop Page</a>

                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>