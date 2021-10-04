<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Order ID: {{ $order->id }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    <div class="flex flex-col sm:flex-row gap-y-2.5 p-3.5 sm:gap-0 items-center justify-between bg-sky sm:p-7 mt-4">
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
                            <a href="#" class="hover:underline transition-colors">Invoice</a>
                        </div>
                    </div>

                    <div class="bg-white text-dblue shadow p-5">
                        <div class="w-full md:w-96">
                            <div class="border-b-2 border-gray-400 mb-3 flex justify-between text-lg">
                                <span>Name:</span>
                                <span>{{ $order->billing_name }}</span>
                            </div>
                            <div class="border-b-2 border-gray-400 mb-3 flex justify-between text-lg">
                                <span>Address:</span>
                                <span>{{ $order->billing_address }}</span>
                            </div>
                            @if ($order->billing_discount_code !== null)
                                <div class="border-b-2 border-gray-400 mb-3 flex justify-between text-lg">
                                    <span>Discount Code:</span>
                                    <span>{{ $order->billing_discount_code }}</span>
                                </div>
                                <div class="border-b-2 border-gray-400 mb-3 flex justify-between text-lg">
                                    <span>Discount:</span>
                                    <span>{{ presentPrice($order->billing_discount) }}</span>
                                </div>
                            @endif
                            <div class="border-b-2 border-gray-400 mb-3 flex justify-between text-lg">
                                <span>Subtotal:</span>
                                <span>{{ presentPrice($order->billing_subtotal) }}</span>
                            </div>
                            <div class="border-b-2 border-gray-400 mb-3 flex justify-between text-lg">
                                <span>Tax:</span>
                                <span>{{ presentPrice($order->billing_tax) }}</span>
                            </div>
                            <div class="border-b-2 border-gray-400 flex justify-between text-lg">
                                <span>Total:</span>
                                <span>{{ presentPrice($order->billing_total) }}</span>
                            </div>
                        </div>
                    </div>

                    {{-- Order Items --}}
                    <div>
                        <div class="text-lg font-semibold bg-sky p-7 mt-6 ">
                            Order Items
                        </div>
    
                        <div class="bg-white text-dblue shadow">
                            @foreach ($order->products as $product)
                                <div class="flex items-center mb-5 border border-gray-200">
                                    <div class="bg-white border-r-2 border-gray-200">
                                        <img src="{{ asset('images/' . $product->image) }}" alt="" class="w-36 md:w-80 object-contain p-3" style="max-height: 320px">
                                    </div>
                                    <div class="ml-2.5 md:ml-10 text-lg">
                                        <a href="{{ route('shop.show', $product->slug) }}" class="hover:underline font-semibold text-xl">{{ $product->name }}</a>
                                        <p class="text-base md:mx-1">{{ presentPrice($product->price) }}</p>
                                        <p class="text-base">Quantity: {{ $product->pivot->quantity }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>