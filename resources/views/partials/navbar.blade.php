<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Rubik:ital,wght@0,300..900;1,300..900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Montserrat:ital,wght@0,100..900;1,100..900&family=Rubik:ital,wght@0,300..900;1,300..900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Montserrat:ital,wght@0,100..900;1,100..900&family=Roboto:ital,wght@0,100..900;1,100..900&family=Rubik:ital,wght@0,300..900;1,300..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    {{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"> --}}
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body>

     <div class="navbar">
            <div class="nav-left">
                <div class="nav-logo">
                    <img src="{{ asset('images/images/bmw-logo-new.png') }}" alt="Logo">
                </div>
                <div class="nav-text">
                    <p>Мощь. Технологии. <span style="font-weight: 600;">Эмоции</span></p>
                </div>
            </div>

            <ul class="menu">
                <li>
                    <a href="{{ route('home.page')  }}">Главная</a>
                </li>
                <li>
                    <a href="{{ route('models') }}">Модели</a>
                </li>
                <li>
                    <a href="{{ route('store') }}">Купить BMW</a>
                </li>
                <li>
                    <a href="{{ route('contact') }}">Связаться</a>
                </li>
                <li>
                    <a href="{{ route('wallpapers') }}">Обои BMW</a>
                </li>
                <li class="burger-menu-btn" style="display: none;">
                    <a href="{{ route('login') }}">Вход</a>
                </li>
                <li class="burger-menu-btn" style="display: none;">
                    <a href="{{ route('register') }}">Регистрация</a>
                </li>

                <div class="account">
                    <a>
                        <i class="fa-regular fa-user"></i>
                    </a>
                </div>
            </ul>

            <div class="burger-menu">
                <span></span>
                <span></span>
                <span></span>
            </div>
    </div>
        <div class="overlay"></div>

        <div class="sign-choose">

            <div class="sign-content">
                @auth
                    <p>Добро пожаловать в мир BMW, {{ auth()->user()->name }}</p>
                @else
                    <p>Добро пожаловать в мир BMW</p>
                    <p>Присоединяйтесь и откройте для себя все возможности:</p>
                @endauth

                <i class="fa-solid fa-check"><span>Сохраняйте любимые модели и настройки.</span></i>
                <i class="fa-solid fa-check"><span>Улучшайте ваш BMW с помощью цифровых сервисов.</span></i>

                <div class="sign-buttons">
                    @auth
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="bmw-logout-btn">Выйти</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}">Вход</a>
                        <a href="{{ route('register') }}">Регистрация</a>
                    @endauth
                </div>
            </div>




        </div>

@yield('nav-content')
