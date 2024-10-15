@extends('admin.layout.page-app')
@section('page_title', __('label.comment'))

@section('content')
    @include('admin.layout.sidebar')

    <div class="right-content">
        @include('admin.layout.header')

        <div class="body-content">
            <!-- mobile title -->
            <h1 class="page-title-sm">{{__('label.comment')}}</h1>

            <div class="border-bottom row mb-3">
                <div class="col-sm-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{__('label.dashboard')}}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{__('label.comment')}}</li>
                    </ol>
                </div>
            </div>

            <!-- Search -->
            <div class="page-search mb-3">
                <div class="input-group" title="{{__('label.search')}}">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-magnifying-glass fa-xl light-gray"></i></span>
                    </div>
                    <input type="text" id="input_search" class="form-control" placeholder="Search Comment" aria-label="Search" aria-describedby="basic-addon1">
                </div>
                <div class="sorting mr-2" style="width: 50%;">
                    <label>{{__('label.sort_by')}}</label>
                    <select class="form-control" name="input_user" id="input_user">
                        <option value="0" selected>{{__('label.all_user')}}</option>
                        @for ($i = 0; $i < count($user); $i++) <option value="{{ $user[$i]['id'] }}" @if(isset($_GET['input_user'])){{ $_GET['input_user'] == $user[$i]['id'] ? 'selected' : ''}} @endif>
                            {{ $user[$i]['user_name'] }}
                            </option>
                            @endfor
                    </select>
                </div>
                <div class="sorting mr-2" style="width: 30%;">
                    <label>{{__('label.sort_by')}}</label>
                    <select class="form-control" name="input_video_type" id="input_video_type">
                        <option value="0">{{__('label.all_type')}}</option>
                        <option value="1" @if(isset($_GET['input_video_type'])){{ $_GET['input_video_type'] == 1 ? 'selected' : ''}} @endif>{{__('label.video')}}</option>
                        <option value="2" @if(isset($_GET['input_video_type'])){{ $_GET['input_video_type'] == 2 ? 'selected' : ''}} @endif>{{__('label.tv_show')}}</option>
                        <option value="5" @if(isset($_GET['input_video_type'])){{ $_GET['input_video_type'] == 5 ? 'selected' : ''}} @endif>{{__('label.upcoming')}}</option>
                        <option value="6" @if(isset($_GET['input_video_type'])){{ $_GET['input_video_type'] == 6 ? 'selected' : ''}} @endif>{{__('label.channel')}}</option>
                        <option value="7" @if(isset($_GET['input_video_type'])){{ $_GET['input_video_type'] == 6 ? 'selected' : ''}} @endif>{{__('label.kids')}}</option>
                    </select>
                </div>
            </div>

            <div class="table-responsive table">
                <table class="table table-striped text-center table-bordered" id="datatable">
                    <thead>
                        <tr style="background: #F9FAFF;">
                            <th>{{__('label.#')}}</th>
                            <th>{{__('label.user')}}</th>
                            <th>{{__('label.content_type')}}</th>
                            <th>{{__('label.content')}}</th>
                            <th>{{__('label.comment')}}</th>
                            <th>{{__('label.date')}}</th>
                            <th>{{__('label.action')}}</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('pagescript')
    <script>

        // Sidebar Scroll Down
        sidebar_down($(document).height());

        $("#input_user").select2();

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
                    url: "{{ route('comment.index') }}",
                    data: function(d) {
                        d.input_search = $('#input_search').val();
                        d.input_user = $('#input_user').val();
                        d.input_video_type = $('#input_video_type').val();
                    },
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'user.user_name',
                        name: 'user.user_name',
                        orderable: false,
                        render: function(data, type, full, meta) {
                            if (data) {
                                return data;
                            } else {
                                return "-";
                            }
                        },
                    },
                    {
                        data: 'video_type',
                        name: 'video_type',
                        orderable: false,
                        render: function(data, type, full, meta) {
                            if (data == 1) {
                                return "{{__('label.video')}}";
                            } else if (data == 2) {
                                return "{{__('label.tv_show')}}";
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
                        data: 'video_name',
                        name: 'video_name',
                        orderable: false,
                        render: function(data, type, full, meta) {
                            if (data) {
                                return data;
                            } else {
                                return "-";
                            }
                        },
                    },
                    {
                        data: 'comment',
                        name: 'comment',
                        orderable: false,
                        render: function(data, type, full, meta) {
                            if (data) {
                                return data;
                            } else {
                                return "-";
                            }
                        }
                    },
                    {
                        data: 'date',
                        name: 'date'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ],
            });

            $('#input_user, #input_video_type').change(function() {
                table.draw();
            });
            $('#input_search').keyup(function() {
                table.draw();
            });
        });

        function change_status(id, status) {

            var Check_Admin = '<?php echo Check_Admin_Access(); ?>';
            if(Check_Admin == 1){

                $("#dvloader").show();
                var url = "{{route('comment.show', '')}}" + "/" + id;
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

                                $('#' + id).text("{{__('label.show')}}");
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

                                $('#' + id).text("{{__('label.hide')}}");
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
    </script>
@endsection