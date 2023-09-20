@extends('adminlte::page')

@section('title', __('global.create_product'))

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>{{ __('global.create_product')}}</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{ __('global.home')}}</a></li>
                <li class="breadcrumb-item"><a href="{{route('admin.products.index')}}">{{ __('global.products')}}</a></li>
                <li class="breadcrumb-item active">{{ __('global.create_product')}}</li>
            </ol>

        </div>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">

                <div class="card-body">
                    <span class="text-info text-bold mb-2">Image Size : 4:3, 720X540, 800X600</span>
                    <form action="{{route('admin.products.store')}}" method="POST" enctype="multipart/form-data" id="admin-form">
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
                                    <label for="title">{{ __('global.title')}}<span class="text-danger"> *</span></label>
                                    <input id="title" name="title" class="form-control" placeholder="{{ __('global.enter_title')}}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="slug">{{ __('global.slug')}}</label>
                                    <input id="slug" name="slug" class="form-control" placeholder="{{ __('global.enter_slug')}}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="price">{{ __('global.price')}}<span class="text-danger"> *</span></label>
                                    <input id="price" name="price" class="form-control" placeholder="{{ __('global.enter_price')}}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="regular_price">{{ __('global.regular_price')}}</label>
                                    <input id="regular_price" name="regular_price" class="form-control" placeholder="{{ __('global.enter_regular_price')}}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="quantity">{{ __('global.quantity')}}<span class="text-danger"> *</span></label>
                                    <input id="quantity" name="quantity" class="form-control" placeholder="{{ __('global.enter_quantity')}}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="sku">{{ __('global.sku')}}</label>
                                    <input id="sku" name="sku" class="form-control" placeholder="{{ __('global.enter_sku')}}">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="categories">{{__('global.select_category')}}<span class="text-danger"> *</span></label>
                                    <select name="categories[]" class="select2 form-control" id="categories" multiple>
                                        <option value="">{{__('global.select_category')}}</option>
                                        @foreach($categories as $cat)
                                            <option value="{{$cat->id}}">{{$cat->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="brand_id">{{__('global.select_brand')}}<span class="text-danger"> *</span></label>
                                    <select name="brand_id" class="select2 form-control" id="brand_id" >
                                        <option value="">{{__('global.select_brand')}}</option>
                                        @foreach($brands as $brand)
                                            <option value="{{$brand->id}}">{{$brand->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label for="description">{{ __('global.description')}}</label>
                                    <textarea id="description" name="description" class="form-control" placeholder="{{ __('global.enter_description')}}"></textarea>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="thumbnail">{{__('global.select_photo')}}</label>
                                    <input name="thumbnail" type="file" class="form-control" id="thumbnail" accept="image/*">
                                    <img src="" class="img-thumbnail" alt="Selected Image" id="selected-image" style="display: none;max-height: 100px">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="gallery">{{__('global.select_gallery_images')}}</label>
                                    <input name="gallery[]" type="file" class="form-control" id="gallery" accept="image/*" multiple>
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

                            <div class="col-md-12">
                                <div id="image-preview">
                                    <!-- Selected images will be displayed here -->
                                </div>
                            </div>

                        </div>

                        @can('product_create')
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
@section('plugins.Summernote',true)
@section('css')
<style>
    .select2-container--default .select2-selection--multiple .select2-selection__choice{
        color: black;
    }
    .select2{
        max-width: 100%!important;
    }
</style>
@stop

@section('js')
    <script>
        // Function to display selected images as thumbnails
        function displaySelectedImages(input) {
            var imagePreview = document.getElementById('image-preview');
            imagePreview.innerHTML = ''; // Clear previous images

            if (input.files && input.files.length > 0) {
                for (var i = 0; i < input.files.length; i++) {
                    var file = input.files[i];
                    if (file.type.match('image')) {
                        var reader = new FileReader();

                        reader.onload = function(e) {
                            var thumbnail = document.createElement('img');
                            thumbnail.src = e.target.result;
                            thumbnail.style.maxWidth = '150px'; // Adjust the max width as needed
                            thumbnail.style.marginRight = '10px'; // Add some spacing
                            imagePreview.appendChild(thumbnail);
                        }

                        reader.readAsDataURL(file);
                    }
                }
            }
        }

        // Add an event listener to the file input
        var galleryInput = document.getElementById('gallery');
        galleryInput.addEventListener('change', function() {
            displaySelectedImages(this);
        });
    </script>
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
