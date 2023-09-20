@extends('layouts.front')
@section('content')
    <section class="mt-8 mb-lg-14 mb-8">
        <div class="container">
            <!-- row -->
            <div class="row">
                <!-- col -->
                <div class="col-lg-12">
                    <!-- page header -->
                    <div class="card mb-4 bg-light border-0">
                        <!-- card body -->
                        <div class="card-body p-9">
                            <!-- title -->
                            <h2 class="mb-0 fs-1">{{$category->name}}</h2>
                        </div>
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
                    <!-- row -->
                    <div class="row mt-8">
                        <div class="col">
                            <!-- nav -->
                            <nav>
                                <ul class="pagination">
                                    <li class="page-item disabled">
                                        <a class="page-link  mx-1 " href="#" aria-label="Previous">
                                            <i class="feather-icon icon-chevron-left"></i>
                                        </a>
                                    </li>
                                    <li class="page-item "><a class="page-link  mx-1 active" href="#">1</a></li>
                                    <li class="page-item"><a class="page-link mx-1 text-body" href="#">2</a></li>
                                    <li class="page-item"><a class="page-link mx-1 text-body" href="#">12</a></li>
                                    <li class="page-item">
                                        <a class="page-link mx-1 text-body" href="#" aria-label="Next">
                                            <i class="feather-icon icon-chevron-right"></i>
                                        </a>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection


