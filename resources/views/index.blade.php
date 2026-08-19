@extends('app.app')

@section('content')

        <div class="home-main" style="margin-top: 200px">
            <div class="main-info">
                <p>{{ $latestCars->first()->car }}</p>
                <p>Новая эра вождения начинается здесь.</p>
                <a href="{{ route('car-info', ['id' => $latestCars->first()->id]) }}">Подробнее</a>
            </div>
            
            <div class="main-car-image">
                <div class="swiper mySwiper3">
                    <div class="swiper-wrapper" style="object-fit: cover; user-select: none;">
                        @foreach($latestCars->first()->otherImages->take(3) as $img)
                            <div class="swiper-slide">
                                <img src="{{ asset($img->image_path) }}" alt="{{ $latestCars->first()->car }}">
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

    <section class="all-bmw">
        <div class="all-bmw-title">
            <p>ВСЕ МОДЕЛИ BMW</p>

            <a href="{{  route('models') }}" class="find-bmw-btn"><i class="fa-solid fa-chevron-right"></i>Найдите свой BMW</a>
        </div>

        <div class="last-models">
            @foreach($latestCars as $car)
                <div class="last-model">
                    <div class="last-model-img">
                        @if($car->otherImages->isNotEmpty())
                            <img src="{{ asset($car->otherImages->first()->image_path) }}" alt="{{ $car->car }}">
                        @else
                            <img src="{{ asset('images/no-image.png') }}" alt="Нет фото">
                        @endif
                    </div>
                    <a href="{{ route('car-info', ['id' => $car->id]) }}">{{ $car->car }}</a>
                </div>
            @endforeach
        </div>

    </section>

    <section class="wallpapers-preview">
        <div class="bmw-wallpapers-title">
            <p>BMW: ОБОИ СКОРОСТИ</p>
            <a href="{{ route('wallpapers') }}" class="find-bmw-btn">
                <i class="fa-solid fa-chevron-right"></i>Все обои BMW
            </a>
        </div>

        <div class="swiper mySwiper4">
            <div class="swiper-wrapper" style="object-fit: cover; user-select: none;">
                @foreach($wallpapers as $wp)
                    <div class="swiper-slide">
                        <img src="{{ asset($wp->image_path) }}" alt="">
                    </div>
                @endforeach
            </div>
            <div class="swiper-pagination"></div>
        </div>
    </section>


@endsection