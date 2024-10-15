@extends('admin.layout.page-app')
@section('page_title', __('label.app_settings'))

@section('content')
    @include('admin.layout.sidebar')

    <div class="right-content">
        @include('admin.layout.header')

        <div class="body-content">
            <!-- mobile title -->
            <h1 class="page-title-sm">{{__('label.app_settings')}}</h1>

            <div class="border-bottom row mb-3">
                <div class="col-sm-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{__('label.dashboard')}}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{__('label.app_settings')}}</li>
                    </ol>
                </div>
            </div>

            <ul class="nav nav-pills custom-tabs inline-tabs" id="pills-tab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="app-tab" data-toggle="tab" href="#app" role="tab" aria-controls="app" aria-selected="true">{{__('label.app_settings')}}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="configrations-tab" data-toggle="tab" href="#configrations" role="tab" aria-controls="configrations" aria-selected="false">{{__('label.configrations')}}</a>
                </li>
                @if( env('DEMO_MODE') == 'OFF')
                    <li class="nav-item">
                        <a class="nav-link" id="smtp-tab" data-toggle="tab" href="#smtp" role="tab" aria-controls="smtp" aria-selected="false">{{__('label.smtp')}}</a>
                    </li>
                @endif
                <li class="nav-item">
                    <a class="nav-link" id="social-tab" data-toggle="tab" href="#social" role="tab" aria-controls="social" aria-selected="false">{{__('label.social_setting')}}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="onboarding-tab" data-toggle="tab" href="#onboarding" role="tab" aria-controls="onboarding" aria-selected="false">{{__('label.onboarding_screen')}}</a>
                </li>
            </ul>

            <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade show active" id="app" role="tabpanel" aria-labelledby="app-tab">
                    <div class="card custom-border-card">
                        <h5 class="card-header">{{__('label.app_settings')}}</h5>
                        <div class="card-body">
                            <form id="app_setting" enctype="multipart/form-data">
                                <div class="form-row">
                                    <div class="col-md-9">
                                        <div class="form-row">
                                            <div class="form-group col-md-4">
                                                <label>{{__('label.app_name')}}<span class="text-danger">*</span></label>
                                                <input type="text" name="app_name" value="@if($result && isset($result['app_name'])){{$result['app_name']}}@endif" class="form-control" placeholder="{{__('label.enter_app_name')}}">
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label>{{__('label.host_email')}}<span class="text-danger">*</span></label>
                                                <input type="email" name="host_email" value="@if($result && isset($result['host_email'])){{$result['host_email']}}@endif" class="form-control" placeholder="{{__('label.enter_host_email')}}">
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label>{{__('label.app_version')}}<span class="text-danger">*</span></label>
                                                <input type="text" name="app_version" value="@if($result && isset($result['app_version'])){{$result['app_version']}}@endif" class="form-control" placeholder="{{__('label.enter_app_version')}}">
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-4">
                                                <label>{{__('label.author')}}<span class="text-danger">*</span></label>
                                                <input type="text" name="author" value="@if($result && isset($result['author'])){{$result['author']}}@endif" class="form-control" placeholder="{{__('label.enter_author')}}">
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label>{{__('label.email')}} <span class="text-danger">*</span></label>
                                                <input type="email" name="email"  value="@if($result && isset($result['email'])){{$result['email']}}@endif" class="form-control" placeholder="{{__('label.enter_email')}}">
                                            </div>
                                            <div class="form-group  col-md-4">
                                                <label> {{__('label.contact')}} <span class="text-danger">*</span></label>
                                                <input type="text" name="contact" value="@if($result && isset($result['contact'])){{$result['contact']}}@endif" class="form-control" placeholder="{{__('label.enter_contact')}}">
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-4">
                                                <label>{{__('label.website')}}<span class="text-danger">*</span></label>
                                                <input type="text" name="website" value="@if($result && isset($result['website'])){{$result['website']}}@endif" class="form-control" placeholder="{{__('label.enter_your_website')}}">
                                            </div>
                                            <div class="form-group col-md-8">
                                                <label>{{__('label.app_description')}}<span class="text-danger">*</span></label>
                                                <textarea name="app_desripation" rows="1" class="form-control" placeholder="Hello...">@if($result && isset($result['app_desripation'])){{$result['app_desripation']}}@endif</textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group ml-5">
                                            <label class="ml-5">{{__('label.app_icon')}}<span class="text-danger">*</span></label>
                                            <div class="avatar-upload ml-5">
                                                <div class="avatar-edit">
                                                    <input type='file' name="app_logo" id="imageUpload" accept=".png, .jpg, .jpeg" />
                                                    <label for="imageUpload" title="{{__('label.select_file')}}"></label>
                                                </div>
                                                <div class="avatar-preview">
                                                    <img src="{{$result['app_logo']}}" alt="upload_img.png" id="imagePreview">
                                                </div>
                                            </div>
                                            <input type="hidden" name="old_app_logo" value="{{$result['app_logo']}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="border-top pt-3 text-right">
                                    <button type="button" class="btn btn-default mw-120" onclick="app_setting()">{{__('label.save')}}</button>
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- API Configrations -->
                    <div class="card custom-border-card">
                        <h5 class="card-header">{{__('label.api_configrations')}}</h5>
                        <div class="card-body">
                            <div class="input-group">
                                <div class="col-1">
                                    <label class="pt-3" style="font-size:16px; font-weight:500; color:#1b1b1b">{{__('label.api_path')}}</label>
                                </div>
                                <input type="text" readonly value="{{url('/')}}/api/" name="api_path" class="form-control" id="api_path">
                                <div class="input-group-text ml-2" onclick="Function_Api_path()" title="{{__('label.copy')}}">
                                    <i class="fa-solid fa-copy fa-2xl"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-6">
                            <!-- TMDb Api Key -->
                            @if( env('DEMO_MODE') == 'OFF')
                                <div class="card custom-border-card">
                                    <h5 class="card-header">{{__('label.tmdb_api_key')}}</h5>
                                    <div class="card-body">
                                        <form id="save_tmdb_api_key">
                                            <div class="form-row">
                                                <div class="col-4">
                                                    <div class="form-group">
                                                        <label>{{__('label.tmdb_active')}}<span class="text-danger">*</span></label>
                                                        <div class="radio-group">
                                                            <div class="custom-control custom-radio">
                                                                <input type="radio" name="tmdb_status" id="tmdb_status_yes" class="custom-control-input" value="1" {{$result['tmdb_status'] == 1 ? 'checked' : ''}}>
                                                                <label class="custom-control-label" for="tmdb_status_yes">{{__('label.yes')}}</label>
                                                            </div>
                                                            <div class="custom-control custom-radio">
                                                                <input type="radio" name="tmdb_status" id="tmdb_status_no" class="custom-control-input" value="0" {{$result['tmdb_status'] == 0 ? 'checked' : ''}}>
                                                                <label class="custom-control-label" for="tmdb_status_no">{{__('label.no')}}</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group col-8 tmdb_api_key">
                                                    <label>{{__('label.tmdb_api_key')}}<span class="text-danger">*</span></label>
                                                    <input type="password" name="tmdb_api_key" class="form-control" value="{{$result['tmdb_api_key']}}" placeholder="{{__('label.enter_tmdb_api_key')}}">
                                                </div>
                                            </div>
                                            <label class="mt-1 text-gray">{{__('label.tmdb_notes')}} <a href="https://developer.themoviedb.org/docs/getting-started" target="_blank" class="btn-link">{{__('label.click_here')}}</a></label>
                                            <div class="border-top pt-3 text-right">
                                                <button type="button" class="btn btn-default mw-120" onclick="save_tmdb_api_key()">{{__('label.save')}}</button>
                                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            @endif
                            <!-- Purchase Code -->
                            <div class="card custom-border-card">
                                <h5 class="card-header">{{__('label.purchase_code')}}</h5>
                                <div class="card-body">
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label>{{__('label.purchase_code')}}</label>
                                            <input type="text" class="form-control" value="{{env('PURCHASE_CODE')}}" readonly>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label> {{__('label.envato_name')}}</label>
                                            <input type="text" class="form-control" value="{{env('BUYER_USERNAME')}}" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <!-- Currency Settings -->
                            <div class="card custom-border-card">
                                <h5 class="card-header">{{__('label.currency_settings')}}</h5>
                                <div class="card-body">
                                    <form id="save_currency">
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label>{{__('label.currency_name')}}<span class="text-danger">*</span></label>
                                                <input type="text" name="currency" class="form-control" value="{{$result['currency']}}" placeholder="{{__('label.enter_currency_name')}}">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label> {{__('label.currency_code')}}<span class="text-danger">*</span></label>
                                                <input type="text" name="currency_code" class="form-control" value="{{$result['currency_code']}}" placeholder="{{__('label.enter_currency_code')}}">
                                            </div>
                                        </div>
                                        <div class="border-top pt-3 text-right">
                                            <button type="button" class="btn btn-default mw-120" onclick="save_currency()">{{__('label.save')}}</button>
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <!-- Vapid_key -->
                            @if( env('DEMO_MODE') == 'OFF')
                            <div class="card custom-border-card">
                                <h5 class="card-header">Vapid Key</h5>
                                <div class="card-body">
                                    <form id="save_vapid_key">
                                        <div class="form-row">
                                            <div class="form-group col-md-12">
                                                <input type="text" name="vapid_key" class="form-control" value="{{$result['vapid_key']}}" placeholder="Enter Vapid Key">
                                            </div>
                                        </div>
                                        <div class="border-top pt-3 text-right">
                                            <button type="button" class="btn btn-default mw-120" onclick="save_vapid_key()">{{__('label.save')}}</button>
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        </div>
                                    </form>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="configrations" role="tabpanel" aria-labelledby="configrations-tab">
                    <!-- Basic Configrations -->
                    <form id="save_basic_configrations">
                        <div class="form-row">
                            <div class="col-4">
                                <div class="card custom-border-card">
                                    <h5 class="card-header">{{__('label.auto_play_trailer_status')}}<span class="text-danger">*</span></h5>
                                    <div class="card-body">
                                        <div class="form-row">
                                            <div class="col-12">
                                                <div class="radio-group">
                                                    <div class="custom-control custom-radio">
                                                        <input type="radio" name="auto_play_trailer" id="auto_play_trailer_yes" class="custom-control-input" value="1" {{$result['auto_play_trailer'] == 1 ? 'checked' : ''}}>
                                                        <label class="custom-control-label" for="auto_play_trailer_yes">{{__('label.yes')}}</label>
                                                    </div>
                                                    <div class="custom-control custom-radio">
                                                        <input type="radio" name="auto_play_trailer" id="auto_play_trailer_no" class="custom-control-input" value="0" {{$result['auto_play_trailer'] == 0 ? 'checked' : ''}}>
                                                        <label class="custom-control-label" for="auto_play_trailer_no">{{__('label.no')}}</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="card custom-border-card">
                                    <h5 class="card-header">{{__('label.active_tv_status')}}<span class="text-danger">*</span></h5>
                                    <div class="card-body">
                                        <div class="form-row">
                                            <div class="col-12">
                                                <div class="radio-group">
                                                    <div class="custom-control custom-radio">
                                                        <input type="radio" name="active_tv_status" id="active_tv_status_yes" class="custom-control-input" value="1" {{$result['active_tv_status'] == 1 ? 'checked' : ''}}>
                                                        <label class="custom-control-label" for="active_tv_status_yes">{{__('label.yes')}}</label>
                                                    </div>
                                                    <div class="custom-control custom-radio">
                                                        <input type="radio" name="active_tv_status" id="active_tv_status_no" class="custom-control-input" value="0" {{$result['active_tv_status'] == 0 ? 'checked' : ''}}>
                                                        <label class="custom-control-label" for="active_tv_status_no">{{__('label.no')}}</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="card custom-border-card">
                                    <h5 class="card-header">{{__('label.parent_control_status')}}<span class="text-danger">*</span></h5>
                                    <div class="card-body">
                                        <div class="form-row">
                                            <div class="col-12">
                                                <div class="radio-group">
                                                    <div class="custom-control custom-radio">
                                                        <input type="radio" name="parent_control_status" id="parent_control_status_yes" class="custom-control-input" value="1" {{$result['parent_control_status'] == 1 ? 'checked' : ''}}>
                                                        <label class="custom-control-label" for="parent_control_status_yes">{{__('label.yes')}}</label>
                                                    </div>
                                                    <div class="custom-control custom-radio">
                                                        <input type="radio" name="parent_control_status" id="parent_control_status_no" class="custom-control-input" value="0" {{$result['parent_control_status'] == 0 ? 'checked' : ''}}>
                                                        <label class="custom-control-label" for="parent_control_status_no">{{__('label.no')}}</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-4">
                                <div class="card custom-border-card">
                                    <h5 class="card-header">{{__('label.watchlist_status')}}<span class="text-danger">*</span></h5>
                                    <div class="card-body">
                                        <div class="form-row">
                                            <div class="col-12">
                                                <div class="radio-group">
                                                    <div class="custom-control custom-radio">
                                                        <input type="radio" name="watchlist_status" id="watchlist_status_yes" class="custom-control-input" value="1" {{$result['watchlist_status'] == 1 ? 'checked' : ''}}>
                                                        <label class="custom-control-label" for="watchlist_status_yes">{{__('label.yes')}}</label>
                                                    </div>
                                                    <div class="custom-control custom-radio">
                                                        <input type="radio" name="watchlist_status" id="watchlist_status_no" class="custom-control-input" value="0" {{$result['watchlist_status'] == 0 ? 'checked' : ''}}>
                                                        <label class="custom-control-label" for="watchlist_status_no">{{__('label.no')}}</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="card custom-border-card">
                                    <h5 class="card-header">{{__('label.download_status')}}<span class="text-danger">*</span></h5>
                                    <div class="card-body">
                                        <div class="form-row">
                                            <div class="col-12">
                                                <div class="radio-group">
                                                    <div class="custom-control custom-radio">
                                                        <input type="radio" name="download_status" id="download_status_yes" class="custom-control-input" value="1" {{$result['download_status'] == 1 ? 'checked' : ''}}>
                                                        <label class="custom-control-label" for="download_status_yes">{{__('label.yes')}}</label>
                                                    </div>
                                                    <div class="custom-control custom-radio">
                                                        <input type="radio" name="download_status" id="download_status_no" class="custom-control-input" value="0" {{$result['download_status'] == 0 ? 'checked' : ''}}>
                                                        <label class="custom-control-label" for="download_status_no">{{__('label.no')}}</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="card custom-border-card">
                                    <h5 class="card-header">{{__('label.continue_watching_status')}}<span class="text-danger">*</span></h5>
                                    <div class="card-body">
                                        <div class="form-row">
                                            <div class="col-12">
                                                <div class="radio-group">
                                                    <div class="custom-control custom-radio">
                                                        <input type="radio" name="continue_watching_status" id="continue_watching_status_yes" class="custom-control-input" value="1" {{$result['continue_watching_status'] == 1 ? 'checked' : ''}}>
                                                        <label class="custom-control-label" for="continue_watching_status_yes">{{__('label.yes')}}</label>
                                                    </div>
                                                    <div class="custom-control custom-radio">
                                                        <input type="radio" name="continue_watching_status" id="continue_watching_status_no" class="custom-control-input" value="0" {{$result['continue_watching_status'] == 0 ? 'checked' : ''}}>
                                                        <label class="custom-control-label" for="continue_watching_status_no">{{__('label.no')}}</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-4">
                                <div class="card custom-border-card">
                                    <h5 class="card-header">{{__('label.onboarding_screen_status')}}<span class="text-danger">*</span></h5>
                                    <div class="card-body">
                                        <div class="form-row">
                                            <div class="col-12">
                                                <div class="radio-group">
                                                    <div class="custom-control custom-radio">
                                                        <input type="radio" name="on_boarding_screen_status" id="on_boarding_screen_status_yes" class="custom-control-input" value="1" {{$result['on_boarding_screen_status'] == 1 ? 'checked' : ''}}>
                                                        <label class="custom-control-label" for="on_boarding_screen_status_yes">Yes</label>
                                                    </div>
                                                    <div class="custom-control custom-radio">
                                                        <input type="radio" name="on_boarding_screen_status" id="on_boarding_screen_status_no" class="custom-control-input" value="0" {{$result['on_boarding_screen_status'] == 0 ? 'checked' : ''}}>
                                                        <label class="custom-control-label" for="on_boarding_screen_status_no">No</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="card custom-border-card">
                                    <h5 class="card-header">{{__('label.coupon_status')}}<span class="text-danger">*</span></h5>
                                    <div class="card-body">
                                        <div class="form-row">
                                            <div class="col-12">
                                                <div class="radio-group">
                                                    <div class="custom-control custom-radio">
                                                        <input type="radio" name="coupon_status" id="coupon_status_yes" class="custom-control-input" value="1" {{$result['coupon_status'] == 1 ? 'checked' : ''}}>
                                                        <label class="custom-control-label" for="coupon_status_yes">{{__('label.yes')}}</label>
                                                    </div>
                                                    <div class="custom-control custom-radio">
                                                        <input type="radio" name="coupon_status" id="coupon_status_no" class="custom-control-input" value="0" {{$result['coupon_status'] == 0 ? 'checked' : ''}}>
                                                        <label class="custom-control-label" for="coupon_status_no">{{__('label.no')}}</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="card custom-border-card">
                                    <h5 class="card-header">{{__('label.rent_status')}}<span class="text-danger">*</span></h5>
                                    <div class="card-body">
                                        <div class="form-row">
                                            <div class="col-12">
                                                <div class="radio-group">
                                                    <div class="custom-control custom-radio">
                                                        <input type="radio" name="rent_status" id="rent_status_yes" class="custom-control-input" value="1" {{$result['rent_status'] == 1 ? 'checked' : ''}}>
                                                        <label class="custom-control-label" for="rent_status_yes">{{__('label.yes')}}</label>
                                                    </div>
                                                    <div class="custom-control custom-radio">
                                                        <input type="radio" name="rent_status" id="rent_status_no" class="custom-control-input" value="0" {{$result['rent_status'] == 0 ? 'checked' : ''}}>
                                                        <label class="custom-control-label" for="rent_status_no">{{__('label.no')}}</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <!-- <div class="col-4">
                                <div class="card custom-border-card">
                                    <h5 class="card-header">{{__('label.multiple_device_sync')}}<span class="text-danger">*</span></h5>
                                    <div class="card-body">
                                        <div class="form-row">
                                            <div class="col-6 form-group">
                                                <label>Multiple Device Sync<span class="text-danger">*</span></label>
                                                <div class="radio-group">
                                                    <div class="custom-control custom-radio">
                                                        <input type="radio" name="multiple_device_sync" id="multiple_device_sync_yes" class="custom-control-input" value="1" {{$result['multiple_device_sync'] == 1 ? 'checked' : ''}}>
                                                        <label class="custom-control-label" for="multiple_device_sync_yes">Yes</label>
                                                    </div>
                                                    <div class="custom-control custom-radio">
                                                        <input type="radio" name="multiple_device_sync" id="multiple_device_sync_no" class="custom-control-input" value="0" {{$result['multiple_device_sync'] == 0 ? 'checked' : ''}}>
                                                        <label class="custom-control-label" for="multiple_device_sync_no">No</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-6 form-group no_of_device_sync">
                                                <label>Number Of Device Sync<span class="text-danger">*</span></label>
                                                <input type="number" name="no_of_device_sync" value="@if($result && isset($result['no_of_device_sync'])){{$result['no_of_device_sync']}}@endif" min="0" class="form-control" placeholder="Enter Number">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div> -->
                            <div class="col-4">
                                <div class="card custom-border-card">
                                    <h5 class="card-header">{{__('label.subscription_status')}}<span class="text-danger">*</span></h5>
                                    <div class="card-body">
                                        <div class="form-row">
                                            <div class="col-12">
                                                <div class="radio-group">
                                                    <div class="custom-control custom-radio">
                                                        <input type="radio" name="subscription_status" id="subscription_status_yes" class="custom-control-input" value="1" {{$result['subscription_status'] == 1 ? 'checked' : ''}}>
                                                        <label class="custom-control-label" for="subscription_status_yes">{{__('label.yes')}}</label>
                                                    </div>
                                                    <div class="custom-control custom-radio">
                                                        <input type="radio" name="subscription_status" id="subscription_status_no" class="custom-control-input" value="0" {{$result['subscription_status'] == 0 ? 'checked' : ''}}>
                                                        <label class="custom-control-label" for="subscription_status_no">{{__('label.no')}}</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <label class="mt-1 text-gray">{{__('label.subscription_status_notes')}}</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="border-top pt-3 text-right">
                            <button type="button" class="btn btn-default mw-120" onclick="save_basic_configrations()">{{__('label.save')}}</button>
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        </div>
                    </form>
                </div>
                <div class="tab-pane fade" id="smtp" role="tabpanel" aria-labelledby="smtp-tab">
                    <div class="card custom-border-card">
                        <h5 class="card-header">{{__('label.email_setting_smtp')}}</h5>
                        <div class="card-body">
                            <form id="smtp_setting">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <input type="hidden" name="id" value="@if($smtp){{$smtp->id}}@endif">
                                <div class="form-row">
                                    <div class="form-group  col-md-3">
                                        <label>{{__('label.is_smtp_active')}}<span class="text-danger">*</span></label>
                                        <select name="status" class="form-control">
                                            <option value="">{{__('label.select_status')}}</option>
                                            <option value="0" @if($smtp){{ $smtp->status == 0  ? 'selected' : ''}}@endif>{{__('label.no')}}</option>
                                            <option value="1" @if($smtp){{ $smtp->status == 1  ? 'selected' : ''}}@endif>{{__('label.yes')}}</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label>{{__('label.host')}}<span class="text-danger">*</span></label>
                                        <input type="text" name="host" class="form-control" value="@if($smtp){{$smtp->host}}@endif" placeholder="{{__('label.enter_host')}}">
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label>{{__('label.port')}}<span class="text-danger">*</span></label>
                                        <input type="text" name="port" class="form-control" value="@if($smtp){{$smtp->port}}@endif" placeholder="{{__('label.enter_port')}}">
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label>{{__('label.protocol')}}<span class="text-danger">*</span></label>
                                        <input type="text" name="protocol" class="form-control" value="@if($smtp){{$smtp->protocol}}@endif" placeholder="{{__('label.enter_protocol')}}">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-3">
                                        <label>{{__('label.user_name')}}<span class="text-danger">*</span></label>
                                        <input type="text" name="user" class="form-control" value="@if($smtp){{$smtp->user}}@endif" placeholder="{{__('label.enter_user_name')}}">
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label>{{__('label.password')}}<span class="text-danger">*</span></label>
                                        <input type="password" name="pass" class="form-control" value="@if($smtp){{$smtp->pass}}@endif" placeholder="{{__('label.enter_password')}}">
                                        <label class="mt-1 text-gray">{{__('label.search_for_better_result')}} <a href="https://support.google.com/mail/answer/185833?hl=en" target="_blank" class="btn-link">{{__('label.click_here')}}</a></label>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label>{{__('label.from_name')}}<span class="text-danger">*</span></label>
                                        <input type="text" name="from_name" class="form-control" value="@if($smtp){{$smtp->from_name}}@endif" placeholder="{{__('label.enter_from_name')}}">
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label>{{__('label.from_email')}}<span class="text-danger">*</span></label>
                                        <input type="text" name="from_email" class="form-control" value="@if($smtp){{$smtp->from_email}}@endif" placeholder="{{__('label.enter_from_email')}}">
                                    </div>
                                </div>
                                <div class="border-top pt-3 text-right">
                                    <button type="button" class="btn btn-default mw-120" onclick="smtp_setting()">{{__('label.save')}}</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="social" role="tabpanel" aria-labelledby="social-tab">
                    <div class="card custom-border-card">
                        <h5 class="card-header">{{__('label.social_links')}}</h5>
                        <div class="card-body">
                            <form id="social_link" enctype="multipart/form-data">
                                <div class="row col-md-12">
                                    <div class="form-group col-md-3">
                                        <label>{{__('label.name')}}<span class="text-danger">*</span></label>
                                        <input type="text" name="name[]" class="form-control" placeholder="{{__('label.enter_url_name')}}">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>{{__('label.url')}}<span class="text-danger">*</span></label>
                                        <input type="url" name="url[]" class="form-control" placeholder="{{__('label.enter_url')}}">
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label>{{__('label.icon')}}<span class="text-danger">*</span></label>
                                        <input type="file" name="image[]" class="form-control import-file social_img" id="social_img" accept=".png, .jpg, .jpeg">
                                        <input type="hidden" name="old_image[]" value="">
                                    </div>
                                    <div class="form-group col-md-1">
                                        <div class="custom-file">
                                            <img src="{{asset('assets/imgs/upload_img.png')}}" style="height: 90px; width: 90px;" class="img-thumbnail" id="link_img_social_img">
                                        </div>
                                    </div>
                                    <div class="col-md-1 mt-2">
                                        <div class="flex-grow-1 px-5 d-inline-flex">
                                            <div class="change mr-3 mt-4" id="add_btn" title="{{__('label.add_more')}}">
                                                <a class="btn btn-success add-more text-white" onclick="add_more_link()">+</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @for ($i=0; $i < count($social_link); $i++)
                                    <div class="social_part">
                                        <div class="row col-lg-12">
                                            <div class="form-group col-md-3">
                                                <label>{{__('label.name')}}<span class="text-danger">*</span></label>
                                                <input type="text" name="name[]" value="{{ $social_link[$i]['name'] }}" class="form-control" placeholder="{{__('label.enter_url_name')}}">
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label>{{__('label.url')}}<span class="text-danger">*</span></label>
                                                <input type="url" name="url[]" value="{{ $social_link[$i]['url'] }}" class="form-control" placeholder="{{__('label.enter_url')}}">
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label>{{__('label.icon')}}<span class="text-danger">*</span></label>
                                                <input type="file" name="image[]" class="form-control import-file social_img" id="social_img_{{$i}}" accept=".png, .jpg, .jpeg">
                                                <input type="hidden" name="old_image[]" value="{{ basename($social_link[$i]['image']) }}">
                                            </div>
                                            <div class="form-group col-md-1">
                                                <div class="custom-file">
                                                    <img src="{{$social_link[$i]['image']}}" style="height: 90px; width: 90px;" class="img-thumbnail" id="link_img_social_img_{{$i}}">
                                                </div>
                                            </div>
                                            <div class="col-md-1 mt-2">
                                                <div class="flex-grow-1 px-5 d-inline-flex">
                                                    <div class="change mr-3 mt-4" id="add_btn" title="{{__('label.remove')}}">
                                                        <a class="btn btn-danger text-white remove_link">-</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endfor               
                                
                                <div class="after-add-more"></div>

                                <div class="border-top pt-3 text-right">
                                    <button type="button" class="btn btn-default mw-120" onclick="social_link()">{{__('label.save')}}</button>
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="onboarding" role="tabpanel" aria-labelledby="onboarding-tab">
                    <div class="card custom-border-card">
                        <h5 class="card-header">{{__('label.onboarding_screen')}}</h5>

                        <div class="card-body">
                            <form id="onboarding_form" enctype="multipart/form-data">
                                <div class="row col-md-12">
                                    <div class="form-group col-md-6">
                                        <label>{{__('label.title')}}<span class="text-danger">*</span></label>
                                        <input type="text" name="title[]" class="form-control" placeholder="{{__('label.enter_title')}}">
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label>{{__('label.image')}}<span class="text-danger">*</span></label>
                                        <input type="file" name="image[]" class="form-control import-file on_boarding_img" id="on_boarding_img" accept=".png, .jpg, .jpeg">
                                        <input type="hidden" name="old_image[]" value="">
                                    </div>
                                    <div class="form-group col-md-1">
                                        <div class="custom-file">
                                            <img src="{{asset('assets/imgs/upload_img.png')}}" style="height: 90px; width: 90px;" class="img-thumbnail" id="link_img_on_boarding_img">
                                        </div>
                                    </div>
                                    <div class="col-md-1 mt-2">
                                        <div class="flex-grow-1 px-5 d-inline-flex">
                                            <div class="change mr-3 mt-4" id="add_btn" title="{{__('label.add_more')}}">
                                                <a class="btn btn-success add-more text-white" onclick="add_more_screen()">+</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @for ($i=0; $i < count($onboarding_screen); $i++)
                                    <div class="onboarding_part">
                                        <div class="row col-lg-12">
                                            <div class="form-group col-md-6">
                                                <label>{{__('label.title')}}<span class="text-danger">*</span></label>
                                                <input type="text" name="title[]" value="{{ $onboarding_screen[$i]['title'] }}" class="form-control" placeholder="{{__('label.enter_title')}}">
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label>{{__('label.image')}}<span class="text-danger">*</span></label>
                                                <input type="file" name="image[]" class="form-control import-file on_boarding_img" id="on_boarding_img{{$i}}" accept=".png, .jpg, .jpeg">
                                                <input type="hidden" name="old_image[]" value="{{ basename($onboarding_screen[$i]['image']) }}">
                                            </div>
                                            <div class="form-group col-md-1">
                                                <div class="custom-file">
                                                    <img src="{{$onboarding_screen[$i]['image']}}" style="height: 90px; width: 90px;" class="img-thumbnail" id="link_img_on_boarding_img{{$i}}">
                                                </div>
                                            </div>
                                            <div class="col-md-1 mt-2">
                                                <div class="flex-grow-1 px-5 d-inline-flex">
                                                    <div class="change mr-3 mt-4" id="add_btn" title="{{__('label.remove')}}">
                                                        <a class="btn btn-danger text-white remove_on_boarding">-</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endfor

                                <div class="after-add-more-on-boarding"></div>

                                <div class="border-top pt-3 text-right">
                                    <button type="button" class="btn btn-default mw-120" onclick="onboarding()">{{__('label.save')}}</button>
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('pagescript')
    <script>

        // Sidebar Scroll Down
        sidebar_down($(document).height());

        // API Key
        function Function_Api_path() {
            /* Get the text field */
            var copyText = document.getElementById("api_path");

            /* Select the text field */
            copyText.select();
            copyText.setSelectionRange(0, 99999); /* For mobile devices */

            document.execCommand('copy');

            /* Alert the copied text */
            alert("Copied the API Path: " + copyText.value);
        }

        $(document).ready(function() {
            var tmdb_status = "<?php echo $result['tmdb_status']; ?>";
            if(tmdb_status == 1){
                $(".tmdb_api_key").show();
            } else {
                $(".tmdb_api_key").hide();
            }
            $('input[type=radio][name=tmdb_status]').change(function() {
                if (this.value == 1) {
                    $(".tmdb_api_key").show();
                }
                else if (this.value == 0) {
                    $(".tmdb_api_key").hide();
                }
            });

            var multiple_device_sync = "<?php echo $result['multiple_device_sync']; ?>";
            if(multiple_device_sync == 1){
                $(".no_of_device_sync").show();
            } else {
                $(".no_of_device_sync").hide();
            }
            $('input[type=radio][name=multiple_device_sync]').change(function() {
                if (this.value == 1) {
                    $(".no_of_device_sync").show();
                }
                else if (this.value == 0) {
                    $(".no_of_device_sync").hide();
                }
            });
        });

        // App Setting
        function app_setting() {

            var Check_Admin = '<?php echo Check_Admin_Access(); ?>';
            if(Check_Admin == 1){

                $("#dvloader").show();
                var formData = new FormData($("#app_setting")[0]);
                $.ajax({
                    type: 'POST',
                    url: '{{ route("setting.app") }}',
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function(resp) {
                        $("#dvloader").hide();
                        get_responce_message(resp, 'app_setting', '{{ route("setting") }}');
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

        // TMDb API Key
        function save_tmdb_api_key() {

            var Check_Admin = '<?php echo Check_Admin_Access(); ?>';
            if(Check_Admin == 1){

                $("#dvloader").show();
                var formData = new FormData($("#save_tmdb_api_key")[0]);
                $.ajax({
                    type: 'POST',
                    url: '{{ route("setting.tmdbkey") }}',
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function(resp) {
                        $("#dvloader").hide();
                        $("html, body").animate({
                            scrollTop: 0
                        }, "swing");
                        get_responce_message(resp);
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

        // Currency Setting
        function save_currency() {

            var Check_Admin = '<?php echo Check_Admin_Access(); ?>';
            if(Check_Admin == 1){

                var formData = new FormData($("#save_currency")[0]);
                $("#dvloader").show();
                $.ajax({
                    type: 'POST',
                    url: '{{ route("setting.currency") }}',
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function(resp) {
                        $("#dvloader").hide();
                        $("html, body").animate({scrollTop: 0}, "swing");
                        get_responce_message(resp);
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

        // Basic Configrations
        function save_basic_configrations() {

            var Check_Admin = '<?php echo Check_Admin_Access(); ?>';
            if(Check_Admin == 1){

                $("#dvloader").show();
                var formData = new FormData($("#save_basic_configrations")[0]);
                $.ajax({
                    type: 'POST',
                    url: '{{ route("setting.basicconfigrations") }}',
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function(resp) {
                        $("#dvloader").hide();
                        $("html, body").animate({
                            scrollTop: 0
                        }, "swing");
                        get_responce_message(resp);
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

        // SMTP
        function smtp_setting() {

            var Check_Admin = '<?php echo Check_Admin_Access(); ?>';
            if(Check_Admin == 1){

                $("#dvloader").show();
                var formData = new FormData($("#smtp_setting")[0]);
                $.ajax({
                    type: 'POST',
                    url: '{{ route("smtp.save") }}',
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function(resp) {
                        $("#dvloader").hide();
                        $("html, body").animate({scrollTop: 0}, "swing");
                        get_responce_message(resp);
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

        // Multipal Img Show 
        $(document).on('change', '.social_img', function(){
            readURL(this, this.id);
        });
        $(document).on('change', '.on_boarding_img', function(){
            readURL(this, this.id);
        });
        function readURL(input, id) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                 
                reader.onload = function (e) {
                    $('#link_img_'+id).attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        // Social Link Add-Remove Link Part
        var i = -1;
        function add_more_link(){

            var data = '<div class="social_part">';
                data += '<div class="row col-md-12">';
                data += '<div class="form-group col-md-3">';
                data += '<label>{{__("label.name")}}<span class="text-danger">*</span></label>';
                data += '<input type="text" name="name[]" class="form-control" placeholder="{{__("label.enter_url_name")}}">';
                data += '</div>';
                data += '<div class="form-group col-md-4">';
                data += '<label>{{__("label.url")}}<span class="text-danger">*</span></label>';
                data += '<input type="url" name="url[]" class="form-control" placeholder="{{__("label.enter_url")}}">';
                data += '</div>';
                data += '<div class="form-group col-lg-3">';
                data += '<label>{{__("label.icon")}}<span class="text-danger">*</span></label>';
                data += '<input type="file" name="image[]" class="form-control import-file social_img" id="social_img_'+i+'" accept=".png, .jpg, .jpeg">';
                data += '<input type="hidden" name="old_image[]" value="">';
                data += '</div>';
                data += '<div class="form-group col-md-1">';
                data += '<div class="custom-file">';
                data += '<img src="{{asset("assets/imgs/upload_img.png")}}" style="height: 90px; width: 90px;" class="img-thumbnail" id="link_img_social_img_'+i+'">';
                data += '</div>';
                data += '</div>';
                data += '<div class="col-md-1 mt-2">';
                data += '<div class="flex-grow-1 px-5 d-inline-flex">';
                data += '<div class="change mr-3 mt-4" id="add_btn" title="{{__("label.remove")}}">';
                data += '<a class="btn btn-danger add-more text-white remove_link">-</a>';
                data += '</div>';
                data += '</div>';
                data += '</div>';
                data += '</div>';
                data += '</div>';

            $('.after-add-more').append(data);
            i--;
            $("html, body").animate({ scrollTop: $(document).height() }, "slow");
        }
        $("body").on("click", ".remove_link", function(e) {
            $(this).parents('.social_part').remove();
        });
        // Social Link Save
        function social_link() {

            var Check_Admin = '<?php echo Check_Admin_Access(); ?>';
            if(Check_Admin == 1){

                $("#dvloader").show();
                var formData = new FormData($("#social_link")[0]);
                $.ajax({
                    type: 'POST',
                    url: '{{ route("settingSocialLink") }}',
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function(resp) {
                        $("#dvloader").hide();
                        get_responce_message(resp, 'app_setting', '{{ route("setting") }}');
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

        // OnBoarding Screen Add-Remove Link Part
        var i = -1;
        function add_more_screen(){

            var data = '<div class="onboarding_part">';
                data += '<div class="row col-md-12">';
                data += '<div class="form-group col-md-6">';
                data += '<label>{{__("label.title")}}<span class="text-danger">*</span></label>';
                data += '<input type="text" name="title[]" class="form-control" placeholder="{{__("label.enter_title")}}">';
                data += '</div>';
                data += '<div class="form-group col-lg-3">';
                data += '<label>{{__("label.image")}}<span class="text-danger">*</span></label>';
                data += '<input type="file" name="image[]" class="form-control import-file on_boarding_img" id="on_boarding_img_'+i+'" accept=".png, .jpg, .jpeg">';
                data += '<input type="hidden" name="old_image[]" value="">';
                data += '</div>';
                data += '<div class="form-group col-md-1">';
                data += '<div class="custom-file">';
                data += '<img src="{{asset("assets/imgs/upload_img.png")}}" style="height: 90px; width: 90px;" class="img-thumbnail" id="link_img_on_boarding_img_'+i+'">';
                data += '</div>';
                data += '</div>';
                data += '<div class="col-md-1 mt-2">';
                data += '<div class="flex-grow-1 px-5 d-inline-flex">';
                data += '<div class="change mr-3 mt-4" id="add_btn" title="{{__("label.remove")}}">';
                data += '<a class="btn btn-danger add-more text-white remove_on_boarding">-</a>';
                data += '</div>';
                data += '</div>';
                data += '</div>';
                data += '</div>';
                data += '</div>';

            $('.after-add-more-on-boarding').append(data);
            i--;
            $("html, body").animate({ scrollTop: $(document).height() }, "slow");
        }
        $("body").on("click", ".remove_on_boarding", function(e) {
            $(this).parents('.onboarding_part').remove();
        });
        // OnBoarding Screen Save
        function onboarding() {

            var Check_Admin = '<?php echo Check_Admin_Access(); ?>';
            if(Check_Admin == 1){

                $("#dvloader").show();
                var formData = new FormData($("#onboarding_form")[0]);
                $.ajax({
                    type: 'POST',
                    url: '{{ route("settingOnBoardingScreen") }}',
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function(resp) {
                        $("#dvloader").hide();
                        get_responce_message(resp, 'onboarding_form', '{{ route("setting") }}');
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

        // Vapid Key
        function save_vapid_key() {
            var Check_Admin = '<?php echo Check_Admin_Access(); ?>';
            if(Check_Admin == 1){

                var formData = new FormData($("#save_vapid_key")[0]);
                $("#dvloader").show();
                $.ajax({
                    type: 'POST',
                    url: '{{ route("setting.vapidkey") }}',
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function(resp) {
                        $("#dvloader").hide();
                        $("html, body").animate({scrollTop: 0}, "swing");
                        get_responce_message(resp);
                    },
                    error: function(XMLHttpRequest, textStatus, errorThrown) {
                        $("#dvloader").hide();
                        toastr.error(errorThrown, textStatus);
                    }
                });
            } else {
                toastr.error('You have no right to Add, Edit and Delete.');
            }
        }
    </script>
@endsection