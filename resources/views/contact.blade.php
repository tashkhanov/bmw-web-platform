@extends('partials.navbar')

@section('nav-content')


    <section class="contact">

        <div class="contact-header">
            <p>Поддержка BMW: Связаться с нами</p>
        </div>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('contact.store') }}" method="POST">
            @csrf

            @guest
                <div class="alert alert-warning">
                    Чтобы отправить сообщение — <a href="{{ route('login') }}">войдите в аккаунт</a>.
                </div>
            @endguest

            @auth
                <div class="contact-group">
                    <div class="contact-inp">
                        <label for="name">Введите имя:</label>
                        <input name="name" type="text">
                    </div>

                    <div class="contact-inp">
                        <label for="email">Введите Email:</label>
                        <input name="email" type="email">
                    </div>

                    <div class="contact-inp">
                        <label for="phone">Введите номер телефона:</label>
                        <input name="phone" type="number">
                    </div>

                    <div class="contact-inp">
                        <label for="theme">Введите тему сообщения:</label>
                        <select name="theme" id="">
                            <option value="Запрос о машине">Запрос о машине</option>
                            <option value="Проблемы с сервисом">Проблемы с сервисом</option>
                            <option value="Вопрос о финансовых услугах">Вопрос о финансовых услугах</option>
                            <option value="Другое">Другое</option>
                        </select>
                    </div>
                </div>

                <div class="contact-message">
                    <label for="message">Сообщение:</label>
                    <textarea name="message" id=""></textarea>
                    <button type="submit">Отправить</button>
                </div>
            @endauth
        </form>

    </section>

    </section>

<script src="{{ asset('js/main.js') }}"></script>
</body>

@endsection
