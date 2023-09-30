@extends('adminlte::page')

@section('title', __('global.checkout_setting'))

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>{{__('global.checkout_setting')}}</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{__('global.home')}}</a></li>
                <li class="breadcrumb-item active">{{__('global.checkout_setting')}}</li>
            </ol>

        </div>
    </div>
@stop
@section('content')

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{route('admin.checkout-setting')}}" method="POST" enctype="multipart/form-data" id="code_setting">
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
                                    <label for="checkout_description">{{ __('global.checkout_description')}}</label>
                                    <textarea id="checkout_description" rows="2" name="checkout_description" class="form-control" placeholder="{{__('global.checkout_description')}}">{{getSetting('checkout_description')}}</textarea>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="payment_discount">{{ __('global.payment_discount')}} %</label>
                                    <input id="payment_discount"type="number" name="payment_discount" class="form-control" value="{{getSetting('payment_discount')}}" placeholder="{{__('global.payment_discount')}}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="payment_max_discount">{{ __('global.payment_max_discount')}}</label>
                                    <input id="payment_max_discount"type="number" name="payment_max_discount" class="form-control" value="{{getSetting('payment_max_discount')}}" placeholder="{{__('global.payment_max_discount')}}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="currency">{{ __('global.currency')}}</label>
                                    <input id="currency"  value="{{getSetting('currency')}}" name="currency" class="form-control" placeholder="{{ __('global.currency')}}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="payment_method">{{ __('global.payment_method')}}</label>
                                    <select id="payment_method"  name="payment_method" class="form-control">
                                        <option value="show" @if(getSetting('payment_method') == 'show') selected @endif>Show</option>
                                        <option value="hide" @if(getSetting('payment_method') == 'hide') selected @endif>Hide</option>
                                    </select>
                                </div>
                            </div>
{{--                            <div class="col-md-4">--}}
{{--                                <div class="form-group">--}}
{{--                                    <label for="dc_required">{{ __('global.dc_required')}}</label>--}}
{{--                                    <select id="dc_required"  name="dc_required" class="form-control">--}}
{{--                                        <option value="yes" @if(getSetting('dc_required') == 'yes') selected @endif>Yes</option>--}}
{{--                                        <option value="no" @if(getSetting('dc_required') == 'no') selected @endif>No</option>--}}
{{--                                    </select>--}}
{{--                                </div>--}}
{{--                            </div>--}}
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="inquiry_number_one">{{ __('global.inquiry_number_one')}}</label>
                                    <input id="inquiry_number_one"  value="{{getSetting('inquiry_number_one')}}" name="inquiry_number_one" class="form-control" placeholder="{{ __('global.inquiry_number_one')}}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="inquiry_number_two">{{ __('global.inquiry_number_two')}}</label>
                                    <input id="inquiry_number_two"  value="{{getSetting('inquiry_number_two')}}" name="inquiry_number_two" class="form-control" placeholder="{{ __('global.inquiry_number_two')}}">
                                </div>
                            </div>


                        </div>

                        @can('code_setting_manage')
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

@section('js')
    <script>
        $(document).ready(function() {
            toastr.now();
        });

    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const imageForm = document.getElementById('site_setting');

            const site_faviconImage = document.getElementById('selected-site_favicon');
            const site_logoImage = document.getElementById('selected-site_logo');

            imageForm.addEventListener('change', function () {
                const site_favicon = this.querySelector('input[name="site_favicon"]').files[0];
                const site_logo = this.querySelector('input[name="site_logo"]').files[0];
                if (site_favicon) {
                    site_faviconImage.src = URL.createObjectURL(site_favicon);
                }
                if (site_logo) {
                    site_logoImage.src = URL.createObjectURL(site_logo);
                }
            });
        });
    </script>
@stop
