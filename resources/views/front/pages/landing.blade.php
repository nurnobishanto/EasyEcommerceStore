<!DOCTYPE html>
<html lang="en">


<!-- Mirrored from freshcart.codescandy.com/ by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 19 Sep 2023 19:00:58 GMT -->

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta content="{{getSetting('site_name')}}" name="author">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{$product->title}} {{getSetting('site_name')}}</title>
    <link href="{{ asset('front') }}/libs/slick-carousel/slick/slick.css" rel="stylesheet" />
    <link href="{{ asset('front') }}/libs/slick-carousel/slick/slick-theme.css" rel="stylesheet" />
    <link href="{{ asset('front') }}/libs/tiny-slider/dist/tiny-slider.css" rel="stylesheet">

    <!-- Favicon icon-->
    @if(getSetting('site_favicon'))
        <link rel="shortcut icon" type="image/x-icon" href="{{ asset('uploads/'.getSetting('site_favicon')) }}">
    @endif
    <!-- Libs CSS -->
    <link href="{{ asset('front') }}/libs/bootstrap-icons/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="{{ asset('front') }}/libs/feather-webfont/dist/feather-icons.css" rel="stylesheet">
    <link href="{{ asset('front') }}/libs/simplebar/dist/simplebar.min.css" rel="stylesheet">
    <link href=" https://cdn.jsdelivr.net/npm/sweetalert2@11.7.28/dist/sweetalert2.min.css " rel="stylesheet">
    <!-- Theme CSS -->

    <link rel="stylesheet" href="{{ asset('front') }}/css/theme.min.css">

    <style type="text/css">
        {!! $product->css !!}
    </style>
    {!! getSetting('header_code') !!}
</head>

<body>
{!! getSetting('body_code') !!}
{{--@include('front.includes.header')--}}
{{--<!-- Shop Cart -->--}}
{{--@include('front.includes.cart')--}}
<main>

    {!! $product->html !!}
    <section style="background-color: #FFF4F5" class=" py-8" id="placeOrder">
        <div class="container">
            <form action="{{route('landingOrderConfirm')}}" method="post">
                @csrf
                <input name="id" value="{{$product->id}}" class="d-none">
            <h2 class="text-center my-5">তাই আর দেরি না করে আজই অর্ডার করুন</h2>
            <div class="row">
                <div class="col-lg-6 col-12 col-md-6 ">
                    <div class="mt-4 mt-lg-0">
                        <div class="card shadow-sm">
                            <h5 class="px-6 py-4 bg-transparent mb-0">Order Details</h5>
                            <ul class="list-group list-group-flush cart-list px-2">
                                <li class="list-group-item py-3 ps-0">
                                    <div class="row align-items-center">
                                        <div class="col-5 col-md-6">
                                            <div class="d-flex">
                                                <img src="{{ asset('uploads/'.$product->thumbnail) }}" alt="" class="icon-shape icon-md">
                                                <div class="ms-3">
                                                    <a href="" class="text-inherit">
                                                        <h6 class="mb-0">{{ $product->title }}</h6>
                                                    </a>
                                                    <span><small class="text-muted">{{ getSetting('currency') }}{{ $product->price }}</small></span>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-5 col-md-4">
                                            <div class="input-group input-spinner">
                                                <input type="button" value="-" class="button-minus btn btn-sm" id="decrement">
                                                <input type="text" readonly step="1" max="10" value="1"  id="quantity" name="quantity" class=" form-control-sm form-input">
                                                <button type="button" class="button-plus btn btn-sm" id="increment">+</button>
                                            </div>
                                        </div>
                                        <div class="col-2 text-lg-end text-start text-md-end col-md-2 p-0">
                                            <span class="fw-bold">{{ getSetting('currency') }}<strong id="subtotal">{{ $product->price }}</strong></span>
                                        </div>
                                    </div>
                                </li>

                            </ul>
                            <div class="card-footer cart-footer">
                                <p class="text-end">Delivery Charge : + {{getSetting('currency')}}<span id="delivery_charge"></span></p>
                                <p class="text-end">Discount : - {{getSetting('currency')}}<span id="discount_amount"></span></p>
                                <p class="text-end fw-bold">Total :  {{getSetting('currency')}}<span id="total_amount"></span></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-12">
                    <div class="card card-bordered shadow-none mb-2">
                                <div class="card-header">
                                    <h5 class="card-title">Order Information</h5>
                                </div>
                                <div class="card-body p-6">
                                    <div class="row g-2">
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="name" class="form-label">আপনার নাম <span class="text-danger"> *</span></label>
                                                    <input type="text" id="name" value="{{old('name')}}" name="name" class="form-control" placeholder="আপনার নাম ">
                                                    @error('name')
                                                    <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="phone" class="form-label">আপনার মোবাইল নম্বর <span class="text-danger"> *</span></label>
                                                    <input type="tel" value="{{old('phone')}}" name="phone" id="phone" class="form-control" placeholder="আপনার মোবাইল নম্বর ">
                                                    <p id="validationMessage"></p>
                                                    @error('phone')
                                                    <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="address" class="form-label">আপনার সম্পূর্ণ ঠিকানা <span class="text-danger"> *</span></label>
                                                    <textarea  id="address"   class="form-control" name="address" placeholder="আপনার সম্পূর্ণ ঠিকানা">{{old('address')}}</textarea>
                                                    @error('address')
                                                    <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="order_note" class="form-label">অর্ডার নোট</label>
                                                    <textarea  id="order_note" class="form-control" name="order_note" placeholder="Order Note">{{old('order_note')}}</textarea>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="delivery_zone_id" class="form-label">ডেলিভারি জোন <span class="text-danger"> *</span></label>
                                                    <select id="delivery_zone_id" class="form-control" name="delivery_zone_id" >
                                                        <option value="" data-charge="80">Select Delivery Zone</option>
                                                        @php $dzSelect   = true; @endphp
                                                        @foreach(deliveryZones() as $zone)
                                                            <option @if(old('delivery_zone_id') == $zone->id || $dzSelect) selected @endif  value="{{$zone->id}}" data-charge="{{$zone->charge}}">{{$zone->name}} - {{getSetting('currency')}}{{$zone->charge}}</option>
                                                            @php $dzSelect   = false; @endphp
                                                        @endforeach
                                                    </select>
                                                    @error('delivery_zone_id')
                                                    <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            @if(getSetting('payment_method') === 'show' || getSetting('dc_required') ==='yes')
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label for="payment_method_id" class="form-label">Payment Method</label>
                                                        <select id="payment_method_id" class="form-control" name="payment_method_id" >
                                                            <option value="">Select Payment Method</option>
                                                            <option @if(old('payment_method_id') === 'cod') selected @endif  value="cod">Cash on Delivery</option>
                                                            @foreach(paymentMethods() as $pm)
                                                                <option @if(old('payment_method_id') === $pm->id) selected @endif onclick="paymentMethodInfo()" value="{{$pm->id}}">{{$pm->name}} @if(getSetting('payment_discount')>0) - {{getSetting('payment_discount')}}% Discount @endif</option>
                                                            @endforeach
                                                        </select>
                                                        <div class="mt-2" id="payment_description"></div>
                                                        @error('payment_method_id')
                                                        <div class="text-danger">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div id="payment_details">
                                                    <div class="col-12">
                                                        <div class="row">
                                                            <div class="col-md-8">
                                                                <div class="form-group">
                                                                    <label for="trxid" class="form-label">ট্রানজেকশন আইডি (TrxID) <span class="text-danger"> *</span></label>
                                                                    <input  id="trxid" class="form-control" name="trxid" placeholder="Enter Transaction id">
                                                                    @error('trxid')
                                                                    <div class="text-danger">{{ $message }}</div>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label for="paid_amount" class="form-label">টাকার পরিমান <span class="text-danger"> *</span></label>
                                                                    <input  id="paid_amount" type="number" class="form-control" name="paid_amount" placeholder="Enter amount">
                                                                    @error('paid_amount')
                                                                    <div class="text-danger">{{ $message }}</div>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>
                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <label for="sent_from" class="form-label">যে নাম্বার থেকে পাঠিয়েছেন <span class="text-danger"> *</span></label>
                                                            <input  id="sent_from" class="form-control" name="sent_from" placeholder="আপনি যে নম্বরে টাকা পাঠিয়েছেন">
                                                            @error('sent_from')
                                                            <div class="text-danger">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>

                                            @endif
                                            <input type="submit" class="btn btn-danger" value="অর্ডার কনফার্ম করুন">

                                        </div>
                                </div>
                            </div>
                </div>
            </div>
            </form>
        </div>

    </section>
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

<script>
    $(document).ready(function() {
        calculateAmount();
        $("#delivery_zone_id, #payment_method_id").on('change',function (){
            calculateAmount();
        });
        $("#increment").on('click',function (){
            var qty = $("#quantity").val();
            qty++;
            $("#quantity").val(qty);
            calculateAmount();
        });
        $("#decrement").on('click',function (){
            var qty = $("#quantity").val();
            if(qty>1){
                qty--;
            }
            $("#quantity").val(qty);
            calculateAmount();
        });
    });
    function calculateAmount(){
        var qty = $("#quantity").val();
        var price = {{$product->price}};
        var selectedOption = $('#delivery_zone_id :selected');
        var charge = parseFloat(selectedOption.data('charge')) || 0;
        var subtotal = qty * price;
        var discount =  0;
        $('#subtotal').text(subtotal);
        var totalAmount = subtotal + charge;
        var id = $('#payment_method_id').val();
        $('#payment_description').text('');
        if (id === 'cod' || id === ''){
            $('#payment_details').removeClass('d-block');
            $('#payment_details').addClass('d-none');
        }else {
            $('#payment_details').removeClass('d-none')
            $('#payment_details').addClass('d-block')
            var discount_rate = parseFloat('{{getSetting('payment_discount')}}'); // Parse as a float
            var max_discount = parseFloat('{{getSetting('payment_max_discount')}}'); // Parse as a float
             discount = (discount_rate / 100) * subtotal;
            if (discount > max_discount){
                discount = max_discount;
            }
        }
        $('#discount_amount').text(discount)
        $('#delivery_charge').text(charge);
        $('#total_amount').text(totalAmount - discount);

    }
</script>


{!! getSetting('footer_code') !!}
</body>

</html>






