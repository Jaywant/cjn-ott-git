@extends('admin.layout.page-app')
@section('page_title', __('label.dashboard'))

@section('content')
    @include('admin.layout.sidebar')

    <div class="right-content">
        @include('admin.layout.header')

        <div class="body-content">
            <!-- mobile title -->
            <h1 class="page-title-sm">{{__('label.dashboard')}}</h1>

            <!-- First Counter -->
            <div class="row counter-row">
                <div class="col-6 col-sm-4 col-md col-lg-4 col-xl">
                    <div class="db-color-card color1-card">
                        <i class="fa-solid fa-users fa-4x card-icon"></i>
                        <div class="dropdown dropright">
                            <a href="#" class="btn head-btn" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa-solid fa-ellipsis-vertical fa-xl text-dark dot-icon mr-2"></i>
                            </a>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                <a class="dropdown-item color1-viewall" href="{{ route('user.index')}}">{{__('label.view_all')}}</a>
                            </div>
                        </div>
                        <h2 class="counter">
                            <p class="p-0 m-0 counting" data-count="{{No_Format($UserCount ?? 0)}}">{{No_Format($UserCount ?? 0)}}</p>
                            <span>{{__('label.users')}}</span>
                        </h2>
                    </div>
                </div>
                <div class="col-6 col-sm-4 col-md col-lg-4 col-xl">
                    <div class="db-color-card color2-card">
                        <i class="fa-solid fa-video fa-4x card-icon"></i>
                        <div class="dropdown dropright">
                            <a href="#" class="btn head-btn" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa-solid fa-ellipsis-vertical fa-xl text-dark dot-icon mr-2"></i>
                            </a>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                <a class="dropdown-item color2-viewall" href="{{route('video.index')}}">{{__('label.view_all')}}</a>
                            </div>
                        </div>
                        <h2 class="counter">
                            <p class="p-0 m-0 counting" data-count="{{No_Format($VideoCount ?? 0)}}">{{No_Format($VideoCount ?? 0)}}</p>
                            <span>{{__('label.videos')}}</span>
                        </h2>
                    </div>
                </div>
                <div class="col-6 col-sm-4 col-md col-lg-4 col-xl">
                    <div class="db-color-card color3-card">
                        <i class="fa-solid fa-tv fa-4x card-icon"></i>
                        <div class="dropdown dropright">
                            <a href="#" class="btn head-btn" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa-solid fa-ellipsis-vertical fa-xl text-dark dot-icon mr-2"></i>
                            </a>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                <a class="dropdown-item color3-viewall" href="{{ route('tvshow.index')}}">{{__('label.view_all')}}</a>
                            </div>
                        </div>
                        <h2 class="counter">
                            <p class="p-0 m-0 counting" data-count="{{No_Format($TVShowCount ?? 0)}}">{{No_Format($TVShowCount ?? 0)}}</p>
                            <span>{{__('label.tv_shows')}}</span>
                        </h2>
                    </div>
                </div>
                <div class="col-6 col-sm-4 col-md col-lg-4 col-xl">
                    <div class="db-color-card color4-card">
                        <i class="fa-solid fa-film fa-4x card-icon"></i>
                        <div class="dropdown dropright">
                            <a href="#" class="btn head-btn" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa-solid fa-ellipsis-vertical fa-xl text-dark dot-icon mr-2"></i>
                            </a>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                <a class="dropdown-item color4-viewall" href="{{route('channel.index')}}">{{__('label.view_all')}}</a>
                            </div>
                        </div>
                        <h2 class="counter">
                            <p class="p-0 m-0 counting" data-count="{{No_Format($ChannelCount ?? 0)}}">{{No_Format($ChannelCount ?? 0)}}</p>
                            <span>{{__('label.channel')}}</span>
                        </h2>
                    </div>
                </div>
                <div class="col-6 col-sm-4 col-md col-lg-4 col-xl">
                    <div class="db-color-card color5-card">
                        <i class="fa-solid fa-user-tie fa-4x card-icon"></i>
                        <div class="dropdown dropright">
                            <a href="#" class="btn head-btn" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa-solid fa-ellipsis-vertical fa-xl text-dark dot-icon mr-2"></i>
                            </a>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                <a class="dropdown-item color5-viewall" href="{{route('cast.index')}}">{{__('label.view_all')}}</a>
                            </div>
                        </div>
                        <h2 class="counter">
                            <p class="p-0 m-0 counting" data-count="{{No_Format($CastCount ?? 0)}}">{{No_Format($CastCount ?? 0)}}</p>
                            <span>{{__('label.cast')}}</span>
                        </h2>
                    </div>
                </div>
            </div>
            <!-- Second Counter -->
            <div class="row counter-row">
                <div class="col-6 col-sm-4 col-md col-lg-4 col-xl">
                    <div class="db-color-card color6-card">
                        <i class="fa-solid fa-money-bill-1 fa-4x card-icon"></i>
                        <div class="dropdown dropright">
                            <a href="#" class="btn head-btn" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa-solid fa-ellipsis-vertical fa-xl text-dark dot-icon mr-2"></i>
                            </a>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                <a class="dropdown-item color6-viewall" href="{{ route('transaction.index') }}">{{__('label.view_all')}}</a>
                            </div>
                        </div>
                        <h2 class="counter mt-4">
                            <p class="p-0 m-0 counting" data-count="{{No_Format($CurrentMounthCount ?? 00)}}">{{No_Format($CurrentMounthCount ?? 00)}}</p>
                            <span style="font-size: 20px;">{{__('label.monthly_package_earnings')}} ({{Currency_Code()}})</span>
                        </h2>
                    </div>
                </div>
                <div class="col-6 col-sm-4 col-md col-lg-4 col-xl">
                    <div class="db-color-card color7-card">
                        <i class="fa-solid fa-money-bill fa-4x card-icon"></i>
                        <div class="dropdown dropright">
                            <a href="#" class="btn head-btn" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa-solid fa-ellipsis-vertical fa-xl text-dark dot-icon mr-2"></i>
                            </a>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                <a class="dropdown-item color7-viewall" href="{{ route('transaction.index') }}">{{__('label.view_all')}}</a>
                            </div>
                        </div>
                        <h2 class="counter mt-4">
                            <p class="p-0 m-0 counting" data-count="{{No_Format($TransactionCount ?? 00)}}">{{No_Format($TransactionCount?? 00)}}</p>
                            <span>{{__('label.package_earnings')}} ({{Currency_Code()}})</span>
                        </h2>
                    </div>
                </div>
                <div class="col-6 col-sm-4 col-md col-lg-4 col-xl">
                    <div class="db-color-card color8-card">
                        <i class="fa-solid fa-box-archive fa-4x card-icon"></i>
                        <div class="dropdown dropright">
                            <a href="#" class="btn head-btn" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa-solid fa-ellipsis-vertical fa-xl text-dark dot-icon mr-2"></i>
                            </a>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                <a class="dropdown-item color8-viewall" href="{{ route('package.index') }}">{{__('label.view_all')}}</a>
                            </div>
                        </div>
                        <h2 class="counter">
                            <p class="p-0 m-0 counting" data-count="{{No_Format($PackageCount ?? 00)}}">{{No_Format($PackageCount ?? 00)}}</p>
                            <span>{{__('label.package')}}</span>
                        </h2>
                    </div>
                </div>
                <div class="col-6 col-sm-4 col-md col-lg-4 col-xl">
                    <div class="db-color-card color9-card">
                        <i class="fa-solid fa-money-bill-1-wave fa-4x card-icon"></i>
                        <div class="dropdown dropright">
                            <a href="#" class="btn head-btn" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa-solid fa-ellipsis-vertical fa-xl text-dark dot-icon mr-2"></i>
                            </a>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                <a class="dropdown-item color9-viewall" href="{{ route('renttransaction.index') }}">{{__('label.view_all')}}</a>
                            </div>
                        </div>
                        <h2 class="counter mt-4">
                            <p class="p-0 m-0 counting" data-count="{{No_Format($CurrentMounthRentCount ?? 00)}}">{{No_Format($CurrentMounthRentCount ?? 00)}}</p>
                            <span>{{__('label.monthly_rent_earnings')}} ({{Currency_Code()}})</span>
                        </h2>
                    </div>
                </div>
                <div class="col-6 col-sm-4 col-md col-lg-4 col-xl">
                    <div class="db-color-card color10-card">
                        <i class="fa-solid fa-money-bill-wave fa-4x card-icon"></i>
                        <div class="dropdown dropright">
                            <a href="#" class="btn head-btn" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa-solid fa-ellipsis-vertical fa-xl text-dark dot-icon mr-2"></i>
                            </a>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                <a class="dropdown-item color10-viewall" href="{{ route('renttransaction.index') }}">{{__('label.view_all')}}</a>
                            </div>
                        </div>
                        <h2 class="counter mt-4">
                            <p class="p-0 m-0 counting" data-count="{{No_Format($RentTransactionCount ?? 00)}}">{{No_Format($RentTransactionCount ?? 00)}}</p>
                            <span>{{__('label.rent_earnings')}}({{Currency_Code()}})</span>
                        </h2>
                    </div>
                </div>
            </div>

            <!-- Join User Statistice && Rent Earning Statistice -->
            <div class="row mb-2">
                <div class="col-12 col-xl-8 cart-bg">
                    <div class="box-title">
                        <h2 class="title"><i class="fa-solid fa-chart-column fa-lg mr-2"></i>{{__('label.join_users_statistice_current_year')}}</h2>
                        <a href="{{ route('user.index') }}" class="btn btn-link">{{__('label.view_all')}}</a>
                    </div>
                    <div class="row mt-2 mb-2">
                        <div class="col-12 col-sm-12">
                            <Button id="year" class="btn btn-default">{{__('label.this_year')}}</Button>
                            <Button id="month" class="btn btn-default">{{__('label.this_month')}}</Button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-sm-12">
                            <canvas id="UserChart" width="100%" height="40px"></canvas>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-xl-4">
                    <div class="video-box pb-2">
                        <div class="box-title mt-0">
                            <h2 class="title"><i class="fa-solid fa-chart-pie fa-lg mr-2"></i>{{__('label.rent_earning_current_year')}}</h2>
                            <a href="{{ route('renttransaction.index') }}" class="btn btn-link">{{__('label.view_all')}}</a>
                        </div>
                        <div class="summary-table-card mt-2">
                            <canvas id="rent_earning" width="566" height="800" style="display: block; width: 283px; height: 400px;"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Plan Earning Statistice && Best Category -->
            <div class="row mb-2">
                <div class="col-12 col-xl-8 cart-bg">
                    <div class="box-title">
                        <h2 class="title"><i class="fa-solid fa-chart-column fa-lg mr-2"></i>{{__('label.plan_earning_statistice_current_year')}}</h2>
                        <a href="{{ route('transaction.index') }}" class="btn btn-link">{{__('label.view_all')}}</a>
                    </div>
                    <div class="row">
                        <div class="col-12 col-sm-12">
                            <canvas id="MyChart" width="100%" height="40px"></canvas>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-xl-4">
                    <div class="category-box">
                        <div class="box-title mt-0">
                            <h2 class="title"><i class="fa-solid fa-table-cells-large fa-lg mr-2"></i>{{__('label.best_category')}}</h2>
                            <a href="{{ route('category.index')}}" class="btn btn-link">{{__('label.view_all')}}</a>
                        </div>
                        <div class="pt-3 mt-0">
                            <div class="row pr-3">
                                @for ($i = 0; $i < count($best_category); $i++)
                                    @if($i > 0 && (($i % 4) == 1 || ($i % 4) == 2))
                                        <div class="col-5 mb-2 pr-0">
                                            <img src="{{$best_category[$i]['image']}}" class="category-image">
                                            <div class="centered">{{$best_category[$i]['name']}}</div>
                                        </div>
                                        @else
                                        <div class="col-7 mb-2 pr-0">
                                            <img src="{{$best_category[$i]['image']}}" class="category-image">
                                            <div class="centered">{{$best_category[$i]['name']}}</div>
                                        </div>
                                    @endif
                                @endfor
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Most View Video & TVShow && Best Channel -->
            <div class="row mb-2">
                <div class="col-12 col-xl-8 cart-bg">
                    <div class="box-title">
                        <h2 class="title"><i class="fa-solid fa-chart-bar fa-lg mr-2"></i>{{__('label.most_view_video_&_tv_show')}}</h2>
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

                <div class="col-12 col-xl-4">
                    <div class="category-box">
                        <div class="box-title mt-0">
                            <h2 class="title"><i class="fa-solid fa-table-cells-large fa-lg mr-2"></i>{{__('label.best_channel')}}</h2>
                            <a href="{{ route('channel.index')}}" class="btn btn-link">{{__('label.view_all')}}</a>
                        </div>
                        <div class="pt-3 mt-0">
                            <div class="row pr-3">
                                @for ($i = 0; $i < count($best_channel); $i++)
                                    @if($i > 0 && (($i % 4) == 1 || ($i % 4) == 2))
                                        <div class="col-5 mb-2 pr-0">
                                            <img src="{{$best_channel[$i]['portrait_img']}}" class="category-image">
                                            <div class="centered">{{$best_channel[$i]['name']}}</div>
                                        </div>
                                        @else
                                        <div class="col-7 mb-2 pr-0">
                                            <img src="{{$best_channel[$i]['portrait_img']}}" class="category-image">
                                            <div class="centered">{{$best_channel[$i]['name']}}</div>
                                        </div>
                                    @endif
                                @endfor
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Most Like Video & TVShow && Best Language -->
            <div class="row mb-2">
                <div class="col-12 col-xl-8 cart-bg">
                    <div class="box-title">
                        <h2 class="title"><i class="fa-solid fa-chart-bar fa-lg mr-2"></i>{{__('label.most_like_content')}}</h2>
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

                <div class="col-12 col-xl-4">
                    <div class="category-box">
                        <div class="box-title mt-0">
                            <h2 class="title"><i class="fa-solid fa-table-cells-large fa-lg mr-2"></i>{{__('label.best_language')}}</h2>
                            <a href="{{ route('language.index')}}" class="btn btn-link">{{__('label.view_all')}}</a>
                        </div>
                        <div class="pt-3 mt-0">
                            <div class="row pr-3">
                                @for ($i = 0; $i < count($best_language); $i++)
                                    @if($i > 0 && (($i % 4) == 1 || ($i % 4) == 2))
                                        <div class="col-5 mb-2 pr-0">
                                            <img src="{{$best_language[$i]['image']}}" class="category-image">
                                            <div class="centered">{{$best_language[$i]['name']}}</div>
                                        </div>
                                        @else
                                        <div class="col-7 mb-2 pr-0">
                                            <img src="{{$best_language[$i]['image']}}" class="category-image">
                                            <div class="centered">{{$best_language[$i]['name']}}</div>
                                        </div>
                                    @endif
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
        var month = ["{{__('label.january')}}", "{{__('label.february')}}", "{{__('label.march')}}", "{{__('label.april')}}", "{{__('label.may')}}", "{{__('label.june')}}", 
        "{{__('label.july')}}", "{{__('label.august')}}", "{{__('label.september')}}", "{{__('label.october')}}", "{{__('label.november')}}", "{{__('label.december')}}"];

        // User Statistice
        var cData = JSON.parse(`<?php echo $user_year; ?>`);
        var ctx = $("#UserChart");
        var data = {
            labels: month,
            datasets: [{
                label: "{{__('label.users')}}",
                data: cData['sum'],
                backgroundColor: '#4e45b8',
            }],
        };
        var options = {
            responsive: true,
            legend: {
                title: "text",
                display: true,
                position: 'top',
                labels: {
                    fontSize: 16,
                    fontColor: "#000000",
                }
            },
            scales: {
                yAxes: [{
                    scaleLabel: {
                        display: true,
                        labelString: "{{__('label.total_count')}}",
                        fontSize: 16,
                        fontColor: "#000000",
                    },
                }],
                xAxes: [{
                    scaleLabel: {
                        display: true,
                        labelString: "{{__('label.month')}}",
                        fontSize: 16,
                        fontColor: "#000000",
                    }
                }]
            }
        };
        var chart1 = new Chart(ctx, {
            type: "bar",
            data: data,
            options: options
        });
        $("#year").on("click", function() {
            chart1.destroy();

            chart1 = new Chart(ctx, {
                type: "bar",
                data: data,
                options: options

            });
        });
        $("#month").on("click", function() {

            var date = new Date();
            var currentYear = date.getFullYear();
            var currentMonth = date.getMonth() + 1;
            const getDays = (year, month) => new Date(year, month, 0).getDate();
            const days = getDays(currentYear, currentMonth);

            var all1 = [];
            for (let i = 0; i < days; i++) {
                all1.push(i + 1);
            }

            chart1.destroy();
            var cData = JSON.parse(`<?php echo $user_month ?>`);

            var data = {
                labels: all1,
                datasets: [{
                    label: "{{__('label.users')}}",
                    data: cData['sum'],
                    backgroundColor: '#4e45b8',
                }],
            };
            var options = {
                responsive: true,
                legend: {
                    title: "text",
                    display: true,
                    position: 'top',
                    labels: {
                        fontSize: 16,
                        fontColor: "#000000",
                    }
                },
                scales: {
                    yAxes: [{
                        scaleLabel: {
                            display: true,
                            labelString: "{{__('label.total_count')}}",
                            fontSize: 16,
                            fontColor: "#000000",
                        },
                    }],
                    xAxes: [{
                        scaleLabel: {
                            display: true,
                            labelString: "{{__('label.month')}}",
                            fontSize: 16,
                            fontColor: "#000000",
                        }
                    }]
                }
            };
            chart1 = new Chart(ctx, {
                type: "bar",
                data: data,
                options: options,
            });
        });

        // Plan Earning Statistice
        $(function() {
            //get the pie chart canvas
            var cData = JSON.parse(`<?php echo $package; ?>`);
            var ctx = $("#MyChart");
            var backcolor = ["#4e45b8", "#0b284d", "#173325", "#360331", "#2A445E", "#9b19f5", "#00bfa0", "#6D3A74", "#0a3603",  "#441552", "#349beb", "#b30000"];
            const datasetValue = [];
            for (let i = 0; i < cData['label'].length; i++) {
                datasetValue[i] = {
                    label: cData['label'][i],
                    data: cData['sum'][i],
                    backgroundColor: backcolor[i],
                }
            }
            //bar chart data
            var data = {
                labels: month,
                datasets: datasetValue
            };
            //options
            var options = {
                responsive: true,
                legend: {
                    title: "text",
                    display: true,
                    position: 'top',
                    labels: {
                        fontSize: 16,
                        fontColor: "#000000",
                    }
                },
                scales: {
                    yAxes: [{
                        scaleLabel: {
                            display: true,
                            labelString: "{{__('label.amount')}}",
                            fontSize: 16,
                            fontColor: "#000000",
                        },
                    }],
                    xAxes: [{
                        scaleLabel: {
                            display: true,
                            labelString: "{{__('label.month')}}",
                            fontSize: 16,
                            fontColor: "#000000",
                        }
                    }]
                }
            };
            //create bar Chart class object
            var chart1 = new Chart(ctx, {
                type: "bar",
                data: data,
                options: options
            });
        });

        // Rent Earning Statistice
        var rent_ctx = document.getElementById("rent_earning");
        var rent_cData = JSON.parse(`<?php echo $rent_earning; ?>`);
        var rent_Chart = new Chart(rent_ctx, {
            type: 'doughnut',
            data: {
                labels: month,
                datasets: [{
                    data: rent_cData['sum'], // Specify the data values array
                    backgroundColor: ['#FF6384', '#4BC0C0', '#FFCD56', '#B04645', '#35B03B', '#36A2EB', '#E007F0', '#9966FF','#FF9F40', '#E04714', '#A19135', '#E876D3'], // Add custom color background (Points and Fill)
                    borderWidth: 1 // Specify bar border width
                }]},         
            options: {
                responsive: true, // Instruct chart js to respond nicely.
                maintainAspectRatio: false, // Add to prevent default behaviour of full-width/height 
                legend: {
                    title: "text",
                    display: true,
                    position: 'bottom',
                    labels: {
                        fontSize: 11,
                        fontColor: "#000000",
                    }
                },
            }
        });
    </script>
@endsection