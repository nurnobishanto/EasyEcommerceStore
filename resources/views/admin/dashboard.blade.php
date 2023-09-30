@extends('adminlte::page')

@section('title', __('global.dashboard'))

@section('content_header')
    <h1>{{__('global.dashboard')}}</h1>
@stop
@section('content')
    <div class="row">
        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
                <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-shopping-cart"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Pending Orders</span>
                    <span class="info-box-number">{{$orders->where('status','pending')->count()}}</span>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
                <span class="info-box-icon bg-info elevation-1"><i class="fas fa-shopping-cart"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Received Orders</span>
                    <span class="info-box-number">{{$orders->where('status','received')->count()}}</span>
                </div>
            </div>
        </div>
        <div class="clearfix hidden-md-up"></div>
        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
                <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-shopping-cart"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Delivered Orders</span>
                    <span class="info-box-number">{{$orders->where('status','delivered')->count()}}</span>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
                <span class="info-box-icon bg-success elevation-1"><i class="fas fa-shopping-cart"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Complete Orders</span>
                    <span class="info-box-number">{{$orders->where('status','completed')->count()}}</span>
                </div>
            </div>
        </div>
        <div class="clearfix hidden-md-up"></div>
        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
                <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-shopping-cart"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Canceled Orders</span>
                    <span class="info-box-number">{{$orders->where('status','canceled')->count()}}</span>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
                <span class="info-box-icon bg-red elevation-1"><i class="fas fa-shopping-cart"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Rejected Orders</span>
                    <span class="info-box-number">{{$orders->where('status','rejected')->count()}}</span>
                </div>
            </div>
        </div>
        <div class="clearfix hidden-md-up"></div>
        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
                <span class="info-box-icon bg-success elevation-1"><i class="fas fa-store"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Total Products</span>
                    <span class="info-box-number">{{$products->count()}}</span>
                </div>
            </div>

        </div>
        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box">
                <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-store"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Low Stock Product</span>
                    <span class="info-box-number">{{$products->where('quantity','<',5)->count()}}</span>
                </div>
            </div>
        </div>
        <div class="clearfix hidden-md-up"></div>
        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
                <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-tags"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Categories</span>
                    <span class="info-box-number">{{$categories->count()}}</span>
                </div>
            </div>

        </div>
        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
                <span class="info-box-icon bg-info elevation-1"><i class="fas fa-tag"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Brands</span>
                    <span class="info-box-number">{{$brands->count()}}</span>
                </div>

            </div>

        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Recent Orders</h5>
                </div>
                <div class="card-body table-responsive">

                    <table id="" class="table  dataTable table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>{{__('global.sl')}}</th>
                            <th>{{__('global.order_id')}}</th>

                            <th>{{__('global.price')}}</th>
                            <th>{{__('global.delivery_zone')}}</th>
                            <th>{{__('global.products')}}</th>
                            <th>{{__('global.status')}}</th>

                        </tr>
                        </thead>
                        <tbody>
                        @foreach($recent_orders as $order)
                            <tr>

                                <td>{{$order->id}}</td>
                                <td>{{$order->order_id}}</td>
                                @php
                                    $discount  = ($order->discount_percent/100)*$order->subtotal;
                                    if ($discount>$order->max_discount){
                                        $discount = $order->max_discount;
                                    }
                                @endphp
                                <td>{{$order->subtotal}} + {{$order->delivery_charge}} - {{$discount}} = {{$order->subtotal + $order->delivery_charge - $discount}}</td>
                                <td>{{$order->delivery_zone->name}}</td>
                                <td>{{$order->products->count() }}</td>
                                <td>
                                    @if($order->status=='pending') <span class="badge-warning badge">{{$order->status}}</span>
                                    @elseif($order->status=='received') <span class="badge-info badge">{{$order->status}}</span>
                                    @elseif($order->status=='delivered') <span class="badge-primary badge">{{$order->status}}</span>
                                    @elseif($order->status=='completed') <span class="badge-success badge">{{$order->status}}</span>
                                    @else <span class="badge-danger badge">{{$order->status}}</span>
                                    @endif
                                </td>

                            </tr>
                        @endforeach

                        </tbody>
                        <tfoot>
                        <tr>
                            <th>{{__('global.sl')}}</th>
                            <th>{{__('global.order_id')}}</th>
                            <th>{{__('global.price')}}</th>
                            <th>{{__('global.delivery_zone')}}</th>
                            <th>{{__('global.products')}}</th>
                            <th>{{__('global.status')}}</th>

                        </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>

    </div>


@stop
@section('footer')
    <strong>{{__('global.developed_by')}} <a href="https://soft-itbd.com">{{__('global.soft_itbd')}}</a>.</strong>
    {{__('global.all_rights_reserved')}}.
    <div class="float-right d-none d-sm-inline-block">
        <b>{{__('global.version')}}</b> {{env('DEV_VERSION')}}
    </div>
@stop
@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop
@section('plugins.datatablesPlugins', true)
@section('plugins.Datatables', true)
@section('js')
    <script>
        $(document).ready(function() {
            $(".dataTable").DataTable({
                responsive: true,
                lengthChange: false,
                autoWidth: false,
                searching: false,
                ordering: true,
                info: false,
                paging: false,

            });
        });
    </script>
@stop
