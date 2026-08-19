<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Завершение профиля</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.19/css/intlTelInput.min.css" />
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head> 
<body class="complete-profile-page">
    <div class="complete-profile-container">
        <div class="complete-profile-card">
            <h1>Завершите профиль</h1>
            <p>Пожалуйста, укажите номер телефона, чтобы завершить регистрацию.</p>

            <form method="POST" action="{{ route('profile.complete.store') }}">
                @csrf
                <label for="phone">Номер телефона</label>
                <input id="phone" name="phone" type="tel" value="{{ old('phone') }}" required>
                @error('phone') <div class="error">{{ $message }}</div> @enderror

                <div class="complete-profile-btn">
                    <button type="submit">Сохранить</button>
                </div>
            </form>
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
            utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.19/js/utils.js",
        });

        const form = input.closest('form');
        form.addEventListener('submit', function () {
            try {
                const e164 = iti.getNumber();
                if (e164 && e164.startsWith('+')) input.value = e164;
            } catch (e) {}
        });

        input.style.direction = 'ltr';
        input.style.textAlign = 'left';
    });
    </script>
</body>
</html>
