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
                                                <td>{{__('global.ip_address')}}</td>
                                                <td>{{$order->ip_address}}
                                                    @if($order->ip_address)
                                                        @if(isIpBlock($order->ip_address))
                                                            <a href="{{route('admin.ip-blocks.unblock',['id'=>$order->id])}}" class="btn btn-success btn-sm">Un BlocK</a>
                                                        @else
                                                            <a href="{{route('admin.ip-blocks.block',['id'=>$order->id])}}" class="btn btn-danger btn-sm">Block</a>
                                                        @endif
                                                    @endif
                                                </td>
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
                                                <td class="text-capitalize">{{$order->status}} - {{$order->delivery_method}} - {{$order->delivery_id}}</td>
                                            </tr>
                                            <tr>
                                                <td>{{__('global.delivery_status')}} </td>
                                                <td class="text-capitalize">{{$order->delivery_status}}</td>
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
                            @if(($order->status == 'pending' || $order->status =='received') && getSetting('steadfast_status'))
                                <a href="{{route('admin.steadfast_delivery_request',['id'=>$order->id])}}" class="btn btn-info">Deliver with Steadfast</a>
                            @endif
                        </form>


                </div>
            </div>

            @if(($order->status == 'pending' || $order->status =='received') && getSetting('pathao_status')=='on' )
            <div class="card">
                <div class="card-body">
                  <h2>Delivery with Pathao</h2>
                    <form action="{{route('admin.delivery_request',['id'=>$order->id])}}" method="post" id="priceCalculationForm">
                        @csrf
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
                            <div class="col-md-3 col-sm-4 col-6">
                                <div class="form-group">
                                    <label for="store">Select Store: <span class="text-danger"> *</span></label>
                                    <select class="form-control" id="store" name="store_id">
                                        <option value="">Select Store</option>
                                        @foreach(pathaoStoreList() as $store)
                                        <option value="{{$store['store_id']}}">{{$store['store_name']}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-4 col-6">
                                <div class="form-group">
                                    <label for="city">Select City: <span class="text-danger"> *</span></label>
                                    <select class="form-control" id="city" name="city_id">
                                        <option value="">Select City</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-4 col-6">
                                <div class="form-group">
                                    <label for="zone">Select Zone:<span class="text-danger"> *</span></label>
                                    <select id="zone" name="zone_id" class="form-control">
                                        <option value="">Select Zone</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-4 col-6">
                                <div class="form-group">
                                    <label for="area">Select Area:<span class="text-danger"> *</span></label>
                                    <select id="area" name="area_id" class="form-control">
                                        <option value="">Select Area</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-4 col-6">
                                <div class="form-group">
                                    <label for="delivery_type">Delivery Type <span class="text-danger"> *</span></label>
                                    <select class="form-control" id="delivery_type" name="delivery_type">
                                        <option value="48">Normal Delivery</option>
                                        <option value="24">Express Delivery</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-4 col-6">
                                <div class="form-group">
                                    <label for="item_type">Product Type <span class="text-danger"> *</span></label>
                                    <select class="form-control" id="item_type" name="item_type">
                                        <option value="2">Parcel</option>
                                        <option value="1">Document</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-4 col-6">
                                <div class="form-group">
                                    <label for="item_weight">Weight (KG)<span class="text-danger"> *</span></label>
                                    <input class="form-control" id="item_weight" type="number" max="10" value="0.5" min="0.5" placeholder="Enter Product weight in kg" name="item_weight">
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-4 col-6">
                                <div class="form-group">
                                    <label for="priceResult">Delivery Charge</label>
                                    <div id="pathaoSpinner" class="spinner-border d-none" role="status">
                                        <span class="sr-only">Loading...</span>
                                    </div>
                                    <input class="form-control " id="pathaoPriceResult" value="..." disabled>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-4 col-6">
                                <input class="btn btn-primary form-control" value="Delivery Request" type="submit">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            @endif

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
    <script>
        function calculateDeliveryCharge() {
            $('#pathaoPriceResult').addClass('d-none')
            $('#pathaoPriceResult').removeClass('d-block')

            $('#pathaoSpinner').removeClass('d-none')
            $('#pathaoSpinner').addClass('d-block')
            var csrfToken = "{{ csrf_token() }}";
            var city_id = $('#city').val();
            var zone_id = $('#zone').val();
            var store_id = $('#store').val();
            var item_type = $('#item_type').val();
            var delivery_type = $('#delivery_type').val();
            var item_weight = $('#item_weight').val();

            if (city_id === ''){
                console.log('City ID Empty')
            }else if(zone_id === ''){
                console.log('Zone ID Empty')
            }else
            {
                $.ajax({
                    type: 'POST',
                    url: '{{route('pathao_price')}}',
                    data: {
                        _token: csrfToken,
                        store_id: store_id,
                        item_type: item_type,
                        delivery_type: delivery_type,
                        item_weight: item_weight,
                        recipient_city: city_id,
                        recipient_zone: zone_id,

                    },
                    success: function (data) {
                        $('#pathaoSpinner').addClass('d-none')
                        $('#pathaoSpinner').removeClass('d-block')

                        $('#pathaoPriceResult').removeClass('d-none')
                        $('#pathaoPriceResult').addClass('d-block')

                        $('#pathaoPriceResult').val(data.price);
                    },
                    error: function (xhr, textStatus, errorThrown) {
                        // Handle errors
                        $('#pathaoSpinner').addClass('d-none')
                        $('#pathaoSpinner').removeClass('d-block')

                        $('#pathaoPriceResult').removeClass('d-none')
                        $('#pathaoPriceResult').addClass('d-block')
                        $('#pathaoPriceResult').val("Error: " + errorThrown);

                    }
                });
            }
        }

        $(document).ready(function () {
            // Populate the city dropdown initially
            $.get('{{route('pathao_city_lists')}}', function (data) {
                var citySelect = $('#city');
                citySelect.empty();
                citySelect.append($('<option>').text('Select City').attr('value', ''));
                $.each(data, function (key, value) {
                    citySelect.append($('<option>').text(value).attr('value', key));
                });

            });

            // When the city dropdown changes, populate the zone dropdown
            $('#city').change(function () {
                var cityId = $(this).val();
                var zoneSelect = $('#zone');
                zoneSelect.empty();
                zoneSelect.append($('<option>').text('Select Zone').attr('value', ''));
                if (cityId !== '') {
                    var routeUrl = "{{ route('pathao_zone_lists', ['id' => ':cityId']) }}";
                    routeUrl = routeUrl.replace(':cityId', cityId);
                    $.get(routeUrl, function (data) {
                        $.each(data, function (key, value) {
                            zoneSelect.append($('<option>').text(value).attr('value', key));
                        });
                    });
                }
            });

            // When the zone dropdown changes, populate the area dropdown
            $('#zone').change(function () {
                var zoneId = $(this).val();
                var areaSelect = $('#area');
                areaSelect.empty();
                areaSelect.append($('<option>').text('Select Area').attr('value', ''));
                if (zoneId !== '') {
                    var routeUrl = "{{ route('pathao_area_lists', ['id' => ':zoneId']) }}";
                    routeUrl = routeUrl.replace(':zoneId', zoneId);
                    $.get(routeUrl, function (data) {
                        $.each(data, function (key, value) {
                            areaSelect.append($('<option>').text(value).attr('value', key));
                        });
                    });
                }
            });
            $('#area,#store,#item_type,#delivery_type,#item_weight').change(function () {
                calculateDeliveryCharge();
            });
        });
    </script>
@stop
