@extends('producer.layout.page-app')
@section('page_title', __('label.episodes'))

@section('content')
    @include('producer.layout.sidebar')

    <div class="right-content">
        @include('producer.layout.header')

        <div class="body-content">
            <!-- mobile title -->
            <h1 class="page-title-sm">{{__('label.episodes')}}</h1>

            <div class="border-bottom row mb-3">
                <div class="col-sm-10">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('producer.dashboard') }}">{{__('label.dashboard')}}</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('ptvshow.index') }}">{{__('label.tv_shows')}}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{__('label.episodes')}}</li>
                    </ol>
                </div>
                <div class="col-sm-2 d-flex align-items-center justify-content-end">
                    <a href="{{ route('ptvshow.index') }}" class="btn btn-default mw-150" style="margin-top: -14px;">{{__('label.tv_shows')}}</a>
                </div>
            </div>

            <!-- Search -->
            <form action="{{ route('ptvshow.episode.index', ['id' => $tvshow_id]) }}" method="GET">
                <input type="hidden" name="show_id" id="show_id" value="{{$tvshow_id}}">
                <div class="page-search mb-3">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1">
                                <i class="fa-solid fa-magnifying-glass fa-xl light-gray"></i>
                            </span>
                        </div>
                        <input type="text" name="input_search" value="@if(isset($_GET['input_search'])){{$_GET['input_search']}}@endif" class="form-control" placeholder="{{__('label.search_episodes')}}" aria-label="Search" aria-describedby="basic-addon1">
                    </div>
                    <div class="sorting mr-3" style="width: 450px;">
                        <label>{{__('label.sort_by')}}</label>
                        <select class="form-control" name="input_season">
                            <option value="0" selected>{{__('label.all_season')}}</option>
                            @for ($i = 0; $i < count($season); $i++) 
                            <option value="{{ $season[$i]['id'] }}" @if(isset($_GET['input_season'])){{ $_GET['input_season'] == $season[$i]['id'] ? 'selected' : ''}} @endif>
                                {{ $season[$i]['name'] }}
                            </option>
                            @endfor
                        </select>
                    </div>
                    <div class="mr-3 ml-5">
                        <button class="btn btn-default" type="submit">{{__('label.search')}}</button>
                    </div>
                    <div class="mr-3 ml-5" title="{{__('label.sortable')}}">
                        <button type="button" data-toggle="modal" data-target="#exampleModal" class="btn btn-default" style="border-radius: 10px;">
                            <i class="fa-solid fa-sort fa-2x"></i>
                        </button>
                    </div>
                </div>
            </form>

            <div class="row">
                <div class="col-12 col-sm-6 col-md-4 col-xl-3">
                    <a href="{{ route('ptvshow.episode.add', ['id' => $tvshow_id]) }}" class="add-video-btn" title="{{__('label.add_episode')}}">
                        <i class="fa-regular fa-square-plus fa-3x icon" style="color: #818181;"></i>
                        {{__('label.add_new_episode')}}
                    </a>
                </div>

                @foreach ($data as $key => $value)
                <div class="col-12 col-sm-6 col-md-4 col-xl-3">
                    <div class="card video-card">
                        <div class="position-relative">

                            @if($value->is_premium == 1)
                                <div class="ribbon ribbon-top-left"><span>{{__('label.premium')}}</span></div>
                            @endif

                            <img class="card-img-top" src="{{$value->thumbnail}}" alt="">
                            @if($value->video_upload_type == "server_video")
                            <button class="btn play-btn-top video" data-toggle="modal" data-target="#videoModal" data-video="{{$value->video_320}}" data-image="{{$value->landscape}}">
                                <i class="fa-regular fa-circle-play text-white fa-4x mr-2 mt-2"></i>
                            </button>
                            @endif

                            <ul class="list-inline overlap-control" aria-labelledby="dropdownMenuLink">
                                <li class="list-inline-item">
                                    <a class="btn" href="{{ route('ptvshow.episode.edit', ['tvshow_id' => $value->show_id, 'id' => $value->id])}}" title="{{__('label.edit')}}">
                                        <i class="fa-solid fa-pen-to-square fa-xl" class="dot-icon" style="color: #4e45b8;"></i>
                                    </a>
                                </li>
                                <li class="list-inline-item">
                                    <a class="btn" href="{{ route('ptvshow.episode.delete', ['tvshow_id' => $value->show_id, 'id' => $value->id])}}" title="{{__('label.delete')}}" onclick="return confirm('{{__('label.delete_episode')}}')">
                                        <i class="fa-solid fa-trash-can fa-xl" class="dot-icon" style="color: #4e45b8;"></i>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">{{$value->name}}</h5>
                            <div class="d-flex justify-content-between">
                                <p class="card-text">
                                    <?php
                                        if (isset($value->season->name)) {echo $value->season->name;}
                                    ?>
                                </p>
                                <div class="d-flex text-align-center">
                                    <span class="d-flex text-align-center mr-3">
                                        <i class="fa-solid fa-thumbs-up fa-xl mr-3" style="color:#4e45b8; margin-top:12px"></i>
                                        <h5 class="counting" data-count="{{No_Format($value->total_like ?? 0)}}">{{No_Format($value->total_like)}}</h5>
                                    </span>
                                    <span class="d-flex text-align-center">
                                        <i class="fa-regular fa-eye fa-xl mr-3" style="color:#4e45b8; margin-top:12px"></i>
                                        <h5 class="counting" data-count="{{No_Format($value->total_view ?? 0)}}">{{No_Format($value->total_view)}}</h5>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Video Modal -->
            <div class="modal fade" id="videoModal" tabindex="-1" data-backdrop="static" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg">
                    <div class="modal-content">
                        <div class="modal-body p-0 bg-transparent">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="close">
                                <span aria-hidden="true" class="text-dark">&times;</span>
                            </button>
                            <video controls width="800" height="500" preload='none' poster="" id="theVideo" controlsList="nodownload noplaybackrate" disablepictureinpicture>
                                <source src="" type="video/mp4">
                            </video>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sortable Modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" data-backdrop="static" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title w-100 text-center" id="exampleModalLabel">{{__('label.episode_sortable_list')}}</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="close">
                                <span aria-hidden="true" class="text-dark">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div id="imageListId">
                                @foreach ($data as $key => $value)
                                <div id="{{$value->id}}" class="listitemClass mb-2" style="background-color: #e9ecef;border: 1px solid black;cursor: s-resize;">
                                    <p class="m-3">{{$value->name}}</p>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="modal-footer justify-content-center">
                            <form enctype="multipart/form-data" id="save_episode_sortable">
                                @csrf
                                <input id="outputvalues" type="hidden" name="ids" value="" />
                                <div class="w-100 text-center">
                                    <button type="button" class="btn btn-default mw-120" onclick="save_episode_sortable()">{{__('label.save')}}</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-between align-items-center">
                <div> Showing {{ $data->firstItem() }} to {{ $data->lastItem() }} of total {{$data->total()}} entries </div>
                <div class="pb-5"> {{ $data->links() }} </div>
            </div>
        </div>
    </div>
@endsection

@section('pagescript')
    <script>
        $(function() {
            $(".video").click(function() {
                var theModal = $(this).data("target"),
                    videoSRC = $(this).attr("data-video"),
                    videoPoster = $(this).attr("data-image"),
                    videoSRCauto = videoSRC + "";

                $(theModal + ' source').attr('src', videoSRCauto);
                $(theModal + ' video').attr('poster', videoPoster);
                $(theModal + ' video').load();

                $(theModal + ' button.close').click(function() {
                    $(theModal + ' source').attr('src', videoSRC);
                });
            });
        });
        $("#videoModal .close").click(function() {
            theVideo.pause()
        });

        $("#imageListId").sortable({
            update: function(event, ui) {
                getIdsOfImages();
            }
        });
        function getIdsOfImages() {
            var values = [];
            $('.listitemClass').each(function(index) {
                values.push($(this).attr("id")
                    .replace("imageNo", ""));
            });
            $('#outputvalues').val(values);
        }

        function save_episode_sortable() {
            var Check_Admin = '<?php echo Check_Admin_Access(); ?>';
            if(Check_Admin == 1){

                $("#dvloader").show();
                var formData = new FormData($("#save_episode_sortable")[0]);
                $.ajax({
                    type: 'POST',
                    url: '{{ route("ptvshow.episode.sortable") }}',
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function(resp) {
                        $("#dvloader").hide();
                        get_responce_message(resp, 'save_episode_sortable', '{{ route("ptvshow.episode.index",["id" => $tvshow_id]) }}');
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