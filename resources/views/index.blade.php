<x-app-layout>
    <x-slot name="cssLink">
        <link rel='stylesheet' href='{{ asset('css/custom.css') }}'>
    </x-slot>

    <x-slot name="owlCarouselCSS">
        <link rel="stylesheet"
            href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
        <link rel="stylesheet"
            href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">
    </x-slot>

    @if (session('logout_successful'))
        <x-alert type="success" :message="session('logout_successful')" />
    @endif

    <div class="row mt-5">
        <div class="owl-carousel">
            @foreach ($mostCommentedProducts as $product)
                <div class="col">
                    <div class="card shadow">
                        <img src="{{ asset('images/no_image.png') }}" class="card-img-top" alt="..."
                            style="height: 300px">
                        <div class="card-body">
                            <h5 class="card-title fw-bold">{{ $product->name }}</h5>
                            <p class="fw-bold">
                                <i class="fas fa-star"></i> {{ calculateRatingForProduct($product) }} / 10
                            </p>
                            <p class="fw-bold">
                                <i class="fas fa-tag"></i> {{ $product->price }} RSD
                            </p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <x-slot name="owlCarouselJS">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
    </x-slot>

    <x-slot name="jsLink">
        <script src="{{ asset('js/index.js') }}" defer></script>
    </x-slot>

</x-app-layout>
