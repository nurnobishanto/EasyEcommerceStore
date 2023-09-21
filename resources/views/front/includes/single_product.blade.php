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
                <span class="text-dark">{{getSetting('currency')}} {{$product->price}}</span>
                @if($product->regular_price)
                <span class="text-decoration-line-through text-muted">{{getSetting('currency')}} {{$product->regular_price}}</span>
                @endif
            </div>
            @if($product->quantity > 0)
            <div class="d-flex justify-content-between align-items-center mt-3">
                <div>
                    <button onclick="orderNow({{$product->id}})" class="btn btn-danger btn-sm">অর্ডার করুন</button>
                </div>
                <div>
                    <button class="btn btn-primary btn-sm add-to-cart" data-product-id="{{ $product->id }}"><i class="feather-icon icon-shopping-cart me-2"></i>+</button>
                </div>
            </div>
            @else
                <span class="text-danger">Stock Out</span>
            @endif
        </div>
    </div>
</div>
