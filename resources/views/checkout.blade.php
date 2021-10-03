@extends('layouts.main')

@section('title', 'Checkout')

@section('content')
    <div class="md:mx-16 mx-10">
        <div class="grid md:grid-cols-2 gap-8 mt-5">
            <div>
                <h1 class="text-2xl font-semibold text-dblue">Billing Details</h1>

                <div class="mt-5 ml-5">
                    <form action="{{ route('checkout.store') }}" method="post" id="payment-form">
                        {{ csrf_field() }}
    
                        <div class="block w-10/12">
                            <label for="email">Email</label>
                            <input type="email" name="email" id="email" value="{{ $email ?? old('email') }}" {{ $email ? 'readonly style=background-color:#E9ECEF' : '' }} class="block w-full {{ $email ? 'focus:border-dblue' : '' }} shadow border-l-2 border-r-0 border-t-0 border-b-0 border-dblue focus:ring-0 focus:shadow-md text-sm">
                        </div>

                        <div class="mt-3 w-10/12">
                            <label for="name">Name</label>
                            <input type="text" name="name" id="name" value="{{ old('name') }}" class="block w-full  shadow border-l-2 border-r-0 border-t-0 border-b-0 border-dblue focus:ring-0 focus:shadow-md text-sm">
                        </div>

                        <div class="mt-3 w-10/12">
                            <label for="addres">Addres</label>
                            <input type="text" name="address" id="address" value="{{ old('addres') }}" class="block w-full  shadow border-l-2 border-r-0 border-t-0 border-b-0 border-dblue focus:ring-0 focus:shadow-md text-sm">
                        </div>

                        <div class="mt-3 w-10/12">
                            <label for="phone">Phone</label>
                            <input type="tel" name="phone" id="phone" value="{{ old('phone') }}" class="block w-full  shadow border-l-2 border-r-0 border-t-0 border-b-0 border-dblue focus:ring-0 focus:shadow-md text-sm">
                        </div>

                        <p class="text-xl text-dblue mt-4 font-semibold">Payment Details</p>

                        <div class="mt-3 w-10/12">
                            <label for="name_on_card">Name on Card</label>
                            <input type="text" name="name_on_card" id="name_on_card" value="{{ old('name_on_card') }}" class="block w-full  shadow border-l-2 border-r-0 border-t-0 border-b-0 border-dblue focus:ring-0 focus:shadow-md text-sm">
                        </div>
                        <div class="mt-3 mb-3 w-10/12">
                            <label for="">Credit or debit card</label>
                            <div id="card-element" class="w-full py-3 px-3.5 shadow border-l-2 border-r-0 border-t-0 border-b-0 border-dblue focus:shadow-md focus:border-blue-600"></div>
                            <div id="card-errors" role="alert" class="text-red-600"></div>
                        </div>
                        
                        <button type="submit" id="complete-order" class="bg-dblue text-white tracking-wide disabled:bg-opacity-75 disabled:cursor-not-allowed rounded-sm text-center shadow w-10/12 p-2 hover:shadow-lg transition-shadow">Complete Order</button>
                    </form>
                </div>
            </div>
            <div>
                <h1 class="text-2xl font-semibold text-dblue">Your Order</h1>
                <div class="flex flex-col justify-center w-11/12">
                    @foreach (Cart::instance('default')->content() as $item)
                        <div class="flex flex-col md:flex-row pt-1.5 pb-3.5 justify-between items-center mt-4 bg-white shadow">
        
                            <div class="flex flex-col md:flex-row text-center md:text-left justify-between items-center">
                                <img src="{{ asset('images/' . $item->model->image) }}" alt="prodcut" width="150" style="max-height: 200px; object-fit: contain; padding: 3px;">
        
                                <div class="flex flex-col justify-between ml-0 mt-1.5 md:mt-0 md:ml-4">
                                    <p class="font-semibold">{{ $item->name }}</p>
                                    <p class="text-sm mt-1.5">{{ \Illuminate\Support\Str::limit($item->model->details, 50) }}</p>
                                    <p class="text-sm mt-1.5">{{ presentPrice($item->price) }}</p>
                                </div>
                            </div>
                            
                            <div class="mr-0 mt-3.5 md:mt-0 md:mr-4 border border-dblue px-3 py-1 text-center">
                                {{ $item->qty }}
                            </div>
        
                        </div>
                    @endforeach

                    <div class="flex flex-col justify-between bg-white text-dblue rounded p-4 shadow-md mt-5">
                        <div class="flex justify-between items-center border-b border-cgray mb-3 pb-2">
                            <p>Subtotal</p>
                            <p>{{ presentPrice(Cart::subtotal()) }}</p>
                        </div>
                        @if (session()->has('coupon'))
                            <div class="flex justify-between items-center border-b border-cgray mb-3 pb-2">
                                <p class="inline-block">Code ({{ session()->get('coupon')['code'] }})</p>
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
                </div>

            </div>
        </div>
    </div>
@endsection

@section('js')
{{-- <script src="https://js.braintreegateway.com/web/dropin/1.13.0/js/dropin.min.js"></script> --}}
<script src="https://js.stripe.com/v3/"></script>

<script>
    (function(){
        // Create a Stripe client
        var stripe = Stripe('pk_test_51JamAgHe6XeSzDggJkb1vlzxtPJkrWSotVCZTULvrQ0GQ2eSOHmVGN9qKvSLm9Jb1nU7w5xgPVB9oubB6kctICm600eyyMRkPB');
        // Create an instance of Elements
        var elements = stripe.elements();
        // Custom styling can be passed to options when creating an Element.
        // (Note that this demo uses a wider set of styles than the guide below.)
        var style = {
            base: {
                color: '#32325d',
                lineHeight: '18px',
                fontFamily: 'Nunito, Helvetica Neue", Helvetica, sans-serif',
                fontSmoothing: 'antialiased',
                fontSize: '16px',
                '::placeholder': {
                    color: '#aab7c4'
                }
            },
            invalid: {
                color: '#fa755a',
                iconColor: '#fa755a'
            }
        };

        // Create an instance of the card Element
        var card = elements.create('card', {
            style: style,
            hidePostalCode: true
        });
        // Add an instance of the card Element into the `card-element` <div>
        card.mount('#card-element');

        // Handle real-time validation errors from the card Element.
        card.addEventListener('change', function(event) {
            var displayError = document.getElementById('card-errors');
            if (event.error) {
                displayError.textContent = event.error.message;
            } else {
                displayError.textContent = '';
            }
        });

        // Handle form submission
        var form = document.getElementById('payment-form');
        form.addEventListener('submit', function(event) {
            event.preventDefault();
            // Disable the submit button to prevent repeated clicks
            document.getElementById('complete-order').disabled = true;
            var options = {
                name: document.getElementById('name_on_card').value,
                address_line1: document.getElementById('address').value
            }
            stripe.createToken(card, options).then(function(result) {
                if (result.error) {
                    // Inform the user if there was an error
                    var errorElement = document.getElementById('card-errors');
                    errorElement.textContent = result.error.message;
                    // Enable the submit button
                    document.getElementById('complete-order').disabled = false;
                } else {
                    // Send the token to your server
                    stripeTokenHandler(result.token);
                }
            });
        });
        
        function stripeTokenHandler(token) {
            // Insert the token ID into the form so it gets submitted to the server
            var form = document.getElementById('payment-form');
            var hiddenInput = document.createElement('input');
            hiddenInput.setAttribute('type', 'hidden');
            hiddenInput.setAttribute('name', 'stripeToken');
            hiddenInput.setAttribute('value', token.id);
            form.appendChild(hiddenInput);

            // Submit the form
            form.submit();
        }

    })();
</script>
@endsection