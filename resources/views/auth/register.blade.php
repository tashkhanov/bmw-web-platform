<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Регистрация</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.19/css/intlTelInput.min.css" />
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body class="sign-background">
    <div class="cancel-form-btn">
        <a href="{{ route('home.page') }}"><i class="fa-solid fa-arrow-left"></i></a>
    </div>
    <div class="sign-main">
        <p class="sign-main-text">Регистрация BMW ID</p>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <label for="name">Имя</label>
            <input id="name" name="name" type="text" value="{{ old('name') }}" required>
            @error('name') <div class="error">{{ $message }}</div> @enderror

            <label for="phone">Номер телефона</label>
            <input id="phone" name="phone" type="tel" value="{{ old('phone') }}" required>
            @error('phone') <div class="error">{{ $message }}</div> @enderror

            <label for="email">Email адрес</label>
            <input id="email" name="email" type="email" value="{{ old('email') }}" required>
            @error('email') <div class="error">{{ $message }}</div> @enderror

            <label for="password">Пароль</label>
            <input id="password" name="password" type="password" required>
            @error('password') <div class="error">{{ $message }}</div> @enderror

            <label for="password_confirmation">Подтвердите пароль</label>
            <input id="password_confirmation" name="password_confirmation" type="password" required>
            @error('password_confirmation') <div class="error">{{ $message }}</div> @enderror

            <div style="margin-top:18px; width: 100%;">
                <button style="width: 100%;" type="submit">Зарегистрироваться</button>
            </div>
        </form>

        <p class="sign-text-or">ИЛИ</p>

        <div class="social-login">
            <a class="social-btn" href="{{ route('auth.provider', ['provider' => 'google']) }}" aria-label="Войти с Google">
                <img src="{{ asset('images/images/google.png') }}" alt="Google">
                <span>Войти с Google</span>
            </a>
        </div>

        <div class="sign-footer">
            <p>Уже зарегистрированы? <a href="{{ route('login') }}">Войти</a></p>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.19/js/intlTelInput.min.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const input = document.querySelector('#phone');
        if (!input) return;

        const iti = window.intlTelInput(input, {
            allowDropdown: false,
            separateDialCode: false,
            initialCountry: "ru",
            nationalMode: false,
            autoHideDialCode: true,
            utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.19/js/utils.js",
        });

        const form = input.closest('form');
        if (form) {
            form.addEventListener('submit', function () {
                try {
                    const e164 = iti.getNumber();
                    if (e164 && e164.startsWith('+')) {
                        input.value = e164;
                    }
                } catch (e) {}
            });
        }

        input.style.direction = 'ltr';
        input.style.textAlign = 'left';
    });
    </script>
</body>
</html>
