@extends('adminlte::page')

@section('title', __('global.view_order'))

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>{{__('global.view_order')}} - {{$order->order_id}}</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{__('global.home')}}</a></li>
                <li class="breadcrumb-item"><a href="{{route('admin.orders.index')}}">{{__('global.orders')}}</a></li>
                <li class="breadcrumb-item active">{{__('global.view_order')}}</li>
            </ol>

        </div>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                        @if (count($errors) > 0)
                            <div class = "alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                            <div class="row">
                                <div class="col-md-6 table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th width="20%">Attribute</th>
                                                <th width="80%">Value</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>{{__('global.order_by')}}</td>
                                                <td>
                                                    Name : {{$order->name}}<br>
                                                    Phone : {{$order->phone}}<br>
                                                    Address : {{$order->address}}<br>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>{{__('global.payment_method')}}</td>
                                                <td>
                                                    @if($order->payment_method)
                                                    Method : {{$order->payment_method->name}} ({{$order->payment_method->account_no}})<br>
                                                    @else
                                                        Method : Cash on Delivery<br>
                                                    @endif
                                                        Paid Amount : {{$order->paid_amount}}{{getSetting('currency')}}<br>
                                                        TrxID : {{$order->trxid}}<br>
                                                        From : {{$order->sent_from}}<br>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>{{__('global.order_note')}}</td>
                                                <td>{{$order->order_note}}</td>
                                            </tr>
                                            <tr>
                                                <td>{{__('global.created_at')}} & {{__('global.created_by')}}</td>
                                                <td>At {{date_format($order->created_at,'d M y h:i A')}} by {{$order->createdBy->name??'--'}}</td>
                                            </tr>
                                            <tr>
                                                <td>{{__('global.updated_at')}} & {{__('global.updated_by')}}</td>
                                                <td>At {{date_format($order->updated_at,'d M y h:i A')}} by {{$order->updatedBy->name??'--'}}</td>
                                            </tr>
                                            <tr>
                                                <td>{{__('global.status')}} </td>
                                                <td class="text-capitalize">{{$order->status}}</td>
                                            </tr>
                                            <tr>
                                                <td>{{__('global.url')}} </td>
                                                <td class="text-capitalize">{{$order->status}}</td>
                                            </tr>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th>Attribute</th>
                                                <th>Value</th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                                <div class="col-md-6 table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                        <tr>
                                            <th>SL</th>
                                            <th>Thumbnail</th>
                                            <th>Product Name</th>
                                            <th>Quantity</th>
                                            <th>Price</th>
                                            <th>Total</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @php $sl = 1@endphp
                                        @foreach($order->products as $product)
                                            <tr>
                                                <td>{{$sl}}</td>
                                                <td><img src="{{asset('uploads/'.$product->thumbnail)}}" class="img-thumbnail" style="max-width: 100px;max-height: 100px"></td>
                                                <td>{{$product->title}}</td>
                                                <td>{{$product['pivot']['quantity']}}</td>
                                                <td>{{$product['pivot']['price']}}</td>
                                                <td>{{$product['pivot']['sub_total']}}</td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                        <tfoot>
                                        <tr>
                                            <th colspan="5">Sub Total</th>
                                            <th>{{$order->subtotal}}</th>
                                        </tr>
                                        <tr>
                                            <td colspan="5">Delivery Charge</td>
                                            <td>{{$order->delivery_charge}}</td>
                                        </tr>
                                        <tr>
                                            <th class="text-end text-success" colspan="5">Discount {{$order->discount_percent}}%</th>
                                            @php
                                                $discount  = ($order->discount_percent/100)*$order->subtotal;
                                                if ($discount>$order->max_discount){
                                                    $discount = $order->max_discount;
                                                }
                                            @endphp
                                            <th class="text-success">- {{getSetting('currency')}}{{$discount}}</th>
                                        </tr>
                                        <tr>
                                            <th class="text-end" colspan="5">Total</th>
                                            <th>{{getSetting('currency')}}{{($order->delivery_charge + $order->subtotal) - $discount}}</th>
                                        </tr>
                                        @if($order->payment_method)
                                            <tr>
                                                <th class="text-end" colspan="5">Paid</th>
                                                <th>{{getSetting('currency')}}{{$order->paid_amount}}</th>
                                            </tr>
                                            <tr>
                                                <th class="text-end" colspan="5">Due</th>
                                                <th>{{getSetting('currency')}}{{($order->delivery_charge + $order->subtotal) -($discount - $order->paid_amount) }}</th>
                                            </tr>
                                        @endif
                                        </tfoot>
                                    </table>
                                </div>
                            </div>



                        <form action="{{ route('admin.orders.destroy', $order->id) }}" method="POST">
                            @method('DELETE')
                            @csrf
                            <a href="{{route('admin.orders.index')}}" class="btn btn-success" >Go Back</a>
                            @can('order_update')
                                <a href="{{route('admin.orders.edit',['order'=>$order->id])}}" class="btn btn-warning "><i class="fa fa-pen"></i> Edit</a>
                            @endcan
                            @can('order_delete')
                                <button onclick="isDelete(this)" class="btn btn-danger"><i class="fa fa-trash"></i> Delete</button>
                            @endcan
                        </form>

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
@section('plugins.toastr',true)
@section('plugins.Sweetalert2', true)
@section('css')

@stop

@section('js')
    <script>
        function isDelete(button) {
            event.preventDefault();
            var row = $(button).closest("tr");
            var form = $(button).closest("form");
            Swal.fire({
                title: @json(__('global.deleteConfirmTitle')),
                text: @json(__('global.deleteConfirmText')),
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: @json(__('global.deleteConfirmButtonText')),
                cancelButtonText: @json(__('global.deleteCancelButton')),
            }).then((result) => {
                console.log(result)
                if (result.value) {
                    // Trigger the form submission
                    form.submit();
                }
            });
        }
        function checkSinglePermission(idName, className,inGroupCount,total,groupCount) {
            if($('.'+className+' input:checked').length === inGroupCount){
                $('#'+idName).prop('checked',true);
            }else {
                $('#'+idName).prop('checked',false);
            }
            if($('.permissions input:checked').length === total+groupCount){
                $('#select_all').prop('checked',true);
            }else {
                $('#select_all').prop('checked',false);
            }
        }

        function checkPermissionByGroup(idName, className,total,groupCount) {
            if($('#'+idName).is(':checked')){
                $('.'+className+' input').prop('checked',true);
            }else {
                $('.'+className+' input').prop('checked',false);
            }
            if($('.permissions input:checked').length === total+groupCount){
                $('#select_all').prop('checked',true);
            }else {
                $('#select_all').prop('checked',false);
            }
        }

        $('#select_all').click(function(event) {
            if(this.checked) {
                // Iterate each checkbox
                $(':checkbox').each(function() {
                    this.checked = true;
                });
            } else {
                $(':checkbox').each(function() {
                    this.checked = false;
                });
            }
        });
    </script>
@stop
