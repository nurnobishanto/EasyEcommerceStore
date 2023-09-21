@extends('layouts.front')
@section('content')
    <section class="mt-8 mb-lg-14 mb-8">
        <div class="container">
            <!-- row -->
            <div class="row">
                <!-- col -->
                <div class="col-lg-12">
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
                    @include('front.includes.pagination', ['paginator' => $products])
                </div>
            </div>
        </div>
    </section>
@endsection


