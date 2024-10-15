@extends('admin.layout.page-app')
@section('page_title', __('label.add_package'))

@section('content')
    @include('admin.layout.sidebar')

    <div class="right-content">
        @include('admin.layout.header')

        <div class="body-content">
            <!-- mobile title -->
            <h1 class="page-title-sm">{{__('label.add_package')}}</h1>

            <div class="border-bottom row mb-3">
                <div class="col-sm-10">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{__('label.dashboard')}}</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('package.index') }}">{{__('label.package')}}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{__('label.add_package')}}</li>
                    </ol>
                </div>
                <div class="col-sm-2 d-flex align-items-center justify-content-end">
                    <a href="{{ route('package.index') }}" class="btn btn-default mw-120" style="margin-top:-14px">{{__('label.package_list')}}</a>
                </div>
            </div>

            <div class="card custom-border-card mt-3">
                <form enctype="multipart/form-data" id="save_package">
                    <input type="hidden" name="id" value="">
                    <div class="form-row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>{{__('label.name')}}<span class="text-danger">*</span></label>
                                <input name="name" type="text" class="form-control" placeholder="{{__('label.enter_package_name')}}" autofocus>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>{{__('label.price')}}<span class="text-danger">*</span></label>
                                <input name="price" type="number" class="form-control" placeholder="{{__('label.enter_package_price')}}">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>{{__('label.package_time')}}<span class="text-danger">*</span></label>
                                <select class="form-control" id="validity_type" name="type">
                                    <option value="">{{__('label.select_type')}}</option>
                                    <option value="Month">{{__('label.month')}}</option>
                                    <option value="Year">{{__('label.year')}}</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3 mt-3">
                            <div class="form-group">
                                <select class="form-control time mt-3" id="time" name="time">
                                    <option value="">{{__('label.select_number')}}</option>
                                    @for($i=1; $i<=12; $i++) 
                                        <option value="{{$i}}">{{$i}}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>{{__('label.watch_on_tv')}}<span class="text-danger">*</span></label>
                                <div class="radio-group">
                                    <div class="custom-control custom-radio">
                                        <input type="radio" name="watch_on_laptop_tv" id="watch_on_laptop_tv_yes" class="custom-control-input" value="1" checked>
                                        <label class="custom-control-label" for="watch_on_laptop_tv_yes">{{__('label.yes')}}</label>
                                    </div>
                                    <div class="custom-control custom-radio">
                                        <input type="radio" name="watch_on_laptop_tv" id="watch_on_laptop_tv_no" class="custom-control-input" value="0">
                                        <label class="custom-control-label" for="watch_on_laptop_tv_no">{{__('label.no')}}</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>{{__('label.ads_free_content')}}<span class="text-danger">*</span></label>
                                <div class="radio-group">
                                    <div class="custom-control custom-radio">
                                        <input type="radio" name="ads_free_content" id="ads_free_content_yes" class="custom-control-input" value="1" checked>
                                        <label class="custom-control-label" for="ads_free_content_yes">{{__('label.yes')}}</label>
                                    </div>
                                    <div class="custom-control custom-radio">
                                        <input type="radio" name="ads_free_content" id="ads_free_content_no" class="custom-control-input" value="0">
                                        <label class="custom-control-label" for="ads_free_content_no">{{__('label.no')}}</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>{{__('label.no_of_device_sync')}}<span class="text-danger">*</span></label>
                                <input name="no_of_device_sync" type="number" value="1"  min="1" class="form-control" placeholder="{{__('label.enter_no_of_device_sync')}}">
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-3 mt-3">
                            <div class="form-group">
                                <label>{{__('label.android_product_package')}}<span class="text-danger">*</span></label>
                                <input name="android_product_package" type="text" class="form-control" placeholder="{{__('label.enter_android_product_package')}}">
                            </div>
                        </div>
                        <div class="col-md-3 mt-3">
                            <div class="form-group">
                                <label>{{__('label.ios_product_package')}}<span class="text-danger">*</span></label>
                                <input name="ios_product_package" type="text" class="form-control" placeholder="{{__('label.enter_ios_product_package')}}">
                            </div>
                        </div>
                        <div class="col-md-3 mt-3">
                            <div class="form-group">
                                <label>{{__('label.web_product_package')}}<span class="text-danger">*</span></label>
                                <input name="web_product_package" type="text" class="form-control" placeholder="{{__('label.enter_web_product_package')}}">
                            </div>
                        </div>
                    </div>
                    <div class="border-top pt-3 text-right">
                        <button type="button" class="btn btn-default mw-120" onclick="save_package()">{{__('label.save')}}</button>
                        <a href="{{route('package.index')}}" class="btn btn-cancel mw-120 ml-2">{{__('label.cancel')}}</a>
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('pagescript')
    <script>

        // Sidebar Scroll Down
        sidebar_down($(document).height());

        function save_package() {

            var Check_Admin = '<?php echo Check_Admin_Access(); ?>';
            if(Check_Admin == 1){

                var formData = new FormData($("#save_package")[0]);
                $("#dvloader").show();
                $.ajax({
                    type: 'POST',
                    url: '{{ route("package.store") }}',
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function(resp) {
                        $("#dvloader").hide();
                        get_responce_message(resp, 'save_package', '{{ route("package.index") }}');
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
            $('.time').hide();
        });

        $('#validity_type').on('click', function() {
            $('.time').show();
            var type = $("#validity_type").val()

            for (let i = 1; i <= 12; i++) {
                $(".time option[value=" + i + "]").show();
                $(".time option[value=" + i + "]").attr("selected", false);
            }

            if (type == "Month") {
                for (let i = 13; i <= 31; i++) {
                    $(".time option[value=" + i + "]").hide();
                }
            } else if (type == "Year") {
                for (let i = 2; i <= 31; i++) {
                    $(".time option[value=" + i + "]").hide();
                }
            } else {
                $('.time').hide();
            }
        })
    </script>
@endsection