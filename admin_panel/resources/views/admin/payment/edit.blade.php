@extends('admin.layout.page-app')
@section('page_title', __('label.edit_payment'))

@section('content')
	@include('admin.layout.sidebar')

	<div class="right-content">
		@include('admin.layout.header')

		<div class="body-content">
			<!-- mobile title -->
			<h1 class="page-title-sm">{{__('label.edit_payment')}}</h1>

			<div class="border-bottom row mb-3">
				<div class="col-sm-10">
					<ol class="breadcrumb">
						<li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{__('label.dashboard')}}</a></li>
						<li class="breadcrumb-item"><a href="{{ route('payment.index') }}">{{__('label.payment')}}</a></li>
						<li class="breadcrumb-item active" aria-current="page">{{__('label.edit_payment')}}</li>
					</ol>
				</div>
				<div class="col-sm-2 d-flex align-items-center justify-content-end">
					<a href="{{ route('payment.index') }}" class="btn btn-default mw-120" style="margin-top:-14px">{{__('label.payment_list')}}</a>
				</div>
			</div>

			<div class="card custom-border-card mt-3">
				<div class="card-body">
					<form id="payment_update" enctype="multipart/form-data">
						<input type="hidden" name="id" value="@if($data){{$data->id}}@endif">
						<div class="form-row">
							<div class="col-md-4">
								<div class="form-group">
									<label>{{__('label.name')}}</label>
									<input name="name" type="text" class="form-control" readonly value="@if($data){{$data->name}}@endif">
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label>{{__('label.status')}}</label>
									<select class="form-control" name="visibility">
										<option value="">{{__('label.select_visibility')}}</option>
										<option value="0" {{$data->visibility == 0 ? 'selected' : ''}}>{{__('label.in_active')}}</option>
										<option value="1" {{$data->visibility == 1 ? 'selected' : ''}}>{{__('label.active')}}</option>
									</select>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label>{{__('label.payment_environment')}}</label>
									<select class="form-control" name="is_live">
										<option value="">{{__('label.select_payment_environment')}}</option>
										<option value="0" {{$data->is_live == 0 ? 'selected' : ''}}>{{__('label.sandbox')}}</option>
										<option value="1" {{$data->is_live == 1 ? 'selected' : ''}}>{{__('label.live')}}</option>
									</select>
								</div>
							</div>
						</div>
						<!-- Paypal -->
						@if($data->id == 2)
							<div class="form-row">
								<div class="col-md-4">
									<div class="form-group">
										<label>{{__('label.client_id')}}</label>
										<input name="key_1" type="text" class="form-control" placeholder="{{__('label.enter_id')}}" value="{{$data->key_1}}">
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label>{{__('label.secret_key')}}</label>
										<input name="key_2" type="text" class="form-control" placeholder="{{__('label.enter_key')}}" value="{{$data->key_2}}">
									</div>
								</div>
							</div>
						@endif
						<!-- Razorpay -->
						@if($data->id == 3)
							<div class="form-row">
								<div class="col-md-4">
									<div class="form-group">
										<label>{{__('label.key')}}</label>
										<input name="key_1" type="text" class="form-control" placeholder="{{__('label.enter_key')}}" value="{{$data->key_1}}">
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label>{{__('label.secret_key')}}</label>
										<input name="key_2" type="text" class="form-control" placeholder="{{__('label.enter_key')}}" value="{{$data->key_2}}">
									</div>
								</div>
							</div>
						@endif
						<!-- FlutterWave -->
						@if($data->id == 4)
							<div class="form-row">
								<div class="col-md-4">
									<div class="form-group">
										<label>{{__('label.public_id')}}</label>
										<input name="key_1" type="text" class="form-control" placeholder="{{__('label.enter_id')}}" value="{{$data->key_1}}">
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label>{{__('label.encryption_key')}}</label>
										<input name="key_2" type="text" class="form-control" placeholder="{{__('label.enter_key')}}" value="{{$data->key_2}}">
									</div>
								</div>
							</div>
						@endif
						<!-- PayUMoney -->
						@if($data->id == 5)
							<div class="form-row">
								<div class="col-md-4">
									<div class="form-group">
										<label>{{__('label.merchant_id')}}</label>
										<input name="key_1" type="text" class="form-control" placeholder="{{__('label.enter_id')}}" value="{{$data->key_1}}">
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label>{{__('label.merchant_key')}}</label>
										<input name="key_2" type="text" class="form-control" placeholder="{{__('label.enter_key')}}" value="{{$data->key_2}}">
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label>{{__('label.merchant_salt_key')}}</label>
										<input name="key_3" type="text" class="form-control" placeholder="{{__('label.enter_key')}}" value="{{$data->key_3}}">
									</div>
								</div>
							</div>
						@endif
						<!-- PayTm -->
						@if($data->id == 6)
							<div class="form-row">
								<div class="col-md-4">
									<div class="form-group">
										<label>{{__('label.merchant_id')}}</label>
										<input name="key_1" type="text" class="form-control" placeholder="{{__('label.enter_id')}}" value="{{ $data->key_1}}">
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label>{{__('label.merchant_key')}}</label>
										<input name="key_2" type="text" class="form-control" placeholder="{{__('label.enter_key')}}" value="{{$data->key_2}}">
									</div>
								</div>
							</div>
						@endif
						<!-- Stripe -->
						@if($data->id == 7)
							<div class="form-row">
								<div class="col-md-4">
									<div class="form-group">
										<label>{{__('label.publishable_key')}}</label>
										<input name="key_1" type="text" class="form-control" placeholder="{{__('label.enter_key')}}" value="{{$data->key_1}}">
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label>{{__('label.secret_key')}}</label>
										<input name="key_2" type="text" class="form-control" placeholder="{{__('label.enter_key')}}" value="{{$data->key_2}}">
									</div>
								</div>
							</div>
						@endif
						<!-- Paystack -->
						@if($data->id == 9)
							<div class="form-row">
								<div class="col-md-4">
									<div class="form-group">
										<label>{{__('label.secret_key')}}</label>
										<input name="key_1" type="text" class="form-control" placeholder="{{__('label.enter_id')}}" value="{{$data->key_1}}">
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label>{{__('label.public_key')}}</label>
										<input name="key_2" type="text" class="form-control" placeholder="{{__('label.enter_id')}}" value="{{$data->key_2}}">
									</div>
								</div>
							</div>
						@endif
						<!-- Instamojo -->
						@if($data->id == 10)
							<div class="form-row">
								<div class="col-md-4">
									<div class="form-group">
										<label>{{__('label.api_key')}}</label>
										<input name="key_1" type="text" class="form-control" placeholder="{{__('label.enter_key')}}" value="{{$data->key_1}}">
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label>{{__('label.auth_token')}}</label>
										<input name="key_2" type="text" class="form-control" placeholder="{{__('label.enter_token')}}" value="{{$data->key_2}}">
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label>{{__('label.salt_key')}}</label>
										<input name="key_3" type="text" class="form-control" placeholder="{{__('label.enter_id')}}" value="{{$data->key_3}}">
									</div>
								</div>
							</div>
						@endif
						<!-- PhonePe -->
						@if($data->id == 11)
							<div class="form-row">
								<div class="col-md-3">
									<div class="form-group">
										<label>{{__('label.merchant_id')}}</label>
										<input name="key_1" type="text" class="form-control" placeholder="{{__('label.enter_id')}}" value="{{$data->key_1}}">
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group">
										<label>{{__('label.salt_key')}}</label>
										<input name="key_2" type="text" class="form-control" placeholder="{{__('label.enter_key')}}" value="{{$data->key_2}}">
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group">
										<label>{{__('label.salt_index')}}</label>
										<input name="key_3" type="text" class="form-control" placeholder="{{__('label.enter_index')}}" value="{{$data->key_3}}">
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group">
										<label>{{__('label.callback_url')}}</label>
										<input name="key_4" type="text" class="form-control" placeholder="{{__('label.enter_url')}}" value="{{$data->key_4}}">
									</div>
								</div>
							</div>
						@endif
						<div class="border-top pt-3 text-right">
							<button type="button" class="btn btn-default mw-120" onclick="update_payment()">{{__('label.update')}}</button>
							<a href="{{route('payment.index')}}" class="btn btn-cancel mw-120 ml-2">{{__('label.cancel')}}</a>
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

		// Sidebar Scroll Down
		sidebar_down($(document).height());

		function update_payment() {

			$("#dvloader").show();
			var formData = new FormData($("#payment_update")[0]);

			$.ajax({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
				enctype: 'multipart/form-data',
				type: 'POST',
				url: '{{route("payment.update", [$data->id])}}',
				data: formData,
				cache: false,
				contentType: false,
				processData: false,
				success: function(resp) {
					$("#dvloader").hide();
					get_responce_message(resp, 'payment_update', '{{ route("payment.index") }}');
				},
				error: function(XMLHttpRequest, textStatus, errorThrown) {
					$("#dvloader").hide();
					toastr.error(errorThrown, textStatus);
				}
			});
		}
	</script>
@endsection