<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ mix('js/app.js', 'build/admin') }}"></script>

    <!-- Styles -->
    <link href="{{ mix('css/app.css', 'build/admin') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    Simpla.laravel
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Каталог <span class="caret"></span>
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                <a class="dropdown-item" href="{{ route('admin.shop.catalog.products.index') }}">Товары</a>
                                <a class="dropdown-item" href="{{ route('admin.shop.catalog.categories.index') }}">Категории</a>
                                <a class="dropdown-item" href="{{ route('admin.shop.catalog.brands.index') }}">Бренды</a>
                                <a class="dropdown-item" href="{{ route('admin.shop.catalog.features.index') }}">Свойства</a>
                                {{--<a class="dropdown-item" href="{{ route('admin.shop.catalog.comments.index') }}">Комментарии</a>--}}
                            </div>
                        </li>
                        {{--<li class="nav-item dropdown">--}}
                            {{--<a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">--}}
                                {{--Заказы <span class="caret"></span>--}}
                            {{--</a>--}}
                            {{--<div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">--}}
                                {{--<a class="dropdown-item" href="{{ route('admin.shop.order.orders.index') }}">Заказы</a>--}}
                                {{--<a class="dropdown-item" href="{{ route('admin.shop.order.coupons.index') }}">Купоны</a>--}}
                                {{--<a class="dropdown-item" href="{{ route('admin.shop.order.labels.index') }}">Метки</a>--}}
                            {{--</div>--}}
                        {{--</li>--}}
                        {{--<li class="nav-item dropdown">--}}
                            {{--<a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">--}}
                                {{--Настройки <span class="caret"></span>--}}
                            {{--</a>--}}
                            {{--<div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">--}}
                                {{--<a class="dropdown-item" href="#">Общие настройки магазина</a>--}}
                                {{--<a class="dropdown-item" href="{{ route('admin.shop.setting.deliveries.index') }}">Методы доставки</a>--}}
                                {{--<a class="dropdown-item" href="{{ route('admin.shop.setting.payment-methods.index') }}">Способы оплаты</a>--}}
                                {{--<a class="dropdown-item" href="{{ route('admin.shop.setting.currencies.index') }}">Валюты</a>--}}
                            {{--</div>--}}
                        {{--</li>--}}
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Сайт <span class="caret"></span>
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                <a class="dropdown-item" href="#">Страницы</a>
                                {{--<a class="dropdown-item" href="#">Обратная связь</a>--}}
                            </div>
                        </li>
                        {{--<li class="nav-item">--}}
                            {{--<a class="nav-link" href="#">Блог</a>--}}
                        {{--</li>--}}
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>

    @stack('scripts-footer')

</body>
</html>
