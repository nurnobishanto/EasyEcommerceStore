<div class="border-bottom ">
    <div class="bg-light py-1">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-12 text-center text-md-start">
                    <span> {!! getSetting('top_left_text') !!}</span>
                </div>
                <div class="col-6 text-end d-none d-md-block">
                    <span> {!! getSetting('top_right_text') !!}</span>
                </div>
            </div>
        </div>
    </div>
    <div class="py-5">
        <div class="container">
            <div class="row w-100 align-items-center gx-lg-2 gx-0">
                <div class="col-xxl-3 col-lg-3">
                    <a class="navbar-brand d-none d-lg-block" href="{{route('home')}}">
                        @if(getSetting('site_logo'))
                        <img src="{{ asset('uploads/'.getSetting('site_logo')) }} "alt="{{getSetting('site_name')}}" style="max-height: 70px;max-width: 250px">
                        @endif
                    </a>
                    <div class="d-flex justify-content-between w-100 d-lg-none">
                        <a class="navbar-brand" href="{{route('home')}}">
                            @if(getSetting('site_logo'))
                            <img src="{{ asset('uploads/'.getSetting('site_logo')) }} "
                                 alt="{{getSetting('site_name')}}" style="max-height: 50px">
                            @endif

                        </a>

                        <div class="d-flex align-items-center lh-1">

                            <div class="list-inline me-4">
                                <div class="list-inline-item">
                                    <a class="text-muted position-relative " data-bs-toggle="offcanvas"
                                       data-bs-target="#offcanvasRight" href="#offcanvasExample" role="button"
                                       aria-controls="offcanvasRight">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                             viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                             stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                             class="feather feather-shopping-bag">
                                            <path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path>
                                            <line x1="3" y1="6" x2="21" y2="6">
                                            </line>
                                            <path d="M16 10a4 4 0 0 1-8 0"></path>
                                        </svg>
                                        <span
                                            class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-success">
                                                1
                                                <span class="visually-hidden">unread messages</span>
                                            </span>
                                    </a>
                                </div>

                            </div>
                            <!-- Button -->
                            <button class="navbar-toggler collapsed" type="button" data-bs-toggle="offcanvas"
                                    data-bs-target="#navbar-default" aria-controls="navbar-default"
                                    aria-label="Toggle navigation">
                                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32"
                                     fill="currentColor" class="bi bi-text-indent-left text-primary"
                                     viewBox="0 0 16 16">
                                    <path
                                        d="M2 3.5a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5zm.646 2.146a.5.5 0 0 1 .708 0l2 2a.5.5 0 0 1 0 .708l-2 2a.5.5 0 0 1-.708-.708L4.293 8 2.646 6.354a.5.5 0 0 1 0-.708zM7 6.5a.5.5 0 0 1 .5-.5h6a.5.5 0 0 1 0 1h-6a.5.5 0 0 1-.5-.5zm0 3a.5.5 0 0 1 .5-.5h6a.5.5 0 0 1 0 1h-6a.5.5 0 0 1-.5-.5zm-5 3a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5z" />
                                </svg>
                            </button>

                        </div>
                    </div>

                </div>
                <div class="col-xxl-7 col-lg-7 d-none d-lg-block">

                    <form action="#">
                        <div class="input-group ">
                            <input class="form-control rounded" type="search" placeholder="Search for products">
                            <span class="input-group-append">
                                    <button class="btn bg-white border border-start-0 ms-n10 rounded-0 rounded-end"
                                            type="button">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                             viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                             stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                             class="feather feather-search">
                                            <circle cx="11" cy="11" r="8"></circle>
                                            <line x1="21" y1="21" x2="16.65" y2="16.65">
                                            </line>
                                        </svg>
                                    </button>
                                </span>
                        </div>

                    </form>
                </div>
                <div class="col-md-2 col-xxl-2 text-end d-none d-lg-block">

                    <div class="list-inline">

                        <div class="list-inline-item">

                            <a class="text-muted position-relative " data-bs-toggle="offcanvas"
                               data-bs-target="#offcanvasRight" href="#offcanvasExample" role="button"
                               aria-controls="offcanvasRight">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                     viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                     stroke-linecap="round" stroke-linejoin="round"
                                     class="feather feather-shopping-bag">
                                    <path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path>
                                    <line x1="3" y1="6" x2="21" y2="6"></line>
                                    <path d="M16 10a4 4 0 0 1-8 0"></path>
                                </svg>
                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-success cart-count">
                                        0
                                        <span class="visually-hidden">unread messages</span>
                                    </span>
                            </a>

                        </div>





                    </div>
                </div>
            </div>
        </div>
    </div>
    <nav class="navbar navbar-expand-lg navbar-light navbar-default py-0 pb-lg-4 "
         aria-label="Offcanvas navbar large">
        <div class="container">


            <div class="offcanvas offcanvas-start" tabindex="-1" id="navbar-default"
                 aria-labelledby="navbar-defaultLabel">
                <div class="offcanvas-header pb-1">
                    <a href="{{route('home')}}">
                        @if(getSetting('site_logo'))
                        <img src="{{ asset('uploads/'.getSetting('site_logo')) }} "
                             alt="{{getSetting('site_name')}}" style="max-height: 50px">
                        @endif
                    </a>
                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas"
                            aria-label="Close"></button>
                </div>
                <div class="offcanvas-body">
                    <div class="d-block d-lg-none mb-4">
                        <form action="#">
                            <div class="input-group ">
                                <input class="form-control rounded" type="search"
                                       placeholder="Search for products">
                                <span class="input-group-append">
                                        <button class="btn bg-white border border-start-0 ms-n10 rounded-0 rounded-end"
                                                type="button">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                 viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                 stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                 class="feather feather-search">
                                                <circle cx="11" cy="11" r="8"></circle>
                                                <line x1="21" y1="21" x2="16.65" y2="16.65">
                                                </line>
                                            </svg>
                                        </button>
                                    </span>
                            </div>
                        </form>
                    </div>
                    @include('front.includes.mobile_categories_menu')
                    @include('front.includes.desktop_categories_navbar')
                    @include('front.includes.navbar')
                </div>
            </div>
        </div>
    </nav>
</div>
