@extends('layouts.front')

@section('content')
    @if(getSetting('home_slider') === 'show')
        @include('front.includes.slider')
    @endif
    <section class="my-lg-2 my-8">
        <div class="container">
            <div class="row">
                <div class="col-12 mb-6">
                    <h3 class="mb-0 d-inline">Popular Products</h3>
                    <a href="#" class="btn btn-sm btn-primary">Shop All</a>
                </div>
            </div>

            <div class="row g-4 row-cols-lg-5 row-cols-2 row-cols-md-3">
                @include('front.includes.single_product')
            </div>
        </div>
    </section>
@endsection
