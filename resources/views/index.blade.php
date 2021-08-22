<x-app-layout>
    <x-slot name="cssLink">
        <link rel='stylesheet' href='{{ asset('css/custom.css') }}'>
        <link rel='stylesheet' href='{{ asset('css/global.css') }}'>
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

    <x-owl-row type="owl-latest" title="Latest Products" :products="$products" />
    <x-owl-row type="owl-likes" title="Most Liked Products" :products="$mostLikedProducts" />
    <x-owl-row type="owl-comments" title="Most Commented Products" :products="$mostCommentedProducts" />

    <x-slot name="owlCarouselJS">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
    </x-slot>

    <x-slot name="jsLink">
        <script src="{{ asset('js/index.js') }}" defer></script>
    </x-slot>
</x-app-layout>
