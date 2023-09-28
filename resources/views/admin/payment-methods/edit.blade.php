@extends('adminlte::page')

@section('title', __('global.update_payment_method'))

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>{{ __('global.update_payment_method')}}</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{ __('global.home')}}</a></li>
                <li class="breadcrumb-item"><a href="{{route('admin.payment-methods.index')}}">{{ __('global.payment_methods')}}</a></li>
                <li class="breadcrumb-item active">{{ __('global.update_payment_method')}}</li>
            </ol>

        </div>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{route('admin.payment-methods.update',['payment_method'=>$payment_method->id])}}" method="POST" enctype="multipart/form-data" id="admin-form">
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
                                    <label for="name">{{ __('global.payment_method')}} <span class="text-danger"> *</span></label>
                                    <input id="name" value="{{$payment_method->name}}" name="name" class="form-control" placeholder="{{ __('global.enter_payment_method')}}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="account_no">{{ __('global.account_no')}} <span class="text-danger"> *</span></label>
                                    <input id="account_no" name="account_no" value="{{$payment_method->account_no}}" class="form-control" placeholder="{{ __('global.enter_account_no')}}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="charge">{{ __('global.charge')}}<span class="text-danger"> *</span></label>
                                    <input id="charge" name="charge" value="{{$payment_method->charge}}" class="form-control" placeholder="{{ __('global.enter_charge')}}">
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label for="description">{{ __('global.description')}}</label>
                                    <textarea id="description" name="description" class="form-control" placeholder="{{ __('global.enter_description')}}">{{$payment_method->description}}</textarea>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="status">{{__('global.select_status')}}<span class="text-danger"> *</span></label>
                                    <select name="status" class="form-control" id="status">
                                        <option value="active" @if("active" == $payment_method->status) selected @endif>{{__('global.active')}}</option>
                                        <option value="deactivate" @if("deactivate" == $payment_method->status) selected @endif>{{__('global.deactivate')}}</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        @can('payment_method_update')
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
