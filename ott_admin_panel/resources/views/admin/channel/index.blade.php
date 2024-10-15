@extends('admin.layout.page-app')
@section('page_title', __('label.channel'))

@section('content')
    @include('admin.layout.sidebar')

    <div class="right-content">
        @include('admin.layout.header')

        <div class="body-content">
            <!-- mobile title -->
            <h1 class="page-title-sm">{{__('label.channel')}}</h1>

            <div class="border-bottom row mb-3">
                <div class="col-sm-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{__('label.dashboard')}}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{__('label.channel')}}</li>
                    </ol>
                </div>
            </div>

            <!-- Add Channel -->
            <div class="card custom-border-card mt-3">
                <h5 class="card-header">{{__('label.add_channel')}}</h5>
                <div class="card-body">
                    <form id="channel" enctype="multipart/form-data">
                        <input type="hidden" name="id" value="">
                        <div class="form-row">
                            <div class="col-md-6">
                                <div class="form-row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>{{__('label.name')}}<span class="text-danger">*</span></label>
                                            <input type="text" value="" name="name" class="form-control" placeholder="{{__('label.enter_name')}}" autofocus>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>{{__('label.is_title')}}<span class="text-danger">*</span></label>
                                            <div class="radio-group">
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" name="is_title" id="is_title_no" class="custom-control-input" value="0" checked>
                                                    <label class="custom-control-label" for="is_title_no">{{__('label.no')}}</label>
                                                </div>
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" name="is_title" id="is_title_yes" class="custom-control-input" value="1">
                                                    <label class="custom-control-label" for="is_title_yes">{{__('label.yes')}}</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group ml-5">
                                    <label class="ml-5">{{__('label.thumbnail_image')}}<span class="text-danger">*</span></label>
                                    <div class="avatar-upload ml-5">
                                        <div class="avatar-edit">
                                            <input type='file' name="portrait_img" id="imageUpload" accept=".png, .jpg, .jpeg" />
                                            <label for="imageUpload" title="{{__('label.select_file')}}"></label>
                                        </div>
                                        <div class="avatar-preview">
                                            <img src="{{asset('assets/imgs/upload_img.png')}}" alt="upload_img.png" id="imagePreview">
                                        </div>
                                    </div>
                                    <label class="mt-3 ml-5 text-gray">{{__('label.maximum_size_2mb')}}</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group ml-5">
                                    <label>{{__('label.landscape_image')}}<span class="text-danger">*</span></label>
                                    <div class="avatar-upload-landscape">
                                        <div class="avatar-edit-landscape">
                                            <input type='file' name="landscape_img" id="imageUploadLandscape" accept=".png, .jpg, .jpeg" />
                                            <label for="imageUploadLandscape" title="{{__('label.select_file')}}"></label>
                                        </div>
                                        <div class="avatar-preview-landscape">
                                            <img src="{{asset('assets/imgs/upload_img.png')}}" alt="upload_img.png" id="imagePreviewLandscape">
                                        </div>
                                    </div>
                                    <label class="mt-3 text-gray">{{__('label.maximum_size_2mb')}}</label>
                                </div>
                            </div>
                        </div>
                        <div class="border-top pt-3 text-right">
                            <button type="button" class="btn btn-default mw-120" onclick="save_channel()">{{__('label.save')}}</button>
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
                        <input type="text" id="input_search" class="form-control" placeholder="{{__('label.search_channel')}}" aria-label="Search" aria-describedby="basic-addon1">
                    </div>
                </div>

                <div class="table-responsive table">
                    <table class="table table-striped text-center table-bordered" id="datatable">
                        <thead>
                            <tr style="background: #F9FAFF;">
                                <th>{{__('label.#')}}</th>
                                <th>{{__('label.image')}}</th>
                                <th>{{__('label.name')}}</th>
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
                            <h5 class="modal-title" id="exampleModalLabel">{{__('label.edit_channel')}}</h5>
                            <button type="button" class="close text-dark" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form id="edit_channel" autocomplete="off">
                            <div class="modal-body">
                                <div class="form-row">
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <label>{{__('label.name')}}<span class="text-danger">*</span></label>
                                            <input type="text" name="name" id="edit_name" class="form-control" placeholder="{{__('label.enter_name')}}">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>{{__('label.is_title')}}<span class="text-danger">*</span></label>
                                            <div class="radio-group">
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" name="is_title" id="edit_is_title_no" class="custom-control-input" value="0">
                                                    <label class="custom-control-label" for="edit_is_title_no">{{__('label.no')}}</label>
                                                </div>
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" name="is_title" id="edit_is_title_yes" class="custom-control-input" value="1">
                                                    <label class="custom-control-label" for="edit_is_title_yes">{{__('label.yes')}}</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group ml-3">
                                            <label>{{__('label.thumbnail_image')}}<span class="text-danger">*</span></label>
                                            <div class="avatar-upload">
                                                <div class="avatar-edit">
                                                    <input type='file' name="portrait_img" id="imageUploadModel" accept=".png, .jpg, .jpeg" />
                                                    <label for="imageUploadModel" title="{{__('label.select_file')}}"></label>
                                                </div>
                                                <div class="avatar-preview">
                                                    <img src="" alt="upload_img.png" id="imagePreviewModel">
                                                </div>
                                            </div>
                                            <label class="mt-3 text-gray">{{__('label.maximum_size_2mb')}}</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group ml-5">
                                            <label>{{__('label.landscape_image')}}<span class="text-danger">*</span></label>
                                            <div class="avatar-upload-landscape">
                                                <div class="avatar-edit-landscape">
                                                    <input type='file' name="landscape_img" id="imageUploadLandscapeModel" accept=".png, .jpg, .jpeg" />
                                                    <label for="imageUploadLandscapeModel" title="{{__('label.select_file')}}"></label>
                                                </div>
                                                <div class="avatar-preview-landscape">
                                                    <img src="" alt="upload_img.png" id="imagePreviewLandscapeModel">
                                                </div>
                                            </div>
                                            <label class="mt-3 text-gray">{{__('label.maximum_size_2mb')}}</label>
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" name="id" id="edit_id">
                                <input type="hidden" name="old_portrait_img" id="edit_old_portrait_img">
                                <input type="hidden" name="old_landscape_img" id="edit_old_landscape_img">
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default mw-120" onclick="update_channel()">{{__('label.update')}}</button>
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

        // Sidebar Scroll Down
        sidebar_down(400);

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
                    url: "{{ route('channel.index') }}",
                    data: function(d){
                        d.input_search = $('#input_search').val();
                    },
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'portrait_img',
                        name: 'portrait_img',
                        orderable: false,
                        searchable: false,
                        render: function(data, type, full, meta) {
                            return "<a href='" + data + "' target='_blank' title='{{__('label.watch')}}'><img src='" + data + "' class='img-thumbnail' style='height:55px; width:55px'></a>";
                        },
                    },
                    {
                        data: 'name',
                        name: 'name',
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

        function save_channel(){

            var Check_Admin = '<?php echo Check_Admin_Access(); ?>';
            if(Check_Admin == 1){

                $("#dvloader").show();
                var formData = new FormData($("#channel")[0]);
                $.ajax({
                    type:'POST',
                    url:'{{ route("channel.store") }}',
                    data:formData,
                    cache:false,
                    contentType: false,
                    processData: false,
                    success:function(resp){
                        $("#dvloader").hide();
                        get_responce_message(resp, 'channel', '{{ route("channel.index") }}');
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

        $(document).on("click", ".edit_channel", function() {
            var id = $(this).data('id');
            var name = $(this).data('name');
            var portrait_img = $(this).data('portrait_img');
            var landscape_img = $(this).data('landscape_img');
            var is_title = $(this).data('is_title');

            $(".modal-body #edit_id").val(id);
            $(".modal-body #edit_name").val(name);
            $(".modal-body #imagePreviewModel").attr("src", portrait_img);
            $(".modal-body #imagePreviewLandscapeModel").attr("src", landscape_img);
            $(".modal-body #edit_old_portrait_img").val(portrait_img);
            $(".modal-body #edit_old_landscape_img").val(landscape_img);

            if(is_title == 1){
                $('input:radio[id=edit_is_title_yes]').prop('checked', true);
            } else {
                $('input:radio[id=edit_is_title_no]').prop('checked', true);
            }
        });

        function update_channel() {

            var Check_Admin = '<?php echo Check_Admin_Access(); ?>';
            if(Check_Admin == 1){

                $("#dvloader").show();
                var formData = new FormData($("#edit_channel")[0]);

                var Edit_Id = $("#edit_id").val();
                var url = '{{ route("channel.update", ":id") }}';
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
                        get_responce_message(resp, 'edit_channel', '{{ route("channel.index") }}');
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