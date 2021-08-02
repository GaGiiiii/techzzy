<div class="row mt-5">
    <h1 style="margin-bottom: 20px; font-size: 1.8rem">{{ $title }}</h1>
    <div class="owl-carousel owl-theme {{ $type }}">
        @foreach ($products as $product)
            <a href="{{url('products/' . $product->id)}}">
                <div class="col-12 product-col">
                    <div class="card shadow">
                        <img src="{{ $product->img != 'no_image.png' ? $product->img : asset('images/no_image.png') }}"
                            class="card-img-top" alt="Image Error" style="height: 300px">
                        <div class="card-body">
                            <h5 class="card-title fw-bold">{{ $product->name }}</h5>
                            <p class="fw-bold">
                                <i class="fas fa-star"></i>
                                {{ isset($product->RATING) ? round($product->RATING, 2) : calculateRatingForProduct($product) }}
                                / 10
                            </p>
                            <p class="fw-bold">
                                <i class="fas fa-tag"></i> {{ $product->price }} RSD
                            </p>
                        </div>
                    </div>
                </div>
            </a>
        @endforeach
    </div>
</div>
