@extends('adminlte::page')

@section('title', __('global.products'))

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>{{__('global.products')}}</h1>
            @can('product_create')
                <a href="{{route('admin.products.create')}}" class="btn btn-primary mt-2">{{__('global.add_new')}}</a>
            @endcan
            @can('product_delete')
                <a href="{{route('admin.products.trashed')}}" class="btn btn-danger mt-2">{{__('global.trash_list')}}</a>
            @endcan

        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{__('global.home')}}</a></li>
                <li class="breadcrumb-item active">{{__('global.products')}}</li>
            </ol>

        </div>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            @can('product_list')
                <div class="card">
                    <div class="card-body table-responsive">
                        <table id="adminsList" class="table  dataTable table-bordered table-striped">
                            <thead>
                            <tr>
                                <th width="10px">{{__('global.sl')}}</th>
                                <th width="50px">{{__('global.thumbnail')}}</th>
                                <th width="20%">{{__('global.title')}}</th>
                                <th>{{__('global.price')}}</th>
                                <th>{{__('global.quantity')}}</th>
                                <th>{{__('global.categories')}}</th>
                                <th>{{__('global.brands')}}</th>
                                <th>{{__('global.status')}}</th>
                                <th>{{__('global.featured')}}</th>
                                <th>{{__('global.action')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $count = 1; ?>
                            @foreach($products as $product)
                                <tr>
                                    <td>{{$count++}}</td>
                                    <td>
                                        <img class="rounded border" width="100px" src="{{asset('uploads/'.$product->thumbnail)}}" alt="{{$product->name}}">
                                    </td>
                                    <td>{{$product->title}}</td>
                                    <td>{{$product->price}}</td>
                                    <td>{{$product->quantity}}</td>
                                    <td>@foreach($product->categories as $cat) {{$cat->name}}, @endforeach</td>
                                    <td>{{$product->brand->name??'Deleted'}}</td>
                                    <td>
                                        @if($product->status=='active') <span class="badge-success badge">Active</span>
                                        @else <span class="badge-danger badge">Deactivate</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($product->is_featured=='yes') <span class="badge-success badge">{{__('global.yes')}}</span>
                                        @else <span class="badge-danger badge">{{__('global.no')}}</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST">
                                            @method('DELETE')
                                            @csrf
                                            @can('product_view')
                                                <a href="{{route('admin.products.show',['product'=>$product->id])}}" class="btn btn-info px-1 py-0 btn-sm"><i class="fa fa-eye"></i></a>
                                            @endcan
                                            @can('product_update')
                                                <a class="btn btn-primary px-1 py-0 btn-sm" href="{{route('admin.products.editor',['product'=>$product->id])}}"><i class="fa fa-cogs"></i></a>
                                                <a href="{{route('admin.products.edit',['product'=>$product->id])}}" class="btn btn-warning px-1 py-0 btn-sm"><i class="fa fa-pen"></i></a>
                                            @endcan
                                            @can('product_delete')
                                                <button onclick="isDelete(this)" class="btn btn-danger btn-sm px-1 py-0"><i class="fa fa-trash"></i></button>
                                            @endcan

                                        </form>
                                    </td>
                                </tr>
                            @endforeach

                            </tbody>
                            <tfoot>
                            <tr>
                                <th>{{__('global.sl')}}</th>
                                <th>{{__('global.thumbnail')}}</th>
                                <th>{{__('global.title')}}</th>
                                <th>{{__('global.price')}}</th>
                                <th>{{__('global.quantity')}}</th>
                                <th>{{__('global.categories')}}</th>
                                <th>{{__('global.brands')}}</th>
                                <th>{{__('global.status')}}</th>
                                <th>{{__('global.featured')}}</th>
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
