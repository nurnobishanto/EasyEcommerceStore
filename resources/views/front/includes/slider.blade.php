<section class="mt-8">
    <div class="container">
        <div class="hero-slider ">
            @foreach(homeSliders() as $slider)
            <div class="" style="background: url({{ asset('uploads/'.$slider->background) }})no-repeat; background-color: whitesmoke; background-size: cover; border-radius: .5rem; background-position: center;">
                <div class="ps-lg-12 py-lg-16 col-xxl-5 col-md-7 py-14 px-8 text-xs-center">
                    <h2 class="text-dark display-5 fw-bold mt-4">{{$slider->title}}</h2>
                    <p class="lead">{{$slider->description}}.</p>
                    @if($slider->url)
                    <a href="{{$slider->url}}" @if($slider->target) target="{{$slider->target}}" @endif class="btn btn-dark mt-3">Shop Now <i class="feather-icon icon-arrow-right ms-1"></i></a>
                    @endif
                </div>


            </div>
            @endforeach
        </div>
    </div>
</section>
