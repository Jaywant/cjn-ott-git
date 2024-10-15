@extends('admin.layout.page-app')
@section('page_title', __('label.edit_user'))

@section('content')
	@include('admin.layout.sidebar')

	<div class="right-content">
		@include('admin.layout.header')

		<div class="body-content">
			<!-- mobile title -->
			<h1 class="page-title-sm">{{__('label.edit_user')}}</h1>

			<div class="border-bottom row mb-3">
				<div class="col-sm-10">
					<ol class="breadcrumb">
						<li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{__('label.dashboard')}}</a></li>
						<li class="breadcrumb-item"><a href="{{ route('user.index') }}">{{__('label.users')}}</a></li>
						<li class="breadcrumb-item active" aria-current="page">{{__('label.edit_user')}}</li>
					</ol>
				</div>
				<div class="col-sm-2 d-flex align-items-center justify-content-end">
					<a href="{{ route('user.index') }}" class="btn btn-default mw-120" style="margin-top:-14px">{{__('label.user_list')}}</a>
				</div>
			</div>

			<div class="card custom-border-card">
				<div class="card-body">
					<form id="user_update" enctype="multipart/form-data">
						<input type="hidden" name="id" value="@if($data){{$data->id}}@endif">
                        <div class="form-row">
                            <div class="col-md-8">
                                <div class="form-row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>{{__('label.full_name')}}<span class="text-danger">*</span></label>
                                            <input type="text" name="full_name" value="@if($data){{$data->full_name}}@endif" class="form-control" placeholder="{{__('label.enter_full_name')}}" autofocus>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>{{__('label.mobile_number')}}<span class="text-danger">*</span></label>
                                            <input type="text" name="mobile_number" value="@if($data){{$data->mobile_number}}@endif" class="form-control" placeholder="{{__('label.enter_mobile_number')}}">
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
                                </div>
                            </div>
                            <div class="col-md-4">
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
						<div class="border-top pt-3 text-right">
							<button type="button" class="btn btn-default mw-120" onclick="update_user()">{{__('label.update')}}</button>
							<a href="{{route('user.index')}}" class="btn btn-cancel mw-120 ml-2">{{__('label.cancel')}}</a>
							<input type="hidden" name="_method" value="PATCH">
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
@endsection

@section('pagescript')
	<script>
		function update_user(){
            var Check_Admin = '<?php echo Check_Admin_Access(); ?>';
            if(Check_Admin == 1){

                $("#dvloader").show();
                var formData = new FormData($("#user_update")[0]);
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    enctype: 'multipart/form-data',
                    type: 'POST',
                    url: '{{route("user.update", [$data->id])}}',
                    data: formData,
                    cache:false,
                    contentType: false,
                    processData: false,
                    success:function(resp){
                        $("#dvloader").hide();
                        get_responce_message(resp, 'user_update', '{{ route("user.index") }}');
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