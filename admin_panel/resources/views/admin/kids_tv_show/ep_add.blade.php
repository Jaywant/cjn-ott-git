@extends('admin.layout.page-app')
@section('page_title', __('label.add_episode'))

@section('content')
    @include('admin.layout.sidebar')

    <div class="right-content">
        @include('admin.layout.header')

        <div class="body-content">
            <!-- mobile title -->
            <h1 class="page-title-sm">{{__('label.add_episode')}}</h1>

            <div class="border-bottom row mb-3">
                <div class="col-sm-10">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{__('label.dashboard')}}</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('kidstvshow.index') }}">{{__('label.tv_shows')}}</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('kidstvshow.episode.index', ['id' => $tvshow_id]) }}">{{__('label.episodes')}}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{__('label.add_episode')}}</li>
                    </ol>
                </div>
                <div class="col-sm-2 d-flex align-items-center justify-content-end">
                    <a href="{{ route('kidstvshow.episode.index',['id'=> $tvshow_id]) }}" class="btn btn-default mw-120" style="margin-top:-14px">{{__('label.episode_list')}}</a>
                </div>
            </div>

            <form id="save_tvshow_video" enctype="multipart/form-data">
                <input type="hidden" name="show_id" id="show_id" value="{{$tvshow_id}}">
                <div class="custom-border-card">
                    <div class="form-row">
                        <div class="col-md-8">
                            <div class="form-group">
                                <label>{{__('label.name')}}<span class="text-danger">*</span></label>
                                <input name="name" type="text" class="form-control" placeholder="{{__('label.enter_episode_name')}}" autofocus>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>{{__('label.season')}}<span class="text-danger">*</span></label>
                                <select class="form-control" name="season_id">
                                    <option value="">{{__('label.select_season')}}</option>
                                    @foreach ($season as $key => $value)
                                    <option value="{{$value->id}}">
                                        {{$value->name}}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="custom-border-card">
                    <div class="form-row">
                        <div class="form-group col-lg-4">
                            <label>{{__('label.video_upload_type')}}<span class="text-danger">*</span></label>
                            <select name="video_upload_type" id="video_upload_type" class="form-control">
                                <option selected="selected" value="server_video">{{__('label.server_video')}}</option>
                                <option value="external">{{__('label.external_url')}}</option>
                                <option value="youtube">{{__('label.youtube')}}</option>
                            </select>
                            <label class="mt-1 mb-2 text-gray">{{__('label.video_notes')}}<a href="https://commentpicker.com/youtube-video-id.php" target="_blank" class="btn-link">{{__('label.click_here')}}</a></label>
                        </div>                       
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>{{__('label.is_premium')}}<span class="text-danger">*</span></label>
                                <div class="radio-group">
                                    <div class="custom-control custom-radio">
                                        <input type="radio" name="is_premium" id="is_premium_no" class="custom-control-input" value="0" checked>
                                        <label class="custom-control-label" for="is_premium_no">{{__('label.no')}}</label>
                                    </div>
                                    <div class="custom-control custom-radio">
                                        <input type="radio" name="is_premium" id="is_premium_yes" class="custom-control-input" value="1">
                                        <label class="custom-control-label" for="is_premium_yes">{{__('label.yes')}}</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>{{__('label.is_title')}}<span class="text-danger">*</span></label>
                                <div class="radio-group">
                                    <div class="custom-control custom-radio">
                                        <input type="radio" name="is_title" id="is_title_no" class="custom-control-input" value="0" checked>
                                        <label class="custom-control-label" for="is_title_no">{{__('label.no')}}</label>
                                    </div>
                                    <div class="custom-control custom-radio">
                                        <input type="radio" name="is_title" id="is_title_yes" class="custom-control-input" value="1">
                                        <label class="custom-control-label" for="is_title_yes">{{__('label.yes')}}</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2 Is_Download">
                            <div class="form-group">
                                <label>{{__('label.is_download')}}<span class="text-danger">*</span></label>
                                <div class="radio-group">
                                    <div class="custom-control custom-radio">
                                        <input type="radio" name="is_download" id="is_download_no" class="custom-control-input" value="0" checked>
                                        <label class="custom-control-label" for="is_download_no">{{__('label.no')}}</label>
                                    </div>
                                    <div class="custom-control custom-radio">
                                        <input type="radio" name="is_download" id="is_download_yes" class="custom-control-input" value="1">
                                        <label class="custom-control-label" for="is_download_yes">{{__('label.yes')}}</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>{{__('label.is_like')}}<span class="text-danger">*</span></label>
                                <div class="radio-group">
                                    <div class="custom-control custom-radio">
                                        <input type="radio" name="is_like" id="is_like_no" class="custom-control-input" value="0" checked>
                                        <label class="custom-control-label" for="is_like_no">{{__('label.no')}}</label>
                                    </div>
                                    <div class="custom-control custom-radio">
                                        <input type="radio" name="is_like" id="is_like_yes" class="custom-control-input" value="1">
                                        <label class="custom-control-label" for="is_like_yes">{{__('label.yes')}}</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-lg-3 video_box">
                            <div style="display: block;">
                                <label>{{__('label.upload_video_320_px')}}<span class="text-danger">*</span></label>
                                <div id="filelist"></div>
                                <div id="container" style="position: relative;">
                                    <div class="form-group">
                                        <input type="file" id="uploadFile" name="uploadFile" style="position: relative; z-index: 1;" class="form-control">
                                    </div>
                                    <input type="hidden" name="video_320" id="mp3_file_name" class="form-control">

                                    <div class="form-group">
                                        <a id="upload" class="btn text-white" style="background-color:#4e45b8;">{{__('label.upload_files')}}</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-lg-3 video_box">
                            <div style="display: block;">
                                <label>{{__('label.upload_video_480_px')}}</label>
                                <div id="filelist1"></div>
                                <div id="container1" style="position: relative;">
                                    <div class="form-group">
                                        <input type="file" id="uploadFile1" name="uploadFile1" style="position: relative; z-index: 1;" class="form-control">
                                    </div>
                                    <input type="hidden" name="video_480" id="mp3_file_name1" class="form-control">

                                    <div class="form-group">
                                        <a id="upload1" class="btn text-white" style="background-color:#4e45b8;">{{__('label.upload_files')}}</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-lg-3 video_box">
                            <div style="display: block;">
                                <label>{{__('label.upload_video_720_px')}}</label>
                                <div id="filelist2"></div>
                                <div id="container2" style="position: relative;">
                                    <div class="form-group">
                                        <input type="file" id="uploadFile2" name="uploadFile2" style="position: relative; z-index: 1;" class="form-control">
                                    </div>
                                    <input type="hidden" name="video_720" id="mp3_file_name2" class="form-control">

                                    <div class="form-group">
                                        <a id="upload2" class="btn text-white" style="background-color:#4e45b8;">{{__('label.upload_files')}}</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-lg-3 video_box">
                            <div style="display: block;">
                                <label>{{__('label.upload_video_1080_px')}}</label>
                                <div id="filelist3"></div>
                                <div id="container3" style="position: relative;">
                                    <div class="form-group">
                                        <input type="file" id="uploadFile3" name="uploadFile3" style="position: relative; z-index: 1;" class="form-control">
                                    </div>
                                    <input type="hidden" name="video_1080" id="mp3_file_name3" class="form-control">

                                    <div class="form-group">
                                        <a id="upload3" class="btn text-white" style="background-color:#4e45b8;">{{__('label.upload_files')}}</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-lg-6 url_box">
                            <label>{{__('label.url_320_px')}}</label>
                            <input name="video_url_320" type="url" class="form-control" placeholder="{{__('label.enter_video_url_320_px')}}">
                        </div>
                        <div class="form-group col-lg-6 url_box">
                            <label>{{__('label.url_480_px')}}</label>
                            <input name="video_url_480" type="url" class="form-control" placeholder="{{__('label.enter_video_url_480_px')}}">
                        </div>
                        <div class="form-group col-lg-6 url_box">
                            <label>{{__('label.url_720_px')}}</label>
                            <input name="video_url_720" type="url" class="form-control" placeholder="{{__('label.enter_video_url_720_px')}}">
                        </div>
                        <div class="form-group col-lg-6 url_box">
                            <label>{{__('label.url_1080_px')}}</label>
                            <input name="video_url_1080" type="url" class="form-control" placeholder="{{__('label.enter_video_url_1080_px')}}">
                        </div>
                    </div>
                </div>
                <div class="custom-border-card">
                    <div class="form-row">
                        <div class="form-group col-lg-4">
                            <label>{{__('label.subtitle_type')}}</label>
                            <select name="subtitle_type" id="subtitle_type" class="form-control">
                                <option selected="selected" value="server_video">{{__('label.server_video')}}</option>
                                <option value="external">{{__('label.external_url')}}</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>{{__('label.language_name')}}</label>
                                <input type="text" name="subtitle_lang_1" class="form-control" placeholder="{{__('label.enter_your_language')}}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>{{__('label.language_name')}}</label>
                                <input type="text" name="subtitle_lang_2" class="form-control" placeholder="{{__('label.enter_your_language')}}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>{{__('label.language_name')}}</label>
                                <input type="text" name="subtitle_lang_3" class="form-control" placeholder="{{__('label.enter_your_language')}}">
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-lg-4 subtitle_box">
                            <div style="display: block;">
                                <label>{{__('label.upload_subtitle')}}</label>
                                <div id="filelist4"></div>
                                <div id="container4" style="position: relative;">
                                    <div class="form-group">
                                        <input type="file" id="uploadFile4" name="uploadFile4" style="position: relative; z-index: 1;" class="form-control">
                                    </div>
                                    <input type="hidden" name="subtitle_1" id="mp3_file_name4" class="form-control">

                                    <div class="form-group">
                                        <a id="upload4" class="btn text-white" style="background-color:#4e45b8;">{{__('label.upload_files')}}</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-lg-4 subtitle_box">
                            <div style="display: block;">
                                <label>{{__('label.upload_subtitle')}}</label>
                                <div id="filelist6"></div>
                                <div id="container6" style="position: relative;">
                                    <div class="form-group">
                                        <input type="file" id="uploadFile6" name="uploadFile6" style="position: relative; z-index: 1;" class="form-control">
                                    </div>
                                    <input type="hidden" name="subtitle_2" id="mp3_file_name6" class="form-control">

                                    <div class="form-group">
                                        <a id="upload6" class="btn text-white" style="background-color:#4e45b8;">{{__('label.upload_files')}}</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-lg-4 subtitle_box">
                            <div style="display: block;">
                                <label>{{__('label.upload_subtitle')}}</label>
                                <div id="filelist7"></div>
                                <div id="container7" style="position: relative;">
                                    <div class="form-group">
                                        <input type="file" id="uploadFile7" name="uploadFile7" style="position: relative; z-index: 1;" class="form-control">
                                    </div>
                                    <input type="hidden" name="subtitle_3" id="mp3_file_name7" class="form-control">

                                    <div class="form-group">
                                        <a id="upload7" class="btn text-white" style="background-color:#4e45b8;">{{__('label.upload_files')}}</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-lg-4 subtitle_url_box">
                            <label>{{__('label.subtitle')}}</label>
                            <input name="subtitle_url_1" type="url" class="form-control" placeholder="{{__('label.enter_subtitle_url')}}">
                        </div>
                        <div class="form-group col-lg-4 subtitle_url_box">
                            <label>{{__('label.subtitle')}}</label>
                            <input name="subtitle_url_2" type="url" class="form-control" placeholder="{{__('label.enter_subtitle_url')}}">
                        </div>
                        <div class="form-group col-lg-4 subtitle_url_box">
                            <label>{{__('label.subtitle')}}</label>
                            <input name="subtitle_url_3" type="url" class="form-control" placeholder="{{__('label.enter_subtitle_url')}}">
                        </div>
                    </div>
                </div>
                <div class="custom-border-card">
                    <div class="form-row">
                        <div class="col-6">
                            <div class="form-row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>{{__('label.video_duration')}}<span class="text-danger">*</span></label>
                                        <input type="text" id="timePicker" name="video_duration" placeholder="{{__('label.video_duration')}}" class="form-control">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label>{{__('label.description')}}<span class="text-danger">*</span></label>
                                        <textarea name="description" class="form-control" rows="2" id="description" placeholder="Hello..."></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group ml-5">
                                <label class="ml-5">{{__('label.thumbnail_image')}}<span class="text-danger">*</span></label>
                                <div class="avatar-upload ml-5">
                                    <div class="avatar-edit">
                                        <input type='file' name="thumbnail" id="imageUpload" accept=".png, .jpg, .jpeg" />
                                        <label for="imageUpload" title="{{__('label.select_file')}}"></label>
                                    </div>
                                    <div class="avatar-preview">
                                        <img src="{{asset('assets/imgs/upload_img.png')}}" alt="upload_img.png" id="imagePreview">
                                    </div>
                                </div>
                                <label class="mt-3 ml-5 text-gray">{{__('label.maximum_size_2mb')}}</label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group ml-5">
                                <label>{{__('label.landscape_image')}}<span class="text-danger">*</span></label>
                                <div class="avatar-upload-landscape">
                                    <div class="avatar-edit-landscape">
                                        <input type='file' name="landscape" id="imageUploadLandscape" accept=".png, .jpg, .jpeg" />
                                        <label for="imageUploadLandscape" title="{{__('label.select_file')}}"></label>
                                    </div>
                                    <div class="avatar-preview-landscape">
                                        <img src="{{asset('assets/imgs/upload_img.png')}}" alt="upload_img.png" id="imagePreviewLandscape">
                                    </div>
                                </div>
                                <label class="mt-3 text-gray">{{__('label.maximum_size_2mb')}}</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="text-right">
                    <button type="button" class="btn btn-default mw-120" onclick="save_tvshow_video()">{{__('label.save')}}</button>
                    <a href="{{route('kidstvshow.episode.index', ['id' => $tvshow_id])}}" class="btn btn-cancel mw-120 ml-2">{{__('label.cancel')}}</a>
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                </div>
            </form>
        </div>
    </div>
@endsection

@section('pagescript')
    <script>

        // Sidebar Scroll Down
        sidebar_down(400);

        var d = new Date();
        d.setHours(0,0,0);
        $('#timePicker').datetimepicker({
            useCurrent: false,
            format:'HH:mm:ss',
            defaultDate: d,
            showClose:true,
            showTodayButton: true,
            icons: {
                up: "fa fa-chevron-up",
                down: "fa fa-chevron-down",
                today: "fa fa-clock fa-regular",
                close: "fa fa-times",
            }
        })

        function save_tvshow_video() {

            var Check_Admin = '<?php echo Check_Admin_Access(); ?>';
            if(Check_Admin == 1){
            
                var formData = new FormData($("#save_tvshow_video")[0]);
                $("#dvloader").show();
                $.ajax({
                    type: 'POST',
                    url: '{{ route("kidstvshow.episode.save") }}',
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function(resp) {
                        $("#dvloader").hide();
                        get_responce_message(resp, 'save_tvshow_video', '{{ route("kidstvshow.episode.index",["id" => $tvshow_id]) }}');
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

        $(document).ready(function() {
            $(".url_box").hide();
            $('#video_upload_type').change(function() {
                var optionValue = $(this).val();

                if (optionValue == 'server_video') {
                    $(".video_box").show();
                    $(".url_box").hide();
                } else {
                    $(".url_box").show();
                    $(".video_box").hide();
                }

                if (optionValue == 'server_video' || optionValue == 'external') {
                    $(".Is_Download").show();
                } else {
                    $(".Is_Download").hide();
                }
            });

            $(".subtitle_url_box").hide();
            $('#subtitle_type').change(function() {
                var optionValue = $(this).val();

                if (optionValue == 'server_video') {
                    $(".subtitle_box").show();
                    $(".subtitle_url_box").hide();
                } else {
                    $(".subtitle_url_box").show();
                    $(".subtitle_box").hide();
                }
            });
        });
    </script>
@endsection