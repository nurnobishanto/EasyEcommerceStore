@extends('adminlte::page')

@section('title', __('global.update_delivery_zone'))

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>{{ __('global.update_delivery_zone')}}</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{ __('global.home')}}</a></li>
                <li class="breadcrumb-item"><a href="{{route('admin.delivery-zones.index')}}">{{ __('global.delivery_zones')}}</a></li>
                <li class="breadcrumb-item active">{{ __('global.update_delivery_zone')}}</li>
            </ol>

        </div>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{route('admin.delivery-zones.update',['delivery_zone'=>$delivery_zone->id])}}" method="POST" enctype="multipart/form-data" id="admin-form">
                        @method('PUT')
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
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="name">{{ __('global.delivery_zone')}} <span class="text-danger"> *</span></label>
                                    <input id="name" value="{{$delivery_zone->name}}" name="name" class="form-control" placeholder="{{ __('global.enter_delivery_zone')}}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="charge">{{ __('global.charge')}}<span class="text-danger"> *</span></label>
                                    <input id="charge" name="charge" value="{{$delivery_zone->charge}}" class="form-control" placeholder="{{ __('global.enter_charge')}}">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="status">{{__('global.select_status')}}<span class="text-danger"> *</span></label>
                                    <select name="status" class="form-control" id="status">
                                        <option value="active" @if("active" == $delivery_zone->status) selected @endif>{{__('global.active')}}</option>
                                        <option value="deactivate" @if("deactivate" == $delivery_zone->status) selected @endif>{{__('global.deactivate')}}</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        @can('delivery_zone_update')
                            <button class="btn btn-success" type="submit">{{ __('global.update')}}</button>
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
@section('css')

@stop

@section('js')
<script>
    $(document).ready(function() {

    });

</script>
@stop
