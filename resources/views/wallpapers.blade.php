@extends('app.app')

@section('content')
<section class="wallpapers">

    <div class="about-head-image">
        <img src="{{ asset('images/images/wallpapers-main.jpg') }}" alt="">
        <div class="head-car-name">
            <p>Все обои BMW</p>
        </div>
    </div>


    <div class="swiper mySwiper4 wallpapers-slider">
        <div class="swiper-wrapper" style="object-fit: cover; user-select: none;">
            @foreach($latest as $wp)
                <div class="swiper-slide">
                    <img src="{{ asset($wp->image_path) }}" alt="">
                </div>
            @endforeach
        </div>
        <div class="swiper-pagination"></div>
    </div>

    <div class="wallpapers-page">
        <div class="page-wrap">
            <section class="grid">
                @foreach($wallpapers as $wp)
                    <div class="card">
                        <img class="thumb"
                            src="{{ asset($wp->image_path) }}"
                            alt=""
                            style="pointer-events: none; user-select: none;"
                            oncontextmenu="return false">

                        <div class="controls">
                            @auth
                                {{-- <a href="{{ asset($wp->image_path) }}"
                                download
                                class="btn-download">Загрузить</a> --}}
                                <a href="{{ route('wallpapers.download', $wp->id) }}" class="btn-download">Загрузить</a>
                            @else
                                <a href="{{ route('login') }}"
                                class="btn-download">Войдите, чтобы скачать</a>
                            @endauth
                        </div>
                    </div>
                @endforeach
            </section>

            <div class="pager-wrap">
                {{ $wallpapers->links('vendor.pagination.bootstrap-5') }}
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('contextmenu', e => e.preventDefault());
        document.addEventListener('keydown', e => {
            if (e.ctrlKey && (e.key === 's' || e.key === 'u' || e.key === 'p')) {
                e.preventDefault();
            }
        });
    </script>

</section>
@endsection
