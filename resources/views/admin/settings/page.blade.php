@extends('adminlte::page')

@section('title',$title)

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>{{$title}}</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{__('global.home')}}</a></li>
                <li class="breadcrumb-item active">{{$title}}</li>
            </ol>

        </div>
    </div>
@stop
@section('content')

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{route('admin.page-setting')}}" method="POST" enctype="multipart/form-data" id="page_setting">
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
                        <input name="slug" value="{{$slug}}" class="d-none">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="{{$heading}}">{{ __('global.'.$heading)}}</label>
                                    <input id="{{$heading}}" value="{{getSetting($heading)}}"  name="{{$heading}}" class="form-control" placeholder="{{__('global.'.$heading)}}">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="{{$content}}">{{ __('global.'.$content)}}</label>
                                    <textarea id="{{$content}}"  name="{{$content}}" class="form-control summernote" placeholder="{{__('global.'.$content)}}">{{getSetting($content)}}</textarea>
                                </div>
                            </div>
                        </div>

                        @can('page_setting_manage')
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
@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop
@section('plugins.Summernote',true)
@section('js')
    <script>
        $(document).ready(function() {

            $('.summernote').summernote();
        });

    </script>

@stop
