@extends('partials.navbar')

@section('nav-content')

@php
    $initialJson = isset($initialModel) ? json_encode($initialModel, JSON_UNESCAPED_UNICODE) : 'null';
@endphp

<script>
    window.INITIAL_MODEL = {!! $initialJson !!};
    window.ROUTES = {
        searchModels: "{{ route('search.models') }}",
        getModelTemplate: "{{ route('models.get', ['id' => '__ID__']) }}"
    };
</script>

    <section class="store">

        <div class="store-header">
             <p>ВЫБЕРИТЕ СВОЙ BMW.</p>
        </div>

        <div class="store-menu">
        <form class="store-form" action="">
            @csrf

            <div class="form-grid">
                <div class="form-group">
                    <label for="model" class="form-label">Выберите модель:</label>
                    <input
                        id="model-search"
                        name="model_search"
                        class="form-control"
                        autocomplete="off"
                        placeholder="Начните вводить модель..."
                        data-search-url="{{ route('search.models') }}"
                        data-get-model-url="{{ route('models.get', ['id' => '__ID__']) }}"
                        data-initial-model='@json($initialModel ?? null)'>
                    <select id="model" name="model_id" class="form-control" style="display:none;"></select>

                    <input type="hidden" id="model-price" name="price" value="">
                </div>

                <div class="form-group">
                    <label for="color" class="form-label">Выберите цвет:</label>
                    <select id="color" name="color" class="form-control"></select>
                </div>

                <div class="form-group">
                    <label for="package" class="form-label">Выберите комплектацию:</label>
                    <select id="package" name="package" class="form-control"></select>
                </div>

                <div class="form-group">
                    <label for="interior" class="form-label">Выберите интерьер:</label>
                    <select id="interior" name="interior" class="form-control"></select>
                </div>
            </div>

            <div class="store-btn">
                @auth
                    <button type="submit" class="submit-btn">Перейти к оплате</button>
                @else
                    <a href="{{ route('login') }}" class="submit-btn">Войдите, чтобы продолжить</a>
                @endauth
            </div>

        </form>
    </div>

    </section>

    <script src="{{ asset('js/store.js') }}"></script>

@endsection
