@extends('adminlte::page')

@section('title', __('global.create_order'))

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>{{ __('global.create_order')}}</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{ __('global.home')}}</a></li>
                <li class="breadcrumb-item"><a href="{{route('admin.orders.index')}}">{{ __('global.orders')}}</a></li>
                <li class="breadcrumb-item active">{{ __('global.create_order')}}</li>
            </ol>

        </div>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{route('admin.orders.store')}}" method="POST" enctype="multipart/form-data" id="admin-form">
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
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">{{ __('global.name')}}<span class="text-danger">*</span></label>
                                    <input id="name" name="name" class="form-control" placeholder="{{ __('global.enter_full_name')}}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="phone">{{ __('global.phone')}}<span class="text-danger">*</span></label>
                                    <input id="phone" name="phone" class="form-control" placeholder="{{ __('global.enter_phone')}}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="address">{{ __('global.address')}}<span class="text-danger">*</span></label>
                                    <textarea id="address" name="address" class="form-control" placeholder="{{ __('global.enter_address')}}"></textarea>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="order_note">{{ __('global.order_note')}}</label>
                                    <textarea id="order_note" name="order_note" class="form-control" placeholder="{{ __('global.enter_order_note')}}"></textarea>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="payment_method_id" class="form-label">Payment Method</label>
                                    <select id="payment_method_id" class="form-control" name="payment_method_id" >
                                        <option value="">Select Payment Method</option>
                                        <option value="cod">Cash on Delivery</option>
                                        @foreach(paymentMethods() as $pm)
                                            <option value="{{$pm->id}}">{{$pm->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="trxid" class="form-label">TrxID</label>
                                    <input  id="trxid" class="form-control"  name="trxid" placeholder="Enter Transaction id">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="paid_amount" class="form-label">Paid Amount</label>
                                    <input  id="paid_amount" type="number"  class="form-control" name="paid_amount" placeholder="Enter amount">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="discount_percent" class="form-label">Discount %</label>
                                    <input  id="discount_percent" type="number" value="{{getSetting('payment_discount')}}" class="form-control" name="discount_percent" placeholder="Enter Discount in %">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="max_discount" class="form-label">Max Discount Amount</label>
                                    <input  id="max_discount" type="number" value="{{getSetting('payment_max_discount')}}" class="form-control" name="max_discount" placeholder="Enter max discount amount">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="delivery_zone_id">{{__('global.select_delivery_zone')}}<span class="text-danger">*</span></label>
                                    <select name="delivery_zone_id" class="select2 form-control" id="delivery_zone_id" >
                                        <option value="">{{__('global.select_delivery_zone')}}</option>
                                        @foreach($delivery_zones as $delivery_zone)
                                            <option value="{{$delivery_zone->id}}">{{$delivery_zone->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="status">{{__('global.select_status')}}<span class="text-danger">*</span></label>
                                    <select name="status" class="form-control" id="status">
                                        <option value="pending">{{__('global.pending')}}</option>
                                        <option value="received">{{__('global.received')}}</option>
                                        <option value="delivered">{{__('global.delivered')}}</option>
                                        <option value="completed">{{__('global.completed')}}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label for="product">{{__('global.select_products')}}<span class="text-danger">*</span></label>
                                    <select name="" class="select2 form-control" id="product">
                                        <option value="">{{__('global.select_products')}}</option>
                                        @foreach($products as $product)
                                            <option value="{{ $product->id }}" data-price="{{ $product->price }}" data-max="{{$product->quantity}}" data-img="{{ asset('uploads/'.$product->thumbnail) }}">
                                                {{ $product->title }} - Tk.{{ $product->price }} - ({{ $product->quantity }})
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <table class="table" id="selected-products">
                                    <thead>
                                    <tr>
                                        <th>Product</th>
                                        <th>Quantity</th>
                                        <th>Price</th>
                                        <th>Subtotal</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <!-- Add selected products and their details here -->
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-md-4">
                                <img src="" alt="Selected Image" id="selected-image" style="display: none;max-height: 150px">
                            </div>
                            <div class="col-md-12">
                                <div id="image-preview">
                                    <!-- Selected images will be displayed here -->
                                </div>
                            </div>

                        </div>

                        @can('order_create')
                            <button class="btn btn-success" type="submit">{{ __('global.create')}}</button>
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
@section('plugins.Select2',true)
@section('plugins.Summernote',true)
@section('css')
<style>
    .select2-container--default .select2-selection--multiple .select2-selection__choice{
        color: black;
    }
    .select2{
        max-width: 100%!important;
    }
</style>
@stop

@section('js')

    <script>
        $(document).ready(function () {
            $('.select2').select2({
                theme:'classic'
            });
            // Initialize an array to store selected products
            var selectedProducts = [];

            // Listen for changes in the product dropdown
            $('#product').change(function () {
                var selectedProductId = $(this).val();
                if (selectedProductId !== '') {
                    // Retrieve product details (you may have to fetch these from your backend)

                    var productName = $(this).find('option:selected').text();
                    var productPrice = parseFloat($(this).find('option:selected').data('price'));
                    var img = $(this).find('option:selected').data('img');
                    var max = $(this).find('option:selected').data('max');
                    // Check if the product is not already in the selected products array
                    if (!selectedProducts.some(product => product['id'] === selectedProductId)) {

                        // Create a new object to represent the selected product
                        var selectedProduct = {
                            id: selectedProductId,
                            name: productName,
                            price: productPrice,
                            img: img,
                            max: max,
                            quantity: 1, // Default quantity
                            subtotal: productPrice // Initial subtotal
                        };
                        // Add the selected product to the array
                        selectedProducts.push(selectedProduct);
                        // Add the selected product to the table
                        addToTable(selectedProduct);
                        // Update the total
                        updateTotal();
                    }
                }
            });

            // Listen for changes in quantity inputs
            $('#selected-products').on('input', '.product-quantity', function () {
                var selectedProductId = $(this).closest('tr').data('product-id');
                var max = parseInt($(this).data('max'));
                var quantity = parseInt($(this).val());
                console.log(max)
                if(max >= quantity){
                    for(var i = 0;i<selectedProducts.length;i++){
                        if(selectedProducts[i]['id'] == selectedProductId){
                            var selectedProduct = selectedProducts[i];
                            break
                        }
                    }
                    // Update the quantity and subtotal
                    selectedProduct['quantity'] = quantity;
                    selectedProduct['subtotal'] = selectedProduct.price * quantity;
                    // Update the table and total
                    updateTable(selectedProduct);
                    updateTotal();
                }else {
                    $(this).val(max)
                    for(var i = 0;i<selectedProducts.length;i++){
                        if(selectedProducts[i]['id'] == selectedProductId){
                            var selectedProduct = selectedProducts[i];
                            break
                        }
                    }
                    // Update the quantity and subtotal
                    selectedProduct['quantity'] = max;
                    selectedProduct['subtotal'] = selectedProduct.price * max;
                    // Update the table and total
                    updateTable(selectedProduct);
                    updateTotal();
                }



            });

            // Listen for clicks on remove buttons
            $('#selected-products').on('click', '.remove-product', function () {
                var selectedProductId = $(this).closest('tr').data('product-id');

                // Remove the selected product from the array
                 selectedProducts = selectedProducts.filter(function(el) { return el.id != selectedProductId; });

                // Remove the table row
                $(this).closest('tr').remove();
                // Update the total
                updateTotal();
            });

            // Function to add a selected product to the table
            function addToTable(product) {
                $('#selected-products tbody').append(`
            <tr data-product-id="${product.id}">
                <td><img src="${product.img}" class="img-thumbnail" style="max-width: 50px; max-height: 50px"></td>
                <input type="hidden" name="product_ids[]" value="${product.id}">
                <td>${product.name}</td>
                <td><input type="number" name="product_quantities[]" max="${product.max}" data-max="${product.max}" class="form-control product-quantity" value="${product.quantity}"></td>
                <td class="product-price">${product.price}</td>
                <td class="product-subtotal">${product.subtotal}</td>
                <td><button class="btn btn-danger remove-product">Remove</button></td>
            </tr>
        `);
            }

            // Function to update a selected product in the table
            function updateTable(product) {
                var row = $(`#selected-products tr[data-product-id="${product.id}"]`);
                row.find('.product-quantity').val(product.quantity);
                row.find('.product-subtotal').text(product.subtotal);
            }

            // Function to update the total
            function updateTotal() {
                var total = selectedProducts.reduce((acc, product) => acc + product.subtotal, 0);
                $('#total').text(total);
            }
        });
    </script>

@stop
