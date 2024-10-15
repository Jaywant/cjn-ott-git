@extends('admin.layout.page-app')

@section('content')
    <div class="h-100">
        <div class="h-100 no-gutters row">
            <div class="d-none d-lg-block h-100 col-lg-5 col-xl-4">
                <div class="left-caption">
                    <img src="{{ Login_Image() }}" class="bg-img"/>
                    <div class="caption">
                        <div>
                            <!-- logo -->
                            <h1 style="font-size: 60px; font-weight: bold;">{{App_Name()}}</h1>

                            <?php $setting = Setting_Data();?>
                            <p class="text">
                                {{String_Cut($setting['app_desripation'], 200)}}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="h-100 d-flex login-bg justify-content-center align-items-lg-center col-md-12 col-lg-7 col-xl-8">
                <div class="mx-auto col-sm-12 col-md-10 col-xl-8">
                    <div class="py-5">

                        <div class="app-logo mb-4">
                            <h1 class="primary-color mb-4 d-block d-lg-none">{{ App_Name() }}</h1>
                            <h3 class="primary-color mb-0 font-weight-bold">{{__('label.login')}}</h3>
                        </div>

                        <h4 class="mb-0 font-weight-bold">
                            <span class="d-block mb-2">{{__('label.welcome_back_admin')}}</span>
                            <span>{{__('label.please_sign_in_to_your_account')}}</span>
                        </h4>

                        @php
                            $emailValue = env('DEMO_MODE') == 'ON' ? 'admin@admin.com' : '';
                            $passwordValue = env('DEMO_MODE') == 'ON' ? 'admin' : '';
                        @endphp
                        <form id="login_form">
                            <div class="form-row mt-4">
                                <div class="col-md-6">
                                    <div class="position-relative form-group">
                                        <label>{{__('label.email')}}</label>
                                        <input name="email" type="email" value="{{ $emailValue }}" placeholder="{{__('label.email_here')}}" class="form-control" autofocus>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="position-relative form-group">
                                        <label>{{__('label.password')}}</label>
                                        <input name="password" type="password" value="{{ $passwordValue }}" placeholder="{{__('label.password_here')}}" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-sm-6 text-center text-sm-left">
                                    <button class="btn btn-default mw-120" onclick="save_login()" type="button">{{__('label.login')}}</button>
                                </div>
                            </div>
                        </form>

                        @if( env('DEMO_MODE') == 'ON') 
                            <hr>
                            <h6>
                                {{__('label.if_you_cannot_login_then')}}<a href="{{ env('APP_URL'). '/public/admin/login' }}" target="_blank" class="btn-link">{{__('label.click_here')}}</a>
                            </h6>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('pagescript')
    <script>
        function save_login() {
            $("#dvloader").show();
            var formData = new FormData($("#login_form")[0]);
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'POST',
                url: '{{ route("admin.save.login") }}',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function(resp) {
                    $("#dvloader").hide();
                    get_responce_message(resp, 'login_form', '{{ route("admin.dashboard") }}');
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    $("#dvloader").hide();
                    toastr.error(errorThrown, textStatus);
                }
            });
        }

        // Press Enter Key & Save Form
        $('#login_form').keypress((e) => { 
            // Enter key corresponds to number 13 
            if (e.which === 13) { 
                save_login();
            } 
        })
    </script>
@endsection