@extends('producer.layout.page-app')
@section('page_title', __('label.channel_videos'))

@section('content')
    @include('producer.layout.sidebar')

    <div class="right-content">
        @include('producer.layout.header')

        <div class="body-content">
            <!-- mobile title -->
            <h1 class="page-title-sm">{{__('label.channel_videos')}}</h1>

            <div class="border-bottom row mb-3">
                <div class="col-sm-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('producer.dashboard') }}">{{__('label.dashboard')}}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{__('label.channel_videos')}}</li>
                    </ol>
                </div>
            </div>

            <!-- Search -->
            <form action="{{route('pch_video.index')}}" method="GET">
                <div class="page-search mb-3">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1">
                                <i class="fa-solid fa-magnifying-glass fa-xl light-gray"></i>
                            </span>
                        </div>
                        <input type="text" name="input_search" value="@if(isset($_GET['input_search'])){{$_GET['input_search']}}@endif" class="form-control" placeholder="{{__('label.search_videos')}}" aria-label="Search" aria-describedby="basic-addon1">
                    </div>
                    <div class="sorting mr-3" style="width: 60%;">
                        <label>{{__('label.sort_by')}}</label>
                        <select class="form-control" name="input_channel" id="input_channel">
                            <option value="0" selected>{{__('label.all_channel')}}</option>
                            @for ($i = 0; $i < count($channel); $i++) 
                                <option value="{{ $channel[$i]['id'] }}" @if(isset($_GET['input_channel'])){{ $_GET['input_channel'] == $channel[$i]['id'] ? 'selected' : ''}} @endif>
                                    {{ $channel[$i]['name'] }}
                                </option>
                            @endfor
                        </select>
                    </div>
                    <div class="sorting mr-3" style="width: 50%;">
                        <label>{{__('label.sort_by')}}</label>
                        <select class="form-control" name="input_type">
                            <option value="0" selected>{{__('label.all_type')}}</option>
                            @for ($i = 0; $i < count($type); $i++) 
                                <option value="{{ $type[$i]['id'] }}" @if(isset($_GET['input_type'])){{ $_GET['input_type'] == $type[$i]['id'] ? 'selected' : ''}} @endif>
                                    {{ $type[$i]['name'] }}
                                </option>
                            @endfor
                        </select>
                    </div>
                    <div class="sorting" style="width: 40%;">
                        <label>{{__('label.sort_by')}}</label>
                        <select class="form-control" name="input_rent">
                            <option value="0" @if(isset($_GET['input_rent'])){{ $_GET['input_rent'] == 0 ? 'selected' : ''}} @endif>{{__('label.all_video')}}</option>
                            <option value="1" @if(isset($_GET['input_rent'])){{ $_GET['input_rent'] == 1 ? 'selected' : ''}} @endif>{{__('label.rent_video')}}</option>
                        </select>
                    </div>
                    <div class="mr-3 ml-5">
                        <button class="btn btn-default" type="submit">{{__('label.search')}}</button>
                    </div>
                </div>
            </form>

            <div class="row">
                <div class="col-12 col-sm-6 col-md-4 col-xl-3" title="{{__('label.add_video')}}">
                    <a href="{{ route('pch_video.create') }}" class="add-video-btn">
                        <i class="fa-regular fa-square-plus fa-3x icon" style="color: #818181;"></i>
                        {{__('label.add_new_video')}}
                    </a>
                </div>

                @foreach ($result as $key => $value)
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
                                    <a class="btn" href="{{route('pch_video.details', [$value->id])}}" title="{{__('label.statistics')}}">
                                        <i class="fa-solid fa-chart-line fa-xl" class="dot-icon" style="color: #4e45b8;"></i>
                                    </a>
                                </li>
                                <li class="list-inline-item">
                                    <a class="btn" href="{{route('pch_video.edit', [$value->id])}}" title="{{__('label.edit')}}">
                                        <i class="fa-solid fa-pen-to-square fa-xl" class="dot-icon" style="color: #4e45b8;"></i>
                                    </a>
                                </li>
                                <li class="list-inline-item">
                                    <a class="btn" href="{{route('pch_video.show', [$value->id])}}" title="{{__('label.delete')}}" onclick="return confirm('{{__('label.delete_video')}}')">
                                        <i class="fa-solid fa-trash-can fa-xl" class="dot-icon" style="color: #4e45b8;"></i>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">{{$value->name}}</h5>
                            <div class="d-flex justify-content-between">
                                @if($value->status == 1)
                                <button class="btn btn-sm" style="background:#058f00; font-weight:bold; border: none; color: white;">{{__('label.show')}}</button>
                                @elseif($value->status == 0)
                                <button class="btn btn-sm" style="background:#e3000b; font-weight:bold; border: none; color: white;">{{__('label.hide')}}</button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Model -->
            <div class="modal fade" id="videoModal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg">
                    <div class="modal-content">
                        <div class="modal-body p-0 bg-transparent">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true" class="text-dark">&times;</span>
                            </button>
                            <video controls width="800" height="500" preload='none' poster="" id="theVideo" controlsList="nodownload noplaybackrate" disablepictureinpicture>
                                <source src="" type="video/mp4">
                            </video>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-between align-items-center">
                <div> Showing {{ $result->firstItem() }} to {{ $result->lastItem() }} of total {{$result->total()}} entries </div>
                <div class="pb-5"> {{ $result->links() }} </div>
            </div>
        </div>
    </div>
@endsection

@section('pagescript')
    <script>
        $("#input_channel").select2();

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
    </script>
@endsection