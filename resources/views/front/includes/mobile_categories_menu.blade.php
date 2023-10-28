<div class="d-block d-lg-none mb-4">
    <a class="btn btn-{{getSetting('theme_color')}} w-100 d-flex justify-content-center align-items-center"
       data-bs-toggle="collapse" href="#collapseExample" role="button"
       aria-expanded="false" aria-controls="collapseExample">
                                <span class="me-2"><svg xmlns="http://www.w3.org/2000/svg" width="16"
                                                        height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                        stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
                                                        class="feather feather-grid">
                                        <rect x="3" y="3" width="7" height="7"></rect>
                                        <rect x="14" y="3" width="7" height="7"></rect>
                                        <rect x="14" y="14" width="7" height="7"></rect>
                                        <rect x="3" y="14" width="7" height="7"></rect>
                                    </svg></span> All Categories
    </a>
    <div class="collapse mt-2" id="collapseExample">
        <div class="card card-body">
            <ul class="mb-0 list-unstyled">
                {{--                                        Mobile category--}}
                @foreach(getCategories() as $category)
                <li><a class="dropdown-item" href="{{route('category',['slug'=>$category->slug])}}">{{$category->name}} ({{countCategoryProducts($category->slug)}})</a></li>
                @endforeach

            </ul>
        </div>
    </div>
</div>
