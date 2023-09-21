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


</head>

<body>

   @include('front.includes.header')
    <!-- Shop Cart -->
    @include('front.includes.cart')
    <main>
        @yield('content')
    </main>



    <!-- footer -->
{{--  @include('front.includes.footer')--}}

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



</body>

</html>
