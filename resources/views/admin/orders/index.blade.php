@extends('adminlte::page')

@section('title', __('global.orders'))

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>{{__('global.orders')}}</h1>
            @can('order_create')
                <a href="{{route('admin.orders.create')}}" class="btn btn-primary mt-2">{{__('global.add_new')}}</a>
            @endcan
            @can('order_delete')
                <a href="{{route('admin.orders.trashed')}}" class="btn btn-danger mt-2">{{__('global.trash_list')}}</a>
            @endcan

        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{__('global.home')}}</a></li>
                <li class="breadcrumb-item active">{{__('global.orders')}}</li>
            </ol>

        </div>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            @can('order_list')
                <div class="card">
                    <div class="card-body table-responsive">
                        <table id="adminsList" class="table  dataTable table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>{{__('global.sl')}}</th>
                                <th>{{__('global.order_id')}}</th>
                                <th>{{__('global.order_by')}}</th>
                                <th width="125px">{{__('global.price')}}</th>
                                <th width="150px">{{__('global.delivery_zone')}}</th>
                                <th>{{__('global.status')}}</th>
                                <th width="150px">{{__('global.action')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @php $sl = 1 @endphp
                            @foreach($orders as $order)
                                <tr>

                                    <td>{{$sl++}}</td>
                                    <td>{{$order->order_id}}</td>
                                    <td>{{$order->name}},<br>{{$order->phone}},<br>{{$order->address}}</td>
                                    @php
                                        $discount  = ($order->discount_percent/100)*$order->subtotal;
                                        if ($discount>$order->max_discount){
                                            $discount = $order->max_discount;
                                        }
                                    @endphp
                                    <td>Subtotal : {{$order->subtotal}}<br>D. Charge : {{$order->delivery_charge}}<br>Discount : {{$discount}}<br>Total : {{$order->subtotal+$order->delivery_charge-$discount}}</td>
                                    <td>
                                        D. Zone: {{$order->delivery_zone->name}}<br>
                                        Pay. M: {{$order->payment_method->name??'Cash on Delivery'}}<br>
                                        TrxID: {{$order->trxid??'---'}}<br>
                                        Paid: {{$order->paid_amount??'0.00'}}<br>
                                    </td>
                                    <td>
                                        @if($order->status=='pending') <span class="badge-warning badge">{{$order->status}}</span>
                                        @elseif($order->status=='received') <span class="badge-info badge">{{$order->status}}</span>
                                        @elseif($order->status=='delivered') <span class="badge-primary badge">{{$order->status}}</span>
                                        @elseif($order->status=='completed') <span class="badge-success badge">{{$order->status}}</span>
                                        @else <span class="badge-danger badge">{{$order->status}}</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <form action="{{ route('admin.orders.destroy', $order->id) }}" method="POST">
                                            @method('DELETE')
                                            @csrf
                                            @can('order_view')
                                                <a target="_blank" href="{{route('admin.orders.print',['order'=>$order->id])}}" class="btn btn-primary px-1 py-0 btn-sm"><i class="fa fa-print"></i></a>
                                                <a href="{{route('admin.orders.show',['order'=>$order->id])}}" class="btn btn-info px-1 py-0 btn-sm"><i class="fa fa-eye"></i></a>
                                            @endcan
                                            @can('order_update')
                                                <a href="{{route('admin.orders.edit',['order'=>$order->id])}}" class="btn btn-warning px-1 py-0 btn-sm"><i class="fa fa-pen"></i></a>
                                            @endcan
                                            @can('order_delete')
                                                <button onclick="isDelete(this)" class="btn btn-danger btn-sm px-1 py-0"><i class="fa fa-trash"></i></button>
                                            @endcan
                                        </form>
                                        <form action="{{route('admin.orders.status_update',['order' => $order->id])}}" method="post" class="mt-2">
                                            @csrf
                                            <select name="status">
                                                <option value="pending" @if($order->status == "pending") selected @endif>{{__('global.pending')}}</option>
                                                <option value="received" @if($order->status == "received") selected @endif>{{__('global.received')}}</option>
                                                <option value="rejected" @if($order->status == "rejected") selected @endif>{{__('global.rejected')}}</option>
                                                <option value="canceled" @if($order->status == "canceled") selected @endif>{{__('global.canceled')}}</option>
                                                <option value="stoke_out" @if($order->status == "stoke_out") selected @endif>{{__('global.stoke_out')}}</option>
                                                <option value="delivered" @if($order->status == "delivered") selected @endif>{{__('global.delivered')}}</option>
                                                <option value="completed" @if($order->status == "completed") selected @endif>{{__('global.completed')}}</option>
                                            </select>
                                            <input type="submit" value="Submit" class="btn btn-sm btn-primary">
                                        </form>
                                    </td>
                                </tr>
                            @endforeach

                            </tbody>
                            <tfoot>
                            <tr>
                                <th>{{__('global.sl')}}</th>
                                <th>{{__('global.order_id')}}</th>
                                <th>{{__('global.order_by')}}</th>
                                <th>{{__('global.price')}}</th>
                                <th>{{__('global.delivery_zone')}}</th>
                                <th>{{__('global.status')}}</th>
                                <th>{{__('global.action')}}</th>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            @endcan

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
@section('plugins.datatablesPlugins', true)
@section('plugins.Datatables', true)
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

        $(document).ready(function() {
            $("#adminsList").DataTable({
                dom: 'Bfrtip',
                responsive: true,
                lengthChange: false,
                autoWidth: false,
                searching: true,
                ordering: true,
                info: true,
                paging: true,
                buttons: [
                    {
                        extend: 'copy',
                        text: '{{ __('global.copy') }}',
                    },
                    {
                        extend: 'csv',
                        text: '{{ __('global.export_csv') }}',
                    },
                    {
                        extend: 'excel',
                        text: '{{ __('global.export_excel') }}',
                    },
                    {
                        extend: 'pdf',
                        text: '{{ __('global.export_pdf') }}',
                    },
                    {
                        extend: 'print',
                        text: '{{ __('global.print') }}',
                    },
                    {
                        extend: 'colvis',
                        text: '{{ __('global.colvis') }}',
                    }
                ],
                pagingType: 'full_numbers',
                pageLength: 10,
                lengthMenu: [10, 25, 50, 100],
                language: {
                    paginate: {
                        first: "{{ __('global.first') }}",
                        previous: "{{ __('global.previous') }}",
                        next: "{{ __('global.next') }}",
                        last: "{{ __('global.last') }}",
                    }
                }
            });

        });

    </script>
@stop
