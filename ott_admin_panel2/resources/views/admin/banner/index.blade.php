@extends('admin.layout.page-app')
@section('page_title', __('label.banner'))

@section('content')
    @include('admin.layout.sidebar')

    <div class="right-content">
        @include('admin.layout.header')

        <div class="body-content">
            <!-- mobile title -->
            <h1 class="page-title-sm">{{__('label.banner')}}</h1>

            <div class="border-bottom row mb-3">
                <div class="col-sm-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{__('label.dashboard')}}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{__('label.banner')}}</li>
                    </ol>
                </div>
            </div>

            @if(isset($type) && $type != null && count($type) > 0)
            <ul class="tabs nav nav-pills custom-tabs inline-tabs" id="pills-tab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="app-tab" onclick="Selected_Type('{{$type[0]['id']}}', '{{$type[0]['type']}}', 1)" data-is_home_screen="1" href="#app" role="tab" data-toggle="tab" aria-controls="app" aria-selected="true">{{__('label.home')}}</a>
                </li>
                @for ($i = 0; $i < count($type); $i++) 
                <li class="nav-item">
                    <a class="nav-link" id="{{$type[$i]['name']}}-tab" onclick="Selected_Type('{{$type[$i]['id']}}', '{{$type[$i]['type']}}', 2)" data-is_home_screen="2" data-id="{{$type[$i]['id']}}" data-type="{{$type[$i]['type']}}" data-toggle="tab" href="#{{$type[$i]['name']}}" role="tab" aria-controls="{{$type[$i]['name']}}" aria-selected="true">{{ $type[$i]['name']}}</a>
                </li>
                @endfor
            </ul>
            @endif

            <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade show active" id="app" role="tabpanel" aria-labelledby="app-tab">
                    <div class="card custom-border-card">
                        <h5 class="card-header">{{__('label.add_banner')}}</h5>
                        @if(isset($type) && $type != null && count($type) > 0)
                        <div class="card-body">
                            <form id="save_banner">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                                <div class="form-row radio-row">
                                    <div class="col-md-6 d-flex justify-content-start">
                                        @for ($i = 0; $i < count($type); $i++) 
                                        <div class="form-check form-check-inline mr-3">
                                            <input class="form-check-input radio" type="radio" name="type_id" onclick="Selected_Type('{{$type[$i]['id']}}', '{{$type[$i]['type']}}', 2)" data-id="{{$type[$i]['id']}}" data-type="{{$type[$i]['type']}}" data-name="{{$type[$i]['name']}}" id="Video_Selecte{{$i}}" value="{{$type[$i]['id']}}" {{ $i == 0  ? 'checked' : ''}}>
                                            <label class="form-check-label font-weight-bold h6">{{$type[$i]['name']}}</label>
                                        </div>
                                        @endfor
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-md-2 mr-3 subvideo_type">
                                        <div class="form-group mt-4">
                                            <label>{{__('label.sub_video_type')}}</label>
                                            <select class="form-control" name="subvideo_type" id="subvideo_type">
                                                <option value="" selected disabled>{{__('label.select_type')}}</option>
                                                <option value="1">{{__('label.video')}}</option>
                                                <option value="2">{{__('label.show')}}</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6 option_class_video">
                                        <div class="form-group mt-4">
                                            <label>{{__('label.video')}}</label>
                                            <select class="form-control" name="video_id" id="video_id" style="width:100%!important;">
                                                <option selected disabled>{{__('label.select_video')}}</option>
                                                @foreach ($video as $key => $value)
                                                <option value="{{$value->id}}">{{ $value->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="after-add-more"></div>

                            </form>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('pagescript')
    <script>
        $("#video_id").select2();

        var type = $('input[name=type_id]:checked').data('type');
        if(type == 1 || type == 2){
            $(".subvideo_type").hide();
        }

        function Selected_Type(type_id, type, is_home_page){

            $("#video_id").empty();
            $('#video_id').append(`<option selected disabled>{{__('label.select_video')}}</option>`);

            $(".subvideo_type").hide();
            if(type == 5 || type == 6 || type == 7){
                $(".subvideo_type").show();
            }

            if(is_home_page == 1) {
                $("#Video_Selecte0").prop('checked', true);
            }

            if (type == 1 || type == 2) {
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: 'POST',
                    url: '{{ route("bannerTypeByVideo") }}',
                    data: {
                        type_id:type_id, 
                        type:type
                    },
                    success: function(resp) {

                        for (var i = 0; i < resp.result.length; i++) {
                            $('#video_id').append(`<option value="${resp.result[i].id}">${resp.result[i].name}</option>`);          
                        }
                    },
                    error: function(XMLHttpRequest, textStatus, errorThrown) {
                        toastr.error(errorThrown, textStatus);
                    }
                });
            } else if (type == 5 || type == 6 || type == 7) {

                var subvideo_type = $('#subvideo_type').find(":selected").val();
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: 'POST',
                    url: '{{ route("bannerTypeByVideo") }}',
                    data: {
                        type_id:type_id,
                        type:type,
                        subvideo_type:subvideo_type
                    },
                    success: function(resp) {

                        for (var i = 0; i < resp.result.length; i++) {
                            $('#video_id').append(`<option value="${resp.result[i].id}">${resp.result[i].name}</option>`);          
                        }
                    },
                    error: function(XMLHttpRequest, textStatus, errorThrown) {
                        toastr.error(errorThrown, textStatus);
                    }
                });
            }
        };

        // Sub Video Type
        $('#subvideo_type').on('change', function () {

            $("#video_id").empty();
            $('#video_id').append(`<option selected disabled>{{__('label.select_video')}}</option>`);

            var Tab = $("ul.tabs li a.active");
            var Is_home_screen = Tab.data("is_home_screen");
            var subvideo_type = $(this).children("option:selected").val();

            if (Is_home_screen == 1) {

                var type_id = $('input[name=type_id]:checked').data('id');
                var type = $('input[name=type_id]:checked').data('type');
            } else if (Is_home_screen == 2) {

                var type_id = Tab.data("id");
                var type = Tab.data("type");
            }

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'POST',
                url: '{{ route("bannerTypeByVideo") }}',
                data: {
                    type_id:type_id,
                    type:type,
                    subvideo_type:subvideo_type,
                },
                success: function(resp) {

                    for (var i = 0; i < resp.result.length; i++) {
                        $('#video_id').append(`<option value="${resp.result[i].id}">${resp.result[i].name}</option>`);          
                    }
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    toastr.error(errorThrown, textStatus);
                }
            });
        });

        // Save
        $('#video_id').on('change', function () {

            var Check_Admin = '<?php echo Check_Admin_Access(); ?>';
            if (Check_Admin == 1) {

                var Tab = $("ul.tabs li a.active");
                var Is_home_screen = Tab.data("is_home_screen");
                var Video_Id = $(this).children("option:selected").val();
                var subvideo_type = $('#subvideo_type').find(":selected").val();

                if(Is_home_screen == 1){

                    var Type_Id = $('input[name=type_id]:checked').val();
                    var Video_Type = $('input[name=type_id]:checked').data('type');
                } else {

                    var Type_Id = Tab.data("id");
                    var Video_Type = Tab.data("type");
                }  

                $("#dvloader").show();
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: 'POST',
                    url: '{{ route("banner.store") }}',
                    data: {
                        is_home_screen:Is_home_screen,
                        type_id:Type_Id,
                        video_type: Video_Type,
                        video_id:Video_Id,
                        subvideo_type:subvideo_type,
                    },
                    success: function(resp) {
                        $("#dvloader").hide();
                        get_responce_message(resp, 'save_banner', '{{ route("banner.index") }}');
                    },
                    error: function(XMLHttpRequest, textStatus, errorThrown) {
                        $("#dvloader").hide();
                        toastr.error(errorThrown, textStatus);
                    }
                });

            } else {
                toastr.error('{{__("label.you_have_no_right_to_add_edit_and_delete")}}');
            }
        });

        // Banner List
        var Tab = $("ul.tabs li a.active");
        var Is_home_screen = Tab.data("is_home_screen");
        if(Is_home_screen == 1){

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "POST",
                data: {is_home_screen:Is_home_screen},
                url: '{{ route("bannerList") }}',
                success: function(resp) {

                    if(resp.result.length > 0){

                        var label_type = '{{__("label.type")}}';
                        var label_video = '{{__("label.video")}}';
                        var label_delete = '{{__("label.delete")}}';

                        var data ='<div class="form-group row mb-0 pb-0">' +
                                    '<div class="col-md-2">' +
                                        '<label>'+label_type+'</label>' +
                                    '</div>' +
                                    '<div class="col-md-4">' +
                                        '<label>'+label_video+'</label>' +
                                    '</div>' +
                                '</div>';
                        $('.after-add-more').append(data);
                    }

                    for (var i = 0; i < resp.result.length; i++) {
                        var data ='<div class="form-group row">' +
                                    '<div class="col-md-2">' +
                                        '<input type="text" class="form-control" name="type" value="'+ resp.result[i].type.name +'" placeholder="Dropdown" readonly/>' +
                                        '<input type="hidden" class="form-control" name="video_type" value=""/>' +
                                    '</div>' +
                                    '<div class="col-md-4">' +
                                        '<input type="text" class="form-control" name="video" value="'+ resp.result[i].video.name +'" id="video" placeholder="Dropdown" readonly/>' +
                                    '</div>' +
                                    '<div class="col-md-1">' +
                                        '<a onclick="DeleteBanner('+ resp.result[i].id +')" class="btn btn-danger remove" id="remove" title="'+ label_delete +'"><i class="fa-solid fa-trash-can fa-xl"></i></a>' +                                   
                                    '</div>' +
                                '</div>';
                        $('.after-add-more').append(data);
                    }
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    toastr.error(errorThrown, textStatus);
                }
            });
        }
        $('.nav-item a').on('click', function() {

            var label_type = '{{__("label.type")}}';
            var label_video = '{{__("label.video")}}';
            var label_delete = '{{__("label.delete")}}';

            var Is_home_screen = $(this).data("is_home_screen");
            $(".after-add-more .row").remove();
            if(Is_home_screen == 2){

                $('.radio-row').hide();
                var type_id = $(this).data("id");

                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: "POST",
                    data: {type_id:type_id, is_home_screen:Is_home_screen},
                    url: '{{ route("bannerList") }}',
                    success: function(resp) {

                        if(resp.result.length > 0){
                            var data ='<div class="form-group row mb-0 pb-0">' +
                                        '<div class="col-md-2">' +
                                            '<label>'+label_type+'</label>' +
                                        '</div>' +
                                        '<div class="col-md-4">' +
                                            '<label>'+label_video+'</label>' +
                                        '</div>' +
                                    '</div>';
                            $('.after-add-more').append(data);
                        }

                        for (var i = 0; i < resp.result.length; i++) {
                            var data ='<div class="form-group row">' +
                                        '<div class="col-md-2">' +
                                            '<input type="text" class="form-control" name="type" value="'+ resp.result[i].type.name +'" placeholder="Dropdown" readonly/>' +
                                            '<input type="hidden" class="form-control" name="video_type" value=""/>' +
                                        '</div>' +
                                        '<div class="col-md-4">' +
                                            '<input type="text" class="form-control" name="video" value="'+ resp.result[i].video['name'] +'" id="video" placeholder="Dropdown" readonly/>' +
                                        '</div>' +
                                        '<div class="col-md-1 flex-grow-1 px-3">' +
                                            '<a onclick="DeleteBanner('+ resp.result[i].id +')" class="btn btn-danger remove" id="remove" title="'+ label_delete +'"><i class="fa-solid fa-trash-can fa-xl"></i></a>' +                                   
                                        '</div>' +
                                    '</div>';
                            $('.after-add-more').append(data);
                        }
                    },
                    error: function(XMLHttpRequest, textStatus, errorThrown) {
                        toastr.error(errorThrown, textStatus);
                    }
                });
            } else {
                $('.radio-row').show();
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: "POST",
                    data: {is_home_screen:Is_home_screen},
                    url: '{{ route("bannerList") }}',
                    success: function(resp) {

                        if(resp.result.length > 0){
                            var data ='<div class="form-group row mb-0 pb-0">' +
                                        '<div class="col-md-2">' +
                                            '<label>'+label_type+'</label>' +
                                        '</div>' +
                                        '<div class="col-md-4">' +
                                            '<label>'+label_video+'</label>' +
                                        '</div>' +
                                    '</div>';
                            $('.after-add-more').append(data);
                        }

                        for (var i = 0; i < resp.result.length; i++) {
                            var data ='<div class="form-group row">' +
                                        '<div class="col-md-2">' +
                                            '<input type="text" class="form-control" name="type" value="'+ resp.result[i].type.name +'" placeholder="Dropdown" readonly/>' +
                                            '<input type="hidden" class="form-control" name="video_type" value=""/>' +
                                        '</div>' +
                                        '<div class="col-md-4">' +
                                            '<input type="text" class="form-control" name="video" value="'+ resp.result[i].video.name +'" id="video" placeholder="Dropdown" readonly/>' +
                                        '</div>' +
                                        '<div class="col-md-1">' +
                                            '<a onclick="DeleteBanner('+ resp.result[i].id +')" class="btn btn-danger remove" id="remove" title="'+ label_delete +'"><i class="fa-solid fa-trash-can fa-xl"></i></a>' +                                   
                                        '</div>' +
                                    '</div>';
                            $('.after-add-more').append(data);
                        }
                    },
                    error: function(XMLHttpRequest, textStatus, errorThrown) {
                        toastr.error(errorThrown, textStatus);
                    }
                });
            };
        });

        // Delete Banner
        function DeleteBanner(id) {

            var Check_Admin = '<?php echo Check_Admin_Access(); ?>';
            if (Check_Admin == 1) {

                var url = "{{route('banner.destroy', '')}}"+"/"+id;
                
                $("#dvloader").show();
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: 'DELETE',
                    url:url,
                    success: function(resp) {
                        $("#dvloader").hide();
                        get_responce_message(resp, 'save_banner', '{{ route("banner.index") }}');
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