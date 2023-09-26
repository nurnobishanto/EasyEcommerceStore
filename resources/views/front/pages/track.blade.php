@extends('layouts.front')
@section('content')
    <section class="mb-lg-14 mb-8 mt-8">
        <div class="container">
            <div class="row g-2 justify-content-center">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">Track your order</h5>
                        </div>
                        <div class="card-body">
                            <form action="{{route('track_order')}}" method="get">
                                <div class="form-group">
                                    <input name="query" class="form-control" placeholder="Enter your order id, phone number">
                                    <input type="submit" value="Search" class="btn btn-primary mt-2">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="">
                        @if($msg)
                            <h2 class="text-center">{!! $msg !!}</h2>
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <th>SL</th>
                                        <th>Order ID</th>
                                        <th>Date</th>
                                        <th>Name</th>
                                        <th>Phone</th>
                                        <th>Products</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @php $sl = 1;@endphp
                                    @foreach($orders as $order)
                                        <tr>
                                            <td>{{$sl++}}</td>
                                            <td>{{$order->order_id}}</td>
                                            <td>{{$order->created_at}}</td>
                                            <td>{{$order->name}}</td>
                                            <td>{{$order->phone}}</td>
                                            <td>{{$order->products->count()}}</td>
                                            <td>{{$order->status}}</td>
                                            <td><a href="{{route('success',['id'=>$order->order_id])}}" class="btn btn-sm btn-info">View</a></td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
