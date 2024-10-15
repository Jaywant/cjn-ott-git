@extends('admin.layout.page-app')
@section('page_title', __('label.producer'))

@section('content')
    @include('admin.layout.sidebar')

    <div class="right-content">
        @include('admin.layout.header')

        <div class="body-content">
            <!-- mobile title -->
            <h1 class="page-title-sm">{{__('label.producer')}}</h1>

            <div class="border-bottom row mb-3">
                <div class="col-sm-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{__('label.dashboard')}}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{__('label.producer')}}</li>
                    </ol>
                </div>
            </div>

            <!-- Add Producer -->
            <div class="card custom-border-card mt-3">
                <h5 class="card-header">{{__('label.add_producer')}}</h5>
                <div class="card-body">
                    <form id="producer" enctype="multipart/form-data">
                        <input type="hidden" name="id" value="">
                        <div class="form-row">
                            <div class="col-md-9">
                                <div class="form-row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>{{__('label.user_name')}}<span class="text-danger">*</span></label>
                                            <input type="text" name="user_name" class="form-control" placeholder="{{__('label.enter_user_name')}}" autofocus>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>{{__('label.full_name')}}<span class="text-danger">*</span></label>
                                            <input type="text" name="full_name" class="form-control" placeholder="{{__('label.enter_full_name')}}">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>{{__('label.mobile_number')}}<span class="text-danger">*</span></label>
                                            <input type="text" name="mobile_number" class="form-control" placeholder="{{__('label.enter_mobile_number')}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>{{__('label.email')}}<span class="text-danger">*</span></label>
                                            <input type="email" name="email" class="form-control" placeholder="{{__('label.enter_email')}}">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>{{__('label.password')}}<span class="text-danger">*</span></label>
                                            <input type="password" name="password" class="form-control" placeholder="{{__('label.enter_password')}}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group ml-5">
                                    <label class="ml-5">{{__('label.image')}}<span class="text-danger">*</span></label>
                                    <div class="avatar-upload ml-5">
                                        <div class="avatar-edit">
                                            <input type='file' name="image" id="imageUpload" accept=".png, .jpg, .jpeg" />
                                            <label for="imageUpload" title="{{__('label.select_file')}}"></label>
                                        </div>
                                        <div class="avatar-preview">
                                            <img src="{{asset('assets/imgs/upload_img.png')}}" alt="upload_img.png" id="imagePreview">
                                        </div>
                                    </div>
                                    <label class="mt-3 ml-5 text-gray">{{__('label.maximum_size_2mb')}}</label>
                                </div>
                            </div>
                        </div>
                        <div class="border-top pt-3 text-right">
                            <button type="button" class="btn btn-default mw-120" onclick="save_producer()">{{__('label.save')}}</button>
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        </div>
                    </form>
                </div>
            </div>

            <!-- Search && Table -->
            <div class="card custom-border-card mt-3">
                <div class="page-search mb-3">
                    <div class="input-group" title="{{__('label.search')}}">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-magnifying-glass fa-xl light-gray"></i></span>
                        </div>
                        <input type="text" id="input_search" class="form-control" placeholder="{{__('label.search_producer')}}" aria-label="Search" aria-describedby="basic-addon1">
                    </div>
                </div>

                <div class="table-responsive table">
                    <table class="table table-striped text-center table-bordered" id="datatable">
                        <thead>
                            <tr style="background: #F9FAFF;">
                                <th>{{__('label.#')}}</th>
                                <th>{{__('label.image')}}</th>
                                <th>{{__('label.user_name')}}</th>
                                <th>{{__('label.full_name')}}</th>
                                <th>{{__('label.email')}}</th>
                                <th>{{__('label.mobile')}}</th>
                                <th>{{__('label.action')}}</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>

            <!-- Edit Model -->
            <div class="modal fade" id="EditModel" tabindex="-1" data-backdrop="static" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">{{__('label.edit_producer')}}</h5>
                            <button type="button" class="close text-dark" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form id="edit_producer" enctype="multipart/form-data">
                            <div class="modal-body">
                                <div class="form-row">
                                    <div class="col-md-8">
                                        <div class="form-row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>{{__('label.user_name')}}<span class="text-danger">*</span></label>
                                                    <input type="text" name="user_name" id="edit_user_name" class="form-control" placeholder="{{__('label.enter_user_name')}}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>{{__('label.full_name')}}<span class="text-danger">*</span></label>
                                                    <input type="text" name="full_name" id="edit_full_name" class="form-control" placeholder="{{__('label.enter_full_name')}}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>{{__('label.mobile_number')}}<span class="text-danger">*</span></label>
                                                    <input type="text" name="mobile_number" id="edit_mobile_number" class="form-control" placeholder="{{__('label.enter_mobile_number')}}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>{{__('label.email')}}<span class="text-danger">*</span></label>
                                                    <input type="text" name="email" id="edit_email" class="form-control" placeholder="{{__('label.enter_email')}}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>{{__('label.password')}}<span class="text-danger">*</span></label>
                                                    <input type="password" name="password" class="form-control" placeholder="{{__('label.enter_password')}}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group ml-3">
                                            <label>{{__('label.image')}}<span class="text-danger">*</span></label>
                                            <div class="avatar-upload">
                                                <div class="avatar-edit">
                                                    <input type='file' name="image" id="imageUploadModel" accept=".png, .jpg, .jpeg" />
                                                    <label for="imageUploadModel" title="{{__('label.select_file')}}"></label>
                                                </div>
                                                <div class="avatar-preview">
                                                    <img src="" alt="upload_img.png" id="imagePreviewModel">
                                                </div>
                                            </div>
                                            <label class="mt-3 text-gray">{{__('label.maximum_size_2mb')}}</label>
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" name="id" id="edit_id">
                                <input type="hidden" name="old_image" id="edit_old_image">
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default mw-120" onclick="update_producer()">{{__('label.update')}}</button>
                                <button type="button" class="btn btn-cancel mw-120" data-dismiss="modal">{{__('label.close')}}</button>
                                <input type="hidden" name="_method" value="PATCH">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('pagescript')
    <script>
        $(document).ready(function() {
            var table = $('#datatable').DataTable({
                dom: "<'top'f>rt<'row'<'col-2'i><'col-1'l><'col-9'p>>",
                searching: false,
                responsive: true,
                autoWidth: false,
                processing: true,
                serverSide: true,
                lengthMenu: [
                    [10, 100, 500, -1],
                    [10, 100, 500, "All"]
                ],
                language: {
                    paginate: {
                        previous: "<i class='fa-solid fa-chevron-left'></i>",
                        next: "<i class='fa-solid fa-chevron-right'></i>"
                    }
                },
                ajax:
                    {
                    url: "{{ route('producer.index') }}",
                    data: function(d){
                        d.input_search = $('#input_search').val();
                    },
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'image',
                        name: 'image',
                        orderable: false,
                        searchable: false,
                        render: function(data, type, full, meta) {
                            return "<a href='" + data + "' target='_blank' title='{{__('label.watch')}}'><img src='" + data + "' class='rounded-circle' style='height:55px; width:55px'></a>";
                        },
                    },
                    {
                        data: 'user_name',
                        name: 'user_name',
                        render: function(data, type, full, meta) {
                            if (data) {
                                return data;
                            } else {
                                return "-";
                            }
                        }
                    },
                    {
                        data: 'full_name',
                        name: 'full_name',
                        render: function(data, type, full, meta) {
                            if (data) {
                                return data;
                            } else {
                                return "-";
                            }
                        }
                    },
                    {
                        data: 'email',
                        name: 'email',
                        render: function(data, type, full, meta) {
                            if (data) {
                                return data;
                            } else {
                                return "-";
                            }
                        }
                    },
                    {
                        data: 'mobile_number',
                        name: 'mobile_number',
                        render: function(data, type, full, meta) {
                            if (data) {
                                return data;
                            } else {
                                return "-";
                            }
                        }
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ],
            });

            $('#input_search').keyup(function() {
                table.draw();
            });
        });

        function save_producer(){
            var Check_Admin = '<?php echo Check_Admin_Access(); ?>';
            if(Check_Admin == 1){

                $("#dvloader").show();
                var formData = new FormData($("#producer")[0]);
                $.ajax({
                    type:'POST',
                    url:'{{ route("producer.store") }}',
                    data:formData,
                    cache:false,
                    contentType: false,
                    processData: false,
                    success:function(resp){
                        $("#dvloader").hide();
                        get_responce_message(resp, 'producer', '{{ route("producer.index") }}');
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

        $(document).on("click", ".edit_producer", function() {
            var id = $(this).data('id');
            var user_name = $(this).data('user_name');
            var full_name = $(this).data('full_name');
            var email = $(this).data('email');
            var mobile_number = $(this).data('mobile_number');
            var image = $(this).data('image');

            $(".modal-body #edit_id").val(id);
            $(".modal-body #edit_user_name").val(user_name);
            $(".modal-body #edit_full_name").val(full_name);
            $(".modal-body #edit_email").val(email);
            $(".modal-body #edit_mobile_number").val(mobile_number);
            $(".modal-body #imagePreviewModel").attr("src", image);
            $(".modal-body #edit_old_image").val(image);
        });

        function update_producer() {

            var Check_Admin = '<?php echo Check_Admin_Access(); ?>';
            if(Check_Admin == 1){

                $("#dvloader").show();
                var formData = new FormData($("#edit_producer")[0]);
                
                var Edit_Id = $("#edit_id").val();
                var url = '{{ route("producer.update", ":id") }}';
                    url = url.replace(':id', Edit_Id);

                $.ajax({
                    headers: {
					    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				    },
				    enctype: 'multipart/form-data',
                    type: 'POST',
                    url: url,
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function(resp) {
                        $("#dvloader").hide();

                        if(resp.status == 200){
                            $('#EditModel').modal('toggle');
                        }
                        get_responce_message(resp, 'edit_producer', '{{ route("producer.index") }}');
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