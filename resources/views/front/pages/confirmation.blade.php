@extends('layouts.front')
@section('content')
    <section class="container">
        <h1 class="mt-5">Order Confirmation</h1>
        <div class="row">
            <div class="col-md-4">
                <div class="card card-primary">
                    <div class="card-header">
                        <h5 class="card-title">Customer Information</h5>
                    </div>
                    <div class="card-body table-responsive">
                        <table class="table">
                            <tr>
                                <th>ORDER ID</th>
                                <td>{{$order->order_id}}</td>
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
                                <th>{{$order->subtotal}}</th>
                            </tr>
                            <tr>
                                <th class="text-end" colspan="3">Delivery Charge</th>
                                <th>{{$order->delivery_charge}}</th>
                            </tr>
                            <tr>
                                <th class="text-end" colspan="3">Total</th>
                                <th>{{$order->delivery_charge + $order->subtotal}}</th>
                            </tr>
                            </tfoot>
                        </table>
                    </div>

                </div>
            </div>
        </div>


    </section>
@endsection
