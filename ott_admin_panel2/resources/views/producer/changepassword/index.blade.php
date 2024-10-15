@extends('producer.layout.page-app')
@section('page_title', __('label.change_password'))

@section('content')
	@include('producer.layout.sidebar')

	<div class="right-content">
		@include('producer.layout.header')

		<div class="body-content">
			<!-- mobile title -->
			<h1 class="page-title-sm">{{__('label.change_password')}}</h1>

			<div class="border-bottom row mb-3">
				<div class="col-sm-12">
					<ol class="breadcrumb">
						<li class="breadcrumb-item"><a href="{{ route('producer.dashboard') }}">{{__('label.dashboard')}}</a></li>
						<li class="breadcrumb-item active" aria-current="page">{{__('label.change_password')}}</li>
					</ol>
				</div>
			</div>

			<div class="card custom-border-card">
				<form id="change_password" enctype="multipart/form-data">
					<input type="hidden" name="id" value="{{$producer_id}}">
						<div class="form-row">
							<div class="col-md-4">
								<div class="form-group">
									<label>{{__('label.current_password')}}<span class="text-danger">*</span></label>
									<input type="password" name="current_password" class="form-control" placeholder="{{__('label.enter_current_password')}}" autofocus>
								</div>
							</div>
						</div>
						<div class="form-row">
							<div class="col-md-4">
								<div class="form-group">
									<label>{{__('label.new_password')}}<span class="text-danger">*</span></label>
									<input type="password" name="new_password" class="form-control" placeholder="{{__('label.enter_new_password')}}">
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label>{{__('label.confirm_password')}}<span class="text-danger">*</span></label>
									<input type="password" name="confirm_password" class="form-control" placeholder="{{__('label.enter_confirm_password')}}">
								</div>
							</div>
						</div>
					<div class="border-top pt-3 text-right">
						<button type="button" class="btn btn-default mw-120" onclick="update_password()">{{__('label.update')}}</button>
						<input type="hidden" name="_method" value="PATCH">
					</div>
				</form>
			</div>
		</div>
	</div>
@endsection

@section('pagescript')
	<script>
		function update_password(){
			var Check_Admin = '<?php echo Check_Admin_Access(); ?>';
            if(Check_Admin == 1){

				$("#dvloader").show();
				var formData = new FormData($("#change_password")[0]);

				$.ajax({
					headers: {
						'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					},
					enctype: 'multipart/form-data',
					type: 'POST',
					url: '{{route("pchangepassword.update", [$producer_id])}}',
					data: formData,
					cache:false,
					contentType: false,
					processData: false,
					success:function(resp){
						$("#dvloader").hide();
						get_responce_message(resp, 'change_password', '{{ route("pchangepassword.index") }}');
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