<x-app-layout>
    <x-slot name="cssLink">
        <link rel='stylesheet' href='{{ asset('css/show_product.css') }}'>
    </x-slot>


    <div class="row mt-5">
        <div class="col-12 col-sm-6">
            <div class="card" style="border-radius: 15px;">
                <img src="{{ $product->img != 'no_image.png' ? $product->img : asset('images/no_image.png') }}"
                    class="card-img-top thumbnail" alt="Image Error" style="max-height: 650px;">
            </div>
        </div>
        <div class="col-12 col-sm-6 mt-5 mt-sm-0">
            <div class="card product-card">
                <div class="card-body">
                    <h2 class="card-title fw-bold product-title">{{ $product->name }}</h2>
                    <div class="card-text mt-3">
                        <p class="fw-bold">
                            <i class="fas fa-star"></i>
                            {{ isset($product->RATING) ? round($product->RATING, 2) : calculateRatingForProduct($product) }}
                            / 10
                        </p>
                        <p class="fw-bold"><i class="fas fa-tag"></i> <span
                                class="original-price-span">{{ $product->price }}</span> RSD <span
                                class="changing-quantity-span"></span></p>
                        <p class="fw-bold"><i class="fas fa-shopping-cart"></i> In stock: <span
                                class="original-stock-span">{{ $product->stock }}</span> pcs</p>
                        <p class="mt-3">{{ $product->desc }}</p>
                        <div class="fw-bold mt-4 mb-1 d-flex justify-content-between">
                            <p class="mt-2">Quantity</p>
                            <ul class="quantity-ul">
                                <li class="btn btn-outline-primary fw-bold li-minus"><i class="fas fa-minus"></i></li>
                                <li class="btn btn-outline-primary fw-bold li-current">1</li>
                                <li class="btn btn-outline-primary fw-bold li-plus"><i class="fas fa-plus"></i></li>
                            </ul>
                        </div>
                    </div>
                    <button type="button" class="btn btn-outline-primary w-100 fw-bold mt-4">ADD TO CART</button>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-5">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <h2 class="card-title fw-bold product-title">Comments and Ratings</h2>
                    <div class="comments mt-4">
                        @if ($product->comments->isEmpty())
                            <h5 class="mb-4">No comments.</h5>
                        @endif
                        @auth
                            <div class="new-comment d-flex">
                                <div class="comment-img">
                                    <img src="{{ asset('avatars') . '/' . auth()->user()->username . '/' . auth()->user()->img }}"
                                        alt="Image Error">
                                </div>
                                <div class="comment-textarea flex-fill">
                                    <div class="form-floating">
                                        <textarea class="form-control" placeholder="Leave a comment here"
                                            id="floatingTextarea2" style="height: 100px"></textarea>
                                        <label for="floatingTextarea2">Leave your comment</label>
                                    </div>
                                    <button class="btn btn-primary mt-3 d-block ms-auto">Submit</button>
                                </div>
                            </div>
                        @endauth
                        @foreach ($product->comments as $comment)
                            <div class="comment d-flex">
                                <div class="comment-img">
                                    <img src="{{ asset('avatars') . '/' . $comment->user->username . '/' . $comment->user->img }}"
                                        alt="Image Error">
                                </div>

                                <div class="comment-body">
                                    <h5>
                                        <i class="fas fa-user"></i> {{ $comment->user->username }} &nbsp;
                                        <i class="fas fa-star"></i>
                                        {{ findRatingForProductFromUser($comment->user, $product) }} / 10
                                    </h5>
                                    <p class="card-text mt-2">{{ $comment->body }}</p>
                                    <p class="mt-3"><i class="fas fa-calendar-alt"></i>
                                        {{ formatDate($comment->created_at) }}h</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>


    <x-slot name="jsLink">
        <script src="{{ asset('js/show_product.js') }}" defer></script>
    </x-slot>

</x-app-layout>