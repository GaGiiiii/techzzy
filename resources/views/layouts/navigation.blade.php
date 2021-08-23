<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container">
        <a class="navbar-brand fw-bold" href="{{ url('/') }}">Techzzy</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarColor01"
            aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarColor01">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link {{ url()->current() == url('/') ? 'active' : '' }}"
                        href="{{ url('/') }}">Home
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ str_contains(url()->current(), 'products') ? 'active' : '' }}"
                        href="{{ url('products') }}">Products
                    </a>
                </li>
            </ul>
            <div id="search">
                <input class="form-control" type="search" placeholder="Search" aria-label="Search">
                <div id="search-results">
                    <div class="search-result-item">
                        <div class="search-result-item-img">
                            <img src="https://cdn.pixabay.com/photo/2015/04/23/22/00/tree-736885__480.jpg" alt="">
                        </div>
                        <div class="search-result-item-info">
                            <p>Ime | Kategorija</p>
                            <p>Ocena</p>
                            <p>Cena</p>
                        </div>
                    </div>
                </div>
            </div>
            <ul class="navbar-nav ms-auto">
                @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('login') }}">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('register') }}">Register</a>
                    </li>
                @endguest
                @auth
                    <li class="nav-item">
                        <a href="{{ url('cart') }}" class="cart position-relative d-inline-flex">
                            <i class="fas fa fa-shopping-cart fa-lg"></i>
                            <span class="cart-basket d-flex align-items-center justify-content-center">
                                {{ sizeof(auth()->user()->carts) }}
                            </span>
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle {{ str_contains(url()->current(), 'dashboard') ? 'active' : '' }}"
                            data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="true"
                            aria-expanded="false">{{ Auth::user()->username }}</a>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="{{ url('dashboard') }}">Dashboard</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="{{ url('admin') }}">Admin</a>
                            <div class="dropdown-divider"></div>
                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                    onclick="event.preventDefault(); this.closest('form').submit();">LOGOUT</a>
                            </form>
                        </div>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>