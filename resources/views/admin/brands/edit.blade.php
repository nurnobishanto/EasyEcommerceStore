@extends('adminlte::page')

@section('title', __('global.update_brand'))

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>{{ __('global.update_brand')}}</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{ __('global.home')}}</a></li>
                <li class="breadcrumb-item"><a href="{{route('admin.brands.index')}}">{{ __('global.brands')}}</a></li>
                <li class="breadcrumb-item active">{{ __('global.update_brand')}}</li>
            </ol>

        </div>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{route('admin.brands.update',['brand'=>$brand->id])}}" method="POST" enctype="multipart/form-data" id="admin-form">
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
                                    <label for="name">{{ __('global.name')}}<span class="text-danger"> *</span></label>
                                    <input id="name" name="name" value="{{$brand->name}}" class="form-control" placeholder="{{ __('global.enter_brand')}}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="thumbnail">{{__('global.select_photo')}}</label>
                                    <input name="thumbnail" type="file" class="form-control" id="thumbnail" accept="image/*">
                                    <input name="thumbnail_old"  class="d-none" id="thumbnail" value="{{$brand->thumbnail}}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="slug">{{ __('global.slug')}}</label>
                                    <input id="slug" name="slug" value="{{$brand->slug}}" class="form-control" placeholder="{{ __('global.enter_slug')}}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="is_featured">{{__('global.featured')}} <span class="text-danger"> *</span></label>
                                    <select name="is_featured" class="form-control" id="is_featured">
                                        <option value="no" @if($brand->is_featured == 'no') selected @endif>{{__('global.no')}}</option>
                                        <option value="yes" @if($brand->is_featured == 'yes') selected @endif>{{__('global.yes')}}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="status">{{__('global.select_status')}}<span class="text-danger"> *</span></label>
                                    <select name="status" class="form-control" id="status">
                                        <option value="active" @if($brand->status == 'active') selected @endif>{{__('global.active')}}</option>
                                        <option value="deactivate" @if($brand->status == 'deactivate') selected @endif>{{__('global.deactivate')}}</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <img src="{{asset('uploads/'.$brand->thumbnail)}}" alt="Selected Image" id="selected-image" style="max-height: 150px">
                            </div>

                        </div>

                        @can('brand_update')
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
    <style>
        .select2-container--default .select2-selection--multiple .select2-selection__choice{
            color: black;
        }
    </style>
@stop

@section('js')
<script>
    $(document).ready(function() {
        $('.select2').select2();
    });
    document.addEventListener('DOMContentLoaded', function () {
        const imageForm = document.getElementById('admin-form');
        const selectedImage = document.getElementById('selected-image');

        imageForm.addEventListener('change', function () {
            const fileInput = this.querySelector('input[type="file"]');
            const file = fileInput.files[0];

            if (file) {
                const imageUrl = URL.createObjectURL(file);
                selectedImage.src = imageUrl;
                selectedImage.style.display = 'block';
            } else {
                selectedImage.src = '';
                selectedImage.style.display = 'none';
            }
        });
    });
</script>
@stop
