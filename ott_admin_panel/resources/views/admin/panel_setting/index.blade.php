@extends('admin.layout.page-app')
@section('page_title', __('label.panel_settings'))

@section('content')
    @include('admin.layout.sidebar')

    <div class="right-content">
        @include('admin.layout.header')

        <div class="body-content">

            <!-- mobile title -->
            <h1 class="page-title-sm">{{__('label.panel_settings')}}</h1>

            <div class="border-bottom row mb-3">
                <div class="col-sm-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{__('label.dashboard')}}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{__('label.panel_settings')}}</li>
                    </ol>
                </div>
            </div>

            <form id="pannel_setting" enctype="multipart/form-data">
                <input type="hidden" name="old_login_page_img" value="{{$result['login_page_img']}}">
                <input type="hidden" name="old_profile_no_img" value="{{$result['profile_no_img']}}">
                <input type="hidden" name="old_normal_no_img" value="{{$result['normal_no_img']}}">
                <input type="hidden" name="old_portrait_no_img" value="{{$result['portrait_no_img']}}">
                <input type="hidden" name="old_landscape_no_img" value="{{$result['landscape_no_img']}}">
                <div class="row">
                    <!-- <div class="col-9">
                        <div class="card custom-border-card">
                            <h5 class="card-header">{{__('label.color_settings')}}</h5>
                            <div class="card-body">
                                <div class="form-row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>{{__('label.primary_color')}}<span class="text-danger">*</span></label>
                                            <div class="input-group colorpicker-component">
                                                <input type="text" id="hexcolor-1" value="@if(isset($result['primary_color'])){{$result['primary_color']}}@endif" class="form-control hexcolor" pattern="^#+([a-fA-F0-9]{6}|[a-fA-F0-9]{3})$">
                                                <input type="color" id="colorpicker-1" name="primary_color" value="@if(isset($result['primary_color'])){{$result['primary_color']}}@endif" class="colorpicker" pattern="^#+([a-fA-F0-9]{6}|[a-fA-F0-9]{3})$">
                                            </div>
                                            <label class="mt-1 mb-0">
                                                <a href="javascript:void(0)" onclick="reset_default_color(1)" class="primary-color">{{__('label.reset_default')}}</a>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>{{__('label.asset_color')}}<span class="text-danger">*</span></label>
                                            <div class="input-group colorpicker-component">
                                                <input type="text" id="hexcolor-2" value="@if(isset($result['asset_color'])){{$result['asset_color']}}@endif" class="form-control hexcolor" pattern="^#+([a-fA-F0-9]{6}|[a-fA-F0-9]{3})$">
                                                <input type="color" id="colorpicker-2" name="asset_color" value="@if(isset($result['asset_color'])){{$result['asset_color']}}@endif" class="colorpicker" pattern="^#+([a-fA-F0-9]{6}|[a-fA-F0-9]{3})$">
                                            </div>
                                            <label class="mt-1 mb-0">
                                                <a href="javascript:void(0)" onclick="reset_default_color(2)" class="primary-color">{{__('label.reset_default')}}</a>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>{{__('label.background_color')}}<span class="text-danger">*</span></label>
                                            <div class="input-group colorpicker-component">
                                                <input type="text" id="hexcolor-3" value="@if(isset($result['background_color'])){{$result['background_color']}}@endif" class="form-control hexcolor" pattern="^#+([a-fA-F0-9]{6}|[a-fA-F0-9]{3})$">
                                                <input type="color" id="colorpicker-3" name="background_color" value="@if(isset($result['background_color'])){{$result['background_color']}}@endif" class="colorpicker" pattern="^#+([a-fA-F0-9]{6}|[a-fA-F0-9]{3})$">
                                            </div>
                                            <label class="mt-1 mb-0">
                                                <a href="javascript:void(0)" onclick="reset_default_color(3)" class="primary-color">{{__('label.reset_default')}}</a>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>{{__('label.shadow_color')}}<span class="text-danger">*</span></label>
                                            <div class="input-group colorpicker-component">
                                                <input type="text" id="hexcolor-4" value="@if(isset($result['shadow_color'])){{$result['shadow_color']}}@endif" class="form-control hexcolor" pattern="^#+([a-fA-F0-9]{6}|[a-fA-F0-9]{3})$">
                                                <input type="color" id="colorpicker-4" name="shadow_color" value="@if(isset($result['shadow_color'])){{$result['shadow_color']}}@endif" class="colorpicker" pattern="^#+([a-fA-F0-9]{6}|[a-fA-F0-9]{3})$">
                                            </div>
                                            <label class="mt-1 mb-0">
                                                <a href="javascript:void(0)" onclick="reset_default_color(4)" class="primary-color">{{__('label.reset_default')}}</a>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>{{__('label.breadcrumb_color')}}<span class="text-danger">*</span></label>
                                            <div class="input-group colorpicker-component">
                                                <input type="text" id="hexcolor-5" value="@if(isset($result['breadcrumb_color'])){{$result['breadcrumb_color']}}@endif" class="form-control hexcolor" pattern="^#+([a-fA-F0-9]{6}|[a-fA-F0-9]{3})$">
                                                <input type="color" id="colorpicker-5" name="breadcrumb_color" value="@if(isset($result['breadcrumb_color'])){{$result['breadcrumb_color']}}@endif" class="colorpicker" pattern="^#+([a-fA-F0-9]{6}|[a-fA-F0-9]{3})$">
                                            </div>
                                            <label class="mt-1 mb-0">
                                                <a href="javascript:void(0)" onclick="reset_default_color(5)" class="primary-color">{{__('label.reset_default')}}</a>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>{{__('label.success_status_color')}}<span class="text-danger">*</span></label>
                                            <div class="input-group colorpicker-component">
                                                <input type="text" id="hexcolor-6" value="@if(isset($result['success_status_color'])){{$result['success_status_color']}}@endif" class="form-control hexcolor" pattern="^#+([a-fA-F0-9]{6}|[a-fA-F0-9]{3})$">
                                                <input type="color" id="colorpicker-6" name="success_status_color" value="@if(isset($result['success_status_color'])){{$result['success_status_color']}}@endif" class="colorpicker" pattern="^#+([a-fA-F0-9]{6}|[a-fA-F0-9]{3})$">
                                            </div>
                                            <label class="mt-1 mb-0">
                                                <a href="javascript:void(0)" onclick="reset_default_color(6)" class="primary-color">{{__('label.reset_default')}}</a>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>{{__('label.error_status_color')}}<span class="text-danger">*</span></label>
                                            <div class="input-group colorpicker-component">
                                                <input type="text" id="hexcolor-7" value="@if(isset($result['error_status_color'])){{$result['error_status_color']}}@endif" class="form-control hexcolor" pattern="^#+([a-fA-F0-9]{6}|[a-fA-F0-9]{3})$">
                                                <input type="color" id="colorpicker-7" name="error_status_color" value="@if(isset($result['error_status_color'])){{$result['error_status_color']}}@endif" class="colorpicker" pattern="^#+([a-fA-F0-9]{6}|[a-fA-F0-9]{3})$">
                                            </div>
                                            <label class="mt-1 mb-0">
                                                <a href="javascript:void(0)" onclick="reset_default_color(7)" class="primary-color">{{__('label.reset_default')}}</a>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>{{__('label.dark_text_color')}}<span class="text-danger">*</span></label>
                                            <div class="input-group colorpicker-component">
                                                <input type="text" id="hexcolor-8" value="@if(isset($result['dark_text_color'])){{$result['dark_text_color']}}@endif" class="form-control hexcolor" pattern="^#+([a-fA-F0-9]{6}|[a-fA-F0-9]{3})$">
                                                <input type="color" id="colorpicker-8" name="dark_text_color" value="@if(isset($result['dark_text_color'])){{$result['dark_text_color']}}@endif" class="colorpicker" pattern="^#+([a-fA-F0-9]{6}|[a-fA-F0-9]{3})$">
                                            </div>
                                            <label class="mt-1 mb-0">
                                                <a href="javascript:void(0)" onclick="reset_default_color(8)" class="primary-color">{{__('label.reset_default')}}</a>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>{{__('label.light_text_color')}}<span class="text-danger">*</span></label>
                                            <div class="input-group colorpicker-component">
                                                <input type="text" id="hexcolor-9" value="@if(isset($result['light_text_color'])){{$result['light_text_color']}}@endif" class="form-control hexcolor" pattern="^#+([a-fA-F0-9]{6}|[a-fA-F0-9]{3})$">
                                                <input type="color" id="colorpicker-9" name="light_text_color" value="@if(isset($result['light_text_color'])){{$result['light_text_color']}}@endif" class="colorpicker" pattern="^#+([a-fA-F0-9]{6}|[a-fA-F0-9]{3})$">
                                            </div>
                                            <label class="mt-1 mb-0">
                                                <a href="javascript:void(0)" onclick="reset_default_color(9)" class="primary-color">{{__('label.reset_default')}}</a>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> -->
                    <div class="col-3">
                        <div class="card custom-border-card">
                            <h5 class="card-header">{{__('label.login_page_image')}}</h5>
                            <div class="card-body">
                                <div class="form-row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <div class="avatar-upload">
                                                <div class="avatar-edit">
                                                    <input type='file' name="login_page_img" id="imageUpload" accept=".png, .jpg, .jpeg" />
                                                    <label for="imageUpload" title="{{__('label.select_file')}}"></label>
                                                </div>
                                                <div class="avatar-preview">
                                                    <img src="{{$result['login_page_img']}}" id="imagePreview">
                                                </div>
                                            </div>
                                            <label class="mt-3 text-gray">{{__('label.size_2640_3960_pixels')}}</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="card custom-border-card">
                            <h5 class="card-header">{{__('label.by_default_image')}}</h5>
                            <div class="card-body">
                                <div class="form-row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>{{__('label.profile_image')}}<span class="text-danger">*</span></label>
                                            <div class="avatar-upload ">
                                                <div class="avatar-edit">
                                                    <input type='file' name="profile_no_img" id="imageUploadModel" accept=".png, .jpg, .jpeg" />
                                                    <label for="imageUploadModel" title="{{__('label.select_file')}}"></label>
                                                </div>
                                                <div class="avatar-preview">
                                                    <img src="{{$result['profile_no_img']}}" id="imagePreviewModel">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>{{__('label.normal_image')}}<span class="text-danger">*</span></label>
                                            <div class="avatar-upload ">
                                                <div class="avatar-edit">
                                                    <input type='file' name="normal_no_img" id="imageUploadLandscape" accept=".png, .jpg, .jpeg" />
                                                    <label for="imageUploadLandscape" title="{{__('label.select_file')}}"></label>
                                                </div>
                                                <div class="avatar-preview">
                                                    <img src="{{$result['normal_no_img']}}" id="imagePreviewLandscape">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>{{__('label.portrait_image')}}<span class="text-danger">*</span></label>
                                            <div class="avatar-upload ">
                                                <div class="avatar-edit">
                                                    <input type='file' name="portrait_no_img" id="imageUploadLandscapeModel" accept=".png, .jpg, .jpeg" />
                                                    <label for="imageUploadLandscapeModel" title="{{__('label.select_file')}}"></label>
                                                </div>
                                                <div class="avatar-preview">
                                                    <img src="{{$result['portrait_no_img']}}" id="imagePreviewLandscapeModel">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>{{__('label.landscape_image')}}<span class="text-danger">*</span></label>
                                            <div class="avatar-upload-landscape">
                                                <div class="avatar-edit-landscape">
                                                    <input type='file' name="landscape_no_img" id="imageUpload1" accept=".png, .jpg, .jpeg" />
                                                    <label for="imageUpload1" title="{{__('label.select_file')}}"></label>
                                                </div>
                                                <div class="avatar-preview-landscape">
                                                    <img src="{{$result['landscape_no_img']}}" id="imagePreview1">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- <div class="row">
                    <div class="col-12">
                        <div class="card custom-border-card">
                            <h5 class="card-header">{{__('label.counter_card_settings')}}</h5>
                            <div class="card-body">
                                <div class="form-row">
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label>{{__('label.background_color_card_1')}}<span class="text-danger">*</span></label>
                                            <div class="input-group colorpicker-component">
                                                <input type="text" id="hexcolor-10" value="@if(isset($result['counter_card_1_bg'])){{$result['counter_card_1_bg']}}@endif" class="form-control hexcolor" pattern="^#+([a-fA-F0-9]{6}|[a-fA-F0-9]{3})$">
                                                <input type="color" id="colorpicker-10" name="counter_card_1_bg" value="@if(isset($result['counter_card_1_bg'])){{$result['counter_card_1_bg']}}@endif" class="colorpicker" pattern="^#+([a-fA-F0-9]{6}|[a-fA-F0-9]{3})$">
                                            </div>
                                            <label class="mt-1 mb-0">
                                                <a href="javascript:void(0)" onclick="reset_default_color(10)" class="primary-color">{{__('label.reset_default')}}</a>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label>{{__('label.background_color_card_2')}}<span class="text-danger">*</span></label>
                                            <div class="input-group colorpicker-component">
                                                <input type="text" id="hexcolor-11" value="@if(isset($result['counter_card_2_bg'])){{$result['counter_card_2_bg']}}@endif" class="form-control hexcolor" pattern="^#+([a-fA-F0-9]{6}|[a-fA-F0-9]{3})$">
                                                <input type="color" id="colorpicker-11" name="counter_card_2_bg" value="@if(isset($result['counter_card_2_bg'])){{$result['counter_card_2_bg']}}@endif" class="colorpicker" pattern="^#+([a-fA-F0-9]{6}|[a-fA-F0-9]{3})$">
                                            </div>
                                            <label class="mt-1 mb-0">
                                                <a href="javascript:void(0)" onclick="reset_default_color(11)" class="primary-color">{{__('label.reset_default')}}</a>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label>{{__('label.background_color_card_3')}}<span class="text-danger">*</span></label>
                                            <div class="input-group colorpicker-component">
                                                <input type="text" id="hexcolor-12" value="@if(isset($result['counter_card_3_bg'])){{$result['counter_card_3_bg']}}@endif" class="form-control hexcolor" pattern="^#+([a-fA-F0-9]{6}|[a-fA-F0-9]{3})$">
                                                <input type="color" id="colorpicker-12" name="counter_card_3_bg" value="@if(isset($result['counter_card_3_bg'])){{$result['counter_card_3_bg']}}@endif" class="colorpicker" pattern="^#+([a-fA-F0-9]{6}|[a-fA-F0-9]{3})$">
                                            </div>
                                            <label class="mt-1 mb-0">
                                                <a href="javascript:void(0)" onclick="reset_default_color(12)" class="primary-color">{{__('label.reset_default')}}</a>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label>{{__('label.background_color_card_4')}}<span class="text-danger">*</span></label>
                                            <div class="input-group colorpicker-component">
                                                <input type="text" id="hexcolor-13" value="@if(isset($result['counter_card_4_bg'])){{$result['counter_card_4_bg']}}@endif" class="form-control hexcolor" pattern="^#+([a-fA-F0-9]{6}|[a-fA-F0-9]{3})$">
                                                <input type="color" id="colorpicker-13" name="counter_card_4_bg" value="@if(isset($result['counter_card_4_bg'])){{$result['counter_card_4_bg']}}@endif" class="colorpicker" pattern="^#+([a-fA-F0-9]{6}|[a-fA-F0-9]{3})$">
                                            </div>
                                            <label class="mt-1 mb-0">
                                                <a href="javascript:void(0)" onclick="reset_default_color(13)" class="primary-color">{{__('label.reset_default')}}</a>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label>{{__('label.background_color_card_5')}}<span class="text-danger">*</span></label>
                                            <div class="input-group colorpicker-component">
                                                <input type="text" id="hexcolor-14" value="@if(isset($result['counter_card_5_bg'])){{$result['counter_card_5_bg']}}@endif" class="form-control hexcolor" pattern="^#+([a-fA-F0-9]{6}|[a-fA-F0-9]{3})$">
                                                <input type="color" id="colorpicker-14" name="counter_card_5_bg" value="@if(isset($result['counter_card_5_bg'])){{$result['counter_card_5_bg']}}@endif" class="colorpicker" pattern="^#+([a-fA-F0-9]{6}|[a-fA-F0-9]{3})$">
                                            </div>
                                            <label class="mt-1 mb-0">
                                                <a href="javascript:void(0)" onclick="reset_default_color(14)" class="primary-color">{{__('label.reset_default')}}</a>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label>{{__('label.text_color_card_1')}}<span class="text-danger">*</span></label>
                                            <div class="input-group colorpicker-component">
                                                <input type="text" id="hexcolor-15" value="@if(isset($result['counter_card_1_text'])){{$result['counter_card_1_text']}}@endif" class="form-control hexcolor" pattern="^#+([a-fA-F0-9]{6}|[a-fA-F0-9]{3})$">
                                                <input type="color" id="colorpicker-15" name="counter_card_1_text" value="@if(isset($result['counter_card_1_text'])){{$result['counter_card_1_text']}}@endif" class="colorpicker" pattern="^#+([a-fA-F0-9]{6}|[a-fA-F0-9]{3})$">
                                            </div>
                                            <label class="mt-1 mb-0">
                                                <a href="javascript:void(0)" onclick="reset_default_color(15)" class="primary-color">{{__('label.reset_default')}}</a>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label>{{__('label.text_color_card_2')}}<span class="text-danger">*</span></label>
                                            <div class="input-group colorpicker-component">
                                                <input type="text" id="hexcolor-16" value="@if(isset($result['counter_card_2_text'])){{$result['counter_card_2_text']}}@endif" class="form-control hexcolor" pattern="^#+([a-fA-F0-9]{6}|[a-fA-F0-9]{3})$">
                                                <input type="color" id="colorpicker-16" name="counter_card_2_text" value="@if(isset($result['counter_card_2_text'])){{$result['counter_card_2_text']}}@endif" class="colorpicker" pattern="^#+([a-fA-F0-9]{6}|[a-fA-F0-9]{3})$">
                                            </div>
                                            <label class="mt-1 mb-0">
                                                <a href="javascript:void(0)" onclick="reset_default_color(16)" class="primary-color">{{__('label.reset_default')}}</a>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label>{{__('label.text_color_card_3')}}<span class="text-danger">*</span></label>
                                            <div class="input-group colorpicker-component">
                                                <input type="text" id="hexcolor-17" value="@if(isset($result['counter_card_3_text'])){{$result['counter_card_3_text']}}@endif" class="form-control hexcolor" pattern="^#+([a-fA-F0-9]{6}|[a-fA-F0-9]{3})$">
                                                <input type="color" id="colorpicker-17" name="counter_card_3_text" value="@if(isset($result['counter_card_3_text'])){{$result['counter_card_3_text']}}@endif" class="colorpicker" pattern="^#+([a-fA-F0-9]{6}|[a-fA-F0-9]{3})$">
                                            </div>
                                            <label class="mt-1 mb-0">
                                                <a href="javascript:void(0)" onclick="reset_default_color(17)" class="primary-color">{{__('label.reset_default')}}</a>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label>{{__('label.text_color_card_4')}}<span class="text-danger">*</span></label>
                                            <div class="input-group colorpicker-component">
                                                <input type="text" id="hexcolor-18" value="@if(isset($result['counter_card_4_text'])){{$result['counter_card_4_text']}}@endif" class="form-control hexcolor" pattern="^#+([a-fA-F0-9]{6}|[a-fA-F0-9]{3})$">
                                                <input type="color" id="colorpicker-18" name="counter_card_4_text" value="@if(isset($result['counter_card_4_text'])){{$result['counter_card_4_text']}}@endif" class="colorpicker" pattern="^#+([a-fA-F0-9]{6}|[a-fA-F0-9]{3})$">
                                            </div>
                                            <label class="mt-1 mb-0">
                                                <a href="javascript:void(0)" onclick="reset_default_color(18)" class="primary-color">{{__('label.reset_default')}}</a>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label>{{__('label.text_color_card_5')}}<span class="text-danger">*</span></label>
                                            <div class="input-group colorpicker-component">
                                                <input type="text" id="hexcolor-19" value="@if(isset($result['counter_card_5_text'])){{$result['counter_card_5_text']}}@endif" class="form-control hexcolor" pattern="^#+([a-fA-F0-9]{6}|[a-fA-F0-9]{3})$">
                                                <input type="color" id="colorpicker-19" name="counter_card_5_text" value="@if(isset($result['counter_card_5_text'])){{$result['counter_card_5_text']}}@endif" class="colorpicker" pattern="^#+([a-fA-F0-9]{6}|[a-fA-F0-9]{3})$">
                                            </div>
                                            <label class="mt-1 mb-0">
                                                <a href="javascript:void(0)" onclick="reset_default_color(19)" class="primary-color">{{__('label.reset_default')}}</a>
                                            </label>
                                        </div>
                                    </div>
                                </div><hr>
                                <div class="form-row">
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label>{{__('label.background_color_card_6')}}<span class="text-danger">*</span></label>
                                            <div class="input-group colorpicker-component">
                                                <input type="text" id="hexcolor-20" value="@if(isset($result['counter_card_6_bg'])){{$result['counter_card_6_bg']}}@endif" class="form-control hexcolor" pattern="^#+([a-fA-F0-9]{6}|[a-fA-F0-9]{3})$">
                                                <input type="color" id="colorpicker-20" name="counter_card_6_bg" value="@if(isset($result['counter_card_6_bg'])){{$result['counter_card_6_bg']}}@endif" class="colorpicker" pattern="^#+([a-fA-F0-9]{6}|[a-fA-F0-9]{3})$">
                                            </div>
                                            <label class="mt-1 mb-0">
                                                <a href="javascript:void(0)" onclick="reset_default_color(20)" class="primary-color">{{__('label.reset_default')}}</a>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label>{{__('label.background_color_card_7')}}<span class="text-danger">*</span></label>
                                            <div class="input-group colorpicker-component">
                                                <input type="text" id="hexcolor-21" value="@if(isset($result['counter_card_7_bg'])){{$result['counter_card_7_bg']}}@endif" class="form-control hexcolor" pattern="^#+([a-fA-F0-9]{6}|[a-fA-F0-9]{3})$">
                                                <input type="color" id="colorpicker-21" name="counter_card_7_bg" value="@if(isset($result['counter_card_7_bg'])){{$result['counter_card_7_bg']}}@endif" class="colorpicker" pattern="^#+([a-fA-F0-9]{6}|[a-fA-F0-9]{3})$">
                                            </div>
                                            <label class="mt-1 mb-0">
                                                <a href="javascript:void(0)" onclick="reset_default_color(21)" class="primary-color">{{__('label.reset_default')}}</a>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label>{{__('label.background_color_card_8')}}<span class="text-danger">*</span></label>
                                            <div class="input-group colorpicker-component">
                                                <input type="text" id="hexcolor-22" value="@if(isset($result['counter_card_8_bg'])){{$result['counter_card_8_bg']}}@endif" class="form-control hexcolor" pattern="^#+([a-fA-F0-9]{6}|[a-fA-F0-9]{3})$">
                                                <input type="color" id="colorpicker-22" name="counter_card_8_bg" value="@if(isset($result['counter_card_8_bg'])){{$result['counter_card_8_bg']}}@endif" class="colorpicker" pattern="^#+([a-fA-F0-9]{6}|[a-fA-F0-9]{3})$">
                                            </div>
                                            <label class="mt-1 mb-0">
                                                <a href="javascript:void(0)" onclick="reset_default_color(22)" class="primary-color">{{__('label.reset_default')}}</a>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label>{{__('label.background_color_card_9')}}<span class="text-danger">*</span></label>
                                            <div class="input-group colorpicker-component">
                                                <input type="text" id="hexcolor-23" value="@if(isset($result['counter_card_9_bg'])){{$result['counter_card_9_bg']}}@endif" class="form-control hexcolor" pattern="^#+([a-fA-F0-9]{6}|[a-fA-F0-9]{3})$">
                                                <input type="color" id="colorpicker-23" name="counter_card_9_bg" value="@if(isset($result['counter_card_9_bg'])){{$result['counter_card_9_bg']}}@endif" class="colorpicker" pattern="^#+([a-fA-F0-9]{6}|[a-fA-F0-9]{3})$">
                                            </div>
                                            <label class="mt-1 mb-0">
                                                <a href="javascript:void(0)" onclick="reset_default_color(23)" class="primary-color">{{__('label.reset_default')}}</a>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label>{{__('label.background_color_card_10')}}<span class="text-danger">*</span></label>
                                            <div class="input-group colorpicker-component">
                                                <input type="text" id="hexcolor-24" value="@if(isset($result['counter_card_10_bg'])){{$result['counter_card_10_bg']}}@endif" class="form-control hexcolor" pattern="^#+([a-fA-F0-9]{6}|[a-fA-F0-9]{3})$">
                                                <input type="color" id="colorpicker-24" name="counter_card_10_bg" value="@if(isset($result['counter_card_10_bg'])){{$result['counter_card_10_bg']}}@endif" class="colorpicker" pattern="^#+([a-fA-F0-9]{6}|[a-fA-F0-9]{3})$">
                                            </div>
                                            <label class="mt-1 mb-0">
                                                <a href="javascript:void(0)" onclick="reset_default_color(24)" class="primary-color">{{__('label.reset_default')}}</a>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label>{{__('label.text_color_card_6')}}<span class="text-danger">*</span></label>
                                            <div class="input-group colorpicker-component">
                                                <input type="text" id="hexcolor-25" value="@if(isset($result['counter_card_6_text'])){{$result['counter_card_6_text']}}@endif" class="form-control hexcolor" pattern="^#+([a-fA-F0-9]{6}|[a-fA-F0-9]{3})$">
                                                <input type="color" id="colorpicker-25" name="counter_card_6_text" value="@if(isset($result['counter_card_6_text'])){{$result['counter_card_6_text']}}@endif" class="colorpicker" pattern="^#+([a-fA-F0-9]{6}|[a-fA-F0-9]{3})$">
                                            </div>
                                            <label class="mt-1 mb-0">
                                                <a href="javascript:void(0)" onclick="reset_default_color(25)" class="primary-color">{{__('label.reset_default')}}</a>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label>{{__('label.text_color_card_7')}}<span class="text-danger">*</span></label>
                                            <div class="input-group colorpicker-component">
                                                <input type="text" id="hexcolor-26" value="@if(isset($result['counter_card_7_text'])){{$result['counter_card_7_text']}}@endif" class="form-control hexcolor" pattern="^#+([a-fA-F0-9]{6}|[a-fA-F0-9]{3})$">
                                                <input type="color" id="colorpicker-26" name="counter_card_7_text" value="@if(isset($result['counter_card_7_text'])){{$result['counter_card_7_text']}}@endif" class="colorpicker" pattern="^#+([a-fA-F0-9]{6}|[a-fA-F0-9]{3})$">
                                            </div>
                                            <label class="mt-1 mb-0">
                                                <a href="javascript:void(0)" onclick="reset_default_color(26)" class="primary-color">{{__('label.reset_default')}}</a>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label>{{__('label.text_color_card_8')}}<span class="text-danger">*</span></label>
                                            <div class="input-group colorpicker-component">
                                                <input type="text" id="hexcolor-27" value="@if(isset($result['counter_card_8_text'])){{$result['counter_card_8_text']}}@endif" class="form-control hexcolor" pattern="^#+([a-fA-F0-9]{6}|[a-fA-F0-9]{3})$">
                                                <input type="color" id="colorpicker-27" name="counter_card_8_text" value="@if(isset($result['counter_card_8_text'])){{$result['counter_card_8_text']}}@endif" class="colorpicker" pattern="^#+([a-fA-F0-9]{6}|[a-fA-F0-9]{3})$">
                                            </div>
                                            <label class="mt-1 mb-0">
                                                <a href="javascript:void(0)" onclick="reset_default_color(27)" class="primary-color">{{__('label.reset_default')}}</a>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label>{{__('label.text_color_card_9')}}<span class="text-danger">*</span></label>
                                            <div class="input-group colorpicker-component">
                                                <input type="text" id="hexcolor-28" value="@if(isset($result['counter_card_9_text'])){{$result['counter_card_9_text']}}@endif" class="form-control hexcolor" pattern="^#+([a-fA-F0-9]{6}|[a-fA-F0-9]{3})$">
                                                <input type="color" id="colorpicker-28" name="counter_card_9_text" value="@if(isset($result['counter_card_9_text'])){{$result['counter_card_9_text']}}@endif" class="colorpicker" pattern="^#+([a-fA-F0-9]{6}|[a-fA-F0-9]{3})$">
                                            </div>
                                            <label class="mt-1 mb-0">
                                                <a href="javascript:void(0)" onclick="reset_default_color(28)" class="primary-color">{{__('label.reset_default')}}</a>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label>{{__('label.text_color_card_10')}}<span class="text-danger">*</span></label>
                                            <div class="input-group colorpicker-component">
                                                <input type="text" id="hexcolor-29" value="@if(isset($result['counter_card_10_text'])){{$result['counter_card_10_text']}}@endif" class="form-control hexcolor" pattern="^#+([a-fA-F0-9]{6}|[a-fA-F0-9]{3})$">
                                                <input type="color" id="colorpicker-29" name="counter_card_10_text" value="@if(isset($result['counter_card_10_text'])){{$result['counter_card_10_text']}}@endif" class="colorpicker" pattern="^#+([a-fA-F0-9]{6}|[a-fA-F0-9]{3})$">
                                            </div>
                                            <label class="mt-1 mb-0">
                                                <a href="javascript:void(0)" onclick="reset_default_color(29)" class="primary-color">{{__('label.reset_default')}}</a>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="card custom-border-card">
                            <h5 class="card-header">{{__('label.chart_settings')}}</h5>
                            <div class="card-body">
                                <div class="form-row">
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label>{{__('label.color_1')}}<span class="text-danger">*</span></label>
                                            <div class="input-group colorpicker-component">
                                                <input type="text" id="hexcolor-30" value="@if(isset($result['chart_color_1'])){{$result['chart_color_1']}}@endif" class="form-control hexcolor" pattern="^#+([a-fA-F0-9]{6}|[a-fA-F0-9]{3})$">
                                                <input type="color" id="colorpicker-30" name="chart_color_1" value="@if(isset($result['chart_color_1'])){{$result['chart_color_1']}}@endif" class="colorpicker" pattern="^#+([a-fA-F0-9]{6}|[a-fA-F0-9]{3})$">
                                            </div>
                                            <label class="mt-1 mb-0">
                                                <a href="javascript:void(0)" onclick="reset_default_color(30)" class="primary-color">{{__('label.reset_default')}}</a>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label>{{__('label.color_2')}}<span class="text-danger">*</span></label>
                                            <div class="input-group colorpicker-component">
                                                <input type="text" id="hexcolor-31" value="@if(isset($result['chart_color_2'])){{$result['chart_color_2']}}@endif" class="form-control hexcolor" pattern="^#+([a-fA-F0-9]{6}|[a-fA-F0-9]{3})$">
                                                <input type="color" id="colorpicker-31" name="chart_color_2" value="@if(isset($result['chart_color_2'])){{$result['chart_color_2']}}@endif" class="colorpicker" pattern="^#+([a-fA-F0-9]{6}|[a-fA-F0-9]{3})$">
                                            </div>
                                            <label class="mt-1 mb-0">
                                                <a href="javascript:void(0)" onclick="reset_default_color(31)" class="primary-color">{{__('label.reset_default')}}</a>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label>{{__('label.color_3')}}<span class="text-danger">*</span></label>
                                            <div class="input-group colorpicker-component">
                                                <input type="text" id="hexcolor-32" value="@if(isset($result['chart_color_3'])){{$result['chart_color_3']}}@endif" class="form-control hexcolor" pattern="^#+([a-fA-F0-9]{6}|[a-fA-F0-9]{3})$">
                                                <input type="color" id="colorpicker-32" name="chart_color_3" value="@if(isset($result['chart_color_3'])){{$result['chart_color_3']}}@endif" class="colorpicker" pattern="^#+([a-fA-F0-9]{6}|[a-fA-F0-9]{3})$">
                                            </div>
                                            <label class="mt-1 mb-0">
                                                <a href="javascript:void(0)" onclick="reset_default_color(32)" class="primary-color">{{__('label.reset_default')}}</a>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label>{{__('label.color_4')}}<span class="text-danger">*</span></label>
                                            <div class="input-group colorpicker-component">
                                                <input type="text" id="hexcolor-33" value="@if(isset($result['chart_color_4'])){{$result['chart_color_4']}}@endif" class="form-control hexcolor" pattern="^#+([a-fA-F0-9]{6}|[a-fA-F0-9]{3})$">
                                                <input type="color" id="colorpicker-33" name="chart_color_4" value="@if(isset($result['chart_color_4'])){{$result['chart_color_4']}}@endif" class="colorpicker" pattern="^#+([a-fA-F0-9]{6}|[a-fA-F0-9]{3})$">
                                            </div>
                                            <label class="mt-1 mb-0">
                                                <a href="javascript:void(0)" onclick="reset_default_color(33)" class="primary-color">{{__('label.reset_default')}}</a>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label>{{__('label.color_5')}}<span class="text-danger">*</span></label>
                                            <div class="input-group colorpicker-component">
                                                <input type="text" id="hexcolor-34" value="@if(isset($result['chart_color_5'])){{$result['chart_color_5']}}@endif" class="form-control hexcolor" pattern="^#+([a-fA-F0-9]{6}|[a-fA-F0-9]{3})$">
                                                <input type="color" id="colorpicker-34" name="chart_color_5" value="@if(isset($result['chart_color_5'])){{$result['chart_color_5']}}@endif" class="colorpicker" pattern="^#+([a-fA-F0-9]{6}|[a-fA-F0-9]{3})$">
                                            </div>
                                            <label class="mt-1 mb-0">
                                                <a href="javascript:void(0)" onclick="reset_default_color(34)" class="primary-color">{{__('label.reset_default')}}</a>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label>{{__('label.color_6')}}<span class="text-danger">*</span></label>
                                            <div class="input-group colorpicker-component">
                                                <input type="text" id="hexcolor-35" value="@if(isset($result['chart_color_6'])){{$result['chart_color_6']}}@endif" class="form-control hexcolor" pattern="^#+([a-fA-F0-9]{6}|[a-fA-F0-9]{3})$">
                                                <input type="color" id="colorpicker-35" name="chart_color_6" value="@if(isset($result['chart_color_6'])){{$result['chart_color_6']}}@endif" class="colorpicker" pattern="^#+([a-fA-F0-9]{6}|[a-fA-F0-9]{3})$">
                                            </div>
                                            <label class="mt-1 mb-0">
                                                <a href="javascript:void(0)" onclick="reset_default_color(35)" class="primary-color">{{__('label.reset_default')}}</a>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label>{{__('label.color_7')}}<span class="text-danger">*</span></label>
                                            <div class="input-group colorpicker-component">
                                                <input type="text" id="hexcolor-36" value="@if(isset($result['chart_color_7'])){{$result['chart_color_7']}}@endif" class="form-control hexcolor" pattern="^#+([a-fA-F0-9]{6}|[a-fA-F0-9]{3})$">
                                                <input type="color" id="colorpicker-36" name="chart_color_7" value="@if(isset($result['chart_color_7'])){{$result['chart_color_7']}}@endif" class="colorpicker" pattern="^#+([a-fA-F0-9]{6}|[a-fA-F0-9]{3})$">
                                            </div>
                                            <label class="mt-1 mb-0">
                                                <a href="javascript:void(0)" onclick="reset_default_color(36)" class="primary-color">{{__('label.reset_default')}}</a>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label>{{__('label.color_8')}}<span class="text-danger">*</span></label>
                                            <div class="input-group colorpicker-component">
                                                <input type="text" id="hexcolor-37" value="@if(isset($result['chart_color_8'])){{$result['chart_color_8']}}@endif" class="form-control hexcolor" pattern="^#+([a-fA-F0-9]{6}|[a-fA-F0-9]{3})$">
                                                <input type="color" id="colorpicker-37" name="chart_color_8" value="@if(isset($result['chart_color_8'])){{$result['chart_color_8']}}@endif" class="colorpicker" pattern="^#+([a-fA-F0-9]{6}|[a-fA-F0-9]{3})$">
                                            </div>
                                            <label class="mt-1 mb-0">
                                                <a href="javascript:void(0)" onclick="reset_default_color(37)" class="primary-color">{{__('label.reset_default')}}</a>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label>{{__('label.color_9')}}<span class="text-danger">*</span></label>
                                            <div class="input-group colorpicker-component">
                                                <input type="text" id="hexcolor-38" value="@if(isset($result['chart_color_9'])){{$result['chart_color_9']}}@endif" class="form-control hexcolor" pattern="^#+([a-fA-F0-9]{6}|[a-fA-F0-9]{3})$">
                                                <input type="color" id="colorpicker-38" name="chart_color_9" value="@if(isset($result['chart_color_9'])){{$result['chart_color_9']}}@endif" class="colorpicker" pattern="^#+([a-fA-F0-9]{6}|[a-fA-F0-9]{3})$">
                                            </div>
                                            <label class="mt-1 mb-0">
                                                <a href="javascript:void(0)" onclick="reset_default_color(38)" class="primary-color">{{__('label.reset_default')}}</a>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label>{{__('label.color_10')}}<span class="text-danger">*</span></label>
                                            <div class="input-group colorpicker-component">
                                                <input type="text" id="hexcolor-39" value="@if(isset($result['chart_color_10'])){{$result['chart_color_10']}}@endif" class="form-control hexcolor" pattern="^#+([a-fA-F0-9]{6}|[a-fA-F0-9]{3})$">
                                                <input type="color" id="colorpicker-39" name="chart_color_10" value="@if(isset($result['chart_color_10'])){{$result['chart_color_10']}}@endif" class="colorpicker" pattern="^#+([a-fA-F0-9]{6}|[a-fA-F0-9]{3})$">
                                            </div>
                                            <label class="mt-1 mb-0">
                                                <a href="javascript:void(0)" onclick="reset_default_color(39)" class="primary-color">{{__('label.reset_default')}}</a>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label>{{__('label.color_11')}}<span class="text-danger">*</span></label>
                                            <div class="input-group colorpicker-component">
                                                <input type="text" id="hexcolor-40" value="@if(isset($result['chart_color_11'])){{$result['chart_color_11']}}@endif" class="form-control hexcolor" pattern="^#+([a-fA-F0-9]{6}|[a-fA-F0-9]{3})$">
                                                <input type="color" id="colorpicker-40" name="chart_color_11" value="@if(isset($result['chart_color_11'])){{$result['chart_color_11']}}@endif" class="colorpicker" pattern="^#+([a-fA-F0-9]{6}|[a-fA-F0-9]{3})$">
                                            </div>
                                            <label class="mt-1 mb-0">
                                                <a href="javascript:void(0)" onclick="reset_default_color(40)" class="primary-color">{{__('label.reset_default')}}</a>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label>{{__('label.color_12')}}<span class="text-danger">*</span></label>
                                            <div class="input-group colorpicker-component">
                                                <input type="text" id="hexcolor-41" value="@if(isset($result['chart_color_12'])){{$result['chart_color_12']}}@endif" class="form-control hexcolor" pattern="^#+([a-fA-F0-9]{6}|[a-fA-F0-9]{3})$">
                                                <input type="color" id="colorpicker-41" name="chart_color_12" value="@if(isset($result['chart_color_12'])){{$result['chart_color_12']}}@endif" class="colorpicker" pattern="^#+([a-fA-F0-9]{6}|[a-fA-F0-9]{3})$">
                                            </div>
                                            <label class="mt-1 mb-0">
                                                <a href="javascript:void(0)" onclick="reset_default_color(41)" class="primary-color">{{__('label.reset_default')}}</a>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> -->
                <div class="text-right">
                    <button type="button" class="btn btn-default mw-120" onclick="save_panel_setting()">{{__('label.save')}}</button>
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                </div>
            </form>
        </div>
    </div>
@endsection

@section('pagescript')
    <script>

        // Sidebar Scroll Down
        sidebar_down($(document).height());

        // Color Picker
        $(document).ready(function() {

            // Event handler for color picker input change
            $('.colorpicker').on('input', function() {
                var target = $(this).attr('id').split('-')[1];
                $('#hexcolor-' + target).val(this.value.toUpperCase());
            });

            // Event handler for hex color input change
            $('.hexcolor').on('input', function() {
                var target = $(this).attr('id').split('-')[1];
                const hexPattern = /^#([a-fA-F0-9]{6}|[a-fA-F0-9]{3})$/;
                if (hexPattern.test(this.value)) {
                    $('#colorpicker-' + target).val(this.value);
                }
            });
        });
        function reset_default_color(value)
        {

            if(value == 1){
                var defaultColor = '#4E45B8';
            } else if(value == 2){
                var defaultColor = '#F9FAFF';
            } else if(value == 3){
                var defaultColor = '#FFFFFF';
            } else if(value == 4){
                var defaultColor = '#000000';
            } else if(value == 5){
                var defaultColor = '#E9ECEF';
            } else if(value == 6){
                var defaultColor = '#E3000B';
            } else if(value == 7){
                var defaultColor = '#058F00';
            } else if(value == 8){
                var defaultColor = '#000000';
            } else if(value == 9){
                var defaultColor = '#FFFFFF';
            } else if(value == 10){
                var defaultColor = '#FEF3F1';
            } else if(value == 11){
                var defaultColor = '#FFE5EF';
            } else if(value == 12){
                var defaultColor = '#EDFFEF';
            } else if(value == 13){
                var defaultColor = '#F4F2FF';
            } else if(value == 14){
                var defaultColor = '#ECFBFF';
            } else if(value == 15){
                var defaultColor = '#A98471';
            } else if(value == 16){
                var defaultColor = '#C0698B';
            } else if(value == 17){
                var defaultColor = '#6CB373';
            } else if(value == 18){
                var defaultColor = '#736AA6';
            } else if(value == 19){
                var defaultColor = '#6DB3C6';
            } else if(value == 20){
                var defaultColor = '#DFAB91';
            } else if(value == 21){
                var defaultColor = '#F068A7';
            } else if(value == 22){
                var defaultColor = '#83CF78';
            } else if(value == 23){
                var defaultColor = '#C9B7F1';
            } else if(value == 24){
                var defaultColor = '#3ACEF3';
            } else if(value == 25){
                var defaultColor = '#692705';
            } else if(value == 26){
                var defaultColor = '#B41D64';
            } else if(value == 27){
                var defaultColor = '#245C1C';
            } else if(value == 28){
                var defaultColor = '#530899';
            } else if(value == 29){
                var defaultColor = '#18677A';
            } else if(value == 30){
                var defaultColor = '#FF6384';
            } else if(value == 31){
                var defaultColor = '#4BC0C0';
            } else if(value == 32){
                var defaultColor = '#FFCD56';
            } else if(value == 33){
                var defaultColor = '#B04645';
            } else if(value == 34){
                var defaultColor = '#35B03B';
            } else if(value == 35){
                var defaultColor = '#36A2EB';
            } else if(value == 36){
                var defaultColor = '#E007F0';
            } else if(value == 37){
                var defaultColor = '#9966FF';
            } else if(value == 38){
                var defaultColor = '#FF9F40';
            } else if(value == 39){
                var defaultColor = '#E04714';
            } else if(value == 40){
                var defaultColor = '#A19135';
            } else if(value == 41){
                var defaultColor = '#E876D3';
            } else {
                var defaultColor = '#000000';
            }

            $('#colorpicker-' + value).val(defaultColor);
            $('#hexcolor-' + value).val(defaultColor);
        }

        function save_panel_setting(){

            var Check_Admin = '<?php echo Check_Admin_Access(); ?>';
            if(Check_Admin == 1){

                $("#dvloader").show();
                var formData = new FormData($("#pannel_setting")[0]);
                $.ajax({
                    type:'POST',
                    url:'{{ route("panel.setting.save") }}',
                    data:formData,
                    cache:false,
                    contentType: false,
                    processData: false,
                    success:function(resp){
                        $("#dvloader").hide();
                        get_responce_message(resp, 'pannel_setting', '{{ route("panel.setting.index") }}');
                    },
                    error: function(XMLHttpRequest, textStatus, errorThrown) {
                        $("#dvloader").hide();
                        toastr.error(errorThrown, textStatus);
                    }
                });
            } else {
                toastr.error('{{__("label.you_have_no_right_to_add_edit_and_delete")}}');
            }
		}
    </script>
@endsection