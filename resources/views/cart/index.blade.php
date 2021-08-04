<x-app-layout>
    <x-slot name="cssLink">
        <link rel='stylesheet' href='{{ asset('css/custom.css') }}'>
        <link rel='stylesheet' href='{{ asset('css/global.css') }}'>
        <link rel='stylesheet' href='{{ asset('css/cart.css') }}'>
    </x-slot>

    @if (session('delete_cart_success'))
        <x-alert type="success" :message="session('delete_cart_success')" />
    @endif

    <div class="d-flex justify-content-between mt-5 first-row mb-5">
        <div>
            <h1 class="fw-bold">My Cart</h1>
        </div>
        <div>
            <a href="{{ url('/products') }}">
                <button class="btn btn-primary">Continue Shopping</button>
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-8">
            @foreach ($carts as $cart)
                <div class="row cart-row">
                    <div class="col">
                        <div class="shadow d-flex cart-item">
                            <div class="product-img-div">
                                <a href="{{ url('/products') . '/' . $cart->product->id }}"><img class="product-img"
                                        src="{{ $cart->product->img != 'no_image.png' ? $cart->product->img : asset('images/no_image.png') }}"
                                        alt="Image Error">
                                </a>
                            </div>
                            <div class="cart-body flex-fill">
                                <h2 class="card-title mb-0"> <a
                                        href="{{ url('/products') . '/' . $cart->product->id }}">{{ $cart->product->name }}</a>
                                </h2>
                                <h6 class="card-title mb-0">{{ $cart->product->category->name }}</h6>
                                <h6 class="card-title">Stock: {{ $cart->product->stock }}</h6>
                                <div class="mt-2 price">
                                    <span class="current-count-span">{{ $cart->count }}</span> x
                                    <span
                                        class="original-product-price">{{ number_format($cart->product->price, 2) }}</span>
                                    RSD
                                </div>
                                <div class="quantity">
                                    <ul class="quantity-ul">
                                        <li data-cart-id="{{ $cart->id }}"
                                            class="btn btn-outline-primary fw-bold li-minus"><i
                                                class="fas fa-minus"></i></li>
                                        <li class="btn btn-outline-primary fw-bold li-current">{{ $cart->count }}
                                        </li>
                                        <li data-cart-id="{{ $cart->id }}"
                                            class="btn btn-outline-primary fw-bold li-plus"><i class="fas fa-plus"></i>
                                        </li>
                                        <!-- Button trigger modal -->
                                        <li data-bs-toggle="modal" data-bs-target="#exampleModal{{ $cart->id }}"
                                            class="btn
                                            btn-outline-primary fw-bold li-delete">
                                            <i class="fas fa-trash"></i>
                                        </li>
                                        <!-- Modal -->
                                        <div class="modal fade" id="exampleModal{{ $cart->id }}" tabindex="-1"
                                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Are you sure
                                                            that
                                                            you want to remove
                                                            <strong>"{{ $cart->product->name }}"</strong> from cart?
                                                        </h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <form class="d-inline"
                                                            action="{{ url('/carts2') }}/{{ $cart->id }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button class="btn btn-danger">YES</button>
                                                        </form>
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">No</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </ul>
                                </div>
                                <div class="total fw-bold">Total:
                                    <span
                                        class="total-product-price">{{ number_format($cart->count * $cart->product->price, 2) }}</span>
                                    RSD
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="col-4">
            <div class="total-div shadow payment-col">
                <h5><strong>SUBTOTAL:</strong> <span
                        class="subtotal-price-span">{{ number_format($totalPrice, 2, '.', ',') }}</span> RSD</h5>
                <h5><strong>SHIPPING:</strong> <span>0 RSD</span></h5>
                <h5><strong>TAX:</strong> <span class="tax-span">{{ number_format($totalPrice * 0.1, 2) }}</span> RSD
                    (10%)</h5>
                <h5 class="totalG2"><strong>TOTAL:</strong> <span
                        class="total-price-span">{{ number_format($totalPrice + $totalPrice * 0.1, 2) }}</span> RSD
                </h5>
                <button class="btn btn-primary btn-lg checkout-btn">Checkout</button>
            </div>
        </div>
    </div>

    <x-slot name="jsLink">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.21.1/axios.min.js"></script>
        <script src="{{ asset('js/cart.js') }}" defer></script>
    </x-slot>

</x-app-layout>
