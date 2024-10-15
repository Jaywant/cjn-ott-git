@extends('producer.layout.page-app')
@section('page_title', __('label.profile'))

@section('content')
	@include('producer.layout.sidebar')

	<div class="right-content">
		@include('producer.layout.header')

		<div class="body-content">
			<!-- mobile title -->
			<h1 class="page-title-sm">{{__('label.profile')}}</h1>

			<div class="border-bottom row mb-3">
				<div class="col-sm-12">
					<ol class="breadcrumb">
						<li class="breadcrumb-item"><a href="{{ route('producer.dashboard') }}">{{__('label.dashboard')}}</a></li>
						<li class="breadcrumb-item active" aria-current="page">{{__('label.profile')}}</li>
					</ol>
				</div>
			</div>

            <div class="card custom-border-card">
                <form id="profile" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="@if($data){{$data->id}}@endif">
                    <div class="form-row">
                        <div class="col-md-9">
                            <div class="form-row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>{{__('label.user_name')}}<span class="text-danger">*</span></label>
                                        <input type="text" name="user_name" value="@if($data){{$data->user_name}}@endif" class="form-control" placeholder="{{__('label.enter_user_name')}}" autofocus>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>{{__('label.full_name')}}<span class="text-danger">*</span></label>
                                        <input type="text" name="full_name" value="@if($data){{$data->full_name}}@endif" class="form-control" placeholder="{{__('label.enter_full_name')}}">
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>{{__('label.email')}}<span class="text-danger">*</span></label>
                                        <input type="email" name="email" value="@if($data){{$data->email}}@endif" class="form-control" placeholder="{{__('label.enter_email')}}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>{{__('label.mobile_number')}}<span class="text-danger">*</span></label>
                                        <input type="text" name="mobile_number" value="@if($data){{$data->mobile_number}}@endif" class="form-control" placeholder="{{__('label.enter_mobile_number')}}">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group ml-5">
                                <label>{{__('label.image')}}<span class="text-danger">*</span></label>
                                <div class="avatar-upload">
                                    <div class="avatar-edit">
                                        <input type='file' name="image" id="imageUpload" accept=".png, .jpg, .jpeg" />
                                        <label for="imageUpload" title="{{__('label.select_file')}}"></label>
                                    </div>
                                    <div class="avatar-preview">
                                        <img src="{{$data->image}}" alt="upload_img.png" id="imagePreview">
                                    </div>
                                </div>
                                <input type="hidden" name="old_image" value="@if($data){{$data->image}}@endif">
                                <label class="mt-3 text-gray">{{__('label.maximum_size_2mb')}}</label>
                            </div>
                        </div>
                    </div>
                    <div class="text-right">
                        <button type="button" class="btn btn-default mw-120" onclick="update_profile()">{{__('label.update')}}</button>
                        <input type="hidden" name="_method" value="PATCH">
                    </div>
                </form>
            </div>
		</div>
	</div>
@endsection

@section('pagescript')
	<script>
		function update_profile(){
            var Check_Admin = '<?php echo Check_Admin_Access(); ?>';
            if(Check_Admin == 1){

                $("#dvloader").show();
                var formData = new FormData($("#profile")[0]);

                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    enctype: 'multipart/form-data',
                    type: 'POST',
                    url: '{{route("pprofile.update", [$data->id])}}',
                    data: formData,
                    cache:false,
                    contentType: false,
                    processData: false,
                    success:function(resp){
                        $("#dvloader").hide();
                        get_responce_message(resp, 'profile', '{{ route("pprofile.index") }}');
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