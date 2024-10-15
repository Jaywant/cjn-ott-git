@extends('producer.layout.page-app')
@section('page_title', __('label.add_channel_tv_show'))

@section('content')
    @include('producer.layout.sidebar')

    <div class="right-content">
        @include('producer.layout.header')

        <div class="body-content">
            <!-- mobile title -->
            <h1 class="page-title-sm">{{__('label.add_channel_tv_show')}}</h1>

            <div class="border-bottom row mb-3">
                <div class="col-sm-10">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('producer.dashboard') }}">{{__('label.dashboard')}}</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('pch_tvshow.index') }}">{{__('label.channel_tv_shows')}}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{__('label.add_channel_tv_show')}}</li>
                    </ol>
                </div>
                <div class="col-sm-2 d-flex align-items-center justify-content-end">
                    <a href="{{ route('pch_tvshow.index') }}" class="btn btn-default mw-120" style="margin-top:-14px">{{__('label.tvshow_list')}}</a>
                </div>
            </div>

            <form id="save_tvshow" enctype="multipart/form-data">
                <div class="custom-border-card">
                    <?php $status = TMDB_Status(); ?>  <!-- 0- No, 1- Yes-->
                    @if($status == 0)
                    <div class="form-row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>{{__('label.name')}}<span class="text-danger">*</span></label>
                                <input type="text" name="name" class="form-control" placeholder="{{__('label.enter_tvshow_name')}}" autofocus>
                            </div>
                        </div>
                    </div>
                    @elseif ($status == 1)
                    <div class="form-row">
                        <div class="col-md-2">
                            <div class="form-group pt-3">
                                <label>{{__('label.import_from_tmdb')}}</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="text" name="Tmdb_id" id="Tmdb_id" class="form-control" placeholder="{{__('label.enter_tmdb_tv_show_id_eg')}}">
                                <label class="mt-1 text-gray">{{__('label.tmdb_notes')}} <a href="https://www.reddit.com/r/jellyfin/comments/xf8uvg/where_to_find_tmdb_id/" target="_blank" class="btn-link">{{__('label.click_here')}}</a> </label>
                            </div>
                        </div>
                        <div class="col-md-2 ml-5">
                            <div class="form-group">
                                <button type="button" class="btn btn-default mw-120" onclick="tmdb_data_fetch()">{{__('label.fetch')}}</button>
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-12 ml-5">
                            <div class="form-group">
                                <label>{{__('label.or')}}</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-2 pt-3">
                            <div class="form-group">
                                <label>{{__('label.tvshow_name')}}</label>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <input type="text" name="name" id="Tmdb_name" list="Tmdb_name_list" class="form-control" placeholder="{{__('label.enter_tvshow_name')}}" autofocus>
                                <datalist id="Tmdb_name_list"></datalist>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
                <div class="custom-border-card">
                    <div class="form-row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>{{__('label.category')}}<span class="text-danger">*</span></label>
                                <select class="form-control" style="width:100%!important;" name="category_id[]" multiple id="category_id">
                                    @foreach ($category as $key => $value)
                                    <option value="{{$value->id}}">
                                        {{ $value->name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>{{__('label.type')}}<span class="text-danger">*</span></label>
                                <select class="form-control" name="type_id">
                                    <option value=""> {{__('label.select_type')}}</option>
                                    @foreach ($type as $key => $value)
                                    <option value="{{$value->id}}">
                                        {{ $value->name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>{{__('label.channel')}}<span class="text-danger">*</span></label>
                                <select class="form-control" name="channel_id" id="channel_id">
                                    <option value="">{{__('label.select_channel')}}</option>
                                    @foreach ($channel as $key => $value)
                                    <option value="{{$value->id}}">
                                        {{ $value->name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>{{__('label.language')}}<span class="text-danger">*</span></label>
                                <select class="form-control" style="width:100%!important;" name="language_id[]" id="language_id" multiple>
                                    @foreach ($language as $key => $value)
                                    <option value="{{$value->id}}">
                                        {{ $value->name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>{{__('label.release_date')}}<span class="text-danger">*</span></label>
                                <input name="release_date" type="date" class="form-control" id="release_date">
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-9">
                            <div class="form-group">
                                <label>{{__('label.cast')}}<span class="text-danger">*</span></label>
                                <select class="form-control" style="width:100%!important;" name="cast_id[]" multiple id="cast_id">
                                    @foreach ($cast as $key => $value)
                                    <option value="{{$value->id}}">
                                        {{ $value->name }}
                                    </option>
                                    @endforeach
                                </select>
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
                    </div>
                </div>
                <div class="custom-border-card">
                    <div class="form-row">
                        <div class="form-group col-lg-4">
                            <label>{{__('label.trailer_type')}}<span class="text-danger">*</span></label>
                            <select name="trailer_type" id="trailer_type" class="form-control">
                                <option selected="selected" value="server_video">{{__('label.server_video')}}</option>
                                <option value="external">{{__('label.external_url')}}</option>
                                <option value="youtube">{{__('label.youtube')}}</option>
                            </select>
                            <label class="mt-1 mb-2 text-gray">{{__('label.video_notes')}}<a href="https://commentpicker.com/youtube-video-id.php" target="_blank" class="btn-link">{{__('label.click_here')}}</a></label>
                        </div>
                        <div class="form-group col-lg-6 trailer_box">
                            <div style="display: block;">
                                <label>{{__('label.trailer')}}<span class="text-danger">*</span></label>
                                <div id="filelist5"></div>
                                <div id="container5" style="position: relative;">
                                    <div class="form-group">
                                        <input type="file" id="uploadFile5" name="uploadFile5" style="position: relative; z-index: 1;" class="form-control">
                                    </div>
                                    <input type="hidden" name="trailer" id="mp3_file_name5" class="form-control">

                                    <div class="form-group">
                                        <a id="upload5" class="btn text-white" style="background-color:#4e45b8;">{{__('label.upload_files')}}</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-lg-6 trailer_url_box">
                            <label>{{__('label.trailer')}}<span class="text-danger">*</span></label>
                            <input name="trailer_url" type="url" class="form-control" placeholder="{{__('label.enter_trailer_url')}}">
                        </div>
                    </div>
                </div>
                <div class="custom-border-card">
                    <div class="form-row">
                        <div class="col-6">
                            <div class="form-group">
                                <label>{{__('label.description')}}<span class="text-danger">*</span></label>
                                <textarea name="description" class="form-control" rows="2" id="description" placeholder="Hello..."></textarea>                               
                            </div>
                            <div class="form-row mt-3">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>{{__('label.is_rent')}}<span class="text-danger">*</span></label>
                                        <div class="radio-group">
                                            <div class="custom-control custom-radio">
                                                <input type="radio" name="is_rent" id="is_rent_no" class="custom-control-input" value="0" checked>
                                                <label class="custom-control-label" for="is_rent_no">{{__('label.no')}}</label>
                                            </div>
                                            <div class="custom-control custom-radio">
                                                <input type="radio" name="is_rent" id="is_rent_yes" class="custom-control-input" value="1">
                                                <label class="custom-control-label" for="is_rent_yes">{{__('label.yes')}}</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                       <label>{{__('label.is_comment')}}<span class="text-danger">*</span></label>
                                        <div class="radio-group">
                                            <div class="custom-control custom-radio">
                                                <input type="radio" name="is_comment" id="is_comment_no" class="custom-control-input" value="0">
                                                <label class="custom-control-label" for="is_comment_no">{{__('label.no')}}</label>
                                            </div>
                                            <div class="custom-control custom-radio">
                                                <input type="radio" name="is_comment" id="is_comment_yes" class="custom-control-input" value="1" checked>
                                                <label class="custom-control-label" for="is_comment_yes">{{__('label.yes')}}</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>{{__('label.is_like')}}<span class="text-danger">*</span></label>
                                        <div class="radio-group">
                                            <div class="custom-control custom-radio">
                                                <input type="radio" name="is_like" id="is_like_no" class="custom-control-input" value="0">
                                                <label class="custom-control-label" for="is_like_no">{{__('label.no')}}</label>
                                            </div>
                                            <div class="custom-control custom-radio">
                                                <input type="radio" name="is_like" id="is_like_yes" class="custom-control-input" value="1" checked>
                                                <label class="custom-control-label" for="is_like_yes">{{__('label.yes')}}</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row rent_price">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>{{__('label.price_list')}}<span class="text-danger">*</span></label>
                                        <select class="form-control" name="price">
                                            <option value="">{{__('label.select_price')}}</option>
                                            @foreach ($rent_price_list as $key => $value)
                                            <option value="{{$value->id}}">
                                                {{ $value->price }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>{{__('label.rent_time_in_days')}}<span class="text-danger">*</span></label>
                                        <input type="number" name="rent_day" class="form-control" placeholder="{{__('label.enter_howmany_day')}}" min="0" value="0">
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
                                        <input type="hidden" class="form-control" id="thumbnail_tmdb" name="thumbnail_tmdb">
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
                                        <input type="hidden" class="form-control" id="landscape_tmdb" name="landscape_tmdb">
                                    </div>
                                </div>
                                <label class="mt-3 text-gray">{{__('label.maximum_size_2mb')}}</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="text-right">
                    <button type="button" class="btn btn-default mw-120" onclick="save_tvshow()">{{__('label.save')}}</button>
                    <a href="{{route('pch_tvshow.index')}}" class="btn btn-cancel mw-120 ml-2">{{__('label.cancel')}}</a>
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                </div>
            </form>
        </div>
    </div>
@endsection

@section('pagescript')
	<script>
		function save_tvshow() {
            var Check_Admin = '<?php echo Check_Admin_Access(); ?>';
            if(Check_Admin == 1){

                var formData = new FormData($("#save_tvshow")[0]);
                $("#dvloader").show();
                $.ajax({
                    type: 'POST',
                    url: '{{ route("pch_tvshow.store") }}',
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function(resp) {
                        $("#dvloader").hide();
                        get_responce_message(resp, 'save_tvshow', '{{ route("pch_tvshow.index") }}');
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
			$("#channel_id").select2();
            $("#category_id").select2({placeholder: "{{__('label.select_category')}}"});
            $("#language_id").select2({placeholder: "{{__('label.select_language')}}"});
            $("#cast_id").select2({placeholder: "{{__('label.select_cast')}}"});

            $(".trailer_url_box").hide();
            $('#trailer_type').change(function() {
                var optionValue = $(this).val();

                if (optionValue == 'server_video') {
                    $(".trailer_box").show();
                    $(".trailer_url_box").hide();
                } else {
                    $(".trailer_url_box").show();
                    $(".trailer_box").hide();
                }
            });

            $(".rent_price").hide();
            $('input[type=radio][name=is_rent]').change(function() {
                if (this.value == 1) {
                    $(".rent_price").show();
                }
                else if (this.value == 0) {
                    $(".rent_price").hide();
                }
            });
		});

        $('#Tmdb_name').keyup(function() {
            var txtVal = this.value;

            if(txtVal.length >= 3){
                var url = "{{route('ptvshow.serach.name', '')}}"+"/"+txtVal;
                $.ajax({
                	type: "POST",
                	url: url,
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                	data: txtVal,
                	success: function(resp) {
                        if (resp.status == 200){

                            if (resp.data.results.length > 0) {
                                var Title_Data = resp.data.results;
                                
                                $('#Tmdb_name_list').empty();
                                for (let i = 0; i < Title_Data.length; i++) {
                                    $('#Tmdb_name_list').append('<option id="'+ resp.data.results[i].id +'" value="' + resp.data.results[i].name + '"></option>');                              
                                }
                            }
                        }
                	},
                	error: function(XMLHttpRequest, textStatus, errorThrown) {
                		toastr.error(errorThrown, textStatus);
                	}
                });
            }
        });
        $('#Tmdb_name').on('input', function() {
            var userText = $(this).val();

            $("#Tmdb_name_list").find("option").each(function() {
                if ($(this).val() == userText) {

                    var MoviesName = $("#Tmdb_name").val();
                    c_id = $('#Tmdb_name_list').find('option[value="' + MoviesName + '"]').attr('id');

                    $("#dvloader").show();
                    var url = "{{route('ptvshow.getdata', '')}}" + "/" + c_id;
                    $.ajax({
                        type: "POST",
                        url: url,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: c_id,
                        success: function(resp) {
                            $("#dvloader").hide();

                            if (resp.status == 200) {
                                
                                var C_Id = resp.data.C_Id;
                                var L_Id = resp.data.L_Id;
                                var C_Insert_Data = resp.data.C_Insert_Data;
                                var L_Insert_Data = resp.data.L_Insert_Data;
                                var Cast_Id = resp.data.Cast_Id;
                                var Cast_Insert_Data = resp.data.Cast_Insert_Data;
                                var Thumbnail = resp.data.Thumbnail;
                                var Title = resp.data.Title;
                                var Description = resp.data.Description;
                                var Release_Date = resp.data.Release_Date;

                                // Append New Category
                                for (let i = 0; i < C_Insert_Data.length; i++) {
                                    var data = '<option value="' + C_Insert_Data[i].id + '">' + C_Insert_Data[i].name + '</option>';
                                    $('#category_id').append(data);
                                }
                                $("#category_id").val(C_Id).trigger("change");

                                // Append New Language
                                for (let i = 0; i < L_Insert_Data.length; i++) {
                                    var data = '<option value="' + L_Insert_Data[i].id + '">' + L_Insert_Data[i].name + '</option>';
                                    $('#language_id').append(data);
                                }
                                $("#language_id").val(L_Id).trigger("change");

                                // Append New Cast
                                for (let i = 0; i < Cast_Insert_Data.length; i++) {
                                    var data = '<option value="' + Cast_Insert_Data[i].id + '">' + Cast_Insert_Data[i].name + '</option>';
                                    $('#cast_id').append(data);
                                }
                                $("#cast_id").val(Cast_Id).trigger("change");

                                // Image 
                                $('#imagePreview').attr('src', Thumbnail);
                                $('#imagePreviewLandscape').attr('src', Thumbnail);
                                $('#thumbnail_tmdb').attr('value', Thumbnail);
                                $('#landscape_tmdb').attr('value', Thumbnail);
                                $('#description').val(Description);
                                $("#release_date").attr('value', Release_Date);
                            }
                        },
                        error: function(XMLHttpRequest, textStatus, errorThrown) {
                            $("#dvloader").hide();
                            toastr.error(errorThrown, textStatus);
                        }
                    });
                }
            })
        })
        function tmdb_data_fetch() {

            var id = $("#Tmdb_id").val();

            if (id != "") {

                $("#dvloader").show();
                var url = "{{route('ptvshow.getdata', '')}}" + "/" + id;
                $.ajax({
                    type: "POST",
                    url: url,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: id,
                    success: function(resp) {
                        $("#dvloader").hide();

                        if (resp.status == 200) {
                            
                            var C_Id = resp.data.C_Id;
                            var L_Id = resp.data.L_Id;
                            var C_Insert_Data = resp.data.C_Insert_Data;
                            var L_Insert_Data = resp.data.L_Insert_Data;
                            var Cast_Id = resp.data.Cast_Id;
                            var Cast_Insert_Data = resp.data.Cast_Insert_Data;
                            var Thumbnail = resp.data.Thumbnail;
                            var Title = resp.data.Title;
                            var Description = resp.data.Description;
                            var Release_Date = resp.data.Release_Date;

                            // Append New Category
                            for (let i = 0; i < C_Insert_Data.length; i++) {
                                var data = '<option value="' + C_Insert_Data[i].id + '">' + C_Insert_Data[i].name + '</option>';
                                $('#category_id').append(data);
                            }
                            $("#category_id").val(C_Id).trigger("change");

                            // Append New Language
                            for (let i = 0; i < L_Insert_Data.length; i++) {
                                var data = '<option value="' + L_Insert_Data[i].id + '">' + L_Insert_Data[i].name + '</option>';
                                $('#language_id').append(data);
                            }
                            $("#language_id").val(L_Id).trigger("change");

                            // Append New Cast
                            for (let i = 0; i < Cast_Insert_Data.length; i++) {
                                var data = '<option value="' + Cast_Insert_Data[i].id + '">' + Cast_Insert_Data[i].name + '</option>';
                                $('#cast_id').append(data);
                            }
                            $("#cast_id").val(Cast_Id).trigger("change");

                            // Image 
                            $('#imagePreview').attr('src', Thumbnail);
                            $('#imagePreviewLandscape').attr('src', Thumbnail);
                            $('#thumbnail_tmdb').attr('value', Thumbnail);
                            $('#landscape_tmdb').attr('value', Thumbnail);
                            $('#description').val(Description);
                            $("#release_date").attr('value', Release_Date);

                            // Title
                            $('#Tmdb_name').val(Title);
                        }
                    },
                    error: function(XMLHttpRequest, textStatus, errorThrown) {
                        $("#dvloader").hide();
                        toastr.error(errorThrown, textStatus);
                    }
                });
            } else {
                alert('{{__("label.please_enter_tmdb_id")}}');
            }
        }
	</script>	
@endsection