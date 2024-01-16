<!DOCTYPE html>
<html lang="en">


<!-- Mirrored from freshcart.codescandy.com/ by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 19 Sep 2023 19:00:58 GMT -->

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta content="{{getSetting('site_name')}}" name="author">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{getSetting('site_name')}} {{getSetting('site_tagline')}}</title>
    <link href="{{ asset('front') }}/libs/slick-carousel/slick/slick.css" rel="stylesheet" />
    <link href="{{ asset('front') }}/libs/slick-carousel/slick/slick-theme.css" rel="stylesheet" />
    <link href="{{ asset('front') }}/libs/tiny-slider/dist/tiny-slider.css" rel="stylesheet">

    <!-- Favicon icon-->
    @if(getSetting('site_favicon'))
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('uploads/'.getSetting('site_favicon')) }}">
    @endif

    @yield('seo_meta')


    <!-- Libs CSS -->
    <link href="{{ asset('front') }}/libs/bootstrap-icons/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="{{ asset('front') }}/libs/feather-webfont/dist/feather-icons.css" rel="stylesheet">
    <link href="{{ asset('front') }}/libs/simplebar/dist/simplebar.min.css" rel="stylesheet">
    <link href=" https://cdn.jsdelivr.net/npm/sweetalert2@11.7.28/dist/sweetalert2.min.css " rel="stylesheet">
    <!-- Theme CSS -->

    <link rel="stylesheet" href="{{ asset('front') }}/css/theme.min.css">

    <style>
        .nav-lb-tab .nav-item .nav-link.active, .nav-lb-tab .nav-item .nav-link:hover{
            color: {{getSetting('primary_color')}};
            border-color: {{getSetting('primary_color')}};
        }
        .btn-primary {
            background-color: {{getSetting('primary_color')}}; /* Change this to your desired primary color */
            border-color: {{getSetting('primary_color')}}; /* Change the button border color if needed */
        }

        /* Change the hover color for buttons */
        .btn-primary:hover {
            background-color: {{getSetting('hover_color')}}; /* Change this to your desired hover color */
            border-color: {{getSetting('hover_color')}}; /* Change the button border hover color if needed */
        }

        /* Change the primary color for links */
        a {
            color: {{getSetting('primary_color')}}; /* Change this to your desired primary color for links */
        }

        /* Change the hover color for links */
        a:hover {
            color: {{getSetting('hover_color')}}; /* Change this to your desired hover color for links */
        }

        :root {
            --primary-color: {{getSetting('primary_color')}};
            --hover-color: {{getSetting('hover_color')}};
        }

    .navbar {
        --fc-navbar-hover-color: var(--primary-color);
        --fc-navbar-active-color: var(--primary-color);
        --fc-navbar-brand-color: var(--primary-color);
        --fc-navbar-brand-hover-color: var(--primary-color);
    }
        .bottom-mobile-nav {
            background: #ffffff;
            position: fixed;
            bottom: 0;
            box-shadow: 0px -4px 8px rgba(0, 0, 0, 0.1);
            height: 45px;
            width: 100%;
            display: flex;
            justify-content: space-around;
        }
        .bloc-icon {
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .bloc-icon i {
            font-size: 30px;
            color: {{getSetting('primary_color')}};
        }

        @media screen and (min-width: 600px) {
            .bottom-mobile-nav {
                display: none;
            }
        }

    </style>
    {!! getSetting('header_code') !!}
</head>

<body>
    {!! getSetting('body_code') !!}
   @include('front.includes.header')
    <!-- Shop Cart -->
    @include('front.includes.cart')
    <main>
        @yield('content')
    </main>



    <!-- footer -->
  @include('front.includes.footer')
  @include('front.includes.bottom_nav')

    <!-- Javascript-->

    <!-- Libs JS -->
    <script src="{{ asset('front') }}/libs/jquery/dist/jquery.min.js"></script>
    <script src="{{ asset('front') }}/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('front') }}/libs/simplebar/dist/simplebar.min.js"></script>

    <!-- Theme JS -->
    <script src="{{ asset('front') }}/js/theme.min.js"></script>
    <script src="{{ asset('front') }}/libs/jquery-countdown/dist/jquery.countdown.min.js"></script>
    <script src="{{ asset('front') }}/js/vendors/countdown.js"></script>
    <script src="{{ asset('front') }}/libs/slick-carousel/slick/slick.min.js"></script>
    <script src="{{ asset('front') }}/js/vendors/slick-slider.js"></script>
    <script src="{{ asset('front') }}/libs/tiny-slider/dist/min/tiny-slider.js"></script>
    <script src="{{ asset('front') }}/js/vendors/tns-slider.js"></script>
    <script src="{{ asset('front') }}/js/vendors/zoom.js"></script>
    <script src="{{ asset('front') }}/js/vendors/increment-value.js"></script>
   <script src=" https://cdn.jsdelivr.net/npm/sweetalert2@11.7.28/dist/sweetalert2.all.min.js "></script>

@include('front.includes.scripts')


    {!! getSetting('footer_code') !!}
</body>

</html>
