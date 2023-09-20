<div class="col">
    <div class="card card-product">
        <div class="card-body">
            <div class="text-center position-relative ">
                <div class=" position-absolute top-0 start-0">
                    @if(calculateDiscountPercentage($product->regular_price, $product->price)>0)
                        <span class="badge bg-success">{{calculateDiscountPercentage($product->regular_price, $product->price)}}% Off</span>
                    @elseif($product->is_featured == 'yes')
                        <span class="badge bg-danger">Hot</span>
                    @endif

                </div>
                <a href="{{route('product',['slug'=>$product->slug])}}">
                    <img src="{{ asset('uploads/'.$product->thumbnail) }}" alt="{{$product->title}}" class="mb-3 img-fluid">
                </a>
            </div>
            <div class="text-small mb-1">
                <a href="{{route('category',['slug'=>$product->categories->first()->slug])}}" class="text-decoration-none text-muted"><small>{{$product->categories->first()->name}}</small></a></div>
            <h2 class="fs-6">
                <a href="{{route('product',['slug'=>$product->slug])}}" class="text-inherit text-decoration-none">{{$product->title}}</a>
            </h2>
            <div>
                <span class="text-dark">{{$product->price}}</span>
                <span class="text-decoration-line-through text-muted">{{$product->regular_price}}</span>
            </div>
            <div class="d-flex justify-content-between align-items-center mt-3">
                <div>
                    <a href="#!" class="btn btn-danger btn-sm"> অর্ডার করুন</a>
                </div>
                <div>
                    <a href="#!" class="btn btn-primary btn-sm">Add cart</a>
                </div>
            </div>
        </div>
    </div>
</div>
