@extends('adminlte::page')

@section('title','Steadfast Setting')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Steadfast Setting</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{__('global.home')}}</a></li>
                <li class="breadcrumb-item active">Steadfast Setting</li>
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
                        <form action="{{route('admin.steadfast_setting')}}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="steadfast_api_key">Steadfast API Key</label>
                                        <input id="steadfast_api_key"  value="{{getSetting('steadfast_api_key')}}" name="steadfast_api_key" class="form-control" placeholder="Enter Steadfast API Key">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="steadfast_secret_key">Steadfast Secret Key</label>
                                        <input id="steadfast_secret_key"  value="{{getSetting('steadfast_secret_key')}}" name="steadfast_secret_key" class="form-control" placeholder="Enter Steadfast Secret Key">
                                    </div>
                                </div>
                                <input type="submit" value="Save Setting" class="btn btn-success form-control">
                            </div>
                        </form>
                    </div>
                    <div class="card-body">
                        <h3>Steadfast Balance : {{getSteadfastBalance()}}</h3>
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

