<section class="mt-8">
    <div class="container">
        <div id="carouselExample" class="carousel slide">
            <div class="carousel-inner">
                @php $active = 'active' @endphp
                @foreach(homeSliders() as $slider)
                    <a href="{{$slider->url}}" @if($slider->target) target="{{$slider->target}}" @endif>
                        <div class="carousel-item {{$active}}">
                            <img src="{{ asset('uploads/'.$slider->background) }}" class="d-block w-100" alt="{{$slider->title}}">
                            <div class="carousel-caption d-none d-md-block">
                                <img src="{{ asset('uploads/'.$slider->image) }}" class="text-center" alt="{{$slider->title}}">
                                <h5>{!! $slider->title !!}</h5>
                                <p>{!! $slider->description !!}</p>
                            </div>
                        </div>
                    </a>
                    @php $active = '' @endphp
                @endforeach
            </div>
            @if(homeSliders()->count()>1)
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
            @endif
        </div>

    </div>
</section>
