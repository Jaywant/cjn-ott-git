@extends('producer.layout.page-app')
@section('page_title', __('label.tvshow_details'))

@section('content')
    @include('producer.layout.sidebar')

    <div class="right-content">
        @include('producer.layout.header')

        <div class="body-content">
            <!-- mobile title -->
            <h1 class="page-title-sm">{{__('label.tvshow_details')}}</h1>

            <div class="border-bottom row mb-3">
                <div class="col-sm-10">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('producer.dashboard') }}">{{__('label.dashboard')}}</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('ptvshow.index') }}">{{__('label.tv_shows')}}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{__('label.tvshow_details')}}</li>
                    </ol>
                </div>
                <div class="col-sm-2 d-flex align-items-center justify-content-end">
                    <a href="{{ route('ptvshow.index') }}" class="btn btn-default mw-150" style="margin-top: -14px;">{{__('label.tvshow_list')}}</a>
                </div>
            </div>

            <!-- First Counter -->
            <div class="row counter-row">
                <div class="col-6 col-sm-4 col-md col-lg-4 col-xl">
                    <div class="db-color-card color1-card">
                        <i class="fa-solid fa-thumbs-up fa-4x card-icon"></i>
                        <h2 class="counter">
                            <p class="p-0 m-0">{{$data['total_like'] ?? 0}}</p>
                            <span>{{__('label.likes')}}</span>
                        </h2>
                    </div>
                </div>
                <div class="col-6 col-sm-4 col-md col-lg-4 col-xl">
                    <div class="db-color-card color2-card">
                        <i class="fa-solid fa-eye fa-4x card-icon"></i>
                        <h2 class="counter">
                            <p class="p-0 m-0">{{$data['total_view'] ?? 0}}</p>
                            <span>{{__('label.views')}}</span>
                        </h2>
                    </div>
                </div>
                <div class="col-6 col-sm-4 col-md col-lg-4 col-xl">
                    <div class="db-color-card color3-card">
                        <i class="fa-solid fa-heart fa-4x card-icon"></i>
                        <h2 class="counter">
                            <p class="p-0 m-0">{{$total_bookmark ?? 0}}</p>
                            <span>{{__('label.bookmark')}}</span>
                        </h2>
                    </div>
                </div>
            </div>
            <!-- Second Counter -->
            <div class="row counter-row">
                <div class="col-6 col-sm-4 col-md col-lg-4 col-xl">
                    <div class="db-color-card color6-card">
                        <i class="fa-solid fa-comments fa-4x card-icon"></i>
                        <h2 class="counter">
                            <p class="p-0 m-0">{{$total_comment ?? 0}}</p>
                            <span>{{__('label.comments')}}</span>
                        </h2>
                    </div>
                </div>
                <div class="col-6 col-sm-4 col-md col-lg-4 col-xl">
                    <div class="db-color-card color7-card">
                        <i class="fa-solid fa-download fa-4x card-icon"></i>
                        <h2 class="counter">
                            <p class="p-0 m-0">{{$total_download ?? 0}}</p>
                            <span>{{__('label.download')}}</span>
                        </h2>
                    </div>
                </div>
                @if($data['is_rent'] == 1)
                <div class="col-6 col-sm-4 col-md col-lg-4 col-xl">
                    <div class="db-color-card color8-card">
                        <i class="fa-solid fa-sack-dollar fa-4x card-icon"></i>
                        <h2 class="counter">
                            <p class="p-0 m-0">{{$total_rent_earning ?? 0}}</p>
                            <span>{{__('label.rent_earning')}}</span>
                        </h2>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
@endsection