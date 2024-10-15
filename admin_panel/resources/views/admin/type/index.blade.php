@extends('admin.layout.page-app')
@section('page_title', __('label.types'))

@section('content')
    @include('admin.layout.sidebar')

    <div class="right-content">
        @include('admin.layout.header')

        <div class="body-content">
            <!-- mobile title -->
            <h1 class="page-title-sm">{{__('label.types')}}</h1>

            <div class="border-bottom row mb-3">
                <div class="col-sm-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{__('label.dashboard')}}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{__('label.types')}}</li>
                    </ol>
                </div>
            </div>

            <!-- Add Type -->
            <div class="card custom-border-card mt-3">
                <h5 class="card-header">{{__('label.add_type')}}</h5>
                <div class="card-body">
                    <form id="type" enctype="multipart/form-data">
                        <input type="hidden" name="id" value="">
                        <div class="form-row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>{{__('label.name')}}<span class="text-danger">*</span></label>
                                    <input type="text" name="name" class="form-control" placeholder="{{__('label.enter_name')}}" autofocus>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>{{__('label.type')}}<span class="text-danger">*</span></label>
                                    <select name="type" class="form-control">
                                        <option value="">{{__('label.select_type')}}</option>
                                        <option value="1">{{__('label.video')}}</option>
                                        <option value="2">{{__('label.show')}}</option>
                                        <option value="5">{{__('label.upcoming')}}</option>
                                        <option value="6">{{__('label.channel')}}</option>
                                        <option value="7">{{__('label.kids')}}</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="border-top pt-3 text-right">
                            <button type="button" class="btn btn-default mw-120" onclick="save_type()">{{__('label.save')}}</button>
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
                        <input type="text" id="input_search" class="form-control" placeholder="{{__('label.search_type')}}" aria-label="Search" aria-describedby="basic-addon1">
                    </div>
                    <div class="sorting">
                        <label>{{__('label.sort_by')}}</label>
                        <select class="form-control" name="input_type" id="input_type">
                            <option value="0" selected>{{__('label.all_type')}}</option>
                            <option value="1">{{__('label.video')}}</option>
                            <option value="2">{{__('label.show')}}</option>
                            <option value="5">{{__('label.upcoming')}}</option>
                            <option value="6">{{__('label.channel')}}</option>
                            <option value="7">{{__('label.kids')}}</option>
                        </select>
                    </div>
                </div>

                <div class="table-responsive table">
                    <table class="table table-striped text-center table-bordered" id="datatable">
                        <thead>
                            <tr style="background: #F9FAFF;">
                                <th>{{__('label.#')}}</th>
                                <th>{{__('label.name')}}</th>
                                <th>{{__('label.type')}}</th>
                                <th>{{__('label.status')}}</th>
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
                            <h5 class="modal-title" id="exampleModalLabel">{{__('label.edit_type')}}</h5>
                            <button type="button" class="close text-dark" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form id="update_type" enctype="multipart/form-data">
                            <div class="modal-body">
                                <input type="hidden" name="id" id="edit_id">
                                <div class="form-row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>{{__('label.name')}}<span class="text-danger">*</span></label>
                                            <input type="text" name="name" id="edit_name" class="form-control" placeholder="{{__('label.enter_name')}}">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>{{__('label.type')}}<span class="text-danger">*</span></label>
                                            <select class="form-control" name="type" id="edit_type">
                                                <option value="">{{__('label.select_type')}}</option>
                                                <option value="1">{{__('label.video')}}</option>
                                                <option value="2">{{__('label.show')}}</option>
                                                <option value="5">{{__('label.upcoming')}}</option>
                                                <option value="6">{{__('label.channel')}}</option>
                                                <option value="7">{{__('label.kids')}}</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default mw-120" onclick="update_type()">{{__('label.update')}}</button>
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
                ajax: {
                    url: "{{ route('type.index') }}",
                    data: function(d) {
                        d.input_type = $('#input_type').val();
                        d.input_search = $('#input_search').val();
                    },
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
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
                        data: 'type',
                        name: 'type',
                        render: function(data, type, full, meta) {
                            if (data == 1) {
                                return "{{__('label.video')}}";
                            } else if (data == 2) {
                                return "{{__('label.show')}}";
                            } else if (data == 5) {
                                return "{{__('label.upcoming')}}";
                            } else if (data == 6) {
                                return "{{__('label.channel')}}";
                            } else if (data == 7) {
                                return "{{__('label.kids')}}";
                            } else {
                                return "-";
                            }
                        }
                    },
                    {
                        data: 'status',
                        name: 'status',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ],
            });

            $('#input_type').change(function() {
                table.draw();
            });
            $('#input_search').keyup(function() {
                table.draw();
            });
        });

        function save_type() {
            var Check_Admin = '<?php echo Check_Admin_Access(); ?>';
            if (Check_Admin == 1) {

                $("#dvloader").show();
                var formData = new FormData($("#type")[0]);
                $.ajax({
                    type: 'POST',
                    url: '{{ route("type.store") }}',
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function(resp) {
                        $("#dvloader").hide();
                        get_responce_message(resp, 'type', '{{ route("type.index") }}');
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

        function change_status(id, status) {

            var Check_Admin = '<?php echo Check_Admin_Access(); ?>';
            if (Check_Admin == 1) {

                $("#dvloader").show();
                var url = "{{route('type.show', '')}}" + "/" + id;
                $.ajax({
                    type: "GET",
                    url: url,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: id,
                    success: function(resp) {
                        $("#dvloader").hide();
                        if (resp.status == 200) {
                            if (resp.Status_Code == 1) {

                                $('#' + id).text('{{__("label.show")}}');
                                $('#' + id).css({
                                    "background": "#058f00",
                                    "font-weight": "bold",
                                    "color": "white",
                                    "border": "none",
                                    "outline": "none",
                                    "padding": "5px 15px",
                                    "border-radius": "5px",
                                    "cursor": "pointer",
                                });
                            } else {

                                $('#' + id).text('{{__("label.hide")}}');
                                $('#' + id).css({
                                    "background": "#e3000b",
                                    "color": "white",
                                    "border": "none",
                                    "outline": "none",
                                    "padding": "5px 20px",
                                    "border-radius": "5px",
                                    "cursor": "pointer",
                                });
                            }
                        } else {
                            toastr.error(resp.errors);
                        }
                    },
                    error: function(XMLHttpRequest, textStatus, errorThrown) {
                        $("#dvloader").hide();
                        toastr.error(errorThrown, textStatus);
                    }
                });
            } else {
                toastr.error('{{__("label.you_have_no_right_to_add_edit_and_delete")}}');
            }
        };

        $(document).on("click", ".edit_type", function() {
            var id = $(this).data('id');
            var name = $(this).data('name');
            var type = $(this).data('type');

            $(".modal-body #edit_id").val(id);
            $(".modal-body #edit_name").val(name);
            $(".modal-body #edit_type").val(type).attr("selected", "selected");
        });

        function update_type() {

            var Check_Admin = '<?php echo Check_Admin_Access(); ?>';
            if (Check_Admin == 1) {

                $("#dvloader").show();
                var formData = new FormData($("#update_type")[0]);
                var Edit_Id = $("#edit_id").val();

                var url = '{{ route("type.update", ":id") }}';
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

                        if (resp.status == 200) {
                            $('#EditModel').modal('toggle');
                        }

                        get_responce_message(resp, 'update_type', '{{ route("type.index") }}');
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