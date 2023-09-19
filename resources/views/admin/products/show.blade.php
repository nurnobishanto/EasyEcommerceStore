@extends('adminlte::page')

@section('title', __('global.view_product'))

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>{{__('global.view_product')}} - {{$product->title}}</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{__('global.home')}}</a></li>
                <li class="breadcrumb-item"><a href="{{route('admin.products.index')}}">{{__('global.products')}}</a></li>
                <li class="breadcrumb-item active">{{__('global.view_product')}}</li>
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
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th width="20%">Attribute</th>
                                                <th width="80%">Value</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>{{__('global.title')}}</td>
                                                <td>{{$product->title}}</td>
                                            </tr>
                                            <tr>
                                                <td>{{__('global.slug')}}</td>
                                                <td>{{$product->slug}}</td>
                                            </tr>
                                            <tr>
                                                <td>{{__('global.sku')}}</td>
                                                <td>{{$product->sku}}</td>
                                            </tr>
                                            <tr>
                                                <td>{{__('global.price')}}</td>
                                                <td>{{$product->price}}</td>
                                            </tr>
                                            <tr>
                                                <td>{{__('global.quantity')}}</td>
                                                <td>{{$product->quantity}}</td>
                                            </tr>
                                            <tr>
                                                <td>{{__('global.brand')}}</td>
                                                <td>{{$product->brand->name??'Deleted'}}</td>
                                            </tr>
                                            <tr>
                                                <td>{{__('global.categories')}}</td>
                                                <td class="text-capitalize">@foreach($product->categories as $cat){{$cat->name??'--'}}, @endforeach</td>
                                            </tr>
                                            <tr>
                                                <td>{{__('global.description')}}</td>
                                                <td>{!! $product->description !!}</td>
                                            </tr>
                                            <tr>
                                                <td>{{__('global.thumbnail')}}</td>
                                                <td><img src="{{asset('uploads/'.$product->thumbnail)}}" alt="{{$product->title}}" class="img-thumbnail" style="max-height: 150px; max-width: 150px"> </td>
                                            </tr>
                                            <tr>
                                                <td>{{__('global.gallery')}}</td>
                                                <td>
                                                    @foreach($product->gallery as $img)
                                                        <img src="{{asset('uploads/'.$img)}}" alt="{{$product->title}}" class="img-thumbnail" style="max-height: 150px; max-width: 150px">
                                                    @endforeach

                                                </td>
                                            </tr>
                                            <tr>
                                                <td>{{__('global.created_at')}} & {{__('global.created_by')}}</td>
                                                <td>At {{date_format($product->created_at,'d M y h:i A')}} by {{$product->createdBy->name??'--'}}</td>
                                            </tr>
                                            <tr>
                                                <td>{{__('global.updated_at')}} & {{__('global.updated_by')}}</td>
                                                <td>At {{date_format($product->updated_at,'d M y h:i A')}} by {{$product->updatedBy->name??'--'}}</td>
                                            </tr>
                                            <tr>
                                                <td>{{__('global.status')}} </td>
                                                <td class="text-capitalize">{{$product->status}}</td>
                                            </tr>
                                            <tr>
                                                <td>{{__('global.url')}} </td>
                                                <td class="text-capitalize">{{$product->status}}</td>
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
                            </div>



                        <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST">
                            @method('DELETE')
                            @csrf
                            <a href="{{route('admin.products.index')}}" class="btn btn-success" >Go Back</a>
                            @can('product_update')
                                <a href="{{route('admin.products.edit',['product'=>$product->id])}}" class="btn btn-warning "><i class="fa fa-pen"></i> Edit</a>
                            @endcan
                            @can('product_delete')
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
