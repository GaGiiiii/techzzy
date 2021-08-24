<x-app-layout>
    <x-slot name="cssLink">
        <link rel='stylesheet' href='{{ asset('css/global.css') }}'>
        <link rel='stylesheet' href='{{ asset('css/products.css') }}'>
    </x-slot>

    <div class="row mt-5">

        <div class="col-2">
            <div class="card filters shadow">
                <div id="sort">
                    <h4 class="mb-2">Sort by:</h4>
                    <select class="form-select ps-2" name="sortBy" aria-label="Default select example">
                        <option selected value="name">Name</option>
                        <option value="price">Price desc</option>
                        <option value="price2">Price asc</option>
                        <option value="ratings">Ratings</option>
                        <option value="comments">Comments</option>
                        <option value="popularity">Popularity</option>
                    </select>
                </div>
                <div id="price" class="mt-3">
                    <h4>Price range</h4>
                    <input type="range" min="0" max="1000000" class="form-range" id="customRange1" name="price-range">
                </div>
                <div id="categories" class="mt-2">
                    <h4 class="mb-2">Cetegory</h4>
                    @foreach ($categories as $category)
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="category"
                                value="{{ $category->name }}">
                            <label class="form-check-label" for="flexCheckDefault">
                                {{ $category->name }}
                            </label>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="col-10">
            <div class="container-fluid pe-2">
                <div class="row">
                    @foreach ($products as $product)
                        <div class="col-lg-3 col-md-4 col-sm-6 product-col">
                            <a href="{{ url('products/' . $product->id) }}">
                                <div class="card shadow">
                                    <img src="{{ $product->img != 'no_image.png' ? $product->img : asset('images/no_image.png') }}"
                                        class="card-img-top" alt="Image Error" style="height: 300px">
                                    <div class="card-body">
                                        <h5 class="card-title fw-bold mb-0">{{ $product->name }}</h5>
                                        <h6 class="mb-2">{{ $product->category->name }}</h6>
                                        <p class="fw-bold">
                                            <i class="fas fa-star"></i>
                                            {{ isset($product->RATING) ? round($product->RATING, 2) : calculateRatingForProduct($product) }}
                                            / 10
                                        </p>
                                        <p class="fw-bold">
                                            <i class="fas fa-tag"></i> {{ number_format($product->price, 2) }} RSD
                                        </p>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
                <div id="pagination" class="mt-5">
                    {{ $products->links() }}
                </div>
            </div>
        </div>
    </div>


    <x-slot name="jsLink">
        <script src="{{ asset('js/products.js') }}" defer></script>
    </x-slot>
</x-app-layout>
