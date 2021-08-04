<x-app-layout>
    <x-slot name="cssLink">
        <link rel='stylesheet' href='{{ asset('css/show_product.css') }}'>
        <link rel='stylesheet' href='{{ asset('css/global.css') }}'>
    </x-slot>

    @if (session('unauthorized'))
        <x-alert type="danger" :message="session('unauthorized')" />
    @endif

    @if (session('add_comment_success'))
        <x-alert type="success" :message="session('add_comment_success')" />
    @endif


    @if (session('add_rating_success'))
        <x-alert type="success" :message="session('add_rating_success')" />
    @endif

    @if (session('delete_comment_success'))
        <x-alert type="success" :message="session('delete_comment_success')" />
    @endif

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
                        @auth
                            <div class="custom-rate-div">
                                <form
                                    action="{{ $usersRating == null ? url('/ratings') : url('/ratings') . '/' . $usersRating->id }}"
                                    method="POST">
                                    @csrf
                                    @if ($usersRating != null)
                                        @method("PUT")
                                    @endif
                                    <button type="submit"><i class="fas fa-star rate-star"></i></button>
                                    <button type="submit"><i class="fas fa-star rate-star"></i></button>
                                    <button type="submit"><i class="fas fa-star rate-star"></i></button>
                                    <button type="submit"><i class="fas fa-star rate-star"></i></button>
                                    <button type="submit"><i class="fas fa-star rate-star"></i></button>
                                    <button type="submit"><i class="fas fa-star rate-star"></i></button>
                                    <button type="submit"><i class="fas fa-star rate-star"></i></button>
                                    <button type="submit"><i class="fas fa-star rate-star"></i></button>
                                    <button type="submit"><i class="fas fa-star rate-star"></i></button>
                                    <button type="submit"><i class="fas fa-star rate-star"></i></button>
                                    <input type="hidden" name="rating" value="{{ $usersRating->rating ?? 0 }}">
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                </form>
                            </div>
                        @endauth
                        <p class="fw-bold"><i class="fas fa-tag"></i> <span
                                class="original-price-span">{{ number_format($product->price, 2) }}</span> RSD <span
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
                    <button data-status="{{ $cartForUserForThisProduct == null ? 'add' : 'remove' }}" type="button"
                        {{ $product->stock == 0 ? 'disabled' : '' }}
                        class="add-to-cart-btn btn btn-outline-primary w-100 fw-bold mt-4">
                        {{ ($product->stock == 0 ? 'Not Available' : $cartForUserForThisProduct == null) ? 'ADD TO CART' : 'REMOVE FROM CART' }}
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="crtid" data-crt="{{ $cartForUserForThisProduct == null ? '' : $cartForUserForThisProduct->id }}">
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
                            @if ($errors->any())
                                <div class="alert alert-danger mb-4">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            <div class="new-comment d-flex">
                                <div class="comment-img">
                                    <img src="{{ asset('avatars') . '/' . auth()->user()->username . '/' . auth()->user()->img }}"
                                        alt="Image Error">
                                </div>
                                <div class="comment-textarea flex-fill">
                                    <form action="{{ url('/comments') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                                        <div class="form-floating">
                                            <textarea name="body" class="form-control" placeholder="Leave a comment here"
                                                id="floatingTextarea2" style="height: 100px">{{ old('body') }}</textarea>
                                            <label for="floatingTextarea2">Leave your comment</label>
                                        </div>
                                        <button type="submit" class="btn btn-primary mt-3 d-block ms-auto">Submit</button>
                                    </form>
                                </div>
                            </div>
                        @endauth
                        @foreach ($product->comments as $comment)
                            <div class="comment d-flex">
                                <div class="comment-img">
                                    <img src="{{ asset('avatars') . '/' . $comment->user->username . '/' . $comment->user->img }}"
                                        alt="Image Error">
                                </div>

                                <div data-comment-id="{{ $comment->id }}" class="comment-body flex-fill">
                                    <h5>
                                        <i class="fas fa-user"></i> {{ $comment->user->username }} &nbsp;
                                        <i class="fas fa-star"></i>
                                        {{ findRatingForProductFromUser($comment->user, $product) }} / 10
                                        @if (auth()->user() && auth()->user()->id == $comment->user->id)
                                            <button data-comment-id="{{ $comment->id }}"
                                                class="btn btn-sm btn-warning edit-comment-btn">Edit</button>
                                            <!-- Button trigger modal -->
                                            <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#exampleModal{{ $comment->id }}">
                                                DELETE
                                            </button>
                                            <!-- Modal -->
                                            <div class="modal fade" id="exampleModal{{ $comment->id }}" tabindex="-1"
                                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Are you sure
                                                                that
                                                                you want to delete this comment?</h5>
                                                            <button type="button" class="btn-close"
                                                                data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <form class="d-inline"
                                                                action="{{ url('/comments') }}/{{ $comment->id }}"
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
                                        @endif
                                    </h5>
                                    <p data-comment-id="{{ $comment->id }}"
                                        class="comment-body-p-focus card-text mt-2 comment-body-p-{{ $comment->id }}">
                                        {{ $comment->body }}
                                    </p>
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
        <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.21.1/axios.min.js"></script>
        <script src="{{ asset('js/show_product.js') }}" defer></script>
    </x-slot>

</x-app-layout>
