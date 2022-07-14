<header class="d-flex flex-wrap align-items-center justify-content-center mb-auto justify-content-md-between ">
    <a href="/" class="d-flex align-items-center col-md-3 mb-2 mb-md-0 text-light text-decoration-none">
        <i class="fa-solid fa-code" role="img">&ensp; Web dev</i>
    </a>

    {{--    <ul class="nav col-12 col-md-auto mb-2 justify-content-center mb-md-0">--}}
    {{--        <li><a href="#" class="nav-link px-2 link-light">Home</a></li>--}}
    {{--        <li><a href="#" class="nav-link px-2 link-light">Features</a></li>--}}
    {{--        <li><a href="#" class="nav-link px-2 link-light">Pricing</a></li>--}}
    {{--        <li><a href="#" class="nav-link px-2 link-light">FAQs</a></li>--}}
    {{--        <li><a href="#" class="nav-link px-2 link-light">About</a></li>--}}
    {{--    </ul>--}}

    <div class="col-md-4">
        <div class="text-end d-flex justify-content-end">
            @auth
                @if($user->isEmployee())
                    <a href="{{ route('platform.main') }}" class="nav-link px-2 link-light text-decoration-underline">Админ</a>
                @endif

                <div class="dropdown">
                    <span class="dropdown-toggle nav-link px-2 link-light" type="button" id="dropdownMenuButton2"
                          data-bs-toggle="dropdown" aria-expanded="false">
                        {{ $user->name }}
                    </span>

                    <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="dropdownMenuButton2">
                        <li>
                            <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#myLeadsModal" href="#">
                                Мои заявки
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#myMeetupsModal" href="#">
                                Мои встречи
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#myProjectsModal" href="#">
                                Проекты
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#logoutModal" href="#">
                                Выйти
                            </a>
                        </li>
                    </ul>
                </div>
            @endauth

            @guest
                <a href="{{ route('login') }}" class="btn btn-outline-primary me-2">Войти</a>
                <a href="{{ route('register') }}" class="btn btn-primary">Зарегистрироваться</a>
            @endguest
        </div>
    </div>
</header>
