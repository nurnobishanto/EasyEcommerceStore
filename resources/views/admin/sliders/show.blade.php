@extends('adminlte::page')

@section('title', __('global.view_slider'))

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>{{__('global.view_slider')}} - {{$slider->title}}</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{__('global.home')}}</a></li>
                <li class="breadcrumb-item"><a href="{{route('admin.sliders.index')}}">{{__('global.sliders')}}</a></li>
                <li class="breadcrumb-item active">{{__('global.view_slider')}}</li>
            </ol>

        </div>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
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
                                        <label for="title">{{ __('global.title')}}</label>
                                        <input id="title" name="title" class="form-control"  value="{{$slider->title}}" disabled>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="url">{{ __('global.url')}}</label>
                                        <input id="url" name="url" class="form-control" value="{{$slider->url}}" disabled>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="target">{{ __('global.target')}}</label>
                                        <select name="target" class="form-control" id="target" disabled>
                                            <option value="" @if("" == $slider->target) selected @endif>{{__('global.same_page')}}</option>
                                            <option value="_blank" @if("_blank" == $slider->target) selected @endif>{{__('global.open_new_window')}}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="order">{{ __('global.order')}}</label>
                                        <input id="order" name="order" class="form-control" disabled value="{{$slider->order}}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="description">{{ __('global.description')}}</label>
                                        <textarea id="description" name="description" class="form-control" disabled>{{$slider->description}}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="status">{{__('global.status')}}</label>
                                        <input id="status" name="status" class="form-control" value="{{$slider->status}}" disabled>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="created_by">{{__('global.created_by')}}</label>
                                        <input id="created_by" name="created_by" class="form-control" value="{{$slider->createdBy->name}}" disabled>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="updated_by">{{__('global.updated_by')}}</label>
                                        <input id="updated_by" name="updated_by" class="form-control" value="{{$slider->updatedBy->name}}" disabled>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>{{__('global.image')}}</label>
                                        <img src="{{asset('uploads/'.$slider->image)}}" alt="{{$slider->name}}" class="img-fluid d-block" style="max-height: 150px">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>{{__('global.background')}}</label>
                                        <img src="{{asset('uploads/'.$slider->background)}}" alt="{{$slider->name}}" class="img-fluid d-block" style="max-height: 150px">
                                    </div>
                                </div>

                            </div>



                        <form action="{{ route('admin.sliders.destroy', $slider->id) }}" method="POST">
                            @method('DELETE')
                            @csrf
                            <a href="{{route('admin.sliders.index')}}" class="btn btn-success" >Go Back</a>
                            @can('slider_update')
                                <a href="{{route('admin.sliders.edit',['slider'=>$slider->id])}}" class="btn btn-warning "><i class="fa fa-pen"></i> Edit</a>
                            @endcan
                            @can('slider_delete')
                                <button onclick="isDelete(this)" class="btn btn-danger"><i class="fa fa-trash"></i> Delete</button>
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
        function checkSinglePermission(idName, className,inGroupCount,total,groupCount) {
            if($('.'+className+' input:checked').length === inGroupCount){
                $('#'+idName).prop('checked',true);
            }else {
                $('#'+idName).prop('checked',false);
            }
            if($('.permissions input:checked').length === total+groupCount){
                $('#select_all').prop('checked',true);
            }else {
                $('#select_all').prop('checked',false);
            }
        }

        function checkPermissionByGroup(idName, className,total,groupCount) {
            if($('#'+idName).is(':checked')){
                $('.'+className+' input').prop('checked',true);
            }else {
                $('.'+className+' input').prop('checked',false);
            }
            if($('.permissions input:checked').length === total+groupCount){
                $('#select_all').prop('checked',true);
            }else {
                $('#select_all').prop('checked',false);
            }
        }

        $('#select_all').click(function(event) {
            if(this.checked) {
                // Iterate each checkbox
                $(':checkbox').each(function() {
                    this.checked = true;
                });
            } else {
                $(':checkbox').each(function() {
                    this.checked = false;
                });
            }
        });
    </script>
@stop
