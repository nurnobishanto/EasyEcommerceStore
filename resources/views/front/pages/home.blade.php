@extends('layouts.front')

@section('content')
    @if(getSetting('home_slider') === 'show')
        @include('front.includes.slider')
    @endif
    @if(getSetting('home_featured_category') === 'show')
        @include('front.includes.featured_category')
    @endif
    <section class="my-lg-2 my-8">
        <div class="container">
            <div class="row">
                <div class="col-12 mb-6">
                    <h3 class="mb-0 d-inline">Featured Products</h3>
                </div>
            </div>

            <div class="row g-4 row-cols-lg-5 row-cols-2 row-cols-md-3">
                @foreach(featuredProducts() as $product)
                    @include('front.includes.single_product',['product' => $product])
                @endforeach
            </div>
        </div>
    </section>
    <section class="my-lg-2 my-8">
        <div class="container">
            <div class="row">
                <div class="col-12 mb-6">
                    <h3 class="mb-0 d-inline">Popular Products</h3>
                </div>
            </div>

            <div class="row g-4 row-cols-lg-5 row-cols-2 row-cols-md-3">
                @foreach(popularProducts() as $product)
                @include('front.includes.single_product',['product' => $product])
                @endforeach
            </div>

            @include('front.includes.pagination', ['products' => popularProducts() ])

        </div>

    </section>
@endsection
