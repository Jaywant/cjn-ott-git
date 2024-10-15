@extends('admin.layout.page-app')
@section('page_title', __('label.add_notification'))

@section('content')
	@include('admin.layout.sidebar')

	<div class="right-content">
		@include('admin.layout.header')

		<div class="body-content">
			<!-- mobile title -->
			<h1 class="page-title-sm">{{__('label.add_notification')}}</h1>

			<div class="border-bottom row">
				<div class="col-sm-10">
					<ol class="breadcrumb">
						<li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{__('label.dashboard')}}</a></li>
						<li class="breadcrumb-item"><a href="{{ route('notification.index') }}">{{__('label.notification')}}</a></li>
						<li class="breadcrumb-item active" aria-current="page">{{__('label.add_notification')}}</li>
					</ol>
				</div>
				<div class="col-sm-2 d-flex align-items-center justify-content-end">
					<a href="{{ route('notification.index') }}" class="btn btn-default mw-120" style="margin-top:-14px">{{__('label.notification_list')}}</a>
				</div>
			</div>

			<div class="card custom-border-card mt-3">
				<form id="notification" enctype="multipart/form-data">
					<input type="hidden" name="id" value="">
					<div class="form-row">
						<div class="col-md-8">
							<div class="form-row">
								<div class="col-md-12">
									<div class="form-group">
										<label>{{__('label.title')}}<span class="text-danger">*</span></label>
										<input name="title" type="text" class="form-control" placeholder="{{__('label.enter_title')}}" autofocus>
									</div>
								</div>
							</div>
							<div class="form-row">
								<div class="col-md-12">
									<div class="form-group">
										<label>{{__('label.message')}}<span class="text-danger">*</span></label>
										<textarea class="form-control" rows="5" name="message" placeholder="Hello..."></textarea>
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-3 ml-5">
							<div class="form-group ">
								<label>{{__('label.image')}}<span class="text-danger">*</span></label>
								<div class="avatar-upload ">
									<div class="avatar-edit">
										<input type='file' name="image" id="imageUpload" accept=".png, .jpg, .jpeg" />
										<label for="imageUpload" title="{{__('label.select_file')}}"></label>
									</div>
									<div class="avatar-preview">
										<img src="{{asset('assets/imgs/upload_img.png')}}" alt="upload_img.png" id="imagePreview">
									</div>
								</div>
								<label class="mt-3 text-gray">{{__('label.maximum_size_2mb')}}</label>
							</div>
						</div>
					</div>
					<div class="border-top pt-3 text-right">
						<button type="button" class="btn btn-default mw-120" onclick="save_notification()">{{__('label.save')}}</button>
						<a href="{{route('notification.index')}}" class="btn btn-cancel mw-120 ml-2">{{__('label.cancel')}}</a>
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

		function save_notification() {

			$("#dvloader").show();
			var formData = new FormData($("#notification")[0]);
			$.ajax({
				type: 'POST',
				url: '{{ route("notification.store") }}',
				data: formData,
				cache: false,
				contentType: false,
				processData: false,
				success: function(resp) {
					$("#dvloader").hide();
					get_responce_message(resp, 'notification', '{{ route("notification.index") }}');
				},
				error: function(XMLHttpRequest, textStatus, errorThrown) {
					$("#dvloader").hide();
					toastr.error(errorThrown, textStatus);
				}
			});
		}
	</script>
@endsection