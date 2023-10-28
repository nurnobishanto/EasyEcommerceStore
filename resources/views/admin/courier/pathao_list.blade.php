@extends('adminlte::page')

@section('title','Pathao Store List')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Pathao Store List</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{__('global.home')}}</a></li>
                <li class="breadcrumb-item active">Pathao Store List</li>
            </ol>

        </div>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            @can('category_list')
                <div class="card">
                    <div class="card-header">
                        <form action="{{route('admin.pathao_setting')}}" method="post" enctype="multipart/form-data">
                            @csrf
                           <div class="row">
                               <div class="col-md-4">
                                   <div class="form-group">
                                       <label for="pathao_status">Pathao Status</label>
                                       <select id="pathao_status" disabled name="pathao_status" class="form-control">
                                           <option value="on" @if(getSetting('pathao_status') == 'on') selected @endif >ON</option>
                                           <option value="off" @if(getSetting('pathao_status') == 'off') selected @endif >OFF</option>
                                       </select>
                                   </div>
                               </div>
                               <div class="col-md-4">
                                   <div class="form-group">
                                       <label for="pathao_grant_type">Pathao Grant Type</label>
                                       <select id="pathao_grant_type" name="pathao_grant_type" class="form-control">
                                           <option value="password" @if(getSetting('pathao_grant_type') == 'password') selected @endif >PASSWORD</option>
                                       </select>
                                   </div>
                               </div>
                               <div class="col-md-4">
                                   <div class="form-group">
                                       <label for="pathao_base_url">Pathao Mode</label>
                                       <select id="pathao_base_url" name="pathao_base_url" class="form-control">
                                           <option value="https://courier-api-sandbox.pathao.com" @if(getSetting('pathao_base_url') == 'https://courier-api-sandbox.pathao.com') selected @endif >Sandbox</option>
                                           <option value="https://api-hermes.pathao.com" @if(getSetting('pathao_base_url') == 'https://api-hermes.pathao.com') selected @endif >Production</option>
                                       </select>
                                   </div>
                               </div>
                               <div class="col-md-4">
                                   <div class="form-group">
                                       <label for="pathao_client_id">Pathao Client ID</label>
                                       <input id="pathao_client_id"  value="{{getSetting('pathao_client_id')}}" name="pathao_client_id" class="form-control" placeholder="Enter Pathao Client ID">
                                   </div>
                               </div>
                               <div class="col-md-4">
                                   <div class="form-group">
                                       <label for="pathao_client_secret">Pathao Client Secret</label>
                                       <input id="pathao_client_secret"  value="{{getSetting('pathao_client_secret')}}" name="pathao_client_secret" class="form-control" placeholder="Enter Pathao Client Secret">
                                   </div>
                               </div>
                               <div class="col-md-4">
                                   <div class="form-group">
                                       <label for="pathao_client_email">Pathao Client Email</label>
                                       <input id="pathao_client_email" type="email" value="{{getSetting('pathao_client_email')}}" name="pathao_client_email" class="form-control" placeholder="Enter Pathao Client Email">
                                   </div>
                               </div>
                               <div class="col-md-4">
                                   <div class="form-group">
                                       <label for="pathao_client_password">Pathao Client Password</label>
                                       <input id="pathao_client_password" type="password" value="{{getSetting('pathao_client_password')}}" name="pathao_client_password" class="form-control" placeholder="Enter Pathao Client Password">
                                   </div>
                               </div>
                               <div class="col-md-4">
                                   <div class="form-group">
                                       <label for="pathao_sender_name">Pathao Sender Name</label>
                                       <input id="pathao_sender_name" type="text" value="{{getSetting('pathao_sender_name')}}" name="pathao_sender_name" class="form-control" placeholder="Enter Pathao Sender Name">
                                   </div>
                               </div>
                               <div class="col-md-4">
                                   <div class="form-group">
                                       <label for="pathao_sender_phone">Pathao Sender Phone</label>
                                       <input id="pathao_sender_phone" type="text" value="{{getSetting('pathao_sender_phone')}}" name="pathao_sender_phone" class="form-control" placeholder="Enter Pathao Sender Phone">
                                   </div>
                               </div>
                               <div class="col-md-4">
                                   <div class="form-group">
                                       <label for="pathao_webhook_secret">Webhook Secret</label>
                                       <input id="pathao_webhook_secret" type="text" value="{{getSetting('pathao_webhook_secret')}}" name="pathao_webhook_secret" class="form-control" placeholder="Enter Pathao Webhook Secret">
                                   </div>
                               </div>
                               <div class="col-md-4">
                                   <div class="form-group">
                                       <input type="submit" value="Save Setting" class="btn btn-success form-control mt-3">
                                   </div>
                               </div>
                             
                           </div>
                        </form>
                        <p>Webhook Integration Callback URL : {{url('/pathao-status')}}</p>
                    </div>
                    <div class="card-body table-responsive">
                        <table id="adminsList" class="table  dataTable table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>Store ID</th>
                                <th>Store Name</th>
                                <th>Store Address</th>
                                <th>Status</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach(pathaoStoreList() as $list)
                                <tr>
                                    <td>{{$list['store_id']}}</td>
                                    <td>{{$list['store_name']}}</td>
                                    <td>{{$list['store_address']}}</td>
                                    <td>{{$list['is_active']?'Active':'Deactivated'}}</td>
                                </tr>
                            @endforeach

                            </tbody>
                            <tfoot>
                            <tr>
                                <th>Store ID</th>
                                <th>Store Name</th>
                                <th>Store Address</th>
                                <th>Status</th>
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
