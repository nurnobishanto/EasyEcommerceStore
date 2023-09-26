@extends('adminlte::page')

@section('title', __('global.page_content'))

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>{{__('global.page_content')}}</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{__('global.home')}}</a></li>
                <li class="breadcrumb-item active">{{__('global.page_content')}}</li>
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
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="site_about">{{ __('global.site_about')}}</label>
                                    <textarea id="site_about"  name="site_about" class="form-control summernote" placeholder="{{__('global.site_about')}}">{{getSetting('site_about')}}</textarea>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="site_contact">{{ __('global.site_contact')}}</label>
                                    <textarea id="site_contact"  name="site_contact" class="form-control summernote" placeholder="{{__('global.site_contact')}}">{{getSetting('site_contact')}}</textarea>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="site_privacy">{{ __('global.site_privacy')}}</label>
                                    <textarea id="site_privacy"  name="site_privacy" class="form-control summernote" placeholder="{{__('global.site_privacy')}}">{{getSetting('site_privacy')}}</textarea>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="site_terms">{{ __('global.site_terms')}}</label>
                                    <textarea id="site_terms"  name="site_terms" class="form-control summernote" placeholder="{{__('global.site_terms')}}">{{getSetting('site_terms')}}</textarea>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="site_return_policy">{{ __('global.site_return_policy')}}</label>
                                    <textarea id="site_return_policy"  name="site_return_policy" class="form-control summernote" placeholder="{{__('global.site_return_policy')}}">{{getSetting('site_return_policy')}}</textarea>
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
