@extends('layouts.front')
@section('content')
    <section class="mb-lg-2 mt-lg-4 my-8">
        <div class="container">
            <div class="row">
                <div class="col-12 mb-6">
                    <h3 class="mb-0">{{$title}}</h3>
                </div>
            </div>
            <div class="row g-2">
                @foreach($categories as $category)
                    <div class="col-md-3 col-sm-4 col-6">
                        <a href="{{route('category',['slug'=>$category->slug])}}" class="text-decoration-none text-inherit">
                            <div class="card card-product mb-lg-4">
                                <div class="card-body text-center py-8">
                                    <img src="{{ asset('uploads/'.$category->thumbnail) }}"
                                         alt="{{$category->name}}" class="mb-3 img-fluid">
                                    <div class="text-truncate">{{$category->name}} ({{countCategoryProducts($category->slug)}})</div>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
            <!-- list icon -->
            <div class="d-lg-flex justify-content-between align-items-center">
                <div>
                    <p class="mb-3 mb-md-0"> <span class="text-dark">{{$products->count()}} </span> Products found </p>
                </div>
            </div>
            <div class="row g-4 row-cols-lg-5 row-cols-2 row-cols-md-3 mt-2">
                @foreach($products as $product)
                    @include('front.includes.single_product',['$product'=>$product])
                @endforeach
            </div>
            @if($products->count()>20)
            @include('front.includes.pagination', ['products' => $products])
            @endif

        </div>
    </section>
@endsection
