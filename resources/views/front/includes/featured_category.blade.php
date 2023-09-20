<section class="mb-lg-2 mt-lg-4 my-8">
    <div class="container">
        <div class="row">
            <div class="col-12 mb-6">
                <h3 class="mb-0">Featured Categories</h3>
            </div>
        </div>
        <div class="category-slider ">
            @foreach(featuredCategories() as $category)
            <div class="item">
                <a href="{{route('category',['slug'=>$category->slug])}}" class="text-decoration-none text-inherit">
                    <div class="card card-product mb-lg-4">
                        <div class="card-body text-center py-8">
                            <img src="{{ asset('uploads/'.$category->thumbnail) }}"
                                 alt="Grocery Ecommerce Template" class="mb-3 img-fluid">
                            <div class="text-truncate">{{$category->name}}</div>
                        </div>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
    </div>
</section>
