<div class="dropdown me-3 d-none d-lg-block">
    <button class="btn btn-{{getSetting('theme_color')}} px-6 " type="button" id="dropdownMenuButton1"
            data-bs-toggle="dropdown" aria-expanded="false">
                                <span class="me-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                         viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.2"
                                         stroke-linecap="round" stroke-linejoin="round" class="feather feather-grid">
                                        <rect x="3" y="3" width="7" height="7"></rect>
                                        <rect x="14" y="3" width="7" height="7"></rect>
                                        <rect x="14" y="14" width="7" height="7"></rect>
                                        <rect x="3" y="14" width="7" height="7"></rect>
                                    </svg></span> All Departments
    </button>
    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
        @foreach(getCategories() as $category)
            <li><a class="dropdown-item" href="{{route('category',['slug'=>$category->slug])}}">{{$category->name}} ({{countCategoryProducts($category->slug)}})</a></li>
        @endforeach
    </ul>
</div>
