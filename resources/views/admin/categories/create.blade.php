@extends('adminlte::page')

@section('title', __('global.create_category'))

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>{{ __('global.create_category')}}</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{ __('global.home')}}</a></li>
                <li class="breadcrumb-item"><a href="{{route('admin.categories.index')}}">{{ __('global.categories')}}</a></li>
                <li class="breadcrumb-item active">{{ __('global.create_category')}}</li>
            </ol>

        </div>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{route('admin.categories.store')}}" method="POST" enctype="multipart/form-data" id="admin-form">
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
                                    <label for="name">{{ __('global.name')}}<span class="text-danger"> *</span></label>
                                    <input id="name" name="name" class="form-control" placeholder="{{ __('global.enter_category')}}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="slug">{{ __('global.slug')}}</label>
                                    <input id="slug" name="slug" class="form-control" placeholder="{{ __('global.enter_slug')}}">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="description">{{ __('global.description')}}</label>
                                    <textarea id="description" name="description" class="form-control" placeholder="{{ __('global.enter_description')}}"></textarea>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="parent_id">{{__('global.select_parent_category')}}</label>
                                    <select name="parent_id" class="select2 form-control" id="parent_id">
                                        <option value="">{{__('global.select_parent_category')}}</option>
                                        @foreach($categories as $category)
                                            <option value="{{$category->id}}">{{$category->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="thumbnail">{{__('global.select_photo')}}</label>
                                    <input name="thumbnail" type="file" class="form-control" id="thumbnail" accept="image/*">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="is_featured">{{__('global.featured')}}<span class="text-danger"> *</span></label>
                                    <select name="is_featured" class="form-control" id="is_featured">
                                        <option value="no">{{__('global.no')}}</option>
                                        <option value="yes">{{__('global.yes')}}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="status">{{__('global.select_status')}}<span class="text-danger"> *</span></label>
                                    <select name="status" class="form-control" id="status">
                                        <option value="active">{{__('global.active')}}</option>
                                        <option value="deactivate">{{__('global.deactivate')}}</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <img src="" alt="Selected Image" id="selected-image" style="display: none;max-height: 150px">
                            </div>

                        </div>

                        @can('category_create')
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
            $('.select2').select2({
                theme:'classic'
            });
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
