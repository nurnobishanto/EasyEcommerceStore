@extends('adminlte::page')

@section('title', __('global.site_setting'))

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>{{__('global.site_setting')}}</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{__('global.home')}}</a></li>
                <li class="breadcrumb-item active">{{__('global.site_setting')}}</li>
            </ol>

        </div>
    </div>
@stop
@section('content')

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{route('admin.site-setting')}}" method="POST" enctype="multipart/form-data" id="site_setting">
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
                                    <label for="site_name">{{ __('global.site_name')}}</label>
                                    <input id="site_name"  value="{{getSetting('site_name')}}" name="site_name" class="form-control" placeholder="{{ __('global.enter_site_name')}}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="site_tagline">{{ __('global.site_tagline')}}</label>
                                    <input id="site_tagline" value="{{getSetting('site_tagline')}}" name="site_tagline" class="form-control" placeholder="{{ __('global.enter_site_tagline')}}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="site_address">{{ __('global.site_address')}}</label>
                                    <input id="site_address" value="{{getSetting('site_address')}}" name="site_address" class="form-control" placeholder="{{ __('global.site_address')}}">
                                </div>
                            </div>


                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="site_description">{{ __('global.site_description')}}</label>
                                    <textarea id="site_description" rows="4" name="site_description" class="form-control" placeholder="{{__('global.enter_site_description')}}">{{getSetting('site_description')}}</textarea>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="site_favicon">{{ __('global.site_favicon')}} <span class="text-muted">(32 x 32)</span></label>
                                    <input id="site_favicon"  name="site_favicon" class="form-control" type="file" accept="image">
                                    <img src="{{asset('uploads/'.getSetting('site_favicon'))}}" class="img-thumbnail"  id="selected-site_favicon" style="max-height: 70px">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="site_logo">{{ __('global.site_logo')}} <span class="text-muted">(250 x 70)</span></label>
                                    <input id="site_logo"  name="site_logo" class="form-control" type="file" accept="image">
                                    <img src="{{asset('uploads/'.getSetting('site_logo'))}}" class="img-thumbnail"  id="selected-site_logo" style="max-height: 70px">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="top_left_text">{{ __('global.top_left_text')}}</label>
                                    <input id="top_left_text" value="{{getSetting('top_left_text')}}" name="top_left_text" class="form-control" placeholder="{{ __('global.enter_top_left_text')}}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="top_right_text">{{ __('global.top_right_text')}}</label>
                                    <input id="top_right_text" value="{{getSetting('top_right_text')}}" name="top_right_text" class="form-control" placeholder="{{ __('global.enter_top_right_text')}}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="home_slider">{{ __('global.home_slider')}}</label>
                                    <select id="home_slider"  name="home_slider" class="form-control">
                                        <option value="show" @if(getSetting('home_slider') == 'show') selected @endif>Show</option>
                                        <option value="hide" @if(getSetting('home_slider') == 'hide') selected @endif>Hide</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="home_slider_text">{{ __('global.home_slider_text')}}</label>
                                    <select id="home_slider_text"  name="home_slider_text" class="form-control">
                                        <option value="show" @if(getSetting('home_slider') == 'show') selected @endif>Show</option>
                                        <option value="hide" @if(getSetting('home_slider') == 'hide') selected @endif>Hide</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="top_bar">{{ __('global.top_bar')}}</label>
                                    <select id="top_bar"  name="top_bar" class="form-control">
                                        <option value="show" @if(getSetting('top_bar') == 'show') selected @endif>Show</option>
                                        <option value="hide" @if(getSetting('top_bar') == 'hide') selected @endif>Hide</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="mobile_category_menu">{{ __('global.mobile_category_menu')}}</label>
                                    <select id="mobile_category_menu"  name="mobile_category_menu" class="form-control">
                                        <option value="show" @if(getSetting('mobile_category_menu') == 'show') selected @endif>Show</option>
                                        <option value="hide" @if(getSetting('mobile_category_menu') == 'hide') selected @endif>Hide</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="desktop_category_menu">{{ __('global.desktop_category_menu')}}</label>
                                    <select id="desktop_category_menu"  name="desktop_category_menu" class="form-control">
                                        <option value="show" @if(getSetting('desktop_category_menu') == 'show') selected @endif>Show</option>
                                        <option value="hide" @if(getSetting('desktop_category_menu') == 'hide') selected @endif>Hide</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="home_featured_category">{{ __('global.home_featured_category')}}</label>
                                    <select id="home_featured_category"  name="home_featured_category" class="form-control">
                                        <option value="show" @if(getSetting('home_featured_category') == 'show') selected @endif>Show</option>
                                        <option value="hide" @if(getSetting('home_featured_category') == 'hide') selected @endif>Hide</option>
                                    </select>
                                </div>
                            </div>



                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="support_number">{{ __('global.support_number')}}</label>
                                    <input id="support_number"  value="{{getSetting('support_number')}}" name="support_number" class="form-control" placeholder="{{ __('global.support_number')}}">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="facebook">{{ __('global.facebook')}}</label>
                                    <input id="facebook"  value="{{getSetting('facebook')}}" name="facebook" class="form-control" placeholder="{{ __('global.facebook')}}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="youtube">{{ __('global.youtube')}}</label>
                                    <input id="youtube"  value="{{getSetting('youtube')}}" name="youtube" class="form-control" placeholder="{{ __('global.youtube')}}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="instagram">{{ __('global.instagram')}}</label>
                                    <input id="instagram"  value="{{getSetting('instagram')}}" name="instagram" class="form-control" placeholder="{{ __('global.instagram')}}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="whatsapp">{{ __('global.whatsapp')}}</label>
                                    <input id="whatsapp"  value="{{getSetting('whatsapp')}}" name="whatsapp" class="form-control" placeholder="{{ __('global.whatsapp')}}">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="primary_color">Primary Color</label>
                                    <input id="primary_color"  value="{{getSetting('primary_color')}}" type="color" name="primary_color" class="form-control" placeholder="Select Primary Color">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="hover_color">Hover Color</label>
                                    <input id="hover_color"  value="{{getSetting('hover_color')}}" type="color" name="hover_color" class="form-control" placeholder="Select Hover Color">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="theme_color">Theme</label>
                                    <select id="theme_color"  name="theme_color" class="form-control">
                                        <option value="primary" @if(getSetting('theme_color') == 'primary') selected @endif>Primary</option>
                                        <option value="secondary" @if(getSetting('theme_color') == 'secondary') selected @endif>Secondary</option>
                                        <option value="success" @if(getSetting('theme_color') == 'success') selected @endif>Success</option>
                                        <option value="danger" @if(getSetting('theme_color') == 'danger') selected @endif>Danger</option>
                                        <option value="warning" @if(getSetting('theme_color') == 'warning') selected @endif>Warning</option>
                                        <option value="info" @if(getSetting('theme_color') == 'info') selected @endif>Info</option>
                                        <option value="light" @if(getSetting('theme_color') == 'light') selected @endif>Light</option>
                                        <option value="dark" @if(getSetting('theme_color') == 'dark') selected @endif>Dark</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="search_btn_color">Search Button</label>
                                    <select id="search_btn_color"  name="search_btn_color" class="form-control">
                                        <option value="primary" @if(getSetting('search_btn_color') == 'primary') selected @endif>Primary</option>
                                        <option value="secondary" @if(getSetting('search_btn_color') == 'secondary') selected @endif>Secondary</option>
                                        <option value="success" @if(getSetting('search_btn_color') == 'success') selected @endif>Success</option>
                                        <option value="danger" @if(getSetting('search_btn_color') == 'danger') selected @endif>Danger</option>
                                        <option value="warning" @if(getSetting('search_btn_color') == 'warning') selected @endif>Warning</option>
                                        <option value="info" @if(getSetting('search_btn_color') == 'info') selected @endif>Info</option>
                                        <option value="light" @if(getSetting('search_btn_color') == 'light') selected @endif>Light</option>
                                        <option value="dark" @if(getSetting('search_btn_color') == 'dark') selected @endif>Dark</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="order_btn_color">Order Button</label>
                                    <select id="order_btn_color"  name="order_btn_color" class="form-control">
                                        <option value="primary" @if(getSetting('order_btn_color') == 'primary') selected @endif>Primary</option>
                                        <option value="secondary" @if(getSetting('order_btn_color') == 'secondary') selected @endif>Secondary</option>
                                        <option value="success" @if(getSetting('order_btn_color') == 'success') selected @endif>Success</option>
                                        <option value="danger" @if(getSetting('order_btn_color') == 'danger') selected @endif>Danger</option>
                                        <option value="warning" @if(getSetting('order_btn_color') == 'warning') selected @endif>Warning</option>
                                        <option value="info" @if(getSetting('order_btn_color') == 'info') selected @endif>Info</option>
                                        <option value="light" @if(getSetting('order_btn_color') == 'light') selected @endif>Light</option>
                                        <option value="dark" @if(getSetting('order_btn_color') == 'dark') selected @endif>Dark</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="add_cart_btn_color">Add To Cart Button</label>
                                    <select id="add_cart_btn_color"  name="add_cart_btn_color" class="form-control">
                                        <option value="primary" @if(getSetting('add_cart_btn_color') == 'primary') selected @endif>Primary</option>
                                        <option value="secondary" @if(getSetting('add_cart_btn_color') == 'secondary') selected @endif>Secondary</option>
                                        <option value="success" @if(getSetting('add_cart_btn_color') == 'success') selected @endif>Success</option>
                                        <option value="danger" @if(getSetting('add_cart_btn_color') == 'danger') selected @endif>Danger</option>
                                        <option value="warning" @if(getSetting('add_cart_btn_color') == 'warning') selected @endif>Warning</option>
                                        <option value="info" @if(getSetting('add_cart_btn_color') == 'info') selected @endif>Info</option>
                                        <option value="light" @if(getSetting('add_cart_btn_color') == 'light') selected @endif>Light</option>
                                        <option value="dark" @if(getSetting('add_cart_btn_color') == 'dark') selected @endif>Dark</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="product_badge_color">Product Badge</label>
                                    <select id="product_badge_color"  name="product_badge_color" class="form-control">
                                        <option value="primary" @if(getSetting('product_badge_color') == 'primary') selected @endif>Primary</option>
                                        <option value="secondary" @if(getSetting('product_badge_color') == 'secondary') selected @endif>Secondary</option>
                                        <option value="success" @if(getSetting('product_badge_color') == 'success') selected @endif>Success</option>
                                        <option value="danger" @if(getSetting('product_badge_color') == 'danger') selected @endif>Danger</option>
                                        <option value="warning" @if(getSetting('product_badge_color') == 'warning') selected @endif>Warning</option>
                                        <option value="info" @if(getSetting('product_badge_color') == 'info') selected @endif>Info</option>
                                        <option value="light" @if(getSetting('product_badge_color') == 'light') selected @endif>Light</option>
                                        <option value="dark" @if(getSetting('product_badge_color') == 'dark') selected @endif>Dark</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="product_feature_badge_color">Product Feature Badge</label>
                                    <select id="product_feature_badge_color" name="product_feature_badge_color" class="form-control">
                                        <option value="primary" @if(getSetting('product_feature_badge_color') == 'primary') selected @endif>Primary</option>
                                        <option value="secondary" @if(getSetting('product_feature_badge_color') == 'secondary') selected @endif>Secondary</option>
                                        <option value="success" @if(getSetting('product_feature_badge_color') == 'success') selected @endif>Success</option>
                                        <option value="danger" @if(getSetting('product_feature_badge_color') == 'danger') selected @endif>Danger</option>
                                        <option value="warning" @if(getSetting('product_feature_badge_color') == 'warning') selected @endif>Warning</option>
                                        <option value="info" @if(getSetting('product_feature_badge_color') == 'info') selected @endif>Info</option>
                                        <option value="light" @if(getSetting('product_feature_badge_color') == 'light') selected @endif>Light</option>
                                        <option value="dark" @if(getSetting('product_feature_badge_color') == 'dark') selected @endif>Dark</option>
                                    </select>
                                </div>
                            </div>

                        </div>

                        @can('site_setting_manage')
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
    <script>
        $(document).ready(function() {
            // Handle changes in the primary color input
            $("#primary_color").on("input", function() {
                const selectedColor = $(this).val();
                // You can perform additional actions with the selected color here
                console.log("Selected Primary Color: " + selectedColor);
            });

            // Handle changes in the hover color input
            $("#hover_color").on("input", function() {
                const selectedColor = $(this).val();
                // You can perform additional actions with the selected color here
                console.log("Selected Hover Color: " + selectedColor);
            });
        });
    </script>
@stop
