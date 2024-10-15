@extends('producer.layout.page-app')
@section('page_title', __('label.upcoming_tv_shows'))

@section('content')
    @include('producer.layout.sidebar')

    <div class="right-content">
        @include('producer.layout.header')

        <div class="body-content">
            <!-- mobile title -->
            <h1 class="page-title-sm">{{__('label.upcoming_tv_shows')}}</h1>

            <div class="border-bottom row mb-3">
                <div class="col-sm-10">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('producer.dashboard') }}">{{__('label.dashboard')}}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{__('label.upcoming_tv_shows')}}</li>
                    </ol>
                </div>
                <div class="col-sm-2 d-flex align-items-center justify-content-end">
                    <a href="{{ route('pupcomingtvshow.create') }}" class="btn btn-default mw-150" style="margin-top: -14px;">{{__('label.add_tv_show')}}</a>
                </div>
            </div>

            <!-- Search -->
            <div class="page-search mb-3">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1">
                            <i class="fa-solid fa-magnifying-glass fa-xl light-gray"></i>
                        </span>
                    </div>
                    <input type="text" id="input_search" class="form-control" placeholder="{{__('label.search_tv_show')}}" aria-label="Search" aria-describedby="basic-addon1">
                </div>
                <div class="sorting mr-3" style="width: 450px;">
                    <label>{{__('label.sort_by')}}</label>
                    <select class="form-control" id="input_type">
                        <option value="0">{{__('label.all_type')}}</option>
                        @for ($i = 0; $i < count($type); $i++) 
                            <option value="{{ $type[$i]['id'] }}" @if(isset($_GET['input_type'])){{ $_GET['input_type'] == $type[$i]['id'] ? 'selected' : ''}} @endif>
                                {{ $type[$i]['name'] }}
                            </option>
                        @endfor
                    </select>
                </div>
                <div class="sorting mr-3" style="width: 450px;">
                    <label>{{__('label.sort_by')}}</label>
                    <select class="form-control" name="input_rent" id="input_rent">
                        <option value="0" @if(isset($_GET['input_rent'])){{ $_GET['input_rent'] == 0 ? 'selected' : ''}} @endif>{{__('label.all_tv_show')}}</option>
                        <option value="1" @if(isset($_GET['input_rent'])){{ $_GET['input_rent'] == 1 ? 'selected' : ''}} @endif>{{__('label.rent_tv_show')}}</option>
                    </select>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-striped TVShow-table text-center table-bordered" id="datatable">
                    <thead>
                        <tr style="background: #F9FAFF;">
                            <th>{{__('label.#')}}</th>
                            <th>{{__('label.image')}}</th>
                            <th>{{__('label.name')}}</th>
                            <th>{{__('label.type')}}</th>
                            <th>{{__('label.episodes')}}</th>
                            <th>{{__('label.status')}}</th>
                            <th>{{__('label.releases')}}</th>
                            <th>{{__('label.action')}}</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>

            <!-- Releases Modal -->
            <div class="modal fade" id="ReleasesModal" tabindex="-1" data-backdrop="static" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">{{__('label.releases_tvshows')}}</h5>
                            <button type="button" class="close text-dark" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form id="release_tvshow" autocomplete="off">
                            <input type="hidden" name="id" id="edit_id">
                            <div class="modal-body">
                                <div class="form-row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>{{__('label.type')}}<span class="text-danger">*</span></label>
                                            <select class="form-control" name="type_id" id="type_id">
                                                <option value="">{{__('label.select_type')}}</option>
                                                @foreach ($releases_type as $key => $value)
                                                <option value="{{ $value->id }}" data-type="{{ $value->type }}">
                                                    {{ $value->name }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6 channel_list">
                                        <div class="form-group">
                                            <label>{{__('label.channel')}}<span class="text-danger">*</span></label>
                                            <select class="form-control" name="channel_id" id="channel_id">
                                            <option value="">{{__('label.select_channel')}}</option>
                                                @foreach ($channel_list as $key => $value)
                                                <option value="{{ $value->id }}">
                                                    {{ $value->name }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>                              
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default mw-120" onclick="release_tvshow()">{{__('label.update')}}</button>
                                <button type="button" class="btn btn-cancel mw-120" data-dismiss="modal">{{__('label.close')}}</button>
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
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
                    url: "{{ route('pupcomingtvshow.index') }}",
                    data: function(d) {
                        d.input_search = $('#input_search').val();
                        d.input_type = $('#input_type').val();
                        d.input_rent = $('#input_rent').val();
                    },
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'thumbnail',
                        name: 'thumbnail',
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
                        data: 'type.name',
                        name: 'type.name'
                    },
                    {
                        data: 'episode',
                        name: 'episode',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'status',
                        name: 'status',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'releases',
                        name: 'releases',
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

            $('#input_type, #input_rent').change(function(){
                table.draw();
            });
            $('#input_search').keyup(function() {
                table.draw();
            });
        });

        // ===== Releases Video =====
        $("#datatable").on("click", ".releases_modal", function() {

            var video_id = $(this).attr("data-id");
            $("#release_tvshow #edit_id").val(video_id);
        });
        $(".channel_list").hide();
        $('#type_id').on('change', function () {

            var type_type = $(this).find('option:selected').data("type");
            $(".channel_list").hide();
            if(type_type == 6){
                $(".channel_list").show();
            }
        });
        function release_tvshow() {
            var Check_Admin = '<?php echo Check_Admin_Access(); ?>';
            if(Check_Admin == 1){

                $("#dvloader").show();
                var formData = new FormData($("#release_tvshow")[0]);
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    enctype: 'multipart/form-data',
                    type: 'POST',
                    url: '{{ route("pupcomingtvshow.releases") }}',
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function(resp) {
                        $("#dvloader").hide();

                        if(resp.status == 200){
                            $('#EditModel').modal('toggle');
                        }
                        get_responce_message(resp, 'release_tvshow', '{{ route("pupcomingtvshow.index") }}');
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