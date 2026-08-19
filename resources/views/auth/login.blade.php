<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Логин</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat&family=Rubik&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body class="sign-background">
    <div class="cancel-form-btn">
        <a href="{{ route('home.page') }}"><i class="fa-solid fa-arrow-left"></i></a>
    </div>

    <div class="sign-main">
        <p class="sign-main-text">Логин в BMW ID</p>


        <form action="{{ route('login') }}" method="POST">
            @csrf


            <label for="email">Email</label>
            <input id="email" name="email" type="email" value="{{ old('email') }}" required>

            @error('email')
                <div class="error">{{ $message }}</div>
            @enderror


            <label for="password">Пароль</label>
            <input id="password" name="password" type="password" required>

            @error('password')
                <div class="error">{{ $message }}</div>
            @enderror

            <button type="submit">Логин</button>
        </form>

        <p class="sign-text-or">ИЛИ</p>

        <div class="social-login">
            <div class="social-login">
                {{-- <a class="social-btn" href="{{ route('auth.google') }}" aria-label="Войти с Google"> --}}
                    <a class="social-btn" href="{{ route('auth.provider', ['provider' => 'google']) }}" aria-label="Войти с Google">
                    <img src="{{ asset('images/images/google.png') }}" alt="Google">
                    <span>Войти с Google</span>
                </a>
            </div>
        </div>

        <div class="sign-footer">
            <p>Ещё не зарегистрированы? <a href="{{ route('register') }}">Зарегистрироваться</a></p>
        </div>
    </div>

    <script src="{{ asset('js/main.js') }}"></script>
</body>
</html>
