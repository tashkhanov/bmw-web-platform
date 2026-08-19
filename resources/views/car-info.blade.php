@extends('app.app')

@section('content')

    <section class="about-car">

        <div class="about-head-image">
            @if($car->otherImages->isNotEmpty())
                <img src="{{ asset($car->otherImages->first()->image_path) }}" alt="Car photo">
                <div class="head-car-name">
                    <p>{{ $car->car }}</p>
                </div>
            @endif
            </div>
        </div>

        <div class="car-description">

            {{-- <p class="short-description">
                BMW M5 Competition — это воплощение спортивной мощности в элегантном кузове бизнес-седана. Под капотом — 625 л.с., разгон до 100 км/ч всего за 3,3 секунды и адаптивный полный привод M xDrive. Это автомобиль, созданный для тех, кто хочет сочетать комфорт и максимальную производительность.
            </p> --}}

            <p class="short-description">
                @if(!empty($car->short_description))
                    {!! $car->short_description !!}
                @else
                    {!! Str::limit(strip_tags($car->description), 250) !!}
                @endif
            </p>

            <div class="swiper mySwiper2">
                 <div class="swiper-wrapper" style="object-fit: cover; user-select: none;">
                    @foreach($car->otherImages as $image)
                    <div class="swiper-slide"><img src="{{ asset($image->image_path) }}" alt="Car photo"></div>
                    @endforeach
                </div>
            </div>

            <p class="long-description">
                {!! $car->description !!}
            </p>
        </div>

    </section>

@endsection
