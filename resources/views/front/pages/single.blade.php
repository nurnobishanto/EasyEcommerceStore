@extends('layouts.front')
@section('content')
<section class="mt-8">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="slider slider-for">
                    <div>
                        <div class="zoom" onmousemove="zoom(event)" style="background-image: url({{asset('uploads/'.$product->thumbnail)}})">
                            <img src="{{asset('uploads/'.$product->thumbnail)}}" alt="" >
                        </div>
                    </div>
                    @foreach(productGalleries($product->id) as $img)
                    <div>
                        <div class="zoom" onmousemove="zoom(event)" style="background-image: url({{asset('uploads/'.$img)}})">
                            <img src="{{asset('uploads/'.$img)}}" alt="" >
                        </div>
                    </div>
                    @endforeach

                </div>
                <div class="slider slider-nav mt-4">
                    <div>
                        <img src="{{asset('uploads/'.$product->thumbnail)}}" alt="" class="w-100 rounded">
                    </div>
                    @foreach($product->gallery as $img)
                    <div>
                        <img src="{{asset('uploads/'.$img)}}" alt="" class="w-100 rounded">
                    </div>
                    @endforeach

                </div>
            </div>

            <div class="col-md-6">
                <div class="ps-lg-10 mt-6 mt-md-0">
                    <!-- content -->
                    <a href="{{route('category',['slug'=>$product->categories->first()->slug])}}" class="mb-4 d-block">{{$product->categories->first()->name}}</a>
                    <!-- heading -->
                    <h1 class="mb-1">{{$product->title}}</h1>
                    <div class="fs-4">
                        <span class="fw-bold text-dark">{{getSetting('currency')}} {{$product->price}}</span>
                        @if($product->regular_price)
                            <span class="text-decoration-line-through text-muted">{{getSetting('currency')}} {{$product->regular_price}}</span>
                        @endif
                        @if(calculateDiscountPercentage($product->regular_price,$product->price)>0)
                        <span><small class="fs-6 ms-2 text-danger">{{calculateDiscountPercentage($product->regular_price,$product->price)}}% Off</small></span>
                        @endif
                    </div>
                    <!-- hr -->

                    @if($product->quantity > 0)
                    <div class="mt-3 row justify-content-start g-2 align-items-center">
                        <div class="col-xxl-4 col-lg-6 col-md-6 col-sm-6 d-grid">
                             <button onclick="orderNow({{$product->id}})" type="button" class="btn btn-danger"><i class="feather-icon icon-shopping-bag me-2"></i>অর্ডার করুন</button>
                        </div>
                        <div class="col-lg-5 col-md-6 col-sm-6 d-grid">
                            <button onclick="addToCart({{$product->id}})" type="button" class="btn btn-primary"><i class="feather-icon icon-shopping-cart me-2">+</i>Add to cart</button>
                        </div>
                    </div>
                    @else
                    <div class="mt-3  justify-content-start g-2 align-items-center">
                        <h5 class="text-danger text-center">Stock Out</h5>
                    </div>
                    @endif

                    <!-- hr -->
                    <hr class="my-6">

                    <div>
                        <!-- table -->
                        <table class="table table-borderless mb-0">

                            <tbody>
                            <tr>
                                <td colspan="2"><a href="tel:" class="btn btn-info w-100 w-md-80 w-lg-50">কল করতে ক্লিক করুন</a></td>
                            </tr>
                            <tr>
                                <td colspan="2"><a href="tel:" class="btn btn-secondary w-100 w-md-80 w-lg-50">কল করতে ক্লিক করুন</a></td>
                            </tr>
                            <tr>
                                <td>Product Code:</td>
                                <td class="text-uppercase">{{$product->sku}}</td>
                            </tr>
                            <tr>
                                <td>Availability:</td>
                                @if($product->quantity > 0)
                                <td class="text-success">In Stock</td>
                                @else
                                <td class="text-danger">Stock Out</td>
                                @endif
                            </tr>
                            <tr>
                                <td>Brand:</td>
                                <td>{{$product->brand->name}}</td>
                            </tr>
                            <tr>
                                <td>Categories:</td>
                                <td>
                                    @foreach($product->categories as $cat)
                                        <a href="{{route('category',['slug'=>$cat->slug])}}">{{$cat->name}} </a>,
                                    @endforeach
                                </td>
                            </tr>
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="mt-lg-5 mt-4">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <ul class="nav nav-pills nav-lb-tab" id="myTab" role="tablist">
                    <!-- nav item -->
                    <li class="nav-item" role="presentation">
                        <!-- btn --> <button class="nav-link active" id="product-tab" data-bs-toggle="tab"
                                             data-bs-target="#product-tab-pane" type="button" role="tab" aria-controls="product-tab-pane"
                                             aria-selected="true">Product Details</button>
                    </li>
                </ul>
                <!-- tab content -->
                <div class="tab-content" id="myTabContent">
                    <!-- tab pane -->
                    <div class="tab-pane fade show active" id="product-tab-pane" role="tabpanel" aria-labelledby="product-tab"
                         tabindex="0">
                        <div class="my-8">
                            {!! $product->details !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- section -->
<section class="my-lg-14 my-14">
    <div class="container">
        <!-- row -->
        <div class="row">
            <div class="col-12">
                <!-- heading -->
                <h3>Related Items</h3>
            </div>
        </div>
        <!-- row -->
        <div class="row g-4 row-cols-lg-5 row-cols-2 row-cols-md-2 mt-2">
            @include('front.includes.single_product',['product'=>$product])
        </div>
    </div>
</section>
@endsection
