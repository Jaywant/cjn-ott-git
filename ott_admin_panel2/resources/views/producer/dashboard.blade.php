@extends('producer.layout.page-app')
@section('page_title', __('label.dashboard'))

@section('content')
    @include('producer.layout.sidebar')

    <div class="right-content">
        @include('producer.layout.header')

        <div class="body-content">
            <!-- mobile title -->
            <h1 class="page-title-sm">{{__('label.dashboard')}}</h1>

            <!-- First Counter -->
            <div class="row counter-row">
                <div class="col-6 col-sm-4 col-md col-lg-4 col-xl">
                    <div class="db-color-card color1-card">
                        <i class="fa-solid fa-video fa-4x card-icon"></i>
                        <div class="dropdown dropright">
                            <a href="#" class="btn head-btn" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa-solid fa-ellipsis-vertical fa-xl text-dark dot-icon mr-2"></i>
                            </a>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                <a class="dropdown-item color1-viewall" href="{{route('pvideo.index')}}">{{__('label.view_all')}}</a>
                            </div>
                        </div>
                        <h2 class="counter">
                            <p class="p-0 m-0 counting" data-count="{{No_Format($VideoCount ?? 0)}}">{{No_Format($VideoCount ?? 0)}}</p>
                            <span>{{__('label.videos')}}</span>
                        </h2>
                    </div>
                </div>
                <div class="col-6 col-sm-4 col-md col-lg-4 col-xl">
                    <div class="db-color-card color2-card">
                        <i class="fa-solid fa-tv fa-4x card-icon"></i>
                        <div class="dropdown dropright">
                            <a href="#" class="btn head-btn" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa-solid fa-ellipsis-vertical fa-xl text-dark dot-icon mr-2"></i>
                            </a>
                            <div class="dropdown-menu" ari0a-labelledby="dropdownMenuLink">
                                <a class="dropdown-item color2-viewall" href="{{ route('ptvshow.index')}}">{{__('label.view_all')}}</a>
                            </div>
                        </div>
                        <h2 class="counter">
                            <p class="p-0 m-0 counting" data-count="{{No_Format($TVShowCount ?? 0)}}">{{No_Format($TVShowCount ?? 0)}}</p>
                            <span>{{__('label.tv_shows')}}</span>
                        </h2>
                    </div>
                </div>
                <div class="col-6 col-sm-4 col-md col-lg-4 col-xl">
                    <div class="db-color-card color3-card">
                        <i class="fa-solid fa-film fa-4x card-icon"></i>
                        <div class="dropdown dropright">
                            <a href="#" class="btn head-btn" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa-solid fa-ellipsis-vertical fa-xl text-dark dot-icon mr-2"></i>
                            </a>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                <a class="dropdown-item color3-viewall" href="{{route('pchannel.index')}}">{{__('label.view_all')}}</a>
                            </div>
                        </div>
                        <h2 class="counter">
                            <p class="p-0 m-0 counting" data-count="{{No_Format($ChannelCount ?? 0)}}">{{No_Format($ChannelCount ?? 0)}}</p>
                            <span>{{__('label.channel')}}</span>
                        </h2>
                    </div>
                </div>
            </div>

            <!-- Most View Video & TVShow -->
            <div class="row mb-2">
                <div class="col-12 cart-bg">
                    <div class="box-title">
                        <h2 class="title"><i class="fa-solid fa-chart-bar fa-lg mr-2"></i>{{__('label.most_view_videos_tvshows')}}</h2>
                    </div>

                    <ul class="nav nav-pills custom-tabs" id="pills-tab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="pills-video-view-tab" data-toggle="pill" href="#pills-video-view" role="tab" aria-controls="pills-video-view" aria-selected="true">{{__('label.videos')}}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="pills-tvshow-view-tab" data-toggle="pill" href="#pills-tvshow-view" role="tab" aria-controls="pills-tvshow-view" aria-selected="false">{{__('label.tv_shows')}}</a>
                        </li>
                    </ul>

                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="pills-video-view" role="tabpanel" aria-labelledby="pills-video-view-tab">
                            <div class="summary-table-card">
                                @for ($i = 0; $i < count($top_video_view); $i++)
                                    <div class="border-card bg-white">
                                        <div class="row">
                                            <div class="col-1">
                                                {{$i + 1 .'.'}}
                                            </div>
                                            <div class="col-9">
                                                <span class="avatar-control">
                                                    <img src="{{$top_video_view[$i]['thumbnail']}}" style='height:40px; width:40px' />
                                                    {{String_Cut($top_video_view[$i]['name'],65)}}
                                                </span>
                                            </div>
                                            <div class="col-2 d-flex justify-content-start">
                                                <i class="fa-solid fa-eye mr-3 fa-xl primary-color"></i>     
                                                <p class="m-0 p-0 counting" data-count="{{No_Format($top_video_view[$i]['total_view'] ?? 00)}}"> {{No_Format($top_video_view[$i]['total_view'] ?? 00)}}</p>
                                            </div>
                                        </div>
                                    </div>
                                @endfor
                            </div>
                        </div>
                        <div class="tab-pane fade" id="pills-tvshow-view" role="tabpanel" aria-labelledby="pills-tvshow-view-tab">
                            <div class="summary-table-card">
                                @for ($i = 0; $i < count($top_tvshow_view); $i++)
                                    <div class="border-card bg-white">
                                        <div class="row">
                                            <div class="col-1">
                                                {{$i + 1 .'.'}}
                                            </div>
                                            <div class="col-9">
                                                <span class="avatar-control">
                                                    <img src="{{ $top_tvshow_view[$i]['thumbnail'] }}" style='height:40px; width:40px' />
                                                    {{String_Cut($top_tvshow_view[$i]['name'],65)}}
                                                </span>
                                            </div>
                                            <div class="col-2 d-flex justify-content-start">
                                                <i class="fa-solid fa-eye mr-3 fa-xl primary-color"></i>     
                                                <p class="m-0 p-0 counting" data-count="{{No_Format($top_tvshow_view[$i]['total_view'] ?? 00)}}"> {{No_Format($top_tvshow_view[$i]['total_view'] ?? 00)}}</p>
                                            </div>
                                        </div>
                                    </div>
                                @endfor
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Most Like Video & TVShow -->
            <div class="row mb-2">
                <div class="col-12 cart-bg">
                    <div class="box-title">
                        <h2 class="title"><i class="fa-solid fa-chart-bar fa-lg mr-2"></i>{{__('label.most_like_videos_tvshows')}}</h2>
                    </div>

                    <ul class="nav nav-pills custom-tabs" id="pills-tab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="pills-video-like-tab" data-toggle="pill" href="#pills-video-like" role="tab" aria-controls="pills-video-like" aria-selected="true">{{__('label.videos')}}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="pills-tvshow-like-tab" data-toggle="pill" href="#pills-tvshow-like" role="tab" aria-controls="pills-tvshow-like" aria-selected="false">{{__('label.tv_shows')}}</a>
                        </li>
                    </ul>

                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="pills-video-like" role="tabpanel" aria-labelledby="pills-video-like-tab">
                            <div class="summary-table-card">
                                @for ($i = 0; $i < count($top_video_like); $i++)
                                    <div class="border-card bg-white">
                                        <div class="row">
                                            <div class="col-1">
                                                {{$i + 1 .'.'}}
                                            </div>
                                            <div class="col-9">
                                                <span class="avatar-control">
                                                    <img src="{{$top_video_like[$i]['thumbnail']}}" style='height:40px; width:40px' />
                                                    {{String_Cut($top_video_like[$i]['name'],65)}}
                                                </span>
                                            </div>
                                            <div class="col-2 d-flex justify-content-start">
                                                <i class="fa-solid fa-thumbs-up mr-3 fa-xl primary-color"></i>     
                                                <p class="m-0 p-0 counting" data-count="{{No_Format($top_video_like[$i]['total_like'] ?? 00)}}"> {{No_Format($top_video_like[$i]['total_like'] ?? 00)}}</p>
                                            </div>
                                        </div>
                                    </div>
                                @endfor
                            </div>
                        </div>
                        <div class="tab-pane fade" id="pills-tvshow-like" role="tabpanel" aria-labelledby="pills-tvshow-like-tab">
                            <div class="summary-table-card">
                                @for ($i = 0; $i < count($top_tvshow_like); $i++)
                                    <div class="border-card bg-white">
                                        <div class="row">
                                            <div class="col-1">
                                                {{$i + 1 .'.'}}
                                            </div>
                                            <div class="col-9">
                                                <span class="avatar-control">
                                                    <img src="{{ $top_tvshow_like[$i]['thumbnail'] }}" style='height:40px; width:40px' />
                                                    {{String_Cut($top_tvshow_like[$i]['name'],65)}}
                                                </span>
                                            </div>
                                            <div class="col-2 d-flex justify-content-start">
                                                <i class="fa-solid fa-thumbs-up mr-3 fa-xl primary-color"></i>    
                                                <p class="m-0 p-0 counting" data-count="{{No_Format($top_tvshow_like[$i]['total_like'] ?? 00)}}"> {{No_Format($top_tvshow_like[$i]['total_like'] ?? 00)}}</p>
                                            </div>
                                        </div>
                                    </div>
                                @endfor
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('pagescript')
    <script>
    </script>
@endsection