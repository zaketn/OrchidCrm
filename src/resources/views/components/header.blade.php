<header class="d-flex flex-wrap align-items-center justify-content-center mb-auto justify-content-md-between ">
    <a href="/" class="d-flex align-items-center col-md-3 mb-2 mb-md-0 text-light text-decoration-none">
        <i class="fa-solid fa-code" role="img">&ensp; Web dev</i>
    </a>

    {{--        <ul class="nav col-12 col-md-auto mb-2 justify-content-center mb-md-0">--}}
    {{--            <li><a href="#" class="nav-link px-2 link-light">Home</a></li>--}}
    {{--            <li><a href="#" class="nav-link px-2 link-light">Features</a></li>--}}
    {{--            <li><a href="#" class="nav-link px-2 link-light">Pricing</a></li>--}}
    {{--            <li><a href="#" class="nav-link px-2 link-light">FAQs</a></li>--}}
    {{--            <li><a href="#" class="nav-link px-2 link-light">About</a></li>--}}
    {{--        </ul>--}}

    <div class="col-md-4">
        @auth
            <div class="text-end">
                <button type="button" class="btn btn-primary me-2" data-bs-toggle="modal" data-bs-target="#myLeadsModal">
                    Мои заявки
                </button>
           {{-- <button type="button" class="btn btn-primary me-2">Мои проекты</button> --}}
                <button type="button" class="btn btn-outline-danger me-2" data-bs-toggle="modal"
                        data-bs-target="#logoutModal">
                    Выйти
                </button>
            </div>
        @endauth
        @guest
            <div class="text-end">
                <a href="{{ route('login') }}" class="btn btn-outline-primary me-2">Войти</a>
                <a href="{{ route('register') }}" class="btn btn-primary">Зарегистрироваться</a>
            </div>
        @endguest
    </div>
</header>
