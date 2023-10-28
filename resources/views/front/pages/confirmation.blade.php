@extends('layouts.front')
@section('content')
    <section class="mb-lg-14 mb-8 mt-8">
        <div class="container">
            <h1 class="mb-5 text-center">Order Confirmation</h1>
            <div class="row">
                <div class="col-md-4">
                    <div class="card card-{{getSetting('theme_color')}}">
                        <div class="card-header">
                            <h5 class="card-title">Customer Information</h5>
                        </div>
                        <div class="card-body table-responsive">
                            <table class="table">
                                <tr>
                                    <th>ORDER ID</th>
                                    <th>{{$order->order_id}}</th>
                                </tr>
                                <tr>
                                    <th>Name</th>
                                    <td>{{$order->name}}</td>
                                </tr>
                                <tr>
                                    <th>Phone</th>
                                    <td>{{$order->phone}}</td>
                                </tr>
                                <tr>
                                    <th>Address</th>
                                    <td>{{$order->address}}</td>
                                </tr>
                                <tr>
                                    <th>Order Note</th>
                                    <td>{{$order->order_note}}</td>
                                </tr>
                                <tr>
                                    <th>Payment Method</th>
                                    <th>
                                        @if($order->payment_method)
                                            {{$order->payment_method->name}}
                                        @else
                                            Cash On Delivery
                                        @endif
                                    </th>
                                </tr>
                                <tr>
                                    <th>Order Status</th>
                                    <th class="text-uppercase">{{$order->status}}</th>
                                </tr>
                                @if($order->delivery_method)
                                <tr>
                                    <th>Delivery Status ({{$order->delivery_method}})</th>
                                    <th class="text-uppercase">{{$order->delivery_status}} </th>
                                </tr>
                                @endif
                                @if($order->delivery_id)
                                <tr>
                                    <th>Delivery ID</th>
                                    <th class="text-uppercase">{{$order->delivery_id}} </th>
                                </tr>
                                @endif
                            </table>

                        </div>
                    </div>


                </div>
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">Product List</h5>
                        </div>
                        <div class="card-body table-responsive">
                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Quantity</th>
                                    <th>Price</th>
                                    <th>Total</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($order->products as $product)
                                    <tr>
                                        <td>{{$product->title}}</td>
                                        <td>{{$product['pivot']['quantity']}}</td>
                                        <td>{{getSetting('currency')}}{{$product['pivot']['price']}}</td>
                                        <td>{{getSetting('currency')}}{{$product['pivot']['sub_total']}}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                                <tfoot>
                                <tr>
                                    <th class="text-end" colspan="3">Sub Total</th>
                                    <th>{{getSetting('currency')}}{{$order->subtotal}}</th>
                                </tr>
                                <tr>
                                    <th class="text-end text-danger" colspan="3">Delivery Charge</th>
                                    <th class="text-danger">+ {{getSetting('currency')}}{{$order->delivery_charge}}</th>
                                </tr>
                                <tr>
                                    <th class="text-end text-success" colspan="3">Discount</th>
                                    @php
                                    $discount  = ($order->discount_percent/100)*$order->subtotal;
                                    if ($discount>$order->max_discount){
                                        $discount = $order->max_discount;
                                    }
                                    @endphp
                                    <th class="text-success">- {{getSetting('currency')}}{{$discount}}</th>
                                </tr>
                                <tr>
                                    <th class="text-end" colspan="3">Total</th>
                                    <th>{{getSetting('currency')}}{{($order->delivery_charge + $order->subtotal) - $discount}}</th>
                                </tr>
                                @if($order->payment_method)
                                <tr>
                                    <th class="text-end" colspan="3">Paid</th>
                                    <th>{{getSetting('currency')}}{{$order->paid_amount}}</th>
                                </tr>
                                <tr>
                                    <th class="text-end" colspan="3">Due</th>
                                    <th>{{getSetting('currency')}}{{($order->delivery_charge + $order->subtotal) -($discount - $order->paid_amount) }}</th>
                                </tr>
                                @endif
                                </tfoot>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
