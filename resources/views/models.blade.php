@extends('app.app')

@section('content')
    <section class="models">

        <div class="models-header">
            <p>ВЫБЕРИТЕ СВОЙ BMW.</p>
        </div>

        <ul class="models-navbar">
            <li class="btn {{ !$currentCategory ? 'active' : '' }}">
                <a href="{{ route('models') }}">Все</a>
            </li>
            <li class="btn {{ $currentCategory === 'sedans' ? 'active' : '' }}">
                <a href="{{ route('models', ['category' => 'sedans']) }}">Седаны</a>
            </li>
            <li class="btn {{ $currentCategory === 'crossovers' ? 'active' : '' }}">
                <a href="{{ route('models', ['category' => 'crossovers']) }}">Кроссоверы</a>
            </li>
            <li class="btn {{ $currentCategory === 'electrocars' ? 'active' : '' }}">
                <a href="{{ route('models', ['category' => 'electrocars']) }}">Электромобили</a>
            </li>
            <li class="btn {{ $currentCategory === 'm-series' ? 'active' : '' }}">
                <a href="{{ route('models', ['category' => 'm-series']) }}">M-серия</a>
            </li>
            <li>
                <form action="{{ route('models') }}" method="GET" class="models-search">
                    <input
                        type="text"
                        name="q"
                        value="{{ request('q') }}"
                        placeholder="Поиск по моделям..."
                    >
                    <button type="submit">Найти</button>
                </form>
            </li>
        </ul>



        <div class="cars">
            <div class="cars-category-name">
                <p>
                    {{ $currentCategory ? ($categoryNames[$currentCategory] ?? $currentCategory) : 'Все модели' }}
                </p>
            </div>

            <div class="previous-cars">
                @foreach ($cars as $car )
                <div class="car">
                    <div class="car-image">
                    @if ($car->mainImage)
                        <img src="{{ asset($car->mainImage->image_path) }}" alt="{{ $car->car }}">
                    @else
                        <img src="{{ asset('images/no-image.png') }}" alt="Нет фото">
                    @endif
                </div>
                    <div class="car-info">
                        <a href="{{ route('car-info', ['id' => $car->id]) }}">{{ $car->car }}</a>
                    <span>{{ $car->fuel }}</span>
                    </div>

                    <div class="car-menu">
                        <p><strong>Комплектация:</strong>
                            {{ is_array($car->complectation) ? implode(', ', $car->complectation) : $car->complectation }}
                        </p>
                        <p><strong>Цвета:</strong>
                            {{ is_array($car->colors) ? implode(', ', $car->colors) : $car->colors }}
                        </p>
                        <p><strong>Интерьер:</strong>
                            {{ is_array($car->interior) ? implode(', ', $car->interior) : $car->interior }}
                        </p>
                        <p><strong>Цена:</strong> ${{ $car->price }}</p>
                        <div class="car-more-btns">
                            <div class="car-more-btn">
                                <a href="{{ route('car-info', ['id' => $car->id]) }}" class="btn-details">Подробнее</a>
                            </div>
                            <div class="car-more-btn">
                                <a href="{{ route('store', ['model' => $car->id]) }}" class="btn-details">
                                    К покупке — ${{ $car->price }}
                                </a>
                            </div>
                        </div>

                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection
