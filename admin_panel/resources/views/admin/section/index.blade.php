@extends('admin.layout.page-app')
@section('page_title', __('label.section'))

@section('content')
    @include('admin.layout.sidebar')

    <div class="right-content">
        @include('admin.layout.header')

        <div class="body-content">
            <!-- mobile title -->
            <h1 class="page-title-sm">{{__('label.section')}}</h1>

            <div class="border-bottom row mb-3">
                <div class="col-sm-11">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{__('label.dashboard')}}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{__('label.section')}}</li>
                    </ol>
                </div>
                <div class="col-sm-1 d-flex justify-content-start mb-3" title="{{__('label.sortable')}}">
                    <button type="button" data-toggle="modal" data-target="#sortableModal" onclick="sortableBTN()" class="btn btn-default" style="border-radius: 10px;">
                        <i class="fa-solid fa-sort fa-1x"></i>
                    </button>
                </div>
            </div>

            <ul class="tabs nav nav-pills custom-tabs inline-tabs " id="pills-tab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="app-tab" onclick="Top_Content('1', '0', '0')" data-is_home_screen="1"
                        data-id="0" data-type="0" data-toggle="pill" href="#app" role="tab" aria-controls="app" aria-selected="true">{{__('label.home')}}</a>
                </li>
                @for ($i = 0; $i < count($type); $i++) 
                <li class="nav-item">
                    <a class="nav-link" id="{{$type[$i]['name']}}-tab" onclick="Top_Content('2' , '{{$type[$i]['id']}}', '{{$type[$i]['type']}}')" data-is_home_screen="2" 
                    data-id="{{$type[$i]['id']}}" data-type="{{$type[$i]['type']}}" data-toggle="pill" href="#{{$type[$i]['name']}}" role="tab" aria-controls="{{$type[$i]['name']}}" aria-selected="true">{{ $type[$i]['name']}}</a>
                </li>
                @endfor
            </ul>

            <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade show active" id="app" role="tabpanel" aria-labelledby="app-tab">
                    <div class="card custom-border-card">
                        <h5 class="card-header">{{__('label.section')}}</h5>
                        <div class="card-body">
                            <form id="save_content_section" enctype="multipart/form-data">
                                <input type="hidden" name="id" value="">
                                <div class="form-row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>{{__('label.title')}}<span class="text-danger">*</span></label>
                                            <input type="text" name="title" class="form-control" placeholder="{{__('label.enter_title')}}" autofocus>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>{{__('label.short_title')}}<span class="text-danger">*</span></label>
                                            <input type="text" name="short_title" class="form-control" placeholder="{{__('label.enter_short_title')}}">
                                        </div>
                                    </div>
                                    <div class="col-md-2 video_type_drop">
                                        <div class="form-group">
                                            <label>{{__('label.video_type')}}<span class="text-danger">*</span></label>
                                            <select name="video_type" class="form-control" id="video_type">
                                                <option value="">{{__('label.select_type')}}</option>
                                                <option value="1">{{__('label.video')}}</option>
                                                <option value="2">{{__('label.tv_show')}}</option>
                                                <option value="3">{{__('label.category')}}</option>
                                                <option value="4">{{__('label.language')}}</option>
                                                <option value="5">{{__('label.channel_list')}}</option>
                                                <option value="6">{{__('label.upcoming_content')}}</option>
                                                <option value="7">{{__('label.channel_content')}}</option>
                                                <option value="8">{{__('label.continue_watching')}}</option>
                                                <option value="9">{{__('label.kids_content')}}</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-2 sub_video_type_drop">
                                        <div class="form-group">
                                            <label>{{__('label.sub_video_type')}}<span class="text-danger">*</span></label>
                                            <select name="sub_video_type" class="form-control" id="sub_video_type">
                                                <option value="">{{__('label.select_type')}}</option>
                                                <option value="1">{{__('label.video')}}</option>
                                                <option value="2">{{__('label.tv_show')}}</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-2 type_drop">
                                        <div class="form-group">
                                            <label>{{__('label.type')}}</label>
                                            <select class="form-control" name="type_id" id="type_id" style="width:100%!important;">
                                                <option value="">{{__('label.select_type')}}</option>
                                                @foreach ($type as $key => $value)
                                                <option value="{{$value->id}}" data-type="{{$value->type}}">{{$value->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-md-3 category_drop">
                                        <div class="form-group">
                                            <label>{{__('label.category')}}<span class="text-danger">*</span></label>
                                            <select name="category_id" class="form-control" id="category_id">
                                                <option value="0">{{__('label.all_category')}}</option>
                                                @for ($i = 0; $i < count($category); $i++) 
                                                <option value="{{ $category[$i]['id'] }}">
                                                    {{ $category[$i]['name'] }}
                                                </option>
                                                @endfor
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3 language_drop">
                                        <div class="form-group">
                                            <label>{{__('label.language')}}<span class="text-danger">*</span></label>
                                            <select name="language_id" class="form-control" id="language_id">
                                                <option value="0">{{__('label.all_language')}}</option>
                                                @for ($i = 0; $i < count($language); $i++) 
                                                <option value="{{ $language[$i]['id'] }}">
                                                    {{ $language[$i]['name'] }}
                                                </option>
                                                @endfor
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-2 channel_drop">
                                        <div class="form-group">
                                            <label>{{__('label.channel')}}<span class="text-danger">*</span></label>
                                            <select name="channel_id" class="form-control" id="channel_id">
                                                <option value="0">{{__('label.all_channel')}}</option>
                                                @for ($i = 0; $i < count($channel); $i++) 
                                                <option value="{{ $channel[$i]['id'] }}">
                                                    {{ $channel[$i]['name'] }}
                                                </option>
                                                @endfor
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-2 screen_layout_drop">
                                        <div class="form-group">
                                            <label>{{__('label.screen_layout')}}<span class="text-danger">*</span></label>
                                            <select name="screen_layout" class="form-control" id="screen_layout">
                                                <option value="">{{__('label.select_screen_layout')}}</option>
                                                <option value="landscape">{{__('label.landscape')}}</option>
                                                <option value="portrait">{{__('label.portrait')}}</option>
                                                <option value="square">{{__('label.square')}}</option>
                                                <option value="category">{{__('label.category')}}</option>
                                                <option value="language">{{__('label.language')}}</option>
                                                <option value="channel">{{__('label.channel')}}</option>
                                                <option value="big_landscape">{{__('label.big_landscape')}}</option>
                                                <option value="big_portrait">{{__('label.big_portrait')}}</option>
                                                <option value="index_landscape">{{__('label.index_landscape')}}</option>
                                                <option value="index_portrait">{{__('label.index_portrait')}}</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-2 no_of_content_drop">
                                        <div class="form-group">
                                            <label>{{__('label.no_of_content')}}<span class="text-danger">*</span></label>
                                            <input type="number" min="1" value="1" name="no_of_content" class="form-control" placeholder="{{__('label.enter_number_of_content')}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-md-2 order_by_upload_drop">
                                        <div class="form-group">
                                            <label>{{__('label.order_by_upload')}}<span class="text-danger">*</span></label>
                                            <div class="radio-group">
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" name="order_by_upload" id="order_by_upload_yes" class="custom-control-input" value="1" checked>
                                                    <label class="custom-control-label" for="order_by_upload_yes">{{__('label.asc')}}</label>
                                                </div>
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" name="order_by_upload" id="order_by_upload_no" class="custom-control-input" value="2">
                                                    <label class="custom-control-label" for="order_by_upload_no">{{__('label.desc')}}</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-2 order_by_like_drop">
                                        <div class="form-group">
                                            <label>{{__('label.order_by_like')}}<span class="text-danger">*</span></label>
                                            <div class="radio-group">
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" name="order_by_like" id="order_by_like_yes" class="custom-control-input" value="1" checked>
                                                    <label class="custom-control-label" for="order_by_like_yes">{{__('label.asc')}}</label>
                                                </div>
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" name="order_by_like" id="order_by_like_no" class="custom-control-input" value="2">
                                                    <label class="custom-control-label" for="order_by_like_no">{{__('label.desc')}}</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-2 order_by_view_drop">
                                        <div class="form-group">
                                            <label>{{__('label.order_by_view')}}<span class="text-danger">*</span></label>
                                            <div class="radio-group">
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" name="order_by_view" id="order_by_view_yes" class="custom-control-input" value="1" checked>
                                                    <label class="custom-control-label" for="order_by_view_yes">{{__('label.asc')}}</label>
                                                </div>
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" name="order_by_view" id="order_by_view_no" class="custom-control-input" value="2">
                                                    <label class="custom-control-label" for="order_by_view_no">{{__('label.desc')}}</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-2 premium_video_drop">
                                        <div class="form-group">
                                            <label>{{__('label.premium_video')}}<span class="text-danger">*</span></label>
                                            <div class="radio-group">
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" name="premium_video" id="premium_video_yes" class="custom-control-input" value="1" checked>
                                                    <label class="custom-control-label" for="premium_video_yes">{{__('label.yes')}}</label>
                                                </div>
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" name="premium_video" id="premium_video_no" class="custom-control-input" value="0">
                                                    <label class="custom-control-label" for="premium_video_no">{{__('label.no')}}</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-2 rent_video_drop">
                                        <div class="form-group">
                                            <label>{{__('label.rent_video')}}<span class="text-danger">*</span></label>
                                            <div class="radio-group">
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" name="rent_video" id="rent_video_yes" class="custom-control-input" value="1" checked>
                                                    <label class="custom-control-label" for="rent_video_yes">{{__('label.yes')}}</label>
                                                </div>
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" name="rent_video" id="rent_video_no" class="custom-control-input" value="0">
                                                    <label class="custom-control-label" for="rent_video_no">{{__('label.no')}}</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-2 view_all_drop">
                                        <div class="form-group">
                                            <label>{{__('label.view_all')}}<span class="text-danger">*</span></label>
                                            <div class="radio-group">
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" name="view_all" id="view_all_yes" class="custom-control-input" value="1" checked>
                                                    <label class="custom-control-label" for="view_all_yes">{{__('label.yes')}}</label>
                                                </div>
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" name="view_all" id="view_all_no" class="custom-control-input" value="0">
                                                    <label class="custom-control-label" for="view_all_no">{{__('label.no')}}</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="border-top pt-3 text-right">
                                    <button type="button" class="btn btn-default mw-120" onclick="save_section()">{{__('label.save')}}</button>
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="after-add-more"></div>
                </div>
            </div>

            <!-- Modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" data-backdrop="static" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">{{__('label.edit_section')}}</h5>
                            <button type="button" class="close text-dark" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form id="edit_content_section" enctype="multipart/form-data">
                            <div class="modal-body">
                                <input type="hidden" name="id" id="edit_id" value="">
                                <input type="hidden" name="is_home_screen" id="edit_is_home_screen" value="">
                                <div class="form-row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>{{__('label.title')}}<span class="text-danger">*</span></label>
                                            <input type="text" name="title" id="edit_title" class="form-control" placeholder="{{__('label.enter_title')}}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>{{__('label.short_title')}}<span class="text-danger">*</span></label>
                                            <input type="text" name="short_title" id="edit_short_title" class="form-control" placeholder="{{__('label.enter_short_title')}}">
                                        </div>
                                    </div>
                                    <div class="col-md-6 edit_video_type_drop">
                                        <div class="form-group">
                                            <label>{{__('label.video_type')}}<span class="text-danger">*</span></label>
                                            <select name="video_type" class="form-control" id="edit_video_type">
                                                <option value="">{{__('label.select_type')}}</option>
                                                <option value="1">{{__('label.video')}}</option>
                                                <option value="2">{{__('label.tv_show')}}</option>
                                                <option value="3">{{__('label.category')}}</option>
                                                <option value="4">{{__('label.language')}}</option>
                                                <option value="5">{{__('label.channel_list')}}</option>
                                                <option value="6">{{__('label.upcoming_content')}}</option>
                                                <option value="7">{{__('label.channel_content')}}</option>
                                                <option value="8">{{__('label.continue_watching')}}</option>
                                                <option value="9">{{__('label.kids_content')}}</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6 edit_sub_video_type_drop">
                                        <div class="form-group">
                                            <label>{{__('label.sub_video_type')}}<span class="text-danger">*</span></label>
                                            <select name="sub_video_type" class="form-control" id="edit_sub_video_type">
                                                <option value="">{{__('label.select_type')}}</option>
                                                <option value="1">{{__('label.video')}}</option>
                                                <option value="2">{{__('label.tv_show')}}</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6 edit_type_drop">
                                        <div class="form-group">
                                            <label>{{__('label.type')}}</label>
                                            <select class="form-control" name="type_id" id="edit_type_id">
                                                <option value="">{{__('label.select_type')}}</option>
                                                @foreach ($type as $key => $value)
                                                <option value="{{$value->id}}" data-type="{{$value->type}}">{{$value->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6 edit_category_drop">
                                        <div class="form-group">
                                            <label>{{__('label.category')}}<span class="text-danger">*</span></label>
                                            <select name="category_id" class="form-control" id="edit_category_id" style="width:100%!important;">
                                                <option value="0">{{__('label.all_category')}}</option>
                                                @for ($i = 0; $i < count($category); $i++) 
                                                <option value="{{ $category[$i]['id'] }}">
                                                    {{ $category[$i]['name'] }}
                                                </option>
                                                @endfor
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6 edit_language_drop">
                                        <div class="form-group">
                                            <label>{{__('label.language')}}<span class="text-danger">*</span></label>
                                            <select name="language_id" class="form-control" id="edit_language_id" style="width:100%!important;">
                                                <option value="0">{{__('label.all_language')}}</option>
                                                @for ($i = 0; $i < count($language); $i++) 
                                                <option value="{{ $language[$i]['id'] }}">
                                                    {{ $language[$i]['name'] }}
                                                </option>
                                                @endfor
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6 edit_channel_drop">
                                        <div class="form-group">
                                            <label>{{__('label.channel')}}<span class="text-danger">*</span></label>
                                            <select name="channel_id" class="form-control" id="edit_channel_id" style="width:100%!important;">
                                                <option value="0">{{__('label.all_channel')}}</option>
                                                @for ($i = 0; $i < count($channel); $i++) 
                                                <option value="{{ $channel[$i]['id'] }}">
                                                    {{ $channel[$i]['name'] }}
                                                </option>
                                                @endfor
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6 edit_screen_layout_drop">
                                        <div class="form-group">
                                            <label>{{__('label.screen_layout')}}<span class="text-danger">*</span></label>
                                            <select name="screen_layout" class="form-control" id="edit_screen_layout">
                                                <option value="">{{__('label.select_screen_layout')}}</option>
                                                <option value="landscape">{{__('label.landscape')}}</option>
                                                <option value="portrait">{{__('label.portrait')}}</option>
                                                <option value="square">{{__('label.square')}}</option>
                                                <option value="category">{{__('label.category')}}</option>
                                                <option value="language">{{__('label.language')}}</option>
                                                <option value="channel">{{__('label.channel')}}</option>
                                                <option value="big_landscape">{{__('label.big_landscape')}}</option>
                                                <option value="big_portrait">{{__('label.big_portrait')}}</option>
                                                <option value="index_landscape">{{__('label.index_landscape')}}</option>
                                                <option value="index_portrait">{{__('label.index_portrait')}}</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6 edit_no_of_content_drop">
                                        <div class="form-group">
                                            <label>{{__('label.no_of_content')}}<span class="text-danger">*</span></label>
                                            <input type="number" min="1" name="no_of_content" id="edit_no_of_content" class="form-control" placeholder="{{__('label.enter_number_of_content')}}">
                                        </div>
                                    </div>
                                    <div class="col-md-4 edit_order_by_upload_drop">
                                        <div class="form-group">
                                            <label>{{__('label.order_by_upload')}}<span class="text-danger">*</span></label>
                                            <div class="radio-group">
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" name="order_by_upload" id="edit_order_by_upload_yes" class="custom-control-input" value="1" checked>
                                                    <label class="custom-control-label" for="edit_order_by_upload_yes">{{__('label.asc')}}</label>
                                                </div>
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" name="order_by_upload" id="edit_order_by_upload_no" class="custom-control-input" value="2">
                                                    <label class="custom-control-label" for="edit_order_by_upload_no">{{__('label.desc')}}</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 edit_order_by_like_drop">
                                        <div class="form-group">
                                            <label>{{__('label.order_by_like')}}<span class="text-danger">*</span></label>
                                            <div class="radio-group">
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" name="order_by_like" id="edit_order_by_like_yes" class="custom-control-input" value="1" checked>
                                                    <label class="custom-control-label" for="edit_order_by_like_yes">{{__('label.asc')}}</label>
                                                </div>
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" name="order_by_like" id="edit_order_by_like_no" class="custom-control-input" value="2">
                                                    <label class="custom-control-label" for="edit_order_by_like_no">{{__('label.desc')}}</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 edit_order_by_view_drop">
                                        <div class="form-group">
                                            <label>{{__('label.order_by_view')}}<span class="text-danger">*</span></label>
                                            <div class="radio-group">
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" name="order_by_view" id="edit_order_by_view_yes" class="custom-control-input" value="1" checked>
                                                    <label class="custom-control-label" for="edit_order_by_view_yes">{{__('label.asc')}}</label>
                                                </div>
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" name="order_by_view" id="edit_order_by_view_no" class="custom-control-input" value="2">
                                                    <label class="custom-control-label" for="edit_order_by_view_no">{{__('label.desc')}}</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 edit_premium_video_drop">
                                        <div class="form-group">
                                            <label>{{__('label.premium_video')}}<span class="text-danger">*</span></label>
                                            <div class="radio-group">
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" name="premium_video" id="edit_premium_video_yes" class="custom-control-input" value="1" checked>
                                                    <label class="custom-control-label" for="edit_premium_video_yes">{{__('label.yes')}}</label>
                                                </div>
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" name="premium_video" id="edit_premium_video_no" class="custom-control-input" value="0">
                                                    <label class="custom-control-label" for="edit_premium_video_no">{{__('label.no')}}</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 edit_view_all_drop">
                                        <div class="form-group">
                                            <label>{{__('label.view_all')}}<span class="text-danger">*</span></label>
                                            <div class="radio-group">
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" name="view_all" id="edit_view_all_yes" class="custom-control-input" value="1" checked>
                                                    <label class="custom-control-label" for="edit_view_all_yes">{{__('label.yes')}}</label>
                                                </div>
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" name="view_all" id="edit_view_all_no" class="custom-control-input" value="0">
                                                    <label class="custom-control-label" for="edit_view_all_no">{{__('label.no')}}</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 edit_rent_video_drop">
                                        <div class="form-group">
                                            <label>{{__('label.rent_video')}}<span class="text-danger">*</span></label>
                                            <div class="radio-group">
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" name="rent_video" id="edit_rent_video_yes" class="custom-control-input" value="1" checked>
                                                    <label class="custom-control-label" for="edit_rent_video_yes">{{__('label.yes')}}</label>
                                                </div>
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" name="rent_video" id="edit_rent_video_no" class="custom-control-input" value="0">
                                                    <label class="custom-control-label" for="edit_rent_video_no">{{__('label.no')}}</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default mw-120" onclick="update_section()">{{__('label.update')}}</button>
                                <button type="button" class="btn btn-cancel mw-120" data-dismiss="modal">{{__('label.close')}}</button>
                                <input type="hidden" name="_method" value="PATCH">
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- sortableModal -->
            <div class="modal fade" id="sortableModal" tabindex="-1" data-backdrop="static" role="dialog" aria-labelledby="sortableModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title w-100 text-center" id="sortableModalLabel">{{__('label.section_sortable_list')}}</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="close">
                                <span aria-hidden="true" class="text-dark">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div id="imageListId">
                                
                            </div>
                        </div>
                        <div class="modal-footer justify-content-center">
                            <form enctype="multipart/form-data" id="save_section_sortable">
                                @csrf
                                <input id="outputvalues" type="hidden" name="ids" value="" />
                                <div class="w-100 text-center">
                                    <button type="button" class="btn btn-default mw-120" onclick="save_section_sortable()">{{__('label.save')}}</button>
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
        $("#category_id").select2();
        $("#language_id").select2();
        $("#channel_id").select2();
        $("#edit_category_id").select2({ dropdownParent: $('#exampleModal') });
        $("#edit_language_id").select2({ dropdownParent: $('#exampleModal') });
        $("#edit_channel_id").select2({ dropdownParent: $('#exampleModal') });

        $(".sub_video_type_drop").hide();
        $(".type_drop").hide();
        $(".category_drop").hide();
        $(".language_drop").hide();
        $(".channel_drop").hide();
        $(".screen_layout_drop").hide();
        $(".no_of_content_drop").hide();
        $(".order_by_upload_drop").hide();
        $(".order_by_like_drop").hide();
        $(".order_by_view_drop").hide();
        $(".premium_video_drop").hide();
        $(".rent_video_drop").hide();
        $(".view_all_drop").hide();

        var tab = $("ul.tabs li a.active");
        var is_home_screen = tab.data("is_home_screen");
        var top_type_id = 0;
        var top_type_type = 0;
        $('.nav-item a').on('click', function() {
            is_home_screen = $(this).data("is_home_screen");
            top_type_id = $(this).data("id");
            top_type_type = $(this).data("type");
        });

        // Video_Type 
        $("#video_type").change(function() {

            var video_type = $(this).children("option:selected").val();
            if(video_type == 1 || video_type == 2){

                $(".sub_video_type_drop").hide();
                $(".type_drop").show();
                $(".category_drop").show();
                $(".language_drop").show();
                $(".channel_drop").hide();
                $(".screen_layout_drop").show();
                $(".no_of_content_drop").show();
                $(".order_by_upload_drop").show();
                $(".order_by_like_drop").show();
                $(".order_by_view_drop").show();
                if(video_type == 1){
                    $(".premium_video_drop").show();
                } else {
                    $(".premium_video_drop").hide();
                }
                $(".rent_video_drop").show();
                $(".view_all_drop").show();

                $("#screen_layout").children().removeAttr("selected");
                $("#screen_layout option[value='landscape']").show();
                $("#screen_layout option[value='portrait']").show();
                $("#screen_layout option[value='square']").show();
                $("#screen_layout option[value='category']").hide();
                $("#screen_layout option[value='language']").hide();
                $("#screen_layout option[value='channel']").hide();
                $("#screen_layout option[value='big_landscape']").show();
                $("#screen_layout option[value='big_portrait']").show();
                $("#screen_layout option[value='index_landscape']").show();
                $("#screen_layout option[value='index_portrait']").show();

                $("#type_id").children().removeAttr("selected");
                if(video_type == 1){
                    $("#type_id option[data-type=1]").show();
                    $("#type_id option[data-type=2]").hide();
                } else {
                    $("#type_id option[data-type=1]").hide();
                    $("#type_id option[data-type=2]").show();
                }
                $("#type_id option[data-type=5]").hide();
                $("#type_id option[data-type=6]").hide();
                $("#type_id option[data-type=7]").hide();

            } else if(video_type == 3 || video_type == 4 || video_type == 5){

                $(".sub_video_type_drop").hide();
                $(".type_drop").hide();
                $(".category_drop").hide();
                $(".language_drop").hide();
                $(".channel_drop").hide();
                $(".screen_layout_drop").show();
                $(".no_of_content_drop").show();
                $(".order_by_upload_drop").hide();
                $(".order_by_like_drop").hide();
                $(".order_by_view_drop").hide();
                $(".premium_video_drop").hide();
                $(".rent_video_drop").hide();
                $(".view_all_drop").show();

                $("#screen_layout").children().removeAttr("selected");
                $("#screen_layout option[value='landscape']").hide();
                $("#screen_layout option[value='portrait']").hide();
                $("#screen_layout option[value='square']").hide();
                if(video_type == 3){
                    $("#screen_layout option[value='category']").show();
                    $("#screen_layout option[value='language']").hide();
                    $("#screen_layout option[value='channel']").hide();
                } else if(video_type == 4){
                    $("#screen_layout option[value='category']").hide();
                    $("#screen_layout option[value='language']").show();
                    $("#screen_layout option[value='channel']").hide();
                } else {
                    $("#screen_layout option[value='category']").hide();
                    $("#screen_layout option[value='language']").hide();                    
                    $("#screen_layout option[value='channel']").show();
                }
                $("#screen_layout option[value='big_landscape']").hide();
                $("#screen_layout option[value='big_portrait']").hide();
                $("#screen_layout option[value='index_landscape']").hide();
                $("#screen_layout option[value='index_portrait']").hide();

                $("#type_id").children().removeAttr("selected");
                $("#type_id option[data-type=1]").hide();
                $("#type_id option[data-type=2]").hide();
                $("#type_id option[data-type=5]").hide();
                $("#type_id option[data-type=6]").hide();
                $("#type_id option[data-type=7]").hide();

            } else if(video_type == 6 || video_type == 7 || video_type == 9){

                $(".sub_video_type_drop").show();
                $(".type_drop").show();
                $(".category_drop").show();
                $(".language_drop").show();
                if(video_type == 6 || video_type == 9){
                    $(".channel_drop").hide();
                } else {
                    $(".channel_drop").show();
                }
                $(".screen_layout_drop").show();
                $(".no_of_content_drop").show();
                $(".order_by_upload_drop").show();
                $(".order_by_like_drop").show();
                $(".order_by_view_drop").show();
                $(".premium_video_drop").hide();
                $(".rent_video_drop").show();
                $(".view_all_drop").show();

                $("#screen_layout").children().removeAttr("selected");
                $("#screen_layout option[value='landscape']").show();
                $("#screen_layout option[value='portrait']").show();
                $("#screen_layout option[value='square']").show();
                $("#screen_layout option[value='category']").hide();
                $("#screen_layout option[value='language']").hide();
                $("#screen_layout option[value='channel']").hide();
                $("#screen_layout option[value='big_landscape']").show();
                $("#screen_layout option[value='big_portrait']").show();
                $("#screen_layout option[value='index_landscape']").show();
                $("#screen_layout option[value='index_portrait']").show();

                $("#type_id").children().removeAttr("selected");
                $("#type_id option[data-type=1]").hide();
                $("#type_id option[data-type=2]").hide();
                if(video_type == 6){
                    $("#type_id option[data-type=5]").show();
                    $("#type_id option[data-type=6]").hide();
                    $("#type_id option[data-type=7]").hide();
                } else if(video_type == 7){
                    $("#type_id option[data-type=5]").hide();
                    $("#type_id option[data-type=6]").show();
                    $("#type_id option[data-type=7]").hide();
                } else if(video_type == 9){
                    $("#type_id option[data-type=5]").hide();
                    $("#type_id option[data-type=6]").hide();
                    $("#type_id option[data-type=7]").show();
                }
            } else if(video_type == 8){

                $(".sub_video_type_drop").hide();
                $(".type_drop").hide();
                $(".category_drop").hide();
                $(".language_drop").hide();
                $(".channel_drop").hide();
                $(".screen_layout_drop").show();
                $(".no_of_content_drop").hide();
                $(".order_by_upload_drop").hide();
                $(".order_by_like_drop").hide();
                $(".order_by_view_drop").hide();
                $(".premium_video_drop").hide();
                $(".rent_video_drop").hide();
                $(".view_all_drop").hide();

                $("#screen_layout").children().removeAttr("selected");
                $("#screen_layout option[value='landscape']").show();
                $("#screen_layout option[value='portrait']").show();
                $("#screen_layout option[value='square']").show();
                $("#screen_layout option[value='category']").hide();
                $("#screen_layout option[value='language']").hide();
                $("#screen_layout option[value='channel']").hide();
                $("#screen_layout option[value='big_landscape']").show();
                $("#screen_layout option[value='big_portrait']").show();
                $("#screen_layout option[value='index_landscape']").hide();
                $("#screen_layout option[value='index_portrait']").hide();

                $("#type_id").children().removeAttr("selected");
                $("#type_id option[data-type=1]").hide();
                $("#type_id option[data-type=2]").hide();
                $("#type_id option[data-type=5]").hide();
                $("#type_id option[data-type=6]").hide();
                $("#type_id option[data-type=7]").hide();
            } else {

                $(".sub_video_type_drop").hide();
                $(".type_drop").hide();
                $(".category_drop").hide();
                $(".language_drop").hide();
                $(".channel_drop").hide();
                $(".screen_layout_drop").hide();
                $(".no_of_content_drop").hide();
                $(".order_by_upload_drop").hide();
                $(".order_by_like_drop").hide();
                $(".order_by_view_drop").hide();
                $(".premium_video_drop").hide();
                $(".rent_video_drop").hide();
                $(".view_all_drop").hide();
            }
        });
        // Sub Video_Type 
        $("#sub_video_type").change(function() {

            var sub_video_type = $(this).children("option:selected").val();
            
            $(".premium_video_drop").hide();
            if(sub_video_type == 1){
                $(".premium_video_drop").show();
            }
        });

        // Save Section
        function save_section(){
            var Check_Admin = '<?php echo Check_Admin_Access(); ?>';
            if(Check_Admin == 1){

                var formData = new FormData($("#save_content_section")[0]);
                formData.append('is_home_screen', is_home_screen);
                formData.append('top_type_id', top_type_id);
                formData.append('top_type_type', top_type_type);

                $("#dvloader").show();
                $.ajax({
                    type:'POST',
                    url:'{{ route("section.store") }}',
                    data:formData,
                    cache:false,
                    contentType: false,
                    processData: false,
                    success:function(resp){
                        $("#dvloader").hide();
                        get_responce_message(resp, 'save_content_section', '{{ route("section.index") }}');
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

        // List Section
        if(is_home_screen == 1) {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'POST',
                url: '{{ route("section.content.data") }}',
                data: {
                    is_home_screen: is_home_screen,
                    top_type_id: 0,
                },
                success: function(resp) {
                    $('.after-add-more').html('');
                    for (var i = 0; i < resp.result.length; i++) {

                        if (resp.result[i].video_type == 1) {
                            var video_type = "{{__('label.video')}}";
                        } else if (resp.result[i].video_type == 2) {
                            var video_type = "{{__('label.tv_show')}}";
                        } else if (resp.result[i].video_type == 3) {
                            var video_type = "{{__('label.category')}}";
                        } else if (resp.result[i].video_type == 4) {
                            var video_type = "{{__('label.language')}}";
                        } else if (resp.result[i].video_type == 5) {
                            var video_type = "{{__('label.channel_list')}}";
                        } else if (resp.result[i].video_type == 6) {
                            var video_type = "{{__('label.upcoming_content')}}";
                        } else if (resp.result[i].video_type == 7) {
                            var video_type = "{{__('label.channel_content')}}";
                        } else if (resp.result[i].video_type == 8) {
                            var video_type = "{{__('label.continue_watching')}}";
                        } else if (resp.result[i].video_type == 9) {
                            var video_type = "{{__('label.kids_content')}}";
                        } else {
                            var video_type = "-";
                        }

                        if (resp.result[i].screen_layout == "landscape") {
                            var screen_layout = "{{__('label.landscape')}}";
                        } else if (resp.result[i].screen_layout == "portrait") {
                            var screen_layout = "{{__('label.portrait')}}";
                        } else if (resp.result[i].screen_layout == "square") {
                            var screen_layout = "{{__('label.square')}}";
                        } else if (resp.result[i].screen_layout == "category") {
                            var screen_layout = "{{__('label.category')}}";
                        } else if (resp.result[i].screen_layout == "language") {
                            var screen_layout = "{{__('label.language')}}";
                        } else if (resp.result[i].screen_layout == "channel") {
                            var screen_layout = "{{__('label.channel')}}";
                        } else if (resp.result[i].screen_layout == "big_landscape") {
                            var screen_layout = "{{__('label.big_landscape')}}";
                        } else if (resp.result[i].screen_layout == "big_portrait") {
                            var screen_layout = "{{__('label.big_portrait')}}";
                        } else if (resp.result[i].screen_layout == "index_landscape") {
                            var screen_layout = "{{__('label.index_landscape')}}";
                        } else if (resp.result[i].screen_layout == "index_portrait") {
                            var screen_layout = "{{__('label.index_portrait')}}";
                        } else {
                            var screen_layout = "-";
                        }

                        var data = '<div class="card custom-border-card mt-3">'+
                                '<div class="card-header d-flex justify-content-between">'+
                                    '<h5>{{__("label.edit_section")}}</h5>';
                                    if(resp.result[i].status == 1){
                                        data += '<button class="btn" id="'+resp.result[i].id+'" onclick="change_status('+resp.result[i].id+')" style="background:#058f00; font-weight:bold; border: none; color: white;">{{__("label.show")}}</button>';
                                    } else {
                                        data += '<button class="btn" id="'+resp.result[i].id+'" onclick="change_status('+resp.result[i].id+')" style="background:#e3000b; font-weight:bold; border: none; color: white;">{{__("label.hide")}}</button>';
                                    }
                                data += '</div>'+
                                '<div class="card-body">'+
                                    '<div class="form-row">'+
                                        '<div class="col-md-3">'+
                                            '<div class="form-group">'+
                                                '<label>{{__("label.title")}}</label>'+
                                                '<input type="text" value="'+resp.result[i].title+'" class="form-control" readonly>'+
                                            '</div>'+
                                        '</div>'+
                                        '<div class="col-md-3">'+
                                            '<div class="form-group">'+
                                                '<label>{{__("label.short_title")}}</label>'+
                                                '<input type="text" value="'+resp.result[i].short_title+'" class="form-control" readonly>'+
                                            '</div>'+
                                        '</div>'+
                                        '<div class="col-md-3">'+
                                            '<div class="form-group">'+
                                                '<label>{{__("label.video_type")}}</label>'+
                                                '<input type="text" value="'+video_type+'" class="form-control" readonly>'+
                                            '</div>'+
                                        '</div>'+
                                        '<div class="col-md-3">'+
                                            '<div class="form-group">'+
                                                '<label>{{__("label.screen_layout")}}</label>'+
                                                '<input type="text" value="'+screen_layout+'" class="form-control" readonly>'+
                                            '</div>'+
                                        '</div>'+
                                    '</div>'+
                                    '<div class="border-top pt-3 text-right">'+
                                        '<button type="button" data-toggle="modal" data-target="#exampleModal" class="btn btn-default mw-120" onclick="edit_section('+resp.result[i].id+')">{{__("label.update")}}</button>'+
                                        '<button type="button" class="btn btn-cancel mw-120 ml-2" onclick="delete_section('+resp.result[i].id+')">{{__("label.delete")}}</button>'+
                                    '</div>'+
                                '</div>'+
                            '</div>';

                        $('.after-add-more').append(data);
                    }
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    toastr.error(errorThrown, textStatus);
                }
            });
        }
        function Top_Content(is_home_screen, top_type_id, type_type) {

            document.getElementById("save_content_section").reset();
            $("#category_id").val(0).trigger("change"); 
            $("#language_id").val(0).trigger("change");
            $("#channel_id").val(0).trigger("change");

            if(is_home_screen == 1){

                $(".sub_video_type_drop").hide();
                $(".type_drop").hide();
                $(".category_drop").hide();
                $(".language_drop").hide();
                $(".channel_drop").hide();
                $(".screen_layout_drop").hide();
                $(".no_of_content_drop").hide();
                $(".order_by_upload_drop").hide();
                $(".order_by_like_drop").hide();
                $(".order_by_view_drop").hide();
                $(".premium_video_drop").hide();
                $(".rent_video_drop").hide();
                $(".view_all_drop").hide();

                $(".video_type_drop").show();
                $("#video_type").children().removeAttr("selected");
                $("#video_type option[value='1']").show();
                $("#video_type option[value='2']").show();
                $("#video_type option[value='3']").show();
                $("#video_type option[value='4']").show();
                $("#video_type option[value='5']").show();
                $("#video_type option[value='6']").show();
                $("#video_type option[value='7']").show();
                $("#video_type option[value='8']").show();
                $("#video_type option[value='9']").show();

            } else if(is_home_screen == 2){

                $(".video_type_drop").hide();
                if(type_type == 5 || type_type == 6 || type_type == 7){
                    $(".sub_video_type_drop").show();
                    $(".premium_video_drop").hide();
                } else {
                    $(".sub_video_type_drop").hide();
                    $(".premium_video_drop").show();
                }
                $(".type_drop").hide();
                $(".category_drop").show();
                $(".language_drop").show();
                if(type_type == 6){
                    $(".channel_drop").show();
                } else {
                    $(".channel_drop").hide();
                }
                $(".screen_layout_drop").show();
                $(".no_of_content_drop").show();
                $(".order_by_upload_drop").show();
                $(".order_by_like_drop").show();
                $(".order_by_view_drop").show();
                $(".rent_video_drop").show();
                $(".view_all_drop").show();

                $("#screen_layout").children().removeAttr("selected");
                $("#screen_layout option[value='landscape']").show();
                $("#screen_layout option[value='portrait']").show();
                $("#screen_layout option[value='square']").show();
                $("#screen_layout option[value='category']").hide();
                $("#screen_layout option[value='language']").hide();
                $("#screen_layout option[value='channel']").hide();
                $("#screen_layout option[value='big_landscape']").show();
                $("#screen_layout option[value='big_portrait']").show();
                $("#screen_layout option[value='index_landscape']").show();
                $("#screen_layout option[value='index_portrait']").show();
            }

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'POST',
                url: '{{ route("section.content.data") }}',
                data: {
                    is_home_screen: is_home_screen,
                    top_type_id: top_type_id,
                },
                success: function(resp) {
                    $('.after-add-more').html('');
                    for (var i = 0; i < resp.result.length; i++) {

                        if (resp.result[i].video_type == 1) {
                            var video_type = "{{__('label.video')}}";
                        } else if (resp.result[i].video_type == 2) {
                            var video_type = "{{__('label.tv_show')}}";
                        } else if (resp.result[i].video_type == 3) {
                            var video_type = "{{__('label.category')}}";
                        } else if (resp.result[i].video_type == 4) {
                            var video_type = "{{__('label.language')}}";
                        } else if (resp.result[i].video_type == 5) {
                            var video_type = "{{__('label.channel_list')}}";
                        } else if (resp.result[i].video_type == 6) {
                            var video_type = "{{__('label.upcoming_content')}}";
                        } else if (resp.result[i].video_type == 7) {
                            var video_type = "{{__('label.channel_content')}}";
                        } else if (resp.result[i].video_type == 8) {
                            var video_type = "{{__('label.continue_watching')}}";
                        } else if (resp.result[i].video_type == 9) {
                            var video_type = "{{__('label.kids_content')}}";
                        } else {
                            var video_type = "-";
                        }

                        if (resp.result[i].screen_layout == "landscape") {
                            var screen_layout = "{{__('label.landscape')}}";
                        } else if (resp.result[i].screen_layout == "portrait") {
                            var screen_layout = "{{__('label.portrait')}}";
                        } else if (resp.result[i].screen_layout == "square") {
                            var screen_layout = "{{__('label.square')}}";
                        } else if (resp.result[i].screen_layout == "category") {
                            var screen_layout = "{{__('label.category')}}";
                        } else if (resp.result[i].screen_layout == "language") {
                            var screen_layout = "{{__('label.language')}}";
                        } else if (resp.result[i].screen_layout == "channel") {
                            var screen_layout = "{{__('label.channel')}}";
                        } else if (resp.result[i].screen_layout == "big_landscape") {
                            var screen_layout = "{{__('label.big_landscape')}}";
                        } else if (resp.result[i].screen_layout == "big_portrait") {
                            var screen_layout = "{{__('label.big_portrait')}}";
                        } else if (resp.result[i].screen_layout == "index_landscape") {
                            var screen_layout = "{{__('label.index_landscape')}}";
                        } else if (resp.result[i].screen_layout == "index_portrait") {
                            var screen_layout = "{{__('label.index_portrait')}}";
                        } else {
                            var screen_layout = "-";
                        }

                        var data = '<div class="card custom-border-card mt-3">'+
                                '<div class="card-header d-flex justify-content-between">'+
                                    '<h5>{{__("label.edit_section")}}</h5>';
                                    if(resp.result[i].status == 1){
                                        data += '<button class="btn" id="'+resp.result[i].id+'" onclick="change_status('+resp.result[i].id+')" style="background:#058f00; font-weight:bold; border: none; color: white;">{{__("label.show")}}</button>';
                                    } else {
                                        data += '<button class="btn" id="'+resp.result[i].id+'" onclick="change_status('+resp.result[i].id+')" style="background:#e3000b; font-weight:bold; border: none; color: white;">{{__("label.hide")}}</button>';
                                    }
                                data += '</div>'+
                                '<div class="card-body">'+
                                    '<div class="form-row">'+
                                        '<div class="col-md-3">'+
                                            '<div class="form-group">'+
                                                '<label>{{__("label.title")}}</label>'+
                                                '<input type="text" value="'+resp.result[i].title+'" class="form-control" readonly>'+
                                            '</div>'+
                                        '</div>'+
                                        '<div class="col-md-3">'+
                                            '<div class="form-group">'+
                                                '<label>{{__("label.short_title")}}</label>'+
                                                '<input type="text" value="'+resp.result[i].short_title+'" class="form-control" readonly>'+
                                            '</div>'+
                                        '</div>'+
                                        '<div class="col-md-3">'+
                                            '<div class="form-group">'+
                                                '<label>{{__("label.video_type")}}</label>'+
                                                '<input type="text" value="'+video_type+'" class="form-control" readonly>'+
                                            '</div>'+
                                        '</div>'+
                                        '<div class="col-md-3">'+
                                            '<div class="form-group">'+
                                                '<label>{{__("label.screen_layout")}}</label>'+
                                                '<input type="text" value="'+screen_layout+'" class="form-control" readonly>'+
                                            '</div>'+
                                        '</div>'+
                                    '</div>'+
                                    '<div class="border-top pt-3 text-right">'+
                                        '<button type="button" data-toggle="modal" data-target="#exampleModal" class="btn btn-default mw-120" onclick="edit_section('+resp.result[i].id+')">{{__("label.update")}}</button>'+
                                        '<button type="button" class="btn btn-cancel mw-120 ml-2" onclick="delete_section('+resp.result[i].id+')">{{__("label.delete")}}</button>'+
                                    '</div>'+
                                '</div>'+
                            '</div>';

                        $('.after-add-more').append(data);
                    }
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    toastr.error(errorThrown, textStatus);
                }
            });
        };

        // Update Section
        function edit_section(id){

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'POST',
                url: '{{ route("section.content.edit") }}',
                data: {
                    id: id,
                },
                success: function(resp) {

                    if(resp.result != null){

                        $("#edit_id").val(resp.result.id);
                        $("#edit_is_home_screen").val(resp.result.is_home_screen);
                        $("#edit_title").val(resp.result.title);
                        $("#edit_short_title").val(resp.result.short_title);
                        $("#edit_video_type").val(resp.result.video_type).attr("selected","selected");
                        $("#edit_sub_video_type").val(resp.result.sub_video_type).attr("selected","selected");
                        $("#edit_type_id").val(resp.result.type_id).attr("selected","selected");
                        $('#edit_category_id').val(resp.result.category_id).trigger('change');
                        $('#edit_language_id').val(resp.result.language_id).trigger('change');
                        $('#edit_channel_id').val(resp.result.channel_id).trigger('change');
                        $("#edit_screen_layout").val(resp.result.screen_layout).attr("selected","selected");
                        $("#edit_no_of_content").val(resp.result.no_of_content);
                        if(resp.result.order_by_upload == 1){
                            $("#edit_order_by_upload_no").prop('checked', false);
                            $("#edit_order_by_upload_yes").prop('checked', true);
                        } else if(resp.result.order_by_upload == 2) {
                            $("#edit_order_by_upload_yes").prop('checked', false);
                            $("#edit_order_by_upload_no").prop('checked', true);
                        }
                        if(resp.result.order_by_like == 1){
                            $("#edit_order_by_like_no").prop('checked', false);
                            $("#edit_order_by_like_yes").prop('checked', true);
                        } else {
                            $("#edit_order_by_like_yes").prop('checked', false);
                            $("#edit_order_by_like_no").prop('checked', true);
                        }
                        if(resp.result.order_by_view == 1){
                            $("#edit_order_by_view_no").prop('checked', false);
                            $("#edit_order_by_view_yes").prop('checked', true);
                        } else {
                            $("#edit_order_by_view_yes").prop('checked', false);
                            $("#edit_order_by_view_no").prop('checked', true);
                        }
                        if(resp.result.premium_video == 1){
                            $("#edit_premium_video_no").prop('checked', false);
                            $("#edit_premium_video_yes").prop('checked', true);
                        } else {
                            $("#edit_premium_video_yes").prop('checked', false);
                            $("#edit_premium_video_no").prop('checked', true);
                        }
                        if(resp.result.rent_video == 1){
                            $("#edit_rent_video_no").prop('checked', false);
                            $("#edit_rent_video_yes").prop('checked', true);
                        } else {
                            $("#edit_rent_video_yes").prop('checked', false);
                            $("#edit_rent_video_no").prop('checked', true);
                        }
                        if(resp.result.view_all == 1){
                            $("#edit_view_all_no").prop('checked', false);
                            $("#edit_view_all_yes").prop('checked', true);
                        } else {
                            $("#edit_view_all_yes").prop('checked', false);
                            $("#edit_view_all_no").prop('checked', true);
                        }

                        // Video_Type
                        if(resp.result.is_home_screen == 1){

                            $(".edit_video_type_drop").show();
                            $(".edit_video_type_drop option[value='1']").show();
                            $(".edit_video_type_drop option[value='2']").show();
                            $(".edit_video_type_drop option[value='3']").show();
                            $(".edit_video_type_drop option[value='4']").show();
                            $(".edit_video_type_drop option[value='5']").show();
                            $(".edit_video_type_drop option[value='6']").show();
                            $(".edit_video_type_drop option[value='7']").show();
                            $(".edit_video_type_drop option[value='8']").show();
                            $(".edit_video_type_drop option[value='9']").show();

                            if(resp.result.video_type == 1 || resp.result.video_type == 2){

                                $(".edit_sub_video_type_drop").hide();
                                $(".edit_type_drop").show();
                                $(".edit_category_drop").show();
                                $(".edit_language_drop").show();
                                $(".edit_channel_drop").hide();
                                $(".edit_screen_layout_drop").show();
                                $(".edit_no_of_content_drop").show();
                                $(".edit_order_by_upload_drop").show();
                                $(".edit_order_by_like_drop").show();
                                $(".edit_order_by_view_drop").show();
                                $(".edit_premium_video_drop").show();
                                $(".edit_rent_video_drop").show();
                                $(".edit_view_all_drop").show();

                                $("#edit_screen_layout option[value='landscape']").show();
                                $("#edit_screen_layout option[value='portrait']").show();
                                $("#edit_screen_layout option[value='square']").show();
                                $("#edit_screen_layout option[value='category']").hide();
                                $("#edit_screen_layout option[value='language']").hide();
                                $("#edit_screen_layout option[value='channel']").hide();
                                $("#edit_screen_layout option[value='big_landscape']").show();
                                $("#edit_screen_layout option[value='big_portrait']").show();
                                $("#edit_screen_layout option[value='index_landscape']").show();
                                $("#edit_screen_layout option[value='index_portrait']").show();

                                if(resp.result.video_type == 1){
                                    $("#edit_type_id option[data-type=1]").show();
                                    $("#edit_type_id option[data-type=2]").hide();
                                } else {
                                    $("#edit_type_id option[data-type=1]").hide();
                                    $("#edit_type_id option[data-type=2]").show();
                                }
                                $("#edit_type_id option[data-type=5]").hide();
                                $("#edit_type_id option[data-type=6]").hide();
                                $("#edit_type_id option[data-type=7]").hide();

                            } else if(resp.result.video_type == 3 || resp.result.video_type == 4 || resp.result.video_type == 5){

                                $(".edit_sub_video_type_drop").hide();
                                $(".edit_type_drop").hide();
                                $(".edit_category_drop").hide();
                                $(".edit_language_drop").hide();
                                $(".edit_channel_drop").hide();
                                $(".edit_screen_layout_drop").show();
                                $(".edit_no_of_content_drop").show();
                                $(".edit_order_by_upload_drop").hide();
                                $(".edit_order_by_like_drop").hide();
                                $(".edit_order_by_view_drop").hide();
                                $(".edit_premium_video_drop").hide();
                                $(".edit_rent_video_drop").hide();
                                $(".edit_view_all_drop").show();

                                $("#edit_screen_layout option[value='landscape']").hide();
                                $("#edit_screen_layout option[value='portrait']").hide();
                                $("#edit_screen_layout option[value='square']").hide();
                                if(resp.result.video_type == 3){
                                    $("#edit_screen_layout option[value='category']").show();
                                    $("#edit_screen_layout option[value='language']").hide();
                                    $("#edit_screen_layout option[value='channel']").hide();
                                } else if(resp.result.video_type == 4){
                                    $("#edit_screen_layout option[value='category']").hide();
                                    $("#edit_screen_layout option[value='language']").show();
                                    $("#edit_screen_layout option[value='channel']").hide();
                                } else {
                                    $("#edit_screen_layout option[value='category']").hide();
                                    $("#edit_screen_layout option[value='language']").hide();
                                    $("#edit_screen_layout option[value='channel']").show();
                                }
                                $("#edit_screen_layout option[value='big_landscape']").hide();
                                $("#edit_screen_layout option[value='big_portrait']").hide();
                                $("#edit_screen_layout option[value='index_landscape']").hide();
                                $("#edit_screen_layout option[value='index_portrait']").hide();
                        
                            } else if(resp.result.video_type == 6 || resp.result.video_type == 7 || resp.result.video_type == 9){

                                $(".edit_sub_video_type_drop").show();
                                $(".edit_type_drop").show();
                                $(".edit_category_drop").show();
                                $(".edit_language_drop").show();
                                if(resp.result.video_type == 6 || resp.result.video_type == 9){
                                    $(".edit_channel_drop").hide();
                                } else {
                                    $(".edit_channel_drop").show();
                                }
                                $(".edit_screen_layout_drop").show();
                                $(".edit_no_of_content_drop").show();
                                $(".edit_order_by_upload_drop").show();
                                $(".edit_order_by_like_drop").show();
                                $(".edit_order_by_view_drop").show();
                                if(resp.result.sub_video_type == 1 ){
                                    $(".edit_premium_video_drop").show();
                                } else {
                                    $(".edit_premium_video_drop").hide();
                                }
                                $(".edit_rent_video_drop").show();
                                $(".edit_view_all_drop").show();

                                $("#edit_screen_layout option[value='landscape']").show();
                                $("#edit_screen_layout option[value='portrait']").show();
                                $("#edit_screen_layout option[value='square']").show();
                                $("#edit_screen_layout option[value='category']").hide();
                                $("#edit_screen_layout option[value='language']").hide();
                                $("#edit_screen_layout option[value='channel']").hide();
                                $("#edit_screen_layout option[value='big_landscape']").show();
                                $("#edit_screen_layout option[value='big_portrait']").show();
                                $("#edit_screen_layout option[value='index_landscape']").show();
                                $("#edit_screen_layout option[value='index_portrait']").show();

                                $("#edit_type_id option[data-type=1]").hide();
                                $("#edit_type_id option[data-type=2]").hide();
                                if(resp.result.video_type == 6){
                                    $("#edit_type_id option[data-type=5]").show();
                                    $("#edit_type_id option[data-type=6]").hide();
                                    $("#edit_type_id option[data-type=7]").hide();
                                } else if(resp.result.video_type == 7) {
                                    $("#edit_type_id option[data-type=5]").hide();
                                    $("#edit_type_id option[data-type=6]").show();
                                    $("#edit_type_id option[data-type=7]").hide();
                                } else if(resp.result.video_type == 9) {
                                    $("#edit_type_id option[data-type=5]").hide();
                                    $("#edit_type_id option[data-type=6]").hide();
                                    $("#edit_type_id option[data-type=7]").show();
                                }
                            } else if(resp.result.video_type == 8){

                                $(".edit_sub_video_type_drop").hide();
                                $(".edit_type_drop").hide();
                                $(".edit_category_drop").hide();
                                $(".edit_language_drop").hide();
                                $(".edit_channel_drop").hide();
                                $(".edit_screen_layout_drop").show();
                                $(".edit_no_of_content_drop").hide();
                                $(".edit_order_by_upload_drop").hide();
                                $(".edit_order_by_like_drop").hide();
                                $(".edit_order_by_view_drop").hide();
                                $(".edit_premium_video_drop").hide();
                                $(".edit_rent_video_drop").hide();
                                $(".edit_view_all_drop").hide();

                                $("#edit_screen_layout option[value='landscape']").show();
                                $("#edit_screen_layout option[value='portrait']").show();
                                $("#edit_screen_layout option[value='square']").show();
                                $("#edit_screen_layout option[value='category']").hide();
                                $("#edit_screen_layout option[value='language']").hide();
                                $("#edit_screen_layout option[value='channel']").hide();
                                $("#edit_screen_layout option[value='big_landscape']").show();
                                $("#edit_screen_layout option[value='big_portrait']").show();
                                $("#edit_screen_layout option[value='index_landscape']").hide();
                                $("#edit_screen_layout option[value='index_portrait']").hide();

                            } else {

                                $(".edit_sub_video_type_drop").hide();
                                $(".edit_type_drop").hide();
                                $(".edit_category_drop").hide();
                                $(".edit_language_drop").hide();
                                $(".edit_channel_drop").hide();
                                $(".edit_screen_layout_drop").hide();
                                $(".edit_no_of_content_drop").hide();
                                $(".edit_order_by_upload_drop").hide();
                                $(".edit_order_by_like_drop").hide();
                                $(".edit_order_by_view_drop").hide();
                                $(".edit_premium_video_drop").hide();
                                $(".edit_rent_video_drop").hide();
                                $(".edit_view_all_drop").hide();
                            }

                        } else if(resp.result.is_home_screen == 2){

                            $(".edit_video_type_drop").hide();
                            if(resp.result.video_type == 6 || resp.result.video_type == 7 || resp.result.video_type == 9){
                                $(".edit_sub_video_type_drop").show();
                            } else {
                                $(".edit_sub_video_type_drop").hide();
                            }
                            $(".edit_type_drop").hide();
                            $(".edit_category_drop").show();
                            $(".edit_language_drop").show();
                            if(resp.result.video_type == 7){
                                $(".edit_channel_drop").show();
                            } else {
                                $(".edit_channel_drop").hide();
                            }
                            $(".edit_screen_layout_drop").show();
                            $(".edit_no_of_content_drop").show();
                            $(".edit_order_by_upload_drop").show();
                            $(".edit_order_by_like_drop").show();
                            $(".edit_order_by_view_drop").show();
                            $(".edit_premium_video_drop").show();
                            $(".edit_rent_video_drop").show();
                            $(".edit_view_all_drop").show();

                            $("#edit_screen_layout option[value='landscape']").show();
                            $("#edit_screen_layout option[value='portrait']").show();
                            $("#edit_screen_layout option[value='square']").show();
                            $("#edit_screen_layout option[value='category']").hide();
                            $("#edit_screen_layout option[value='language']").hide();
                            $("#edit_screen_layout option[value='channel']").hide();
                            $("#edit_screen_layout option[value='big_landscape']").show();
                            $("#edit_screen_layout option[value='big_portrait']").show();
                            $("#edit_screen_layout option[value='index_landscape']").show();
                            $("#edit_screen_layout option[value='index_portrait']").show();

                        } else {
                            $(".edit_video_type_drop").hide();
                        }

                        // Video_Type 
                        $("#edit_video_type").change(function() {

                            var video_type = $(this).children("option:selected").val();
                            if(video_type == 1 || video_type == 2){

                                $(".edit_sub_video_type_drop").hide();
                                $(".edit_type_drop").show();
                                $(".edit_category_drop").show();
                                $(".edit_language_drop").show();
                                $(".edit_channel_drop").hide();
                                $(".edit_screen_layout_drop").show();
                                $(".edit_no_of_content_drop").show();
                                $(".edit_order_by_upload_drop").show();
                                $(".edit_order_by_like_drop").show();
                                $(".edit_order_by_view_drop").show();
                                if(video_type == 1){
                                    $(".edit_premium_video_drop").show();
                                } else {
                                    $(".edit_premium_video_drop").hide();
                                }
                                $(".edit_rent_video_drop").show();
                                $(".edit_view_all_drop").show();

                                $("#edit_screen_layout").children().removeAttr("selected");
                                $("#edit_screen_layout option[value='landscape']").show();
                                $("#edit_screen_layout option[value='portrait']").show();
                                $("#edit_screen_layout option[value='square']").show();
                                $("#edit_screen_layout option[value='category']").hide();
                                $("#edit_screen_layout option[value='language']").hide();
                                $("#edit_screen_layout option[value='channel']").hide();
                                $("#edit_screen_layout option[value='big_landscape']").show();
                                $("#edit_screen_layout option[value='big_portrait']").show();
                                $("#edit_screen_layout option[value='index_landscape']").show();
                                $("#edit_screen_layout option[value='index_portrait']").show();

                                $("#edit_type_id").children().removeAttr("selected");
                                $("#edit_type_id option:first").attr('selected','selected');
                                if(video_type == 1){
                                    $("#edit_type_id option[data-type=1]").show();
                                    $("#edit_type_id option[data-type=2]").hide();
                                } else {
                                    $("#edit_type_id option[data-type=1]").hide();
                                    $("#edit_type_id option[data-type=2]").show();
                                }
                                $("#edit_type_id option[data-type=5]").hide();
                                $("#edit_type_id option[data-type=6]").hide();
                                $("#edit_type_id option[data-type=7]").hide();

                            } else if(video_type == 3 || video_type == 4 || video_type == 5){

                                $(".edit_sub_video_type_drop").hide();
                                $(".edit_type_drop").hide();
                                $(".edit_category_drop").hide();
                                $(".edit_language_drop").hide();
                                $(".edit_channel_drop").hide();
                                $(".edit_screen_layout_drop").show();
                                $(".edit_no_of_content_drop").show();
                                $(".edit_order_by_upload_drop").hide();
                                $(".edit_order_by_like_drop").hide();
                                $(".edit_order_by_view_drop").hide();
                                $(".edit_premium_video_drop").hide();
                                $(".edit_rent_video_drop").hide();
                                $(".edit_view_all_drop").show();

                                $("#edit_screen_layout").children().removeAttr("selected");
                                $("#edit_screen_layout option[value='landscape']").hide();
                                $("#edit_screen_layout option[value='portrait']").hide();
                                $("#edit_screen_layout option[value='square']").hide();
                                if(video_type == 3){
                                    $("#edit_screen_layout option[value='category']").show();
                                    $("#edit_screen_layout option[value='language']").hide();
                                    $("#edit_screen_layout option[value='channel']").hide();
                                } else if(video_type == 4){
                                    $("#edit_screen_layout option[value='category']").hide();
                                    $("#edit_screen_layout option[value='language']").show();
                                    $("#edit_screen_layout option[value='channel']").hide();
                                } else {
                                    $("#edit_screen_layout option[value='category']").hide();
                                    $("#edit_screen_layout option[value='language']").hide();                    
                                    $("#edit_screen_layout option[value='channel']").show();
                                }
                                $("#edit_screen_layout option[value='big_landscape']").hide();
                                $("#edit_screen_layout option[value='big_portrait']").hide();
                                $("#edit_screen_layout option[value='index_landscape']").hide();
                                $("#edit_screen_layout option[value='index_portrait']").hide();

                                $("#edit_type_id").children().removeAttr("selected");
                                $("#edit_type_id option:first").attr('selected','selected');
                                $("#edit_type_id option[data-type=1]").hide();
                                $("#edit_type_id option[data-type=2]").hide();
                                $("#edit_type_id option[data-type=5]").hide();
                                $("#edit_type_id option[data-type=6]").hide();
                                $("#edit_type_id option[data-type=7]").hide();

                            } else if(video_type == 6 || video_type == 7 || video_type == 9){

                                $(".edit_sub_video_type_drop").show();
                                $("#edit_sub_video_type").children().removeAttr("selected");
                                $("#edit_sub_video_type option:first").attr('selected','selected');
                                $(".edit_type_drop").show();
                                $(".edit_category_drop").show();
                                $(".edit_language_drop").show();
                                if(video_type == 6 || video_type == 9){
                                    $(".edit_channel_drop").hide();
                                } else {
                                    $(".edit_channel_drop").show();
                                }
                                $(".edit_screen_layout_drop").show();
                                $(".edit_no_of_content_drop").show();
                                $(".edit_order_by_upload_drop").show();
                                $(".edit_order_by_like_drop").show();
                                $(".edit_order_by_view_drop").show();
                                $(".edit_premium_video_drop").hide();
                                $(".edit_rent_video_drop").show();
                                $(".edit_view_all_drop").show();

                                $("#edit_screen_layout").children().removeAttr("selected");
                                $("#edit_screen_layout option[value='landscape']").show();
                                $("#edit_screen_layout option[value='portrait']").show();
                                $("#edit_screen_layout option[value='square']").show();
                                $("#edit_screen_layout option[value='category']").hide();
                                $("#edit_screen_layout option[value='language']").hide();
                                $("#edit_screen_layout option[value='channel']").hide();
                                $("#edit_screen_layout option[value='big_landscape']").show();
                                $("#edit_screen_layout option[value='big_portrait']").show();
                                $("#edit_screen_layout option[value='index_landscape']").show();
                                $("#edit_screen_layout option[value='index_portrait']").show();

                                $("#edit_type_id").children().removeAttr("selected");
                                $("#edit_type_id option:first").attr('selected','selected');
                                $("#edit_type_id option[data-type=1]").hide();
                                $("#edit_type_id option[data-type=2]").hide();
                                if(video_type == 6){
                                    $("#edit_type_id option[data-type=5]").show();
                                    $("#edit_type_id option[data-type=6]").hide();
                                    $("#edit_type_id option[data-type=7]").hide();
                                } else if(video_type == 7){
                                    $("#edit_type_id option[data-type=5]").hide();
                                    $("#edit_type_id option[data-type=6]").show();
                                    $("#edit_type_id option[data-type=7]").hide();
                                } else if(video_type == 9){
                                    $("#edit_type_id option[data-type=5]").hide();
                                    $("#edit_type_id option[data-type=6]").hide();
                                    $("#edit_type_id option[data-type=7]").show();
                                }
                            } else if(video_type == 8){

                                $(".edit_sub_video_type_drop").hide();
                                $(".edit_type_drop").hide();
                                $(".edit_category_drop").hide();
                                $(".edit_language_drop").hide();
                                $(".edit_channel_drop").hide();
                                $(".edit_screen_layout_drop").show();
                                $(".edit_no_of_content_drop").hide();
                                $(".edit_order_by_upload_drop").hide();
                                $(".edit_order_by_like_drop").hide();
                                $(".edit_order_by_view_drop").hide();
                                $(".edit_premium_video_drop").hide();
                                $(".edit_rent_video_drop").hide();
                                $(".edit_view_all_drop").hide();

                                $("#edit_screen_layout").children().removeAttr("selected");
                                $("#edit_screen_layout option[value='landscape']").show();
                                $("#edit_screen_layout option[value='portrait']").show();
                                $("#edit_screen_layout option[value='square']").show();
                                $("#edit_screen_layout option[value='category']").hide();
                                $("#edit_screen_layout option[value='language']").hide();
                                $("#edit_screen_layout option[value='channel']").hide();
                                $("#edit_screen_layout option[value='big_landscape']").show();
                                $("#edit_screen_layout option[value='big_portrait']").show();
                                $("#edit_screen_layout option[value='index_landscape']").hide();
                                $("#edit_screen_layout option[value='index_portrait']").hide();

                                $("#edit_type_id").children().removeAttr("selected");
                                $("#edit_type_id option:first").attr('selected','selected');
                                $("#edit_type_id option[data-type=1]").hide();
                                $("#edit_type_id option[data-type=2]").hide();
                                $("#edit_type_id option[data-type=5]").hide();
                                $("#edit_type_id option[data-type=6]").hide();
                                $("#edit_type_id option[data-type=7]").hide();
                            } else {

                                $(".edit_sub_video_type_drop").hide();
                                $(".edit_type_drop").hide();
                                $(".edit_category_drop").hide();
                                $(".edit_language_drop").hide();
                                $(".edit_channel_drop").hide();
                                $(".edit_screen_layout_drop").hide();
                                $(".edit_no_of_content_drop").hide();
                                $(".edit_order_by_upload_drop").hide();
                                $(".edit_order_by_like_drop").hide();
                                $(".edit_order_by_view_drop").hide();
                                $(".edit_premium_video_drop").hide();
                                $(".edit_rent_video_drop").hide();
                                $(".edit_view_all_drop").hide();
                            }
                        });
                    }
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    toastr.error(errorThrown, textStatus);
                }
            });
        }
        $("#edit_sub_video_type").change(function() {

            var sub_video_type = $(this).children("option:selected").val();
            $(".edit_premium_video_drop").hide();
            if(sub_video_type == 1){
                $(".edit_premium_video_drop").show();
            }
        });
        function update_section(){

            var Check_Admin = '<?php echo Check_Admin_Access(); ?>';
            if(Check_Admin == 1){

                $("#dvloader").show();
                var id = $('#edit_id').val();
                var formData = new FormData($("#edit_content_section")[0]);

                var url = '{{ route("section.update", ":id") }}';
                    url = url.replace(':id', id);

                $.ajax({
                    headers: {
					    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				    },
				    enctype: 'multipart/form-data',
                    type: 'POST',
                    url: url,
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function(resp) {

                        $("#dvloader").hide();
                        if(resp.status == 200){
                            $('#exampleModal').modal('toggle');
                        }
                        get_responce_message(resp, 'edit_content_section', '{{ route("section.index") }}');
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

        // Delete Section
        function delete_section(id){

            var Check_Admin = '<?php echo Check_Admin_Access(); ?>';
            if(Check_Admin == 1){

                var result = confirm('{{__("label.delete_section")}}');
                if(result){

                    $("#dvloader").show();
    
                    var url = '{{ route("section.show", ":id") }}';
                        url = url.replace(':id', id);
    
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        type: 'GET',
                        url: url,
                        cache: false,
                        contentType: false,
                        processData: false,
                        success: function(resp) {
                            $("#dvloader").hide();
                            get_responce_message(resp, '', '{{ route("section.index") }}');
                        },
                        error: function(XMLHttpRequest, textStatus, errorThrown) {
                            $("#dvloader").hide();
                            toastr.error(errorThrown, textStatus);
                        }
                    });
                }
            } else {
                toastr.error('{{__("label.you_have_no_right_to_add_edit_and_delete")}}');
            }
        }

        // Sortable Section
        $("#imageListId").sortable({
            update: function(event, ui) {
                getIdsOfImages();
            } //end update
        });
        function getIdsOfImages() {
            var values = [];
            $('.listitemClass').each(function(index) {
                values.push($(this).attr("id")
                    .replace("imageNo", ""));
            });
            $('#outputvalues').val(values);
        }
        function sortableBTN(){
            var tab = $("ul.tabs li a.active");
            var is_home_screen = tab.data("is_home_screen");
            var top_type_id = tab.data("id");

            $("#dvloader").show();
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'POST',
                url: '{{ route("section.content.sortable") }}',
                data: {
                    is_home_screen: is_home_screen,
                    top_type_id: top_type_id,
                },
                success: function(resp) {
                    $("#dvloader").hide();

                    $('#imageListId').html('');
                    for (var i = 0; i < resp.result.length; i++) {

                        var data = '<div id="'+ resp.result[i].id+'" class="listitemClass mb-2" style="background-color: #e9ecef;border: 1px solid black;cursor: s-resize;">'+
                                    '<p class="m-2">'+resp.result[i].title+'</p>'+
                                '</div>';

                        $('#imageListId').append(data);
                    }
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    $("#dvloader").hide();
                    toastr.error(errorThrown, textStatus);
                }
            });
        }
        function save_section_sortable() {
            var Check_Admin = '<?php echo Check_Admin_Access(); ?>';
            if(Check_Admin == 1){
                $("#dvloader").show();
                var formData = new FormData($("#save_section_sortable")[0]);
                $.ajax({
                    type: 'POST',
                    url: '{{ route("section.content.sortable.save") }}',
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function(resp) {
                        $("#dvloader").hide();
                        get_responce_message(resp, 'save_section_sortable', '{{ route("section.index") }}');
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

        // Change Status
        function change_status(id) {

            var Check_Admin = '<?php echo Check_Admin_Access(); ?>';
            if(Check_Admin == 1){

                $("#dvloader").show();
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: "GET",
                    url: "{{route('section.status')}}",
                    data: {id: id},
                    success: function(resp) {
                        $("#dvloader").hide();
                        if (resp.status == 200) {

                            if (resp.Status == 1) {
                                $('#' + id).text('Show');
                                $('#' + id).css({
                                    "background": "#058f00",
                                    "color": "white",
                                    "font-weight": "bold",
                                    "border": "none"
                                });
                            } else {
                                $('#' + id).text('Hide');
                                $('#' + id).css({
                                    "background": "#e3000b",
                                    "color": "white",
                                    "font-weight": "bold",
                                    "border": "none"
                                });
                            }
                        } else {
                            toastr.error(resp.errors);
                        }
                    },
                    error: function(XMLHttpRequest, textStatus, errorThrown) {
                        $("#dvloader").hide();
                        toastr.error(errorThrown, textStatus);
                    }
                });
            } else {
                toastr.error('{{__("label.you_have_no_right_to_add_edit_and_delete")}}');
            }
        };
    </script>
@endsection